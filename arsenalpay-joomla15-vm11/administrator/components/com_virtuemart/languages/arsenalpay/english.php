<?php
if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' ); 

global $VM_LANG;
$langvars = array (
	'ARSENALPAY_UNIQUE_ID' => 'Unique token *',
	'ARSENALPAY_UNIQUE_ID_DESC' => 'Assigned to merchant for access to ArsenalPay payment frame.',
	'ARSENALPAY_SIGN_KEY' => 'Sign key *',
	'ARSENALPAY_SIGN_KEY_DESC' => 'With this key you check a validity of sign that comes with callback payment data.', 
	'ARSENALPAY_FRAME_URL'	=> 'Frame URL *',
	'ARSENALPAY_FRAME_URL_DESC'	=> 'URL-address of ArsenalPay payment frame',
	'ARSENALPAY_PAYMENT_SRC' => 'Payment type *',
	'ARSENALPAY_PAYMENT_SRC_DESC' => 'card - payment from bank card (internet acquiring),<br>mk - payment from mobile phone account (mobile-commerce)',
	'ARSENALPAY_PAYER_CALLBACK_URL' => 'Check URL',
    'ARSENALPAY_PAYER_CALLBACK_URL_DESC' => 'To check order number before payment processing',
    'ARSENALPAY_PAYMENT_CALLBACK_URL' => 'Callback URL *',
    'ARSENALPAY_PAYMENT_CALLBACK_URL_DESC' => 'For payment confirmation',
	'ARSENALPAY_ALLOWED_IP' => 'Allowed IP-address',
    'ARSENALPAY_ALLOWED_IP_DESC' => 'It can be allowed to receive ArsenalPay payment confirmation callback requests only from the IP-address pointed out here',
    'ARSENALPAY_CSS_FILE' => 'css parameter',
	'ARSENALPAY_CSS_FILE_DESC' => 'URL of CSS file if exists',
	'ARSENALPAY_STATUS_PENDING' => 'Order Status for Pending transactions',
	'ARSENALPAY_STATUS_CONFIRMED' => 'Order Status for Confirmed transactions',
	'ARSENALPAY_STATUS_CANCELLED' => 'Order Status for Cancelled transactions',
	'ARSENALPAY_FRAME_MODE' => 'To display payment page inside frame',
	'ARSENALPAY_FRAME_MODE_DESC' => 'Yes - inside frame at your site,<br>No - redirect to payment page',
	'ARSENALPAY_FRAME_PARAMS' => 'Other ArsenalPay payment frame parameters',
	'ARSENALPAY_FRAME_PARAMS_DESC' => "Here you can set ifame parameters and so modify how ArsenalPay payment frame will be displayed.<br>For example: width='700' height='500' frameborder='0' scrolling='auto'",

); 
$VM_LANG->initModule('arsenalpay', $langvars);