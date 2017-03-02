<?php
/* MyMail integration for Layered Popups */
class ulp_mymail_class {
	var $default_popup_options = array(
		'mymail_enable' => "off",
		'mymail_listid' => "",
		'mymail_double' => "off"
	);
	function __construct() {
		if (is_admin()) {
			add_action('ulp_popup_options_show', array(&$this, 'popup_options_show'));
			add_action('ulp_subscribe', array(&$this, 'subscribe'), 10, 2);
			add_filter('ulp_popup_options_check', array(&$this, 'popup_options_check'), 10, 1);
			add_filter('ulp_popup_options_populate', array(&$this, 'popup_options_populate'), 10, 1);
		}
	}
	function popup_options_show($_popup_options) {
		$popup_options = array_merge($this->default_popup_options, $_popup_options);
		echo '
				<h3>'.__('MyMail Parameters', 'ulp').'</h3>
				<table class="ulp_useroptions">';
		if (function_exists('mymail_subscribe') || function_exists('mymail')) {
			if (function_exists('mymail')) {
				$lists = mymail('lists')->get();
				$create_list_url = 'edit.php?post_type=newsletter&page=mymail_lists';
			} else {
				$lists = get_terms('newsletter_lists', array('hide_empty' => false));
				$create_list_url = 'edit-tags.php?taxonomy=newsletter_lists&post_type=newsletter';
			}
			if (sizeof($lists) == 0) {
				echo '
					<tr>
						<th>'.__('Enable MyMail', 'ulp').':</th>
						<td>'.__('Please', 'ulp').' <a href="'.$create_list_url.'">'.__('create', 'ulp').'</a> '.__('at least one list.', 'ulp').'</td>
					</tr>';
			} else {
				echo '
					<tr>
						<th>'.__('Enable MyMail', 'ulp').':</th>
						<td>
							<input type="checkbox" id="ulp_mymail_enable" name="ulp_mymail_enable" '.($popup_options['mymail_enable'] == "on" ? 'checked="checked"' : '').'"> '.__('Submit contact details to MyMail', 'ulp').'
							<br /><em>'.__('Please tick checkbox if you want to submit contact details to MyMail.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('List ID', 'ulp').':</th>
						<td>
							<select name="ulp_mymail_listid" class="ic_input_m">';
				foreach ($lists as $list) {
					if (function_exists('mymail')) $id = $list->ID;
					else $id = $list->term_id;
					echo '
								<option value="'.$id.'"'.($id == $popup_options['mymail_listid'] ? ' selected="selected"' : '').'>'.$list->name.'</option>';
				}
				echo '
							</select>
							<br /><em>'.__('Select your List ID.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('Double Opt-In', 'ulp').':</th>
						<td>
							<input type="checkbox" id="ulp_mymail_double" name="ulp_mymail_double" '.($popup_options['mymail_double'] == "on" ? 'checked="checked"' : '').'"> '.__('Enable Double Opt-In', 'ulp').'
							<br /><em>'.__('Please tick checkbox if you want to enable double opt-in feature.', 'ulp').'</em>
						</td>
					</tr>';
			}
		} else {
			echo '
					<tr>
						<th>'.__('Enable MyMail', 'ulp').':</th>
						<td>'.__('Please install and activate <a target="_blank" href="http://codecanyon.net/item/mymail-email-newsletter-plugin-for-wordpress/3078294?ref=ichurakov">MyMail</a> plugin.', 'ulp').'</td>
					</tr>';
		
		}
		echo '
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
		if (isset($_POST["ulp_mymail_enable"])) $popup_options['mymail_enable'] = "on";
		else $popup_options['mymail_enable'] = "off";
		if (isset($_POST["ulp_mymail_double"])) $popup_options['mymail_double'] = "on";
		else $popup_options['mymail_double'] = "off";
		if ($popup_options['mymail_enable'] == 'on') {
			if (empty($popup_options['mymail_listid'])) $errors[] = __('Invalid MyMail List ID.', 'ulp');
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
		if (isset($_POST["ulp_mymail_enable"])) $popup_options['mymail_enable'] = "on";
		else $popup_options['mymail_enable'] = "off";
		if (isset($_POST["ulp_mymail_double"])) $popup_options['mymail_double'] = "on";
		else $popup_options['mymail_double'] = "off";
		return array_merge($_popup_options, $popup_options);
	}
	function subscribe($_popup_options, $_subscriber) {
		$popup_options = array_merge($this->default_popup_options, $_popup_options);
		if (function_exists('mymail_subscribe') || function_exists('mymail')) {
			if ($popup_options['mymail_enable'] == 'on') {
				if (function_exists('mymail')) {
					$list = mymail('lists')->get($popup_options['mymail_listid']);
				} else {
					$list = get_term_by('id', $popup_options['mymail_listid'], 'newsletter_lists');
				}
				if (!empty($list)) {
					try {
						if ($popup_options['mymail_double'] == "on") $double = true;
						else $double = false;
						if (function_exists('mymail')) {
							$entry = array(
								'firstname' => $_subscriber['{subscription-name}'],
								'email' => $_subscriber['{subscription-email}'],
								'status' => $double ? 0 : 1,
								'ip' => $_SERVER['REMOTE_ADDR'],
								'signup_ip' => $_SERVER['REMOTE_ADDR'],
								'referer' => $_SERVER['HTTP_REFERER'],
								'signup' =>time()
							);
							$subscriber_id = mymail('subscribers')->add($entry, true);
							if (is_wp_error( $subscriber_id )) return;
							$result = mymail('subscribers')->assign_lists($subscriber_id, array($list->ID));
						} else {
							$result = mymail_subscribe($_subscriber['{subscription-email}'], array('firstname' => $_subscriber['{subscription-name}']), array($list->slug), $double);
						}
					} catch (Exception $e) {
					}
				}
			}
		}
	}
}
$ulp_mymail = new ulp_mymail_class();
?>