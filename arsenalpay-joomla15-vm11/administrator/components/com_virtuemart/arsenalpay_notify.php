 <?php
global $mosConfig_absolute_path, $mosConfig_live_site, $mosConfig_lang, $database, $mosConfig_mailfrom, $mosConfig_fromname;

/*** access Joomla's configuration file ***/
$my_path = dirname(__FILE__);

if (file_exists($my_path . "/../../../configuration.php")) {
    $absolute_path = dirname($my_path . "/../../../configuration.php");
    require_once ($my_path . "/../../../configuration.php");
} elseif (file_exists($my_path . "/../../configuration.php")) {
    $absolute_path = dirname($my_path . "/../../configuration.php");
    require_once ($my_path . "/../../configuration.php");
} elseif (file_exists($my_path . "/configuration.php")) {
    $absolute_path = dirname($my_path . "/configuration.php");
    require_once ($my_path . "/configuration.php");
} else {
    die("Joomla Configuration File not found!");
}

$absolute_path = realpath($absolute_path);

// Set up the appropriate CMS framework
if (class_exists('jconfig')) {
    define('_JEXEC', 1);
    define('JPATH_BASE', $absolute_path);
    define('DS', DIRECTORY_SEPARATOR);
    
    // Load the framework
    require_once (JPATH_BASE . DS . 'includes' . DS . 'defines.php');
    require_once (JPATH_BASE . DS . 'includes' . DS . 'framework.php');
    
    // create the mainframe object
    $mainframe = & JFactory::getApplication('site');
    
    // Initialize the framework
    $mainframe->initialise();
    
    // load system plugin group
    JPluginHelper::importPlugin('system');
    
    // trigger the onBeforeStart events
    $mainframe->triggerEvent('onBeforeStart');
    $lang = & JFactory::getLanguage();
    $mosConfig_lang = $GLOBALS['mosConfig_lang'] = strtolower($lang->getBackwardLang());
    // Adjust the live site path
    $mosConfig_live_site = str_replace('/administrator/components/com_virtuemart', '', JURI::base());
    $mosConfig_absolute_path = JPATH_BASE;
} else {
    define('_VALID_MOS', '1');
    require_once ($mosConfig_absolute_path . '/includes/joomla.php');
    require_once ($mosConfig_absolute_path . '/includes/database.php');
    $database = new database($mosConfig_host, $mosConfig_user, $mosConfig_password, $mosConfig_db, $mosConfig_dbprefix);
    $mainframe = new mosMainFrame($database, 'com_virtuemart', $mosConfig_absolute_path);
}

// load Joomla Language File
if (file_exists($mosConfig_absolute_path . '/language/' . $mosConfig_lang . '.php')) {
    require_once ($mosConfig_absolute_path . '/language/' . $mosConfig_lang . '.php');
} elseif (file_exists($mosConfig_absolute_path . '/language/english.php')) {
    require_once ($mosConfig_absolute_path . '/language/english.php');
}
/*** END of Joomla config ***/

/*** VirtueMart part ***/
global $database;
require_once ($mosConfig_absolute_path . '/administrator/components/com_virtuemart/virtuemart.cfg.php');
include_once (ADMINPATH . '/compat.joomla1.5.php');
require_once (ADMINPATH . 'global.php');
require_once (CLASSPATH . 'ps_main.php');
require_once (CLASSPATH . 'ps_database.php');
require_once (CLASSPATH . 'ps_order.php');

/* Load the ArsenalPay Configuration File */
require_once (CLASSPATH . 'payment/ps_arsenalpay.cfg.php');
/*** END VirtueMart part ***/

$callback_msg = $_POST;
$available_keys = array(
    'ID' => FILTER_SANITIZE_STRING, 
    'FUNCTION' => FILTER_SANITIZE_STRING, 
    'RRN' => FILTER_SANITIZE_NUMBER_INT, 
    'PAYER' => FILTER_SANITIZE_STRING, 
    'AMOUNT' => FILTER_VALIDATE_FLOAT, 
    'ACCOUNT' => FILTER_SANITIZE_STRING, 
    'STATUS' => FILTER_SANITIZE_STRING, 
    'DATETIME' => FILTER_DEFAULT, 
    'SIGN' => FILTER_SANITIZE_STRING,
    'MERCH_TYPE' => FILTER_SANITIZE_STRING,
    'AMOUNT_FULL' => FILTER_VALIDATE_FLOAT 
    ); 
$callback_msg = filter_input_array(INPUT_POST, $available_keys);
// Обязательные параметры     
$key_array = array(
    'ID',           /* merchant identifier */
    'FUNCTION',     /* request type: check or payment*/
    'RRN',          /* transaction identifier */
    'PAYER',        /* payer(custom) identifier */
    'AMOUNT',       /* payment amount */
    'ACCOUNT',      /* order number */
    'STATUS',       /* Payment status. */
    'DATETIME',     /* Date and time in ISO-8601 format, urlencoded.*/
    'SIGN',         /* callback request sign = md5(md5(ID).md(FUNCTION).md5(RRN).md5(PAYER).md5(AMOUNT).md5(ACCOUNT).md(STATUS).md5(PASSWORD)) */       
); 
/**
 * Checking the absence of each parameter in the post request.
 */
foreach ($key_array as $key) {
    if (empty($callback_msg[$key]) || !array_key_exists($key, $callback_msg)) {
        logMsg("ERR_".$key);
        die("ERR_".$key);
    }
} 
$order_number = $callback_msg['ACCOUNT'];

//получаем данные заказа
$sql = "SELECT order_id, order_number, user_id, order_total, order_status FROM #__vm_orders WHERE order_id='{$order_number}'";
$dbManger = new ps_DB();

$dbManger->query($sql);
$dbManger->next_record();
$order_total_cost = htmlentities(sprintf("%.2f", $dbManger->f("order_total")), ENT_QUOTES, 'UTF-8');
$shop_user = $dbManger->f('user_id');
$order_id = $dbManger->f('order_id');
$order_status = $dbManger->f("order_status");
if (is_null($order_id) || $order_status == 'C') {
    if ($callback_msg['FUNCTION'] == 'check' && $callback_msg['STATUS'] == 'check') { 
        logMsg('NO');
        die('NO');
    }
    logMsg('ERR_ACCOUNT');
    die('ERR_ACCOUNT');
}
else {
    //check if the ip is allowed 
    $REMOTE_ADDR = htmlentities($_SERVER["REMOTE_ADDR"], ENT_QUOTES, 'UTF-8');
    $IP_ALLOW = defined('AP_ALLOWED_IP') && AP_ALLOWED_IP != 'AP_ALLOWED_IP' ? AP_ALLOWED_IP : '';
    if( strlen( $IP_ALLOW ) > 0 && $IP_ALLOW != $REMOTE_ADDR ) {
        logMsg('ERR_IP');
        die('ERR_IP');
    }
    /**
     * Checking the request sign validness.
     */
    $SECRET_KEY = defined('AP_SIGN_KEY') && AP_SIGN_KEY != 'AP_SIGN_KEY' ? AP_SIGN_KEY : '';
    if( !checkSign( $callback_msg, $SECRET_KEY)) {
        logMsg('ERR_INVALID_SIGN');
        die('ERR_INVALID_SIGN');
    }  
    if ($callback_msg['FUNCTION']=='check' && $callback_msg['FUNCTION']=='check' ) {
        logMsg('YES');
        die('YES');
    }
    $lessAmount = false;
    if ( $callback_msg['MERCH_TYPE'] == '0' && $order_total_cost == $callback_msg['AMOUNT'] ) {
        $lessAmount = false;
    }
    elseif ( $callback_msg['MERCH_TYPE'] == '1' && $order_total_cost >= $callback_msg['AMOUNT'] && $order_total_cost == $callback_msg['AMOUNT_FULL'] ) {
        $lessAmount = true;
    }
    else {
        logMsg('ERR_AMOUNT');
        die('ERR_AMOUNT');
    }
    if ($lessAmount) {
        logMsg(sprintf("Order #%s is payed with less amount %s. Total amount is %s", $order_number, $callback_msg['AMOUNT'], $order_total_cost));
    }
    if ( $callback_msg['FUNCTION'] == 'payment' && $callback_msg['STATUS'] == 'payment' ) {
        $order['order_id'] = $order_id;
        $order['notify_customer'] = "Y";
        $order['order_total'] = $order_total_cost;
        $order['order_status'] = 'C';
        $ps_order = new ps_order();
        $ps_order->order_status_update($order);
        //отправка пользователю подтверждения об оплтае
        $mailsubject = "Заказ № ".$order['order_id']." оплачен.";
        $mailbody = "Статус  заказа No. ".$order['order_id']." был изменен.\n\n";
        $mailbody .= "Новый статус:\n\n";
        $mailbody .= "--------------------------------------- \n";
        $mailbody .= "Confirmed\n";
        $mailbody .= "--------------------------------------- \n\n";
        $mailbody .= "Для просмотра информации о заказе, пожалуйста, ";
        $mailbody .= "пройдите по этой ссылке(или скопируйте её в адресную строку Вашего браузер):\n";
        $mailbody .= URL."index.php?option=com_virtuemart&page=account.order_details&order_id=".$order['order_id']."\n";
        vmMail($mosConfig_mailfrom, $mosConfig_fromname, $mosConfig_mailfrom, $mailsubject, $mailbody);
        logMsg('OK');
        die('OK');
    } 
    else {
        logMsg('ERR_FUNCTION');
        die('ERR_FUNCTION');
    }
}

function logMsg($msg) 
{
    ob_start();
    // logging
    $fp = fopen('./arsenalpay.log', 'a+');
    $str = date('Y-m-d H:i:s') . ' - ';
    fwrite($fp, $str . "\n" . print_r($msg, true). "\n\n");
    fclose($fp); 
    ob_end_clean();
}

function checkSign( $callback, $pass) 
{
    $validSign = ( $callback['SIGN'] === md5(md5($callback['ID']).
            md5($callback['FUNCTION']).md5($callback['RRN']).
            md5($callback['PAYER']).md5($callback['AMOUNT']).md5($callback['ACCOUNT']).
            md5($callback['STATUS']).md5($pass) ) )? true : false;
    return $validSign;        
}
?>

