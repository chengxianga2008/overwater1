<?php
/* MailChimp integration for Layered Popups */
class ulp_mailchimp_class {
	var $default_popup_options = array(
		"mailchimp_enable" => "off",
		"mailchimp_api_key" => "",
		"mailchimp_list_id" => "",
		"mailchimp_groups" => "",
		"mailchimp_fields" => "",
		"mailchimp_double" => "off",
		"mailchimp_welcome" => "off"
	);
	function __construct() {
		$this->default_popup_options['mailchimp_fields'] = serialize(array('EMAIL' => '{subscription-email}', 'FNAME' => '{subscription-name}', 'NAME' => '{subscription-name}'));
		if (is_admin()) {
			add_action('admin_init', array(&$this, 'admin_request_handler'));
			add_action('ulp_popup_options_show', array(&$this, 'popup_options_show'));
			add_action('ulp_subscribe', array(&$this, 'subscribe'), 10, 2);
			add_filter('ulp_popup_options_check', array(&$this, 'popup_options_check'), 10, 1);
			add_filter('ulp_popup_options_populate', array(&$this, 'popup_options_populate'), 10, 1);
			add_action('wp_ajax_ulp-mailchimp-groups', array(&$this, "show_groups"));
			add_action('wp_ajax_ulp-mailchimp-fields', array(&$this, "show_fields"));
		}
	}
	function popup_options_show($_popup_options) {
		$popup_options = array_merge($this->default_popup_options, $_popup_options);
		echo '
				<h3>'.__('MailChimp Parameters', 'ulp').'</h3>
				<table class="ulp_useroptions">
					<tr>
						<th>'.__('Enable MailChimp', 'ulp').':</th>
						<td>
							<input type="checkbox" id="ulp_mailchimp_enable" name="ulp_mailchimp_enable" '.($popup_options['mailchimp_enable'] == "on" ? 'checked="checked"' : '').'"> '.__('Submit contact details to MailChimp', 'ulp').'
							<br /><em>'.__('Please tick checkbox if you want to submit contact details to MailChimp.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('MailChimp API Key', 'ulp').':</th>
						<td>
							<input type="text" id="ulp_mailchimp_api_key" name="ulp_mailchimp_api_key" value="'.esc_html($popup_options['mailchimp_api_key']).'" class="widefat" onchange="ulp_mailchimp_lists(); ulp_mailchimp_fields(); ulp_mailchimp_groups();">
							<br /><em>'.__('Enter your MailChimp API Key. You can get it <a href="https://admin.mailchimp.com/account/api-key-popup" target="_blank">here</a>.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('List ID', 'ulp').':</th>
						<td>
							<input type="text" id="ulp_mailchimp_list_id" name="ulp_mailchimp_list_id" value="'.esc_html($popup_options['mailchimp_list_id']).'" class="widefat" onchange="ulp_mailchimp_fields(); ulp_mailchimp_groups();">
							<br /><em>'.__('Enter your List ID. You can get List ID from', 'ulp').' <a href="'.admin_url('admin.php').'?action=ulp-mailchimp-lists&key='.base64_encode($popup_options['mailchimp_api_key']).'" class="thickbox" id="ulp_mailchimp_lists" title="'.__('Available Lists', 'ulp').'">'.__('this table', 'ulp').'</a>.</em>
							<script>
								function ulp_mailchimp_lists() {
									jQuery("#ulp_mailchimp_lists").attr("href", "'.admin_url('admin.php').'?action=ulp-mailchimp-lists&key="+ulp_encode64(jQuery("#ulp_mailchimp_api_key").val()));
								}
							</script>
						</td>
					</tr>
					<tr>
						<th>'.__('Fields', 'ulp').':</th>
						<td style="vertical-align: middle;">
							<div class="ulp-mailchimp-fields-html">';
		if (!empty($popup_options['mailchimp_api_key']) && !empty($popup_options['mailchimp_list_id'])) {
			$fields = $this->get_fields_html($popup_options['mailchimp_api_key'], $popup_options['mailchimp_list_id'], $popup_options['mailchimp_fields']);
			echo $fields;
		}
		echo '
							</div>
							<a id="ulp_mailchimp_fields_button" class="ulp_button button-secondary" onclick="return ulp_mailchimp_loadfields();">'.__('Load Fields', 'ulp').'</a>
							<img class="ulp-loading" id="ulp-mailchimp-fields-loading" src="'.plugins_url('/images/loading.gif', dirname(__FILE__)).'">
							<br /><em>'.__('Click the button to (re)load fields list. Ignore if you do not need specify fields values.', 'ulp').'</em>
							<script>
								function ulp_mailchimp_loadfields() {
									jQuery("#ulp-mailchimp-fields-loading").fadeIn(350);
									jQuery(".ulp-mailchimp-fields-html").slideUp(350);
									var data = {action: "ulp-mailchimp-fields", ulp_key: jQuery("#ulp_mailchimp_api_key").val(), ulp_list: jQuery("#ulp_mailchimp_list_id").val()};
									jQuery.post("'.admin_url('admin-ajax.php').'", data, function(return_data) {
										jQuery("#ulp-mailchimp-fields-loading").fadeOut(350);
										try {
											var data = jQuery.parseJSON(return_data);
											var status = data.status;
											if (status == "OK") {
												jQuery(".ulp-mailchimp-fields-html").html(data.html);
												jQuery(".ulp-mailchimp-fields-html").slideDown(350);
											} else {
												jQuery(".ulp-mailchimp-fields-html").html("<div class=\'ulp-mailchimp-grouping\' style=\'margin-bottom: 10px;\'><strong>'.__('Internal error! Can not connect to MailChimp server.', 'ulp').'</strong></div>");
												jQuery(".ulp-mailchimp-fields-html").slideDown(350);
											}
										} catch(error) {
											jQuery(".ulp-mailchimp-fields-html").html("<div class=\'ulp-mailchimp-grouping\' style=\'margin-bottom: 10px;\'><strong>'.__('Internal error! Can not connect to MailChimp server.', 'ulp').'</strong></div>");
											jQuery(".ulp-mailchimp-fields-html").slideDown(350);
										}
									});
									return false;
								}
							</script>
						</td>
					</tr>
					<tr>
						<th>'.__('Groups', 'ulp').':</th>
						<td style="vertical-align: middle;">
							<div class="ulp-mailchimp-groups-html">';
		if (!empty($popup_options['mailchimp_api_key']) && !empty($popup_options['mailchimp_list_id'])) {
			$groups = $this->get_groups_html($popup_options['mailchimp_api_key'], $popup_options['mailchimp_list_id'], $popup_options['mailchimp_groups']);
			echo $groups;
		}
		echo '
							</div>
							<a id="ulp_mailchimp_groups_button" class="ulp_button button-secondary" onclick="return ulp_mailchimp_loadgroups();">'.__('Load Groups', 'ulp').'</a>
							<img class="ulp-loading" id="ulp-mailchimp-groups-loading" src="'.plugins_url('/images/loading.gif', dirname(__FILE__)).'">
							<br /><em>'.__('Click the button to (re)load groups of the list. Ignore if you do not use groups.', 'ulp').'</em>
							<script>
								function ulp_mailchimp_loadgroups() {
									jQuery("#ulp-mailchimp-groups-loading").fadeIn(350);
									jQuery(".ulp-mailchimp-groups-html").slideUp(350);
									var data = {action: "ulp-mailchimp-groups", ulp_key: jQuery("#ulp_mailchimp_api_key").val(), ulp_list: jQuery("#ulp_mailchimp_list_id").val()};
									jQuery.post("'.admin_url('admin-ajax.php').'", data, function(return_data) {
										jQuery("#ulp-mailchimp-groups-loading").fadeOut(350);
										try {
											var data = jQuery.parseJSON(return_data);
											var status = data.status;
											if (status == "OK") {
												jQuery(".ulp-mailchimp-groups-html").html(data.html);
												jQuery(".ulp-mailchimp-groups-html").slideDown(350);
											} else {
												jQuery(".ulp-mailchimp-groups-html").html("<div class=\'ulp-mailchimp-grouping\' style=\'margin-bottom: 10px;\'><strong>'.__('Internal error! Can not connect to MailChimp server.', 'ulp').'</strong></div>");
												jQuery(".ulp-mailchimp-groups-html").slideDown(350);
											}
										} catch(error) {
											jQuery(".ulp-mailchimp-groups-html").html("<div class=\'ulp-mailchimp-grouping\' style=\'margin-bottom: 10px;\'><strong>'.__('Internal error! Can not connect to MailChimp server.', 'ulp').'</strong></div>");
											jQuery(".ulp-mailchimp-groups-html").slideDown(350);
										}
									});
									return false;
								}
							</script>
						</td>
					</tr>
					<tr>
						<th>'.__('Double opt-in', 'ulp').':</th>
						<td>
							<input type="checkbox" id="ulp_mailchimp_double" name="ulp_mailchimp_double" '.($popup_options['mailchimp_double'] == "on" ? 'checked="checked"' : '').'"> '.__('Ask users to confirm their subscription', 'ulp').'
							<br /><em>'.__('Control whether a double opt-in confirmation message is sent.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('Send Welcome', 'ulp').':</th>
						<td>
							<input type="checkbox" id="ulp_mailchimp_welcome" name="ulp_mailchimp_welcome" '.($popup_options['mailchimp_welcome'] == "on" ? 'checked="checked"' : '').'"> '.__('Send Lists Welcome message', 'ulp').'
							<br /><em>'.__('If your <strong>Double opt-in</strong> is disabled and this is enabled, MailChimp will send your lists Welcome Email if this subscribe succeeds. If <strong>Double opt-in</strong> is enabled, this has no effect.', 'ulp').'</em>
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
		if (isset($_POST["ulp_mailchimp_enable"])) $popup_options['mailchimp_enable'] = "on";
		else $popup_options['mailchimp_enable'] = "off";
		if ($popup_options['mailchimp_enable'] == 'on') {
			if (empty($popup_options['mailchimp_api_key']) || strpos($popup_options['mailchimp_api_key'], '-') === false) $errors[] = __('Invalid MailChimp API Key.', 'ulp');
			if (empty($popup_options['mailchimp_list_id'])) $errors[] = __('Invalid MailChimp List ID.', 'ulp');
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
		if (isset($_POST["ulp_mailchimp_double"])) $popup_options['mailchimp_double'] = "on";
		else $popup_options['mailchimp_double'] = "off";
		if (isset($_POST["ulp_mailchimp_welcome"])) $popup_options['mailchimp_welcome'] = "on";
		else $popup_options['mailchimp_welcome'] = "off";
		if (isset($_POST["ulp_mailchimp_enable"])) $popup_options['mailchimp_enable'] = "on";
		else $popup_options['mailchimp_enable'] = "off";
		
		$groups = array();
		foreach($_POST as $key => $value) {
			if (substr($key, 0, strlen('ulp_mailchimp_group_')) == 'ulp_mailchimp_group_') {
				$groups[] = substr($key, strlen('ulp_mailchimp_group_'));
			}
		}
		$popup_options['mailchimp_groups'] = implode(':', $groups);

		$fields = array();
		foreach($_POST as $key => $value) {
			if (substr($key, 0, strlen('ulp_mailchimp_field_')) == 'ulp_mailchimp_field_') {
				$field = substr($key, strlen('ulp_mailchimp_field_'));
				$fields[$field] = stripslashes(trim($value));
			}
		}
		$popup_options['mailchimp_fields'] = serialize($fields);
		
		return array_merge($_popup_options, $popup_options);
	}
	function admin_request_handler() {
		global $wpdb;
		if (!empty($_GET['action'])) {
			switch($_GET['action']) {
				case 'ulp-mailchimp-lists':
					if (isset($_GET["key"])) {
						$key = base64_decode($_GET["key"]);
						$dc = "us1";
						if (strstr($key, "-")) {
							list($key, $dc) = explode("-", $key, 2);
							if (!$dc) $dc = "us1";
						}
						$mailchimp_url = 'https://'.$dc.'.api.mailchimp.com/2.0/lists/list.json';
						$data = array(
							'apikey' => $key
						);
						$request = json_encode($data);
						$lists = array();
						try {
							$curl = curl_init($mailchimp_url);
							curl_setopt($curl, CURLOPT_POST, 1);
							curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
							curl_setopt($curl, CURLOPT_TIMEOUT, 10);
							curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
							curl_setopt($curl, CURLOPT_FORBID_REUSE, 1);
							curl_setopt($curl, CURLOPT_FRESH_CONNECT, 1);
							//curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
							curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
							curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
												
							$response = curl_exec($curl);
							curl_close($curl);
							$result = json_decode($response, true);
							if($result && intval($result['total']) > 0) {
								foreach ($result['data'] as $list) {
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
	<title>'.__('MailChimp Lists', 'ulp').'</title>
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
		if ($popup_options['mailchimp_enable'] == 'on') {
			
			$groups = array();
			$groups_tmp = array();
			if (!empty($popup_options['mailchimp_groups'])) {
				$groups_marked = explode(':', $popup_options['mailchimp_groups']);
				foreach($groups_marked as $value) {
					$grouping = '';
					$group = '';
					list($grouping, $group) = explode("-", $value, 2);
					if (!empty($grouping) && !empty($group)) {
						$groups_tmp[$grouping][] = $group;
					}
				}
				$result = $this->get_groups($popup_options['mailchimp_api_key'], $popup_options['mailchimp_list_id']);
				if ($result && !array_key_exists('status', $result)) {
					foreach ($result as $grouping) {
						foreach ($grouping['groups'] as $group) {
							if (array_key_exists($grouping['id'], $groups_tmp)) {
								if (in_array($group['id'], $groups_tmp[$grouping['id']])) {
									$groups[$grouping['id']][] = $group['name'];
								}
							}
						}
					}
				}
			}
			
			$dc = "us1";
			if (strstr($popup_options['mailchimp_api_key'], "-")) {
				list($key, $dc) = explode("-", $popup_options['mailchimp_api_key'], 2);
				if (!$dc) $dc = "us1";
			}
			$mailchimp_url = 'https://'.$dc.'.api.mailchimp.com/2.0/lists/subscribe.json';
			$data = array(
				'apikey' => $popup_options['mailchimp_api_key'],
				'id' => $popup_options['mailchimp_list_id'],
				'email' => array('email' => $_subscriber['{subscription-email}']),
				'merge_vars' => array(
					'optin_ip' => $_SERVER['REMOTE_ADDR'],
				),
				'replace_interests' => false,
				'double_optin' => ($popup_options['mailchimp_double'] == 'on' ? true : false),
				'send_welcome' => ($popup_options['mailchimp_welcome'] == 'on' ? true : false),
				'update_existing' => true
			);
			
			$fields = array();
			if (!empty($popup_options['mailchimp_fields'])) $fields = unserialize($popup_options['mailchimp_fields']);
			if (!empty($fields) && is_array($fields)) {
				foreach ($fields as $key => $value) {
					if (!empty($value)) {
						$data['merge_vars'][$key] = strtr($value, $_subscriber);
					}
				}
			}
			
			if (!empty($groups)) {
				foreach ($groups as $grouping => $grouping_groups) {
					$data['merge_vars']['groupings'][] = array('id' => $grouping, 'groups' => $grouping_groups);
				}
			}
			$request = json_encode($data);

			try {
				$curl = curl_init($mailchimp_url);
				curl_setopt($curl, CURLOPT_POST, 1);
				curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
				curl_setopt($curl, CURLOPT_TIMEOUT, 10);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($curl, CURLOPT_FORBID_REUSE, 1);
				curl_setopt($curl, CURLOPT_FRESH_CONNECT, 1);
				//curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
				curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
												
				$response = curl_exec($curl);
				curl_close($curl);
			} catch (Exception $e) {
			}
		}
	}
	function show_groups() {
		global $wpdb;
		if (current_user_can('manage_options')) {
			if (!isset($_POST['ulp_key']) || !isset($_POST['ulp_list']) || empty($_POST['ulp_key']) || empty($_POST['ulp_list'])) exit;
			$key = trim(stripslashes($_POST['ulp_key']));
			$list = trim(stripslashes($_POST['ulp_list']));
			$return_object = array();
			$return_object['status'] = 'OK';
			$return_object['html'] = $this->get_groups_html($key, $list, '');
			echo json_encode($return_object);
		}
		exit;
	}
	function get_groups_html($_key, $_list, $_groups) {
		$result = $this->get_groups($_key, $_list);
		$groups = '';
		$groups_marked = explode(':', $_groups);
		if (!empty($result)) {
			if (array_key_exists('status', $result) && $result['status'] == 'error') {
				$groups = '<div class="ulp-mailchimp-grouping" style="margin-bottom: 10px;"><strong>'.$result['error'].'</strong></div>';
			} else {
				foreach ($result as $grouping) {
					$groups .= '<div class="ulp-mailchimp-grouping" style="margin-bottom: 10px;"><strong>'.$grouping['name'].'</strong>';
					foreach ($grouping['groups'] as $group) {
						$groups .= '<div class="ulp-mailchimp-group" style="margin: 1px 0 1px 10px;"><input type="checkbox" name="ulp_mailchimp_group_'.$grouping['id'].'-'.$group['id'].'"'.(in_array($grouping['id'].'-'.$group['id'], $groups_marked) ? ' checked="checked"' : '').' /> '.$group['name'].'</div>';
					}
					$groups .= '</div>';
				}
			}
		} else {
			$groups = '<div class="ulp-mailchimp-grouping" style="margin-bottom: 10px;"><strong>'.__('No groups found.', 'ulp').'</strong></div>';
		}
		return $groups;
	}
	function get_groups($_key, $_list) {
		$result = array();
		$dc = "us1";
		if (strstr($_key, "-")) {
			list($key, $dc) = explode("-", $_key, 2);
			if (!$dc) $dc = "us1";
		}
		$mailchimp_url = 'https://'.$dc.'.api.mailchimp.com/2.0/lists/interest-groupings.json';
		$data = array(
			'apikey' => $_key,
			'id' => $_list
		);
		$request = json_encode($data);
		try {
			$curl = curl_init($mailchimp_url);
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
			curl_setopt($curl, CURLOPT_TIMEOUT, 10);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_FORBID_REUSE, 1);
			curl_setopt($curl, CURLOPT_FRESH_CONNECT, 1);
			//curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

			$response = curl_exec($curl);
			curl_close($curl);
			$result = json_decode($response, true);
		} catch (Exception $e) {
		}
		return $result;
	}
	function show_fields() {
		global $wpdb;
		if (current_user_can('manage_options')) {
			if (!isset($_POST['ulp_key']) || !isset($_POST['ulp_list']) || empty($_POST['ulp_key']) || empty($_POST['ulp_list'])) exit;
			$key = trim(stripslashes($_POST['ulp_key']));
			$list = trim(stripslashes($_POST['ulp_list']));
			$return_object = array();
			$return_object['status'] = 'OK';
			$return_object['html'] = $this->get_fields_html($key, $list, $this->default_popup_options['mailchimp_fields']);
			echo json_encode($return_object);
		}
		exit;
	}
	function get_fields_html($_key, $_list, $_fields) {
		$result = $this->get_fields($_key, $_list);
		$fields = '';
		$values = unserialize($_fields);
		if (!is_array($values)) $values = array();
		if (!empty($result)) {
			if (array_key_exists('status', $result) && $result['status'] == 'error') {
				$fields = '<div class="ulp-mailchimp-grouping" style="margin-bottom: 10px;"><strong>'.$result['error'].'</strong></div>';
			} else {
				if (isset($result['success_count'])) {
					$fields = '
			'.__('Please adjust the fields below. You can use the same shortcodes (<code>{subscription-email}</code>, <code>{subscription-name}</code>, etc.) to associate MailChimp fields with the popup fields.', 'ulp').'
			<table style="min-width: 280px; width: 50%;">';
					foreach ($result['data'][0]['merge_vars'] as $field) {
						if (is_array($field)) {
							if (array_key_exists('tag', $field) && array_key_exists('name', $field)) {
								$fields .= '
				<tr>
					<td style="width: 100px;"><strong>'.esc_html($field['tag']).':</strong></td>
					<td>
						<input type="text" id="ulp_mailchimp_field_'.esc_html($field['tag']).'" name="ulp_mailchimp_field_'.esc_html($field['tag']).'" value="'.esc_html(array_key_exists($field['tag'], $values) ? $values[$field['tag']] : '').'" class="widefat"'.($field['tag'] == 'EMAIL' ? ' readonly="readonly"' : '').' />
						<br /><em>'.esc_html($field['name']).'</em>
					</td>
				</tr>';
							}
						}
					}
					$fields .= '
			</table>';
				} else {
					$fields = '<div class="ulp-mailchimp-grouping" style="margin-bottom: 10px;"><strong>'.__('No fields found.', 'ulp').'</strong></div>';
				}
			}
		} else {
			$fields = '<div class="ulp-mailchimp-grouping" style="margin-bottom: 10px;"><strong>'.__('No fields found.', 'ulp').'</strong></div>';
		}
		return $fields;
	}
	function get_fields($_key, $_list) {
		$dc = "us1";
		if (strstr($_key, "-")) {
			list($_key, $dc) = explode("-", $_key, 2);
			if (!$dc) $dc = "us1";
		}
		$mailchimp_url = 'https://'.$dc.'.api.mailchimp.com/2.0/lists/merge-vars.json';
		$data = array(
			'apikey' => $_key,
			'id' => array($_list)
		);
		$request = json_encode($data);
		$result = array();
		$fields = array();
		try {
			$curl = curl_init($mailchimp_url);
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
			curl_setopt($curl, CURLOPT_TIMEOUT, 10);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_FORBID_REUSE, 1);
			curl_setopt($curl, CURLOPT_FRESH_CONNECT, 1);
			//curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

			$response = curl_exec($curl);
			curl_close($curl);
			$result = json_decode($response, true);
		} catch (Exception $e) {
		}
		return $result;
	}
}
$ulp_mailchimp = new ulp_mailchimp_class();
?>