<?php
/* Constant Contact integration for Layered Popups */
define('ULP_CONSTANT_CONTACT_DEFAULT_API_KEY', 'byk44ey5gc6nkha7vrxmdg8s');
class ulp_constantcontact_class {
	var $default_popup_options = array(
		'constantcontact_enable' => "off",
		'constantcontact_api_key' => ULP_CONSTANT_CONTACT_DEFAULT_API_KEY,
		'constantcontact_token' => '',
		'constantcontact_list_id' => ''
	);
	function __construct() {
		if (is_admin()) {
			add_action('admin_init', array(&$this, 'admin_request_handler'));
			add_action('ulp_popup_options_show', array(&$this, 'popup_options_show'));
			add_action('ulp_subscribe', array(&$this, 'subscribe'), 10, 2);
			add_filter('ulp_popup_options_check', array(&$this, 'popup_options_check'), 10, 1);
			add_filter('ulp_popup_options_populate', array(&$this, 'popup_options_populate'), 10, 1);
		}
	}
	function popup_options_show($_popup_options) {
		$popup_options = array_merge($this->default_popup_options, $_popup_options);
		echo '
				<h3>'.__('Constant Contact Parameters', 'ulp').'</h3>
				<table class="ulp_useroptions">
					<tr>
						<th>'.__('Enable Constant Contact', 'ulp').':</th>
						<td>
							<input type="checkbox" id="ulp_constantcontact_enable" name="ulp_constantcontact_enable" '.($popup_options['constantcontact_enable'] == "on" ? 'checked="checked"' : '').'"> '.__('Submit contact details to Constant Contact', 'ulp').'
							<br /><em>'.__('Please tick checkbox if you want to submit contact details to Constant Contact.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('API Key', 'ulp').':</th>
						<td>
							<input type="text" id="ulp_constantcontact_api_key" name="ulp_constantcontact_api_key" value="'.esc_html($popup_options['constantcontact_api_key']).'" class="widefat" onchange="ulp_constantcontact_key_changed();">
							<br /><em>'.__('Enter your API Key. You can use <a href="#" onclick="jQuery(\'#ulp_constantcontact_api_key\').val(\''.ULP_CONSTANT_CONTACT_DEFAULT_API_KEY.'\'); ulp_constantcontact_key_changed(); return false;">Default API Key</a> or get your own API Key <a href="https://constantcontact.mashery.com/apps/mykeys" target="_blank">here</a>.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('Access Token', 'ulp').':</th>
						<td>
							<input type="text" id="ulp_constantcontact_token" name="ulp_constantcontact_token" value="'.esc_html($popup_options['constantcontact_token']).'" class="widefat" onchange="ulp_constantcontact_token_changed();">
							<br /><em>'.__('Enter your Access Token. You can get it <a id="ulp_constantcontact_token_link" href="https://oauth2.constantcontact.com/oauth2/password.htm?client_id='.esc_html($popup_options['constantcontact_api_key']).'" target="_blank">here</a>.', 'ulp').'</em>
							<script>
								function ulp_constantcontact_key_changed() {
									jQuery("#ulp_constantcontact_token_link").attr("href", "https://oauth2.constantcontact.com/oauth2/password.htm?client_id="+jQuery("#ulp_constantcontact_api_key").val());
									ulp_constantcontact_token_changed();
								}
							</script>
						</td>
					</tr>
					<tr>
						<th>'.__('List ID', 'ulp').':</th>
						<td>
							<input type="text" id="ulp_constantcontact_list_id" name="ulp_constantcontact_list_id" value="'.esc_html($popup_options['constantcontact_list_id']).'" class="widefat">
							<br /><em>'.__('Enter your List ID. You can get List ID from', 'ulp').' <a href="'.admin_url('admin.php').'?action=ulp-constantcontact-lists&token='.base64_encode($popup_options['constantcontact_token']).'&key='.base64_encode($popup_options['constantcontact_api_key']).'" class="thickbox" id="ulp_constantcontact_lists" title="'.__('Available Lists', 'ulp').'">'.__('this table', 'ulp').'</a>.</em>
							<script>
								function ulp_constantcontact_token_changed() {
									jQuery("#ulp_constantcontact_lists").attr("href", "'.admin_url('admin.php').'?action=ulp-constantcontact-lists&token="+ulp_encode64(jQuery("#ulp_constantcontact_token").val())+"&key="+ulp_encode64(jQuery("#ulp_constantcontact_api_key").val()));
								}
							</script>
						</td>
					</tr>
				</table>';
	}
	function popup_options_check($_errors) {
		$errors = array();
		$popup_options = array();
		foreach ($this->default_popup_options as $key => $value) {
			if (isset($_POST['ulp_'.$key])) {
				$popup_options[$key] = stripslashes(trim($_POST['ulp_'.$key]));
			}
		}
		if (isset($_POST["ulp_constantcontact_enable"])) $popup_options['constantcontact_enable'] = "on";
		else $popup_options['constantcontact_enable'] = "off";
		if ($popup_options['constantcontact_enable'] == 'on') {
			if (empty($popup_options['constantcontact_api_key'])) $errors[] = __('Invalid Constant Contact API Key.', 'ulp');
			if (empty($popup_options['constantcontact_token'])) $errors[] = __('Invalid Constant Contact Access Token.', 'ulp');
			if (empty($popup_options['constantcontact_list_id'])) $errors[] = __('Invalid Constant Contact List ID.', 'ulp');
		}
		return array_merge($_errors, $errors);
	}
	function popup_options_populate($_popup_options) {
		$popup_options = array();
		foreach ($this->default_popup_options as $key => $value) {
			if (isset($_POST['ulp_'.$key])) {
				$popup_options[$key] = stripslashes(trim($_POST['ulp_'.$key]));
			}
		}
		if (isset($_POST["ulp_constantcontact_enable"])) $popup_options['constantcontact_enable'] = "on";
		else $popup_options['constantcontact_enable'] = "off";
		return array_merge($_popup_options, $popup_options);
	}
	function admin_request_handler() {
		global $wpdb;
		if (!empty($_GET['action'])) {
			switch($_GET['action']) {
				case 'ulp-constantcontact-lists':
					if (isset($_GET["token"]) && isset($_GET["key"])) {
						$token = base64_decode($_GET["token"]);
						$key = base64_decode($_GET["key"]);
						$lists = array();
						try {
							$curl = curl_init('https://api.constantcontact.com/v2/lists?api_key='.rawurlencode($key));
							$header = array(
								'Authorization: Bearer '.$token
							);
							curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
							curl_setopt($curl, CURLOPT_TIMEOUT, 10);
							curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
							curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
							curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
							//curl_setopt($curl, CURLOPT_FORBID_REUSE, 1);
							//curl_setopt($curl, CURLOPT_FRESH_CONNECT, 1);
							$response = curl_exec($curl);
							curl_close($curl);
							
							$result = json_decode($response, true);
							if($result && is_array($result)) {
								foreach ($result as $list) {
									if (is_array($list)) {
										if (array_key_exists('id', $list) && array_key_exists('name', $list)) {
											$lists[$list['id']] = $list['name'];
										}
									}
								}
							}							
						} catch (Exception $e) {
						}
						if (!empty($lists)) {
							echo '
<html>
<head>
	<meta name="robots" content="noindex, nofollow, noarchive, nosnippet">
	<title>'.__('Consatnt Contact Lists', 'ulp').'</title>
</head>
<body>
	<table style="width: 100%;">
		<tr>
			<td style="width: 170px; font-weight: bold;">'.__('List ID', 'ulp').'</td>
			<td style="font-weight: bold;">'.__('List Name', 'ulp').'</td>
		</tr>';
							foreach ($lists as $key => $value) {
								echo '
		<tr>
			<td>'.esc_html($key).'</td>
			<td>'.esc_html(esc_html($value)).'</td>
		</tr>';
							}
							echo '
	</table>						
</body>
</html>';
						} else echo '<div style="text-align: center; margin: 20px 0px;">'.__('No data found!', 'ulp').'</div>';
					} else echo '<div style="text-align: center; margin: 20px 0px;">'.__('No data found!', 'ulp').'</div>';
					die();
					break;
				default:
					break;
			}
		}
	}
	function subscribe($_popup_options, $_subscriber) {
		$popup_options = array_merge($this->default_popup_options, $_popup_options);
		if ($popup_options['constantcontact_enable'] == 'on') {
			$curl = curl_init('https://api.constantcontact.com/v2/contacts?api_key='.rawurlencode($popup_options['constantcontact_api_key']).'&email='.$_subscriber['{subscription-email}']);
			$header = array(
				'Authorization: Bearer '.$popup_options['constantcontact_token']
			);
			curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
			curl_setopt($curl, CURLOPT_TIMEOUT, 10);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
			//curl_setopt($curl, CURLOPT_FORBID_REUSE, 1);
			//curl_setopt($curl, CURLOPT_FRESH_CONNECT, 1);
			$response = curl_exec($curl);
			curl_close($curl);
			$result = json_decode($response, true);
			if($result && is_array($result)) {
				if (!empty($result['results'])) {
					$contact = $result['results'][0];
					$update = true;
					foreach ($contact['lists'] as $list) {
						if ($list['id'] == $popup_options['constantcontact_list_id']) {
							$update = false;
							break;
						}
					}
					if ($update) {
						$contact['lists'][] = array('id' => $popup_options['constantcontact_list_id']);
					}
					if ($contact['first_name'] != $_subscriber['{subscription-name}']) {
						$update = true;
						$contact['first_name'] = $_subscriber['{subscription-name}'];
					}
					if (!empty($_subscriber['{subscription-phone}'])) {
						if ($contact['home_phone'] != $_subscriber['{subscription-phone}']) {
							$update = true;
							$contact['home_phone'] = $_subscriber['{subscription-phone}'];
						}
					}
					if ($update) {
						$curl = curl_init('https://api.constantcontact.com/v2/contacts/'.$contact['id'].'?api_key='.rawurlencode($popup_options['constantcontact_api_key']).'&action_by=ACTION_BY_VISITOR');
						$header = array(
							'Content-Type: application/json',
							'Authorization: Bearer '.$popup_options['constantcontact_token']
						);
						curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
						curl_setopt($curl, CURLOPT_TIMEOUT, 10);
						curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
						//curl_setopt($curl, CURLOPT_FORBID_REUSE, 1);
						//curl_setopt($curl, CURLOPT_FRESH_CONNECT, 1);
						curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
						curl_setopt($curl, CURLOPT_POST, 1);
						curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($contact));
						curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
						curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
						$response = curl_exec($curl);
						curl_close($curl);
					}
				} else {
					$contact = array(
						'first_name' => $_subscriber['{subscription-name}'],
						'last_name' => '',
						'email_addresses' => array(
							array('email_address' => $_subscriber['{subscription-email}'])
						),
						'lists' => array(
							array(
								'id' => $popup_options['constantcontact_list_id']
							)
						)
					);
					if (!empty($_subscriber['{subscription-phone}'])) $contact['home_phone'] = $_subscriber['{subscription-phone}'];
					$curl = curl_init('https://api.constantcontact.com/v2/contacts?api_key='.rawurlencode($popup_options['constantcontact_api_key']).'&action_by=ACTION_BY_VISITOR');
					$header = array(
						'Content-Type: application/json',
						'Authorization: Bearer '.$popup_options['constantcontact_token']
					);
					curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
					curl_setopt($curl, CURLOPT_TIMEOUT, 10);
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
					//curl_setopt($curl, CURLOPT_FORBID_REUSE, 1);
					//curl_setopt($curl, CURLOPT_FRESH_CONNECT, 1);
					curl_setopt($curl, CURLOPT_POST, 1);
					curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($contact));
					curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
					curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
					$response = curl_exec($curl);
					curl_close($curl);
				}
			}
		}
	}
}
$ulp_constantcontact = new ulp_constantcontact_class();
?>