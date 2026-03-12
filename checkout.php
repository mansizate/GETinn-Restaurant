<?php
session_start();
require_once "includes/connection.php";

require_once __DIR__ . '/payment/config.php'; // returns ['api_key'=>'..','api_secret'=>'..']
$config = require __DIR__ . '/payment/config.php';

// load sdk (use vendor/autoload if composer installed)
if (file_exists(__DIR__ . '/payment/vendor/autoload.php')) {
    require __DIR__ . '/payment/vendor/autoload.php';
}

use Razorpay\Api\Api;

if (mysqli_connect_error()) {
    echo "<script>
        alert('UNKNOWN ISSUE: cannot process your request.');
        window.location.href='menu.php';
    </script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['checkout'])) {
        // Check if user is logged in
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
            // Retrieve user information from registered_users table
            $query = "SELECT * FROM registered_users WHERE email='{$_SESSION['username']}'";
            $result = mysqli_query($conn, $query);





            if ($result && mysqli_num_rows($result) > 0) {
                $user_data = mysqli_fetch_assoc($result);

                // Use user data in the INSERT query for orders table
                $name = $user_data['name'];
                $email = $user_data['email'];
                $state = $user_data['state'];
                $district = $user_data['district'];
                $address = $state . ' ' . $district;





                // helper: convert rupees->paise safely (string input)
                function rupees_to_paise(string $input): int
                {
                    $s = preg_replace('/[^\d.]/', '', $input);
                    if ($s === '' || !preg_match('/^\d+(\.\d{0,})?$/', $s)) {
                        throw new InvalidArgumentException('Invalid amount format');
                    }
                    $parts = explode('.', $s);
                    $rupees = $parts[0];
                    $paisePart = $parts[1] ?? '0';
                    $paisePart = str_pad(substr($paisePart, 0, 2), 2, '0', STR_PAD_RIGHT);
                    return ((int)$rupees) * 100 + (int)$paisePart;
                }

                try {
                    // Validate posted arrays
                    if (!isset($_POST['Item_name'], $_POST['price'], $_POST['Quantity'])) {
                        throw new RuntimeException('Invalid request: missing item data.');
                    }

                    $items = $_POST['Item_name'];
                    $prices = $_POST['price'];      // expected as string/number per item (rupees)
                    $quantities = $_POST['Quantity'];

                    if (
                        !is_array($items) || !is_array($prices) || !is_array($quantities) ||
                        count($items) !== count($prices) || count($items) !== count($quantities)
                    ) {
                        throw new RuntimeException('Mismatched cart data.');
                    }

                    // Compute total in paise (server-side authoritative)
                    $totalPaise = 0;
                    for ($i = 0; $i < count($items); $i++) {
                        $p = trim((string)$prices[$i]);
                        $q = (int)$quantities[$i];
                        if ($q <= 0) $q = 1;
                        $unitPaise = rupees_to_paise($p);
                        $totalPaise += $unitPaise * $q;
                    }

                    if ($totalPaise <= 0) {
                        throw new RuntimeException('Total amount invalid.');
                    }

                    // Insert rows into orders table in 'pending' state and collect inserted IDs (optional)
                    // Use prepared statements for security
                    // ----------------- Insert order items (without order_id) -----------------
                    $insertSql = "INSERT INTO `orders` (`name`, `email`, `address`, `item`, `quantity`, `total_price`, `order_id`) VALUES (?, ?, ?, ?, ?, ?, ?)";
                    $insertStmt = mysqli_prepare($conn, $insertSql);
                    if (!$insertStmt) {
                        throw new RuntimeException('DB prepare failed: ' . mysqli_error($conn));
                    }

                    // Unique receipt token for this whole cart / order
                    $receipt_token = 'rcpt_' . time() . '_' . bin2hex(random_bytes(6));
                    $status_pending = 'pending';
                    $tr_id = null; // order_id is null for now

                    for ($i = 0; $i < count($items); $i++) {
                        $item = (string)$items[$i];
                        $price = trim((string)$prices[$i]);
                        $quantity = max(1, (int)$quantities[$i]);

                        $unitPaise = rupees_to_paise($price);
                        $total_price_for_row = ($unitPaise * $quantity) / 100; // rupees as decimal (e.g., 99.00)

                        // bind: name, email, address, item, quantity (int), total_price (string), status, receipt_token
                        mysqli_stmt_bind_param($insertStmt, 'ssssiss', $name, $email, $address, $item, $quantity, $total_price_for_row, $receipt_token);

                        if (!mysqli_stmt_execute($insertStmt)) {
                            throw new RuntimeException('Failed to insert order row: ' . mysqli_stmt_error($insertStmt));
                        }
                    }
                    mysqli_stmt_close($insertStmt);

                    // ----------------- Create Razorpay order -----------------
                    $api_secret = "YOUR_RAZOR_PAY_API_SECRET";
                    $api_key = "YOUR_RAZOR_PAY_API_KEY";
                    $api = new Api($api_key, $api_secret);

                    $orderData = [
                        'amount' => $totalPaise,    // in paise
                        'currency' => 'INR',
                        'receipt' => $receipt_token,
                        'payment_capture' => 1
                    ];

                    $razorpayOrder = $api->order->create($orderData);
                    $razorpayOrderId = (string)$razorpayOrder->id;

                    // 2) Generate a transaction grouping id (tr_id)
                    // use a cryptographically-strong random id
                    $tr_id = 'tr_' . bin2hex(random_bytes(8)); // e.g. tr_4f3a2b...

                    // 3) Insert each item ONCE with order_id and tr_id
                    // Add tr_id column to your table if not present: ALTER TABLE orders ADD tr_id VARCHAR(100) NULL;
                    $insertSql = "INSERT INTO `orders` (`order_id`, `name`, `email`, `address`, `item`, `quantity`, `total_price`, `tr_id`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                    $insertStmt = mysqli_prepare($conn, $insertSql);
                    if (!$insertStmt) {
                        throw new RuntimeException('DB prepare failed: ' . mysqli_error($conn));
                    }

                    for ($i = 0; $i < count($items); $i++) {
                        $itemName = (string)$items[$i];
                        $price = trim((string)$prices[$i]);
                        $quantity = (string)max(1, (int)$quantities[$i]); // store as string because your schema uses varchar
                        // compute total price per row in rupees (string)
                        $unitPaise = rupees_to_paise($price);
                        $total_price_for_row = number_format(($unitPaise * (int)$quantity) / 100, 2, '.', ''); // "99.00"

                        // all fields are varchar in your schema, so bind as strings
                        mysqli_stmt_bind_param(
                            $insertStmt,
                            'ssssssss',
                            $razorpayOrderId,
                            $name,
                            $email,
                            $address,
                            $itemName,
                            $quantity,
                            $total_price_for_row,
                            $tr_id
                        );

                        if (!mysqli_stmt_execute($insertStmt)) {
                            throw new RuntimeException('Failed to insert order row: ' . mysqli_stmt_error($insertStmt));
                        }
                    }
                    mysqli_stmt_close($insertStmt);

                    // 4) Render Checkout (open Razorpay Checkout with the created order)
                    $publicKey = htmlspecialchars($api_key, ENT_QUOTES);
                    $amountJs = (int)$totalPaise;
                    $currency = 'INR';
                    $orderIdJs = htmlspecialchars($razorpayOrderId, ENT_QUOTES);

                    echo '<!doctype html><html><head><meta charset="utf-8"><title>Checkout</title></head><body>';
                    echo '<script src="https://checkout.razorpay.com/v1/checkout.js"></script>';
                    echo "<script>
        (function(){
            var options = {
                key: '$publicKey',
                amount: $amountJs,
                currency: '$currency',
                name: " . json_encode($name) . ",
                description: 'Order Payment',
                order_id: '$orderIdJs',
                handler: function(response) {
                    var form = new FormData();
                    form.append('razorpay_order_id', response.razorpay_order_id);
                    form.append('razorpay_payment_id', response.razorpay_payment_id);
                    form.append('razorpay_signature', response.razorpay_signature);
                    form.append('tr_id', " . json_encode($tr_id) . ");

                    // verify endpoint (adjust path as needed)
                    fetch('/Project-Taaza/payment/verify.php', { method: 'POST', body: form })
                    .then(async res => {
                        const ct = res.headers.get('content-type') || '';
                        if (ct.includes('application/json')) return res.json();
                        const text = await res.text();
                        throw new Error('Server did not return JSON. ' + text.substring(0,500));
                    })
                    .then(j => {
                        if (j.status === 'success') {
                            window.location.href = 'dashboard.php?payment=success&pid=' + encodeURIComponent(j.payment_id);
                        } else {
                            alert('Payment verification failed: ' + (j.message || 'unknown'));
                            window.location.href = 'dashboard.php';
                        }
                    })
                    .catch(err => { alert('Server verification error: ' + err.message); window.location.href = 'dashboard.php'; });
                },
                modal: { ondismiss: function() { window.location.href = 'menu.php'; } }
            };
            var rzp = new Razorpay(options);
            rzp.open();
        })();
    </script>";
                    echo '</body></html>';
                    exit;
                } catch (Exception $e) {
                    error_log('Checkout error: ' . $e->getMessage());
                    echo "<script>alert('Error initiating payment: " . addslashes($e->getMessage()) . "'); window.location.href='menu.php';</script>";
                    exit;
                }
                // ---------- END CLEAN FLOW ----------
                catch (Exception $e) {
                    error_log('Checkout error: ' . $e->getMessage());
                    echo "<script>alert('Error initiating payment: " . addslashes($e->getMessage()) . "'); window.location.href='menu.php';</script>";
                    exit;
                } // ---------- END: payment and order processing ----------


                //payment and 









                // Loop through the arrays of items, prices, and quantities
                $items = $_POST['Item_name'];
                $prices = $_POST['price'];
                $quantities = $_POST['Quantity'];

                for ($i = 0; $i < count($items); $i++) {
                    $item = $items[$i];
                    $price = $prices[$i];
                    $quantity = $quantities[$i];
                    $total_price = $price * $quantity; // Calculate total price

                    $query1 = "INSERT INTO `orders`(`name`, `email`, `address`,`item`, `quantity`, `total_price`) 
               VALUES ('$name','$email','$address','$item','$quantity','$total_price')";

                    if (mysqli_query($conn, $query1)) {
                        // Order placed successfully
                    } else {
                        // Error occurred while placing the order
                        echo "Error: " . mysqli_error($conn);
                    }
                }

                echo "<script>
                    alert('Orders placed successfully');
                    window.location.href='dashboard.php';
                </script>";
            }
        } else {
            echo "<script>
                alert('Please login to proceed with checkout.');
                window.location.href='login.php';
            </script>";
        }
    }
}
