<?php
/* Active Campaign integration for Layered Popups */
class ulp_activecampaign_class {
	var $default_popup_options = array(
		'activecampaign_enable' => 'off',
		'activecampaign_url' => '',
		'activecampaign_api_key' => '',
		'activecampaign_list_id' => ''
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
				<h3>'.__('Active Campaign Parameters', 'ulp').'</h3>
				<table class="ulp_useroptions">
					<tr>
						<th>'.__('Enable ActiveCampaign', 'ulp').':</th>
						<td>
							<input type="checkbox" id="ulp_activecampaign_enable" name="ulp_activecampaign_enable" '.($popup_options['activecampaign_enable'] == "on" ? 'checked="checked"' : '').'"> '.__('Submit contact details to ActiveCampaign', 'ulp').'
							<br /><em>'.__('Please tick checkbox if you want to submit contact details to ActiveCampaign.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('API URL', 'ulp').':</th>
						<td>
							<input type="text" id="ulp_activecampaign_url" name="ulp_activecampaign_url" value="'.esc_html($popup_options['activecampaign_url']).'" class="widefat" onchange="ulp_activecampaign_handler();">
							<br /><em>'.__('Enter your ActiveCampaign API URL. To get API URL please go to your ActiveCampaign Account >> Integration >> ActiveCampaign API.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('API Key', 'ulp').':</th>
						<td>
							<input type="text" id="ulp_activecampaign_api_key" name="ulp_activecampaign_api_key" value="'.esc_html($popup_options['activecampaign_api_key']).'" class="widefat" onchange="ulp_activecampaign_handler();">
							<br /><em>'.__('Enter your ActiveCampaign API Key. To get API Key please go to your ActiveCampaign Account >> Integration >> ActiveCampaign API.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('List ID', 'ulp').':</th>
						<td>
							<input type="text" id="ulp_activecampaign_list_id" name="ulp_activecampaign_list_id" value="'.esc_html($popup_options['activecampaign_list_id']).'" class="widefat">
							<br /><em>'.__('Enter your List ID. You can get List ID from', 'ulp').' <a href="'.admin_url('admin.php').'?action=ulp-activecampaign-lists&url='.base64_encode($popup_options['activecampaign_url']).'&key='.base64_encode($popup_options['activecampaign_api_key']).'" class="thickbox" id="ulp_activecampaign_lists" title="'.__('Available Lists', 'ulp').'">'.__('this table', 'ulp').'</a>.</em>
							<script>
								function ulp_activecampaign_handler() {
									jQuery("#ulp_activecampaign_lists").attr("href", "'.admin_url('admin.php').'?action=ulp-activecampaign-lists&url="+ulp_encode64(jQuery("#ulp_activecampaign_url").val())+"&key="+ulp_encode64(jQuery("#ulp_activecampaign_api_key").val()));
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
		if (isset($_POST["ulp_activecampaign_enable"])) $popup_options['activecampaign_enable'] = "on";
		else $popup_options['activecampaign_enable'] = "off";
		if ($popup_options['activecampaign_enable'] == 'on') {
			if (strlen($popup_options['activecampaign_url']) == 0 || !preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $popup_options['activecampaign_url'])) $errors[] = __('ActiveCampaign API URL must be a valid URL.', 'ulp');
			if (empty($popup_options['activecampaign_api_key'])) $errors[] = __('Invalid ActiveCampaign API key', 'ulp');
			if (empty($popup_options['activecampaign_list_id'])) $errors[] = __('Invalid ActiveCampaign list ID', 'ulp');
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
		if (isset($_POST["ulp_activecampaign_enable"])) $popup_options['activecampaign_enable'] = "on";
		else $popup_options['activecampaign_enable'] = "off";
		return array_merge($_popup_options, $popup_options);
	}
	function admin_request_handler() {
		global $wpdb;
		if (!empty($_GET['action'])) {
			switch($_GET['action']) {
				case 'ulp-activecampaign-lists':
					if (isset($_GET["url"]) && isset($_GET["key"])) {
						$url = base64_decode($_GET["url"]);
						$url = rtrim($url, '/');
						$key = base64_decode($_GET["key"]);
						
						$lists = $this->activecampaign_getlists($url, $key);
						if (!empty($lists)) {
							echo '
<html>
<head>
	<meta name="robots" content="noindex, nofollow, noarchive, nosnippet">
	<title>'.__('ActiveCampaign Lists', 'ulp').'</title>
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
		if ($popup_options['activecampaign_enable'] == 'on') {
			$request = http_build_query(array(
				'api_action' => 'contact_add',
				'api_key' => $popup_options['activecampaign_api_key'],
				'api_output' => 'serialize',
				'p['.$popup_options['activecampaign_list_id'].']' => $popup_options['activecampaign_list_id'],
				'email' => $_subscriber['{subscription-email}'],
				'first_name' => $_subscriber['{subscription-name}'],
				'ip4' => $_SERVER['REMOTE_ADDR']
			));

			$url = str_replace('https://', 'http://', $popup_options['activecampaign_url']);
			$curl = curl_init($url.'/admin/api.php?api_action=contact_add');
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
			curl_setopt($curl, CURLOPT_TIMEOUT, 20);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_FORBID_REUSE, 1);
			curl_setopt($curl, CURLOPT_FRESH_CONNECT, 1);
			curl_setopt($curl, CURLOPT_HEADER, 0);
			$response = curl_exec($curl);
			curl_close($curl);
		}
	}
	function activecampaign_getlists($_url, $_key) {
		$request = http_build_query(array(
			'api_action' => 'list_list',
			'api_key' => $_key,
			'api_output' => 'serialize',
			'ids' => 'all'
		));

		$_url = str_replace('https://', 'http://', $_url);
		$curl = curl_init($_url.'/admin/api.php?api_action=list_list');
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
		curl_setopt($curl, CURLOPT_TIMEOUT, 20);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_FORBID_REUSE, 1);
		curl_setopt($curl, CURLOPT_FRESH_CONNECT, 1);
		curl_setopt($curl, CURLOPT_HEADER, 0);
								
		$response = curl_exec($curl);
		
		curl_close($curl);
		$result = unserialize($response);
		if (!is_array($result) || (isset($result['result_code']) && $result['result_code'] != 1)) return array();
		$lists = array();
		foreach ($result as $key => $value) {
			if (is_array($value)) {
				$lists[$value['id']] = $value['name'];
			}
		}
		return $lists;
	}
}
$ulp_activecampaign = new ulp_activecampaign_class();
?>