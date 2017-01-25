<?php
if (!defined('_VALID_MOS') && !defined('_JEXEC'))
	die('Direct Access to ' . basename(__FILE__) . ' is not allowed.');

/**
* @version      $Id: ps_arsenalpay.php special 
* @author       The ArsenalPay Dev. Team
* @package      VirtueMart
* @subpackage 	payment
* @copyright    Copyright (C) 2017 ArsenalPay. All rights reserved.
* @license      http://www.gnu.org/copyleft/gpl.html GNU/GPL
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See /administrator/components/com_virtuemart/COPYRIGHT.php for copyright notices and details.
*
* http://virtuemart.net
*/

class ps_arsenalpay {
	var $payment_code = "AP";
	/**
	 * Shows the configuration form for this payment module in the payment method form
	 * 
	 * @param void
	 * @return string
	 */
	function show_configuration() {

        global $VM_LANG, $sess;
		$db = new ps_DB;
		$payment_method_id = vmGet( $_REQUEST, 'payment_method_id', null );

		$VM_LANG->load('arsenalpay');
			
		// Read current Configuration
		include_once(CLASSPATH ."payment/ps_arsenalpay.cfg.php");
				
		?>
<p style="text-align: center;font-weight: bold;"><?php echo $VM_LANG->_('ARSENALPAY_TITLE') ?></p>
<p><?php echo $VM_LANG->_('ARSENALPAY_DESC') ?></p><br>
<table>	
	<tr>
		<td><strong><?php echo $VM_LANG->_('ARSENALPAY_UNIQUE_ID') ?></strong></td>
		<td><input type="text" name="AP_UNIQUE_ID" size="50"  class="inputbox" value="<?php echo defined('AP_UNIQUE_ID') ? AP_UNIQUE_ID : ''?>"/></td>
		<td><?php echo vmtooltip($VM_LANG->_('ARSENALPAY_UNIQUE_ID_DESC')) ?></td>
	</tr>
	<tr>
		<td><strong><?php echo $VM_LANG->_('ARSENALPAY_SIGN_KEY') ?></strong></td>
		<td><input type="text" name="AP_SIGN_KEY" size="50" class="inputbox" value="<?php echo defined('AP_SIGN_KEY') ? AP_SIGN_KEY : ''?>" /></td>
		<td><?php echo vmtooltip($VM_LANG->_('ARSENALPAY_SIGN_KEY_DESC'))?></td>
	</tr>
	<tr>
		<td><strong><?php echo $VM_LANG->_('ARSENALPAY_FRAME_URL') ?></strong></td>
		<td><input type="text" name="AP_FRAME_URL" size="50" class="inputbox" value="<?php echo defined('AP_FRAME_URL') ? AP_FRAME_URL : 'https://arsenalpay.ru/payframe/pay.php' ?>" /></td>
		<td><?php echo vmtooltip($VM_LANG->_('ARSENALPAY_FRAME_URL_DESC'))?></td>
	</tr>	
	<tr>
        <td><strong><?php echo $VM_LANG->_('ARSENALPAY_PAYMENT_SRC')?></strong></td>
        <td>
			<select name="AP_PAYMENT_SRC" class="inputbox" >
                <option <?php if (AP_PAYMENT_SRC == 'card') echo "selected=\"selected\""; ?> value="card">card</option>
                <option <?php if (AP_PAYMENT_SRC == 'mk') echo "selected=\"selected\""; ?> value="mk">mk</option>
            </select>
        </td>
        <td><?php echo vmtooltip($VM_LANG->_('ARSENALPAY_PAYMENT_SRC_DESC')) ?>
        </td>
    </tr>
    <tr>
		<td><strong><?php echo $VM_LANG->_('ARSENALPAY_PAYER_CALLBACK_URL') ?></strong></td>
		<td><input type="text" name="AP_PAYER_CALLBACK_URL" size="50" class="inputbox" value="<?php  echo defined('AP_PAYER_CALLBACK_URL') ? AP_PAYER_CALLBACK_URL :  'http(s)://[joomla-site-domain]/administrator/components/com_virtuemart/arsenalpay_notify.php' ?>" /></td>
		<td><?php echo vmtooltip($VM_LANG->_('ARSENALPAY_PAYER_CALLBACK_URL_DESC'))?></td>
	</tr>
	<tr>
		<td><strong><?php echo $VM_LANG->_('ARSENALPAY_PAYMENT_CALLBACK_URL') ?></strong></td>
		<td><input type="text" name="AP_PAYMENT_CALLBACK_URL" size="50" class="inputbox" value="<?php echo defined('AP_PAYMENT_CALLBACK_URL') ? AP_PAYMENT_CALLBACK_URL : 'http(s)://[joomla-site-domain]/administrator/components/com_virtuemart/arsenalpay_notify.php' ?>" /></td>
		<td><?php echo vmtooltip($VM_LANG->_('ARSENALPAY_PAYMENT_CALLBACK_URL_DESC'))?></td>
	</tr>
	<tr>
		<td><strong><?php echo $VM_LANG->_('ARSENALPAY_ALLOWED_IP') ?></strong></td>
		<td><input type="text" name="AP_ALLOWED_IP" class="inputbox" value="<?php echo defined('AP_ALLOWED_IP') ? AP_ALLOWED_IP : '' ?>" /></td>
		<td><?php echo vmtooltip($VM_LANG->_('ARSENALPAY_ALLOWED_IP_DESC'))?></td>
	</tr>
	<tr>
		<td><strong><?php echo $VM_LANG->_('ARSENALPAY_CSS_FILE') ?></strong></td>
		<td><input type="text" name="AP_CSS_FILE" size="50" class="inputbox" value="<?php echo defined('AP_CSS_FILE') ? AP_CSS_FILE : '' ?>" /></td>
		<td><?php echo vmtooltip($VM_LANG->_('ARSENALPAY_CSS_FILE_DESC'))?></td>
	</tr>
	<tr>
        <td><strong><?php echo $VM_LANG->_('ARSENALPAY_FRAME_MODE')?></strong></td>
        <td>
			<select name="AP_FRAME_MODE" class="inputbox" >
                <option <?php if (AP_FRAME_MODE == '1') echo "selected=\"selected\""; ?> value="1">YES</option>
                <option <?php if (AP_FRAME_MODE == '0') echo "selected=\"selected\""; ?> value="0">NO</option>
            </select>
        </td>
        <td><?php echo vmtooltip($VM_LANG->_('ARSENALPAY_FRAME_MODE_DESC')) ?>
        </td>
    </tr>
    <tr>
		<td><strong><?php echo $VM_LANG->_('ARSENALPAY_FRAME_PARAMS') ?></strong></td>
		<td><input type="text" name="AP_FRAME_PARAMS" size="50" class="inputbox" value="<?php echo defined('AP_FRAME_PARAMS') ? AP_FRAME_PARAMS : "width='700' height='500' frameborder='0' scrolling='auto'"?>" /></td>
		<td><?php echo vmtooltip($VM_LANG->_('ARSENALPAY_FRAME_PARAMS_DESC'))?></td>
	</tr>
</table>
		<?php
		return true;
	}

	function has_configuration() {
		// return false if there's no configuration
		return true;
	}

	/**
	* Returns the "is_writeable" status of the configuration file
	* @param void
	* @returns boolean True when the configuration file is writeable, false when not
	*/
	function configfile_writeable() {
		return is_writeable( CLASSPATH."payment/".__CLASS__.".cfg.php" );
	}

	/**
	 * Returns true if the configuration file for that payment module is readable, false if not
	 * 
	 * @param void
	 * @return boolean
	 */
	function configfile_readable() {
		return is_readable(CLASSPATH . "payment/".__CLASS__.".cfg.php");
	}

	/**
	 * Stores all configuration values for this payment module in the configuration file
	 * 
	 * @param array $d An array of objects
	 * @return void
	 */
	function write_configuration(&$d) {
		$my_config_array = array(
			"AP_UNIQUE_ID" => htmlentities($d['AP_UNIQUE_ID'], ENT_QUOTES, 'UTF-8'),
			"AP_SIGN_KEY" => htmlentities($d['AP_SIGN_KEY'], ENT_QUOTES, 'UTF-8'),
			"AP_FRAME_URL" => htmlentities($d['AP_FRAME_URL'], ENT_QUOTES, 'UTF-8'),
			"AP_PAYMENT_SRC" => htmlentities($d['AP_PAYMENT_SRC'], ENT_QUOTES, 'UTF-8'),
			"AP_PAYER_CALLBACK_URL" => htmlentities($d['AP_PAYER_CALLBACK_URL'], ENT_QUOTES, 'UTF-8'),
			"AP_PAYMENT_CALLBACK_URL" => htmlentities($d['AP_PAYMENT_CALLBACK_URL'], ENT_QUOTES, 'UTF-8'),
			"AP_ALLOWED_IP" => htmlentities($d['AP_ALLOWED_IP'], ENT_QUOTES, 'UTF-8'),
			"AP_CSS_FILE" => htmlentities($d['AP_CSS_FILE'], ENT_QUOTES, 'UTF-8'),
			"AP_FRAME_MODE" => htmlentities($d['AP_FRAME_MODE'], ENT_QUOTES, 'UTF-8'),
			"AP_FRAME_PARAMS" => addslashes($d['AP_FRAME_PARAMS'])
		);

		if (isset($my_config_array['AP_FRAME_PARAMS'])) {
			$frame_params = $my_config_array['AP_FRAME_PARAMS'];
		 	$pattern = '/[\s]+/';
		 	$iframe_attributes = preg_split($pattern, trim($frame_params));
		 	foreach ($iframe_attributes as $pair) {
		 		$attribute = explode("=", $pair);
		 		$available_attributes = array("width", "height", "scrolling", 
			    	"frameborder", "allign", "marginheight", "marginwidth");
				if (!in_array(trim($attribute[0]), $available_attributes)) {
					return false;
				}	
			}
		}

		$config = "<?php\n";
		$config .= "if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' ); \n\n";
		foreach( $my_config_array as $key => $value ) {
			$config .= "define ('$key', '$value');\n";
		}

		$config .= "?>";

		if ($fp = fopen(CLASSPATH ."payment/".__CLASS__.".cfg.php", "w")) {
			fputs($fp, $config, strlen($config));
			fclose ($fp);
			return true;
		}
		else {
			return false;
		}
	}
	
	/**
	 * This is the function to calculate the fee / discount for this special payment module 
	 * (so you can calculate a fee, depending on the order total amount).
	 * 
	 * @param float $subtotal	 
	 * @return float
	 */
	function get_payment_rate($subtotal) {}

	/**
	 * This is the main function for all payment modules that use direct connections 
	 * to a payment gateway (like arsenalpay.ru). 
	 * This is the place, where the payment details are validated and captured on success.
	 * Returns true on sucess, false on failure.
	 * 
	 * @param string $order_number
	 * @param float $order_total
	 * @param array $d An array of objects
	 * @return boolean
	 */
	function process_payment($order_number, $order_total, &$d) {
        return true;
    }
}
?>