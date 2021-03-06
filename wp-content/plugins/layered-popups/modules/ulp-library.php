<?php
/* Popups Library for Layered Popups */
define('ULP_LIBRARY_URL', 'http://layeredpopups.com/library/');
class ulp_library_class {
	function __construct() {
		if (is_admin()) {
			add_action('ulp_admin_menu', array(&$this, 'admin_menu'));
			add_action('admin_init', array(&$this, 'admin_request_handler'));
			add_action('ulp_options_show', array(&$this, 'options_show'));
			add_action('wp_ajax_ulp_library_clear_cache', array(&$this, "clear_cache"));
		}
	}
	function admin_menu() {
		add_submenu_page(
			"ulp"
			, __('Popups Library', 'ulp')
			, __('Popups Library', 'ulp')
			, "add_users"
			, "ulp-library"
			, array(&$this, 'admin_library')
		);
	}
	function options_show() {
		echo '
			<h3>'.__('Popups Library', 'ulp').' <span class="ulp-badge ulp-badge-beta">Beta</span></h3>
			<table class="ulp_useroptions">
				<tr>
					<th>'.__('Cache', 'ulp').':</th>
					<td>
						<input type="button" class="ulp_button button-secondary" value="'.__('Clear Library Cache', 'ulp').'" onclick="return ulp_library_clear_cache();" >
						<img id="ulp-library-loading" class="ulp-loading" src="'.plugins_url('/images/loading.gif', dirname(__FILE__)).'">
						<br /><em>'.__('Click the button to clear Popups Library cache.', 'ulp').'</em>
					</td>
				</tr>
			</table>
			<script>
				function ulp_library_clear_cache() {
					jQuery("#ulp-library-loading").fadeIn(350);
					var data = {action: "ulp_library_clear_cache"};
					jQuery.post(ulp_ajax_handler, data, function(data) {
						jQuery("#ulp-library-loading").fadeOut(350);
					});
					return false;
				}			
			</script>';
		
	}
	function clear_cache() {
		if (current_user_can('manage_options')) {
			$upload_dir = wp_upload_dir();
			$cache_dir = $upload_dir["basedir"].'/'.ULP_UPLOADS_DIR.'/temp';
			$files = array_diff(scandir($cache_dir), array('.','..')); 
			foreach ($files as $file) { 
				if (is_file($cache_dir.'/'.$file) && substr($file, 0, 6) == 'cache-') {
					unlink($cache_dir.'/'.$file);
				}
			}
			echo 'OK';
		}
		exit;
	}
	function admin_library() {
		global $wpdb, $ulp;
		$url = trailingslashit(ULP_LIBRARY_URL).'get-items/';
		$items = array();
		$upload_dir = wp_upload_dir();
		$cache_file = $upload_dir["basedir"].'/'.ULP_UPLOADS_DIR.'/temp/cache-'.md5($url).'.txt';
		if (file_exists($cache_file)) {
			if (filemtime($cache_file)+3600*12 > time()) {
				$cached = file_get_contents($cache_file);
				$items_tmp = unserialize($cached);
				if ($items_tmp === false) unlink($cache_file);
				else $items = $items_tmp;
			}
		}
		if (empty($items)) {
			try {
				$curl = curl_init($url);
				curl_setopt($curl, CURLOPT_TIMEOUT, 10);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($curl, CURLOPT_FORBID_REUSE, 1);
				curl_setopt($curl, CURLOPT_FRESH_CONNECT, 1);
				curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2049.0 Safari/537.36');
				//curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
				$response = curl_exec($curl);
				curl_close($curl);
													
				$result = json_decode($response, true);
				if($result && is_array($result) && !empty($result)) {
					$items = $result;
					file_put_contents($cache_file, serialize($items));
				}
			} catch (Exception $e) {
			}
		}
		if (!empty($ulp->error)) $message = "<div class='error'><p>".$ulp->error."</p></div>";
		else if (!empty($ulp->info)) $message = "<div class='updated'><p>".$ulp->info."</p></div>";
		else if (empty($items)) $message = '<div class="error"><p>'.__('The library is currently <strong>not available</strong>. Please try again later.', 'ulp').'</p></div>';
		else $message = '';
		echo '
		<div class="wrap ulp">
			<div id="icon-edit-pages" class="icon32"><br /></div><h2>'.__('Layered Popups - Library', 'ulp').'</h2>
			'.$message.'
			<div class="ulp-options" style="margin-top: 20px;">';
		foreach($items as $item) {
			echo '
				<div class="ulp-library-item-box">
					<img class="item-thumbnail" src="'.$item['image'].'" alt="Item #'.$item['id'].'" />
					<div class="ulp-library-item-box-hover">
						<div style="margin-top: 100px; text-align: center;">
							<a href="'.admin_url('admin.php').'?action=ulp-import-library&id='.$item['id'].'&key='.$item['key'].'&ac='.$ulp->random_string().'" class="button-secondary ulp-button">'.__('Download and import popup', 'ulp').'</a>
						</div>
					</div>
					<div class="ulp-library-label"># '.$item['id'].'</div>
				</div>';
		}
		echo '
			</div>
		</div>';
	}
	function admin_request_handler() {
		global $wpdb, $ulp;
		if (!empty($_GET['action'])) {
			switch($_GET['action']) {
				case 'ulp-import-library':
					if (!isset($_GET['id']) || !isset($_GET['key'])) {
						setcookie("ulp_error", __('<strong>Invalid</strong> URL.', 'ulp'), time()+30, "/", ".".str_replace("www.", "", $_SERVER["SERVER_NAME"]));
						header('Location: '.admin_url('admin.php').'?page=ulp-library');
						exit;
					}
					$purchase_code = preg_replace('#([a-z0-9]{8})-?([a-z0-9]{4})-?([a-z0-9]{4})-?([a-z0-9]{4})-?([a-z0-9]{12})#', '$1-$2-$3-$4-$5', strtolower($ulp->options['purchase_code']));
					if (strlen($purchase_code) != 36) {
						setcookie("ulp_error", __('<strong>Invalid</strong> Item Purchase Code. Please make sure that you set correct Item Purchse Code on Settings page.', 'ulp'), time()+30, "/", ".".str_replace("www.", "", $_SERVER["SERVER_NAME"]));
						header('Location: '.admin_url('admin.php').'?page=ulp-library');
						exit;
					}
					$key = preg_replace('/[^a-zA-Z0-9-]/', '', $_GET['key']);
					$human_id = preg_replace('/[^a-zA-Z0-9-]/', '', $_GET['id']);
					$upload_dir = wp_upload_dir();
					$zip_file = $upload_dir["basedir"].'/'.ULP_UPLOADS_DIR.'/temp/cache-'.$key.'.zip';
					$use_cache = false;
					if (file_exists($zip_file)) {
						if (filemtime($zip_file)+3600*24 > time()) {
							$use_cache = true;
						}
					}
					if (!$use_cache) {
						$request = http_build_query(array(
							'purchase_code' => $ulp->options['purchase_code'],
							'website' => get_bloginfo('wpurl'),
							'item' => $key
						));
						try {
							$url = trailingslashit(ULP_LIBRARY_URL).'download/';
							$curl = curl_init($url);
							curl_setopt($curl, CURLOPT_TIMEOUT, 10);
							curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
							curl_setopt($curl, CURLOPT_FORBID_REUSE, 1);
							curl_setopt($curl, CURLOPT_FRESH_CONNECT, 1);
							curl_setopt($curl, CURLOPT_POST, 1);
							curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
							curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2049.0 Safari/537.36');
							//curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
							$response = curl_exec($curl);
							if (curl_error($curl)) {
								setcookie("ulp_error", curl_error($curl), time()+30, "/", ".".str_replace("www.", "", $_SERVER["SERVER_NAME"]));
								curl_close($curl);
								header('Location: '.admin_url('admin.php').'?page=ulp-library');
								exit;
							}
							$http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
							curl_close($curl);
							if ($http_code != '200') {
								$result = json_decode($response, true);
								if($result && is_array($result) && !empty($result)) {
									setcookie("ulp_error", $result['message'], time()+30, "/", ".".str_replace("www.", "", $_SERVER["SERVER_NAME"]));
									header('Location: '.admin_url('admin.php').'?page=ulp-library');
									exit;
								} else {
									setcookie("ulp_error", __('<strong>Can not download</strong> desired item.', 'ulp'), time()+30, "/", ".".str_replace("www.", "", $_SERVER["SERVER_NAME"]));
									header('Location: '.admin_url('admin.php').'?page=ulp-library');
									exit;
								}
							}
							$result = file_put_contents($zip_file, $response);
							if ($result === false) {
								setcookie("ulp_error", __('<strong>Can not save</strong> file in temp directory. Please re-activate the plugin and make sure that the following directory exists and writable: ', 'ulp').' '.$upload_dir["basedir"].'/'.ULP_UPLOADS_DIR.'/temp/.', time()+30, "/", ".".str_replace("www.", "", $_SERVER["SERVER_NAME"]));
								header('Location: '.admin_url('admin.php').'?page=ulp-library');
								exit;
							}
						} catch (Exception $e) {
						}
					}
					$result = $ulp->import_zip($zip_file, 'Popup # '.$human_id);
					if (is_wp_error($result)) {
						setcookie("ulp_error", $result->get_error_message(), time()+30, "/", ".".str_replace("www.", "", $_SERVER["SERVER_NAME"]));
						header('Location: '.admin_url('admin.php').'?page=ulp-library');
						exit;
					}
					setcookie("ulp_info", __('Item', 'ulp').' # '.$human_id.' '.__('<strong>successfully imported</strong> from library and marked as "blocked". Do not forget to unblock it.', 'ulp'), time()+30, "/", ".".str_replace("www.", "", $_SERVER["SERVER_NAME"]));
					header('Location: '.admin_url('admin.php').'?page=ulp');
					exit;
					break;
				default:
					break;
			}
		}
	}
}
$ulp_library = new ulp_library_class();
?>