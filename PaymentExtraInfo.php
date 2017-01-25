<?php 

include_once(CLASSPATH ."payment/ps_arsenalpay.cfg.php");
global $VM_LANG;
$VM_LANG->load('arsenalpay');
$order_number = htmlentities($db->f("order_id"), ENT_QUOTES, 'UTF-8');
$total_sum_to_pay = htmlentities(sprintf("%.2f", $db->f("order_total")), ENT_QUOTES, 'UTF-8');

$q = "select payment_method_id FROM #__vm_order_payment WHERE order_id = '$order_number'";
$db->query($q);
$payment_method_id = htmlentities($db->f('payment_method_id'), ENT_QUOTES, 'UTF-8'); 

$q = "select payment_class FROM #__vm_payment_method WHERE payment_method_id = '".$payment_method_id."'";
$db->query($q);
$payment_class = htmlentities($db->f('payment_class'), ENT_QUOTES, 'UTF-8');

$frame_url = defined('AP_FRAME_URL') ? AP_FRAME_URL : 'https://arsenalpay/payframe/pay.php';
$unique_id = defined('AP_UNIQUE_ID') ? AP_UNIQUE_ID : '';
$payment_type = defined('AP_PAYMENT_SRC') ? AP_PAYMENT_SRC : '';
$frame_mode = defined('AP_FRAME_MODE') ? AP_FRAME_MODE : '';
$css_file = defined('AP_CSS_FILE') ? AP_CSS_FILE : '';
$frame_params = defined('AP_FRAME_PARAMS') ? AP_FRAME_PARAMS : "width='700' height='500' frameborder='0' scrolling='auto'";

$url_params = array(
    'src' => $payment_type,
    't' => $unique_id,
    'n' => $order_number,
    'a' => $total_sum_to_pay,
    'msisdn'=> '',
    'css' => $css_file,
    'frame' => $frame_mode,
    'description' => '',
    'full_name' => '',
    'phone' => '',
    'email' => '',
    'address' => '',
    'other' => '',
);


$payment_url = $frame_url . '?' . http_build_query($url_params, '', '&');

?>
<?php if ($payment_class == 'ps_arsenalpay'):?>
<iframe name="arspay" src=<?php echo htmlentities($payment_url, ENT_QUOTES, 'UTF-8')?> <?php echo stripcslashes($frame_params)?>></iframe>'
<?php endif?>