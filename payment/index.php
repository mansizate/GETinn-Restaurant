<?php
declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php'; // composer autoload

use Razorpay\Api\Api;
use Razorpay\Api\Errors\BadRequestError;
use Razorpay\Api\Errors\UnauthorizedError;

// Load keys from environment (safer). As a fallback you may hardcode for local testing.
// $api_key = isset($_ENV['RAZORPAY_KEY']) ? trim($_ENV['RAZORPAY_KEY']) : trim('rzp_test_YOUR_NEW_KEY');
// $api_secret = isset($_ENV['RAZORPAY_SECRET']) ? trim($_ENV['RAZORPAY_SECRET']) : trim('YOUR_NEW_SECRET');
$api_secret = "KCk7oi5ehH13EwboTCbkxbFU";
$api_key ="rzp_test_RSYeLpG9kQCHnH";

try {
    // Quick sanity check: length must match expected pattern
    if (empty($api_key) || empty($api_secret)) {
        throw new \RuntimeException('Razorpay API key/secret not set.');
    }

    $api = new Api($api_key, $api_secret);

    $orderData = [
        'amount' => 9900,        // in paise (₹99.00)
        'currency' => 'INR',
        'receipt' => 'order_receipt_12asa3',
        'payment_capture' => 1
    ];

    $order = $api->order->create($orderData);

    // safe to expose only the keyId and order id to client, never secret
    $order_id = $order->id;

    // render minimal HTML + Checkout integration
    echo '<!doctype html><html><head><meta charset="utf-8"><title>Pay</title></head><body>';
    echo '<script src="https://checkout.razorpay.com/v1/checkout.js"></script>';
    echo '<button id="rzp-pay">Pay with Razorpay</button>';
    echo '<script>
      document.getElementById("rzp-pay").onclick = function(e){
        var options = {
          "key": "' . htmlspecialchars($api_key, ENT_QUOTES) . '",
          "amount": ' . (int)$order->amount . ',
          "currency": "' . htmlspecialchars($order->currency, ENT_QUOTES) . '",
          "name": "Your Company Name",
          "description": "Order Payment",
          "order_id": "' . htmlspecialchars($order_id, ENT_QUOTES) . '",
          "handler": function (response){
            // handle success - send response.razorpay_payment_id / order id to server-side for verification
            window.location.href = "/success.html?payment_id="+response.razorpay_payment_id+"&order_id="+response.razorpay_order_id;
          }
        };
        var rzp = new Razorpay(options);
        rzp.open();
        e.preventDefault();
      }
    </script>';
    echo '</body></html>';

} catch (UnauthorizedError $e) {
    // 401 - authentication specifically
    error_log('Razorpay Unauthorized: ' . $e->getMessage());
    http_response_code(500);
    echo "Payment service authentication failed. Please check API keys (rotated and safe).";
    exit;
} catch (BadRequestError $e) {
    error_log('Razorpay BadRequest: ' . $e->getMessage());
    http_response_code(400);
    echo "Payment service bad request: " . htmlspecialchars($e->getMessage());
    exit;
} catch (\Exception $e) {
    error_log('Razorpay Exception: ' . $e->getMessage());
    http_response_code(500);
    echo "An error occurred while creating order. Check server logs.";
    exit;
}
