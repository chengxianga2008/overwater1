<?php
/* Benchmark Email integration for Layered Popups */
class ulp_benchmark_class {
	var $default_popup_options = array(
		'benchmark_enable' => 'off',
		'benchmark_api_key' => '',
		'benchmark_list_id' => '',
		'benchmark_double' => 'off'
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
				<h3>'.__('Benchmark Parameters', 'ulp').'</h3>
				<table class="ulp_useroptions">
					<tr>
						<th>'.__('Enable Benchmark', 'ulp').':</th>
						<td>
							<input type="checkbox" id="ulp_benchmark_enable" name="ulp_benchmark_enable" '.($popup_options['benchmark_enable'] == "on" ? 'checked="checked"' : '').'"> '.__('Submit contact details to Benchmark Email', 'ulp').'
							<br /><em>'.__('Please tick checkbox if you want to submit contact details to Benchmark Email.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('API Key', 'ulp').':</th>
						<td>
							<input type="text" id="ulp_benchmark_api_key" name="ulp_benchmark_api_key" value="'.esc_html($popup_options['benchmark_api_key']).'" class="widefat" onchange="ulp_benchmark_handler();">
							<br /><em>'.__('Enter your Benchmark Email API Key. You can get your API Key <a href="https://ui.benchmarkemail.com/EditSetting" target="_blank">here</a>.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('List ID', 'ulp').':</th>
						<td>
							<input type="text" id="ulp_benchmark_list_id" name="ulp_benchmark_list_id" value="'.esc_html($popup_options['benchmark_list_id']).'" class="widefat">
							<br /><em>'.__('Enter your List ID. You can get List ID from', 'ulp').' <a href="'.admin_url('admin.php').'?action=ulp-benchmark-lists&key='.base64_encode($popup_options['benchmark_api_key']).'" class="thickbox" id="ulp_benchmark_lists" title="'.__('Available Lists', 'ulp').'">'.__('this table', 'ulp').'</a>.</em>
							<script>
								function ulp_benchmark_handler() {
									jQuery("#ulp_benchmark_lists").attr("href", "'.admin_url('admin.php').'?action=ulp-benchmark-lists&key="+ulp_encode64(jQuery("#ulp_benchmark_api_key").val()));
								}
							</script>
						</td>
					</tr>
					<tr>
						<th>'.__('Double opt-in', 'ulp').':</th>
						<td>
							<input type="checkbox" id="ulp_benchmark_double" name="ulp_benchmark_double" '.($popup_options['benchmark_double'] == "on" ? 'checked="checked"' : '').'"> '.__('Ask users to confirm their subscription', 'ulp').'
							<br /><em>'.__('Control whether a double opt-in confirmation message is sent.', 'ulp').'</em>
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
		if (isset($_POST["ulp_benchmark_enable"])) $popup_options['benchmark_enable'] = "on";
		else $popup_options['benchmark_enable'] = "off";
		if ($popup_options['benchmark_enable'] == 'on') {
			if (empty($popup_options['benchmark_api_key'])) $errors[] = __('Invalid Benchmark Email API key', 'ulp');
			if (empty($popup_options['benchmark_list_id'])) $errors[] = __('Invalid Benchmark Email list ID', 'ulp');
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
		if (isset($_POST["ulp_benchmark_enable"])) $popup_options['benchmark_enable'] = "on";
		else $popup_options['benchmark_enable'] = "off";
		if (isset($_POST["ulp_benchmark_double"])) $popup_options['benchmark_double'] = "on";
		else $popup_options['benchmark_double'] = "off";
		return array_merge($_popup_options, $popup_options);
	}
	function admin_request_handler() {
		global $wpdb;
		if (!empty($_GET['action'])) {
			switch($_GET['action']) {
				case 'ulp-benchmark-lists':
					if (isset($_GET["key"])) {
						$key = base64_decode($_GET["key"]);
						
						$lists = $this->benchmark_getlists($key);
						if (!empty($lists)) {
							echo '
<html>
<head>
	<meta name="robots" content="noindex, nofollow, noarchive, nosnippet">
	<title>'.__('Benchmark Lists', 'ulp').'</title>
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
		if ($popup_options['benchmark_enable'] == 'on') {
			$request = http_build_query(array(
				'contacts' => array(
					'email' => $_subscriber['{subscription-email}'],
					'firstname' => $_subscriber['{subscription-name}'],
					'lastname' => ''),
				'optin' => ($popup_options['benchmark_double'] == 'on' ? 1 : 0),
				'listID' => $popup_options['benchmark_list_id'],
				'token' => $popup_options['benchmark_api_key']
			));

			$curl = curl_init('http://www.benchmarkemail.com/api/1.0/?output=php&method=listAddContacts');
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
	function benchmark_getlists($_key) {
		$request = http_build_query(array(
			'token' => $_key
		));

		$curl = curl_init('http://www.benchmarkemail.com/api/1.0/?output=php&method=listGet');
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
		if (!is_array($result) || isset($result['error'])) return array();
		$lists = array();
		foreach ($result as $key => $value) {
			$lists[$value['id']] = $value['listname'];
		}
		return $lists;
	}
}
$ulp_benchmark = new ulp_benchmark_class();
?>