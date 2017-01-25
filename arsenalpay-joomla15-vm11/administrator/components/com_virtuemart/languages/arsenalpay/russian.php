<?php
if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' ); 

global $VM_LANG;
$langvars = array (
	'ARSENALPAY_UNIQUE_ID' => 'Уникальный токен *',
	'ARSENALPAY_UNIQUE_ID_DESC' => 'Присваивается мерчанту для доступа к платежному фрейму',
	'ARSENALPAY_SIGN_KEY' => 'Ключ *',
	'ARSENALPAY_SIGN_KEY_DESC' => 'Используется для проверки подписи', 
	'ARSENALPAY_FRAME_URL'	=> 'URL фрейма *',
	'ARSENALPAY_FRAME_URL_DESC'	=> 'URL-адрес платежного фрейма ArsenalPay',
	'ARSENALPAY_PAYMENT_SRC' => 'Тип оплаты *',
	'ARSENALPAY_PAYMENT_SRC_DESC' => 'card - оплата банковскими картами, <br>mk - оплата с мобильного баланса',
	'ARSENALPAY_PAYER_CALLBACK_URL' => 'URL для проверки получателя',
    'ARSENALPAY_PAYER_CALLBACK_URL_DESC' => 'На проверку номера заказа',
    'ARSENALPAY_PAYMENT_CALLBACK_URL' => 'URL для обратного запроса *',
    'ARSENALPAY_PAYMENT_CALLBACK_URL_DESC' => 'На подтверждение платежа',
	'ARSENALPAY_ALLOWED_IP' => 'Разрешенный IP-адрес',
    'ARSENALPAY_ALLOWED_IP_DESC' => 'IP-адрес, только с которого будут разрешены обратные запросы о подтверждении платежей от ArsenalPay',
    'ARSENALPAY_CSS_FILE' => 'Параметр css',
	'ARSENALPAY_CSS_FILE_DESC' => 'Адрес (URL) css-файла',
	'ARSENALPAY_STATUS_PENDING' => 'Статус заказа на время ожидания оплаты',
	'ARSENALPAY_STATUS_CONFIRMED' => 'Статус заказа после подтверждения платежа',
	'ARSENALPAY_STATUS_CANCELLED' => 'Статус заказа после неудавшегося платежа',
	'ARSENALPAY_FRAME_MODE' => 'Отображать платежную страницу внутри фрейма',
	'ARSENALPAY_FRAME_MODE_DESC' => 'Да - внутри фрейма на вашем сайте, Нет - перенаправлять на платежную страницу',
	'ARSENALPAY_FRAME_PARAMS' => 'Дополнительные параметры фрейма',
	'ARSENALPAY_FRAME_PARAMS_DESC' => "Здесь вы можете задать параметры отображения платежного фрейма,<br>Например: width='700' height='500' frameborder='0' scrolling='auto'",
); 
$VM_LANG->initModule('arsenalpay', $langvars);