<?php
// payment/verify.php
declare(strict_types=1);
session_start();
header('Content-Type: application/json; charset=utf-8');

// only accept POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status'=>'error','message'=>'Method not allowed']);
    exit;
}

// require DB and config
require_once __DIR__ . '/../includes/connection.php';
$config = require __DIR__ . '/config.php'; // adjust path if needed

// include SDK
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require __DIR__ . '/vendor/autoload.php';
} elseif (file_exists(__DIR__ . '/razorpay-php/Razorpay.php')) {
    require __DIR__ . '/razorpay-php/Razorpay.php';
} else {
    http_response_code(500);
    echo json_encode(['status'=>'error','message'=>'Razorpay SDK missing']);
    exit;
}

use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

// validate required fields
$required = ['razorpay_order_id','razorpay_payment_id','razorpay_signature','tr_id'];
foreach ($required as $f) {
    if (empty($_POST[$f])) {
        http_response_code(400);
        echo json_encode(['status'=>'error','message'=>"Missing $f"]);
        exit;
    }
}

$order_id = (string)$_POST['razorpay_order_id'];
$payment_id = (string)$_POST['razorpay_payment_id'];
$signature = (string)$_POST['razorpay_signature'];
$tr_id = (string)$_POST['tr_id'];

$api_key = $config['api_key'] ?? null;
$api_secret = $config['api_secret'] ?? null;
if (empty($api_key) || empty($api_secret)) {
    http_response_code(500);
    echo json_encode(['status'=>'error','message'=>'API keys not configured']);
    exit;
}

try {
    $api = new Api($api_key, $api_secret);
    $attributes = [
        'razorpay_order_id' => $order_id,
        'razorpay_payment_id' => $payment_id,
        'razorpay_signature' => $signature
    ];
    // verifies signature or throws
    $api->utility->verifyPaymentSignature($attributes);

    // fetch payment details (optional)
    $payment = $api->payment->fetch($payment_id);

    // mark DB rows paid matching tr_id and belonging to logged-in user (for security)
    if (!isset($_SESSION['username'])) {
        // if you don't use sessions here, you can skip ownership check — but better to verify
        $userEmail = null;
    } else {
        $userEmail = $_SESSION['username'];
    }

    // Update orders: set payment_id, status='paid', ensure order_id matches the one provided
    if ($userEmail) {
        $upd = $conn->prepare("UPDATE orders SET payment_id = ?, status = 'paid', order_id = ? WHERE tr_id = ? AND email = ?");
        $upd->bind_param('ssss', $payment_id, $order_id, $tr_id, $userEmail);
    } else {
        $upd = $conn->prepare("UPDATE orders SET payment_id = ?, status = 'paid', order_id = ? WHERE tr_id = ?");
        $upd->bind_param('sss', $payment_id, $order_id, $tr_id);
    }

    if (!$upd) {
        http_response_code(500);
        echo json_encode(['status'=>'error','message'=>'DB prepare failed']);
        exit;
    }
    $ok = $upd->execute();
    $upd->close();

    if (!$ok) {
        http_response_code(500);
        echo json_encode(['status'=>'error','message'=>'DB update failed']);
        exit;
    }

    // Success response
    echo json_encode([
        'status'=>'success',
        'order_id'=>$order_id,
        'payment_id'=>$payment_id,
        'amount'=> $payment->amount ?? null
    ]);
    exit;

} catch (SignatureVerificationError $e) {
    http_response_code(400);
    error_log('SignatureVerificationError: ' . $e->getMessage());
    echo json_encode(['status'=>'error','message'=>'Signature verification failed']);
    exit;
} catch (Exception $e) {
    http_response_code(500);
    error_log('verify.php Exception: ' . $e->getMessage());
    echo json_encode(['status'=>'error','message'=>'Internal server error']);
    exit;
}
