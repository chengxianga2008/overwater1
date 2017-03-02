<?php
/*
Plugin Name: Layered Popups
Plugin URI: https://layeredpopups.com/
Description: Create multi-layers animated popups.
Version: 4.60
Author: Halfdata, Inc.
Author URI: http://codecanyon.net/user/halfdata?ref=halfdata
*/
define('ULP_RECORDS_PER_PAGE', '50');
define('ULP_VERSION', 4.60);
define('ULP_EXPORT_VERSION', '0001');
define('ULP_API_URL', 'https://halfdata.com/updates/');
define('ULP_UPLOADS_DIR', 'ulp');

register_activation_hook(__FILE__, array("ulp_class", "install"));

class ulp_class {
	var $plugins_url;
	var $options;
	var $error;
	var $info;
	var $google_fonts = array();
	var $front_header = '';
	var $front_footer = '';
	var $font_awesome = array('fa-noicon', 'fa-adjust', 'fa-adn', 'fa-align-center', 'fa-align-justify', 'fa-align-left', 'fa-align-right', 'fa-ambulance', 'fa-anchor', 'fa-android', 'fa-angellist', 'fa-angle-double-down', 'fa-angle-double-left', 'fa-angle-double-right', 'fa-angle-double-up', 'fa-angle-down', 'fa-angle-left', 'fa-angle-right', 'fa-angle-up', 'fa-apple', 'fa-archive', 'fa-area-chart', 'fa-arrow-circle-down', 'fa-arrow-circle-left', 'fa-arrow-circle-o-down', 'fa-arrow-circle-o-left', 'fa-arrow-circle-o-right', 'fa-arrow-circle-o-up', 'fa-arrow-circle-right', 'fa-arrow-circle-up', 'fa-arrow-down', 'fa-arrow-left', 'fa-arrow-right', 'fa-arrow-up', 'fa-arrows', 'fa-arrows-alt', 'fa-arrows-h', 'fa-arrows-v', 'fa-asterisk', 'fa-at', 'fa-automobile', 'fa-backward', 'fa-ban', 'fa-bank', 'fa-bar-chart', 'fa-bar-chart-o', 'fa-barcode', 'fa-bars', 'fa-bed', 'fa-beer', 'fa-behance', 'fa-behance-square', 'fa-bell', 'fa-bell-o', 'fa-bell-slash', 'fa-bell-slash-o', 'fa-bicycle', 'fa-binoculars', 'fa-birthday-cake', 'fa-bitbucket', 'fa-bitbucket-square', 'fa-bitcoin', 'fa-bold', 'fa-bolt', 'fa-bomb', 'fa-book', 'fa-bookmark', 'fa-bookmark-o', 'fa-briefcase', 'fa-btc', 'fa-bug', 'fa-building', 'fa-building-o', 'fa-bullhorn', 'fa-bullseye', 'fa-bus', 'fa-buysellads', 'fa-cab', 'fa-calculator', 'fa-calendar', 'fa-calendar-o', 'fa-camera', 'fa-camera-retro', 'fa-car', 'fa-caret-down', 'fa-caret-left', 'fa-caret-right', 'fa-caret-square-o-down', 'fa-caret-square-o-left', 'fa-caret-square-o-right', 'fa-caret-square-o-up', 'fa-caret-up', 'fa-cart-arrow-down', 'fa-cart-plus', 'fa-cc', 'fa-cc-amex', 'fa-cc-discover', 'fa-cc-mastercard', 'fa-cc-paypal', 'fa-cc-stripe', 'fa-cc-visa', 'fa-certificate', 'fa-chain', 'fa-chain-broken', 'fa-check', 'fa-check-circle', 'fa-check-circle-o', 'fa-check-square', 'fa-check-square-o', 'fa-chevron-circle-down', 'fa-chevron-circle-left', 'fa-chevron-circle-right', 'fa-chevron-circle-up', 'fa-chevron-down', 'fa-chevron-left', 'fa-chevron-right', 'fa-chevron-up', 'fa-child', 'fa-circle', 'fa-circle-o', 'fa-circle-o-notch', 'fa-circle-thin', 'fa-clipboard', 'fa-clock-o', 'fa-close', 'fa-cloud', 'fa-cloud-download', 'fa-cloud-upload', 'fa-cny', 'fa-code', 'fa-code-fork', 'fa-codepen', 'fa-coffee', 'fa-cog', 'fa-cogs', 'fa-columns', 'fa-comment', 'fa-comment-o', 'fa-comments', 'fa-comments-o', 'fa-compass', 'fa-compress', 'fa-connectdevelop', 'fa-copy', 'fa-copyright', 'fa-credit-card', 'fa-crop', 'fa-crosshairs', 'fa-css3', 'fa-cube', 'fa-cubes', 'fa-cut', 'fa-cutlery', 'fa-dashboard', 'fa-dashcube', 'fa-database', 'fa-dedent', 'fa-delicious', 'fa-desktop', 'fa-deviantart', 'fa-diamond', 'fa-digg', 'fa-dollar', 'fa-dot-circle-o', 'fa-download', 'fa-dribbble', 'fa-dropbox', 'fa-drupal', 'fa-edit', 'fa-eject', 'fa-ellipsis-h', 'fa-ellipsis-v', 'fa-empire', 'fa-envelope', 'fa-envelope-o', 'fa-envelope-square', 'fa-eraser', 'fa-eur', 'fa-euro', 'fa-exchange', 'fa-exclamation', 'fa-exclamation-circle', 'fa-exclamation-triangle', 'fa-expand', 'fa-external-link', 'fa-external-link-square', 'fa-eye', 'fa-eye-slash', 'fa-eyedropper', 'fa-facebook', 'fa-facebook-f', 'fa-facebook-official', 'fa-facebook-square', 'fa-fast-backward', 'fa-fast-forward', 'fa-fax', 'fa-female', 'fa-fighter-jet', 'fa-file', 'fa-file-archive-o', 'fa-file-audio-o', 'fa-file-code-o', 'fa-file-excel-o', 'fa-file-image-o', 'fa-file-movie-o', 'fa-file-o', 'fa-file-pdf-o', 'fa-file-photo-o', 'fa-file-picture-o', 'fa-file-powerpoint-o', 'fa-file-sound-o', 'fa-file-text', 'fa-file-text-o', 'fa-file-video-o', 'fa-file-word-o', 'fa-file-zip-o', 'fa-files-o', 'fa-film', 'fa-filter', 'fa-fire', 'fa-fire-extinguisher', 'fa-flag', 'fa-flag-checkered', 'fa-flag-o', 'fa-flash', 'fa-flask', 'fa-flickr', 'fa-floppy-o', 'fa-folder', 'fa-folder-o', 'fa-folder-open', 'fa-folder-open-o', 'fa-font', 'fa-forumbee', 'fa-forward', 'fa-foursquare', 'fa-frown-o', 'fa-futbol-o', 'fa-gamepad', 'fa-gavel', 'fa-gbp', 'fa-ge', 'fa-gear', 'fa-gears', 'fa-genderless', 'fa-gift', 'fa-git', 'fa-git-square', 'fa-github', 'fa-github-alt', 'fa-github-square', 'fa-gittip', 'fa-glass', 'fa-globe', 'fa-google', 'fa-google-plus', 'fa-google-plus-square', 'fa-google-wallet', 'fa-graduation-cap', 'fa-gratipay', 'fa-group', 'fa-h-square', 'fa-hacker-news', 'fa-hand-o-down', 'fa-hand-o-left', 'fa-hand-o-right', 'fa-hand-o-up', 'fa-hdd-o', 'fa-header', 'fa-headphones', 'fa-heart', 'fa-heart-o', 'fa-heartbeat', 'fa-history', 'fa-home', 'fa-hospital-o', 'fa-hotel', 'fa-html5', 'fa-ils', 'fa-image', 'fa-inbox', 'fa-indent', 'fa-info', 'fa-info-circle', 'fa-inr', 'fa-instagram', 'fa-institution', 'fa-ioxhost', 'fa-italic', 'fa-joomla', 'fa-jpy', 'fa-jsfiddle', 'fa-key', 'fa-keyboard-o', 'fa-krw', 'fa-language', 'fa-laptop', 'fa-lastfm', 'fa-lastfm-square', 'fa-leaf', 'fa-leanpub', 'fa-legal', 'fa-lemon-o', 'fa-level-down', 'fa-level-up', 'fa-life-bouy', 'fa-life-buoy', 'fa-life-ring', 'fa-life-saver', 'fa-lightbulb-o', 'fa-line-chart', 'fa-link', 'fa-linkedin', 'fa-linkedin-square', 'fa-linux', 'fa-list', 'fa-list-alt', 'fa-list-ol', 'fa-list-ul', 'fa-location-arrow', 'fa-lock', 'fa-long-arrow-down', 'fa-long-arrow-left', 'fa-long-arrow-right', 'fa-long-arrow-up', 'fa-magic', 'fa-magnet', 'fa-mail-forward', 'fa-mail-reply', 'fa-mail-reply-all', 'fa-male', 'fa-map-marker', 'fa-mars', 'fa-mars-double', 'fa-mars-stroke', 'fa-mars-stroke-h', 'fa-mars-stroke-v', 'fa-maxcdn', 'fa-meanpath', 'fa-medium', 'fa-medkit', 'fa-meh-o', 'fa-mercury', 'fa-microphone', 'fa-microphone-slash', 'fa-minus', 'fa-minus-circle', 'fa-minus-square', 'fa-minus-square-o', 'fa-mobile', 'fa-mobile-phone', 'fa-money', 'fa-moon-o', 'fa-mortar-board', 'fa-motorcycle', 'fa-music', 'fa-navicon', 'fa-neuter', 'fa-newspaper-o', 'fa-openid', 'fa-outdent', 'fa-pagelines', 'fa-paint-brush', 'fa-paper-plane', 'fa-paper-plane-o', 'fa-paperclip', 'fa-paragraph', 'fa-paste', 'fa-pause', 'fa-paw', 'fa-paypal', 'fa-pencil', 'fa-pencil-square', 'fa-pencil-square-o', 'fa-phone', 'fa-phone-square', 'fa-photo', 'fa-picture-o', 'fa-pie-chart', 'fa-pied-piper', 'fa-pied-piper-alt', 'fa-pinterest', 'fa-pinterest-p', 'fa-pinterest-square', 'fa-plane', 'fa-play', 'fa-play-circle', 'fa-play-circle-o', 'fa-plug', 'fa-plus', 'fa-plus-circle', 'fa-plus-square', 'fa-plus-square-o', 'fa-power-off', 'fa-print', 'fa-puzzle-piece', 'fa-qq', 'fa-qrcode', 'fa-question', 'fa-question-circle', 'fa-quote-left', 'fa-quote-right', 'fa-ra', 'fa-random', 'fa-rebel', 'fa-recycle', 'fa-reddit', 'fa-reddit-square', 'fa-refresh', 'fa-remove', 'fa-renren', 'fa-reorder', 'fa-repeat', 'fa-reply', 'fa-reply-all', 'fa-retweet', 'fa-rmb', 'fa-road', 'fa-rocket', 'fa-rotate-left', 'fa-rotate-right', 'fa-rouble', 'fa-rss', 'fa-rss-square', 'fa-rub', 'fa-ruble', 'fa-rupee', 'fa-save', 'fa-scissors', 'fa-search', 'fa-search-minus', 'fa-search-plus', 'fa-sellsy', 'fa-send', 'fa-send-o', 'fa-server', 'fa-share', 'fa-share-alt', 'fa-share-alt-square', 'fa-share-square', 'fa-share-square-o', 'fa-shekel', 'fa-sheqel', 'fa-shield', 'fa-ship', 'fa-shirtsinbulk', 'fa-shopping-cart', 'fa-sign-in', 'fa-sign-out', 'fa-signal', 'fa-simplybuilt', 'fa-sitemap', 'fa-skyatlas', 'fa-skype', 'fa-slack', 'fa-sliders', 'fa-slideshare', 'fa-smile-o', 'fa-soccer-ball-o', 'fa-sort', 'fa-sort-alpha-asc', 'fa-sort-alpha-desc', 'fa-sort-amount-asc', 'fa-sort-amount-desc', 'fa-sort-asc', 'fa-sort-desc', 'fa-sort-down', 'fa-sort-numeric-asc', 'fa-sort-numeric-desc', 'fa-sort-up', 'fa-soundcloud', 'fa-space-shuttle', 'fa-spinner', 'fa-spoon', 'fa-spotify', 'fa-square', 'fa-square-o', 'fa-stack-exchange', 'fa-stack-overflow', 'fa-star', 'fa-star-half', 'fa-star-half-empty', 'fa-star-half-full', 'fa-star-half-o', 'fa-star-o', 'fa-steam', 'fa-steam-square', 'fa-step-backward', 'fa-step-forward', 'fa-stethoscope', 'fa-stop', 'fa-street-view', 'fa-strikethrough', 'fa-stumbleupon', 'fa-stumbleupon-circle', 'fa-subscript', 'fa-subway', 'fa-suitcase', 'fa-sun-o', 'fa-superscript', 'fa-support', 'fa-table', 'fa-tablet', 'fa-tachometer', 'fa-tag', 'fa-tags', 'fa-tasks', 'fa-taxi', 'fa-tencent-weibo', 'fa-terminal', 'fa-text-height', 'fa-text-width', 'fa-th', 'fa-th-large', 'fa-th-list', 'fa-thumb-tack', 'fa-thumbs-down', 'fa-thumbs-o-down', 'fa-thumbs-o-up', 'fa-thumbs-up', 'fa-ticket', 'fa-times', 'fa-times-circle', 'fa-times-circle-o', 'fa-tint', 'fa-toggle-down', 'fa-toggle-left', 'fa-toggle-off', 'fa-toggle-on', 'fa-toggle-right', 'fa-toggle-up', 'fa-train', 'fa-transgender', 'fa-transgender-alt', 'fa-trash', 'fa-trash-o', 'fa-tree', 'fa-trello', 'fa-trophy', 'fa-truck', 'fa-try', 'fa-tty', 'fa-tumblr', 'fa-tumblr-square', 'fa-turkish-lira', 'fa-twitch', 'fa-twitter', 'fa-twitter-square', 'fa-umbrella', 'fa-underline', 'fa-undo', 'fa-university', 'fa-unlink', 'fa-unlock', 'fa-unlock-alt', 'fa-unsorted', 'fa-upload', 'fa-usd', 'fa-user', 'fa-user-md', 'fa-user-plus', 'fa-user-secret', 'fa-user-times', 'fa-users', 'fa-venus', 'fa-venus-double', 'fa-venus-mars', 'fa-viacoin', 'fa-video-camera', 'fa-vimeo-square', 'fa-vine', 'fa-vk', 'fa-volume-down', 'fa-volume-off', 'fa-volume-up', 'fa-warning', 'fa-wechat', 'fa-weibo', 'fa-weixin', 'fa-whatsapp', 'fa-wheelchair', 'fa-wifi', 'fa-windows', 'fa-won', 'fa-wordpress', 'fa-wrench', 'fa-xing', 'fa-xing-square', 'fa-yahoo', 'fa-yelp', 'fa-yen', 'fa-youtube', 'fa-youtube-play', 'fa-youtube-square');
	var $sort_methods = array('date-za', 'date-az', 'title-za', 'title-az');
	var $local_fonts = array(
		'arial' => 'Arial',
		'verdana' => 'Verdana'
	);
	var $alignments = array(
		'left' => 'Left',
		'right' => 'Right',
		'center' => 'Center',
		'justify' => 'Justify'
	);
	var $display_modes = array(
		'none' => 'Disable popup',
		'every-time' => 'Every time', 
		'once-session' => 'Once per session',
		'once-period' => 'Once per %X days',
		'once-only' => 'Only once'
	);
	var $appearances = array(
		'fade-in' => 'Fade In',
		'slide-up' => 'Slide Up',
		'slide-down' => 'Slide Down',
		'slide-left' => 'Slide Left',
		'slide-right' => 'Slide Right'
	);
	var $css3_appearances = array(
		'bounceIn' => 'Bounce',
		'bounceInUp' => 'Bounce Up',
		'bounceInDown' => 'Bounce Down',
		'bounceInLeft' => 'Bounce Right',
		'bounceInRight' => 'Bounce Left',
		'fadeIn' => 'Fade',
		'fadeInUp' => 'Fade Up',
		'fadeInDown' => 'Fade Down',
		'fadeInLeft' => 'Fade Right',
		'fadeInRight' => 'Fade Left',
		'flipInX' => 'Flip X',
		'flipInY' => 'Flip Y',
		'lightSpeedIn' => 'Light Speed',
		'rotateIn' => 'Rotate',
		'rotateInDownLeft' => 'Rotate Down Left',
		'rotateInDownRight' => 'Rotate Down Right',
		'rotateInUpLeft' => 'Rotate Up Left',
		'rotateInUpRight' => 'Rotate Up Right',
		'rollIn' => 'Roll',
		'zoomIn' => 'Zoom',
		'zoomInUp' => 'Zoom Up',
		'zoomInDown' => 'Zoom Down',
		'zoomInLeft' => 'Zoom Right',
		'zoomInRight' => 'Zoom Left'
	);
	var $font_weights = array(
		'100' => 'Thin',
		'200' => 'Extra-light',
		'300' => 'Light',
		'400' => 'Normal',
		'500' => 'Medium',
		'600' => 'Demi-bold',
		'700' => 'Bold',
		'800' => 'Heavy',
		'900' => 'Black'
	);
	var $default_popup_options = array(
		"title" => "",
		"width" => "640",
		"height" => "400",
		'position' => 'middle-center',
		'disable_overlay' => 'off',
		"overlay_color" => "#333333",
		"overlay_opacity" => 0.8,
		"enable_close" => "on",
		'name_placeholder' => 'Enter your name...',
		'email_placeholder' => 'Enter your e-mail...',
		'phone_placeholder' => 'Enter your phone number...',
		'message_placeholder' => 'Enter your message...',
		'name_mandatory' => 'off',
		'phone_mandatory' => 'off',
		'message_mandatory' => 'off',
		'button_label' => 'Subscribe',
		'button_icon' => 'fa-noicon',
		'button_label_loading' => 'Loading...',
		'button_color' => '#0147A3',
		'button_border_radius' => 2,
		'button_gradient' => 'on',
		'button_inherit_size' => 'off',
		'button_css' => '',
		'button_css_hover' => '',
		'input_border_color' => '#444444',
		'input_border_width' => 1,
		'input_border_radius' => 2,
		'input_background_color' => '#FFFFFF',
		'input_background_opacity' => 0.7,
		'input_icons' => 'off',
		'input_css' => '',
		'recaptcha_mandatory' => 'off',
		'recaptcha_theme' => 'light',
		'return_url' => '',
		'close_delay' => 0
	);
	var $default_layer_options = array(
		"title" => "",
		"content" => "",
		"width" => "",
		"height" => "",
		"scrollbar" => "off",
		"left" => 20,
		"top" => 20,
		"background_color" => "",
		"background_opacity" => 0.9,
		"background_image" => "",
		"content_align" => "left",
		"index" => 5,
		"appearance" => "fade-in",
		"appearance_delay" => "200",
		"appearance_speed" => "1000",
		"font" => "arial",
		"font_color" => "#000000",
		"font_weight" => "400",
		"font_size" => 14,
		"text_shadow_size" => 0,
		"text_shadow_color" => "#000000",
		"confirmation_layer" => "off",
		'inline_disable' => 'off',
		"style" => ""
	);
	var $ext_options = array(
		'enable_customfields' => 'off',
		'enable_social' => 'on',
		'enable_social2' => 'off',
		'enable_mailchimp' => 'on',
		'enable_sendgrid' => 'off',
		'enable_elasticemail' => 'off',
		'enable_egoi' => 'off',
		'enable_aweber' => 'off',
		'enable_getresponse' => 'off',
		'enable_icontact' => 'off',
		'enable_madmimi' => 'off',
		'enable_campaignmonitor' => 'off',
		'enable_salesautopilot' => 'off',
		'enable_sendy' => 'off',
		'enable_interspire' => 'off',
		'enable_benchmark' => 'off',
		'enable_activecampaign' => 'off',
		'enable_ontraport' => 'off',
		'enable_mailerlite' => 'off',
		'enable_mymail' => 'off',
		'enable_mailpoet' => 'off',
		'enable_sendpress' => 'off',
		'enable_ymlp' => 'off',
		'enable_freshmail' => 'off',
		'enable_sendreach' => 'off',
		'enable_constantcontact' => 'off',
		'enable_directmail' => 'off',
		'enable_htmlform' => 'off',
		'enable_mail' => 'on',
		'enable_welcomemail' => 'on',
		'enable_mailwizz' => 'off',
		'enable_customerio' => 'off',
		'late_init' => 'off',
		'minified_sources' => 'on',
		'enable_library' => 'on',
		'enable_addons' => 'on',
		'admin_only_meta' => 'on'
	);
	var $default_meta = array(
		"version" => ULP_VERSION,
		"onload_mode" => 'default',
		"onload_period" => '5',
		"onload_delay" => 0,
		"onload_close_delay" => 0,
		"onload_popup" => 'default',
		"onload_popup_mobile" => 'default',
		"onexit_mode" => 'default',
		"onexit_period" => '5',
		"onexit_popup" => 'default',
		"onexit_popup_mobile" => 'default',
		"onscroll_popup" => 'default',
		"onscroll_popup_mobile" => 'default',
		"onscroll_mode" => 'default',
		"onscroll_period" => '5',
		"onscroll_offset" => 600,
		"onidle_mode" => 'default',
		"onidle_delay" => 30,
		"onidle_period" => '5',
		"onidle_popup" => 'default',
		"onidle_popup_mobile" => 'default'
	);
	function __construct() {
		if (function_exists('load_plugin_textdomain')) {
			load_plugin_textdomain('ulp', false, dirname(plugin_basename(__FILE__)).'/languages/');
		}
		$this->plugins_url = plugins_url('', __FILE__);
		$this->options = array(
			"version" => ULP_VERSION,
			"cookie_value" => 'ilovelencha',
			"onload_mode" => 'none',
			"onload_period" => '5',
			"onload_delay" => 0,
			"onload_close_delay" => 0,
			"onload_popup" => '',
			"onload_popup_mobile" => 'same',
			"onexit_mode" => 'none',
			"onexit_period" => '5',
			"onexit_popup" => '',
			"onexit_popup_mobile" => 'same',
			"onscroll_mode" => 'none',
			"onscroll_period" => '5',
			"onscroll_popup" => '',
			"onscroll_popup_mobile" => 'same',
			"onscroll_offset" => 600,
			"onidle_mode" => 'none',
			"onidle_delay" => 30,
			"onidle_period" => '5',
			"onidle_popup" => '',
			"onidle_popup_mobile" => 'same',
			"disable_roles" => array(),
			"onload_only" => 'off',
			"onexit_limits" => 'off',
			"csv_separator" => ";",
			"email_validation" => "off",
			"ga_tracking" => "off",
			"km_tracking" => "off",
			"css3_enable" => "on",
			"fa_enable" => "off",
			"fa_css_disable" => "off",
			"recaptcha_enable" => "off",
			"recaptcha_js_disable" => "off",
			"recaptcha_public_key" => "",
			"recaptcha_secret_key" => "",
			"no_preload" => 'off',
			"from_name" => get_bloginfo('name'),
			"from_email" => "noreply@".str_replace("www.", "", $_SERVER["SERVER_NAME"]),
			"popups_sort" => 'date-za',
			"campaigns_sort" => 'date-za',
			"subscribers_sort" => 'date-za',
			"purchase_code" => ''
		);

		if (defined('WP_ALLOW_MULTISITE')) $this->install();
		$this->get_ext_options();
		$this->get_options();
		
		if (!in_array('curl', get_loaded_extensions())) {
			$this->ext_options = array_merge($this->ext_options, array(
				'enable_library' => 'off',
				'enable_addons' => 'off',
				'enable_mailchimp' => 'off',
				'enable_sendgrid' => 'off',
				'enable_elasticemail' => 'off',
				'enable_egoi' => 'off',
				'enable_customerio' => 'off',
				'enable_mailwizz' => 'off',
				'enable_icontact' => 'off',
				'enable_getresponse' => 'off',
				'enable_madmimi' => 'off',
				'enable_directmail' => 'off',
				'enable_campaignmonitor' => 'off',
				'enable_salesautopilot' => 'off',
				'enable_activecampaign' => 'off',
				'enable_benchmark' => 'off',
				'enable_sendy' => 'off',
				'enable_interspire' => 'off',
				'enable_ontraport' => 'off',
				'enable_mailerlite' => 'off',
				'enable_ymlp' => 'off',
				'enable_sendreach' => 'off',
				'enable_aweber' => 'off',
				'enable_constantcontact' => 'off',
				'enable_htmlform' => 'off',
				'enable_freshmail' => 'off'
			));
		}
		
		if (file_exists(dirname(__FILE__).'/modules/ulp-custom-fields.php') && $this->ext_options['enable_customfields'] == 'on') include_once(dirname(__FILE__).'/modules/ulp-custom-fields.php');
		if (file_exists(dirname(__FILE__).'/modules/ulp-social.php') && $this->ext_options['enable_social'] == 'on') include_once(dirname(__FILE__).'/modules/ulp-social.php');
		if (file_exists(dirname(__FILE__).'/modules/ulp-social2.php') && $this->ext_options['enable_social2'] == 'on') include_once(dirname(__FILE__).'/modules/ulp-social2.php');
		if (file_exists(dirname(__FILE__).'/modules/ulp-mail.php') && $this->ext_options['enable_mail'] == 'on') include_once(dirname(__FILE__).'/modules/ulp-mail.php');
		if (file_exists(dirname(__FILE__).'/modules/ulp-welcomemail.php') && $this->ext_options['enable_welcomemail'] == 'on') include_once(dirname(__FILE__).'/modules/ulp-welcomemail.php');
		if (file_exists(dirname(__FILE__).'/modules/ulp-mailchimp.php') && $this->ext_options['enable_mailchimp'] == 'on') include_once(dirname(__FILE__).'/modules/ulp-mailchimp.php');
		if (file_exists(dirname(__FILE__).'/modules/ulp-icontact.php') && $this->ext_options['enable_icontact'] == 'on') include_once(dirname(__FILE__).'/modules/ulp-icontact.php');
		if (file_exists(dirname(__FILE__).'/modules/ulp-getresponse.php') && $this->ext_options['enable_getresponse'] == 'on') include_once(dirname(__FILE__).'/modules/ulp-getresponse.php');
		if (file_exists(dirname(__FILE__).'/modules/ulp-constant-contact.php') && $this->ext_options['enable_constantcontact'] == 'on') include_once(dirname(__FILE__).'/modules/ulp-constant-contact.php');
		if (file_exists(dirname(__FILE__).'/modules/ulp-mad-mimi.php') && $this->ext_options['enable_madmimi'] == 'on') include_once(dirname(__FILE__).'/modules/ulp-mad-mimi.php');
		if (file_exists(dirname(__FILE__).'/modules/ulp-campaign-monitor.php') && $this->ext_options['enable_campaignmonitor'] == 'on') include_once(dirname(__FILE__).'/modules/ulp-campaign-monitor.php');
		if (file_exists(dirname(__FILE__).'/modules/ulp-sales-autopilot.php') && $this->ext_options['enable_salesautopilot'] == 'on') include_once(dirname(__FILE__).'/modules/ulp-sales-autopilot.php');
		if (file_exists(dirname(__FILE__).'/modules/ulp-active-campaign.php') && $this->ext_options['enable_activecampaign'] == 'on') include_once(dirname(__FILE__).'/modules/ulp-active-campaign.php');
		if (file_exists(dirname(__FILE__).'/modules/ulp-benchmark.php') && $this->ext_options['enable_benchmark'] == 'on') include_once(dirname(__FILE__).'/modules/ulp-benchmark.php');
		if (file_exists(dirname(__FILE__).'/modules/ulp-sendy.php') && $this->ext_options['enable_sendy'] == 'on') include_once(dirname(__FILE__).'/modules/ulp-sendy.php');
		if (file_exists(dirname(__FILE__).'/modules/ulp-interspire.php') && $this->ext_options['enable_interspire'] == 'on') include_once(dirname(__FILE__).'/modules/ulp-interspire.php');
		if (file_exists(dirname(__FILE__).'/modules/ulp-ontraport.php') && $this->ext_options['enable_ontraport'] == 'on') include_once(dirname(__FILE__).'/modules/ulp-ontraport.php');
		if (file_exists(dirname(__FILE__).'/modules/ulp-mailerlite.php') && $this->ext_options['enable_mailerlite'] == 'on') include_once(dirname(__FILE__).'/modules/ulp-mailerlite.php');
		if (file_exists(dirname(__FILE__).'/modules/ulp-ymlp.php') && $this->ext_options['enable_ymlp'] == 'on') include_once(dirname(__FILE__).'/modules/ulp-ymlp.php');
		if (file_exists(dirname(__FILE__).'/modules/ulp-freshmail.php') && $this->ext_options['enable_freshmail'] == 'on') include_once(dirname(__FILE__).'/modules/ulp-freshmail.php');
		if (file_exists(dirname(__FILE__).'/modules/ulp-sendreach.php') && $this->ext_options['enable_sendreach'] == 'on') include_once(dirname(__FILE__).'/modules/ulp-sendreach.php');
		if (file_exists(dirname(__FILE__).'/modules/ulp-direct-mail.php') && $this->ext_options['enable_directmail'] == 'on') include_once(dirname(__FILE__).'/modules/ulp-direct-mail.php');
		if (file_exists(dirname(__FILE__).'/modules/ulp-mailwizz.php') && $this->ext_options['enable_mailwizz'] == 'on') include_once(dirname(__FILE__).'/modules/ulp-mailwizz.php');
		if (file_exists(dirname(__FILE__).'/modules/ulp-customerio.php') && $this->ext_options['enable_customerio'] == 'on') include_once(dirname(__FILE__).'/modules/ulp-customerio.php');
		if (file_exists(dirname(__FILE__).'/modules/ulp-egoi.php') && $this->ext_options['enable_egoi'] == 'on') include_once(dirname(__FILE__).'/modules/ulp-egoi.php');
		if (file_exists(dirname(__FILE__).'/modules/ulp-elasticemail.php') && $this->ext_options['enable_elasticemail'] == 'on') include_once(dirname(__FILE__).'/modules/ulp-elasticemail.php');
		if (file_exists(dirname(__FILE__).'/modules/ulp-sendgrid.php') && $this->ext_options['enable_sendgrid'] == 'on') include_once(dirname(__FILE__).'/modules/ulp-sendgrid.php');
		if (file_exists(dirname(__FILE__).'/modules/ulp-aweber.php') && $this->ext_options['enable_aweber'] == 'on') include_once(dirname(__FILE__).'/modules/ulp-aweber.php');
		if (file_exists(dirname(__FILE__).'/modules/ulp-mymail.php') && $this->ext_options['enable_mymail'] == 'on') include_once(dirname(__FILE__).'/modules/ulp-mymail.php');
		if (file_exists(dirname(__FILE__).'/modules/ulp-mailpoet.php') && $this->ext_options['enable_mailpoet'] == 'on') include_once(dirname(__FILE__).'/modules/ulp-mailpoet.php');
		if (file_exists(dirname(__FILE__).'/modules/ulp-sendpress.php') && $this->ext_options['enable_sendpress'] == 'on') include_once(dirname(__FILE__).'/modules/ulp-sendpress.php');
		if (file_exists(dirname(__FILE__).'/modules/ulp-htmlform.php') && $this->ext_options['enable_htmlform'] == 'on') include_once(dirname(__FILE__).'/modules/ulp-htmlform.php');
		if (file_exists(dirname(__FILE__).'/modules/ulp-library.php') && $this->ext_options['enable_library'] == 'on') include_once(dirname(__FILE__).'/modules/ulp-library.php');
		if (file_exists(dirname(__FILE__).'/modules/ulp-addons.php') && $this->ext_options['enable_addons'] == 'on') include_once(dirname(__FILE__).'/modules/ulp-addons.php');

		if (!empty($_COOKIE["ulp_error"])) {
			$this->error = stripslashes($_COOKIE["ulp_error"]);
			setcookie("ulp_error", "", time()+30, "/", ".".str_replace("www.", "", $_SERVER["SERVER_NAME"]));
		}
		if (!empty($_COOKIE["ulp_info"])) {
			$this->info = stripslashes($_COOKIE["ulp_info"]);
			setcookie("ulp_info", "", time()+30, "/", ".".str_replace("www.", "", $_SERVER["SERVER_NAME"]));
		}

		if (is_admin()) {
			if ($this->options['version'] < 4.58) {
				add_action('admin_notices', array(&$this, 'admin_warning'));
			}
			add_action('admin_enqueue_scripts', array(&$this, 'admin_enqueue_scripts'));
			add_action('admin_head', array(&$this, 'admin_head'));
			add_action('admin_menu', array(&$this, 'admin_menu'));
			add_action('init', array(&$this, 'admin_request_handler'));
			add_action('admin_menu', array(&$this, 'add_meta'));
			add_action('save_post', array(&$this, 'save_meta'), 10, 2);
			add_action('wp_ajax_ulp_save_layer', array(&$this, "save_layer"));
			add_action('wp_ajax_ulp_copy_layer', array(&$this, "copy_layer"));
			add_action('wp_ajax_ulp_save_popup', array(&$this, "save_popup"));
			add_action('wp_ajax_ulp_save_campaign', array(&$this, "save_campaign"));
			add_action('wp_ajax_ulp_delete_layer', array(&$this, "delete_layer"));
			add_action('wp_ajax_ulp_reset_cookie', array(&$this, "reset_cookie"));
			add_action('wp_ajax_ulp_save_settings', array(&$this, "save_settings"));
			add_action('wp_ajax_ulp_save_ext_settings', array(&$this, "save_ext_settings"));
			add_action('wp_ajax_ulp_subscribe', array(&$this, "subscribe"));
			add_action('wp_ajax_nopriv_ulp_subscribe', array(&$this, "subscribe"));
			add_action('wp_ajax_ulp_share', array(&$this, "share"));
			add_action('wp_ajax_nopriv_ulp_share', array(&$this, "share"));
			add_action('wp_ajax_ulp_addimpression', array(&$this, "add_impression"));
			add_action('wp_ajax_nopriv_ulp_addimpression', array(&$this, "add_impression"));
			add_action('wp_ajax_ulp_loadpopup', array(&$this, "load_popup"));
			add_action('wp_ajax_nopriv_ulp_loadpopup', array(&$this, "load_popup"));

			//if (!empty($this->options['purchase_code'])) {
				add_filter('pre_set_site_transient_update_plugins', array(&$this, 'check_for_plugin_update'));
				add_filter('plugins_api', array(&$this, 'plugin_api_call'), 10, 3);
			//}
		} else {
			if ($this->ext_options['late_init'] == 'on') {
				add_action('wp_enqueue_scripts', array(&$this, 'front_init'), 99);
			} else {
				add_action('wp', array(&$this, 'front_init'), 15);
			}
			add_shortcode('ulp', array(&$this, "shortcode_handler"));
		}
	}

	function admin_warning() {
		echo '
		<div class="error ulp-error"><p><strong>IMPORTANT!</strong> Please deactivate and activate <strong>Layered Popups</strong> plugin <a href="'.admin_url('plugins.php').'">here</a>!</p></div>';
	}
	
	function admin_enqueue_scripts() {
		wp_enqueue_script("jquery");
		wp_enqueue_style('ulp', plugins_url('/css/admin.css', __FILE__), array(), ULP_VERSION);
		wp_enqueue_style('ulp-link-buttons', plugins_url('/css/link-buttons.css', __FILE__), array(), ULP_VERSION);
		wp_enqueue_script('ulp', plugins_url('/js/admin.js', __FILE__), array(), ULP_VERSION);
		if (isset($_GET['page']) && $_GET['page'] == 'ulp-add') {
			wp_enqueue_style('wp-color-picker');
			wp_enqueue_script('wp-color-picker');
			if ($this->options['fa_enable'] == 'on') wp_enqueue_style('font-awesome', plugins_url('/css/font-awesome.min.css', __FILE__), array(), ULP_VERSION);
		}
		if (isset($_GET['page']) && ($_GET['page'] == 'ulp-subscribers' || $_GET['page'] == 'ulp-add' || $_GET['page'] == 'ulp-campaigns')) {
			wp_enqueue_style('thickbox');
			wp_enqueue_script('thickbox');
		}
	}
	
	function admin_head() {
		echo '<script>var ulp_ajax_handler = "'.admin_url('admin-ajax.php').'";</script>';
	}
	
	static function install() {
		global $wpdb;
		$add_default = false;
		$table_name = $wpdb->prefix."ulp_popups";
		if($wpdb->get_var("SHOW TABLES LIKE '".$table_name."'") != $table_name) {
			$sql = "CREATE TABLE ".$table_name." (
				id int(11) NOT NULL auto_increment,
				str_id varchar(31) collate latin1_general_cs NULL,
				title varchar(255) collate utf8_unicode_ci NULL,
				width int(11) NULL default '640',
				height int(11) NULL default '400',
				options longtext collate utf8_unicode_ci NULL,
				impressions int(11) NULL default '0',
				clicks int(11) NULL default '0',
				created int(11) NULL,
				blocked int(11) NULL default '0',
				deleted int(11) NULL default '0',
				UNIQUE KEY  id (id)
			);";
			require_once(ABSPATH.'wp-admin/includes/upgrade.php');
			dbDelta($sql);
			$add_default = true;
		}
		if ($wpdb->get_var("SHOW COLUMNS FROM ".$wpdb->prefix."ulp_popups LIKE 'impressions'") != 'impressions') {
			$sql = "ALTER TABLE ".$wpdb->prefix."ulp_popups ADD impressions int(11) NULL default '0'";
			$wpdb->query($sql);
		}
		if ($wpdb->get_var("SHOW COLUMNS FROM ".$wpdb->prefix."ulp_popups LIKE 'clicks'") != 'clicks') {
			$sql = "ALTER TABLE ".$wpdb->prefix."ulp_popups ADD clicks int(11) NULL default '0'";
			$wpdb->query($sql);
		}
		$table_name = $wpdb->prefix."ulp_layers";
		if($wpdb->get_var("SHOW TABLES LIKE '".$table_name."'") != $table_name) {
			$sql = "CREATE TABLE ".$table_name." (
				id int(11) NOT NULL auto_increment,
				popup_id int(11) NULL,
				title varchar(255) collate utf8_unicode_ci NULL,
				content longtext collate utf8_unicode_ci NULL,
				zindex int(11) NULL default '5',
				details longtext collate utf8_unicode_ci NULL,
				created int(11) NULL,
				deleted int(11) NULL default '0',
				UNIQUE KEY  id (id)
			);";
			require_once(ABSPATH.'wp-admin/includes/upgrade.php');
			dbDelta($sql);
		}
		$table_name = $wpdb->prefix."ulp_campaigns";
		if($wpdb->get_var("SHOW TABLES LIKE '".$table_name."'") != $table_name) {
			$sql = "CREATE TABLE ".$table_name." (
				id int(11) NOT NULL auto_increment,
				title varchar(255) collate utf8_unicode_ci NULL,
				str_id varchar(31) collate latin1_general_cs NULL,
				details longtext collate utf8_unicode_ci NULL,
				created int(11) NULL,
				blocked int(11) NULL default '0',
				deleted int(11) NULL default '0',
				UNIQUE KEY  id (id)
			);";
			require_once(ABSPATH.'wp-admin/includes/upgrade.php');
			dbDelta($sql);
		}
		$table_name = $wpdb->prefix."ulp_campaign_items";
		if($wpdb->get_var("SHOW TABLES LIKE '".$table_name."'") != $table_name) {
			$sql = "CREATE TABLE ".$table_name." (
				id int(11) NOT NULL auto_increment,
				campaign_id int(11) NULL,
				popup_id int(11) NULL,
				impressions int(11) NULL default '0',
				clicks int(11) NULL default '0',
				created int(11) NULL,
				deleted int(11) NULL default '0',
				UNIQUE KEY  id (id)
			);";
			require_once(ABSPATH.'wp-admin/includes/upgrade.php');
			dbDelta($sql);
		}
		$table_name = $wpdb->prefix . "ulp_subscribers";
		if($wpdb->get_var("SHOW TABLES LIKE '".$table_name."'") != $table_name) {
			$sql = "CREATE TABLE ".$table_name." (
				id int(11) NOT NULL auto_increment,
				popup_id int(11) NULL,
				name varchar(255) collate utf8_unicode_ci NULL,
				email varchar(255) collate utf8_unicode_ci NULL,
				phone varchar(255) collate utf8_unicode_ci NULL,
				message longtext collate utf8_unicode_ci NULL,
				custom_fields longtext collate utf8_unicode_ci NULL,
				created int(11) NULL,
				deleted int(11) NULL default '0',
				UNIQUE KEY  id (id)
			);";
			require_once(ABSPATH.'wp-admin/includes/upgrade.php');
			dbDelta($sql);
		}
		if ($wpdb->get_var("SHOW COLUMNS FROM ".$wpdb->prefix."ulp_subscribers LIKE 'phone'") != 'phone') {
			$sql = "ALTER TABLE ".$wpdb->prefix."ulp_subscribers ADD phone varchar(255) collate utf8_unicode_ci NULL";
			$wpdb->query($sql);
		}
		if ($wpdb->get_var("SHOW COLUMNS FROM ".$wpdb->prefix."ulp_subscribers LIKE 'message'") != 'message') {
			$sql = "ALTER TABLE ".$wpdb->prefix."ulp_subscribers ADD message longtext collate utf8_unicode_ci NULL";
			$wpdb->query($sql);
		}
		if ($wpdb->get_var("SHOW COLUMNS FROM ".$wpdb->prefix."ulp_subscribers LIKE 'custom_fields'") != 'custom_fields') {
			$sql = "ALTER TABLE ".$wpdb->prefix."ulp_subscribers ADD custom_fields longtext collate utf8_unicode_ci NULL";
			$wpdb->query($sql);
		}
		$table_name = $wpdb->prefix."ulp_webfonts";
		if($wpdb->get_var("SHOW TABLES LIKE '".$table_name."'") != $table_name) {
			$sql = "CREATE TABLE ".$table_name." (
				id int(11) NOT NULL auto_increment,
				family varchar(255) collate utf8_unicode_ci NULL,
				variants varchar(255) collate utf8_unicode_ci NULL,
				subsets varchar(255) collate utf8_unicode_ci NULL,
				source varchar(31) collate latin1_general_cs NULL,
				deleted int(11) NULL default '0',
				UNIQUE KEY  id (id)
			);";
			require_once(ABSPATH.'wp-admin/includes/upgrade.php');
			dbDelta($sql);
			include_once(dirname(__FILE__).'/webfonts.php');
			$webfonts_array = json_decode($fonts, true);
			if (is_array($webfonts_array['items'])) {
				$values = array();
				foreach($webfonts_array['items'] as $fontvars) {
					if (!empty($fontvars['family'])) {
						$variants = '';
						if (!empty($fontvars['variants']) && is_array($fontvars['variants'])) {
							foreach ($fontvars['variants'] as $key => $var) {
									if ($var == 'regular') $fontvars['variants'][$key] = '400';
									if ($var == 'italic') $fontvars['variants'][$key] = '400italic';
							}
							$variants = implode(",", $fontvars['variants']);
						}
						$subsets = '';
						if (!empty($fontvars['subsets']) && is_array($fontvars['subsets'])) {
							$subsets = implode(",", $fontvars['subsets']);
						}
						$values[] = "('".esc_sql($fontvars['family'])."', '".esc_sql($variants)."', '".esc_sql($subsets)."', 'google', '0')";
						if (sizeof($values) > 9) {
							$sql = "INSERT INTO ".$wpdb->prefix."ulp_webfonts (family, variants, subsets, source, deleted) 
									VALUES ".implode(', ', $values);
							$wpdb->query($sql);
							$values = array();
						}
					}
				}
				if (sizeof($values) > 0) {
					$sql = "INSERT INTO ".$wpdb->prefix."ulp_webfonts (family, variants, subsets, source, deleted) 
							VALUES ".implode(', ', $values);
					$wpdb->query($sql);
				}
			}
		}
		update_option('ulp_version', ULP_VERSION);
		$upload_dir = wp_upload_dir();
		wp_mkdir_p($upload_dir["basedir"].'/'.ULP_UPLOADS_DIR);
		wp_mkdir_p($upload_dir["basedir"].'/'.ULP_UPLOADS_DIR.'/temp');
		if (file_exists($upload_dir["basedir"].'/'.ULP_UPLOADS_DIR) && !file_exists($upload_dir["basedir"].'/'.ULP_UPLOADS_DIR.'/index.html')) {
			file_put_contents($upload_dir["basedir"].'/'.ULP_UPLOADS_DIR.'/index.html', 'Silence is the gold!');
		}
		if (file_exists($upload_dir["basedir"].'/'.ULP_UPLOADS_DIR.'/temp') && !file_exists($upload_dir["basedir"].'/'.ULP_UPLOADS_DIR.'/temp/index.html')) {
			file_put_contents($upload_dir["basedir"].'/'.ULP_UPLOADS_DIR.'/temp/index.html', 'Silence is the gold!');
		}
		if ($add_default) {
			if (file_exists(dirname(__FILE__).'/default') && is_dir(dirname(__FILE__).'/default')) {
				$dircontent = scandir(dirname(__FILE__).'/default');
				for ($i=0; $i<sizeof($dircontent); $i++) {
					if ($dircontent[$i] != "." && $dircontent[$i] != ".." && $dircontent[$i] != "index.html" && $dircontent[$i] != ".htaccess") {
						if (is_file(dirname(__FILE__).'/default/'.$dircontent[$i])) {
							$lines = file(dirname(__FILE__).'/default/'.$dircontent[$i]);
							if (sizeof($lines) != 3) continue;
							$version = intval(trim($lines[0]));
							if ($version > intval(ULP_EXPORT_VERSION)) continue;
							$md5_hash = trim($lines[1]);
							$popup_data = trim($lines[2]);
							$popup_data = base64_decode($popup_data);
							if (!$popup_data || md5($popup_data) != $md5_hash) continue;
							$popup = unserialize($popup_data);
							$popup_details = $popup['popup'];
							$symbols = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
							$str_id = '';
							for ($j=0; $j<16; $j++) {
								$str_id .= $symbols[rand(0, strlen($symbols)-1)];
							}
							$sql = "INSERT INTO ".$wpdb->prefix."ulp_popups (str_id, title, width, height, options, created, blocked, deleted) 
								VALUES (
								'".$str_id."', 
								'".esc_sql($popup_details['title'])."', 
								'".intval($popup_details['width'])."', 
								'".intval($popup_details['height'])."', 
								'".esc_sql($popup_details['options'])."', 
								'".time()."', '1', '0')";
							$wpdb->query($sql);
							$popup_id = $wpdb->insert_id;
							$layers = $popup['layers'];
							if (sizeof($layers) > 0) {
								foreach ($layers as $layer) {
									$sql = "INSERT INTO ".$wpdb->prefix."ulp_layers (
										popup_id, title, content, zindex, details, created, deleted) VALUES (
										'".$popup_id."',
										'".esc_sql($layer['title'])."',
										'".esc_sql($layer['content'])."',
										'".esc_sql($layer['zindex'])."',
										'".esc_sql($layer['details'])."',
										'".time()."', '0')";
									$wpdb->query($sql);
								}
							}
						}
					}
				}
			}
		}
	}

	function get_ext_options() {
		foreach ($this->ext_options as $key => $value) {
			$this->ext_options[$key] = get_option('ulp_ext_'.$key, $this->ext_options[$key]);
		}
	}

	function update_ext_options() {
		if (current_user_can('manage_options')) {
			foreach ($this->ext_options as $key => $value) {
				update_option('ulp_ext_'.$key, $value);
			}
		}
	}

	function populate_ext_options() {
		foreach ($this->ext_options as $key => $value) {
			if (isset($_POST['ulp_ext_'.$key])) {
				$this->ext_options[$key] = trim(stripslashes($_POST['ulp_ext_'.$key]));
			}
		}
	}

	function get_options() {
		$exists = get_option('ulp_version');
		if ($exists) {
			foreach ($this->options as $key => $value) {
				$this->options[$key] = get_option('ulp_'.$key, $this->options[$key]);
			}
		}
	}

	function update_options() {
		if (current_user_can('manage_options')) {
			foreach ($this->options as $key => $value) {
				update_option('ulp_'.$key, $value);
			}
		}
	}

	function populate_options() {
		foreach ($this->options as $key => $value) {
			if (isset($_POST['ulp_'.$key])) {
				$this->options[$key] = trim(stripslashes($_POST['ulp_'.$key]));
			}
		}
	}

	function get_meta($post_id) {
		$meta = array();
		$version = get_post_meta($post_id, 'ulp_version', true);
		if (empty($version)) $meta = $this->default_meta;
		else {
			foreach($this->default_meta as $key => $value) {
				$meta[$key] = get_post_meta($post_id, 'ulp_'.$key, true);
			}
			if ($version < 3.50) {
				$meta['onload_popup_mobile'] = $this->default_meta['onload_popup_mobile'];
				$meta['onscroll_popup_mobile'] = $this->default_meta['onscroll_popup_mobile'];
				$meta['onexit_popup_mobile'] = $this->default_meta['onexit_popup_mobile'];
			}
			if ($version < 3.71) {
				$meta['onload_period'] = $this->default_meta['onload_period'];
				$meta['onexit_period'] = $this->default_meta['onexit_period'];
				$meta['onscroll_period'] = $this->default_meta['onscroll_period'];
			}
		}
		if (empty($meta['onexit_mode'])) {
			$meta['onexit_mode'] = $this->default_meta['onexit_mode'];
			$meta['onexit_popup'] = $this->default_meta['onexit_popup'];
		}
		if (empty($meta['onscroll_mode'])) {
			$meta['onscroll_mode'] = $this->default_meta['onscroll_mode'];
			$meta['onscroll_popup'] = $this->default_meta['onscroll_popup'];
			$meta['onscroll_offset'] = $this->default_meta['onscroll_offset'];
		}
		if (empty($meta['onidle_mode'])) {
			$meta['onidle_mode'] = $this->default_meta['onidle_mode'];
			$meta['onidle_popup'] = $this->default_meta['onidle_popup'];
			$meta['onidle_popup_mobile'] = $this->default_meta['onidle_popup_mobile'];
			$meta['onidle_delay'] = $this->default_meta['onidle_delay'];
			$meta['onidle_period'] = $this->default_meta['onidle_period'];
		}
		return $meta;
	}

	function add_meta() {
		if ($this->ext_options['admin_only_meta'] == 'on' && !current_user_can('manage_options')) return;
		add_meta_box("ulp", 'Layered Popups Events Settings', array(&$this, 'show_meta'), "post", "normal", "default");
		add_meta_box("ulp", 'Layered Popups Events Settings', array(&$this, 'show_meta'), "page", "normal", "default");
		$post_types = get_post_types(array('public' => true, '_builtin' => false), 'names', 'and'); 
		foreach ($post_types as $post_type ) {
			add_meta_box("ulp", 'Layered Popups Events Settings', array(&$this, 'show_meta'), $post_type, "normal", "default");
		}		
	}
	
	function show_meta($post, $box) {
		global $wpdb;
		$meta = $this->get_meta($post->ID);
		wp_nonce_field(basename( __FILE__ ), 'ulp_nonce');
		echo '
			<input type="hidden" name="ulp_meta_version" value="'.ULP_VERSION.'">
			<div class="ulp ulp-meta">
				<h3>'.__('OnLoad Settings', 'ulp').'</h3>
				<table class="ulp_useroptions">
					<tr>
						<th>'.__('Popup or A/B Campaign', 'ulp').':</th>
						<td style="vertical-align: middle; line-height: 1.6;">
							<strong>'.__('For desktops:', 'ulp').'</strong><br />
							<select id="ulp_onload_popup" name="ulp_onload_popup">';
		$popups = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."ulp_popups WHERE deleted = '0' ORDER BY title ASC", ARRAY_A);
		if (sizeof($popups) > 0) {
			echo '
								<option disabled="disabled">--------- '.__('Popups', 'ulp').' ---------</option>';
			foreach($popups as $popup) {
				echo '
								<option value="'.$popup['str_id'].'"'.($meta['onload_popup'] == $popup['str_id'] ? ' selected="selected"' : '').'>'.esc_html($popup['title']).($popup['blocked'] == 1 ? ' '.__('[blocked]', 'ulp') : '').'</option>';
			}
		}
		$campaigns = $wpdb->get_results("SELECT t1.*, t2.popups FROM ".$wpdb->prefix."ulp_campaigns t1 JOIN (SELECT COUNT(*) AS popups, tt1.campaign_id FROM ".$wpdb->prefix."ulp_campaign_items tt1 JOIN ".$wpdb->prefix."ulp_popups tt2 ON tt2.id = tt1.popup_id WHERE tt1.deleted = '0' AND tt2.deleted = '0' GROUP BY tt1.campaign_id) t2 ON t2.campaign_id = t1.id WHERE t1.deleted = '0' AND t2.popups > 0 ORDER BY t1.title ASC", ARRAY_A);
		if (sizeof($campaigns) > 0) {
			echo '
								<option disabled="disabled">--------- '.__('A/B Campaigns', 'ulp').' ---------</option>';
			foreach($campaigns as $campaign) {
				echo '
								<option value="'.$campaign['str_id'].'"'.($meta['onload_popup'] == $campaign['str_id'] ? ' selected="selected"' : '').'>'.esc_html($campaign['title']).($campaign['blocked'] == 1 ? ' '.__('[blocked]', 'ulp') : '').'</option>';
			}
		}
		if (sizeof($popups) > 0 || sizeof($campaigns) > 0) {
			echo '
								<option disabled="disabled">------------------</option>';
		}
		echo '
								<option value=""'.(empty($meta['onload_popup']) ? ' selected="selected"' : '').'>'.__('None (disabled)', 'ulp').'</option>
								<option value="default"'.($meta['onload_popup'] == 'default' ? ' selected="selected"' : '').'>'.__('Default Popup (taken from Settings page)', 'ulp').'</option>
							<select>
							<br /><strong>'.__('For mobile devices (smartphones):', 'ulp').'</strong><br />
							<select id="ulp_onload_popup_mobile" name="ulp_onload_popup_mobile">';
		//$popups = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."ulp_popups WHERE deleted = '0' ORDER BY title ASC", ARRAY_A);
		if (sizeof($popups) > 0) {
			echo '
								<option disabled="disabled">--------- '.__('Popups', 'ulp').' ---------</option>';
			foreach($popups as $popup) {
				echo '
								<option value="'.$popup['str_id'].'"'.($meta['onload_popup_mobile'] == $popup['str_id'] ? ' selected="selected"' : '').'>'.esc_html($popup['title']).($popup['blocked'] == 1 ? ' '.__('[blocked]', 'ulp') : '').'</option>';
			}
		}
		//$campaigns = $wpdb->get_results("SELECT t1.*, t2.popups FROM ".$wpdb->prefix."ulp_campaigns t1 JOIN (SELECT COUNT(*) AS popups, tt1.campaign_id FROM ".$wpdb->prefix."ulp_campaign_items tt1 JOIN ".$wpdb->prefix."ulp_popups tt2 ON tt2.id = tt1.popup_id WHERE tt1.deleted = '0' AND tt2.deleted = '0' GROUP BY tt1.campaign_id) t2 ON t2.campaign_id = t1.id WHERE t1.deleted = '0' AND t2.popups > 0 ORDER BY t1.title ASC", ARRAY_A);
		if (sizeof($campaigns) > 0) {
			echo '
								<option disabled="disabled">--------- '.__('A/B Campaigns', 'ulp').' ---------</option>';
			foreach($campaigns as $campaign) {
				echo '
								<option value="'.$campaign['str_id'].'"'.($meta['onload_popup_mobile'] == $campaign['str_id'] ? ' selected="selected"' : '').'>'.esc_html($campaign['title']).($campaign['blocked'] == 1 ? ' '.__('[blocked]', 'ulp') : '').'</option>';
			}
		}
		if (sizeof($popups) > 0 || sizeof($campaigns) > 0) {
			echo '
								<option disabled="disabled">------------------</option>';
		}
		echo '
								<option value=""'.(empty($meta['onload_popup_mobile']) ? ' selected="selected"' : '').'>'.__('None (disabled)', 'ulp').'</option>
								<option value="default"'.($meta['onload_popup_mobile'] == 'default' ? ' selected="selected"' : '').'>'.__('Default Popup (taken from Settings page)', 'ulp').'</option>
								<option value="same"'.($meta['onload_popup_mobile'] == 'same' ? ' selected="selected"' : '').'>'.__('Same as for desktops', 'ulp').'</option>
							<select>
							<br /><em>'.__('Select popup to be displayed on page load.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('Display mode', 'ulp').':</th>
						<td style="line-height: 1.8; vertical-align: middle;">';
		foreach ($this->display_modes as $key => $value) {
			$value = str_replace('%X', '<input type="text" name="ulp_onload_period" id="ulp_onload_period" class="ic_input_number_short" value="'.$meta['onload_period'].'">', $value);
			echo '
							<input type="radio" name="ulp_onload_mode" id="ulp_onload_mode" value="'.$key.'"'.($meta['onload_mode'] == $key ? ' checked="checked"' : '').'> '.$value.'<br />';
		}
		echo '
							<input type="radio" name="ulp_onload_mode" id="ulp_onload_mode" value="default"'.($meta['onload_mode'] == 'default' ? ' checked="checked"' : '').'> '.__('Default Mode (taken from <a href="admin.php?page=ulp-settings" target="_blank">Settings</a> page)', 'ulp').'<br />
							<em>'.__('Select the popup display mode.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('Start delay', 'ulp').':</th>
						<td style="vertical-align: middle;">
							<input type="text" name="ulp_onload_delay" value="'.esc_html($meta['onload_delay']).'" class="ic_input_number" placeholder="Delay"> '.__('seconds', 'ulp').'
							<br /><em>'.__('Popup appears with this delay after page loaded. Set "0" for immediate start. Value is ignored for "Default" popup.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('Autoclose delay', 'ulp').':</th>
						<td style="vertical-align: middle;">
							<input type="text" name="ulp_onload_close_delay" value="'.esc_html($meta['onload_close_delay']).'" class="ic_input_number" placeholder="Autoclose delay"> '.__('seconds', 'ulp').'
							<br /><em>'.__('Popup is automatically closed after this period of time. Set "0", if you do not need autoclosing. Value is ignored for "Default" popup.', 'ulp').'</em>
						</td>
					</tr>
				</table>
				<h3>'.__('OnScroll Settings', 'ulp').'</h3>
				<table class="ulp_useroptions">
					<tr>
						<th>'.__('Popup or A/B Campaign', 'ulp').':</th>
						<td style="vertical-align: middle; line-height: 1.6;">
							<strong>'.__('For desktops:', 'ulp').'</strong><br />
							<select id="ulp_onscroll_popup" name="ulp_onscroll_popup">';
		//$popups = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."ulp_popups WHERE deleted = '0' ORDER BY title ASC", ARRAY_A);
		if (sizeof($popups) > 0) {
			echo '
								<option disabled="disabled">--------- '.__('Popups', 'ulp').' ---------</option>';
			foreach($popups as $popup) {
				echo '
								<option value="'.$popup['str_id'].'"'.($meta['onscroll_popup'] == $popup['str_id'] ? ' selected="selected"' : '').'>'.esc_html($popup['title']).($popup['blocked'] == 1 ? ' '.__('[blocked]', 'ulp') : '').'</option>';
			}
		}
		//$campaigns = $wpdb->get_results("SELECT t1.*, t2.popups FROM ".$wpdb->prefix."ulp_campaigns t1 JOIN (SELECT COUNT(*) AS popups, tt1.campaign_id FROM ".$wpdb->prefix."ulp_campaign_items tt1 JOIN ".$wpdb->prefix."ulp_popups tt2 ON tt2.id = tt1.popup_id WHERE tt1.deleted = '0' AND tt2.deleted = '0' GROUP BY tt1.campaign_id) t2 ON t2.campaign_id = t1.id WHERE t1.deleted = '0' AND t2.popups > 0 ORDER BY t1.title ASC", ARRAY_A);
		if (sizeof($campaigns) > 0) {
			echo '
								<option disabled="disabled">--------- '.__('A/B Campaigns', 'ulp').' ---------</option>';
			foreach($campaigns as $campaign) {
				echo '
								<option value="'.$campaign['str_id'].'"'.($meta['onscroll_popup'] == $campaign['str_id'] ? ' selected="selected"' : '').'>'.esc_html($campaign['title']).($campaign['blocked'] == 1 ? ' '.__('[blocked]', 'ulp') : '').'</option>';
			}
		}
		if (sizeof($popups) > 0 || sizeof($campaigns) > 0) {
			echo '
								<option disabled="disabled">------------------</option>';
		}
		echo '
								<option value=""'.(empty($meta['onscroll_popup']) ? ' selected="selected"' : '').'>'.__('None (disabled)', 'ulp').'</option>
								<option value="default"'.($meta['onscroll_popup'] == 'default' ? ' selected="selected"' : '').'>'.__('Default Popup (taken from Settings page)', 'ulp').'</option>
							<select>
							<br /><strong>'.__('For mobile devices (smartphones):', 'ulp').'</strong><br />
							<select id="ulp_onscroll_popup_mobile" name="ulp_onscroll_popup_mobile">';
		//$popups = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."ulp_popups WHERE deleted = '0' ORDER BY title ASC", ARRAY_A);
		if (sizeof($popups) > 0) {
			echo '
								<option disabled="disabled">--------- '.__('Popups', 'ulp').' ---------</option>';
			foreach($popups as $popup) {
				echo '
								<option value="'.$popup['str_id'].'"'.($meta['onscroll_popup_mobile'] == $popup['str_id'] ? ' selected="selected"' : '').'>'.esc_html($popup['title']).($popup['blocked'] == 1 ? ' '.__('[blocked]', 'ulp') : '').'</option>';
			}
		}
		//$campaigns = $wpdb->get_results("SELECT t1.*, t2.popups FROM ".$wpdb->prefix."ulp_campaigns t1 JOIN (SELECT COUNT(*) AS popups, tt1.campaign_id FROM ".$wpdb->prefix."ulp_campaign_items tt1 JOIN ".$wpdb->prefix."ulp_popups tt2 ON tt2.id = tt1.popup_id WHERE tt1.deleted = '0' AND tt2.deleted = '0' GROUP BY tt1.campaign_id) t2 ON t2.campaign_id = t1.id WHERE t1.deleted = '0' AND t2.popups > 0 ORDER BY t1.title ASC", ARRAY_A);
		if (sizeof($campaigns) > 0) {
			echo '
								<option disabled="disabled">--------- '.__('A/B Campaigns', 'ulp').' ---------</option>';
			foreach($campaigns as $campaign) {
				echo '
								<option value="'.$campaign['str_id'].'"'.($meta['onscroll_popup_mobile'] == $campaign['str_id'] ? ' selected="selected"' : '').'>'.esc_html($campaign['title']).($campaign['blocked'] == 1 ? ' '.__('[blocked]', 'ulp') : '').'</option>';
			}
		}
		if (sizeof($popups) > 0 || sizeof($campaigns) > 0) {
			echo '
								<option disabled="disabled">------------------</option>';
		}
		echo '
								<option value=""'.(empty($meta['onscroll_popup_mobile']) ? ' selected="selected"' : '').'>'.__('None (disabled)', 'ulp').'</option>
								<option value="default"'.($meta['onscroll_popup_mobile'] == 'default' ? ' selected="selected"' : '').'>'.__('Default Popup (taken from Settings page)', 'ulp').'</option>
								<option value="same"'.($meta['onscroll_popup_mobile'] == 'same' ? ' selected="selected"' : '').'>'.__('Same as for desktops', 'ulp').'</option>
							<select>
							<br /><em>'.__('Select the popup to be displayed on scrolling the page.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('Display mode', 'ulp').':</th>
						<td style="line-height: 1.8; vertical-align: middle;">';
		foreach ($this->display_modes as $key => $value) {
			$value = str_replace('%X', '<input type="text" name="ulp_onscroll_period" id="ulp_onscroll_period" class="ic_input_number_short" value="'.$meta['onscroll_period'].'">', $value);
			echo '
							<input type="radio" name="ulp_onscroll_mode" id="ulp_onscroll_mode" value="'.$key.'"'.($meta['onscroll_mode'] == $key ? ' checked="checked"' : '').'> '.$value.'<br />';
		}
		echo '
							<input type="radio" name="ulp_onscroll_mode" id="ulp_onscroll_mode" value="default"'.($meta['onscroll_mode'] == 'default' ? ' checked="checked"' : '').'> '.__('Default Mode (taken from <a href="admin.php?page=ulp-settings" target="_blank">Settings</a> page)', 'ulp').'<br />
							<em>'.__('Select the popup display mode.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('Scrolling offset', 'ulp').':</th>
						<td style="vertical-align: middle;">
							<input type="text" name="ulp_onscroll_offset" value="'.esc_html($meta['onscroll_offset']).'" class="ic_input_number" placeholder="Offset"> '.__('pixels', 'ulp').'
							<br /><em>'.__('Popup appears when user scroll down to this number of pixels.', 'ulp').'</em>
						</td>
					</tr>
				</table>
				<h3>'.__('OnExit Settings', 'ulp').'</h3>
				<table class="ulp_useroptions">
					<tr>
						<th>'.__('Popup or A/B Campaign', 'ulp').':</th>
						<td style="vertical-align: middle; line-height: 1.6;">
							<strong>'.__('For desktops:', 'ulp').'</strong><br />
							<select id="ulp_onexit_popup" name="ulp_onexit_popup">';
		//$popups = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."ulp_popups WHERE deleted = '0' ORDER BY title ASC", ARRAY_A);
		if (sizeof($popups) > 0) {
			echo '
								<option disabled="disabled">--------- '.__('Popups', 'ulp').' ---------</option>';
			foreach($popups as $popup) {
				echo '
								<option value="'.$popup['str_id'].'"'.($meta['onexit_popup'] == $popup['str_id'] ? ' selected="selected"' : '').'>'.esc_html($popup['title']).($popup['blocked'] == 1 ? ' '.__('[blocked]', 'ulp') : '').'</option>';
			}
		}
		//$campaigns = $wpdb->get_results("SELECT t1.*, t2.popups FROM ".$wpdb->prefix."ulp_campaigns t1 JOIN (SELECT COUNT(*) AS popups, tt1.campaign_id FROM ".$wpdb->prefix."ulp_campaign_items tt1 JOIN ".$wpdb->prefix."ulp_popups tt2 ON tt2.id = tt1.popup_id WHERE tt1.deleted = '0' AND tt2.deleted = '0' GROUP BY tt1.campaign_id) t2 ON t2.campaign_id = t1.id WHERE t1.deleted = '0' AND t2.popups > 0 ORDER BY t1.title ASC", ARRAY_A);
		if (sizeof($campaigns) > 0) {
			echo '
								<option disabled="disabled">--------- '.__('A/B Campaigns', 'ulp').' ---------</option>';
			foreach($campaigns as $campaign) {
				echo '
								<option value="'.$campaign['str_id'].'"'.($meta['onexit_popup'] == $campaign['str_id'] ? ' selected="selected"' : '').'>'.esc_html($campaign['title']).($campaign['blocked'] == 1 ? ' '.__('[blocked]', 'ulp') : '').'</option>';
			}
		}
		if (sizeof($popups) > 0 || sizeof($campaigns) > 0) {
			echo '
								<option disabled="disabled">------------------</option>';
		}
		echo '
								<option value=""'.(empty($meta['onexit_popup']) ? ' selected="selected"' : '').'>'.__('None (disabled)', 'ulp').'</option>
								<option value="default"'.($meta['onexit_popup'] == 'default' ? ' selected="selected"' : '').'>'.__('Default Popup (taken from Settings page)', 'ulp').'</option>
							<select>
							<br /><strong>'.__('For mobile devices (smartphones):', 'ulp').'</strong><br />
							<select id="ulp_onexit_popup_moblie" name="ulp_onexit_popup_mobile">';
		//$popups = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."ulp_popups WHERE deleted = '0' ORDER BY title ASC", ARRAY_A);
		if (sizeof($popups) > 0) {
			echo '
								<option disabled="disabled">--------- '.__('Popups', 'ulp').' ---------</option>';
			foreach($popups as $popup) {
				echo '
								<option value="'.$popup['str_id'].'"'.($meta['onexit_popup_mobile'] == $popup['str_id'] ? ' selected="selected"' : '').'>'.esc_html($popup['title']).($popup['blocked'] == 1 ? ' '.__('[blocked]', 'ulp') : '').'</option>';
			}
		}
		//$campaigns = $wpdb->get_results("SELECT t1.*, t2.popups FROM ".$wpdb->prefix."ulp_campaigns t1 JOIN (SELECT COUNT(*) AS popups, tt1.campaign_id FROM ".$wpdb->prefix."ulp_campaign_items tt1 JOIN ".$wpdb->prefix."ulp_popups tt2 ON tt2.id = tt1.popup_id WHERE tt1.deleted = '0' AND tt2.deleted = '0' GROUP BY tt1.campaign_id) t2 ON t2.campaign_id = t1.id WHERE t1.deleted = '0' AND t2.popups > 0 ORDER BY t1.title ASC", ARRAY_A);
		if (sizeof($campaigns) > 0) {
			echo '
								<option disabled="disabled">--------- '.__('A/B Campaigns', 'ulp').' ---------</option>';
			foreach($campaigns as $campaign) {
				echo '
								<option value="'.$campaign['str_id'].'"'.($meta['onexit_popup_mobile'] == $campaign['str_id'] ? ' selected="selected"' : '').'>'.esc_html($campaign['title']).($campaign['blocked'] == 1 ? ' '.__('[blocked]', 'ulp') : '').'</option>';
			}
		}
		if (sizeof($popups) > 0 || sizeof($campaigns) > 0) {
			echo '
								<option disabled="disabled">------------------</option>';
		}
		echo '
								<option value=""'.(empty($meta['onexit_popup_mobile']) ? ' selected="selected"' : '').'>'.__('None (disabled)', 'ulp').'</option>
								<option value="default"'.($meta['onexit_popup_mobile'] == 'default' ? ' selected="selected"' : '').'>'.__('Default Popup (taken from Settings page)', 'ulp').'</option>
								<option value="same"'.($meta['onexit_popup_mobile'] == 'same' ? ' selected="selected"' : '').'>'.__('Same as for desktops', 'ulp').'</option>
							<select>
							<br /><em>'.__('Select the popup to be displayed on exit intent.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('Display mode', 'ulp').':</th>
						<td style="line-height: 1.8; vertical-align: middle;">';
		foreach ($this->display_modes as $key => $value) {
			$value = str_replace('%X', '<input type="text" name="ulp_onexit_period" id="ulp_onexit_period" class="ic_input_number_short" value="'.$meta['onexit_period'].'">', $value);
			echo '
							<input type="radio" name="ulp_onexit_mode" id="ulp_onexit_mode" value="'.$key.'"'.($meta['onexit_mode'] == $key ? ' checked="checked"' : '').'> '.$value.'<br />';
		}
		echo '
							<input type="radio" name="ulp_onexit_mode" id="ulp_onexit_mode" value="default"'.($meta['onexit_mode'] == 'default' ? ' checked="checked"' : '').'> '.__('Default Mode (taken from <a href="admin.php?page=ulp-settings" target="_blank">Settings</a> page)', 'ulp').'<br />
							<em>'.__('Select the popup display mode.', 'ulp').'</em>
						</td>
					</tr>
				</table>
				<h3>'.__('OnInactivity Settings', 'ulp').'</h3>
				<table class="ulp_useroptions">
					<tr>
						<th>'.__('Popup or A/B Campaign', 'ulp').':</th>
						<td style="vertical-align: middle; line-height: 1.6;">
							<strong>'.__('For desktops:', 'ulp').'</strong><br />
							<select id="ulp_onidle_popup" name="ulp_onidle_popup">';
		//$popups = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."ulp_popups WHERE deleted = '0' ORDER BY title ASC", ARRAY_A);
		if (sizeof($popups) > 0) {
			echo '
								<option disabled="disabled">--------- '.__('Popups', 'ulp').' ---------</option>';
			foreach($popups as $popup) {
				echo '
								<option value="'.$popup['str_id'].'"'.($meta['onidle_popup'] == $popup['str_id'] ? ' selected="selected"' : '').'>'.esc_html($popup['title']).($popup['blocked'] == 1 ? ' '.__('[blocked]', 'ulp') : '').'</option>';
			}
		}
		//$campaigns = $wpdb->get_results("SELECT t1.*, t2.popups FROM ".$wpdb->prefix."ulp_campaigns t1 JOIN (SELECT COUNT(*) AS popups, tt1.campaign_id FROM ".$wpdb->prefix."ulp_campaign_items tt1 JOIN ".$wpdb->prefix."ulp_popups tt2 ON tt2.id = tt1.popup_id WHERE tt1.deleted = '0' AND tt2.deleted = '0' GROUP BY tt1.campaign_id) t2 ON t2.campaign_id = t1.id WHERE t1.deleted = '0' AND t2.popups > 0 ORDER BY t1.title ASC", ARRAY_A);
		if (sizeof($campaigns) > 0) {
			echo '
								<option disabled="disabled">--------- '.__('A/B Campaigns', 'ulp').' ---------</option>';
			foreach($campaigns as $campaign) {
				echo '
								<option value="'.$campaign['str_id'].'"'.($meta['onidle_popup'] == $campaign['str_id'] ? ' selected="selected"' : '').'>'.esc_html($campaign['title']).($campaign['blocked'] == 1 ? ' '.__('[blocked]', 'ulp') : '').'</option>';
			}
		}
		if (sizeof($popups) > 0 || sizeof($campaigns) > 0) {
			echo '
								<option disabled="disabled">------------------</option>';
		}
		echo '
								<option value=""'.(empty($meta['onidle_popup']) ? ' selected="selected"' : '').'>'.__('None (disabled)', 'ulp').'</option>
								<option value="default"'.($meta['onidle_popup'] == 'default' ? ' selected="selected"' : '').'>'.__('Default Popup (taken from Settings page)', 'ulp').'</option>
							<select>
							<br /><strong>'.__('For mobile devices (smartphones):', 'ulp').'</strong><br />
							<select id="ulp_onidle_popup_mobile" name="ulp_onidle_popup_mobile">';
		//$popups = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."ulp_popups WHERE deleted = '0' ORDER BY title ASC", ARRAY_A);
		if (sizeof($popups) > 0) {
			echo '
								<option disabled="disabled">--------- '.__('Popups', 'ulp').' ---------</option>';
			foreach($popups as $popup) {
				echo '
								<option value="'.$popup['str_id'].'"'.($meta['onidle_popup_mobile'] == $popup['str_id'] ? ' selected="selected"' : '').'>'.esc_html($popup['title']).($popup['blocked'] == 1 ? ' '.__('[blocked]', 'ulp') : '').'</option>';
			}
		}
		//$campaigns = $wpdb->get_results("SELECT t1.*, t2.popups FROM ".$wpdb->prefix."ulp_campaigns t1 JOIN (SELECT COUNT(*) AS popups, tt1.campaign_id FROM ".$wpdb->prefix."ulp_campaign_items tt1 JOIN ".$wpdb->prefix."ulp_popups tt2 ON tt2.id = tt1.popup_id WHERE tt1.deleted = '0' AND tt2.deleted = '0' GROUP BY tt1.campaign_id) t2 ON t2.campaign_id = t1.id WHERE t1.deleted = '0' AND t2.popups > 0 ORDER BY t1.title ASC", ARRAY_A);
		if (sizeof($campaigns) > 0) {
			echo '
								<option disabled="disabled">--------- '.__('A/B Campaigns', 'ulp').' ---------</option>';
			foreach($campaigns as $campaign) {
				echo '
								<option value="'.$campaign['str_id'].'"'.($meta['onidle_popup_mobile'] == $campaign['str_id'] ? ' selected="selected"' : '').'>'.esc_html($campaign['title']).($campaign['blocked'] == 1 ? ' '.__('[blocked]', 'ulp') : '').'</option>';
			}
		}
		if (sizeof($popups) > 0 || sizeof($campaigns) > 0) {
			echo '
								<option disabled="disabled">------------------</option>';
		}
		echo '
								<option value=""'.(empty($meta['onidle_popup_mobile']) ? ' selected="selected"' : '').'>'.__('None (disabled)', 'ulp').'</option>
								<option value="default"'.($meta['onidle_popup_mobile'] == 'default' ? ' selected="selected"' : '').'>'.__('Default Popup (taken from Settings page)', 'ulp').'</option>
								<option value="same"'.($meta['onidle_popup_mobile'] == 'same' ? ' selected="selected"' : '').'>'.__('Same as for desktops', 'ulp').'</option>
							<select>
							<br /><em>'.__('Select the popup to be displayed on user inactivity.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('Display mode', 'ulp').':</th>
						<td style="line-height: 1.8; vertical-align: middle;">';
		foreach ($this->display_modes as $key => $value) {
			$value = str_replace('%X', '<input type="text" name="ulp_onidle_period" id="ulp_onidle_period" class="ic_input_number_short" value="'.$meta['onidle_period'].'">', $value);
			echo '
							<input type="radio" name="ulp_onidle_mode" id="ulp_onidle_mode" value="'.$key.'"'.($meta['onidle_mode'] == $key ? ' checked="checked"' : '').'> '.$value.'<br />';
		}
		echo '
							<input type="radio" name="ulp_onidle_mode" id="ulp_onidle_mode" value="default"'.($meta['onidle_mode'] == 'default' ? ' checked="checked"' : '').'> '.__('Default Mode (taken from <a href="admin.php?page=ulp-settings" target="_blank">Settings</a> page)', 'ulp').'<br />
							<em>'.__('Select the popup display mode.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('Period of inactivity', 'ulp').':</th>
						<td style="vertical-align: middle;">
							<input type="text" name="ulp_onidle_delay" value="'.esc_html($meta['onidle_delay']).'" class="ic_input_number" placeholder="seconds"> '.__('seconds', 'ulp').'
							<br /><em>'.__('The popup appears after this period of inactivity.', 'ulp').'</em>
						</td>
					</tr>
				</table>';
		do_action('ulp_show_meta', $post, $box);
		echo '
			</div>';
	}

	function save_meta($post_id, $post) {
		if (!isset( $_POST['ulp_nonce'] ) || !wp_verify_nonce($_POST['ulp_nonce'], basename( __FILE__ ))) {
			return $post_id;
		}
		
		$post_type = get_post_type_object($post->post_type);
		if (!current_user_can($post_type->cap->edit_post, $post_id)) {
			return $post_id;
		}
		if (isset($_POST['ulp_meta_version'])) {
			$meta = array();
			foreach($this->default_meta as $key => $value) {
				if (isset($_POST['ulp_'.$key])) $value = trim(stripslashes($_POST['ulp_'.$key]));
				if ($key == 'onload_period' || $key == 'onscroll_period' || $key == 'onexit_period' || $key == 'onidle_period' || $key == 'onidle_delay') {
					if (strlen($value) == 0 || $value != preg_replace('/[^0-9]/', '', $value) || intval($value) < 1) $value = $this->options[$key];
				} else if ($key == 'onload_delay' || $key == 'onload_close_delay' || $key == 'onscroll_offset') {
					if (strlen($value) > 0 && $value != preg_replace('/[^0-9]/', '', $value)) $value = $this->options[$key];
				}
				update_post_meta($post_id, 'ulp_'.$key, $value);
			}
		}
		do_action('ulp_save_meta', $post_id, $post);
	}
	
	function admin_menu() {
		add_menu_page(
			"Layered Popups"
			, "Layered Popups"
			, "add_users"
			, "ulp"
			, array(&$this, 'admin_popups')
		);
		add_submenu_page(
			"ulp"
			, __('Popups', 'ulp')
			, __('Popups', 'ulp')
			, "add_users"
			, "ulp"
			, array(&$this, 'admin_popups')
		);
		add_submenu_page(
			"ulp"
			, __('Create Popup', 'ulp')
			, __('Create Popup', 'ulp')
			, "add_users"
			, "ulp-add"
			, array(&$this, 'admin_add_popup')
		);
		add_submenu_page(
			"ulp"
			, __('A/B Campaigns', 'ulp')
			, __('A/B Campaigns', 'ulp')
			, "add_users"
			, "ulp-campaigns"
			, array(&$this, 'admin_campaigns')
		);
		add_submenu_page(
			"ulp"
			, __('Create Campaign', 'ulp')
			, __('Create Campaign', 'ulp')
			, "add_users"
			, "ulp-add-campaign"
			, array(&$this, 'admin_add_campaign')
		);
		add_submenu_page(
			"ulp"
			, __('Log', 'ulp')
			, __('Log', 'ulp')
			, "add_users"
			, "ulp-subscribers"
			, array(&$this, 'admin_subscribers')
		);
		do_action('ulp_admin_menu');
		add_submenu_page(
			"ulp"
			, __('Settings', 'ulp')
			, __('Settings', 'ulp')
			, "add_users"
			, "ulp-settings"
			, array(&$this, 'admin_settings')
		);
		add_submenu_page(
			"ulp"
			, __('FAQ', 'ulp')
			, __('FAQ', 'ulp')
			, "add_users"
			, "ulp-faq"
			, array(&$this, 'admin_faq')
		);
	}

	function admin_faq() {
		global $wpdb;
		echo '
		<div class="wrap ulp">
			<div id="icon-edit-pages" class="icon32"><br /></div><h2>Layered Popups - FAQ</h2>
			<div class="ulp-options" style="width: 100%; position: relative;">';
		include_once(dirname(__FILE__).'/faq.php');
		do_action('ulp_faq');
		echo '
				<h3>'.__('Credits', 'ulp').'</h3>
				<ol>
					<li><a href="http://p.yusukekamiyamane.com/" target="_blank">Fugue Icons</a> [icons]</li>
					<li><a href="http://www.google.com/fonts/specimen/Open+Sans" target="_blank">Open Sans</a> [font]</li>
					<li><a href="http://www.google.com/fonts/specimen/Walter+Turncoat" target="_blank">Walter Turncoat</a> [font]</li>
					<li><a href="http://www.flickr.com/photos/duncanh1/8506986371/in/photolist-dXJwEP-7ZogK1-8bHpxi-eoL5K2-dU8WLK-7Zk6DD-dyBCL2-dyH6vN-87oTAm-dVq9ex-bax8Fe-a3sk3a-dyBCG8-dyBCye-dxoaup-aFxFtK-a25d6s-cA1TLd-fEy7Vh-a25t97-a3sk3i-a25t9d-bt324c-9eWYyv-e9v5L6-9ZYJCb-7YgSdJ-aow783-dV8L1k-9dB9zs-8A5WTw-9ZvMxn-b9HKsk-bp15Kf-ecHEZB-bPkHhK-8Ebh3A-a1S7W5-e3vpbv-9Zz3hW-a7uaQT-egTcNK-a1S7Wh-7PsHJT-fEuMRY-fq7Cz9-aEQRuu-cz4kYU-8WrG2Q-dxtAQA-brkWsD/" target="_blank">The City from the Shard</a> [image]</li>
					<li><a href="http://www.fasticon.com" target="_blank">Fast Icon</a> [icons]</li>
					<li><a href="http://www.wallsave.com" target="_blank">Wallpapers Business Graph</a> [image]</li>
					<li><a href="http://daneden.github.io/animate.css/" target="_blank">Animate.css</a> [stylesheet]</li>
				</ol>
			</div>
		</div>';
	}

	function admin_settings() {
		global $wpdb;

		if (isset($_GET['mode']) && $_GET['mode'] == 'ext') {
			$this->admin_ext_settings();
			return;
		}
		
		if (!empty($this->error)) $message = "<div class='error'><p>".$this->error."</p></div>";
		else if (!empty($this->info)) $message = "<div class='updated'><p>".$this->info."</p></div>";
		else $message = '';
		
		echo '
		<div class="wrap ulp">
			<div id="icon-options-general" class="icon32"><br /></div><h2>'.__('Layered Popups - Settings', 'ulp').'</h2>
			'.$message.'
			<h2 class="nav-tab-wrapper">
				<a class="nav-tab nav-tab-active" href="'.admin_url('admin.php').'?page=ulp-settings">'.__('General', 'ulp').'</a>
				<a class="nav-tab" href="'.admin_url('admin.php').'?page=ulp-settings&mode=ext">'.__('Advanced', 'ulp').'</a>
			</h2>
			<form class="ulp-popup-form" enctype="multipart/form-data" method="post" style="margin: 0px" action="'.admin_url('admin.php').'">
			<div class="ulp-options" style="width: 100%; position: relative;">
				<h3>'.__('OnLoad Settings', 'ulp').'</h3>
				<table class="ulp_useroptions">
					<tr>
						<th>'.__('Popup or A/B Campaign', 'ulp').':</th>
						<td style="vertical-align: middle; line-height: 1.6;">
							<strong>'.__('For desktops:', 'ulp').'</strong><br />
							<select id="ulp_onload_popup" name="ulp_onload_popup">';
		$popups = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."ulp_popups WHERE deleted = '0' ORDER BY title ASC", ARRAY_A);
		$checked = false;
		if (sizeof($popups) > 0) {
			echo '
								<option disabled="disabled">--------- '.__('Popups', 'ulp').' ---------</option>';
			foreach($popups as $popup) {
				if ($this->options['onload_popup'] == $popup['str_id']) {
					$checked = true;
					echo '
								<option value="'.$popup['str_id'].'" selected="selected">'.esc_html($popup['title']).($popup['blocked'] == 1 ? ' '.__('[blocked]', 'ulp') : '').'</option>';
				} else {
					echo '
								<option value="'.$popup['str_id'].'">'.esc_html($popup['title']).($popup['blocked'] == 1 ? ' '.__('[blocked]', 'ulp') : '').'</option>';
				}
			}
		}
		$campaigns = $wpdb->get_results("SELECT t1.*, t2.popups FROM ".$wpdb->prefix."ulp_campaigns t1 JOIN (SELECT COUNT(*) AS popups, tt1.campaign_id FROM ".$wpdb->prefix."ulp_campaign_items tt1 JOIN ".$wpdb->prefix."ulp_popups tt2 ON tt2.id = tt1.popup_id WHERE tt1.deleted = '0' AND tt2.deleted = '0' GROUP BY tt1.campaign_id) t2 ON t2.campaign_id = t1.id WHERE t1.deleted = '0' AND t2.popups > 0 ORDER BY t1.title ASC", ARRAY_A);
		if (sizeof($campaigns) > 0) {
			echo '
								<option disabled="disabled">--------- '.__('A/B Campaigns', 'ulp').' ---------</option>';
			foreach($campaigns as $campaign) {
				if ($this->options['onload_popup'] == $campaign['str_id']) {
					$checked = true;
					echo '
								<option value="'.$campaign['str_id'].'" selected="selected">'.esc_html($campaign['title']).($campaign['blocked'] == 1 ? ' '.__('[blocked]', 'ulp') : '').'</option>';
				} else {
					echo '
								<option value="'.$campaign['str_id'].'">'.esc_html($campaign['title']).($campaign['blocked'] == 1 ? ' '.__('[blocked]', 'ulp') : '').'</option>';
				}
			}
		}
		if (sizeof($popups) > 0 || sizeof($campaigns) > 0) {
			echo '
								<option disabled="disabled">------------------</option>';
		}
		echo '
								<option value=""'.(!$checked ? ' selected="selected"' : '').'>'.__('None (disabled)', 'ulp').'</option>
							</select>
							<br /><strong>'.__('For mobile devices (smartphones):', 'ulp').'</strong><br />
							<select id="ulp_onload_popup_mobile" name="ulp_onload_popup_mobile">';
		//$popups = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."ulp_popups WHERE deleted = '0' ORDER BY title ASC", ARRAY_A);
		$checked = false;
		if (sizeof($popups) > 0) {
			echo '
								<option disabled="disabled">--------- '.__('Popups', 'ulp').' ---------</option>';
			foreach($popups as $popup) {
				if ($this->options['onload_popup_mobile'] == $popup['str_id']) {
					$checked = true;
					echo '
								<option value="'.$popup['str_id'].'" selected="selected">'.esc_html($popup['title']).($popup['blocked'] == 1 ? ' '.__('[blocked]', 'ulp') : '').'</option>';
				} else {
					echo '
								<option value="'.$popup['str_id'].'">'.esc_html($popup['title']).($popup['blocked'] == 1 ? ' '.__('[blocked]', 'ulp') : '').'</option>';
				}
			}
		}
		//$campaigns = $wpdb->get_results("SELECT t1.*, t2.popups FROM ".$wpdb->prefix."ulp_campaigns t1 JOIN (SELECT COUNT(*) AS popups, tt1.campaign_id FROM ".$wpdb->prefix."ulp_campaign_items tt1 JOIN ".$wpdb->prefix."ulp_popups tt2 ON tt2.id = tt1.popup_id WHERE tt1.deleted = '0' AND tt2.deleted = '0' GROUP BY tt1.campaign_id) t2 ON t2.campaign_id = t1.id WHERE t1.deleted = '0' AND t2.popups > 0 ORDER BY t1.title ASC", ARRAY_A);
		if (sizeof($campaigns) > 0) {
			echo '
								<option disabled="disabled">--------- '.__('A/B Campaigns', 'ulp').' ---------</option>';
			foreach($campaigns as $campaign) {
				if ($this->options['onload_popup_mobile'] == $campaign['str_id']) {
					$checked = true;
					echo '
								<option value="'.$campaign['str_id'].'" selected="selected">'.esc_html($campaign['title']).($campaign['blocked'] == 1 ? ' '.__('[blocked]', 'ulp') : '').'</option>';
				} else {
					echo '
								<option value="'.$campaign['str_id'].'">'.esc_html($campaign['title']).($campaign['blocked'] == 1 ? ' '.__('[blocked]', 'ulp') : '').'</option>';
				}
			}
		}
		if (sizeof($popups) > 0 || sizeof($campaigns) > 0) {
			echo '
								<option disabled="disabled">------------------</option>';
		}
		if ($this->options['onload_popup_mobile'] == 'same') {
			$checked = true;
			echo '
								<option value="same" selected="selected">'.__('Same as for desktops', 'ulp').'</option>';
		} else {
			echo '
								<option value="same">'.__('Same as for desktops', 'ulp').'</option>';
		}
		echo '
								<option value=""'.(!$checked ? ' selected="selected"' : '').'>'.__('None (disabled)', 'ulp').'</option>
							</select>
							<br /><em>'.__('Select popup or A/B campaign to be displayed on page load.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('Display mode', 'ulp').':</th>
						<td style="line-height: 1.8; vertical-align: middle;">';
		foreach ($this->display_modes as $key => $value) {
			$value = str_replace('%X', '<input type="text" name="ulp_onload_period" id="ulp_onload_period" class="ic_input_number_short" value="'.$this->options['onload_period'].'">', $value);
			echo '
							<input type="radio" name="ulp_onload_mode" id="ulp_onload_mode" value="'.$key.'"'.($this->options['onload_mode'] == $key ? ' checked="checked"' : '').'> '.$value.'<br />';
		}
		echo '
							<em>'.__('Select the popup display mode.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('Start delay', 'ulp').':</th>
						<td style="vertical-align: middle;">
							<input type="text" name="ulp_onload_delay" value="'.esc_html($this->options['onload_delay']).'" class="ic_input_number" placeholder="Delay"> '.__('seconds', 'ulp').'
							<br /><em>'.__('Popup appears with this delay after page loaded. Set "0" for immediate start.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('Autoclose delay', 'ulp').':</th>
						<td style="vertical-align: middle;">
							<input type="text" name="ulp_onload_close_delay" value="'.esc_html($this->options['onload_close_delay']).'" class="ic_input_number" placeholder="Autoclose delay"> '.__('seconds', 'ulp').'
							<br /><em>'.__('Popup is automatically closed after this period of time. Set "0", if you do not need autoclosing.', 'ulp').'</em>
						</td>
					</tr>
				</table>
				<h3>'.__('OnScroll Settings', 'ulp').'</h3>
				<table class="ulp_useroptions">
					<tr>
						<th>'.__('Popup or A/B Campaign', 'ulp').':</th>
						<td style="vertical-align: middle; line-height: 1.6;">
							<strong>'.__('For desktops:', 'ulp').'</strong><br />
							<select id="ulp_onscroll_popup" name="ulp_onscroll_popup">';
		//$popups = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."ulp_popups WHERE deleted = '0' ORDER BY title ASC", ARRAY_A);
		$checked = false;
		if (sizeof($popups) > 0) {
			echo '
								<option disabled="disabled">--------- '.__('Popups', 'ulp').' ---------</option>';
			foreach($popups as $popup) {
				if ($this->options['onscroll_popup'] == $popup['str_id']) {
					$checked = true;
					echo '
								<option value="'.$popup['str_id'].'" selected="selected">'.esc_html($popup['title']).($popup['blocked'] == 1 ? ' '.__('[blocked]', 'ulp') : '').'</option>';
				} else {
					echo '
								<option value="'.$popup['str_id'].'">'.esc_html($popup['title']).($popup['blocked'] == 1 ? ' '.__('[blocked]', 'ulp') : '').'</option>';
				}
			}
		}
		//$campaigns = $wpdb->get_results("SELECT t1.*, t2.popups FROM ".$wpdb->prefix."ulp_campaigns t1 JOIN (SELECT COUNT(*) AS popups, tt1.campaign_id FROM ".$wpdb->prefix."ulp_campaign_items tt1 JOIN ".$wpdb->prefix."ulp_popups tt2 ON tt2.id = tt1.popup_id WHERE tt1.deleted = '0' AND tt2.deleted = '0' GROUP BY tt1.campaign_id) t2 ON t2.campaign_id = t1.id WHERE t1.deleted = '0' AND t2.popups > 0 ORDER BY t1.title ASC", ARRAY_A);
		if (sizeof($campaigns) > 0) {
			echo '
								<option disabled="disabled">--------- '.__('A/B Campaigns', 'ulp').' ---------</option>';
			foreach($campaigns as $campaign) {
				if ($this->options['onscroll_popup'] == $campaign['str_id']) {
					$checked = true;
					echo '
								<option value="'.$campaign['str_id'].'" selected="selected">'.esc_html($campaign['title']).($campaign['blocked'] == 1 ? ' '.__('[blocked]', 'ulp') : '').'</option>';
				} else {
					echo '
								<option value="'.$campaign['str_id'].'">'.esc_html($campaign['title']).($campaign['blocked'] == 1 ? ' '.__('[blocked]', 'ulp') : '').'</option>';
				}
			}
		}
		if (sizeof($popups) > 0 || sizeof($campaigns) > 0) {
			echo '
								<option disabled="disabled">------------------</option>';
		}
		echo '
								<option value=""'.(!$checked ? ' selected="selected"' : '').'>'.__('None (disabled)', 'ulp').'</option>
							</select>
							<br /><strong>'.__('For mobile devices (smartphones):', 'ulp').'</strong><br />
							<select id="ulp_onscroll_popup_mobile" name="ulp_onscroll_popup_mobile">';
		//$popups = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."ulp_popups WHERE deleted = '0' ORDER BY title ASC", ARRAY_A);
		$checked = false;
		if (sizeof($popups) > 0) {
			echo '
								<option disabled="disabled">--------- '.__('Popups', 'ulp').' ---------</option>';
			foreach($popups as $popup) {
				if ($this->options['onscroll_popup_mobile'] == $popup['str_id']) {
					$checked = true;
					echo '
								<option value="'.$popup['str_id'].'" selected="selected">'.esc_html($popup['title']).($popup['blocked'] == 1 ? ' '.__('[blocked]', 'ulp') : '').'</option>';
				} else {
					echo '
								<option value="'.$popup['str_id'].'">'.esc_html($popup['title']).($popup['blocked'] == 1 ? ' '.__('[blocked]', 'ulp') : '').'</option>';
				}
			}
		}
		//$campaigns = $wpdb->get_results("SELECT t1.*, t2.popups FROM ".$wpdb->prefix."ulp_campaigns t1 JOIN (SELECT COUNT(*) AS popups, tt1.campaign_id FROM ".$wpdb->prefix."ulp_campaign_items tt1 JOIN ".$wpdb->prefix."ulp_popups tt2 ON tt2.id = tt1.popup_id WHERE tt1.deleted = '0' AND tt2.deleted = '0' GROUP BY tt1.campaign_id) t2 ON t2.campaign_id = t1.id WHERE t1.deleted = '0' AND t2.popups > 0 ORDER BY t1.title ASC", ARRAY_A);
		if (sizeof($campaigns) > 0) {
			echo '
								<option disabled="disabled">--------- '.__('A/B Campaigns', 'ulp').' ---------</option>';
			foreach($campaigns as $campaign) {
				if ($this->options['onscroll_popup_mobile'] == $campaign['str_id']) {
					$checked = true;
					echo '
								<option value="'.$campaign['str_id'].'" selected="selected">'.esc_html($campaign['title']).($campaign['blocked'] == 1 ? ' '.__('[blocked]', 'ulp') : '').'</option>';
				} else {
					echo '
								<option value="'.$campaign['str_id'].'">'.esc_html($campaign['title']).($campaign['blocked'] == 1 ? ' '.__('[blocked]', 'ulp') : '').'</option>';
				}
			}
		}
		if (sizeof($popups) > 0 || sizeof($campaigns) > 0) {
			echo '
								<option disabled="disabled">------------------</option>';
		}
		if ($this->options['onscroll_popup_mobile'] == 'same') {
			$checked = true;
			echo '
								<option value="same" selected="selected">'.__('Same as for desktops', 'ulp').'</option>';
		} else {
			echo '
								<option value="same">'.__('Same as for desktops', 'ulp').'</option>';
		}
		echo '
								<option value=""'.(!$checked ? ' selected="selected"' : '').'>'.__('None (disabled)', 'ulp').'</option>
							</select>
							<br /><em>'.__('Select popup or A/B campaign to be displayed on scrolling down.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('Display mode', 'ulp').':</th>
						<td style="line-height: 1.8; vertical-align: middle;">';
		foreach ($this->display_modes as $key => $value) {
			$value = str_replace('%X', '<input type="text" name="ulp_onscroll_period" id="ulp_onscroll_period" class="ic_input_number_short" value="'.$this->options['onscroll_period'].'">', $value);
			echo '
							<input type="radio" name="ulp_onscroll_mode" id="ulp_onscroll_mode" value="'.$key.'"'.($this->options['onscroll_mode'] == $key ? ' checked="checked"' : '').'> '.$value.'<br />';
		}
		echo '
							<em>'.__('Select the popup display mode.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('Scrolling offset', 'ulp').':</th>
						<td style="vertical-align: middle;">
							<input type="text" name="ulp_onscroll_offset" value="'.esc_html($this->options['onscroll_offset']).'" class="ic_input_number" placeholder="Offset"> '.__('pixels', 'ulp').'
							<br /><em>'.__('Popup appears when user scroll down to this number of pixels.', 'ulp').'</em>
						</td>
					</tr>
				</table>
				<h3>'.__('OnExit Settings', 'ulp').'</h3>
				<table class="ulp_useroptions">
					<tr>
						<th>'.__('Popup or A/B Campaign', 'ulp').':</th>
						<td style="vertical-align: middle; line-height: 1.6;">
							<strong>'.__('For desktops:', 'ulp').'</strong><br />
							<select id="ulp_onexit_popup" name="ulp_onexit_popup">';
		//$popups = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."ulp_popups WHERE deleted = '0' ORDER BY title ASC", ARRAY_A);
		$checked = false;
		if (sizeof($popups) > 0) {
			echo '
								<option disabled="disabled">--------- '.__('Popups', 'ulp').' ---------</option>';
			foreach($popups as $popup) {
				if ($this->options['onexit_popup'] == $popup['str_id']) {
					$checked = true;
					echo '
								<option value="'.$popup['str_id'].'" selected="selected">'.esc_html($popup['title']).($popup['blocked'] == 1 ? ' '.__('[blocked]', 'ulp') : '').'</option>';
				} else {
					echo '
								<option value="'.$popup['str_id'].'">'.esc_html($popup['title']).($popup['blocked'] == 1 ? ' '.__('[blocked]', 'ulp') : '').'</option>';
				}
			}
		}
		//$campaigns = $wpdb->get_results("SELECT t1.*, t2.popups FROM ".$wpdb->prefix."ulp_campaigns t1 JOIN (SELECT COUNT(*) AS popups, tt1.campaign_id FROM ".$wpdb->prefix."ulp_campaign_items tt1 JOIN ".$wpdb->prefix."ulp_popups tt2 ON tt2.id = tt1.popup_id WHERE tt1.deleted = '0' AND tt2.deleted = '0' GROUP BY tt1.campaign_id) t2 ON t2.campaign_id = t1.id WHERE t1.deleted = '0' AND t2.popups > 0 ORDER BY t1.title ASC", ARRAY_A);
		if (sizeof($campaigns) > 0) {
			echo '
								<option disabled="disabled">--------- '.__('A/B Campaigns', 'ulp').' ---------</option>';
			foreach($campaigns as $campaign) {
				if ($this->options['onexit_popup'] == $campaign['str_id']) {
					$checked = true;
					echo '
								<option value="'.$campaign['str_id'].'" selected="selected">'.esc_html($campaign['title']).($campaign['blocked'] == 1 ? ' '.__('[blocked]', 'ulp') : '').'</option>';
				} else {
					echo '
								<option value="'.$campaign['str_id'].'">'.esc_html($campaign['title']).($campaign['blocked'] == 1 ? ' '.__('[blocked]', 'ulp') : '').'</option>';
				}
			}
		}
		if (sizeof($popups) > 0 || sizeof($campaigns) > 0) {
			echo '
								<option disabled="disabled">------------------</option>';
		}
		echo '
								<option value=""'.(!$checked ? ' selected="selected"' : '').'>'.__('None (disabled)', 'ulp').'</option>
							</select>
							<br /><strong>'.__('For mobile devices (smartphones):', 'ulp').'</strong><br />
							<select id="ulp_onexit_popup_mobile" name="ulp_onexit_popup_mobile">';
		//$popups = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."ulp_popups WHERE deleted = '0' ORDER BY title ASC", ARRAY_A);
		$checked = false;
		if (sizeof($popups) > 0) {
			echo '
								<option disabled="disabled">--------- '.__('Popups', 'ulp').' ---------</option>';
			foreach($popups as $popup) {
				if ($this->options['onexit_popup_mobile'] == $popup['str_id']) {
					$checked = true;
					echo '
								<option value="'.$popup['str_id'].'" selected="selected">'.esc_html($popup['title']).($popup['blocked'] == 1 ? ' '.__('[blocked]', 'ulp') : '').'</option>';
				} else {
					echo '
								<option value="'.$popup['str_id'].'">'.esc_html($popup['title']).($popup['blocked'] == 1 ? ' '.__('[blocked]', 'ulp') : '').'</option>';
				}
			}
		}
		//$campaigns = $wpdb->get_results("SELECT t1.*, t2.popups FROM ".$wpdb->prefix."ulp_campaigns t1 JOIN (SELECT COUNT(*) AS popups, tt1.campaign_id FROM ".$wpdb->prefix."ulp_campaign_items tt1 JOIN ".$wpdb->prefix."ulp_popups tt2 ON tt2.id = tt1.popup_id WHERE tt1.deleted = '0' AND tt2.deleted = '0' GROUP BY tt1.campaign_id) t2 ON t2.campaign_id = t1.id WHERE t1.deleted = '0' AND t2.popups > 0 ORDER BY t1.title ASC", ARRAY_A);
		if (sizeof($campaigns) > 0) {
			echo '
								<option disabled="disabled">--------- '.__('A/B Campaigns', 'ulp').' ---------</option>';
			foreach($campaigns as $campaign) {
				if ($this->options['onexit_popup_mobile'] == $campaign['str_id']) {
					$checked = true;
					echo '
								<option value="'.$campaign['str_id'].'" selected="selected">'.esc_html($campaign['title']).($campaign['blocked'] == 1 ? ' '.__('[blocked]', 'ulp') : '').'</option>';
				} else {
					echo '
								<option value="'.$campaign['str_id'].'">'.esc_html($campaign['title']).($campaign['blocked'] == 1 ? ' '.__('[blocked]', 'ulp') : '').'</option>';
				}
			}
		}
		if (sizeof($popups) > 0 || sizeof($campaigns) > 0) {
			echo '
								<option disabled="disabled">------------------</option>';
		}
		if ($this->options['onexit_popup_mobile'] == 'same') {
			$checked = true;
			echo '
								<option value="same" selected="selected">'.__('Same as for desktops', 'ulp').'</option>';
		} else {
			echo '
								<option value="same">'.__('Same as for desktops', 'ulp').'</option>';
		}
		echo '
								<option value=""'.(!$checked ? ' selected="selected"' : '').'>'.__('None (disabled)', 'ulp').'</option>
							</select>
							<br /><em>'.__('Select popup or A/B campaign to be displayed on exit intent.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('Display mode', 'ulp').':</th>
						<td style="line-height: 1.8; vertical-align: middle;">';
		foreach ($this->display_modes as $key => $value) {
			$value = str_replace('%X', '<input type="text" name="ulp_onexit_period" id="ulp_onexit_period" class="ic_input_number_short" value="'.$this->options['onexit_period'].'">', $value);
			echo '
							<input type="radio" name="ulp_onexit_mode" id="ulp_onexit_mode" value="'.$key.'"'.($this->options['onexit_mode'] == $key ? ' checked="checked"' : '').'> '.$value.'<br />';
		}
		echo '
							<em>'.__('Select the popup display mode.', 'ulp').'</em>
						</td>
					</tr>
				</table>
				<h3>'.__('OnInactivity Settings', 'ulp').'</h3>
				<table class="ulp_useroptions">
					<tr>
						<th>'.__('Popup or A/B Campaign', 'ulp').':</th>
						<td style="vertical-align: middle; line-height: 1.6;">
							<strong>'.__('For desktops:', 'ulp').'</strong><br />
							<select id="ulp_onidle_popup" name="ulp_onidle_popup">';
		//$popups = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."ulp_popups WHERE deleted = '0' ORDER BY title ASC", ARRAY_A);
		$checked = false;
		if (sizeof($popups) > 0) {
			echo '
								<option disabled="disabled">--------- '.__('Popups', 'ulp').' ---------</option>';
			foreach($popups as $popup) {
				if ($this->options['onidle_popup'] == $popup['str_id']) {
					$checked = true;
					echo '
								<option value="'.$popup['str_id'].'" selected="selected">'.esc_html($popup['title']).($popup['blocked'] == 1 ? ' '.__('[blocked]', 'ulp') : '').'</option>';
				} else {
					echo '
								<option value="'.$popup['str_id'].'">'.esc_html($popup['title']).($popup['blocked'] == 1 ? ' '.__('[blocked]', 'ulp') : '').'</option>';
				}
			}
		}
		//$campaigns = $wpdb->get_results("SELECT t1.*, t2.popups FROM ".$wpdb->prefix."ulp_campaigns t1 JOIN (SELECT COUNT(*) AS popups, tt1.campaign_id FROM ".$wpdb->prefix."ulp_campaign_items tt1 JOIN ".$wpdb->prefix."ulp_popups tt2 ON tt2.id = tt1.popup_id WHERE tt1.deleted = '0' AND tt2.deleted = '0' GROUP BY tt1.campaign_id) t2 ON t2.campaign_id = t1.id WHERE t1.deleted = '0' AND t2.popups > 0 ORDER BY t1.title ASC", ARRAY_A);
		if (sizeof($campaigns) > 0) {
			echo '
								<option disabled="disabled">--------- '.__('A/B Campaigns', 'ulp').' ---------</option>';
			foreach($campaigns as $campaign) {
				if ($this->options['onidle_popup'] == $campaign['str_id']) {
					$checked = true;
					echo '
								<option value="'.$campaign['str_id'].'" selected="selected">'.esc_html($campaign['title']).($campaign['blocked'] == 1 ? ' '.__('[blocked]', 'ulp') : '').'</option>';
				} else {
					echo '
								<option value="'.$campaign['str_id'].'">'.esc_html($campaign['title']).($campaign['blocked'] == 1 ? ' '.__('[blocked]', 'ulp') : '').'</option>';
				}
			}
		}
		if (sizeof($popups) > 0 || sizeof($campaigns) > 0) {
			echo '
								<option disabled="disabled">------------------</option>';
		}
		echo '
								<option value=""'.(!$checked ? ' selected="selected"' : '').'>'.__('None (disabled)', 'ulp').'</option>
							</select>
							<br /><strong>'.__('For mobile devices (smartphones):', 'ulp').'</strong><br />
							<select id="ulp_onidle_popup_mobile" name="ulp_onidle_popup_mobile">';
		//$popups = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."ulp_popups WHERE deleted = '0' ORDER BY title ASC", ARRAY_A);
		$checked = false;
		if (sizeof($popups) > 0) {
			echo '
								<option disabled="disabled">--------- '.__('Popups', 'ulp').' ---------</option>';
			foreach($popups as $popup) {
				if ($this->options['onidle_popup_mobile'] == $popup['str_id']) {
					$checked = true;
					echo '
								<option value="'.$popup['str_id'].'" selected="selected">'.esc_html($popup['title']).($popup['blocked'] == 1 ? ' '.__('[blocked]', 'ulp') : '').'</option>';
				} else {
					echo '
								<option value="'.$popup['str_id'].'">'.esc_html($popup['title']).($popup['blocked'] == 1 ? ' '.__('[blocked]', 'ulp') : '').'</option>';
				}
			}
		}
		//$campaigns = $wpdb->get_results("SELECT t1.*, t2.popups FROM ".$wpdb->prefix."ulp_campaigns t1 JOIN (SELECT COUNT(*) AS popups, tt1.campaign_id FROM ".$wpdb->prefix."ulp_campaign_items tt1 JOIN ".$wpdb->prefix."ulp_popups tt2 ON tt2.id = tt1.popup_id WHERE tt1.deleted = '0' AND tt2.deleted = '0' GROUP BY tt1.campaign_id) t2 ON t2.campaign_id = t1.id WHERE t1.deleted = '0' AND t2.popups > 0 ORDER BY t1.title ASC", ARRAY_A);
		if (sizeof($campaigns) > 0) {
			echo '
								<option disabled="disabled">--------- '.__('A/B Campaigns', 'ulp').' ---------</option>';
			foreach($campaigns as $campaign) {
				if ($this->options['onidle_popup_mobile'] == $campaign['str_id']) {
					$checked = true;
					echo '
								<option value="'.$campaign['str_id'].'" selected="selected">'.esc_html($campaign['title']).($campaign['blocked'] == 1 ? ' '.__('[blocked]', 'ulp') : '').'</option>';
				} else {
					echo '
								<option value="'.$campaign['str_id'].'">'.esc_html($campaign['title']).($campaign['blocked'] == 1 ? ' '.__('[blocked]', 'ulp') : '').'</option>';
				}
			}
		}
		if (sizeof($popups) > 0 || sizeof($campaigns) > 0) {
			echo '
								<option disabled="disabled">------------------</option>';
		}
		if ($this->options['onidle_popup_mobile'] == 'same') {
			$checked = true;
			echo '
								<option value="same" selected="selected">'.__('Same as for desktops', 'ulp').'</option>';
		} else {
			echo '
								<option value="same">'.__('Same as for desktops', 'ulp').'</option>';
		}
		echo '
								<option value=""'.(!$checked ? ' selected="selected"' : '').'>'.__('None (disabled)', 'ulp').'</option>
							</select>
							<br /><em>'.__('Select popup or A/B campaign to be displayed on user inactivity.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('Display mode', 'ulp').':</th>
						<td style="line-height: 1.8; vertical-align: middle;">';
		foreach ($this->display_modes as $key => $value) {
			$value = str_replace('%X', '<input type="text" name="ulp_onidle_period" id="ulp_onidle_period" class="ic_input_number_short" value="'.$this->options['onidle_period'].'">', $value);
			echo '
							<input type="radio" name="ulp_onidle_mode" id="ulp_onidle_mode" value="'.$key.'"'.($this->options['onidle_mode'] == $key ? ' checked="checked"' : '').'> '.$value.'<br />';
		}
		echo '
							<em>'.__('Select the popup display mode.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('Period of inactivity', 'ulp').':</th>
						<td style="vertical-align: middle;">
							<input type="text" name="ulp_onidle_delay" value="'.esc_html($this->options['onidle_delay']).'" class="ic_input_number" placeholder="seconds"> '.__('seconds', 'ulp').'
							<br /><em>'.__('The popup appears after this period of inactivity.', 'ulp').'</em>
						</td>
					</tr>
				</table>';
		if (apply_filters('ulp_use_mailing', false)) {
			echo '
				<h3>'.__('Mailing Settings', 'ulp').'</h3>
				<table class="ulp_useroptions">
					<tr>
						<th>'.__('Sender name', 'ulp').':</th>
						<td>
							<input type="text" id="ulp_from_name" name="ulp_from_name" value="'.esc_html($this->options['from_name']).'" class="widefat">
							<br /><em>'.__('Please enter sender name. All messages from plugin are sent using this name as "FROM:" header value.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('Sender e-mail', 'ulp').':</th>
						<td>
							<input type="text" id="ulp_from_email" name="ulp_from_email" value="'.esc_html($this->options['from_email']).'" class="widefat">
							<br /><em>'.__('Please enter sender e-mail. All messages from plugin are sent using this e-mail as "FROM:" header value.', 'ulp').'</em>
						</td>
					</tr>
				</table>';
		}
		echo '
				<h3>'.__('Miscellaneous', 'ulp').'</h3>
				<table class="ulp_useroptions">
					<tr>
						<th>'.__('Single subscription', 'ulp').':</th>
						<td>
							<input type="checkbox" id="ulp_onexit_limits" name="ulp_onexit_limits" '.($this->options['onexit_limits'] == "on" ? 'checked="checked"' : '').'"> '.__('Disable all event popups if user subscribed through any popup or inline form', 'ulp').'
							<br /><em>'.__('Disable event popups (OnLoad, OnExit, OnScroll, OnInactivity), if user subscribed through any popup or inline form.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('Use event popups only', 'ulp').':</th>
						<td>
							<input type="checkbox" id="ulp_onload_only" name="ulp_onload_only" '.($this->options['onload_only'] == "on" ? 'checked="checked"' : '').'"> '.__('Use event popups only', 'ulp').'
							<br /><em>'.__('If you turn this option on, only event popups (OnLoad, OnExit, OnScroll, OnInactivity) will be loaded with website pages. If you disable this feature, all active popups will be loaded.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('Do not pre-load popups', 'ulp').':</th>
						<td>
							<input type="checkbox" id="ulp_no_preload" name="ulp_no_preload" '.($this->options['no_preload'] == "on" ? 'checked="checked"' : '').'"> '.__('Do not pre-load popups', 'ulp').'
							<br /><em>'.__('Tick checkbox to disable popups pre-load. Popup will be pulled using AJAX.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('CSV column separator', 'ulp').':</th>
						<td>
							<select id="ulp_csv_separator" name="ulp_csv_separator">
								<option value=";"'.($this->options['csv_separator'] == ';' ? ' selected="selected"' : '').'>'.__('Semicolon - ";"', 'ulp').'</option>
								<option value=","'.($this->options['csv_separator'] == ',' ? ' selected="selected"' : '').'>'.__('Comma - ","', 'ulp').'</option>
								<option value="tab"'.($this->options['csv_separator'] == 'tab' ? ' selected="selected"' : '').'>'.__('Tab', 'ulp').'</option>
							</select>
							<br /><em>'.__('Please select CSV column separator.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('Extended e-mail validation', 'ulp').':</th>
						<td>
							<input type="checkbox" id="ulp_email_validation" name="ulp_email_validation" '.($this->options['email_validation'] == "on" ? 'checked="checked"' : '').'"> '.__('Enable extended e-mail address validation', 'ulp').'
							<br /><em>'.__('If you turn this option on, the plugin will check MX records according to the host provided within the email address. PHP 5 >= 5.3 required!', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('Google Analytics tracking', 'ulp').':</th>
						<td>
							<input type="checkbox" id="ulp_ga_tracking" name="ulp_ga_tracking" '.($this->options['ga_tracking'] == "on" ? 'checked="checked"' : '').'"> '.__('Enable Google Analytics tracking', 'ulp').'
							<br /><em>'.__('Send popup events to Google Analytics. Google Analytics must be installed on your website.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('KISSmetrics tracking', 'ulp').':</th>
						<td>
							<input type="checkbox" id="ulp_km_tracking" name="ulp_km_tracking" '.($this->options['km_tracking'] == "on" ? 'checked="checked"' : '').'"> '.__('Enable KISSmetrics tracking', 'ulp').'
							<br /><em>'.__('Identify the current person with a e-mail address submitted through opt-in form. KISSmetrics must be installed on your website.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('Font Awesome icons', 'ulp').':</th>
						<td>
							<input type="checkbox" id="ulp_fa_enable" name="ulp_fa_enable" '.($this->options['fa_enable'] == "on" ? 'checked="checked"' : '').'"> '.__('Enable Font Awesome icons', 'ulp').'
							<br /><em>'.__('Enable Font Awesome icons.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th></th>
						<td>
							<input type="checkbox" id="ulp_fa_css_disable" name="ulp_fa_css_disable" '.($this->options['fa_css_disable'] == "on" ? 'checked="checked"' : '').'"> '.__('Disable Font Awesome CSS loading', 'ulp').'
							<br /><em>'.__('If your theme or another plugin load Font Awesome, you can turn it off to avoid conflicts.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('CSS3 animation', 'ulp').':</th>
						<td>
							<input type="checkbox" id="ulp_css3_enable" name="ulp_css3_enable" '.($this->options['css3_enable'] == "on" ? 'checked="checked"' : '').'"> '.__('Enable CSS3 animation', 'ulp').'
							<br /><em>'.__('Activate CSS3 animation (driven by <a href="http://daneden.github.io/animate.css/" target="_blank">Animate.css</a>).', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('Disable event popups for', 'ulp').':</th>
						<td style="line-height: 1.7;">';
		$roles = get_editable_roles();
		if (sizeof($roles) > 0) {
			echo '
							<input type="hidden" name="ulp_edit_roles" value="1">';
			foreach ($roles as $key => $value) {
				echo '
							<input type="checkbox" name="ulp_role_'.$key.'"'.(in_array($key, $this->options['disable_roles']) ? ' checked="checked"' : '').'> '.$value['name'].'<br />';
			}
		}
		echo '
							<em>'.__('Event popups (OnLoad, OnExit, OnScroll, OnInactivity) will never be displayed for these user roles!', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('Reset cookie', 'ulp').':</th>
						<td>
							<input type="button" class="ulp_button button-secondary" value="'.__('Reset cookie', 'ulp').'" onclick="return ulp_reset_cookie();" >
							<img id="ulp-reset-loading" class="ulp-loading" src="'.plugins_url('/images/loading.gif', __FILE__).'">
							<br /><em>'.__('Click the button to reset cookie. Popup will appear for all users. Do this operation if you changed content in popup and want to display it for returning visitors.', 'ulp').'</em>
						</td>
					</tr>
				</table>
				<h3>'.__('reCAPTCHA Settings', 'ulp').' <span class="ulp-badge ulp-badge-beta">Beta</span></h3>
				<table class="ulp_useroptions">
					<tr>
						<th>'.__('Enable reCAPTCHA', 'ulp').':</th>
						<td>
							<input type="checkbox" id="ulp_recaptcha_enable" name="ulp_recaptcha_enable" '.($this->options['recaptcha_enable'] == "on" ? 'checked="checked"' : '').'"> '.__('Enable reCAPTCHA', 'ulp').'
							<br /><em>'.__('Enable reCAPTCHA.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th></th>
						<td>
							<input type="checkbox" id="ulp_recaptcha_js_disable" name="ulp_recaptcha_js_disable" '.($this->options['recaptcha_js_disable'] == "on" ? 'checked="checked"' : '').'"> '.__('Disable reCAPTCHA library loading', 'ulp').'
							<br /><em>'.__('If your theme or another plugin load reCAPTCHA library, you can turn it off to avoid conflicts.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('Public key', 'ulp').':</th>
						<td>
							<input type="text" id="ulp_recaptcha_public_key" name="ulp_recaptcha_public_key" value="'.esc_html($this->options['recaptcha_public_key']).'" class="widefat">
							<br /><em>'.__('Please enter Public Key, generated <a href="https://www.google.com/recaptcha/">here</a>.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('Secret key', 'ulp').':</th>
						<td>
							<input type="text" id="ulp_recaptcha_secret_key" name="ulp_recaptcha_secret_key" value="'.esc_html($this->options['recaptcha_secret_key']).'" class="widefat">
							<br /><em>'.__('Please enter Secret Key, generated <a href="https://www.google.com/recaptcha/">here</a>.', 'ulp').'</em>
						</td>
					</tr>
				</table>';
		do_action('ulp_options_show');
		echo '
				<h3>'.__('Item Purchase Code', 'ulp').'</h3>
				<table class="ulp_useroptions">
					<tr>
						<th>'.__('Item Purchase Code', 'ulp').':</th>
						<td>
							<input type="text" id="ulp_purchase_code" name="ulp_purchase_code" value="'.esc_html($this->options['purchase_code']).'" class="widefat">
							<br /><em>'.__('To activate automatic update feature please enter Item Purchase Code. Item Purchase Code goes with your license.', 'ulp').' <a target="_blank" href="https://help.market.envato.com/hc/en-us/articles/202822600">'.__('Where can I find my Purchase Code?', 'ulp').'</a></em>
						</td>
					</tr>
					</tr>
				</table>
				<hr>
				<div style="text-align: right; margin-bottom: 5px; margin-top: 20px;">
					<!-- <a href="'.admin_url('admin.php').'?page=ulp-settings&mode=ext" style="float: left;">'.__('Advanced Settings', 'ulp').'</a> -->
					<input type="hidden" name="action" value="ulp_save_settings" />
					<img id="ulp-save-loading" class="ulp-loading" src="'.plugins_url('/images/loading.gif', __FILE__).'">
					<input type="submit" class="button-primary ulp-button" name="submit" value="'.__('Save Settings', 'ulp').'" onclick="return ulp_save_settings();">
				</div>
				<div class="ulp-message"></div>
			</div>
			</form>
		</div>';
	}
	
	function reset_cookie() {
		if (current_user_can('manage_options')) {
			$this->options["cookie_value"] = time();
			update_option('ulp_cookie_value', $this->options["cookie_value"]);
			echo 'OK';
		}
		exit;
	}

	function save_settings() {
		global $wpdb;
		$popup_options = array();
		if (current_user_can('manage_options')) {
			if (!empty($_POST['ulp_purchase_code']) && $_POST['ulp_purchase_code'] != $this->options['purchase_code']) {
				delete_option('_site_transient_update_plugins');
			}
			$this->populate_options();
			if (isset($_POST['ulp_onload_only'])) $this->options['onload_only'] = 'on';
			else $this->options['onload_only'] = 'off';
			if (isset($_POST['ulp_onexit_limits'])) $this->options['onexit_limits'] = 'on';
			else $this->options['onexit_limits'] = 'off';
			if (isset($_POST['ulp_email_validation'])) $this->options['email_validation'] = 'on';
			else $this->options['email_validation'] = 'off';
			if (isset($_POST['ulp_css3_enable'])) $this->options['css3_enable'] = 'on';
			else $this->options['css3_enable'] = 'off';
			if (isset($_POST['ulp_ga_tracking'])) $this->options['ga_tracking'] = 'on';
			else $this->options['ga_tracking'] = 'off';
			if (isset($_POST['ulp_km_tracking'])) $this->options['km_tracking'] = 'on';
			else $this->options['km_tracking'] = 'off';
			if (isset($_POST['ulp_no_preload'])) $this->options['no_preload'] = 'on';
			else $this->options['no_preload'] = 'off';
			if (isset($_POST['ulp_fa_enable'])) $this->options['fa_enable'] = 'on';
			else $this->options['fa_enable'] = 'off';
			if (isset($_POST["ulp_fa_css_disable"])) $this->options['fa_css_disable'] = "on";
			else $this->options['fa_css_disable'] = "off";
			if (isset($_POST['ulp_recaptcha_enable'])) $this->options['recaptcha_enable'] = 'on';
			else $this->options['recaptcha_enable'] = 'off';
			if (isset($_POST["ulp_recaptcha_js_disable"])) $this->options['recaptcha_js_disable'] = "on";
			else $this->options['recaptcha_js_disable'] = "off";
			$errors = array();
			if (strlen($this->options['onload_delay']) > 0 && $this->options['onload_delay'] != preg_replace('/[^0-9]/', '', $this->options['onload_delay'])) $errors[] = __('Invalid OnLoad delay value.', 'ulp');
			if (strlen($this->options['onload_close_delay']) > 0 && $this->options['onload_close_delay'] != preg_replace('/[^0-9]/', '', $this->options['onload_close_delay'])) $errors[] = __('Invalid OnLoad autoclosing delay value.', 'ulp');
			if (strlen($this->options['onscroll_offset']) > 0 && $this->options['onscroll_offset'] != preg_replace('/[^0-9]/', '', $this->options['onscroll_offset'])) $errors[] = __('Invalid OnScroll offset value.', 'ulp');
			if (strlen($this->options['onidle_delay']) == 0 || $this->options['onidle_delay'] != preg_replace('/[^0-9]/', '', $this->options['onidle_delay'])) $errors[] = __('Invalid OnInactivity period value.', 'ulp');
			if (apply_filters('ulp_use_mailing', false)) {
				if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,9})$/i", $this->options['from_email']) || strlen($this->options['from_email']) == 0) $errors[] = __('Sender e-mail must be valid e-mail address.', 'ulp');
				if (strlen($this->options['from_name']) < 2) $errors[] = __('Sender name is too short.', 'ulp');
			}
			if (strlen($this->options['onload_period']) == 0 || $this->options['onload_period'] != preg_replace('/[^0-9]/', '', $this->options['onload_period']) || intval($this->options['onload_period']) < 1) $errors[] = __('Invalid OnLoad cookie period.', 'ulp');
			if (strlen($this->options['onscroll_period']) == 0 || $this->options['onscroll_period'] != preg_replace('/[^0-9]/', '', $this->options['onscroll_period']) || intval($this->options['onscroll_period']) < 1) $errors[] = __('Invalid OnScroll cookie period.', 'ulp');
			if (strlen($this->options['onexit_period']) == 0 || $this->options['onexit_period'] != preg_replace('/[^0-9]/', '', $this->options['onexit_period']) || intval($this->options['onexit_period']) < 1) $errors[] = __('Invalid OnExit cookie period.', 'ulp');
			if (strlen($this->options['onidle_period']) == 0 || $this->options['onidle_period'] != preg_replace('/[^0-9]/', '', $this->options['onidle_period']) || intval($this->options['onidle_period']) < 1) $errors[] = __('Invalid OnInactivity cookie period.', 'ulp');
			
			if ($this->options['recaptcha_enable'] == 'on') {
				if (strlen($this->options['recaptcha_public_key']) == 0) $errors[] = __('reCAPTCHA public key can not be empty.', 'ulp');
				if (strlen($this->options['recaptcha_secret_key']) == 0) $errors[] = __('reCAPTCHA secret key can not be empty.', 'ulp');
			}
			
			if (isset($_POST['ulp_edit_roles'])) {
				$this->options['disable_roles'] = array();
				foreach ($_POST as $key => $value) {
					if (substr($key, 0, strlen('ulp_role_')) == 'ulp_role_') $this->options['disable_roles'][] = substr($key, strlen('ulp_role_'));
				}
			}
			
			$errors = apply_filters('ulp_options_check', $errors);
			
			if (!empty($errors)) {
				$return_object = array();
				$return_object['status'] = 'ERROR';
				$return_object['message'] = __('Attention! Please correct the errors below and try again.', 'ulp').'<ul><li>'.implode('</li><li>', $errors).'</li></ul>';
				echo json_encode($return_object);
				exit;
			}
			
			$this->options['purchase_code'] = preg_replace('/[^a-zA-Z0-9-]/', '', $this->options['purchase_code']);
			$this->update_options();
			
			do_action('ulp_options_update');
			
			setcookie("ulp_info", __('Settings successfully <strong>saved</strong>.', 'ulp'), time()+30, "/", ".".str_replace("www.", "", $_SERVER["SERVER_NAME"]));
			
			$return_object = array();
			$return_object['status'] = 'OK';
			$return_object['return_url'] = admin_url('admin.php').'?page=ulp-settings';
			echo json_encode($return_object);
			exit;
		}
	}

	function admin_ext_settings() {
		global $wpdb;

		if (!empty($this->error)) $message = "<div class='error'><p>".$this->error."</p></div>";
		else if (!empty($this->info)) $message = "<div class='updated'><p>".$this->info."</p></div>";
		else $message = '';
		
		if (!in_array('curl', get_loaded_extensions())) {
			$is_curl = false;
			$message .= '<div class="error"><p>'.__('cURL is <strong>not installed</strong>! Some modules are <strong>not available</strong>.', 'ulp').'</p></div>';
		
		} else $is_curl = true;
		
		echo '
		<div class="wrap ulp">
			<div id="icon-options-general" class="icon32"><br /></div><h2>'.__('Layered Popups - Settings', 'ulp').'</h2>
			'.$message.'
			<h2 class="nav-tab-wrapper">
				<a class="nav-tab" href="'.admin_url('admin.php').'?page=ulp-settings">'.__('General', 'ulp').'</a>
				<a class="nav-tab nav-tab-active" href="'.admin_url('admin.php').'?page=ulp-settings&mode=ext">'.__('Advanced', 'ulp').'</a>
			</h2>
			<form class="ulp-popup-form" enctype="multipart/form-data" method="post" style="margin: 0px" action="'.admin_url('admin.php').'">
			<div class="ulp-options" style="width: 100%; position: relative;">
				<h3>'.__('Plugin Modules', 'ulp').'</h3>
				<table class="ulp_useroptions">
					<tr>
						<th>'.__('Plugin modules', 'ulp').':</th>
						<td>
							<input type="checkbox" id="ulp_ext_enable_social" name="ulp_ext_enable_social" '.($this->ext_options['enable_social'] == "on" ? 'checked="checked"' : '').'"> '.__('Activate Social Buttons module', 'ulp').'
							<br /><em>'.__('Tick checkbox if you want to use Social Buttons module (Facebook Like, Google +1, Twitter Tweet, LinkedIn Share).', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th></th>
						<td>
							<input type="checkbox" id="ulp_ext_enable_social2" name="ulp_ext_enable_social2" '.($this->ext_options['enable_social2'] == "on" ? 'checked="checked"' : '').'"> '.__('Activate "Subscribe with Social Media" module', 'ulp').'
							<br /><em>'.__('Tick checkbox if you want to use "Subscribe with Social Media" module (Facebook, Google).', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th></th>
						<td>
							<input type="checkbox" id="ulp_ext_enable_customfields" name="ulp_ext_enable_customfields" '.($this->ext_options['enable_customfields'] == "on" ? 'checked="checked"' : '').'"> '.__('Activate "Custom Fields" module', 'ulp').' <span class="ulp-badge ulp-badge-beta">Beta</span>
							<br /><em>'.__('Tick checkbox if you want to use "Custom Fields" module.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th></th>
						<td>
							<input type="checkbox" id="ulp_ext_enable_mail" name="ulp_ext_enable_mail" '.($this->ext_options['enable_mail'] == "on" ? 'checked="checked"' : '').'"> '.__('Activate Admin Notification module', 'ulp').'
							<br /><em>'.__('Tick checkbox if you want to receive data submitted by subscribers.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th></th>
						<td>
							<input type="checkbox" id="ulp_ext_enable_welcomemail" name="ulp_ext_enable_welcomemail" '.($this->ext_options['enable_welcomemail'] == "on" ? 'checked="checked"' : '').'"> '.__('Activate Welcome Mail module', 'ulp').'
							<br /><em>'.__('Tick checkbox if you want to send Welcome Mail to subscribers.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th></th>
						<td>
							<input '.($is_curl ? '' : 'disabled="disabled" ').'type="checkbox" id="ulp_ext_enable_mailchimp" name="ulp_ext_enable_mailchimp" '.($this->ext_options['enable_mailchimp'] == "on" ? 'checked="checked"' : '').'"> '.__('Activate MailChimp Integration module', 'ulp').'
							<br /><em>'.__('Tick checkbox if you want to integrate popups with MailChimp.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th></th>
						<td>
							<input '.($is_curl ? '' : 'disabled="disabled" ').'type="checkbox" id="ulp_ext_enable_aweber" name="ulp_ext_enable_aweber" '.($this->ext_options['enable_aweber'] == "on" ? 'checked="checked"' : '').'"> '.__('Activate AWeber Integration module', 'ulp').'
							<br /><em>'.__('Tick checkbox if you want to integrate popups with AWeber.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th></th>
						<td>
							<input '.($is_curl ? '' : 'disabled="disabled" ').'type="checkbox" id="ulp_ext_enable_icontact" name="ulp_ext_enable_icontact" '.($this->ext_options['enable_icontact'] == "on" ? 'checked="checked"' : '').'"> '.__('Activate iContact Integration module', 'ulp').'
							<br /><em>'.__('Tick checkbox if you want to integrate popups with iContact.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th></th>
						<td>
							<input '.($is_curl ? '' : 'disabled="disabled" ').'type="checkbox" id="ulp_ext_enable_getresponse" name="ulp_ext_enable_getresponse" '.($this->ext_options['enable_getresponse'] == "on" ? 'checked="checked"' : '').'"> '.__('Activate GetResponse Integration module', 'ulp').'
							<br /><em>'.__('Tick checkbox if you want to integrate popups with GetResponse.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th></th>
						<td>
							<input '.($is_curl ? '' : 'disabled="disabled" ').'type="checkbox" id="ulp_ext_enable_madmimi" name="ulp_ext_enable_madmimi" '.($this->ext_options['enable_madmimi'] == "on" ? 'checked="checked"' : '').'"> '.__('Activate Mad Mimi Integration module', 'ulp').'
							<br /><em>'.__('Tick checkbox if you want to integrate popups with Mad Mimi.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th></th>
						<td>
							<input '.($is_curl ? '' : 'disabled="disabled" ').'type="checkbox" id="ulp_ext_enable_campaignmonitor" name="ulp_ext_enable_campaignmonitor" '.($this->ext_options['enable_campaignmonitor'] == "on" ? 'checked="checked"' : '').'"> '.__('Activate Campaign Monitor Integration module', 'ulp').'
							<br /><em>'.__('Tick checkbox if you want to integrate popups with Campaign Monitor.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th></th>
						<td>
							<input '.($is_curl ? '' : 'disabled="disabled" ').'type="checkbox" id="ulp_ext_enable_salesautopilot" name="ulp_ext_enable_salesautopilot" '.($this->ext_options['enable_salesautopilot'] == "on" ? 'checked="checked"' : '').'"> '.__('Activate SalesAutoPilot Integration module', 'ulp').'
							<br /><em>'.__('Tick checkbox if you want to integrate popups with SalesAutoPilot.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th></th>
						<td>
							<input '.($is_curl ? '' : 'disabled="disabled" ').'type="checkbox" id="ulp_ext_enable_activecampaign" name="ulp_ext_enable_activecampaign" '.($this->ext_options['enable_activecampaign'] == "on" ? 'checked="checked"' : '').'"> '.__('Activate Active Campaign Integration module', 'ulp').'
							<br /><em>'.__('Tick checkbox if you want to integrate popups with Active Campaign.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th></th>
						<td>
							<input '.($is_curl ? '' : 'disabled="disabled" ').'type="checkbox" id="ulp_ext_enable_benchmark" name="ulp_ext_enable_benchmark" '.($this->ext_options['enable_benchmark'] == "on" ? 'checked="checked"' : '').'"> '.__('Activate Benchmark Integration module', 'ulp').'
							<br /><em>'.__('Tick checkbox if you want to integrate popups with Benchmark.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th></th>
						<td>
							<input '.($is_curl ? '' : 'disabled="disabled" ').'type="checkbox" id="ulp_ext_enable_sendy" name="ulp_ext_enable_sendy" '.($this->ext_options['enable_sendy'] == "on" ? 'checked="checked"' : '').'"> '.__('Activate Sendy Integration module', 'ulp').'
							<br /><em>'.__('Tick checkbox if you want to integrate popups with Sendy.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th></th>
						<td>
							<input '.($is_curl ? '' : 'disabled="disabled" ').'type="checkbox" id="ulp_ext_enable_ontraport" name="ulp_ext_enable_ontraport" '.($this->ext_options['enable_ontraport'] == "on" ? 'checked="checked"' : '').'"> '.__('Activate Ontraport (Office Auto Pilot) Integration module', 'ulp').'
							<br /><em>'.__('Tick checkbox if you want to integrate popups with Ontraport (Office Auto Pilot).', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th></th>
						<td>
							<input '.($is_curl ? '' : 'disabled="disabled" ').'type="checkbox" id="ulp_ext_enable_mailerlite" name="ulp_ext_enable_mailerlite" '.($this->ext_options['enable_mailerlite'] == "on" ? 'checked="checked"' : '').'"> '.__('Activate MailerLite Integration module', 'ulp').'
							<br /><em>'.__('Tick checkbox if you want to integrate popups with MailerLite.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th></th>
						<td>
							<input type="checkbox" id="ulp_ext_enable_mymail" name="ulp_ext_enable_mymail" '.($this->ext_options['enable_mymail'] == "on" ? 'checked="checked"' : '').'"> '.__('Activate MyMail Integration module', 'ulp').'
							<br /><em>'.__('Tick checkbox if you want to integrate popups with MyMail.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th></th>
						<td>
							<input type="checkbox" id="ulp_ext_enable_mailpoet" name="ulp_ext_enable_mailpoet" '.($this->ext_options['enable_mailpoet'] == "on" ? 'checked="checked"' : '').'"> '.__('Activate MailPoet (WISYJA) Integration module', 'ulp').'
							<br /><em>'.__('Tick checkbox if you want to integrate popups with MailPoet (WYSIJA).', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th></th>
						<td>
							<input type="checkbox" id="ulp_ext_enable_sendpress" name="ulp_ext_enable_sendpress" '.($this->ext_options['enable_sendpress'] == "on" ? 'checked="checked"' : '').'"> '.__('Activate SendPress Integration module', 'ulp').'
							<br /><em>'.__('Tick checkbox if you want to integrate popups with SendPress.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th></th>
						<td>
							<input '.($is_curl ? '' : 'disabled="disabled" ').'type="checkbox" id="ulp_ext_enable_interspire" name="ulp_ext_enable_interspire" '.($this->ext_options['enable_interspire'] == "on" ? 'checked="checked"' : '').'"> '.__('Activate Interspire Integration module', 'ulp').'
							<br /><em>'.__('Tick checkbox if you want to integrate popups with Interspire.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th></th>
						<td>
							<input '.($is_curl ? '' : 'disabled="disabled" ').'type="checkbox" id="ulp_ext_enable_ymlp" name="ulp_ext_enable_ymlp" '.($this->ext_options['enable_ymlp'] == "on" ? 'checked="checked"' : '').'"> '.__('Activate Your Mailing List Provider Integration module', 'ulp').'
							<br /><em>'.__('Tick checkbox if you want to integrate popups with Your Mailing List Provider.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th></th>
						<td>
							<input '.($is_curl ? '' : 'disabled="disabled" ').'type="checkbox" id="ulp_ext_enable_freshmail" name="ulp_ext_enable_freshmail" '.($this->ext_options['enable_freshmail'] == "on" ? 'checked="checked"' : '').'"> '.__('Activate FreshMail Integration module', 'ulp').'
							<br /><em>'.__('Tick checkbox if you want to integrate popups with FreshMail.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th></th>
						<td>
							<input '.($is_curl ? '' : 'disabled="disabled" ').'type="checkbox" id="ulp_ext_enable_sendreach" name="ulp_ext_enable_sendreach" '.($this->ext_options['enable_sendreach'] == "on" ? 'checked="checked"' : '').'"> '.__('Activate SendReach Integration module', 'ulp').'
							<br /><em>'.__('Tick checkbox if you want to integrate popups with SendReach.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th></th>
						<td>
							<input '.($is_curl ? '' : 'disabled="disabled" ').'type="checkbox" id="ulp_ext_enable_constantcontact" name="ulp_ext_enable_constantcontact" '.($this->ext_options['enable_constantcontact'] == "on" ? 'checked="checked"' : '').'"> '.__('Activate Constant Contact Integration module', 'ulp').'
							<br /><em>'.__('Tick checkbox if you want to integrate popups with Constant Contact.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th></th>
						<td>
							<input '.($is_curl ? '' : 'disabled="disabled" ').'type="checkbox" id="ulp_ext_enable_directmail" name="ulp_ext_enable_directmail" '.($this->ext_options['enable_directmail'] == "on" ? 'checked="checked"' : '').'"> '.__('Activate Direct Mail Integration module', 'ulp').'
							<br /><em>'.__('Tick checkbox if you want to integrate popups with Direct Mail.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th></th>
						<td>
							<input '.($is_curl ? '' : 'disabled="disabled" ').'type="checkbox" id="ulp_ext_enable_mailwizz" name="ulp_ext_enable_mailwizz" '.($this->ext_options['enable_mailwizz'] == "on" ? 'checked="checked"' : '').'"> '.__('Activate MailWizz Integration module', 'ulp').'
							<br /><em>'.__('Tick checkbox if you want to integrate popups with MailWizz.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th></th>
						<td>
							<input '.($is_curl ? '' : 'disabled="disabled" ').'type="checkbox" id="ulp_ext_enable_customerio" name="ulp_ext_enable_customerio" '.($this->ext_options['enable_customerio'] == "on" ? 'checked="checked"' : '').'"> '.__('Activate Customer.io Integration module', 'ulp').'
							<br /><em>'.__('Tick checkbox if you want to integrate popups with Customer.io.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th></th>
						<td>
							<input '.($is_curl ? '' : 'disabled="disabled" ').'type="checkbox" id="ulp_ext_enable_egoi" name="ulp_ext_enable_egoi" '.($this->ext_options['enable_egoi'] == "on" ? 'checked="checked"' : '').'"> '.__('Activate E-goi Integration module', 'ulp').'
							<br /><em>'.__('Tick checkbox if you want to integrate popups with E-goi.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th></th>
						<td>
							<input '.($is_curl ? '' : 'disabled="disabled" ').'type="checkbox" id="ulp_ext_enable_elasticemail" name="ulp_ext_enable_elasticemail" '.($this->ext_options['enable_elasticemail'] == "on" ? 'checked="checked"' : '').'"> '.__('Activate Elastic Email Integration module', 'ulp').'
							<br /><em>'.__('Tick checkbox if you want to integrate popups with Elastic Email.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th></th>
						<td>
							<input '.($is_curl ? '' : 'disabled="disabled" ').'type="checkbox" id="ulp_ext_enable_sendgrid" name="ulp_ext_enable_sendgrid" '.($this->ext_options['enable_sendgrid'] == "on" ? 'checked="checked"' : '').'"> '.__('Activate SendGrid Integration module', 'ulp').'
							<br /><em>'.__('Tick checkbox if you want to integrate popups with SendGrid.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th></th>
						<td>
							<input '.($is_curl ? '' : 'disabled="disabled" ').'type="checkbox" id="ulp_ext_enable_html" name="ulp_ext_enable_htmlform" '.($this->ext_options['enable_htmlform'] == "on" ? 'checked="checked"' : '').'"> '.__('Activate HTML Form Integration module', 'ulp').' <span class="ulp-badge ulp-badge-beta">Beta</span>
							<br /><em>'.__('Tick checkbox if you want to submit opt-in details as a part of various HTML form.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('Late Initialization', 'ulp').':</th>
						<td>
							<input type="checkbox" id="ulp_ext_late_init" name="ulp_ext_late_init" '.($this->ext_options['late_init'] == "on" ? 'checked="checked"' : '').'"> '.__('Enable late initialization', 'ulp').'
							<br /><em>'.__('Tick checkbox to enable late initilaization.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('Enable minification', 'ulp').':</th>
						<td>
							<input type="checkbox" id="ulp_ext_minified_sources" name="ulp_ext_minified_sources" '.($this->ext_options['minified_sources'] == "on" ? 'checked="checked"' : '').'"> '.__('Use minified JS and CSS files', 'ulp').'
							<br /><em>'.__('Tick checkbox to use minified JS and CSS files.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('Popups Library', 'ulp').':</th>
						<td>
							<input '.($is_curl ? '' : 'disabled="disabled" ').'type="checkbox" id="ulp_ext_enable_library" name="ulp_ext_enable_library" '.($this->ext_options['enable_library'] == "on" ? 'checked="checked"' : '').'"> '.__('Enable access to Popups Library', 'ulp').'
							<br /><em>'.__('Tick checkbox if you want to have access to Popups Library.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('Add-ons', 'ulp').':</th>
						<td>
							<input '.($is_curl ? '' : 'disabled="disabled" ').'type="checkbox" id="ulp_ext_enable_addons" name="ulp_ext_enable_addons" '.($this->ext_options['enable_addons'] == "on" ? 'checked="checked"' : '').'"> '.__('Show available add-ons', 'ulp').'
							<br /><em>'.__('Tick checkbox if you want to view available add-ons.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('Post meta', 'ulp').':</th>
						<td>
							<input type="checkbox" id="ulp_ext_admin_only_meta" name="ulp_ext_admin_only_meta" '.($this->ext_options['admin_only_meta'] == "on" ? 'checked="checked"' : '').'"> '.__('Disable post/page meta box for non-administrators', 'ulp').'
							<br /><em>'.__('Tick checkbox if you want to hide post/page meta box for non-administrators.', 'ulp').'</em>
						</td>
					</tr>
				</table>
				<hr>
				<div style="text-align: right; margin-bottom: 5px; margin-top: 20px;">
					<!-- <a href="'.admin_url('admin.php').'?page=ulp-settings" style="float: left;">'.__('General Settings', 'ulp').'</a> -->
					<input type="hidden" name="action" value="ulp_save_ext_settings" />
					<img class="ulp-loading" src="'.plugins_url('/images/loading.gif', __FILE__).'">
					<input type="submit" class="button-primary ulp-button" name="submit" value="'.__('Save Settings', 'ulp').'" onclick="return ulp_save_ext_settings();">
				</div>
				<div class="ulp-message"></div>
			</div>
			</form>
		</div>';
	}

	function save_ext_settings() {
		global $wpdb;
		$popup_options = array();
		if (current_user_can('manage_options')) {
			$this->populate_ext_options();
			
			if (isset($_POST['ulp_ext_enable_library'])) $this->ext_options['enable_library'] = 'on';
			else $this->ext_options['enable_library'] = 'off';
			if (isset($_POST['ulp_ext_enable_addons'])) $this->ext_options['enable_addons'] = 'on';
			else $this->ext_options['enable_addons'] = 'off';
			if (isset($_POST['ulp_ext_enable_social'])) $this->ext_options['enable_social'] = 'on';
			else $this->ext_options['enable_social'] = 'off';
			if (isset($_POST['ulp_ext_enable_social2'])) $this->ext_options['enable_social2'] = 'on';
			else $this->ext_options['enable_social2'] = 'off';
			if (isset($_POST['ulp_ext_enable_customfields'])) $this->ext_options['enable_customfields'] = 'on';
			else $this->ext_options['enable_customfields'] = 'off';
			if (isset($_POST['ulp_ext_enable_htmlform'])) $this->ext_options['enable_htmlform'] = 'on';
			else $this->ext_options['enable_htmlform'] = 'off';
			if (isset($_POST['ulp_ext_enable_mailchimp'])) $this->ext_options['enable_mailchimp'] = 'on';
			else $this->ext_options['enable_mailchimp'] = 'off';
			if (isset($_POST['ulp_ext_enable_sendgrid'])) $this->ext_options['enable_sendgrid'] = 'on';
			else $this->ext_options['enable_sendgrid'] = 'off';
			if (isset($_POST['ulp_ext_enable_elasticemail'])) $this->ext_options['enable_elasticemail'] = 'on';
			else $this->ext_options['enable_elasticemail'] = 'off';
			if (isset($_POST['ulp_ext_enable_egoi'])) $this->ext_options['enable_egoi'] = 'on';
			else $this->ext_options['enable_egoi'] = 'off';
			if (isset($_POST['ulp_ext_enable_customerio'])) $this->ext_options['enable_customerio'] = 'on';
			else $this->ext_options['enable_customerio'] = 'off';
			if (isset($_POST['ulp_ext_enable_mailwizz'])) $this->ext_options['enable_mailwizz'] = 'on';
			else $this->ext_options['enable_mailwizz'] = 'off';
			if (isset($_POST['ulp_ext_enable_constantcontact'])) $this->ext_options['enable_constantcontact'] = 'on';
			else $this->ext_options['enable_constantcontact'] = 'off';
			if (isset($_POST['ulp_ext_enable_aweber'])) $this->ext_options['enable_aweber'] = 'on';
			else $this->ext_options['enable_aweber'] = 'off';
			if (isset($_POST['ulp_ext_enable_getresponse'])) $this->ext_options['enable_getresponse'] = 'on';
			else $this->ext_options['enable_getresponse'] = 'off';
			if (isset($_POST['ulp_ext_enable_icontact'])) $this->ext_options['enable_icontact'] = 'on';
			else $this->ext_options['enable_icontact'] = 'off';
			if (isset($_POST['ulp_ext_enable_madmimi'])) $this->ext_options['enable_madmimi'] = 'on';
			else $this->ext_options['enable_madmimi'] = 'off';
			if (isset($_POST['ulp_ext_enable_directmail'])) $this->ext_options['enable_directmail'] = 'on';
			else $this->ext_options['enable_directmail'] = 'off';
			if (isset($_POST['ulp_ext_enable_campaignmonitor'])) $this->ext_options['enable_campaignmonitor'] = 'on';
			else $this->ext_options['enable_campaignmonitor'] = 'off';
			if (isset($_POST['ulp_ext_enable_salesautopilot'])) $this->ext_options['enable_salesautopilot'] = 'on';
			else $this->ext_options['enable_salesautopilot'] = 'off';
			if (isset($_POST['ulp_ext_enable_sendy'])) $this->ext_options['enable_sendy'] = 'on';
			else $this->ext_options['enable_sendy'] = 'off';
			if (isset($_POST['ulp_ext_enable_benchmark'])) $this->ext_options['enable_benchmark'] = 'on';
			else $this->ext_options['enable_benchmark'] = 'off';
			if (isset($_POST['ulp_ext_enable_ontraport'])) $this->ext_options['enable_ontraport'] = 'on';
			else $this->ext_options['enable_ontraport'] = 'off';
			if (isset($_POST['ulp_ext_enable_mailerlite'])) $this->ext_options['enable_mailerlite'] = 'on';
			else $this->ext_options['enable_mailerlite'] = 'off';
			if (isset($_POST['ulp_ext_enable_activecampaign'])) $this->ext_options['enable_activecampaign'] = 'on';
			else $this->ext_options['enable_activecampaign'] = 'off';
			if (isset($_POST['ulp_ext_enable_mymail'])) $this->ext_options['enable_mymail'] = 'on';
			else $this->ext_options['enable_mymail'] = 'off';
			if (isset($_POST['ulp_ext_enable_mailpoet'])) $this->ext_options['enable_mailpoet'] = 'on';
			else $this->ext_options['enable_mailpoet'] = 'off';
			if (isset($_POST['ulp_ext_enable_sendpress'])) $this->ext_options['enable_sendpress'] = 'on';
			else $this->ext_options['enable_sendpress'] = 'off';
			if (isset($_POST['ulp_ext_enable_ymlp'])) $this->ext_options['enable_ymlp'] = 'on';
			else $this->ext_options['enable_ymlp'] = 'off';
			if (isset($_POST['ulp_ext_enable_freshmail'])) $this->ext_options['enable_freshmail'] = 'on';
			else $this->ext_options['enable_freshmail'] = 'off';
			if (isset($_POST['ulp_ext_enable_sendreach'])) $this->ext_options['enable_sendreach'] = 'on';
			else $this->ext_options['enable_sendreach'] = 'off';
			if (isset($_POST['ulp_ext_enable_interspire'])) $this->ext_options['enable_interspire'] = 'on';
			else $this->ext_options['enable_interspire'] = 'off';
			if (isset($_POST['ulp_ext_enable_mail'])) $this->ext_options['enable_mail'] = 'on';
			else $this->ext_options['enable_mail'] = 'off';
			if (isset($_POST['ulp_ext_enable_welcomemail'])) $this->ext_options['enable_welcomemail'] = 'on';
			else $this->ext_options['enable_welcomemail'] = 'off';
			if (isset($_POST['ulp_ext_late_init'])) $this->ext_options['late_init'] = 'on';
			else $this->ext_options['late_init'] = 'off';
			if (isset($_POST['ulp_ext_minified_sources'])) $this->ext_options['minified_sources'] = 'on';
			else $this->ext_options['minified_sources'] = 'off';
			if (isset($_POST['ulp_ext_admin_only_meta'])) $this->ext_options['admin_only_meta'] = 'on';
			else $this->ext_options['admin_only_meta'] = 'off';
			$errors = array();

			if (!empty($errors)) {
				$return_object = array();
				$return_object['status'] = 'ERROR';
				$return_object['message'] = __('Attention! Please correct the errors below and try again.', 'ulp').'<ul><li>'.implode('</li><li>', $errors).'</li></ul>';
				echo json_encode($return_object);
				exit;
			}
			$this->update_ext_options();
			
			setcookie("ulp_info", __('Settings successfully <strong>saved</strong>.', 'ulp'), time()+30, "/", ".".str_replace("www.", "", $_SERVER["SERVER_NAME"]));
			
			$return_object = array();
			$return_object['status'] = 'OK';
			$return_object['return_url'] = admin_url('admin.php').'?page=ulp-settings&mode=ext';
			echo json_encode($return_object);
			exit;
		}
	}

	
	function admin_popups() {
		global $wpdb;

		if (isset($_GET["s"])) $search_query = trim(stripslashes($_GET["s"]));
		else $search_query = "";
		$tmp = $wpdb->get_row("SELECT COUNT(*) AS total FROM ".$wpdb->prefix."ulp_popups WHERE deleted = '0'".((strlen($search_query) > 0) ? " AND title LIKE '%".addslashes($search_query)."%'" : ""), ARRAY_A);
		$total = $tmp["total"];
		$totalpages = ceil($total/ULP_RECORDS_PER_PAGE);
		if ($totalpages == 0) $totalpages = 1;
		if (isset($_GET["p"])) $page = intval($_GET["p"]);
		else $page = 1;
		if ($page < 1 || $page > $totalpages) $page = 1;
		$switcher = $this->page_switcher(admin_url('admin.php').'?page=ulp'.((strlen($search_query) > 0) ? '&s='.rawurlencode($search_query) : ''), $page, $totalpages);

		if (isset($_GET['o'])) {
			$sort = $_GET['o'];
			if (in_array($sort, $this->sort_methods)) {
				if ($sort != $this->options['popups_sort']) {
					update_option('ulp_popups_sort', $sort);
					$this->options['popups_sort'] = $sort;
				}
			} else $sort = $this->options['popups_sort'];
		} else $sort = $this->options['popups_sort'];
		$orderby = 't1.created DESC';
		switch ($sort) {
			case 'title-az':
				$orderby = 't1.title ASC';
				break;
			case 'title-za':
				$orderby = 't1.title DESC';
				break;
			case 'date-az':
				$orderby = 't1.created ASC';
				break;
			default:
				$orderby = 't1.created DESC';
				break;
		}
		
		$sql = "SELECT t1.*, t2.layers FROM ".$wpdb->prefix."ulp_popups t1 LEFT JOIN (SELECT COUNT(*) AS layers, popup_id FROM ".$wpdb->prefix."ulp_layers WHERE deleted = '0' GROUP BY popup_id) t2 ON t2.popup_id = t1.id WHERE t1.deleted = '0'".((strlen($search_query) > 0) ? " AND t1.title LIKE '%".addslashes($search_query)."%'" : "")." ORDER BY ".$orderby." LIMIT ".(($page-1)*ULP_RECORDS_PER_PAGE).", ".ULP_RECORDS_PER_PAGE;
		$rows = $wpdb->get_results($sql, ARRAY_A);
		if (!empty($this->error)) $message = "<div class='error'><p>".$this->error."</p></div>";
		else if (!empty($this->info)) $message = "<div class='updated'><p>".$this->info."</p></div>";
		else {
			$message = '';
			$tmp = $wpdb->get_row("SELECT COUNT(*) AS total FROM ".$wpdb->prefix."ulp_popups WHERE deleted = '0' AND blocked = '0'", ARRAY_A);
			if (intval($tmp["total"]) == 0) $message = '<div class="error"><p>'.sprintf(__('<strong>Important!</strong> All existing popups are <strong>deactivated</strong>. Please activate desired popups by clicking icon %s. After that you can use them on your website.', 'ulp'), '<img src="'.plugins_url('/images/unblock.png', __FILE__).'" alt="">').'</p></div>';
		}
		$upload_dir = wp_upload_dir();
		if (!class_exists('ZipArchive') || !class_exists('DOMDocument') || !file_exists($upload_dir["basedir"].'/'.ULP_UPLOADS_DIR.'/temp')) $export_full = false;
		else $export_full = true;
		
		echo '
			<div class="wrap admin_ulp_wrap">
				<div id="icon-edit-pages" class="icon32"><br /></div><h2>'.__('Layered Popups', 'ulp').'</h2><br />
				'.$message.'
				<div class="ulp-top-forms">
					<div class="ulp-top-form-left">
						<form action="'.admin_url('admin.php').'" method="get" style="margin-bottom: 10px;">
						<input type="hidden" name="page" value="ulp" />
						'.__('Search:', 'ulp').' <input type="text" name="s" value="'.esc_html($search_query).'">
						<input type="submit" class="button-secondary action" value="'.__('Search', 'ulp').'" />
						'.((strlen($search_query) > 0) ? '<input type="button" class="button-secondary action" value="'.__('Reset search results', 'ulp').'" onclick="window.location.href=\''.admin_url('admin.php').'?page=ulp\';" />' : '').'
						</form>
					</div>
					<div class="ulp-top-form-right">
						<form id="ulp-sorting-form" action="'.admin_url('admin.php').'" method="get" style="margin-bottom: 10px;">
						<input type="hidden" name="page" value="ulp" />
						'.__('Sort:', 'ulp').'
						'.((strlen($search_query) > 0) ? '<input type="text" name="s" value="'.esc_html($search_query).'">' : '').'
						'.(($page > 1) ? '<input type="text" name="p" value="'.esc_html($page).'">' : '').'
						<select name="o" onchange="jQuery(\'#ulp-sorting-form\').submit();">
							<option value="title-az"'.($sort == 'title-az' ? ' selected="selected"' : '').'>'.__('Alphabetically', 'ulp').' ▲</option>
							<option value="title-za"'.($sort == 'title-za' ? ' selected="selected"' : '').'>'.__('Alphabetically', 'ulp').' ▼</option>
							<option value="date-az"'.($sort == 'date-az' ? ' selected="selected"' : '').'>'.__('Created', 'ulp').' ▲</option>
							<option value="date-za"'.($sort == 'date-za' ? ' selected="selected"' : '').'>'.__('Created', 'ulp').' ▼</option>
						</select>
						</form>
					</div>
				</div>
				<div class="ulp_buttons"><a class="button" href="'.admin_url('admin.php').'?page=ulp-add">'.__('Create New Popup', 'ulp').'</a></div>
				<div class="ulp_pageswitcher">'.$switcher.'</div>
				<table class="ulp_records">
				<tr>
					<th>'.__('Title', 'ulp').'</th>
					<th style="width: 160px;">'.__('ID', 'ulp').'</th>
					<th style="width: 80px;">'.__('Layers', 'ulp').'</th>
					<th style="width: 80px;">'.__('Submits', 'ulp').'</th>
					<th style="width: 80px;">'.__('Impressions', 'ulp').'</th>
					<th style="width: '.($export_full ? '160' : '140').'px;"></th>
				</tr>';
		if (sizeof($rows) > 0) {
			foreach ($rows as $row) {
				$bg_color = "";
				echo '
				<tr>
					<td>'.($row['blocked'] == 1 ? '<span class="ulp-badge ulp-badge-blocked">Blocked</span> ' : '').'<strong>'.esc_html($row['title']).'</strong></td>
					<td><input type="text" value="'.$row['str_id'].'" readonly="readonly" style="width: 100%;" onclick="this.focus();this.select();"></td>
					<td style="text-align: right;">'.intval($row['layers']).'</td>
					<td style="text-align: right;">'.intval($row['clicks']).'</td>
					<td style="text-align: right;">'.intval($row['impressions']).'</td>
					<td style="text-align: center;">
						<a target="ulp-preview" href="'.get_bloginfo('wpurl').'?ulp='.$row['str_id'].'&ac='.$this->random_string().'" title="'.__('Preview popup', 'ulp').'"><img src="'.plugins_url('/images/preview.png', __FILE__).'" alt="'.__('Preview popup', 'ulp').'" border="0"></a>
						<a href="'.admin_url('admin.php').'?page=ulp-add&id='.$row['id'].'" title="'.__('Edit popup details', 'ulp').'"><img src="'.plugins_url('/images/edit.png', __FILE__).'" alt="'.__('Edit popup details', 'ulp').'" border="0"></a>
						<a href="'.admin_url('admin.php').'?action=ulp-copy&id='.$row['id'].'&ac='.$this->random_string().'" title="'.__('Duplicate popup', 'ulp').'" onclick="return ulp_submitOperation();"><img src="'.plugins_url('/images/copy.png', __FILE__).'" alt="'.__('Duplicate popup', 'ulp').'" border="0"></a>
						<a href="'.admin_url('admin.php').'?action=ulp-export&id='.$row['id'].'&ac='.$this->random_string().'" title="'.__('Export popup details', 'ulp').'"><img src="'.plugins_url('/images/export.png', __FILE__).'" alt="'.__('Export popup details', 'ulp').'" border="0"></a>
						'.($export_full ? '<a href="'.admin_url('admin.php').'?action=ulp-export-full&id='.$row['id'].'&ac='.$this->random_string().'" title="'.__('Export full popup details (including images)', 'ulp').'"><img src="'.plugins_url('/images/export-full.png', __FILE__).'" alt="'.__('Export full popup details (including images)', 'ulp').'" border="0"></a>' : '').'
						'.($row['blocked'] == 1 ? '<a href="'.admin_url('admin.php').'?action=ulp-unblock&id='.$row['id'].'&ac='.$this->random_string().'" title="'.__('Unblock popup', 'ulp').'"><img src="'.plugins_url('/images/unblock.png', __FILE__).'" alt="'.__('Unblock popup', 'ulp').'" border="0"></a>' : '<a href="'.admin_url('admin.php').'?action=ulp-block&id='.$row['id'].'&ac='.$this->random_string().'" title="'.__('Block popup', 'ulp').'"><img src="'.plugins_url('/images/block.png', __FILE__).'" alt="'.__('Block popup', 'ulp').'" border="0"></a>').'
						<a href="'.admin_url('admin.php').'?action=ulp-drop-counters&id='.$row['id'].'&ac='.$this->random_string().'" title="'.__('Drop counters', 'ulp').'" onclick="return ulp_submitOperation();"><img src="'.plugins_url('/images/clear.png', __FILE__).'" alt="'.__('Drop counters', 'ulp').'" border="0"></a>
						<a href="'.admin_url('admin.php').'?action=ulp-delete&id='.$row['id'].'&ac='.$this->random_string().'" title="'.__('Delete popup', 'ulp').'" onclick="return ulp_submitOperation();"><img src="'.plugins_url('/images/delete.png', __FILE__).'" alt="'.__('Delete popup', 'ulp').'" border="0"></a>
					</td>
				</tr>';
			}
		} else {
			echo '
				<tr><td colspan="6" style="padding: 20px; text-align: center;">'.((strlen($search_query) > 0) ? __('No results found for', 'ulp').' "<strong>'.htmlspecialchars($search_query, ENT_QUOTES).'</strong>"' : __('List is empty.', 'ulp')).'</td></tr>';
		}
		echo '
				</table>
				<div class="ulp_buttons">
					<form id="ulp-import-form" enctype="multipart/form-data" method="post" action="'.admin_url('admin.php').'?action=ulp-import">
						<div style="position: relative; padding: 10px 20px;">
							<a class="ulp-import-form-close" href="#" onclick="jQuery(\'#ulp-import-form\').fadeOut(350); return false;">×</a>
							<input type="file" name="ulp-file" onchange="jQuery(\'#ulp-import-form\').submit();">
						</div>
					</form>
					<a class="button" href="#" onclick="jQuery(\'#ulp-import-form\').fadeIn(350); return false;">'.__('Import Popup', 'ulp').'</a>
					<a class="button" href="'.admin_url('admin.php').'?page=ulp-add">'.__('Create New Popup', 'ulp').'</a>
				</div>
				<div class="ulp_pageswitcher">'.$switcher.'</div>
				<div class="ulp_legend">
					<strong>Legend:</strong>
					<p><img src="'.plugins_url('/images/preview.png', __FILE__).'" alt="'.__('Preview popup', 'ulp').'" border="0"> '.__('Preview popup', 'ulp').'</p>
					<p><img src="'.plugins_url('/images/copy.png', __FILE__).'" alt="'.__('Duplicate popup', 'ulp').'" border="0"> '.__('Duplicate popup', 'ulp').'</p>
					<p><img src="'.plugins_url('/images/export.png', __FILE__).'" alt="'.__('Export popup details', 'ulp').'" border="0"> '.__('Export popup details', 'ulp').'</p>
					'.($export_full ? '<p><img src="'.plugins_url('/images/export-full.png', __FILE__).'" alt="'.__('Export full popup details (including images)', 'ulp').'" border="0"> '.__('Export full popup details (including images)', 'ulp').'</p>' : '').'
					<p><img src="'.plugins_url('/images/edit.png', __FILE__).'" alt="'.__('Edit popup details', 'ulp').'" border="0"> '.__('Edit popup details', 'ulp').'</p>
					<p><img src="'.plugins_url('/images/block.png', __FILE__).'" alt="'.__('Block popup', 'ulp').'" border="0"> '.__('Block popup', 'ulp').'</p>
					<p><img src="'.plugins_url('/images/unblock.png', __FILE__).'" alt="'.__('Unblock popup', 'ulp').'" border="0"> '.__('Unblock popup', 'ulp').'</p>
					<p><img src="'.plugins_url('/images/clear.png', __FILE__).'" alt="'.__('Drop counters', 'ulp').'" border="0"> '.__('Drop counters', 'ulp').'</p>
					<p><img src="'.plugins_url('/images/delete.png', __FILE__).'" alt="'.__('Delete popup', 'ulp').'" border="0"> '.__('Delete popup', 'ulp').'</p>
				</div>
			</div>';
	}

	function admin_add_popup() {
		global $wpdb;

		if (isset($_GET["id"]) && !empty($_GET["id"])) {
			$id = intval($_GET["id"]);
			$popup_details = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."ulp_popups WHERE id = '".$id."' AND deleted = '0'", ARRAY_A);
		}
		if (!empty($popup_details)) {
			$id = $popup_details['id'];
			$popup_options = unserialize($popup_details['options']);
			if (is_array($popup_options)) $popup_options = array_merge($this->default_popup_options, $popup_options);
			else $popup_options = $this->default_popup_options;
		} else {
			$str_id = $this->random_string(16);
			$sql = "INSERT INTO ".$wpdb->prefix."ulp_popups (str_id, title, width, height, options, created, blocked, deleted) VALUES ('".$str_id."', '', '640', '400', '', '".time()."', '0', '1')";
			$wpdb->query($sql);
			$id = $wpdb->insert_id;
			$popup_options = $this->default_popup_options;
		}
		
		if ($this->options['version'] >= 4.58) {
			$webfonts_array = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."ulp_webfonts WHERE deleted = '0' ORDER BY family", ARRAY_A);
		} else $webfonts_array = array();
		
		$errors = true;
		if (!empty($this->error)) $message = "<div class='error'><p>".$this->error."</p></div>";
		else if (!empty($this->info)) $message = "<div class='updated'><p>".$this->info."</p></div>";
		else $message = '';
		
		echo '
		<div class="wrap ulp">
			<div id="icon-edit-pages" class="icon32"><br /></div><h2>'.(!empty($popup_details) ? __('Layered Popups - Edit Popup', 'ulp') : __('Layered Popups - Create Popup', 'ulp')).'</h2>
			'.$message.'
			<form class="ulp-popup-form" enctype="multipart/form-data" method="post" style="margin: 0px" action="'.admin_url('admin.php').'">
			<div class="ulp-options" style="width: 100%; position: relative;">
				<h3>'.__('General Parameters', 'ulp').'</h3>
				<table class="ulp_useroptions">
					<tr>
						<th>'.__('Title', 'ulp').':</th>
						<td>
							<input type="text" name="ulp_title" value="'.(!empty($popup_details['title']) ? esc_html($popup_details['title']) : esc_html($this->default_popup_options['title'])).'" class="widefat" placeholder="Enter the popup title...">
							<br /><em>'.__('Enter the popup title. It is used for your reference.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('Basic size', 'ulp').':</th>
						<td style="vertical-align: middle;">
							<input type="text" name="ulp_width" value="'.(!empty($popup_details['width']) ? esc_html($popup_details['width']) : esc_html($this->default_popup_options['width'])).'" class="ic_input_number" placeholder="Width" onblur="ulp_build_preview();" onchange="ulp_build_preview();"> x
							<input type="text" name="ulp_height" value="'.(!empty($popup_details['height']) ? esc_html($popup_details['height']) : esc_html($this->default_popup_options['height'])).'" class="ic_input_number" placeholder="Height" onblur="ulp_build_preview();" onchange="ulp_build_preview();"> pixels
							<br /><em>'.__('Enter the size of basic frame. This frame will be centered and all layers will be placed relative to the top-left corner of this frame.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('Position', 'ulp').':</th>
						<td>
							<div id="ulp-position-top-left" class="ulp-position-box'.($popup_options['position'] == 'top-left' ? ' ulp-position-selected' : '').'" onclick="ulp_set_position(this);"><div class="ulp-position-element ulp-position-top-left"></div></div>
							<div id="ulp-position-top-center" class="ulp-position-box'.($popup_options['position'] == 'top-center' ? ' ulp-position-selected' : '').'" onclick="ulp_set_position(this);"><div class="ulp-position-element ulp-position-top-center"></div></div>
							<div id="ulp-position-top-right" class="ulp-position-box'.($popup_options['position'] == 'top-right' ? ' ulp-position-selected' : '').'" onclick="ulp_set_position(this);"><div class="ulp-position-element ulp-position-top-right"></div></div>
							<br />
							<div id="ulp-position-middle-left" class="ulp-position-box'.($popup_options['position'] == 'middle-left' ? ' ulp-position-selected' : '').'" onclick="ulp_set_position(this);"><div class="ulp-position-element ulp-position-middle-left"></div></div>
							<div id="ulp-position-middle-center" class="ulp-position-box'.($popup_options['position'] == 'middle-center' ? ' ulp-position-selected' : '').'" onclick="ulp_set_position(this);"><div class="ulp-position-element ulp-position-middle-center"></div></div>
							<div id="ulp-position-middle-right" class="ulp-position-box'.($popup_options['position'] == 'middle-right' ? ' ulp-position-selected' : '').'" onclick="ulp_set_position(this);"><div class="ulp-position-element ulp-position-middle-right"></div></div>
							<br />
							<div id="ulp-position-bottom-left" class="ulp-position-box'.($popup_options['position'] == 'bottom-left' ? ' ulp-position-selected' : '').'" onclick="ulp_set_position(this);"><div class="ulp-position-element ulp-position-bottom-left"></div></div>
							<div id="ulp-position-bottom-center" class="ulp-position-box'.($popup_options['position'] == 'bottom-center' ? ' ulp-position-selected' : '').'" onclick="ulp_set_position(this);"><div class="ulp-position-element ulp-position-bottom-center"></div></div>
							<div id="ulp-position-bottom-right" class="ulp-position-box'.($popup_options['position'] == 'bottom-right' ? ' ulp-position-selected' : '').'" onclick="ulp_set_position(this);"><div class="ulp-position-element ulp-position-bottom-right"></div></div>
							<input type="hidden" id="ulp_position" name="ulp_position" value="'.(!empty($popup_options['position']) ? esc_html($popup_options['position']) : esc_html($this->default_popup_options['position'])).'">
							<br /><em>'.__('Select popup position on browser window.', 'ulp').'</em>
							<script>
								function ulp_set_position(object) {
									var position = jQuery(object).attr("id");
									position = position.replace("ulp-position-", "");
									jQuery("#ulp_position").val(position);
									jQuery(".ulp-position-box").removeClass("ulp-position-selected");
									jQuery(object).addClass("ulp-position-selected");
								}
							</script>
						</td>
					</tr>
					<tr>
						<th>'.__('Disable overlay', 'ulp').':</th>
						<td>
							<input type="checkbox" id="ulp_disable_overlay" name="ulp_disable_overlay" '.($popup_options['disable_overlay'] == "on" ? 'checked="checked"' : '').'"> '.__('Disable overlay', 'ulp').'
							<br /><em>'.__('Please tick checkbox to disable overlay.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('Overlay color', 'ulp').':</th>
						<td>
							<input type="text" class="ulp-color ic_input_number" name="ulp_overlay_color" value="'.(!empty($popup_options['overlay_color']) ? esc_html($popup_options['overlay_color']) : esc_html($this->default_popup_options['overlay_color'])).'" placeholder="">
							<br /><em>'.__('Set the overlay color.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('Overlay opacity', 'ulp').':</th>
						<td>
							<input type="text" name="ulp_overlay_opacity" value="'.(!empty($popup_options['overlay_opacity']) ? esc_html($popup_options['overlay_opacity']) : esc_html($this->default_popup_options['overlay_opacity'])).'" class="ic_input_number" placeholder="Opacity">
							<br /><em>'.__('Set the overlay opacity. The value must be in a range [0...1].', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('Extended closing', 'ulp').':</th>
						<td>
							<input type="checkbox" id="ulp_enable_close" name="ulp_enable_close" '.($popup_options['enable_close'] == "on" ? 'checked="checked"' : '').'"> '.__('Close popup window on ESC-button click and overlay click', 'ulp').'
							<br /><em>'.__('Please tick checkbox to enable popup closing on ESC-button click and overlay click.', 'ulp').'</em>
						</td>
					</tr>
				</table>
				<h3>'.__('Layers', 'ulp').'</h3>
				<div id="ulp-layers-data">';
		$sql = "SELECT * FROM ".$wpdb->prefix."ulp_layers WHERE deleted = '0' AND popup_id = '".$id."' ORDER BY created ASC";
		$layers = $wpdb->get_results($sql, ARRAY_A);
		if (sizeof($layers) > 0) {
			foreach ($layers as $layer) {
				$layer_options = unserialize($layer['details']);
				if (is_array($layer_options)) $layer_options = array_merge($this->default_layer_options, $layer_options);
				else $layer_options = $this->default_layer_options;
				$layer_options = $this->filter_lp($layer_options);
				if (strlen($layer_options['content']) == 0) $content = 'No content...';
				else if (strlen($layer_options['content']) > 192) $content = substr($layer_options['content'], 0, 180).'...';
				else $content = $layer_options['content'];
				$layer_options_html = '';
				foreach ($layer_options as $key => $value) {
					$layer_options_html .= '<input type="hidden" id="ulp_layer_'.$layer['id'].'_'.$key.'" name="ulp_layer_'.$layer['id'].'_'.$key.'" value="'.esc_html($value).'">';
				}
				echo '
					<section class="ulp-layers-item" id="ulp-layer-'.$layer['id'].'">
						<div class="ulp-layers-item-cell ulp-layers-item-cell-info">
							<h4>'.esc_html($layer_options['title']).'</h4>
							<p>'.esc_html($content).'</p>
						</div>
						<div class="ulp-layers-item-cell" style="width: 70px;">
							<a href="#" title="'.__('Edit layer details', 'ulp').'" onclick="return ulp_edit_layer(this);"><img src="'.plugins_url('/images/edit.png', __FILE__).'" alt="'.__('Edit layer details', 'ulp').'" border="0"></a>
							<a href="#" title="'.__('Duplicate layer', 'ulp').'" onclick="return ulp_copy_layer(this);"><img src="'.plugins_url('/images/copy.png', __FILE__).'" alt="'.__('Duplicate details', 'ulp').'" border="0"></a>
							<a href="#" title="'.__('Delete layer', 'ulp').'" onclick="return ulp_delete_layer(this);"><img src="'.plugins_url('/images/delete.png', __FILE__).'" alt="'.__('Delete layer', 'ulp').'" border="0"></a>
						</div>
						'.$layer_options_html.'
					</section>
					<div class="ulp-edit-layer" id="ulp-edit-layer-'.$layer['id'].'"></div>';
			}
		}
		echo '									
				</div>
				<div id="ulp-new-layer"></div>
				<input type="button" class="button-secondary" onclick="return ulp_add_layer();" value="'.__('Add New Layer', 'ulp').'">
				<h3>'.__('Live Preview', 'ulp').'</h3>
				<div class="ulp-preview-container">
					<div class="ulp-preview-window">
						<div class="ulp-preview-content">
						</div>
					</div>
				</div>
				<h3>'.__('Native Form Parameters', 'ulp').'</h3>
				<p>'.__('The parameters below are used for subscription form only. Please read FAQ section about adding subscription form into layers.', 'ulp').'</p>
				<table class="ulp_useroptions">
					<tr>
						<th>'.__('"Name" field placeholder', 'ulp').':</th>
						<td>
							<input type="text" id="ulp_name_placeholder" name="ulp_name_placeholder" value="'.esc_html($popup_options['name_placeholder']).'" class="widefat">
							<br /><em>'.__('Enter the placeholder for "Name" input field.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th></th>
						<td>
							<input type="checkbox" id="ulp_name_mandatory" name="ulp_name_mandatory" '.($popup_options['name_mandatory'] == "on" ? 'checked="checked"' : '').'> '.__('"Name" field is mandatory', 'ulp').'
							<br /><em>'.__('Please tick checkbox to set "name" field as mandatory.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('"Phone number" field placeholder', 'ulp').':</th>
						<td>
							<input type="text" id="ulp_phone_placeholder" name="ulp_phone_placeholder" value="'.esc_html($popup_options['phone_placeholder']).'" class="widefat">
							<br /><em>'.__('Enter the placeholder for "Phone number" input field.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th></th>
						<td>
							<input type="checkbox" id="ulp_phone_mandatory" name="ulp_phone_mandatory" '.($popup_options['phone_mandatory'] == "on" ? 'checked="checked"' : '').'> '.__('"Phone number" field is mandatory', 'ulp').'
							<br /><em>'.__('Please tick checkbox to set "phone number" field as mandatory.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('"Message" text area placeholder', 'ulp').':</th>
						<td>
							<input type="text" id="ulp_message_placeholder" name="ulp_message_placeholder" value="'.esc_html($popup_options['message_placeholder']).'" class="widefat">
							<br /><em>'.__('Enter the placeholder for "Message" text area.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th></th>
						<td>
							<input type="checkbox" id="ulp_message_mandatory" name="ulp_message_mandatory" '.($popup_options['message_mandatory'] == "on" ? 'checked="checked"' : '').'> '.__('"Message" text area is mandatory', 'ulp').'
							<br /><em>'.__('Please tick checkbox to set "message" text area as mandatory.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('"E-mail" field placeholder', 'ulp').':</th>
						<td>
							<input type="text" id="ulp_email_placeholder" name="ulp_email_placeholder" value="'.esc_html($popup_options['email_placeholder']).'" class="widefat">
							<br /><em>'.__('Enter the placeholder for "E-mail" input field.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('"Submit" button label', 'ulp').':</th>
						<td>
							<input type="text" id="ulp_button_label" name="ulp_button_label" value="'.esc_html($popup_options['button_label']).'" class="widefat">
							<br /><em>'.__('Enter the label for "Submit" button.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('"Loading" button label', 'ulp').':</th>
						<td>
							<input type="text" id="ulp_button_label_loading" name="ulp_button_label_loading" value="'.(!empty($popup_options['button_label_loading']) ? esc_html($popup_options['button_label_loading']) : esc_html($this->default_popup_options['button_label_loading'])).'" class="widefat">
							<br /><em>'.__('Enter the label for "Submit" button which appears on subscription form submission.', 'ulp').'</em>
						</td>
					</tr>';
		if ($this->options['fa_enable'] == 'on') {
			echo '
					<tr>
						<th>'.__('Button icon', 'ulp').':</th>
						<td>
							<span id="ulp-button-icon-image" class="ulp-icon ulp-icon-active" title="'.__('Icons', 'ulp').'" onclick="jQuery(\'#ulp-button-icon-set\').slideToggle(300);"><i class="fa '.$popup_options['button_icon'].'"></i></span><br />
							<div id="ulp-button-icon-set" class="ulp-icon-set">';
			foreach ($this->font_awesome as $value) {
				echo '<span class="ulp-icon'.($popup_options['button_icon'] == $value ? ' ulp-icon-active' : '').'" title="'.$value.'" onclick="ulp_seticon(this, \'ulp-button-icon\');"><i class="fa '.$value.'"></i></span>';
			}
			echo '
							</div>
							<input type="hidden" name="ulp_button_icon" id="ulp-button-icon" value="'.$popup_options['button_icon'].'">
							<em>'.__('Select "Submit" button icon.', 'ulp').'</em>
						</td>
					</tr>';
		}
		echo '
					<tr>
						<th>'.__('Button color', 'ulp').':</th>
						<td>
							<input type="text" class="ulp-color ic_input_number" name="ulp_button_color" value="'.esc_html($popup_options['button_color']).'" placeholder=""> 
							<br /><em>'.__('Set the "Submit" button color.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th></th>
						<td>
							<input type="checkbox" id="ulp_button_gradient" name="ulp_button_gradient" '.($popup_options['button_gradient'] == "on" ? 'checked="checked"' : '').'"> '.__('Add color gradient', 'ulp').'
							<br /><em>'.__('Please tick checkbox to want to add color gradient to "Submit" button.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('Button size', 'ulp').':</th>
						<td>
							<input type="checkbox" id="ulp_button_inherit_size" name="ulp_button_inherit_size" '.($popup_options['button_inherit_size'] == "on" ? 'checked="checked"' : '').'"> '.__('Inherit layer size', 'ulp').'
							<br /><em>'.__('Please tick checkbox to want to inherit layer size for button size.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('Button border radius', 'ulp').':</th>
						<td style="vertical-align: middle;">
							<input type="text" id="ulp_button_border_radius" name="ulp_button_border_radius" value="'.esc_html($popup_options['button_border_radius']).'" class="ic_input_number" placeholder="'.__('pixels', 'ulp').'"> '.__('pixels', 'ulp').'
							<br /><em>'.__('Set the border radius of "Submit" button.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('Button CSS', 'ulp').':</th>
						<td style="vertical-align: middle;">
							<input type="text" id="ulp_button_css" name="ulp_button_css" value="'.esc_html($popup_options['button_css']).'" class="widefat" placeholder="'.__('Custom button CSS', 'ulp').'">
							<br /><em>'.__('Customize CSS for "Submit" button.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('Button:hover CSS', 'ulp').':</th>
						<td style="vertical-align: middle;">
							<input type="text" id="ulp_button_css_hover" name="ulp_button_css_hover" value="'.esc_html($popup_options['button_css_hover']).'" class="widefat" placeholder="'.__('Custom button:hover CSS', 'ulp').'">
							<br /><em>'.__('Customize CSS for "Submit" button when pointer is over the button.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('Input field border color', 'ulp').':</th>
						<td>
							<input type="text" class="ulp-color ic_input_number" name="ulp_input_border_color" value="'.esc_html($popup_options['input_border_color']).'" placeholder="">
							<br /><em>'.__('Set the border color of "Name" and "E-mail" input fields.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('Input field border width', 'ulp').':</th>
						<td style="vertical-align: middle;">
							<input type="text" id="ulp_input_border_width" name="ulp_input_border_width" value="'.esc_html($popup_options['input_border_width']).'" class="ic_input_number" placeholder="'.__('pixels', 'ulp').'"> '.__('pixels', 'ulp').'
							<br /><em>'.__('Set the border width of "Name" and "E-mail" input fields.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('Input field border radius', 'ulp').':</th>
						<td style="vertical-align: middle;">
							<input type="text" id="ulp_input_border_radius" name="ulp_input_border_radius" value="'.esc_html($popup_options['input_border_radius']).'" class="ic_input_number" placeholder="'.__('pixels', 'ulp').'"> '.__('pixels', 'ulp').'
							<br /><em>'.__('Set the border radius of "Name" and "E-mail" input fields.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('Input field background color', 'ulp').':</th>
						<td>
							<input type="text" class="ulp-color ic_input_number" name="ulp_input_background_color" value="'.esc_html($popup_options['input_background_color']).'" placeholder="">
							<br /><em>'.__('Set the background color of "Name" and "E-mail" input fields.', 'ulp').'</em>
						</td>
					</tr>';
		if ($this->options['fa_enable'] == 'on') {
			echo '
					<tr>
						<th></th>
						<td>
							<input type="checkbox" id="ulp_input_icons" name="ulp_input_icons" '.($popup_options['input_icons'] == "on" ? 'checked="checked"' : '').'"> '.__('Add icons to input fields', 'ulp').'
							<br /><em>'.__('Please tick checkbox to want to add icons to "Name" and "E-mail" input fields.', 'ulp').'</em>
						</td>
					</tr>';
		}
		echo '
					<tr>
						<th>'.__('Input field background opacity', 'ulp').':</th>
						<td>
							<input type="text" class="ic_input_number" name="ulp_input_background_opacity" value="'.esc_html($popup_options['input_background_opacity']).'" placeholder="[0...1]">
							<br /><em>'.__('Set the background opacity of "Name" and "E-mail" input fields. The value must be in a range [0...1].', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('Input field CSS', 'ulp').':</th>
						<td style="vertical-align: middle;">
							<input type="text" id="ulp_input_css" name="ulp_input_css" value="'.esc_html($popup_options['input_css']).'" class="widefat" placeholder="'.__('Custom input field CSS', 'ulp').'">
							<br /><em>'.__('Customize CSS for input fields.', 'ulp').'</em>
						</td>
					</tr>';
		if ($this->options['recaptcha_enable'] == 'on') {
			echo '
					<tr>
						<th>'.__('reCAPTCHA theme', 'ulp').':</th>
						<td>
							<select class="ic_input_m" name="ulp_recaptcha_theme" id="ulp_recaptcha_theme">
								<option value="light"'.($popup_options['recaptcha_theme'] == 'light' ? ' selected="selected"' : '').'>Light</option>
								<option value="dark"'.($popup_options['recaptcha_theme'] == 'dark' ? ' selected="selected"' : '').'>Dark</option>
							</select>
							<br /><em>'.__('Select reCAPTCHA theme.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th></th>
						<td>
							<input type="checkbox" id="ulp_recaptcha_mandatory" name="ulp_recaptcha_mandatory" '.($popup_options['recaptcha_mandatory'] == "on" ? 'checked="checked"' : '').'"> '.__('reCAPTCHA is mandatory', 'ulp').'
							<br /><em>'.__('Please tick checkbox to set reCAPTCHA as mandatory. Do not forget to create new layer and insert <code>{recaptcha}</code> shortcode into its content.', 'ulp').'</em>
						</td>
					</tr>';
		}
		echo '
					<tr>
						<th>'.__('Autoclose delay', 'ulp').':</th>
						<td style="vertical-align: middle;">
							<input type="text" id="ulp_close_delay" name="ulp_close_delay" value="'.esc_html($popup_options['close_delay']).'" class="ic_input_number" placeholder="'.__('seconds', 'ulp').'"> '.__('seconds', 'ulp').'
							<br /><em>'.__('When subscription is succesfull, the popup will be automatically closed after this delay.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('Redirect URL', 'ulp').':</th>
						<td>
							<input type="text" id="ulp_return_url" name="ulp_return_url" value="'.esc_html($popup_options['return_url']).'" class="widefat">
							<br /><em>'.__('Enter the redirect URL. After successful subscribing user is redirected to this URL. Leave blank to stay on the same page.', 'ulp').'</em>
						</td>
					</tr>
				</table>';
		do_action('ulp_popup_options_show', $popup_options);
		echo '
				<br /><br />
				<hr>
				<div style="text-align: right; margin-bottom: 5px; margin-top: 20px;">
					<input type="hidden" name="action" value="ulp_save_popup" />
					<input type="hidden" name="ulp_id" value="'.$id.'" />
					<img id="ulp-loading" class="ulp-loading" src="'.plugins_url('/images/loading.gif', __FILE__).'">
					<input type="submit" class="button-primary ulp-button" name="submit" value="'.__('Save Popup Details', 'ulp').'" onclick="return ulp_save_popup();">
				</div>
				<div id="ulp-message" class="ulp-message"></div>
				<div id="ulp-overlay"></div>
			</div>
			</form>
			<script type="text/javascript">
				var ulp_local_fonts = new Array("'.strtolower(implode('","', $this->local_fonts)).'");
				var ulp_active_layer = -1;
				var ulp_default_layer_options = {';
		foreach ($this->default_layer_options as $key => $value) {
			echo '
					"'.$key.'" : "'.esc_html($value).'",';
		}
		echo '
					"a" : ""
				};
				function ulp_build_preview() {
					//jQuery(".ulp-preview-container").css({
					//	"background" : jQuery("[name=\'ulp_overlay_color\']").val()
					//});
					jQuery(".ulp-preview-window").css({
						"width" : parseInt(jQuery("[name=\'ulp_width\']").val(), 10) + "px",
						"height" : parseInt(jQuery("[name=\'ulp_height\']").val(), 10) + "px"
					});
					
					var popup_style = "";
					var from_rgb = ulp_hex2rgb(jQuery("[name=\'ulp_button_color\']").val());
					var to_color = "transparent";
					var from_color = "transparent";
					if (from_rgb) {
						var total = parseInt(from_rgb.r, 10)+parseInt(from_rgb.g, 10)+parseInt(from_rgb.b, 10);
						if (total == 0) total = 1;
						var to = {
							r : Math.max(0, parseInt(from_rgb.r, 10) - parseInt(48*from_rgb.r/total, 10)),
							g : Math.max(0, parseInt(from_rgb.g, 10) - parseInt(48*from_rgb.g/total, 10)),
							b : Math.max(0, parseInt(from_rgb.b, 10) - parseInt(48*from_rgb.b/total, 10))
						};
						from_color = jQuery("[name=\'ulp_button_color\']").val();
						to_color = ulp_rgb2hex(to.r, to.g, to.b);
					}
					var input_border_color = "border-color:transparent !important;";
					if (jQuery("[name=\'ulp_input_border_color\']").val() != "") input_border_color = "border-color:"+jQuery("[name=\'ulp_input_border_color\']").val()+" !important;";
					input_border_color = input_border_color + " border-width:"+parseInt(jQuery("[name=\'ulp_input_border_width\']").val(), 10)+"px !important; border-radius:"+parseInt(jQuery("[name=\'ulp_input_border_radius\']").val(), 10)+"px !important;"
					var input_background_color = "background-color: transparent !important;";
					if (jQuery("[name=\'ulp_input_background_color\']").val() != "") {
						var bg_rgb = ulp_hex2rgb(jQuery("[name=\'ulp_input_background_color\']").val());
						input_background_color = "background-color:rgb("+parseInt(bg_rgb.r)+","+parseInt(bg_rgb.g)+","+parseInt(bg_rgb.b)+") !important;background-color:rgba("+parseInt(bg_rgb.r)+","+parseInt(bg_rgb.g)+","+parseInt(bg_rgb.b)+", "+jQuery("[name=\'ulp_input_background_opacity\']").val()+") !important;";
					}
					if (jQuery("#ulp_button_gradient").is(":checked")) {
						popup_style += ".ulp-preview-submit,.ulp-preview-submit:visited{background: "+from_color+";border:1px solid "+from_color+";background-image:linear-gradient("+to_color+","+from_color+"); border-radius:"+parseInt(jQuery("[name=\'ulp_button_border_radius\']").val(), 10)+"px !important;}";
						popup_style += ".ulp-preview-submit:hover,.ulp-preview-submit:active{background: "+to_color+";border:1px solid "+from_color+";background-image:linear-gradient("+from_color+","+to_color+"); border-radius:"+parseInt(jQuery("[name=\'ulp_button_border_radius\']").val(), 10)+"px !important;}";
					} else {
						popup_style += ".ulp-preview-submit,.ulp-preview-submit:visited{background: "+from_color+";border:1px solid "+from_color+"; border-radius:"+parseInt(jQuery("[name=\'ulp_button_border_radius\']").val(), 10)+"px !important;}";
						popup_style += ".ulp-preview-submit:hover,.ulp-preview-submit:active{background: "+to_color+";border:1px solid "+to_color+"; border-radius:"+parseInt(jQuery("[name=\'ulp_button_border_radius\']").val(), 10)+"px !important;}";
					}
					if (jQuery("#ulp_button_css").val() != "") {
						popup_style += ".ulp-preview-submit,.ulp-preview-submit:visited{"+jQuery("#ulp_button_css").val()+"}";
					}
					if (jQuery("#ulp_button_css_hover").val() != "") {
						popup_style += ".ulp-preview-submit:hover,.ulp-preview-submit:active{"+jQuery("#ulp_button_css_hover").val()+"}";
					}
					popup_style += ".ulp-preview-input,.ulp-preview-input:hover,.ulp-preview-input:active,.ulp-preview-input:focus,.ulp-preview-checkbox{"+input_border_color+""+input_background_color+"}";
					if (jQuery("#ulp_input_css").val() != "") {
						popup_style += ".ulp-preview-input,.ulp-preview-input:hover,.ulp-preview-input:active,.ulp-preview-input:focus,.ulp-preview-checkbox{"+jQuery("#ulp_input_css").val()+"}";
					}';
		do_action('ulp_js_build_preview_popup_style');
		echo '			
					jQuery(".ulp-preview-content").html("<style>"+popup_style+"</style>");
					var input_name_icon_html = "";
					var input_email_icon_html = "";
					var input_phone_icon_html = "";';
		if ($this->options['fa_enable'] == 'on') {
			echo '
					if (jQuery("#ulp_input_icons").is(":checked")) {
						input_name_icon_html = "<div class=\'ulp-fa-input-table\'><div class=\'ulp-fa-input-cell\'><i class=\'fa fa-user\'></i></div></div>";
						input_email_icon_html = "<div class=\'ulp-fa-input-table\'><div class=\'ulp-fa-input-cell\'><i class=\'fa fa-envelope\'></i></div></div>";
						input_phone_icon_html = "<div class=\'ulp-fa-input-table\'><div class=\'ulp-fa-input-cell\'><i class=\'fa fa-phone\'></i></div></div>";
					}';
		}
		echo '		
					var recaptcha_image = "'.plugins_url('/images/recaptcha_light.png', __FILE__).'";
					if (jQuery("#ulp_recaptcha_theme").val() == "dark") recaptcha_image = "'.plugins_url('/images/recaptcha_dark.png', __FILE__).'";
					jQuery(".ulp-layers-item").each(function() {
						var layer_id = jQuery(this).attr("id").replace("ulp-layer-", "");
						if (ulp_active_layer == layer_id) {
							var content = jQuery("#ulp_layer_content").val();
							content = content.replace("{subscription-name}", "<input class=\'ulp-preview-input\' id=\'ulp-preview-input-name\' type=\'text\'>"+input_name_icon_html);
							content = content.replace("{subscription-email}", "<input class=\'ulp-preview-input\' id=\'ulp-preview-input-email\' type=\'text\'>"+input_email_icon_html);
							content = content.replace("{subscription-submit}", "<a class=\'ulp-preview-submit\' id=\'ulp-preview-submit\'></a>");
							content = content.replace("{subscription-phone}", "<input class=\'ulp-preview-input\' id=\'ulp-preview-input-phone\' type=\'text\'>"+input_phone_icon_html);
							content = content.replace("{subscription-message}", "<textarea class=\'ulp-preview-input\' id=\'ulp-preview-input-message\'></textarea>");';
		if ($this->options['recaptcha_enable'] == 'on') {
			echo '
						content = content.replace("{recaptcha}", "<div class=\'ulp-preview-recaptcha\' style=\'width: 306px; height: 80px;\'><img src=\'"+recaptcha_image+"\' /></div>");';
		}
		do_action('ulp_js_build_preview_content');
		echo '					
							var style = "#ulp-preview-layer-"+layer_id+" {left:" + parseInt(jQuery("#ulp_layer_left").val(), 10) + "px;top:" + parseInt(jQuery("#ulp_layer_top").val(), 10) + "px;}";
							if (jQuery("#ulp_layer_width").val() != "") style += "#ulp-preview-layer-"+layer_id+" {width:"+parseInt(jQuery("#ulp_layer_width").val(), 10)+"px;}";
							if (jQuery("#ulp_layer_height").val() != "") style += "#ulp-preview-layer-"+layer_id+" {height:"+parseInt(jQuery("#ulp_layer_height").val(), 10)+"px;}";
							var background = "";		
							if (jQuery("#ulp_layer_background_color").val() != "") {
								var rgb = ulp_hex2rgb(jQuery("#ulp_layer_background_color").val());
								if (rgb != false) background = "background-color:"+jQuery("#ulp_layer_background_color").val()+";background-color:rgba("+rgb.r+","+rgb.g+","+rgb.b+","+jQuery("#ulp_layer_background_opacity").val()+");";
							} else $background = "";
							if (jQuery("#ulp_layer_background_image").val() != "") {
								background += "background-image:url("+jQuery("#ulp_layer_background_image").val()+");background-repeat:repeat;";
							}
							var font = "font-family:\'"+jQuery("#ulp_layer_font").val()+"\',arial;font-weight:"+jQuery("#ulp_layer_font_weight").val()+";color:"+jQuery("#ulp_layer_font_color").val()+";font-size:"+parseInt(jQuery("#ulp_layer_font_size").val(), 10)+"px;";
							if (parseInt(jQuery("#ulp_layer_text_shadow_size").val(), 10) != 0 && jQuery("#ulp_layer_text_shadow_color").val() != "") font += "text-shadow:"+jQuery("#ulp_layer_text_shadow_color").val()+" "+jQuery("#ulp_layer_text_shadow_size").val()+"px "+" "+jQuery("#ulp_layer_text_shadow_size").val()+"px "+" "+jQuery("#ulp_layer_text_shadow_size").val()+"px";
							style += "#ulp-preview-layer-"+layer_id+",#ulp-preview-layer-"+layer_id+" p,#ulp-preview-layer-"+layer_id+" a,#ulp-preview-layer-"+layer_id+" span,#ulp-preview-layer-"+layer_id+" li,#ulp-preview-layer-"+layer_id+" input,#ulp-preview-layer-"+layer_id+" button,#ulp-preview-layer-"+layer_id+" textarea,#ulp-preview-layer-"+layer_id+" select {"+font+"}";';
		if ($this->options['fa_enable'] == 'on') {
			echo '
							if (jQuery("#ulp_input_icons").is(":checked")) {
								style += "#ulp-preview-layer-"+layer_id+" input.ulp-preview-input, #ulp-preview-layer-"+layer_id+" select.ulp-preview-input {padding-left:"+parseInt(4+2*parseInt(jQuery("#ulp_layer_font_size").val(), 10), 10)+"px !important;} #ulp-preview-layer-"+layer_id+" div.ulp-fa-input-cell {width: "+parseInt(2*parseInt(jQuery("#ulp_layer_font_size").val(), 10), 10)+"px !important; padding-left: 4px !important;}";
							}';
		}
		echo '
							style += "#ulp-preview-layer-"+layer_id+" .ulp-preview-checkbox label:after{background:"+jQuery("#ulp_layer_font_color").val()+";}";
							style += "#ulp-preview-layer-"+layer_id+"{"+background+"z-index:"+parseInt(parseInt(jQuery("#ulp_layer_index").val(), 10)+1000, 10)+";text-align:"+jQuery("#ulp_layer_content_align").val()+"}";
							if (jQuery("#ulp_layer_style").val() != "") style += "#ulp-preview-layer-"+layer_id+"{"+jQuery("#ulp_layer_style").val()+"}";
							if (jQuery("#ulp_layer_scrollbar").is(":checked")) style += "#ulp-preview-layer-"+layer_id+"{overflow:hidden;}";
							var font_link = "";
							if (!ulp_inarray(jQuery("#ulp_layer_font").val(), ulp_local_fonts)) font_link = "<link href=\'//fonts.googleapis.com/css?family="+jQuery("#ulp_layer_font").val().replace(" ", "+")+":100,200,300,400,500,600,700,800,900&subset=latin,latin-ext,cyrillic,cyrillic-ext,greek\' rel=\'stylesheet\' type=\'text/css\'>";
							var layer = font_link+"<style>"+style+"</style><div class=\'ulp-preview-layer ulp-preview-layer-active\' id=\'ulp-preview-layer-"+layer_id+"\'>"+content+"</div>";
						} else {
							var content = jQuery("#ulp_layer_"+layer_id+"_content").val();
							content = content.replace("{subscription-name}", "<input class=\'ulp-preview-input\' id=\'ulp-preview-input-name\' type=\'text\'>"+input_name_icon_html);
							content = content.replace("{subscription-email}", "<input class=\'ulp-preview-input\' id=\'ulp-preview-input-email\' type=\'text\'>"+input_email_icon_html);
							content = content.replace("{subscription-submit}", "<a class=\'ulp-preview-submit\' id=\'ulp-preview-submit\'></a>");
							content = content.replace("{subscription-phone}", "<input class=\'ulp-preview-input\' id=\'ulp-preview-input-phone\' type=\'text\'>"+input_phone_icon_html);
							content = content.replace("{subscription-message}", "<textarea class=\'ulp-preview-input\' id=\'ulp-preview-input-message\'></textarea>");';
		if ($this->options['recaptcha_enable'] == 'on') {
			echo '
						content = content.replace("{recaptcha}", "<div class=\'ulp-preview-recaptcha\' style=\'width: 306px; height: 80px;\'><img src=\'"+recaptcha_image+"\' /></div>");';
		}
		do_action('ulp_js_build_preview_content');
		echo '					
							var style = "#ulp-preview-layer-"+layer_id+" {left:" + parseInt(jQuery("#ulp_layer_"+layer_id+"_left").val(), 10) + "px;top:" + parseInt(jQuery("#ulp_layer_"+layer_id+"_top").val(), 10) + "px;}";
							if (jQuery("#ulp_layer_"+layer_id+"_width").val() != "") style += "#ulp-preview-layer-"+layer_id+" {width:"+parseInt(jQuery("#ulp_layer_"+layer_id+"_width").val(), 10)+"px;}";
							if (jQuery("#ulp_layer_"+layer_id+"_height").val() != "") style += "#ulp-preview-layer-"+layer_id+" {height:"+parseInt(jQuery("#ulp_layer_"+layer_id+"_height").val(), 10)+"px;}";
							var background = "";		
							if (jQuery("#ulp_layer_"+layer_id+"_background_color").val() != "") {
								var rgb = ulp_hex2rgb(jQuery("#ulp_layer_"+layer_id+"_background_color").val());
								if (rgb != false) background = "background-color:"+jQuery("#ulp_layer_"+layer_id+"_background_color").val()+";background-color:rgba("+rgb.r+","+rgb.g+","+rgb.b+","+jQuery("#ulp_layer_"+layer_id+"_background_opacity").val()+");";
							} else $background = "";
							if (jQuery("#ulp_layer_"+layer_id+"_background_image").val() != "") {
								background += "background-image:url("+jQuery("#ulp_layer_"+layer_id+"_background_image").val()+");background-repeat:repeat;";
							}
							var font = "font-family:\'"+jQuery("#ulp_layer_"+layer_id+"_font").val()+"\',arial;font-weight:"+jQuery("#ulp_layer_"+layer_id+"_font_weight").val()+";color:"+jQuery("#ulp_layer_"+layer_id+"_font_color").val()+";font-size:"+parseInt(jQuery("#ulp_layer_"+layer_id+"_font_size").val(), 10)+"px;";
							if (parseInt(jQuery("#ulp_layer_"+layer_id+"_text_shadow_size").val(), 10) != 0 && jQuery("#ulp_layer_"+layer_id+"_text_shadow_color").val() != "") font += "text-shadow:"+jQuery("#ulp_layer_"+layer_id+"_text_shadow_color").val()+" "+jQuery("#ulp_layer_"+layer_id+"_text_shadow_size").val()+"px "+" "+jQuery("#ulp_layer_"+layer_id+"_text_shadow_size").val()+"px "+" "+jQuery("#ulp_layer_"+layer_id+"_text_shadow_size").val()+"px";
							style += "#ulp-preview-layer-"+layer_id+",#ulp-preview-layer-"+layer_id+" p,#ulp-preview-layer-"+layer_id+" a,#ulp-preview-layer-"+layer_id+" span,#ulp-preview-layer-"+layer_id+" li,#ulp-preview-layer-"+layer_id+" input,#ulp-preview-layer-"+layer_id+" button,#ulp-preview-layer-"+layer_id+" textarea, #ulp-preview-layer-"+layer_id+" select {"+font+"}";';
		if ($this->options['fa_enable'] == 'on') {
			echo '
							if (jQuery("#ulp_input_icons").is(":checked")) {
								style += "#ulp-preview-layer-"+layer_id+" input.ulp-preview-input, #ulp-preview-layer-"+layer_id+" select.ulp-preview-input {padding-left:"+parseInt(4+2*parseInt(jQuery("#ulp_layer_"+layer_id+"_font_size").val(), 10), 10)+"px !important;} #ulp-preview-layer-"+layer_id+" div.ulp-fa-input-cell {width: "+parseInt(2*parseInt(jQuery("#ulp_layer_"+layer_id+"_font_size").val(), 10), 10)+"px !important; padding-left: 4px !important;}";
							}';
		}
		echo '
							style += "#ulp-preview-layer-"+layer_id+" .ulp-preview-checkbox label:after{background:"+jQuery("#ulp_layer_"+layer_id+"_font_color").val()+";}";
							style += "#ulp-preview-layer-"+layer_id+"{"+background+"z-index:"+parseInt(parseInt(jQuery("#ulp_layer_"+layer_id+"_index").val(), 10)+1000, 10)+";text-align:"+jQuery("#ulp_layer_"+layer_id+"_content_align").val()+";}";
							if (jQuery("#ulp_layer_"+layer_id+"_style").val() != "") style += "#ulp-preview-layer-"+layer_id+"{"+jQuery("#ulp_layer_"+layer_id+"_style").val()+"}";
							if (jQuery("#ulp_layer_"+layer_id+"_scrollbar").val() == "on") style += "#ulp-preview-layer-"+layer_id+"{overflow:hidden;}";
							var font_link = "";
							if (!ulp_inarray(jQuery("#ulp_layer_"+layer_id+"_font").val(), ulp_local_fonts)) font_link = "<link href=\'//fonts.googleapis.com/css?family="+jQuery("#ulp_layer_"+layer_id+"_font").val().replace(" ", "+")+":100,200,300,400,500,600,700,800,900&subset=latin,latin-ext,cyrillic,cyrillic-ext,greek\' rel=\'stylesheet\' type=\'text/css\'>";
							var layer = font_link+"<style>"+style+"</style><div class=\'ulp-preview-layer\' id=\'ulp-preview-layer-"+layer_id+"\'>"+content+"</div>";
						}
						jQuery(".ulp-preview-content").append(layer);
					});
					if (ulp_active_layer == 0) {
						layer_id = "0";
						var content = jQuery("#ulp_layer_content").val();
						content = content.replace("{subscription-name}", "<input class=\'ulp-preview-input\' id=\'ulp-preview-input-name\' type=\'text\'>"+input_name_icon_html);
						content = content.replace("{subscription-email}", "<input class=\'ulp-preview-input\' id=\'ulp-preview-input-email\' type=\'text\'>"+input_email_icon_html);
						content = content.replace("{subscription-submit}", "<a class=\'ulp-preview-submit\' id=\'ulp-preview-submit\'></a>");
						content = content.replace("{subscription-phone}", "<input class=\'ulp-preview-input\' id=\'ulp-preview-input-phone\' type=\'text\'>"+input_phone_icon_html);
						content = content.replace("{subscription-message}", "<textarea class=\'ulp-preview-input\' id=\'ulp-preview-input-message\'></textarea>");';
		if ($this->options['recaptcha_enable'] == 'on') {
			echo '
						content = content.replace("{recaptcha}", "<div class=\'ulp-preview-recaptcha\' style=\'width: 306px; height: 80px;\'><img src=\'"+recaptcha_image+"\' /></div>");';
		}
		do_action('ulp_js_build_preview_content');
		echo '					
						var style = "#ulp-preview-layer-"+layer_id+" {left:" + parseInt(jQuery("#ulp_layer_left").val(), 10) + "px;top:" + parseInt(jQuery("#ulp_layer_top").val(), 10) + "px;}";
						if (jQuery("#ulp_layer_width").val() != "") style += "#ulp-preview-layer-"+layer_id+" {width:"+parseInt(jQuery("#ulp_layer_width").val(), 10)+"px;}";
						if (jQuery("#ulp_layer_height").val() != "") style += "#ulp-preview-layer-"+layer_id+" {height:"+parseInt(jQuery("#ulp_layer_height").val(), 10)+"px;}";
						var background = "";		
						if (jQuery("#ulp_layer_background_color").val() != "") {
							var rgb = ulp_hex2rgb(jQuery("#ulp_layer_background_color").val());
							if (rgb != false) background = "background-color:"+jQuery("#ulp_layer_background_color").val()+";background-color:rgba("+rgb.r+","+rgb.g+","+rgb.b+","+jQuery("#ulp_layer_background_opacity").val()+");";
						} else $background = "";
						if (jQuery("#ulp_layer_background_image").val() != "") {
							background += "background-image:url("+jQuery("#ulp_layer_background_image").val()+");background-repeat:repeat;";
						}
						var font = "font-family:\'"+jQuery("#ulp_layer_font").val()+"\',arial;font-weight:"+jQuery("#ulp_layer_font_weight").val()+";color:"+jQuery("#ulp_layer_font_color").val()+";font-size:"+parseInt(jQuery("#ulp_layer_font_size").val(), 10)+"px;";
						if (parseInt(jQuery("#ulp_layer_text_shadow_size").val(), 10) != 0 && jQuery("#ulp_layer_text_shadow_color").val() != "") font += "text-shadow:"+jQuery("#ulp_layer_text_shadow_color").val()+" "+jQuery("#ulp_layer_text_shadow_size").val()+"px "+" "+jQuery("#ulp_layer_text_shadow_size").val()+"px "+" "+jQuery("#ulp_layer_text_shadow_size").val()+"px;";
						style += "#ulp-preview-layer-"+layer_id+",#ulp-preview-layer-"+layer_id+" p,#ulp-preview-layer-"+layer_id+" a,#ulp-preview-layer-"+layer_id+" span,#ulp-preview-layer-"+layer_id+" li,#ulp-preview-layer-"+layer_id+" input,#ulp-preview-layer-"+layer_id+" button,#ulp-preview-layer-"+layer_id+" textarea,#ulp-preview-layer-"+layer_id+" select {"+font+"}";';
		if ($this->options['fa_enable'] == 'on') {
			echo '
						if (jQuery("#ulp_input_icons").is(":checked")) {
							style += "#ulp-preview-layer-"+layer_id+" input.ulp-preview-input, #ulp-preview-layer-"+layer_id+" select.ulp-preview-input {padding-left:"+parseInt(4+2*parseInt(jQuery("#ulp_layer_font_size").val(), 10), 10)+"px !important;} #ulp-preview-layer-"+layer_id+" div.ulp-fa-input-cell {width: "+parseInt(2*parseInt(jQuery("#ulp_layer_font_size").val(), 10), 10)+"px !important; padding-left: 4px !important;}";
						}';
		}
		echo '
						style += "#ulp-preview-layer-"+layer_id+" .ulp-preview-checkbox label:after{background:"+jQuery("#ulp_layer_font_color").val()+";}";
						style += "#ulp-preview-layer-"+layer_id+"{"+background+"z-index:"+parseInt(parseInt(jQuery("#ulp_layer_index").val(), 10)+1000, 10)+";text-align:"+jQuery("#ulp_layer_content_align").val()+";}";
						if (jQuery("#ulp_layer_style").val() != "") style += "#ulp-preview-layer-"+layer_id+"{"+jQuery("#ulp_layer_style").val()+"}";
						if (jQuery("#ulp_layer_scrollbar").is(":checked")) style += "#ulp-preview-layer-"+layer_id+"{overflow:hidden;}";
						var font_link = "";
						if (!ulp_inarray(jQuery("#ulp_layer_font").val(), ulp_local_fonts)) font_link = "<link href=\'//fonts.googleapis.com/css?family="+jQuery("#ulp_layer_font").val().replace(" ", "+")+":100,200,300,400,500,600,700,800,900&subset=latin,latin-ext,cyrillic,cyrillic-ext,greek\' rel=\'stylesheet\' type=\'text/css\'>";
						var layer = font_link+"<style>"+style+"</style><div class=\'ulp-preview-layer ulp-preview-layer-active\' id=\'ulp-preview-layer-"+layer_id+"\'>"+content+"</div>";
						jQuery(".ulp-preview-content").append(layer);
					}
					jQuery("#ulp-preview-input-name").attr("placeholder", jQuery("[name=\'ulp_name_placeholder\']").val());
					jQuery("#ulp-preview-input-email").attr("placeholder", jQuery("[name=\'ulp_email_placeholder\']").val());
					if (jQuery("#ulp_button_inherit_size").is(":checked")) {
						jQuery("#ulp-preview-submit").addClass("ulp-inherited");
					} else {
						jQuery("#ulp-preview-submit").removeClass("ulp-inherited");
					}
					var button_icon = "";
					if (jQuery("#ulp-button-icon").val() && jQuery("#ulp-button-icon").val() != "fa-noicon") button_icon = "<i class=\'fa "+jQuery("#ulp-button-icon").val()+"\'></i>&nbsp; "
					jQuery("#ulp-preview-submit").html(button_icon+jQuery("[name=\'ulp_button_label\']").val());
					jQuery("#ulp-preview-input-phone").attr("placeholder", jQuery("[name=\'ulp_phone_placeholder\']").val());
					jQuery("#ulp-preview-input-message").attr("placeholder", jQuery("[name=\'ulp_message_placeholder\']").val());
				}
				ulp_build_preview();
				var ulp_keyuprefreshtimer;
				jQuery(document).ready(function(){
					jQuery(".ulp-color").wpColorPicker({
						change: function(event, ui) {
							setTimeout(function(){ulp_build_preview();}, 300);
						},
						clear: function() {ulp_build_preview();}
					});
					jQuery("input, select, textarea").bind("change", function() {
						clearTimeout(ulp_keyuprefreshtimer);
						ulp_build_preview();
					});
					jQuery(\'input[type="checkbox"]\').bind("click", function() {
						ulp_build_preview();
					});
					jQuery("input, select, textarea").bind("keyup", function() {
						clearTimeout(ulp_keyuprefreshtimer);
						ulp_keyuprefreshtimer = setTimeout(function(){ulp_build_preview();}, 1000);
					});
				});
			</script>
		</div>
		<div class="ulp_legend">
			<strong>Legend:</strong>
			<p><img src="'.plugins_url('/images/copy.png', __FILE__).'" alt="'.__('Duplicate layer', 'ulp').'" border="0"> '.__('Duplicate layer', 'ulp').'</p>
			<p><img src="'.plugins_url('/images/edit.png', __FILE__).'" alt="'.__('Edit layer details', 'ulp').'" border="0"> '.__('Edit layer details', 'ulp').'</p>
			<p><img src="'.plugins_url('/images/delete.png', __FILE__).'" alt="'.__('Delete layer', 'ulp').'" border="0"> '.__('Delete layer', 'ulp').'</p>
		</div>
<div id="ulp-layers-item-container" style="display: none;">
	<div class="ulp-layers-item-cell ulp-layers-item-cell-info">
		<h4></h4>
		<p></p>
	</div>
	<div class="ulp-layers-item-cell" style="width: 70px;">
		<a href="#" title="'.__('Edit layer details', 'ulp').'" onclick="return ulp_edit_layer(this);"><img src="'.plugins_url('/images/edit.png', __FILE__).'" alt="'.__('Edit layer details', 'ulp').'" border="0"></a>
		<a href="#" title="'.__('Duplicate layer', 'ulp').'" onclick="return ulp_copy_layer(this);"><img src="'.plugins_url('/images/copy.png', __FILE__).'" alt="'.__('Duplicate details', 'ulp').'" border="0"></a>
		<a href="#" title="'.__('Delete layer', 'ulp').'" onclick="return ulp_delete_layer(this);"><img src="'.plugins_url('/images/delete.png', __FILE__).'" alt="'.__('Delete layer', 'ulp').'" border="0"></a>
	</div>
</div>
<div id="ulp-layer-options-container" style="display: none;">
	<div class="ulp-layer-options">
		<div class="ulp-layer-row">
			<div class="ulp-layer-property">
				<label>'.__('Layer title', 'ulp').'</label>
				<input type="text" id="ulp_layer_title" name="ulp_layer_title" value="" class="widefat" placeholder="Enter the layer title...">
				<br /><em>'.__('Enter the layer title. It is used for your reference.', 'ulp').'</em>
			</div>
		</div>
		<div class="ulp-layer-row">
			<div class="ulp-layer-property">
				<label>'.__('Layer content', 'ulp').'</label>
				<textarea id="ulp_layer_content" name="ulp_layer_content" class="widefat" placeholder="Enter the layer content..."></textarea>
				<br /><em>'.__('Enter the layer content. HTML-code allowed.', 'ulp').'</em>
			</div>
		</div>
		<div class="ulp-layer-row">
			<div class="ulp-layer-property">
				<label>'.__('Layer size', 'ulp').'</label>
				<input type="text" id="ulp_layer_width" name="ulp_layer_width" value="" class="ic_input_number" placeholder="Width"> x
				<input type="text" id="ulp_layer_height" name="ulp_layer_height" value="" class="ic_input_number" placeholder="Height"> pixels
				<br /><em>'.__('Enter the layer size, width x height. Leave both or one field empty for auto calculation.', 'ulp').'</em>
			</div>
			<div class="ulp-layer-property">
				<label>'.__('Scrollbar', 'ulp').'</label>
				<input type="checkbox" id="ulp_layer_scrollbar" name="ulp_layer_scrollbar"> '.__('Add scrollbar', 'ulp').'
				<br /><em>'.__('Add scrollbar to the layer. Layer height must be set.', 'ulp').'</em>
			</div>
			<div class="ulp-layer-property">
				<label>'.__('Left position', 'ulp').'</label>
				<input type="text" id="ulp_layer_left" name="ulp_layer_left" value="" class="ic_input_number" placeholder="Left"> pixels
				<br /><em>'.__('Enter the layer left position relative basic frame left edge.', 'ulp').'</em>
			</div>
			<div class="ulp-layer-property">
				<label>'.__('Top position', 'ulp').'</label>
				<input type="text" id="ulp_layer_top" name="ulp_layer_top" value="" class="ic_input_number" placeholder="Top"> pixels
				<br /><em>'.__('Enter the layer top position relative basic frame top edge.', 'ulp').'</em>
			</div>
			<div class="ulp-layer-property">
				<label>'.__('Content alignment', 'ulp').'</label>
				<select class="ic_input_s" id="ulp_layer_content_align" name="ulp_layer_content_align">';
			foreach ($this->alignments as $key => $value) {
				echo '
					<option value="'.$key.'">'.esc_html($value).'</option>';
			}
			echo '
				</select>
				<br /><em>'.__('Set the horizontal content alignment.', 'ulp').'</em>
			</div>
		</div>
		<div class="ulp-layer-row">
			<div class="ulp-layer-property" style="width: 25%;">
				<label>'.__('Appearance', 'ulp').'</label>
				<select class="ic_input_s" id="ulp_layer_appearance" name="ulp_layer_appearance">';
			if ($this->options['css3_enable'] == 'on') {
				echo '
					<option value="" disabled="disabled">'.__('=== Basic jQuery Animation ===', 'ulp').'</option>';
			}
			foreach ($this->appearances as $key => $value) {
				echo '
					<option value="'.$key.'">'.esc_html($value).'</option>';
			}
			if ($this->options['css3_enable'] == 'on') {
				echo '
					<option value="" disabled="disabled">'.__('=== CSS3 Animation ===', 'ulp').'</option>';
				foreach ($this->css3_appearances as $key => $value) {
					echo '
						<option value="'.$key.'">'.esc_html($value).'</option>';
				}
			}
			echo '
				</select>
				<br /><em>'.__('Set the layer appearance.', 'ulp').'</em>
			</div>
			<div class="ulp-layer-property" style="width: 25%;">
				<label>'.__('Start delay', 'ulp').'</label>
				<input type="text" id="ulp_layer_appearance_delay" name="ulp_layer_appearance_delay" value="" class="ic_input_number" placeholder="[0...10000]"> milliseconds
				<br /><em>'.__('Set the appearance start delay. The value must be in a range [0...1].', 'ulp').'</em>
			</div>
			<div class="ulp-layer-property" style="width: 25%;">
				<label>'.__('Duration speed', 'ulp').'</label>
				<input type="text" id="ulp_layer_appearance_speed" name="ulp_layer_appearance_speed" value="" class="ic_input_number" placeholder="[0...10000]"> milliseconds
				<br /><em>'.__('Set the duration speed in milliseconds.', 'ulp').'</em>
			</div>
			<div class="ulp-layer-property" style="width: 25%;">
				<label>'.__('Layer index', 'ulp').'</label>
				<input type="text" id="ulp_layer_index" name="ulp_layer_index" value="" class="ic_input_number" placeholder="[0...100]">
				<br /><em>'.__('Set the stack order of the layer. A layer with greater stack order is always in front of a layer with a lower stack order.', 'ulp').'</em>
			</div>
		</div>
		<div class="ulp-layer-row">
			<div class="ulp-layer-property" style="width: 270px;">
				<label>'.__('Background color', 'ulp').'</label>
				<input type="text" class="ulp-color ic_input_number" id="ulp_layer_background_color" name="ulp_layer_background_color" value="" placeholder="">
				<br /><em>'.__('Set the background color. Leave empty for transparent background.', 'ulp').'</em>
			</div>
			<div class="ulp-layer-property" style="width: 200px;">
				<label>'.__('Background opacity', 'ulp').'</label>
				<input type="text" id="ulp_layer_background_opacity" name="ulp_layer_background_opacity" value="" class="ic_input_number" placeholder="[0...1]">
				<br /><em>'.__('Set the background opacity. The value must be in a range [0...1].', 'ulp').'</em>
			</div>
			<div class="ulp-layer-property">
				<label>'.__('Background image URL', 'ulp').'</label>
				<input type="text" id="ulp_layer_background_image" name="ulp_layer_background_image" value="" class="widefat" placeholder="Enter the background image URL...">
				<br /><em>'.__('Enter the background image URL.', 'ulp').'</em>
			</div>
		</div>
		<div class="ulp-layer-row">
			<div class="ulp-layer-property" style="width: 230px;">
				<label>'.__('Font', 'ulp').'</label>
				<select class="ic_input_m" id="ulp_layer_font" name="ulp_layer_font">
					<option disabled="disabled">------ LOCAL FONTS ------</option>';
			foreach ($this->local_fonts as $key => $value) {
				echo '
					<option value="'.$key.'">'.esc_html($value).'</option>';
			}
			if (is_array($webfonts_array) && !empty($webfonts_array)) {
				echo '
					<option disabled="disabled">------ WEB FONTS ------</option>';
				foreach ($webfonts_array as $webfont) {
					echo '
					<option value="'.esc_html($webfont['family']).'">'.esc_html($webfont['family']).'</option>';
				}
			}
			echo '
				</select>
				<br /><em>'.__('Select the font.', 'ulp').'</em>
			</div>
			<div class="ulp-layer-property" style="width: 270px;">
				<label>'.__('Font color', 'ulp').'</label>
				<input type="text" class="ulp-color ic_input_number" id="ulp_layer_font_color" name="ulp_layer_font_color" value="" placeholder="">
				<br /><em>'.__('Set the font color.', 'ulp').'</em>
			</div>
			<div class="ulp-layer-property" style="width: 25%;">
				<label>'.__('Font size', 'ulp').'</label>
				<input type="text" id="ulp_layer_font_size" name="ulp_layer_font_size" value="" class="ic_input_number" placeholder="Font size"> pixels
				<br /><em>'.__('Set the font size. The value must be in a range [10...64].', 'ulp').'</em>
			</div>
			<div class="ulp-layer-property" style="width: 25%;">
				<label>'.__('Font weight', 'ulp').'</label>
				<select class="ic_input_s" id="ulp_layer_font_weight" name="ulp_layer_font_weight">';
			foreach ($this->font_weights as $key => $value) {
				echo '
					<option value="'.$key.'">'.esc_html($key.' - '.$value).'</option>';
			}
			echo '
				</select>
				<br /><em>'.__('Select the font weight. Some fonts may not support selected font weight.', 'ulp').'</em>
			</div>
		</div>
		<div class="ulp-layer-row">
			<div class="ulp-layer-property" style="width: 200px;">
				<label>'.__('Text shadow size', 'ulp').'</label>
				<input type="text" id="ulp_layer_text_shadow_size" name="ulp_layer_text_shadow_size" value="" class="ic_input_number" placeholder="Shadow size"> pixels
				<br /><em>'.__('Set the text shadow size.', 'ulp').'</em>
			</div>
			<div class="ulp-layer-property" style="width: 270px;">
				<label>'.__('Text shadow color', 'ulp').'</label>
				<input type="text" class="ulp-color ic_input_number" id="ulp_layer_text_shadow_color" name="ulp_layer_text_shadow_color" value="" placeholder="">
				<br /><em>'.__('Set the text shadow color.', 'ulp').'</em>
			</div>
			<div class="ulp-layer-property">
				<label>'.__('Custom style', 'ulp').'</label>
				<input type="text" id="ulp_layer_style" name="ulp_layer_style" value="" class="widefat" placeholder="Enter the custom style string...">
				<br /><em>'.__('Enter the custom style string. This value is added to layer <code>style</code> attribute.', 'ulp').'</em>
			</div>
		</div>
		<div class="ulp-layer-row">
			<div class="ulp-layer-property">
				<input type="checkbox" id="ulp_layer_confirmation_layer" name="ulp_layer_confirmation_layer"> '.__('"Confirmation of subscription" layer', 'ulp').'
				<br /><em>'.__('This layer appears only on successful submitting of subscription/contact form.', 'ulp').'</em>
			</div>
			<div class="ulp-layer-property">
				<input type="checkbox" id="ulp_layer_inline_disable" name="ulp_layer_inline_disable"> '.__('Disable for inline mode', 'ulp').'
				<br /><em>'.__('This layer appears only in popup mode and disabled for inline mode.', 'ulp').'</em>
			</div>
		</div>
		<div class="ulp-layer-row">
			<div class="ulp-layer-property">
				<input type="hidden" name="action" value="ulp_save_layer">
				<input type="hidden" name="ulp_layer_id" value="0">
				<input type="hidden" name="ulp_popup_id" value="'.$id.'">
				<input type="button" class="ulp-button button-primary" name="submit" value="'.__('Save Layer', 'ulp').'" onclick="return ulp_save_layer();">
				<img class="ulp-loading" src="'.plugins_url('/images/loading.gif', __FILE__).'">
			</div>
			<div class="ulp-layer-property" style="text-align: right;">
				<input type="button" class="ulp-button button-secondary" name="submit" value="'.__('Cancel', 'ulp').'" onclick="return ulp_cancel_layer(this);">
			</div>
		</div>
		<div class="ulp-message"></div>
	</div>
</div>';
	}

	function save_popup() {
		global $wpdb;
		$popup_options = array();
		if (current_user_can('manage_options')) {
			foreach ($this->default_popup_options as $key => $value) {
				if (isset($_POST['ulp_'.$key])) {
					$popup_options[$key] = stripslashes(trim($_POST['ulp_'.$key]));
				}
			}
			if (isset($_POST["ulp_disable_overlay"])) $popup_options['disable_overlay'] = "on";
			else $popup_options['disable_overlay'] = "off";
			if (isset($_POST["ulp_enable_close"])) $popup_options['enable_close'] = "on";
			else $popup_options['enable_close'] = "off";
			if (isset($_POST["ulp_name_mandatory"])) $popup_options['name_mandatory'] = "on";
			else $popup_options['name_mandatory'] = "off";
			if (isset($_POST["ulp_phone_mandatory"])) $popup_options['phone_mandatory'] = "on";
			else $popup_options['phone_mandatory'] = "off";
			if (isset($_POST["ulp_message_mandatory"])) $popup_options['message_mandatory'] = "on";
			else $popup_options['message_mandatory'] = "off";
			if (isset($_POST["ulp_button_gradient"])) $popup_options['button_gradient'] = "on";
			else $popup_options['button_gradient'] = "off";
			if (isset($_POST["ulp_button_inherit_size"])) $popup_options['button_inherit_size'] = "on";
			else $popup_options['button_inherit_size'] = "off";
			if (isset($_POST["ulp_input_icons"])) $popup_options['input_icons'] = "on";
			else $popup_options['input_icons'] = "off";
			if (isset($_POST["ulp_recaptcha_mandatory"])) $popup_options['recaptcha_mandatory'] = "on";
			else $popup_options['recaptcha_mandatory'] = "off";
			
			if (isset($_POST['ulp_id'])) $popup_id = intval($_POST['ulp_id']);
			else $popup_id = 0;
			$popup_details = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."ulp_popups WHERE id = '".$popup_id."'", ARRAY_A);
			if (empty($popup_details)) {
				$return_object = array();
				$return_object['status'] = 'ERROR';
				$return_object['message'] = __('Invalid popup ID. Try again later.', 'ulp');
				echo json_encode($return_object);
				exit;
			}
			$errors = array();
			
			$layers = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."ulp_layers WHERE popup_id = '".$popup_id."' AND deleted = '0'", ARRAY_A);
			if (!$layers) $errors[] = __('Create at least one layer.', 'ulp');
			if (strlen($popup_options['title']) < 1) $errors[] = __('Popup title is too short.', 'ulp');
			if (strlen($popup_options['width']) > 0 && $popup_options['width'] != preg_replace('/[^0-9]/', '', $popup_options['width'])) $errors[] = __('Invalid popup basic width.', 'ulp');
			if (strlen($popup_options['height']) > 0 && $popup_options['height'] != preg_replace('/[^0-9]/', '', $popup_options['height'])) $errors[] = __('Invalid popup basic height.', 'ulp');
			if (strlen($popup_options['overlay_color']) > 0 && $this->get_rgb($popup_options['overlay_color']) === false) $errors[] = __('Ovarlay color must be a valid value.', 'ulp');
			if (floatval($popup_options['overlay_opacity']) < 0 || floatval($popup_options['overlay_opacity']) > 1) $errors[] = __('Overlay opacity must be in a range [0...1].', 'ulp');
			if (strlen($popup_options['name_placeholder']) < 1) $errors[] = __('"Name" field placeholder is too short.', 'ulp');
			if (strlen($popup_options['email_placeholder']) < 1) $errors[] = __('"E-mail" field placeholder is too short.', 'ulp');
			if (strlen($popup_options['phone_placeholder']) < 1) $errors[] = __('"Phone number" field placeholder is too short.', 'ulp');
			if (strlen($popup_options['message_placeholder']) < 1) $errors[] = __('"Message" text area placeholder is too short.', 'ulp');
			if (strlen($popup_options['input_border_color']) > 0 && $this->get_rgb($popup_options['input_border_color']) === false) $errors[] = __('Input field border color must be a valid value.', 'ulp');
			if (strlen($popup_options['input_background_color']) > 0 && $this->get_rgb($popup_options['input_background_color']) === false) $errors[] = __('Input field background color must be a valid value.', 'ulp');
			if (floatval($popup_options['input_background_opacity']) < 0 || floatval($popup_options['input_background_opacity']) > 1) $errors[] = __('Input field background opacity must be in a range [0...1].', 'ulp');
			if (strlen($popup_options['button_label']) < 1) $errors[] = __('"Submit" button label is too short.', 'ulp');
			if (strlen($popup_options['button_color']) == 0 || $this->get_rgb($popup_options['button_color']) === false) $errors[] = __('"Submit" button color must be a valid value.', 'ulp');
			//if (strlen($popup_options['return_url']) > 0 && !preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $popup_options['return_url'])) $errors[] = __('Redirect URL must be a valid URL.', 'ulp');
			if (strlen($popup_options['close_delay']) > 0 && $popup_options['close_delay'] != preg_replace('/[^0-9]/', '', $popup_options['close_delay'])) $errors[] = __('Invalid autoclose delay.', 'ulp');

			if (strlen($popup_options['input_border_width']) > 0 && $popup_options['input_border_width'] != preg_replace('/[^0-9]/', '', $popup_options['input_border_width'])) $errors[] = __('Invalid input field border width.', 'ulp');
			if (strlen($popup_options['input_border_radius']) > 0 && $popup_options['input_border_radius'] != preg_replace('/[^0-9]/', '', $popup_options['input_border_radius'])) $errors[] = __('Invalid input field border radius.', 'ulp');
			if (strlen($popup_options['button_border_radius']) > 0 && $popup_options['button_border_radius'] != preg_replace('/[^0-9]/', '', $popup_options['button_border_radius'])) $errors[] = __('Invalid "Submit" button border radius.', 'ulp');
			
			$errors = apply_filters('ulp_popup_options_check', $errors);
			
			if (!empty($errors)) {
				$return_object = array();
				$return_object['status'] = 'ERROR';
				$return_object['message'] = __('Attention! Please correct the errors below and try again.', 'ulp').'<ul><li>'.implode('</li><li>', $errors).'</li></ul>';
				echo json_encode($return_object);
				exit;
			}
			
			$popup_options = apply_filters('ulp_popup_options_populate', $popup_options);
			
			$sql = "UPDATE ".$wpdb->prefix."ulp_popups SET
				title = '".esc_sql($popup_options['title'])."',
				width = '".intval($popup_options['width'])."',
				height = '".intval($popup_options['height'])."',
				options = '".esc_sql(serialize($popup_options))."',
				deleted = '0'
				WHERE id = '".$popup_id."'";
			$wpdb->query($sql);

			setcookie("ulp_info", __('Popup details successfully <strong>saved</strong>.', 'ulp'), time()+30, "/", ".".str_replace("www.", "", $_SERVER["SERVER_NAME"]));
			
			$return_object = array();
			$return_object['status'] = 'OK';
			$return_object['return_url'] = admin_url('admin.php').'?page=ulp';
			echo json_encode($return_object);
			exit;
		}
	}
	
	function save_layer() {
		global $wpdb;
		$layer_options = array();
		if (current_user_can('manage_options')) {
			foreach ($this->default_layer_options as $key => $value) {
				if (isset($_POST['ulp_layer_'.$key])) {
					$layer_options[$key] = stripslashes(trim($_POST['ulp_layer_'.$key]));
					//$layer_options[$key] = str_replace(array(plugins_url('/images/default', __FILE__), 'http://datastorage.pw/images'), array('ULP-DEMO-IMAGES-URL', 'ULP-DEMO-IMAGES-URL'), $layer_options[$key]);
				}
			}
			if (isset($_POST['ulp_layer_scrollbar'])) $layer_options['scrollbar'] = 'on';
			else $layer_options['scrollbar'] = 'off';
			if (isset($_POST['ulp_layer_confirmation_layer'])) $layer_options['confirmation_layer'] = 'on';
			else $layer_options['confirmation_layer'] = 'off';
			if (isset($_POST['ulp_layer_inline_disable'])) $layer_options['inline_disable'] = 'on';
			else $layer_options['inline_disable'] = 'off';
			if (isset($_POST['ulp_layer_id'])) $layer_id = intval($_POST['ulp_layer_id']);
			else $layer_id = 0;
			if (isset($_POST['ulp_popup_id'])) $popup_id = intval($_POST['ulp_popup_id']);
			else $popup_id = 0;
			
			$popup_details = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."ulp_popups WHERE id = '".$popup_id."'", ARRAY_A);
			if (empty($popup_details)) {
				$return_object = array();
				$return_object['status'] = 'ERROR';
				$return_object['message'] = __('Invalid popup ID. Try again later.', 'ulp');
				echo json_encode($return_object);
				exit;
			}
			$errors = array();
			if (strlen($layer_options['title']) < 1) $errors[] = __('Layer title is too short.', 'ulp');
			if (strlen($layer_options['width']) > 0 && $layer_options['width'] != preg_replace('/[^0-9]/', '', $layer_options['width'])) $errors[] = __('Invalid layer width.', 'ulp');
			if (strlen($layer_options['height']) > 0 && $layer_options['height'] != preg_replace('/[^0-9]/', '', $layer_options['height'])) $errors[] = __('Invalid layer height.', 'ulp');
			if (strlen($layer_options['left']) == 0 || $layer_options['left'] != preg_replace('/[^0-9\-]/', '', $layer_options['left'])) $errors[] = __('Invalid left position.', 'ulp');
			if (strlen($layer_options['top']) == 0 || $layer_options['top'] != preg_replace('/[^0-9\-]/', '', $layer_options['top'])) $errors[] = __('Invalid top position.', 'ulp');
			if (strlen($layer_options['background_color']) > 0 && $this->get_rgb($layer_options['background_color']) === false) $errors[] = __('Background color must be a valid value.', 'ulp');
			if (floatval($layer_options['background_opacity']) < 0 || floatval($layer_options['background_opacity']) > 1) $errors[] = __('Background opacity must be in a range [0...1].', 'ulp');
			if (strlen($layer_options['background_image']) > 0 && !preg_match('~^((http(s)?://)|(//))[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$~i', $layer_options['background_image'])) $errors[] = __('Background image URL must be a valid URL.', 'ulp');
			if (strlen($layer_options['index']) > 0 && $layer_options['index'] != preg_replace('/[^0-9]/', '', $layer_options['index']) && $layer_options['index'] > 100) $errors[] = __('Layer index must be in a range [0...100].', 'ulp');
			if (strlen($layer_options['appearance_delay']) > 0 && $layer_options['appearance_delay'] != preg_replace('/[^0-9]/', '', $layer_options['appearance_delay']) && $layer_options['appearance_delay'] > 10000) $errors[] = __('Appearance start delay must be in a range [0...10000].', 'ulp');
			if (strlen($layer_options['appearance_speed']) > 0 && $layer_options['appearance_speed'] != preg_replace('/[^0-9]/', '', $layer_options['appearance_speed']) && $layer_options['appearance_speed'] > 10000) $errors[] = __('Appearance duration speed must be in a range [0...10000].', 'ulp');
			if (strlen($layer_options['font_color']) > 0 && $this->get_rgb($layer_options['font_color']) === false) $errors[] = __('Font color must be a valid value.', 'ulp');
			if (strlen($layer_options['font_size']) > 0 && $layer_options['font_size'] != preg_replace('/[^0-9]/', '', $layer_options['font_size']) && ($layer_options['font_size'] > 72 || $layer_options['font_size'] < 10)) $errors[] = __('Font size must be in a range [10...72].', 'ulp');
			if (strlen($layer_options['text_shadow_color']) > 0 && $this->get_rgb($layer_options['text_shadow_color']) === false) $errors[] = __('Text shadow color must be a valid value.', 'ulp');
			if (strlen($layer_options['text_shadow_size']) > 0 && $layer_options['text_shadow_size'] != preg_replace('/[^0-9]/', '', $layer_options['text_shadow_size']) && $layer_options['text_shadow_size'] > 72) $errors[] = __('Text shadow size must be in a range [0...72].', 'ulp');

			if (!empty($errors)) {
				$return_object = array();
				$return_object['status'] = 'ERROR';
				$return_object['message'] = __('Attention! Please correct the errors below and try again.', 'ulp').'<ul><li>'.implode('</li><li>', $errors).'</li></ul>';
				echo json_encode($return_object);
				exit;
			}
			
			foreach ($layer_options as $key => $value) {
				$layer_options[$key] = str_replace(array(plugins_url('/images/default', __FILE__), 'http://datastorage.pw/images'), array('ULP-DEMO-IMAGES-URL', 'ULP-DEMO-IMAGES-URL'), $layer_options[$key]);
			}
			
			if ($layer_id > 0) $layer_details = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."ulp_layers WHERE id = '".$layer_id."' AND popup_id = '".$popup_id."' AND deleted = '0'", ARRAY_A);
			if (!empty($layer_details)) {
				$sql = "UPDATE ".$wpdb->prefix."ulp_layers SET
					title = '".esc_sql($layer_options['title'])."',
					content = '".esc_sql($layer_options['content'])."',
					zindex = '".esc_sql($layer_options['index'])."',
					details = '".esc_sql(serialize($layer_options))."'
					WHERE id = '".$layer_id."'";
				$wpdb->query($sql);
			} else {
				$sql = "INSERT INTO ".$wpdb->prefix."ulp_layers (
					popup_id, title, content, zindex, details, created, deleted) VALUES (
					'".$popup_id."',
					'".esc_sql($layer_options['title'])."',
					'".esc_sql($layer_options['content'])."',
					'".esc_sql($layer_options['index'])."',
					'".esc_sql(serialize($layer_options))."',
					'".time()."', '0')";
				$wpdb->query($sql);
				$layer_id = $wpdb->insert_id;
			}
			
			$layer_options = $this->filter_lp($layer_options);
			$return_object = array();
			$return_object['status'] = 'OK';
			$return_object['title'] = esc_html($layer_options['title']);
			if (strlen($layer_options['content']) == 0) $content = 'No content...';
			else if (strlen($layer_options['content']) > 192) $content = substr($layer_options['content'], 0, 180).'...';
			else $content = $layer_options['content'];
			$return_object['content'] = esc_html($content);
			$layer_options_html = '';
			foreach ($layer_options as $key => $value) {
				$layer_options_html .= '<input type="hidden" id="ulp_layer_'.$layer_id.'_'.$key.'" name="ulp_layer_'.$layer_id.'_'.$key.'" value="'.esc_html($value).'">';
			}
			$return_object['options_html'] = $layer_options_html;
			$return_object['layer_id'] = $layer_id;
			echo json_encode($return_object);
			exit;
		}
	}

	function copy_layer() {
		global $wpdb;
		if (current_user_can('manage_options')) {
			if (isset($_POST['ulp_layer_id'])) $layer_id = intval($_POST['ulp_layer_id']);
			else $layer_id = 0;
			$layer_details = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."ulp_layers WHERE id = '".$layer_id."' AND deleted = '0'", ARRAY_A);
			if (empty($layer_details)) {
				$return_object = array();
				$return_object['status'] = 'ERROR';
				$return_object['message'] = __('Layer not found!', 'ulp');
				echo json_encode($return_object);
				exit;
			}
			$layer_options = unserialize($layer_details['details']);
			if (is_array($layer_options)) $layer_options = array_merge($this->default_layer_options, $layer_options);
			else $layer_options = $this->default_layer_options;
			$layer_options = $this->filter_lp($layer_options);
			$sql = "INSERT INTO ".$wpdb->prefix."ulp_layers (
				popup_id, title, content, zindex, details, created, deleted) VALUES (
				'".$layer_details['popup_id']."',
				'".esc_sql($layer_details['title'])."',
				'".esc_sql($layer_details['content'])."',
				'".esc_sql($layer_details['zindex'])."',
				'".esc_sql($layer_details['details'])."',
				'".time()."', '0')";
			$wpdb->query($sql);
			$layer_id = $wpdb->insert_id;
			$return_object = array();
			$return_object['status'] = 'OK';
			$return_object['title'] = esc_html($layer_options['title']);
			if (strlen($layer_options['content']) == 0) $content = 'No content...';
			else if (strlen($layer_options['content']) > 192) $content = substr($layer_options['content'], 0, 180).'...';
			else $content = $layer_options['content'];
			$return_object['content'] = esc_html($content);
			$layer_options_html = '';
			foreach ($layer_options as $key => $value) {
				$layer_options_html .= '<input type="hidden" id="ulp_layer_'.$layer_id.'_'.$key.'" name="ulp_layer_'.$layer_id.'_'.$key.'" value="'.esc_html($value).'">';
			}
			$return_object['options_html'] = $layer_options_html;
			$return_object['layer_id'] = $layer_id;
			echo json_encode($return_object);
			exit;
		}
		exit;
	}
	
	function delete_layer() {
		global $wpdb;
		if (current_user_can('manage_options')) {
			if (isset($_POST['ulp_layer_id'])) $layer_id = intval($_POST['ulp_layer_id']);
			else $layer_id = 0;
			$sql = "UPDATE ".$wpdb->prefix."ulp_layers SET deleted = '1' WHERE id = '".$layer_id."'";
			$wpdb->query($sql);
		}
		exit;
	}

	function admin_campaigns() {
		global $wpdb;

		if (isset($_GET["s"])) $search_query = trim(stripslashes($_GET["s"]));
		else $search_query = "";
		$tmp = $wpdb->get_row("SELECT COUNT(*) AS total FROM ".$wpdb->prefix."ulp_campaigns WHERE deleted = '0'".((strlen($search_query) > 0) ? " AND title LIKE '%".addslashes($search_query)."%'" : ""), ARRAY_A);
		$total = $tmp["total"];
		$totalpages = ceil($total/ULP_RECORDS_PER_PAGE);
		if ($totalpages == 0) $totalpages = 1;
		if (isset($_GET["p"])) $page = intval($_GET["p"]);
		else $page = 1;
		if ($page < 1 || $page > $totalpages) $page = 1;
		$switcher = $this->page_switcher(admin_url('admin.php').'?page=ulp-campaigns'.((strlen($search_query) > 0) ? '&s='.rawurlencode($search_query) : ''), $page, $totalpages);

		if (isset($_GET['o'])) {
			$sort = $_GET['o'];
			if (in_array($sort, $this->sort_methods)) {
				if ($sort != $this->options['campaigns_sort']) {
					update_option('ulp_campaigns_sort', $sort);
					$this->options['campaigns_sort'] = $sort;
				}
			} else $sort = $this->options['campaigns_sort'];
		} else $sort = $this->options['campaigns_sort'];
		$orderby = 't1.created DESC';
		switch ($sort) {
			case 'title-az':
				$orderby = 't1.title ASC';
				break;
			case 'title-za':
				$orderby = 't1.title DESC';
				break;
			case 'date-az':
				$orderby = 't1.created ASC';
				break;
			default:
				$orderby = 't1.created DESC';
				break;
		}
		
		$sql = "SELECT t1.*, t2.popups, t2.clicks, t2.impressions FROM ".$wpdb->prefix."ulp_campaigns t1 LEFT JOIN (SELECT COUNT(*) AS popups, SUM(tt1.clicks) AS clicks, SUM(tt1.impressions) AS impressions, tt1.campaign_id FROM ".$wpdb->prefix."ulp_campaign_items tt1 JOIN ".$wpdb->prefix."ulp_popups tt2 ON tt2.id = tt1.popup_id WHERE tt1.deleted = '0' AND tt2.deleted = '0' GROUP BY tt1.campaign_id) t2 ON t2.campaign_id = t1.id WHERE t1.deleted = '0'".((strlen($search_query) > 0) ? " AND t1.title LIKE '%".addslashes($search_query)."%'" : "")." ORDER BY ".$orderby." LIMIT ".(($page-1)*ULP_RECORDS_PER_PAGE).", ".ULP_RECORDS_PER_PAGE;
		$rows = $wpdb->get_results($sql, ARRAY_A);
		if (!empty($this->error)) $message = "<div class='error'><p>".$this->error."</p></div>";
		else if (!empty($this->info)) $message = "<div class='updated'><p>".$this->info."</p></div>";
		else $message = '';

		echo '
			<div class="wrap admin_ulp_wrap">
				<div id="icon-edit-pages" class="icon32"><br /></div><h2>'.__('Layered Popups - A/B Campaigns', 'ulp').'</h2><br />
				'.$message.'
				<div class="ulp-top-forms">
					<div class="ulp-top-form-left">
						<form action="'.admin_url('admin.php').'" method="get" style="margin-bottom: 10px;">
						<input type="hidden" name="page" value="ulp-campaigns" />
						'.__('Search:', 'ulp').' <input type="text" name="s" value="'.esc_html($search_query).'">
						<input type="submit" class="button-secondary action" value="'.__('Search', 'ulp').'" />
						'.((strlen($search_query) > 0) ? '<input type="button" class="button-secondary action" value="'.__('Reset search results', 'ulp').'" onclick="window.location.href=\''.admin_url('admin.php').'?page=ulp-campaigns\';" />' : '').'
						</form>
					</div>
					<div class="ulp-top-form-right">
						<form id="ulp-sorting-form" action="'.admin_url('admin.php').'" method="get" style="margin-bottom: 10px;">
						<input type="hidden" name="page" value="ulp-campaigns" />
						'.__('Sort:', 'ulp').'
						'.((strlen($search_query) > 0) ? '<input type="text" name="s" value="'.esc_html($search_query).'">' : '').'
						'.(($page > 1) ? '<input type="text" name="p" value="'.esc_html($page).'">' : '').'
						<select name="o" onchange="jQuery(\'#ulp-sorting-form\').submit();">
							<option value="title-az"'.($sort == 'title-az' ? ' selected="selected"' : '').'>'.__('Alphabetically', 'ulp').' ▲</option>
							<option value="title-za"'.($sort == 'title-za' ? ' selected="selected"' : '').'>'.__('Alphabetically', 'ulp').' ▼</option>
							<option value="date-az"'.($sort == 'date-az' ? ' selected="selected"' : '').'>'.__('Created', 'ulp').' ▲</option>
							<option value="date-za"'.($sort == 'date-za' ? ' selected="selected"' : '').'>'.__('Created', 'ulp').' ▼</option>
						</select>
						</form>
					</div>
				</div>
				<div class="ulp_buttons"><a class="button" href="'.admin_url('admin.php').'?page=ulp-add-campaign">'.__('Create New Campaign', 'ulp').'</a></div>
				<div class="ulp_pageswitcher">'.$switcher.'</div>
				<table class="ulp_records">
				<tr>
					<th>'.__('Title', 'ulp').'</th>
					<th style="width: 180px;">'.__('ID', 'ulp').'</th>
					<th style="width: 80px;">'.__('Popups', 'ulp').'</th>
					<th style="width: 80px;">'.__('Submits', 'ulp').'</th>
					<th style="width: 80px;">'.__('Impressions', 'ulp').'</th>
					<th style="width: 110px;"></th>
				</tr>';
		if (sizeof($rows) > 0) {
			foreach ($rows as $row) {
				echo '
				<tr>
					<td>'.($row['blocked'] == 1 ? '<span class="ulp-badge ulp-badge-blocked">Blocked</span> ' : '').'<strong>'.esc_html($row['title']).'</strong></td>
					<td><input type="text" value="'.$row['str_id'].'" readonly="readonly" style="width: 100%;" onclick="this.focus();this.select();"></td>
					<td style="text-align: right;">'.intval($row['popups']).'</td>
					<td style="text-align: right;">'.intval($row['clicks']).'</td>
					<td style="text-align: right;">'.intval($row['impressions']).'</td>
					<td style="text-align: center;">
						<a href="'.admin_url('admin.php').'?page=ulp-add-campaign&id='.$row['id'].'" title="'.__('Edit campaign details', 'ulp').'"><img src="'.plugins_url('/images/edit.png', __FILE__).'" alt="'.__('Edit campaign details', 'ulp').'" border="0"></a>
						<a class="thickbox" href="'.admin_url('admin.php').'?action=ulp-campaigns-stats&id='.$row['id'].'&ac='.$this->random_string().'" title="'.__('Statistics', 'ulp').': '.esc_html($row['title']).'"><img src="'.plugins_url('/images/chart.png', __FILE__).'" alt="'.__('Show campaign statistics', 'ulp').'" border="0"></a>
						'.($row['blocked'] == 1 ? '<a href="'.admin_url('admin.php').'?action=ulp-campaigns-unblock&id='.$row['id'].'&ac='.$this->random_string().'" title="'.__('Unblock campaign', 'ulp').'"><img src="'.plugins_url('/images/unblock.png', __FILE__).'" alt="'.__('Unblock campaign', 'ulp').'" border="0"></a>' : '<a href="'.admin_url('admin.php').'?action=ulp-campaigns-block&id='.$row['id'].'&ac='.$this->random_string().'" title="'.__('Block campaign', 'ulp').'"><img src="'.plugins_url('/images/block.png', __FILE__).'" alt="'.__('Block campaign', 'ulp').'" border="0"></a>').'
						<a href="'.admin_url('admin.php').'?action=ulp-campaigns-drop-counters&id='.$row['id'].'&ac='.$this->random_string().'" title="'.__('Drop counters', 'ulp').'" onclick="return ulp_submitOperation();"><img src="'.plugins_url('/images/clear.png', __FILE__).'" alt="'.__('Drop counters', 'ulp').'" border="0"></a>
						<a href="'.admin_url('admin.php').'?action=ulp-campaigns-delete&id='.$row['id'].'&ac='.$this->random_string().'" title="'.__('Delete campaign', 'ulp').'" onclick="return ulp_submitOperation();"><img src="'.plugins_url('/images/delete.png', __FILE__).'" alt="'.__('Delete campaign', 'ulp').'" border="0"></a>
					</td>
				</tr>';
			}
		} else {
			echo '
				<tr><td colspan="6" style="padding: 20px; text-align: center;">'.((strlen($search_query) > 0) ? __('No results found for', 'ulp').' "<strong>'.htmlspecialchars($search_query, ENT_QUOTES).'</strong>"' : __('List is empty.', 'ulp')).'</td></tr>';
		}
		echo '
				</table>
				<div class="ulp_buttons">
					<a class="button" href="'.admin_url('admin.php').'?page=ulp-add-campaign">'.__('Create New Campaign', 'ulp').'</a>
				</div>
				<div class="ulp_pageswitcher">'.$switcher.'</div>
				<div class="ulp_legend">
					<strong>Legend:</strong>
					<p><img src="'.plugins_url('/images/edit.png', __FILE__).'" alt="'.__('Edit campaign details', 'ulp').'" border="0"> '.__('Edit campaign details', 'ulp').'</p>
					<p><img src="'.plugins_url('/images/chart.png', __FILE__).'" alt="'.__('Show campaign statistics', 'ulp').'" border="0"> '.__('Show campaign statistics', 'ulp').'</p>
					<p><img src="'.plugins_url('/images/block.png', __FILE__).'" alt="'.__('Block campaign', 'ulp').'" border="0"> '.__('Block campaign', 'ulp').'</p>
					<p><img src="'.plugins_url('/images/unblock.png', __FILE__).'" alt="'.__('Unblock campaign', 'ulp').'" border="0"> '.__('Unblock campaign', 'ulp').'</p>
					<p><img src="'.plugins_url('/images/clear.png', __FILE__).'" alt="'.__('Drop counters', 'ulp').'" border="0"> '.__('Drop counters', 'ulp').'</p>
					<p><img src="'.plugins_url('/images/delete.png', __FILE__).'" alt="'.__('Delete campaign', 'ulp').'" border="0"> '.__('Delete campaign', 'ulp').'</p>
				</div>
			</div>';
	}

	function admin_add_campaign() {
		global $wpdb;

		if (isset($_GET["id"]) && !empty($_GET["id"])) {
			$id = intval($_GET["id"]);
			$campaign_details = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."ulp_campaigns WHERE id = '".$id."' AND deleted = '0'", ARRAY_A);
		}
		
		$errors = true;
		if (!empty($this->error)) $message = "<div class='error'><p>".$this->error."</p></div>";
		else if (!empty($this->info)) $message = "<div class='updated'><p>".$this->info."</p></div>";
		else $message = '';
		
		echo '
		<div class="wrap ulp">
			<div id="icon-edit-pages" class="icon32"><br /></div><h2>'.(!empty($campaign_details) ? __('Layered Popups - Edit A/B Campaign', 'ulp') : __('Layered Popups - Create A/B Campaign', 'ulp')).'</h2>
			'.$message.'
			<form class="ulp-campaign-form" enctype="multipart/form-data" method="post" style="margin: 0px" action="'.admin_url('admin.php').'">
			<div class="ulp-options" style="width: 100%; position: relative;">
				<h3>'.__('Campaign Details', 'ulp').'</h3>
				<table class="ulp_useroptions">
					<tr>
						<th>'.__('Title', 'ulp').':</th>
						<td>
							<input type="text" name="ulp_title" value="'.(!empty($campaign_details['title']) ? esc_html($campaign_details['title']) : __('Default A/B Campaign', 'ulp')).'" class="widefat" placeholder="Enter the campaign title...">
							<br /><em>'.__('Enter the campaign title. It is used for your reference.', 'ulp').'</em>
						</td>
					</tr>
					<tr>
						<th>'.__('Popups', 'ulp').':</th>
						<td>';
		if (!empty($campaign_details)) $sql = "SELECT t1.*, t2.id AS item_id FROM ".$wpdb->prefix."ulp_popups t1 LEFT JOIN ".$wpdb->prefix."ulp_campaign_items t2 ON t2.popup_id = t1.id AND t2.deleted = '0' AND t2.campaign_id = '".$campaign_details['id']."' WHERE t1.deleted = '0' ORDER BY t1.title ASC";
		else $sql = "SELECT * FROM ".$wpdb->prefix."ulp_popups WHERE deleted = '0' ORDER BY created DESC";
		$rows = $wpdb->get_results($sql, ARRAY_A);
		if (sizeof($rows) > 0) {
			foreach ($rows as $row) {
				echo '
							<input type="checkbox" name="ulp_popup_'.$row['id'].'"'.(isset($row['item_id']) && intval($row['item_id']) > 0 ? ' checked="checked"' : '').'> '.esc_html($row['title']).($row['blocked'] == 1 ? ' <span class="ulp-badge ulp-badge-blocked">'.__('Blocked', 'ulp').'</span>' : '').'<br />';
			}
			echo '
							<em>'.__('Select popups that you would like to include into campaign.', 'ulp').'</em>';

		} else {
			echo '
							'.__('Create at least one popup to start A/B Campaign.', 'ulp');
		}
							
		echo '
						</td>
					</tr>
				</table>
				<hr>
				<div style="text-align: right; margin-bottom: 5px; margin-top: 20px;">
					<input type="hidden" name="action" value="ulp_save_campaign" />
					<input type="hidden" name="ulp_id" value="'.(!empty($campaign_details['title']) ? $campaign_details['id'] : '0').'" />
					<img class="ulp-loading" src="'.plugins_url('/images/loading.gif', __FILE__).'">
					<input type="submit" class="button-primary ulp-button" name="submit" value="'.__('Save Campaign Details', 'ulp').'" onclick="return ulp_save_campaign();">
				</div>
				<div class="ulp-message"></div>
				<div id="ulp-overlay"></div>
			</div>
			</form>';
	}

	function save_campaign() {
		global $wpdb;
		if (current_user_can('manage_options')) {
			if (isset($_POST['ulp_id'])) {
				$id = intval($_POST['ulp_id']);
				$campaign_details = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."ulp_campaigns WHERE id = '".$id."' AND deleted = '0'", ARRAY_A);
			} else unset($campaign_details);
			if (isset($_POST['ulp_title'])) $title = stripslashes(trim($_POST['ulp_title']));
			else $title = '';
			
			$errors = array();
			if (strlen($title) < 1) $errors[] = __('Campaign title is too short.', 'ulp');

			$checked = false;
			$popups = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."ulp_popups WHERE deleted = '0'", ARRAY_A);
			if (sizeof($popups) > 0) {
				foreach ($popups as $popup) {
					if (isset($_POST['ulp_popup_'.$popup['id']])) {
						$checked = true;
						break;
					}
				}
				if (!$checked) $errors[] = __('Select at least one popup for this campaign.', 'ulp');
			} else $errors[] = __('Create at least one popup.', 'ulp');
			
			if (!empty($errors)) {
				$return_object = array();
				$return_object['status'] = 'ERROR';
				$return_object['message'] = __('Attention! Please correct the errors below and try again.', 'ulp').'<ul><li>'.implode('</li><li>', $errors).'</li></ul>';
				echo json_encode($return_object);
				exit;
			}
			
			if (empty($campaign_details)) {
				$str_id = 'ab-'.$this->random_string(16);
				$sql = "INSERT INTO ".$wpdb->prefix."ulp_campaigns (
					title, str_id, details, created, blocked, deleted) VALUES (
					'".esc_sql($title)."',
					'".esc_sql($str_id)."',
					'', '".time()."', '0', '0')";
				$wpdb->query($sql);
				$campaign_id = $wpdb->insert_id;
				foreach ($popups as $popup) {
					if (isset($_POST['ulp_popup_'.$popup['id']])) {
						$sql = "INSERT INTO ".$wpdb->prefix."ulp_campaign_items (
							campaign_id, popup_id, impressions, clicks, created, deleted) VALUES (
							'".$campaign_id."',
							'".$popup['id']."',
							'0', '0', '".time()."', '0')";
						$wpdb->query($sql);
					}
				}
			} else {
				$wpdb->query("UPDATE ".$wpdb->prefix."ulp_campaigns SET title = '".esc_sql($title)."' WHERE id = '".$campaign_details['id']."'");
				$wpdb->query("UPDATE ".$wpdb->prefix."ulp_campaign_items SET deleted = '1' WHERE campaign_id = '".$campaign_details['id']."'");
				foreach ($popups as $popup) {
					if (isset($_POST['ulp_popup_'.$popup['id']])) {
						$item_details = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."ulp_campaign_items WHERE campaign_id = '".$campaign_details['id']."' AND popup_id = '".$popup['id']."'", ARRAY_A);
						if (!empty($item_details)) {
							$sql = "UPDATE ".$wpdb->prefix."ulp_campaign_items SET deleted = '0' WHERE id = '".$item_details['id']."'";
							$wpdb->query($sql);
						} else {
							$sql = "INSERT INTO ".$wpdb->prefix."ulp_campaign_items (
								campaign_id, popup_id, impressions, clicks, created, deleted) VALUES (
								'".$campaign_details['id']."',
								'".$popup['id']."',
								'0', '0', '".time()."', '0')";
							$wpdb->query($sql);
						}
					}
				}
			}
			setcookie("ulp_info", __('Campaign details successfully <strong>saved</strong>.', 'ulp'), time()+30, "/", ".".str_replace("www.", "", $_SERVER["SERVER_NAME"]));
			
			$return_object = array();
			$return_object['status'] = 'OK';
			$return_object['return_url'] = admin_url('admin.php').'?page=ulp-campaigns';
			echo json_encode($return_object);
			exit;
		}
	}

	function admin_subscribers() {
		global $wpdb;

		if (isset($_GET["s"])) $search_query = trim(stripslashes($_GET["s"]));
		else $search_query = "";
		
		$tmp = $wpdb->get_row("SELECT COUNT(*) AS total FROM ".$wpdb->prefix."ulp_subscribers WHERE deleted = '0'".((strlen($search_query) > 0) ? " AND (name LIKE '%".addslashes($search_query)."%' OR email LIKE '%".addslashes($search_query)."%')" : ""), ARRAY_A);
		$total = $tmp["total"];
		$totalpages = ceil($total/ULP_RECORDS_PER_PAGE);
		if ($totalpages == 0) $totalpages = 1;
		if (isset($_GET["p"])) $page = intval($_GET["p"]);
		else $page = 1;
		if ($page < 1 || $page > $totalpages) $page = 1;
		$switcher = $this->page_switcher(admin_url('admin.php').'?page=ulp-subscribers'.((strlen($search_query) > 0) ? '&s='.rawurlencode($search_query) : ''), $page, $totalpages);

		$sql = "SELECT t1.*, t2.title AS popup_title FROM ".$wpdb->prefix."ulp_subscribers t1 LEFT JOIN ".$wpdb->prefix."ulp_popups t2 ON t2.id = t1.popup_id WHERE t1.deleted = '0'".((strlen($search_query) > 0) ? " AND (t1.name LIKE '%".addslashes($search_query)."%' OR t1.email LIKE '%".addslashes($search_query)."%')" : "")." ORDER BY t1.created DESC LIMIT ".(($page-1)*ULP_RECORDS_PER_PAGE).", ".ULP_RECORDS_PER_PAGE;
		$rows = $wpdb->get_results($sql, ARRAY_A);
		if (!empty($this->error)) $message = "<div class='error'><p>".$this->error."</p></div>";
		else if (!empty($this->info)) $message = "<div class='updated'><p>".$this->info."</p></div>";
		else $message = '';

		echo '
			<div class="wrap admin_ulp_wrap">
				<div id="icon-users" class="icon32"><br /></div><h2>'.__('Layered Popups - Log', 'ulp').'</h2><br />
				'.$message.'
				<form action="'.admin_url('admin.php').'" method="get" style="margin-bottom: 10px;">
				<input type="hidden" name="page" value="ulp-subscribers" />
				'.__('Search', 'ulp').': <input type="text" name="s" value="'.htmlspecialchars($search_query, ENT_QUOTES).'">
				<input type="submit" class="button-secondary action" value="'.__('Search', 'ulp').'" />
				'.((strlen($search_query) > 0) ? '<input type="button" class="button-secondary action" value="'.__('Reset search results', 'ulp').'" onclick="window.location.href=\''.admin_url('admin.php').'?page=ulp-subscribers\';" />' : '').'
				</form>
				<div class="ulp_buttons"><a class="button" href="'.admin_url('admin.php').'?action=ulp-subscribers-csv&ac='.$this->random_string().'">'.__('CSV Export', 'ulp').'</a></div>
				<div class="ulp_pageswitcher">'.$switcher.'</div>
				<table class="ulp_records">
				<tr>
					<th>'.__('Name', 'ulp').'</th>
					<th>'.__('E-mail', 'ulp').'</th>
					<th>'.__('Popup', 'ulp').'</th>
					<th style="width: 120px;">'.__('Created', 'ulp').'</th>
					<th style="width: 50px;"></th>
				</tr>';
		if (sizeof($rows) > 0) {
			foreach ($rows as $row) {
				echo '
				<tr>
					<td>'.(empty($row['name']) ? '-' : esc_html($row['name'])).'</td>
					<td>'.esc_html($row['email']).'</td>
					<td>'.esc_html($row['popup_title']).'</td>
					<td>'.date("Y-m-d H:i", $row['created']).'</td>
					<td style="text-align: center;">
						<a class="thickbox" href="'.admin_url('admin.php').'?action=ulp-subscribers-details&id='.$row['id'].'&ac='.$this->random_string().'" title="'.__('View details', 'ulp').'"><img src="'.plugins_url('/images/message.png', __FILE__).'" alt="'.__('View details', 'ulp').'" border="0"></a>
						<a href="'.admin_url('admin.php').'?action=ulp-subscribers-delete&id='.$row['id'].'&ac='.$this->random_string().'" title="'.__('Delete record', 'ulp').'" onclick="return ulp_submitOperation();"><img src="'.plugins_url('/images/delete.png', __FILE__).'" alt="'.__('Delete record', 'ulp').'" border="0"></a>
					</td>
				</tr>';
			}
		} else {
			echo '
				<tr><td colspan="5" style="padding: 20px; text-align: center;">'.((strlen($search_query) > 0) ? __('No results found for', 'ulp').' "<strong>'.htmlspecialchars($search_query, ENT_QUOTES).'</strong>"' : __('List is empty.', 'ulp')).'</td></tr>';
		}
		echo '
				</table>
				<div class="ulp_buttons">
					<a class="button" href="'.admin_url('admin.php').'?action=ulp-subscribers-delete-all&ac='.$this->random_string().'" onclick="return ulp_submitOperation();">'.__('Delete All', 'ulp').'</a>
					<a class="button" href="'.admin_url('admin.php').'?action=ulp-subscribers-csv&ac='.$this->random_string().'">'.__('CSV Export', 'ulp').'</a>
				</div>
				<div class="ulp_pageswitcher">'.$switcher.'</div>
				<div class="ulp_legend">
				<strong>'.__('Legend:', 'ulp').'</strong>
					<p><img src="'.plugins_url('/images/message.png', __FILE__).'" alt="'.__('View details', 'ulp').'" border="0"> '.__('View details', 'ulp').'</p>
					<p><img src="'.plugins_url('/images/delete.png', __FILE__).'" alt="'.__('Delete record', 'ulp').'" border="0"> '.__('Delete record', 'ulp').'</p>
				</div>
			</div>';
	}
	
	function admin_request_handler() {
		global $wpdb, $wp_header_to_desc;
		$wp_header_to_desc[682] = __('Invalid Item Purchase Code!', 'ulp');
		$wp_header_to_desc[683] = __('Specified Item Purchase Code is already in use!', 'ulp');
		if (!empty($_GET['action'])) {
			switch($_GET['action']) {
				case 'ulp-copy':
					$id = intval($_GET["id"]);
					$popup_details = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."ulp_popups WHERE id = '".$id."' AND deleted = '0'", ARRAY_A);
					if (empty($popup_details)) {
						setcookie("ulp_error", __('<strong>Invalid</strong> service call.', 'ulp'), time()+30, "/", ".".str_replace("www.", "", $_SERVER["SERVER_NAME"]));
						header('Location: '.admin_url('admin.php').'?page=ulp');
						exit;
					}
					$str_id = $this->random_string(16);
					$sql = "INSERT INTO ".$wpdb->prefix."ulp_popups (str_id, title, width, height, options, created, blocked, deleted) 
						VALUES (
						'".$str_id."', 
						'".esc_sql($popup_details['title'])."', 
						'".intval($popup_details['width'])."', 
						'".intval($popup_details['height'])."', 
						'".esc_sql($popup_details['options'])."', 
						'".time()."', '0', '0')";
					$wpdb->query($sql);
					$popup_id = $wpdb->insert_id;
					$layers = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."ulp_layers WHERE popup_id = '".$popup_details['id']."' AND deleted = '0'", ARRAY_A);
					if (sizeof($layers) > 0) {
						foreach ($layers as $layer) {
							$sql = "INSERT INTO ".$wpdb->prefix."ulp_layers (
								popup_id, title, content, zindex, details, created, deleted) VALUES (
								'".$popup_id."',
								'".esc_sql($layer['title'])."',
								'".esc_sql($layer['content'])."',
								'".esc_sql($layer['zindex'])."',
								'".esc_sql($layer['details'])."',
								'".time()."', '0')";
							$wpdb->query($sql);
						}
					}
					setcookie("ulp_info", __('Popup successfully <strong>duplicated</strong>.', 'ulp'), time()+30, "/", ".".str_replace("www.", "", $_SERVER["SERVER_NAME"]));
					header('Location: '.admin_url('admin.php').'?page=ulp');
					exit;
					break;
				case 'ulp-delete':
					$id = intval($_GET["id"]);
					$popup_details = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."ulp_popups WHERE id = '".$id."' AND deleted = '0'", ARRAY_A);
					if (intval($popup_details["id"]) == 0) {
						setcookie("ulp_error", __('<strong>Invalid</strong> service call.', 'ulp'), time()+30, "/", ".".str_replace("www.", "", $_SERVER["SERVER_NAME"]));
						header('Location: '.admin_url('admin.php').'?page=ulp');
						exit;
					}
					$sql = "UPDATE ".$wpdb->prefix."ulp_popups SET deleted = '1' WHERE id = '".$id."'";
					if ($wpdb->query($sql) !== false) {
						setcookie("ulp_info", __('Popup successfully <strong>removed</strong>.', 'ulp'), time()+30, "/", ".".str_replace("www.", "", $_SERVER["SERVER_NAME"]));
						header('Location: '.admin_url('admin.php').'?page=ulp');
						exit;
					} else {
						setcookie("ulp_error", __('<strong>Invalid</strong> service call.', 'ulp'), time()+30, "/", ".".str_replace("www.", "", $_SERVER["SERVER_NAME"]));
						header('Location: '.admin_url('admin.php').'?page=ulp');
						exit;
					}
					exit;
					break;
				case 'ulp-drop-counters':
					$id = intval($_GET["id"]);
					$popup_details = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."ulp_popups WHERE id = '".$id."' AND deleted = '0'", ARRAY_A);
					if (intval($popup_details["id"]) == 0) {
						setcookie("ulp_error", __('<strong>Invalid</strong> service call.', 'ulp'), time()+30, "/", ".".str_replace("www.", "", $_SERVER["SERVER_NAME"]));
						header('Location: '.admin_url('admin.php').'?page=ulp');
						exit;
					}
					$sql = "UPDATE ".$wpdb->prefix."ulp_popups SET clicks = '0', impressions = '0' WHERE id = '".$id."'";
					if ($wpdb->query($sql) !== false) {
						setcookie("ulp_info", __('Popup counters successfully <strong>cleared</strong>.', 'ulp'), time()+30, "/", ".".str_replace("www.", "", $_SERVER["SERVER_NAME"]));
						header('Location: '.admin_url('admin.php').'?page=ulp');
						exit;
					} else {
						setcookie("ulp_error", __('<strong>Invalid</strong> service call.', 'ulp'), time()+30, "/", ".".str_replace("www.", "", $_SERVER["SERVER_NAME"]));
						header('Location: '.admin_url('admin.php').'?page=ulp');
						exit;
					}
					exit;
					break;
				case 'ulp-block':
					$id = intval($_GET["id"]);
					$popup_details = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."ulp_popups WHERE id = '".$id."' AND deleted = '0'", ARRAY_A);
					if (intval($popup_details["id"]) == 0) {
						setcookie("ulp_error", __('<strong>Invalid</strong> service call.', 'ulp'), time()+30, "/", ".".str_replace("www.", "", $_SERVER["SERVER_NAME"]));
						header('Location: '.admin_url('admin.php').'?page=ulp');
						exit;
					}
					$sql = "UPDATE ".$wpdb->prefix."ulp_popups SET blocked = '1' WHERE id = '".$id."'";
					if ($wpdb->query($sql) !== false) {
						setcookie("ulp_info", __('Popup successfully <strong>blocked</strong>.', 'ulp'), time()+30, "/", ".".str_replace("www.", "", $_SERVER["SERVER_NAME"]));
						header('Location: '.admin_url('admin.php').'?page=ulp');
						exit;
					} else {
						setcookie("ulp_error", __('<strong>Invalid</strong> service call.', 'ulp'), time()+30, "/", ".".str_replace("www.", "", $_SERVER["SERVER_NAME"]));
						header('Location: '.admin_url('admin.php').'?page=ulp');
						exit;
					}
					exit;
					break;
				case 'ulp-unblock':
					$id = intval($_GET["id"]);
					$popup_details = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."ulp_popups WHERE id = '".$id."' AND deleted = '0'", ARRAY_A);
					if (intval($popup_details["id"]) == 0) {
						setcookie("ulp_error", __('<strong>Invalid</strong> service call.', 'ulp'), time()+30, "/", ".".str_replace("www.", "", $_SERVER["SERVER_NAME"]));
						header('Location: '.admin_url('admin.php').'?page=ulp');
						exit;
					}
					$sql = "UPDATE ".$wpdb->prefix."ulp_popups SET blocked = '0' WHERE id = '".$id."'";
					if ($wpdb->query($sql) !== false) {
						setcookie("ulp_info", __('Popup successfully <strong>unblocked</strong>.', 'ulp'), time()+30, "/", ".".str_replace("www.", "", $_SERVER["SERVER_NAME"]));
						header('Location: '.admin_url('admin.php').'?page=ulp');
						exit;
					} else {
						setcookie("ulp_error", __('<strong>Invalid</strong> service call.', 'ulp'), time()+30, "/", ".".str_replace("www.", "", $_SERVER["SERVER_NAME"]));
						header('Location: '.admin_url('admin.php').'?page=ulp');
						exit;
					}
					exit;
					break;
				case 'ulp-campaigns-delete':
					$id = intval($_GET["id"]);
					$campaign_details = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."ulp_campaigns WHERE id = '".$id."' AND deleted = '0'", ARRAY_A);
					if (intval($campaign_details["id"]) == 0) {
						setcookie("ulp_error", __('<strong>Invalid</strong> service call.', 'ulp'), time()+30, "/", ".".str_replace("www.", "", $_SERVER["SERVER_NAME"]));
						header('Location: '.admin_url('admin.php').'?page=ulp-campaigns');
						exit;
					}
					$sql = "UPDATE ".$wpdb->prefix."ulp_campaigns SET deleted = '1' WHERE id = '".$id."'";
					if ($wpdb->query($sql) !== false) {
						setcookie("ulp_info", __('Campaign successfully <strong>removed</strong>.', 'ulp'), time()+30, "/", ".".str_replace("www.", "", $_SERVER["SERVER_NAME"]));
						header('Location: '.admin_url('admin.php').'?page=ulp-campaigns');
						exit;
					} else {
						setcookie("ulp_error", __('<strong>Invalid</strong> service call.', 'ulp'), time()+30, "/", ".".str_replace("www.", "", $_SERVER["SERVER_NAME"]));
						header('Location: '.admin_url('admin.php').'?page=ulp-campaigns');
						exit;
					}
					exit;
					break;
				case 'ulp-campaigns-drop-counters':
					$id = intval($_GET["id"]);
					$campaign_details = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."ulp_campaigns WHERE id = '".$id."' AND deleted = '0'", ARRAY_A);
					if (intval($campaign_details["id"]) == 0) {
						setcookie("ulp_error", __('<strong>Invalid</strong> service call.', 'ulp'), time()+30, "/", ".".str_replace("www.", "", $_SERVER["SERVER_NAME"]));
						header('Location: '.admin_url('admin.php').'?page=ulp-campaigns');
						exit;
					}
					$sql = "UPDATE ".$wpdb->prefix."ulp_campaign_items SET clicks = '0', impressions = '0' WHERE campaign_id = '".$id."'";
					if ($wpdb->query($sql) !== false) {
						setcookie("ulp_info", __('Campaign counters successfully <strong>cleared</strong>.', 'ulp'), time()+30, "/", ".".str_replace("www.", "", $_SERVER["SERVER_NAME"]));
						header('Location: '.admin_url('admin.php').'?page=ulp-campaigns');
						exit;
					} else {
						setcookie("ulp_error", __('<strong>Invalid</strong> service call.', 'ulp'), time()+30, "/", ".".str_replace("www.", "", $_SERVER["SERVER_NAME"]));
						header('Location: '.admin_url('admin.php').'?page=ulp-campaigns');
						exit;
					}
					exit;
					break;
				case 'ulp-campaigns-block':
					$id = intval($_GET["id"]);
					$campaign_details = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."ulp_campaigns WHERE id = '".$id."' AND deleted = '0'", ARRAY_A);
					if (intval($campaign_details["id"]) == 0) {
						setcookie("ulp_error", __('<strong>Invalid</strong> service call.', 'ulp'), time()+30, "/", ".".str_replace("www.", "", $_SERVER["SERVER_NAME"]));
						header('Location: '.admin_url('admin.php').'?page=ulp-campaigns');
						exit;
					}
					$sql = "UPDATE ".$wpdb->prefix."ulp_campaigns SET blocked = '1' WHERE id = '".$id."'";
					if ($wpdb->query($sql) !== false) {
						setcookie("ulp_info", __('Campaign successfully <strong>blocked</strong>.', 'ulp'), time()+30, "/", ".".str_replace("www.", "", $_SERVER["SERVER_NAME"]));
						header('Location: '.admin_url('admin.php').'?page=ulp-campaigns');
						exit;
					} else {
						setcookie("ulp_error", __('<strong>Invalid</strong> service call.', 'ulp'), time()+30, "/", ".".str_replace("www.", "", $_SERVER["SERVER_NAME"]));
						header('Location: '.admin_url('admin.php').'?page=ulp-campaigns');
						exit;
					}
					exit;
					break;
				case 'ulp-campaigns-unblock':
					$id = intval($_GET["id"]);
					$campaign_details = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."ulp_campaigns WHERE id = '".$id."' AND deleted = '0'", ARRAY_A);
					if (intval($campaign_details["id"]) == 0) {
						setcookie("ulp_error", __('<strong>Invalid</strong> service call.', 'ulp'), time()+30, "/", ".".str_replace("www.", "", $_SERVER["SERVER_NAME"]));
						header('Location: '.admin_url('admin.php').'?page=ulp-campaigns');
						exit;
					}
					$sql = "UPDATE ".$wpdb->prefix."ulp_campaigns SET blocked = '0' WHERE id = '".$id."'";
					if ($wpdb->query($sql) !== false) {
						setcookie("ulp_info", __('Campaign successfully <strong>unblocked</strong>.', 'ulp'), time()+30, "/", ".".str_replace("www.", "", $_SERVER["SERVER_NAME"]));
						header('Location: '.admin_url('admin.php').'?page=ulp-campaigns');
						exit;
					} else {
						setcookie("ulp_error", __('<strong>Invalid</strong> service call.', 'ulp'), time()+30, "/", ".".str_replace("www.", "", $_SERVER["SERVER_NAME"]));
						header('Location: '.admin_url('admin.php').'?page=ulp-campaigns');
						exit;
					}
					exit;
					break;
				case 'ulp-campaigns-stats':
					$id = intval($_GET["id"]);
					$campaign_details = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."ulp_campaigns WHERE id = '".$id."' AND deleted = '0'", ARRAY_A);
					if (!empty($campaign_details["id"])) {
						$sql = "SELECT t1.*, t2.title FROM ".$wpdb->prefix."ulp_campaign_items t1 JOIN ".$wpdb->prefix."ulp_popups t2 ON t2.id = t1.popup_id WHERE t2.deleted = '0' AND t1.campaign_id = '".$id."' AND t1.deleted = '0'";
						$rows = $wpdb->get_results($sql, ARRAY_A);
						if (sizeof($rows) > 0) {
							$max_impressions = 0;
							foreach ($rows as $row) {
								if ($row['impressions'] > $max_impressions) $max_impressions = $row['impressions'];
							}
							echo '
<html>
<head>
	<meta name="robots" content="noindex, nofollow, noarchive, nosnippet">
	<title>'.__('A/B campaign stats', 'ulp').'</title>
	<style>
	.popup-charts {margin-bottom: 10px;}
	.chart {border-radius: 2px; margin-bottom: 5px; padding: 5px 5px 5px 0px; display: inline-block; text-align: right; color: #FFF;}
	.chart-outer-label {padding: 5px 0px 5px 5px; display: inline-block; text-align: left; color: #333;}
	.impressions-chart {
		background: #848;
	}
	.clicks-chart {
		background: #488;
	}
	.ctr-chart {
		background: #884;
	}
	.legend-chart {
		display: inline-block;
		padding: 5px 20px;
		color: #FFF;
		border-radius: 2px;
	}
	hr {margin-top: 20px;}
	</style>
</head>
<body>';
							foreach ($rows as $row) {
								$impressions = $max_impressions > 0 ? intval(0+$row['impressions']*100/$max_impressions) : 0;
								$clicks = $max_impressions > 0 ? intval(0+$row['clicks']*100/$max_impressions) : 0;
								$ctr = $row['impressions'] > 0 ? intval(0+$row['clicks']*100/$row['impressions']) : 0;
								echo '
	<div class="popup-charts">
		<strong>'.esc_html($row['title']).'</strong><br />
		<div class="chart impressions-chart" style="width: '.$impressions.'%;">'.($impressions > 10 ? $row['impressions'] : '&nbsp').'</div>'.($impressions > 10 ? '' : '<div class="chart-outer-label">'.$row['impressions'].'</div>').'<br />
		<div class="chart clicks-chart" style="width: '.$clicks.'%;">'.($clicks > 10 ? $row['clicks'] : '&nbsp').'</div>'.($clicks > 10 ? '' : '<div class="chart-outer-label">'.$row['clicks'].'</div>').'<br />
		<div class="chart ctr-chart" style="width: '.$ctr.'%;">'.($ctr > 10 ? ($row['impressions'] > 0 ? number_format($row['clicks']*100/$row['impressions'], 2, ".", "").'%' : '0%') : '&nbsp').'</div>'.($ctr > 10 ? '' : '<div class="chart-outer-label">'.($row['impressions'] > 0 ? number_format($row['clicks']*100/$row['impressions'], 2, ".", "").'%' : '0%').'</div>').'
	</div>';
							}
							echo '
	<hr>
	<div class="popup-charts">
		<strong>Legend:</strong><br />
		<div class="legend-chart impressions-chart">'.__('Impressions', 'ulp').'</div>
		<div class="legend-chart clicks-chart">'.__('Submits', 'ulp').'</div>
		<div class="legend-chart ctr-chart">'.__('CTR', 'ulp').'</div>
	</div>
							
</body>
</html>';
						} else echo '<div style="text-align: center; margin: 20px 0px;">'.__('No data found!', 'ulp').'</div>';
					} else echo '<div style="text-align: center; margin: 20px 0px;">'.__('No data found!', 'ulp').'</div>';
					die();
					break;
				case 'ulp-subscribers-details':
					$id = intval($_GET["id"]);
					$subscriber_details = $wpdb->get_row("SELECT t1.*, t2.title AS popup_title FROM ".$wpdb->prefix."ulp_subscribers t1 LEFT JOIN ".$wpdb->prefix."ulp_popups t2 ON t2.id = t1.popup_id WHERE t1.id = '".$id."' AND t1.deleted = '0'", ARRAY_A);
					echo '
<html>
<head>
	<meta name="robots" content="noindex, nofollow, noarchive, nosnippet">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>'.__('Details', 'ulp').'</title>
	<style>table {border-collapse: collapse;} td {vertical-align: top; padding: 4px 7px;} tr:nth-of-type(even) {background-color: #F8F8F8;}</style>
</head>
<body>';
					if ($subscriber_details) {
						echo '
	<table style="width: 100%;">
		<tr>
			<td style="width: 120px;"><strong>'.__('E-mail', 'ulp').':</strong></td>
			<td>'.esc_html($subscriber_details['email']).'</td>
		</tr>
		<tr>
			<td><strong>'.__('Name', 'ulp').':</strong></td>
			<td>'.(empty($subscriber_details['name']) ? '-' : esc_html($subscriber_details['name'])).'</td>
		</tr>
		<tr>
			<td><strong>'.__('Phone #', 'ulp').':</strong></td>
			<td>'.(empty($subscriber_details['phone']) ? '-' : esc_html($subscriber_details['phone'])).'</td>
		</tr>
		<tr>
			<td><strong>'.__('Message', 'ulp').':</strong></td>
			<td>'.(empty($subscriber_details['message']) ? '-' : str_replace(array("\r", "\n"), array('', '<br />'), esc_html($subscriber_details['message']))).'</td>
		</tr>';
						if (array_key_exists('custom_fields', $subscriber_details) && !empty($subscriber_details['custom_fields'])) {
							$custom_fields = unserialize($subscriber_details['custom_fields']);
							if ($custom_fields && is_array($custom_fields)) {
								foreach ($custom_fields as $field) {
									echo '
		<tr>
			<td><strong>'.esc_html($field['name']).':</strong></td>
			<td>'.(empty($field['value']) ? '-' : str_replace(array("\r", "\n"), array('', '<br />'), esc_html($field['value']))).'</td>
		</tr>';
								}
							}
						}
						echo '
	</table>';
					} else {
						echo '<div style="text-align: center; margin: 20px 0px;">'.__('No data found!', 'ulp').'</div>';
					}
					echo '
</body>
</html>';
					exit;
					break;
				case 'ulp-subscribers-delete':
					$id = intval($_GET["id"]);
					$subscriber_details = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."ulp_subscribers WHERE id = '".$id."' AND deleted = '0'", ARRAY_A);
					if (intval($subscriber_details["id"]) == 0) {
						setcookie("ulp_error", __('<strong>Invalid</strong> service call.', 'ulp'), time()+30, "/", ".".str_replace("www.", "", $_SERVER["SERVER_NAME"]));
						header('Location: '.admin_url('admin.php').'?page=ulp-subscribers');
						exit;
					}
					$sql = "UPDATE ".$wpdb->prefix."ulp_subscribers SET deleted = '1' WHERE id = '".$id."'";
					if ($wpdb->query($sql) !== false) {
						setcookie("ulp_info", __('Record successfully <strong>removed</strong>.', 'ulp'), time()+30, "/", ".".str_replace("www.", "", $_SERVER["SERVER_NAME"]));
						header('Location: '.admin_url('admin.php').'?page=ulp-subscribers');
						exit;
					} else {
						setcookie("ulp_error", __('<strong>Invalid</strong> service call.', 'ulp'), time()+30, "/", ".".str_replace("www.", "", $_SERVER["SERVER_NAME"]));
						header('Location: '.admin_url('admin.php').'?page=ulp-subscribers');
						exit;
					}
					break;
				case 'ulp-subscribers-csv':
					$rows = $wpdb->get_results("SELECT t1.*, t2.title AS popup_title FROM ".$wpdb->prefix."ulp_subscribers t1 LEFT JOIN ".$wpdb->prefix."ulp_popups t2 ON t2.id = t1.popup_id WHERE t1.deleted = '0' ORDER BY t1.created DESC", ARRAY_A);
					if (sizeof($rows) > 0) {
						if (strstr($_SERVER["HTTP_USER_AGENT"],"MSIE")) {
							header("Pragma: public");
							header("Expires: 0");
							header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
							header("Content-type: application-download");
							header("Content-Disposition: attachment; filename=\"emails.csv\"");
							header("Content-Transfer-Encoding: binary");
						} else {
							header("Content-type: application-download");
							header("Content-Disposition: attachment; filename=\"emails.csv\"");
						}
						$separator = $this->options['csv_separator'];
						if ($separator == 'tab') $separator = "\t";
						echo '"Name"'.$separator.'"E-Mail"'.$separator.'"Phone"'.$separator.'"Popup"'.$separator.'"Created"'."\r\n";
						foreach ($rows as $row) {
							echo '"'.str_replace('"', "'", $row["name"]).'"'.$separator.'"'.str_replace('"', "'", $row["email"]).'"'.$separator.'"'.str_replace('"', "'", $row["phone"]).'"'.$separator.'"'.str_replace('"', "'", $row["popup_title"]).'"'.$separator.'"'.date("Y-m-d H:i:s", $row["created"]).'"'."\r\n";
						}
						exit;
		            }
		            header('Location: '.admin_url('admin.php').'?page=ulp-subscribers');
					exit;
					break;
				case 'ulp-subscribers-delete-all':
					$sql = "UPDATE ".$wpdb->prefix."ulp_subscribers SET deleted = '1'";
					if ($wpdb->query($sql) !== false) {
						setcookie("ulp_info", __('Records successfully <strong>removed</strong>.', 'ulp'), time()+30, "/", ".".str_replace("www.", "", $_SERVER["SERVER_NAME"]));
					} else {
						setcookie("ulp_error", __('<strong>Invalid</strong> service call.', 'ulp'), time()+30, "/", ".".str_replace("www.", "", $_SERVER["SERVER_NAME"]));
					}
					header('Location: '.admin_url('admin.php').'?page=ulp-subscribers');
					exit;
					break;
				case 'ulp-export':
					error_reporting(0);
					$id = intval($_GET["id"]);
					$popup_details = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."ulp_popups WHERE id = '".$id."' AND deleted = '0'", ARRAY_A);
					$popup_full = array();
					if (!empty($popup_details)) {
						$popup_full = array();
						$popup_full['popup'] = $popup_details;
						$popup_full['layers'] = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."ulp_layers WHERE popup_id = '".$id."' AND deleted = '0'", ARRAY_A);
						foreach ($popup_full['layers'] as $idx => $layer) {
							$layer_options = unserialize($layer['details']);
							if (is_array($layer_options)) $layer_options = array_merge($this->default_layer_options, $layer_options);
							else $layer_options = $this->default_layer_options;
							$layer_options = $this->filter_lp_reverse($layer_options);
							$popup_full['layers'][$idx]['content'] = str_replace(array('http://datastorage.pw/images', plugins_url('/images/default', __FILE__)), array('ULP-DEMO-IMAGES-URL', 'ULP-DEMO-IMAGES-URL'), $popup_full['layers'][$idx]['content']);
							$popup_full['layers'][$idx]['details'] = serialize($layer_options);
						}
						$popup_data = serialize($popup_full);
						$output = ULP_EXPORT_VERSION.PHP_EOL.md5($popup_data).PHP_EOL.base64_encode($popup_data);
						if (strstr($_SERVER["HTTP_USER_AGENT"],"MSIE")) {
							header("Pragma: public");
							header("Expires: 0");
							header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
							header("Content-type: application-download");
							header('Content-Disposition: attachment; filename="'.$popup_details['str_id'].'.txt"');
							header("Content-Transfer-Encoding: binary");
						} else {
							header("Content-type: application-download");
							header('Content-Disposition: attachment; filename="'.$popup_details['str_id'].'.txt"');
						}
						echo $output;
						flush();
						ob_flush();
						exit;
		            }
		            header('Location: '.admin_url('admin.php').'?page=ulp');
					exit;
					break;
				case 'ulp-export-full':
					if (!class_exists('ZipArchive') || !class_exists('DOMDocument')) {
						setcookie("ulp_error", __('This operation <strong>requires</strong> <em>ZipArchive</em> and <em>DOMDocument</em> classes. Some of them <strong>not found</strong>.', 'ulp'), time()+30, "/", ".".str_replace("www.", "", $_SERVER["SERVER_NAME"]));
						header('Location: '.admin_url('admin.php').'?page=ulp');
						exit;
					}
					$upload_dir = wp_upload_dir();
					if (!file_exists($upload_dir["basedir"].'/'.ULP_UPLOADS_DIR.'/temp')) {
						setcookie("ulp_error", __('Please <strong>re-activate</strong> the plugin and try again.', 'ulp'), time()+30, "/", ".".str_replace("www.", "", $_SERVER["SERVER_NAME"]));
						header('Location: '.admin_url('admin.php').'?page=ulp');
						exit;
					}
					$id = intval($_GET["id"]);
					$popup_details = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."ulp_popups WHERE id = '".$id."' AND deleted = '0'", ARRAY_A);
					$popup_full = array();
					if (!empty($popup_details)) {
						require_once(ABSPATH.'wp-admin/includes/file.php');
						$zip = new ZipArchive();
						$zip_filename = $upload_dir["basedir"].'/'.ULP_UPLOADS_DIR.'/temp/'.$this->random_string(16).'.zip';
						if ($zip->open($zip_filename, ZipArchive::CREATE) !== true) {
							setcookie("ulp_error", __('<strong>Can not create</strong> zip-archive. Make sure that the following folder has write permission:', 'ulp').' '.$upload_dir["basedir"].'/'.ULP_UPLOADS_DIR.'/temp', time()+30, "/", ".".str_replace("www.", "", $_SERVER["SERVER_NAME"]));
							header('Location: '.admin_url('admin.php').'?page=ulp');
							exit;
						}
						$popup_full = array();
						$images_processed = array();
						$popup_options = unserialize($popup_details['options']);
						
						$export_options = apply_filters('ulp_export_full_popup_options', $this->default_popup_options);
						
						if (is_array($popup_options)) $popup_options = array_intersect_key($popup_options, $export_options);
						else $popup_options = $this->default_popup_options;
						$popup_options['redirect_url'] = '';
						$popup_details['options'] = serialize($popup_options);
						$popup_full['popup'] = $popup_details;
						$popup_full['layers'] = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."ulp_layers WHERE popup_id = '".$id."' AND deleted = '0'", ARRAY_A);
						foreach ($popup_full['layers'] as $idx => $layer) {
							$layer_options = unserialize($layer['details']);
							if (is_array($layer_options)) $layer_options = array_merge($this->default_layer_options, $layer_options);
							else $layer_options = $this->default_layer_options;
							$layer_options = $this->filter_lp($layer_options);
							
							if (!empty($layer_options['background_image']) && preg_match('~^((http(s)?://)|(//))[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$~i', $layer_options['background_image'])) {
								$filename = $this->add_to_archive($zip, $layer_options['background_image'], $images_processed);
								if ($filename !== false) {
									$layer_options['background_image'] = 'ULP-UPLOADS-DIR/'.$filename;
								}
							}
							
							if (function_exists('libxml_use_internal_errors')) libxml_use_internal_errors(true);
							if (!empty($layer_options['content'])) {
								$dom = new DOMDocument();
								$dom->loadHTML($layer_options['content']);
								if (!$dom) {
									$zip->close();
									unlink($zip_filename);
									setcookie("ulp_error", __('<strong>Can not parse</strong> layer HTML-content. Make sure it is valid.', 'ulp'), time()+30, "/", ".".str_replace("www.", "", $_SERVER["SERVER_NAME"]));
									header('Location: '.admin_url('admin.php').'?page=ulp');
									exit;
								}
								$imgs = $dom->getElementsByTagName('img');
								foreach ($imgs as $img) {
									$img_string = $img->getAttribute('src');
									if (!empty($img_string) && preg_match('~^((http(s)?://)|(//))[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$~i', $img_string)) {
										$filename = $this->add_to_archive($zip, $img_string, $images_processed);
										if ($filename !== false) {
											$layer_options['content'] = str_replace($img_string, 'ULP-UPLOADS-DIR/'.$filename, $layer_options['content']);
										}
									}
								}								
							}
							$popup_full['layers'][$idx]['content'] = $layer_options['content'];
							$popup_full['layers'][$idx]['details'] = serialize($layer_options);
						}
						$popup_data = serialize($popup_full);
						$zip->addFromString('popup.txt', ULP_EXPORT_VERSION.PHP_EOL.md5($popup_data).PHP_EOL.base64_encode($popup_data));
						$zip->addFromString('index.html', 'Get your copy of Layered Popups: <a href="http://codecanyon.net/item/layered-popups-for-wordpress/5978263">WordPress Plugin</a>, <a href="http://codecanyon.net/item/layered-popups/6027291">Standalone Script</a>.');
						$zip->close();
						error_reporting(0);
						$length = filesize($zip_filename);
						if (strstr($_SERVER["HTTP_USER_AGENT"], "MSIE")) {
							header("Pragma: public");
							header("Expires: 0");
							header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
							header("Content-Type: application-download");
							header("Content-Length: ".$length);
							header('Content-Disposition: attachment; filename="'.$popup_details['str_id'].'.zip"');
							header("Content-Transfer-Encoding: binary");
						} else {
							header("Content-Type: application-download");
							header("Content-Length: ".$length);
							header('Content-Disposition: attachment; filename="'.$popup_details['str_id'].'.zip"');
						}
						$handle_read = fopen($zip_filename, "rb");
						while (!feof($handle_read) && $length > 0) {
							$content = fread($handle_read, 1024);
							echo substr($content, 0, min($length, 1024));
							flush();
							$length = $length - strlen($content);
							if ($length < 0) $length = 0;
						}
						fclose($handle_read);
						unlink($zip_filename);
						foreach ($images_processed as $value) {
							if (!empty($value['temp']) && file_exists($value['temp']) && is_file($value['temp'])) unlink($value['temp']);
						}
						exit;
		            }
		            header('Location: '.admin_url('admin.php').'?page=ulp');
					exit;
					break;
				case 'ulp-import':
					if (is_uploaded_file($_FILES["ulp-file"]["tmp_name"])) {
						$dot_pos = strrpos($_FILES["ulp-file"]["name"], '.');
						if ($dot_pos === false) {
							setcookie("ulp_error", __('<strong>Invalid</strong> popup file.', 'ulp'), time()+30, "/", ".".str_replace("www.", "", $_SERVER["SERVER_NAME"]));
							header('Location: '.admin_url('admin.php').'?page=ulp');
							exit;
						}
						$ext = strtolower(substr($_FILES["ulp-file"]["name"], $dot_pos));
						if ($ext == '.txt') {
							$lines = file($_FILES["ulp-file"]["tmp_name"]);
							if (sizeof($lines) != 3) {
								setcookie("ulp_error", __('<strong>Invalid</strong> popup file.', 'ulp'), time()+30, "/", ".".str_replace("www.", "", $_SERVER["SERVER_NAME"]));
								header('Location: '.admin_url('admin.php').'?page=ulp');
								exit;
							}
							$version = intval(trim($lines[0]));
							if ($version > intval(ULP_EXPORT_VERSION)) {
								setcookie("ulp_error", __('Popup file version <strong>is not supported</strong>.', 'ulp'), time()+30, "/", ".".str_replace("www.", "", $_SERVER["SERVER_NAME"]));
								header('Location: '.admin_url('admin.php').'?page=ulp');
								exit;
							}
							$md5_hash = trim($lines[1]);
							$popup_data = trim($lines[2]);
							$popup_data = base64_decode($popup_data);
							if (!$popup_data || md5($popup_data) != $md5_hash) {
								setcookie("ulp_error", __('Popup file <strong>corrupted</strong>.', 'ulp'), time()+30, "/", ".".str_replace("www.", "", $_SERVER["SERVER_NAME"]));
								header('Location: '.admin_url('admin.php').'?page=ulp');
								exit;
							}
							$popup = unserialize($popup_data);
							$popup_details = $popup['popup'];
							$str_id = $this->random_string(16);
							$sql = "INSERT INTO ".$wpdb->prefix."ulp_popups (str_id, title, width, height, options, created, blocked, deleted) 
								VALUES (
								'".$str_id."', 
								'".esc_sql($popup_details['title'])."', 
								'".intval($popup_details['width'])."', 
								'".intval($popup_details['height'])."', 
								'".esc_sql($popup_details['options'])."', 
								'".time()."', '1', '0')";
							$wpdb->query($sql);
							$popup_id = $wpdb->insert_id;
							$layers = $popup['layers'];
							if (sizeof($layers) > 0) {
								foreach ($layers as $layer) {
									$sql = "INSERT INTO ".$wpdb->prefix."ulp_layers (
										popup_id, title, content, zindex, details, created, deleted) VALUES (
										'".$popup_id."',
										'".esc_sql($layer['title'])."',
										'".esc_sql($layer['content'])."',
										'".esc_sql($layer['zindex'])."',
										'".esc_sql($layer['details'])."',
										'".time()."', '0')";
									$wpdb->query($sql);
								}
							}
							setcookie("ulp_info", __('The new popup successfully <strong>imported</strong> and marked as <strong>blocked</strong>.', 'ulp'), time()+30, "/", ".".str_replace("www.", "", $_SERVER["SERVER_NAME"]));
							header('Location: '.admin_url('admin.php').'?page=ulp');
							exit;
						} else if ($ext == '.zip') {
							$result = $this->import_zip($_FILES["ulp-file"]["tmp_name"]);
							if (is_wp_error($result)) {
								setcookie("ulp_error", $result->get_error_message(), time()+30, "/", ".".str_replace("www.", "", $_SERVER["SERVER_NAME"]));
								header('Location: '.admin_url('admin.php').'?page=ulp');
								exit;
							}
							setcookie("ulp_info", __('The new popup successfully <strong>imported</strong> and marked as <strong>blocked</strong>.', 'ulp'), time()+30, "/", ".".str_replace("www.", "", $_SERVER["SERVER_NAME"]));
							header('Location: '.admin_url('admin.php').'?page=ulp');
							exit;
						} else {
							setcookie("ulp_error", __('<strong>Invalid</strong> popup file.', 'ulp'), time()+30, "/", ".".str_replace("www.", "", $_SERVER["SERVER_NAME"]));
							header('Location: '.admin_url('admin.php').'?page=ulp');
							exit;
						}
					}
					setcookie("ulp_error", __('Popup file <strong>not uploaded</strong>.', 'ulp'), time()+30, "/", ".".str_replace("www.", "", $_SERVER["SERVER_NAME"]));
					header('Location: '.admin_url('admin.php').'?page=ulp');
					exit;
					break;
				default:
					break;
			}
		}
	}

	function load_popup() {
		$str_id = '';
		if (isset($_REQUEST['ulp-popup'])) {
			$str_id = preg_replace('/[^a-zA-Z0-9-]/', '', $_REQUEST['ulp-popup']);
		}
		$this->get_popups($str_id, false);
		$return_data = array();
		$return_data['status'] = 'OK';
		$return_data['html'] = $this->front_header.$this->front_footer;
		echo json_encode($return_data);
		exit;
	}
	
	function front_init() {
		global $wpdb, $post, $current_user;
		
		$posts_page = false;
		$posts_page_id = get_option('page_for_posts');
		if (is_home() && !empty($posts_page_id)) $posts_page = true;
		
		$woo_page = false;
		$woo_page_id = 0;
		if (function_exists('is_product')) {
			if (is_product()) {
				$woo_page_id = $post->ID;
				$woo_page = true;
			}
		}
		if (function_exists('is_shop')) {
			if (is_shop() && function_exists('woocommerce_get_page_id')) {
				$woo_page_id = woocommerce_get_page_id('shop');
				$woo_page = true;
			}
		}
		
		if ($this->options['no_preload'] != 'on') {
			$this->get_popups();
		}
		
		$common_roles = array();
		if ($current_user) $common_roles = array_intersect($current_user->roles, $this->options['disable_roles']);

		$this->front_header .= '
		<script>
			var ulp_cookie_value = "'.$this->options['cookie_value'].'";
			var ulp_recaptcha_enable = "'.$this->options['recaptcha_enable'].'";';
		$this->front_header .= $this->options['recaptcha_enable'] != 'on' ? '' : '
			var ulp_recaptcha_public_key = "'.esc_html($this->options['recaptcha_public_key']).'";';
		if (is_singular() || $posts_page || $woo_page) {
			if ($posts_page) $meta = $this->get_meta($posts_page_id);
			else if ($woo_page) $meta = $this->get_meta($woo_page_id);
			else $meta = $this->get_meta($post->ID);
			
			$onload_popup = ($meta['onload_popup'] == 'default' ? $this->options['onload_popup'] : $meta['onload_popup']);
			$onload_popup_mobile = ($meta['onload_popup_mobile'] == 'default' ? $this->options['onload_popup_mobile'] : $meta['onload_popup_mobile']);
			if ($onload_popup_mobile != 'same' && (!empty($onload_popup) || !empty($onload_popup_mobile))) $onload_popup .= '*'.$onload_popup_mobile;

			$onscroll_popup = ($meta['onscroll_popup'] == 'default' ? $this->options['onscroll_popup'] : $meta['onscroll_popup']);
			$onscroll_popup_mobile = ($meta['onscroll_popup_mobile'] == 'default' ? $this->options['onscroll_popup_mobile'] : $meta['onscroll_popup_mobile']);
			if ($onscroll_popup_mobile != 'same' && (!empty($onscroll_popup) || !empty($onscroll_popup_mobile))) $onscroll_popup .= '*'.$onscroll_popup_mobile;

			$onexit_popup = ($meta['onexit_popup'] == 'default' ? $this->options['onexit_popup'] : $meta['onexit_popup']);
			$onexit_popup_mobile = ($meta['onexit_popup_mobile'] == 'default' ? $this->options['onexit_popup_mobile'] : $meta['onexit_popup_mobile']);
			if ($onexit_popup_mobile != 'same' && (!empty($onexit_popup) || !empty($onexit_popup_mobile))) $onexit_popup .= '*'.$onexit_popup_mobile;

			$onidle_popup = ($meta['onidle_popup'] == 'default' ? $this->options['onidle_popup'] : $meta['onidle_popup']);
			$onidle_popup_mobile = ($meta['onidle_popup_mobile'] == 'default' ? $this->options['onidle_popup_mobile'] : $meta['onidle_popup_mobile']);
			if ($onidle_popup_mobile != 'same' && (!empty($onidle_popup) || !empty($onidle_popup_mobile))) $onidle_popup .= '*'.$onidle_popup_mobile;
			
			if (!empty($common_roles)) {
				$this->options['onload_mode'] = 'none';
				$this->options['onexit_mode'] = 'none';
				$this->options['onscroll_mode'] = 'none';
				$this->options['onidle_mode'] = 'none';
				$meta['onload_mode'] = 'none';
				$meta['onexit_mode'] = 'none';
				$meta['onscroll_mode'] = 'none';
				$meta['onidle_mode'] = 'none';
			}
			
			$this->front_header .= '
			var ulp_onload_mode = "'.($meta['onload_mode'] == 'default' ? $this->options['onload_mode'] : $meta['onload_mode']).'";
			var ulp_onload_period = "'.($meta['onload_mode'] == 'default' ? intval($this->options['onload_period']) : intval($meta['onload_period'])).'";
			var ulp_onload_popup = "'.$onload_popup.'";
			var ulp_onload_delay = "'.($meta['onload_popup'] == 'default' ? intval($this->options['onload_delay']) : intval($meta['onload_delay'])).'";
			var ulp_onload_close_delay = "'.($meta['onload_popup'] == 'default' ? intval($this->options['onload_close_delay']) : intval($meta['onload_close_delay'])).'";
			var ulp_onexit_mode = "'.($meta['onexit_mode'] == 'default' ? $this->options['onexit_mode'] : $meta['onexit_mode']).'";
			var ulp_onexit_period = "'.($meta['onexit_mode'] == 'default' ? intval($this->options['onexit_period']) : intval($meta['onexit_period'])).'";
			var ulp_onexit_popup = "'.$onexit_popup.'";
			var ulp_onscroll_mode = "'.($meta['onscroll_mode'] == 'default' ? $this->options['onscroll_mode'] : $meta['onscroll_mode']).'";
			var ulp_onscroll_period = "'.($meta['onscroll_mode'] == 'default' ? $this->options['onscroll_period'] : $meta['onscroll_period']).'";
			var ulp_onscroll_popup = "'.$onscroll_popup.'";
			var ulp_onscroll_offset = "'.($meta['onscroll_popup'] == 'default' ? intval($this->options['onscroll_offset']) : intval($meta['onscroll_offset'])).'";
			var ulp_onidle_mode = "'.($meta['onidle_mode'] == 'default' ? $this->options['onidle_mode'] : $meta['onidle_mode']).'";
			var ulp_onidle_period = "'.($meta['onidle_mode'] == 'default' ? $this->options['onidle_period'] : $meta['onidle_period']).'";
			var ulp_onidle_popup = "'.$onidle_popup.'";
			var ulp_onidle_delay = "'.($meta['onidle_popup'] == 'default' ? intval($this->options['onidle_delay']) : intval($meta['onidle_delay'])).'";';
		} else {
			$onload_popup = $this->options['onload_popup'];
			if ($this->options['onload_popup_mobile'] != 'same' && (!empty($onload_popup) || !empty($this->options['onload_popup_mobile']))) $onload_popup .= '*'.$this->options['onload_popup_mobile'];

			$onscroll_popup = $this->options['onscroll_popup'];
			if ($this->options['onscroll_popup_mobile'] != 'same' && (!empty($onscroll_popup) || !empty($this->options['onscroll_popup_mobile']))) $onscroll_popup .= '*'.$this->options['onscroll_popup_mobile'];

			$onexit_popup = $this->options['onexit_popup'];
			if ($this->options['onexit_popup_mobile'] != 'same' && (!empty($onexit_popup) || !empty($this->options['onexit_popup_mobile']))) $onexit_popup .= '*'.$this->options['onexit_popup_mobile'];

			$onidle_popup = $this->options['onidle_popup'];
			if ($this->options['onidle_popup_mobile'] != 'same' && (!empty($onidle_popup) || !empty($this->options['onidle_popup_mobile']))) $onidle_popup .= '*'.$this->options['onidle_popup_mobile'];

			if (!empty($common_roles)) {
				$this->options['onload_mode'] = 'none';
				$this->options['onexit_mode'] = 'none';
				$this->options['onscroll_mode'] = 'none';
				$this->options['onidle_mode'] = 'none';
			}
			
			$this->front_header .= '
			var ulp_onload_mode = "'.$this->options['onload_mode'].'";
			var ulp_onload_period = "'.intval($this->options['onload_period']).'";
			var ulp_onload_popup = "'.$onload_popup.'";
			var ulp_onload_delay = "'.intval($this->options['onload_delay']).'";
			var ulp_onload_close_delay = "'.intval($this->options['onload_close_delay']).'";
			var ulp_onexit_mode = "'.$this->options['onexit_mode'].'";
			var ulp_onexit_period = "'.intval($this->options['onexit_period']).'";
			var ulp_onexit_popup = "'.$onexit_popup.'";
			var ulp_onscroll_mode = "'.$this->options['onscroll_mode'].'";
			var ulp_onscroll_period = "'.intval($this->options['onscroll_period']).'";
			var ulp_onscroll_popup = "'.$onscroll_popup.'";
			var ulp_onscroll_offset = "'.intval($this->options['onscroll_offset']).'";
			var ulp_onidle_mode = "'.$this->options['onidle_mode'].'";
			var ulp_onidle_period = "'.intval($this->options['onidle_period']).'";
			var ulp_onidle_popup = "'.$onidle_popup.'";
			var ulp_onidle_delay = "'.intval($this->options['onidle_delay']).'";';
		}
		$this->front_header .= '
		</script>';
		
		$this->front_footer .= '
		<script>
			var ulp_ajax_url = "'.admin_url('admin-ajax.php').'";
			var ulp_css3_enable = "'.$this->options['css3_enable'].'";
			var ulp_ga_tracking = "'.$this->options['ga_tracking'].'";
			var ulp_km_tracking = "'.$this->options['km_tracking'].'";
			var ulp_onexit_limits = "'.$this->options['onexit_limits'].'";
			var ulp_no_preload = "'.$this->options['no_preload'].'";
			var ulp_campaigns = {';
		$campaigns = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."ulp_campaigns WHERE deleted = '0' AND blocked = '0' ORDER BY created DESC", ARRAY_A);
		foreach ($campaigns as $campaign) {
			$popups = $wpdb->get_results("SELECT t1.*, t2.str_id FROM ".$wpdb->prefix."ulp_campaign_items t1 JOIN ".$wpdb->prefix."ulp_popups t2 ON t2.id = t1.popup_id WHERE t1.campaign_id = '".$campaign['id']."' AND t1.deleted = '0' AND t2.deleted = '0' AND t2.blocked = '0' ORDER BY t1.created DESC", ARRAY_A);
			$campaign_popups = array();
			foreach($popups as $popup) {
				$campaign_popups[] = $popup['str_id'];
			}
			$this->front_footer .= '"'.$campaign['str_id'].'":["'.implode('","', $campaign_popups).'"],';
		}
		$this->front_footer .= '"none":[""]};';
		$popups = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."ulp_popups WHERE deleted = '0' AND blocked = '0'", ARRAY_A);
		$this->front_footer .= '
			var ulp_overlays = {';
		foreach ($popups as $popup) {
			$popup_options = unserialize($popup['options']);
			if (is_array($popup_options)) $popup_options = array_merge($this->default_popup_options, $popup_options);
			else $popup_options = $this->default_popup_options;
			$this->front_footer .= '"'.$popup['str_id'].'":["'.($popup_options['disable_overlay'] == 'on' ? '' : (!empty($popup_options['overlay_color']) ? $popup_options['overlay_color'] : 'transparent')).'", "'.$popup_options['overlay_opacity'].'", "'.$popup_options['enable_close'].'", "'.$popup_options['position'].'"],';
		}
		$this->front_footer .= '"none":["", "", "", ""]};';

		if (isset($_GET['ulp'])) {
			$str_id = preg_replace('/[^a-zA-Z0-9-]/', '', $_GET['ulp']);
			$this->front_footer .= '
			if (typeof ulp_inline_open == "function" && typeof ulp_open == "function") { 
				ulp_prepare_ids(); ulp_inline_open(false); ulp_open("'.$str_id.'");
			} else {
				jQuery(document).ready(function(){ulp_prepare_ids(); ulp_inline_open(false); ulp_open("'.$str_id.'");});
			}';
		} else {
			$this->front_footer .= '
			if (typeof ulp_inline_open == "function" && typeof ulp_init == "function") { 
				ulp_prepare_ids(); ulp_inline_open(false); ulp_init();
			} else {
				jQuery(document).ready(function(){ulp_prepare_ids(); ulp_inline_open(false); ulp_init();});
			}';
		}
		$this->front_footer .= '
		</script>';
		if ($this->ext_options['late_init'] == 'on') {
			$this->front_enqueue_scripts();
		} else {
			add_action('wp_enqueue_scripts', array(&$this, 'front_enqueue_scripts'), 99);
		}
		add_action('wp_head', array(&$this, 'front_header'), 15);
		add_action('wp_footer', array(&$this, 'front_footer'), 999);
	}
	
	function get_popups($_popup_id = '', $_add_overlay = true) {
		global $wpdb, $post;
		
		$posts_page = false;
		$posts_page_id = get_option('page_for_posts');
		if (is_home() && !empty($posts_page_id)) $posts_page = true;

		$woo_page = false;
		$woo_page_id = 0;
		if (function_exists('is_product')) {
			if (is_product()) {
				$woo_page_id = $post->ID;
				$woo_page = true;
			}
		}
		if (function_exists('is_shop')) {
			if (is_shop() && function_exists('woocommerce_get_page_id')) {
				$woo_page_id = woocommerce_get_page_id('shop');
				$woo_page = true;
			}
		}
		
		$layer_webfonts = array();
		$style = '';
		unset($str_id);
		$filtered = array();
		if (!empty($_popup_id)) {
			$_popup_id = preg_replace('/[^a-zA-Z0-9-]/', '', $_popup_id);
			$filtered[] = $_popup_id;
		} else if (isset($_GET['ulp'])) {
			$str_id = preg_replace('/[^a-zA-Z0-9-]/', '', $_GET['ulp']);
			if (substr($str_id, 0, 3) == 'ab-') {
				$sql = "SELECT t1.*, t2.str_id FROM ".$wpdb->prefix."ulp_campaign_items t1 JOIN ".$wpdb->prefix."ulp_popups t2 ON t2.id = t1.popup_id JOIN ".$wpdb->prefix."ulp_campaigns t3 ON t3.id = t1.campaign_id WHERE t2.deleted = '0' AND t2.blocked = '0' AND t3.deleted = '0' AND t3.blocked = '0' AND t3.str_id = '".$str_id."' AND t1.deleted = '0'";
				$rows = $wpdb->get_results($sql, ARRAY_A);
				if (sizeof($rows) > 0) {
					foreach ($rows as $row) {
						$filtered[] = $row['str_id'];
					}
				} else $filtered[] = 'none';
			} else $filtered[] = $str_id;
		} else if ($this->options['onload_only'] == 'on') {
			if (is_singular() || $posts_page || $woo_page) {
				if ($posts_page) $meta = $this->get_meta($posts_page_id);
				else if ($woo_page) $meta = $this->get_meta($woo_page_id);
				else $meta = $this->get_meta($post->ID);
				$filtered[] = $meta['onload_popup'] == 'default' ? $this->options['onload_popup'] : $meta['onload_popup'];
				$filtered[] = $meta['onexit_popup'] == 'default' ? $this->options['onexit_popup'] : $meta['onexit_popup'];
				$filtered[] = $meta['onscroll_popup'] == 'default' ? $this->options['onscroll_popup'] : $meta['onscroll_popup'];
				$filtered[] = $meta['onidle_popup'] == 'default' ? $this->options['onidle_popup'] : $meta['onidle_popup'];
			} else {
				$filtered[] = $this->options['onload_popup'];
				$filtered[] = $this->options['onexit_popup'];
				$filtered[] = $this->options['onscroll_popup'];
				$filtered[] = $this->options['onidle_popup'];
			}
			$sql = "SELECT t1.*, t2.str_id FROM ".$wpdb->prefix."ulp_campaign_items t1 JOIN ".$wpdb->prefix."ulp_popups t2 ON t2.id = t1.popup_id JOIN ".$wpdb->prefix."ulp_campaigns t3 ON t3.id = t1.campaign_id WHERE t2.deleted = '0' AND t2.blocked = '0' AND t3.deleted = '0' AND t3.blocked = '0' AND t3.str_id IN ('".implode("', '", $filtered)."') AND t1.deleted = '0'";
			$rows = $wpdb->get_results($sql, ARRAY_A);
			if (sizeof($rows) > 0) {
				foreach ($rows as $row) {
					$filtered[] = $row['str_id'];
				}
			}
		}
		
		$popups = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."ulp_popups WHERE deleted = '0'".(isset($str_id) ? "" : " AND blocked = '0'").(!empty($filtered) ? " AND str_id IN ('".implode("', '", $filtered)."')" : ""), ARRAY_A);
		foreach ($popups as $popup) {
			$popup_options = unserialize($popup['options']);
			if (is_array($popup_options)) $popup_options = array_merge($this->default_popup_options, $popup_options);
			else $popup_options = $this->default_popup_options;
			$from = $this->get_rgb($popup_options['button_color']);
			$total = $from['r']+$from['g']+$from['b'];
			if ($total == 0) $total = 1;
			$to = array();
			$to['r'] = max(0, $from['r']-intval(48*$from['r']/$total));
			$to['g'] = max(0, $from['g']-intval(48*$from['g']/$total));
			$to['b'] = max(0, $from['b']-intval(48*$from['b']/$total));
			$to_color = '#'.($to['r'] < 16 ? '0' : '').dechex($to['r']).($to['g'] < 16 ? '0' : '').dechex($to['g']).($to['b'] < 16 ? '0' : '').dechex($to['b']);
			$from_color = $popup_options['button_color'];
			if (!empty($popup_options['input_background_color'])) $bg_color = $this->get_rgb($popup_options['input_background_color']);
			if ($popup_options['button_gradient'] == 'on') {
				$style .= '#ulp-'.$popup['str_id'].' .ulp-submit,#ulp-'.$popup['str_id'].' .ulp-submit:visited{border-radius: '.intval($popup_options['button_border_radius']).'px !important; background: '.$from_color.';border:1px solid '.$from_color.';background-image:linear-gradient('.$to_color.','.$from_color.');'.(!empty($popup_options['button_css']) ? $popup_options['button_css'] : '').'}';
				$style .= '#ulp-'.$popup['str_id'].' .ulp-submit:hover,#ulp-'.$popup['str_id'].' .ulp-submit:active{border-radius: '.intval($popup_options['button_border_radius']).'px !important; background: '.$to_color.';border:1px solid '.$from_color.';background-image:linear-gradient('.$from_color.','.$to_color.');'.(!empty($popup_options['button_css_hover']) ? $popup_options['button_css_hover'] : '').'}';
			} else {
				$style .= '#ulp-'.$popup['str_id'].' .ulp-submit,#ulp-'.$popup['str_id'].' .ulp-submit:visited{border-radius: '.intval($popup_options['button_border_radius']).'px !important; background: '.$from_color.';border:1px solid '.$from_color.';'.(!empty($popup_options['button_css']) ? $popup_options['button_css'] : '').'}';
				$style .= '#ulp-'.$popup['str_id'].' .ulp-submit:hover,#ulp-'.$popup['str_id'].' .ulp-submit:active{border-radius: '.intval($popup_options['button_border_radius']).'px !important; background: '.$to_color.';border:1px solid '.$to_color.';'.(!empty($popup_options['button_css_hover']) ? $popup_options['button_css_hover'] : '').'}';
			}
			$style .= '#ulp-'.$popup['str_id'].' .ulp-input,#ulp-'.$popup['str_id'].' .ulp-input:hover,#ulp-'.$popup['str_id'].' .ulp-input:active,#ulp-'.$popup['str_id'].' .ulp-input:focus,#ulp-'.$popup['str_id'].' .ulp-checkbox{border-width: '.intval($popup_options['input_border_width']).'px !important; border-radius: '.intval($popup_options['input_border_radius']).'px !important; border-color:'.(empty($popup_options['input_border_color']) ? 'transparent' : $popup_options['input_border_color']).';background-color:'.(empty($popup_options['input_background_color']) ? 'transparent' : $popup_options['input_background_color']).' !important;background-color:'.(empty($popup_options['input_background_color']) ? 'transparent' : 'rgba('.$bg_color['r'].','.$bg_color['g'].','.$bg_color['b'].','.floatval($popup_options['input_background_opacity'])).') !important;'.(!empty($popup_options['input_css']) ? $popup_options['input_css'] : '').'}';
			if ($_add_overlay && $popup_options['disable_overlay'] != 'on') $style .= '#ulp-'.$popup['str_id'].'-overlay{background:'.(!empty($popup_options['overlay_color']) ? $popup_options['overlay_color'] : 'transparent').';opacity:'.$popup_options['overlay_opacity'].';-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=\''.intval(100*$popup_options['overlay_opacity']).'\')";filter:alpha(opacity="'.intval(100*$popup_options['overlay_opacity']).'");}';
			
			$style = apply_filters('ulp_front_popup_style', $style, $popup);
			
			if ($_add_overlay && $popup_options['disable_overlay'] != 'on') {
				$this->front_footer .= '
				<div class="ulp-overlay" id="ulp-'.$popup['str_id'].'-overlay"></div>';
			}
			$this->front_footer .= '
				<div class="ulp-window" id="ulp-'.$popup['str_id'].'" data-title="'.esc_html($popup['title']).'" data-width="'.$popup_options['width'].'" data-height="'.$popup_options['height'].'" data-close="'.$popup_options['enable_close'].'" data-position="'.$popup_options['position'].'">
					<div class="ulp-content">';
			$layers = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."ulp_layers WHERE popup_id = '".$popup['id']."' AND deleted = '0'", ARRAY_A);
			foreach ($layers as $layer) {
				$layer_options = unserialize($layer['details']);
				if (is_array($layer_options)) $layer_options = array_merge($this->default_layer_options, $layer_options);
				else $layer_options = $this->default_layer_options;
				$layer_options = $this->filter_lp($layer_options);
				$content = str_replace(
					array('{subscription-name}', '{subscription-email}', '{subscription-phone}', '{subscription-message}', '{subscription-submit}'),
					array(
						'<input class="ulp-input ulp-input-field" type="text" name="ulp-name" placeholder="'.esc_html($popup_options['name_placeholder']).'" value="" onfocus="jQuery(this).removeClass(\'ulp-input-error\');">'.($this->options['fa_enable'] == 'on' && $popup_options['input_icons'] == 'on' ? '<div class="ulp-fa-input-table"><div class="ulp-fa-input-cell"><i class="fa fa-user"></i></div></div>' : ''),
						'<input class="ulp-input ulp-input-field" type="text" name="ulp-email" placeholder="'.esc_html($popup_options['email_placeholder']).'" value="" onfocus="jQuery(this).removeClass(\'ulp-input-error\');">'.($this->options['fa_enable'] == 'on' && $popup_options['input_icons'] == 'on' ? '<div class="ulp-fa-input-table"><div class="ulp-fa-input-cell"><i class="fa fa-envelope"></i></div></div>' : ''),
						'<input class="ulp-input ulp-input-field" type="text" name="ulp-phone" placeholder="'.esc_html($popup_options['phone_placeholder']).'" value="" onfocus="jQuery(this).removeClass(\'ulp-input-error\');">'.($this->options['fa_enable'] == 'on' && $popup_options['input_icons'] == 'on' ? '<div class="ulp-fa-input-table"><div class="ulp-fa-input-cell"><i class="fa fa-phone"></i></div></div>' : ''),
						'<textarea class="ulp-input ulp-input-field" name="ulp-message" placeholder="'.esc_html($popup_options['message_placeholder']).'" onfocus="jQuery(this).removeClass(\'ulp-input-error\');"></textarea>',
						'<a class="ulp-submit'.($popup_options['button_inherit_size'] == 'on' ? ' ulp-inherited' : '').'" onclick="return ulp_subscribe(this);"'.($this->options['fa_enable'] == 'on' && !empty($popup_options['button_icon']) && $popup_options['button_icon'] != 'fa-noicon' ? ' data-icon="'.$popup_options['button_icon'].'"' : '').' data-label="'.esc_html($popup_options['button_label']).'" data-loading="'.esc_html($popup_options['button_label_loading']).'">'.($this->options['fa_enable'] == 'on' && !empty($popup_options['button_icon']) && $popup_options['button_icon'] != 'fa-noicon' ? '<i class="fa '.$popup_options['button_icon'].'"></i>&nbsp; ' : '').esc_html($popup_options['button_label']).'</a>'),
					$layer_options['content']);
				if ($this->options['recaptcha_enable'] == 'on') {
					$recaptcha_id = 'ulp-recaptcha-'.$this->random_string(8);
					$content = str_replace('{recaptcha}', '<div class="ulp-recaptcha" id="'.$recaptcha_id.'" name="'.$recaptcha_id.'" data-theme="'.esc_html($popup_options['recaptcha_theme']).'"></div>', $content);
				}
				$content = apply_filters('ulp_front_popup_content', $content, $popup_options);
				$content = do_shortcode($content);
				$base64 = false;
				if (strpos(strtolower($content), '<iframe') !== false || strpos(strtolower($content), '<video') !== false || strpos(strtolower($content), '<audio') !== false) {
					$base64 = true;
					$content = base64_encode($content);
				}
				$this->front_footer .= '
						<div class="ulp-layer" id="ulp-layer-'.$layer['id'].'" data-left="'.$layer_options['left'].'" data-top="'.$layer_options['top'].'" data-appearance="'.$layer_options['appearance'].'" data-appearance-speed="'.$layer_options['appearance_speed'].'" data-appearance-delay="'.$layer_options['appearance_delay'].'"'.(!empty($layer_options['width']) ? ' data-width="'.$layer_options['width'].'"' : '').(!empty($layer_options['height']) ? ' data-height="'.$layer_options['height'].'"' : '').' data-font-size="'.$layer_options['font_size'].'"'.($base64 ? ' data-base64="yes"' : '').' '.(!empty($layer_options['scrollbar']) ? ' data-scrollbar="'.$layer_options['scrollbar'].'"' : ' data-scrollbar="off"').(!empty($layer_options['confirmation_layer']) ? ' data-confirmation="'.$layer_options['confirmation_layer'].'"' : ' data-confirmation="off"').'>'.$content.'</div>';
				if (!empty($layer_options['background_color'])) {
					$rgb = $this->get_rgb($layer_options['background_color']);
					$background = 'background-color:'.$layer_options['background_color'].';background-color:rgba('.$rgb['r'].','.$rgb['g'].','.$rgb['b'].','.$layer_options['background_opacity'].');';
				} else $background = '';
				if (!empty($layer_options['background_image'])) {
					$background .= 'background-image:url('.$layer_options['background_image'].');background-repeat:repeat;';
				}
				$font = "font-family:'".$layer_options['font']."', arial;font-weight:".$layer_options['font_weight'].";color:".$layer_options['font_color'].";".($layer_options['text_shadow_size'] > 0 && !empty($layer_options['text_shadow_color']) ? "text-shadow: ".$layer_options['text_shadow_color']." ".$layer_options['text_shadow_size']."px ".$layer_options['text_shadow_size']."px ".$layer_options['text_shadow_size']."px;" : "");
				$style .= '#ulp-layer-'.$layer['id'].',#ulp-layer-'.$layer['id'].' p,#ulp-layer-'.$layer['id'].' a,#ulp-layer-'.$layer['id'].' span,#ulp-layer-'.$layer['id'].' li,#ulp-layer-'.$layer['id'].' input,#ulp-layer-'.$layer['id'].' button,#ulp-layer-'.$layer['id'].' textarea,#ulp-layer-'.$layer['id'].' select {'.$font.'}';
				$style .= '#ulp-layer-'.$layer['id'].' .ulp-checkbox label:after{background:'.$layer_options['font_color'].'}';
				if ($this->options['fa_enable'] == 'on' && $popup_options['input_icons'] == 'on') {
					$style .= '#ulp-layer-'.$layer['id'].' input.ulp-input, #ulp-layer-'.$layer['id'].' select.ulp-input {padding-left: '.intval(4+2*$layer_options['font_size']).'px !important;} #ulp-layer-'.$layer['id'].' div.ulp-fa-input-cell {width: '.intval(2*$layer_options['font_size']).'px !important; padding-left: 4px !important;}';
				}
				$style .= '#ulp-layer-'.$layer['id'].'{'.$background.'z-index:'.($layer_options['index']+1000002).';text-align:'.$layer_options['content_align'].';'.$layer_options['style'].'}';
				if (!array_key_exists($layer_options['font'], $this->local_fonts)) $layer_webfonts[] = $layer_options['font'];
			}
			$this->front_footer .= '
					</div>
				</div>';
		}
		if (!empty($layer_webfonts)) {
			$layer_webfonts = array_unique($layer_webfonts);
			if ($this->options['version'] >= 4.58) {
				$webfonts_array = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."ulp_webfonts WHERE family IN ('".implode("', '", $layer_webfonts)."') AND deleted = '0' ORDER BY family", ARRAY_A);
			} else $webfonts_array = array();
			if(!empty($webfonts_array)){
				$families = array();
				$subsets = array();
				foreach($webfonts_array as $webfont) {
					$families[] = str_replace(' ', '+', $webfont['family']).':'.$webfont['variants'];
					$webfont_subsets = explode(',', $webfont['subsets']);
					if (!empty($webfont_subsets) && is_array($webfont_subsets)) $subsets = array_merge($subsets, $webfont_subsets);
				}
				$subsets = array_unique($subsets);
				$query = '?family='.implode('|', $families);
				if (!empty($subsets)) $query .= '&subset='.implode(',', $subsets);
				$this->front_header .= '<link href="//fonts.googleapis.com/css'.$query.'" rel="stylesheet" type="text/css">';
			}
		}
		$this->front_header .= '<style>'.$style.'</style>';
	}

	function front_enqueue_scripts() {
		wp_enqueue_script("jquery");
		if ($this->ext_options['minified_sources'] == 'on') {
			wp_enqueue_style('ulp', plugins_url('/css/style.min.css', __FILE__), array(), ULP_VERSION);
			wp_enqueue_style('ulp-link-buttons', plugins_url('/css/link-buttons.min.css', __FILE__), array(), ULP_VERSION);
			wp_enqueue_script('ulp', plugins_url('/js/script.min.js', __FILE__), array(), ULP_VERSION, true);
			if ($this->options['fa_enable'] == 'on' && $this->options['fa_css_disable'] != 'on') wp_enqueue_style('font-awesome', plugins_url('/css/font-awesome.min.css', __FILE__), array(), ULP_VERSION);
			wp_enqueue_style('perfect-scrollbar', plugins_url('/css/perfect-scrollbar-0.4.6.min.css', __FILE__), array(), ULP_VERSION);
			wp_enqueue_script('perfect-scrollbar', plugins_url('/js/perfect-scrollbar-0.4.6.with-mousewheel.min.js', __FILE__), array('ulp'), ULP_VERSION, true);
			if ($this->options['css3_enable'] == 'on') wp_enqueue_style('animate.css', plugins_url('/css/animate.min.css', __FILE__), array(), ULP_VERSION);
		} else {
			wp_enqueue_style('ulp', plugins_url('/css/style.css', __FILE__), array(), ULP_VERSION);
			wp_enqueue_style('ulp-link-buttons', plugins_url('/css/link-buttons.css', __FILE__), array(), ULP_VERSION);
			wp_enqueue_script('ulp', plugins_url('/js/script.js', __FILE__), array(), ULP_VERSION, true);
			if ($this->options['fa_enable'] == 'on' && $this->options['fa_css_disable'] != 'on') wp_enqueue_style('font-awesome', plugins_url('/css/font-awesome.css', __FILE__), array(), ULP_VERSION);
			wp_enqueue_style('perfect-scrollbar', plugins_url('/css/perfect-scrollbar.css', __FILE__), array(), ULP_VERSION);
			wp_enqueue_script('perfect-scrollbar', plugins_url('/js/perfect-scrollbar-0.4.6.with-mousewheel.min.js', __FILE__), array('ulp'), ULP_VERSION, true);
			if ($this->options['css3_enable'] == 'on') wp_enqueue_style('animate.css', plugins_url('/css/animate.css', __FILE__), array(), ULP_VERSION);
		}
		if ($this->options['recaptcha_enable'] == 'on' && $this->options['recaptcha_js_disable'] != 'on') {
			wp_deregister_script('recaptcha');
			wp_register_script('recaptcha', 'https://www.google.com/recaptcha/api.js?onload=ulp_recaptcha_loaded&render=explicit&hl=en');
			wp_enqueue_script("recaptcha", true, array(), ULP_VERSION, false);
		}
	}
	
	function front_header() {
		global $wpdb;
		echo $this->front_header;
	}

	function front_footer() {
		global $wpdb;
		echo $this->front_footer;
	}

	function shortcode_handler($_atts) {
		global $post, $wpdb;
		$html = '';
		$layer_webfonts = array();
		$style = '';
		//if ($this->check_options() === true) {
			if (isset($_atts['id'])) {
				$str_id = $_atts["id"];
				$popup = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."ulp_popups WHERE deleted = '0' AND str_id = '".esc_sql($str_id)."' AND blocked = '0'", ARRAY_A);
				if ($popup) {
					$popup_options = unserialize($popup['options']);
					if (is_array($popup_options)) $popup_options = array_merge($this->default_popup_options, $popup_options);
					else $popup_options = $this->default_popup_options;
					$from = $this->get_rgb($popup_options['button_color']);
					$total = $from['r']+$from['g']+$from['b'];
					if ($total == 0) $total = 1;
					$to = array();
					$to['r'] = max(0, $from['r']-intval(48*$from['r']/$total));
					$to['g'] = max(0, $from['g']-intval(48*$from['g']/$total));
					$to['b'] = max(0, $from['b']-intval(48*$from['b']/$total));
					$to_color = '#'.($to['r'] < 16 ? '0' : '').dechex($to['r']).($to['g'] < 16 ? '0' : '').dechex($to['g']).($to['b'] < 16 ? '0' : '').dechex($to['b']);
					$from_color = $popup_options['button_color'];
					if (isset($_atts['inline_id'])) $inline_id = $_atts['inline_id'];
					else $inline_id = $this->random_string();
					if (!empty($popup_options['input_background_color'])) $bg_color = $this->get_rgb($popup_options['input_background_color']);
					if ($popup_options['button_gradient'] == 'on') {
						$style .= '#ulp-inline-'.$inline_id.' .ulp-submit,#ulp-inline-'.$inline_id.' .ulp-submit:visited{border-radius: '.intval($popup_options['button_border_radius']).'px !important; background: '.$from_color.';border:1px solid '.$from_color.';background-image:linear-gradient('.$to_color.','.$from_color.');'.(!empty($popup_options['button_css']) ? $popup_options['button_css'] : '').'}';
						$style .= '#ulp-inline-'.$inline_id.' .ulp-submit:hover,#ulp-inline-'.$inline_id.' .ulp-submit:active{border-radius: '.intval($popup_options['button_border_radius']).'px !important; background: '.$to_color.';border:1px solid '.$from_color.';background-image:linear-gradient('.$from_color.','.$to_color.');'.(!empty($popup_options['button_css_hover']) ? $popup_options['button_css_hover'] : '').'}';
					} else {
						$style .= '#ulp-inline-'.$inline_id.' .ulp-submit,#ulp-inline-'.$inline_id.' .ulp-submit:visited{border-radius: '.intval($popup_options['button_border_radius']).'px !important; background: '.$from_color.';border:1px solid '.$from_color.';'.(!empty($popup_options['button_css']) ? $popup_options['button_css'] : '').'}';
						$style .= '#ulp-inline-'.$inline_id.' .ulp-submit:hover,#ulp-inline-'.$inline_id.' .ulp-submit:active{border-radius: '.intval($popup_options['button_border_radius']).'px !important; background: '.$to_color.';border:1px solid '.$to_color.';'.(!empty($popup_options['button_css_hover']) ? $popup_options['button_css_hover'] : '').'}';
					}
					$style .= '#ulp-inline-'.$inline_id.' .ulp-input,#ulp-inline-'.$inline_id.' .ulp-input:hover,#ulp-inline-'.$inline_id.' .ulp-input:active,#ulp-inline-'.$inline_id.' .ulp-input:focus,#ulp-inline-'.$inline_id.' .ulp-checkbox{border-width: '.intval($popup_options['input_border_width']).'px !important; border-radius: '.intval($popup_options['input_border_radius']).'px !important; border-color:'.(empty($popup_options['input_border_color']) ? 'transparent' : $popup_options['input_border_color']).';background-color:'.(empty($popup_options['input_background_color']) ? 'transparent' : $popup_options['input_background_color']).' !important;background-color:'.(empty($popup_options['input_background_color']) ? 'transparent' : 'rgba('.$bg_color['r'].','.$bg_color['g'].','.$bg_color['b'].','.floatval($popup_options['input_background_opacity'])).') !important;'.(!empty($popup_options['input_css']) ? $popup_options['input_css'] : '').'}';
			
					$style = apply_filters('ulp_front_inline_style', $style, $inline_id, $popup);

					$html = '
						<div class="ulp-inline-window" id="ulp-inline-'.$inline_id.'" data-id="'.$popup['str_id'].'" data-title="'.esc_html($popup['title']).'" data-width="'.$popup_options['width'].'" data-height="'.$popup_options['height'].'" data-close="'.$popup_options['enable_close'].'">
							<div class="ulp-content">';
					$layers = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."ulp_layers WHERE popup_id = '".$popup['id']."' AND deleted = '0'", ARRAY_A);
					foreach ($layers as $layer) {
						$layer_options = unserialize($layer['details']);
						if (is_array($layer_options)) $layer_options = array_merge($this->default_layer_options, $layer_options);
						else $layer_options = $this->default_layer_options;
						$layer_options = $this->filter_lp($layer_options);
						if ($layer_options['inline_disable'] == 'on') continue;
						$content = str_replace(
							array('{subscription-name}', '{subscription-email}', '{subscription-phone}', '{subscription-message}', '{subscription-submit}'),
							array(
								'<input class="ulp-input ulp-input-field" type="text" name="ulp-name" placeholder="'.esc_html($popup_options['name_placeholder']).'" value="" onfocus="jQuery(this).removeClass(\'ulp-input-error\');">'.($this->options['fa_enable'] == 'on' && $popup_options['input_icons'] == 'on' ? '<div class="ulp-fa-input-table"><div class="ulp-fa-input-cell"><i class="fa fa-user"></i></div></div>' : ''),
								'<input class="ulp-input ulp-input-field" type="text" name="ulp-email" placeholder="'.esc_html($popup_options['email_placeholder']).'" value="" onfocus="jQuery(this).removeClass(\'ulp-input-error\');">'.($this->options['fa_enable'] == 'on' && $popup_options['input_icons'] == 'on' ? '<div class="ulp-fa-input-table"><div class="ulp-fa-input-cell"><i class="fa fa-envelope"></i></div></div>' : ''),
								'<input class="ulp-input ulp-input-field" type="text" name="ulp-phone" placeholder="'.esc_html($popup_options['phone_placeholder']).'" value="" onfocus="jQuery(this).removeClass(\'ulp-input-error\');">'.($this->options['fa_enable'] == 'on' && $popup_options['input_icons'] == 'on' ? '<div class="ulp-fa-input-table"><div class="ulp-fa-input-cell"><i class="fa fa-phone"></i></div></div>' : ''),
								'<textarea class="ulp-input ulp-input-field" name="ulp-message" placeholder="'.esc_html($popup_options['message_placeholder']).'" onfocus="jQuery(this).removeClass(\'ulp-input-error\');"></textarea>',
								'<a class="ulp-submit'.($popup_options['button_inherit_size'] == 'on' ? ' ulp-inherited' : '').'" onclick="return ulp_subscribe(this);"'.($this->options['fa_enable'] == 'on' && !empty($popup_options['button_icon']) && $popup_options['button_icon'] != 'fa-noicon' ? ' data-icon="'.$popup_options['button_icon'].'"' : '').' data-label="'.esc_html($popup_options['button_label']).'" data-loading="'.esc_html($popup_options['button_label_loading']).'">'.($this->options['fa_enable'] == 'on' && !empty($popup_options['button_icon']) && $popup_options['button_icon'] != 'fa-noicon' ? '<i class="fa '.$popup_options['button_icon'].'"></i>&nbsp; ' : '').esc_html($popup_options['button_label']).'</a>'),
							$layer_options['content']);
						if ($this->options['recaptcha_enable'] == 'on') {
							$recaptcha_id = 'ulp-recaptcha-'.$this->random_string(8);
							$content = str_replace('{recaptcha}', '<div class="ulp-recaptcha" id="'.$recaptcha_id.'" name="'.$recaptcha_id.'" data-theme="'.esc_html($popup_options['recaptcha_theme']).'"></div>', $content);
						}
						$content = apply_filters('ulp_front_popup_content', $content, $popup_options);
						$content = do_shortcode($content);
						$base64 = false;
						if (strpos(strtolower($content), '<iframe') !== false || strpos(strtolower($content), '<video') !== false || strpos(strtolower($content), '<audio') !== false) {
							$base64 = true;
							$content = base64_encode($content);
						}
						$html .= '
								<div class="ulp-layer" id="ulp-inline-layer-'.$inline_id.'-'.$layer['id'].'" data-left="'.$layer_options['left'].'" data-top="'.$layer_options['top'].'" data-appearance="'.$layer_options['appearance'].'" data-appearance-speed="'.$layer_options['appearance_speed'].'" data-appearance-delay="'.$layer_options['appearance_delay'].'"'.(!empty($layer_options['width']) ? ' data-width="'.$layer_options['width'].'"' : '').(!empty($layer_options['height']) ? ' data-height="'.$layer_options['height'].'"' : '').' data-font-size="'.$layer_options['font_size'].'"'.($base64 ? ' data-base64="yes"' : '').' '.(!empty($layer_options['scrollbar']) ? ' data-scrollbar="'.$layer_options['scrollbar'].'"' : ' data-scrollbar="off"').(!empty($layer_options['confirmation_layer']) ? ' data-confirmation="'.$layer_options['confirmation_layer'].'"' : ' data-confirmation="off"').'>'.$content.'</div>';
						if (!empty($layer_options['background_color'])) {
							$rgb = $this->get_rgb($layer_options['background_color']);
							$background = 'background-color:'.$layer_options['background_color'].';background-color:rgba('.$rgb['r'].','.$rgb['g'].','.$rgb['b'].','.$layer_options['background_opacity'].');';
						} else $background = '';
						if (!empty($layer_options['background_image'])) {
							$background .= 'background-image:url('.$layer_options['background_image'].');background-repeat:repeat;';
						}
						$font = "font-family:'".$layer_options['font']."', arial;font-weight:".$layer_options['font_weight'].";color:".$layer_options['font_color'].";".($layer_options['text_shadow_size'] > 0 && !empty($layer_options['text_shadow_color']) ? "text-shadow: ".$layer_options['text_shadow_color']." ".$layer_options['text_shadow_size']."px ".$layer_options['text_shadow_size']."px ".$layer_options['text_shadow_size']."px;" : "");
						$style .= '#ulp-inline-layer-'.$inline_id.'-'.$layer['id'].',#ulp-inline-layer-'.$inline_id.'-'.$layer['id'].' p,#ulp-inline-layer-'.$inline_id.'-'.$layer['id'].' a,#ulp-inline-layer-'.$inline_id.'-'.$layer['id'].' span,#ulp-inline-layer-'.$inline_id.'-'.$layer['id'].' li,#ulp-inline-layer-'.$inline_id.'-'.$layer['id'].' input,#ulp-inline-layer-'.$inline_id.'-'.$layer['id'].' button,#ulp-inline-layer-'.$inline_id.'-'.$layer['id'].' textarea,#ulp-inline-layer-'.$inline_id.'-'.$layer['id'].' select {'.$font.'}';
						$style .= '#ulp-inline-layer-'.$inline_id.'-'.$layer['id'].' .ulp-checkbox label:after{background:'.$layer_options['font_color'].'}';
						if ($this->options['fa_enable'] == 'on' && $popup_options['input_icons'] == 'on') {
							$style .= '#ulp-inline-layer-'.$inline_id.'-'.$layer['id'].' input.ulp-input, #ulp-inline-layer-'.$inline_id.'-'.$layer['id'].' select.ulp-input {padding-left: '.intval(4+2*$layer_options['font_size']).'px !important;} #ulp-inline-layer-'.$inline_id.'-'.$layer['id'].' div.ulp-fa-input-cell {width: '.intval(2*$layer_options['font_size']).'px !important; padding-left: 4px !important;}';
						}
						$style .= '#ulp-inline-layer-'.$inline_id.'-'.$layer['id'].'{'.$background.'z-index:'.($layer_options['index']+10).';text-align:'.$layer_options['content_align'].';'.$layer_options['style'].'}';
						if (!array_key_exists($layer_options['font'], $this->local_fonts)) $layer_webfonts[] = $layer_options['font'];
					}
					$html .= '
							</div>
						</div>';
					$html = '<style>'.$style.'</style>'.$html;
					
					if (!empty($layer_webfonts)) {
						$layer_webfonts = array_unique($layer_webfonts);
						if ($this->options['version'] >= 4.58) {
							$webfonts_array = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."ulp_webfonts WHERE family IN ('".implode("', '", $layer_webfonts)."') AND deleted = '0' ORDER BY family", ARRAY_A);
						} else $webfonts_array = array();
						if(!empty($webfonts_array)){
							$families = array();
							$subsets = array();
							foreach($webfonts_array as $webfont) {
								$families[] = str_replace(' ', '+', $webfont['family']).':'.$webfont['variants'];
								$webfont_subsets = explode(',', $webfont['subsets']);
								if (!empty($webfont_subsets) && is_array($webfont_subsets)) $subsets = array_merge($subsets, $webfont_subsets);
							}
							$subsets = array_unique($subsets);
							$query = '?family='.implode('|', $families);
							if (!empty($subsets)) $query .= '&subset='.implode(',', $subsets);
							$html = '<link href="//fonts.googleapis.com/css'.$query.'" rel="stylesheet" type="text/css">'.$html;
						}
					}
				}
			}
		//}
		return $html;
	}

	function add_impression() {
		global $wpdb;
		if (isset($_POST['ulp-popup'])) $popup_str_id = trim(stripslashes($_POST['ulp-popup']));
		else $popup_str_id = '';
		if (isset($_POST['ulp-campaign'])) $campaign_str_id = trim(stripslashes($_POST['ulp-campaign']));
		else $campaign_str_id = '';
		$popup_str_id = preg_replace('/[^a-zA-Z0-9]/', '', $popup_str_id);
		$campaign_str_id = preg_replace('/[^a-zA-Z0-9-]/', '', $campaign_str_id);

		if (!empty($popup_str_id)) {
			$wpdb->query("UPDATE ".$wpdb->prefix."ulp_popups SET impressions = impressions + 1 WHERE deleted = '0' AND blocked = '0' AND str_id = '".esc_sql($popup_str_id)."'");
			if (!empty($campaign_str_id)) {
				$wpdb->query("UPDATE ".$wpdb->prefix."ulp_campaign_items t1 JOIN ".$wpdb->prefix."ulp_campaigns t2 ON t2.id = t1.campaign_id JOIN ".$wpdb->prefix."ulp_popups t3 ON t3.id = t1.popup_id SET t1.impressions = t1.impressions + 1 WHERE t1.deleted = '0' AND t2.deleted = '0' AND t2.blocked = '0' AND t2.str_id = '".esc_sql($campaign_str_id)."' AND t3.deleted = '0' AND t3.blocked = '0' AND t3.str_id = '".esc_sql($popup_str_id)."'");
			}
		}
		$return_data = array();
		$return_data['status'] = 'OK';
		echo json_encode($return_data);
		exit;
	}
	
	function subscribe() {
		global $wpdb;
		if (isset($_POST['ulp-name'])) $name = trim(stripslashes($_POST['ulp-name']));
		else $name = '';
		if (isset($_POST['ulp-email'])) $email = trim(stripslashes($_POST['ulp-email']));
		else $email = '';
		if (isset($_POST['ulp-phone'])) $phone = trim(stripslashes($_POST['ulp-phone']));
		else $phone = '';
		if (isset($_POST['ulp-message'])) $message = trim(stripslashes($_POST['ulp-message']));
		else $message = '';
		if (isset($_POST['ulp-campaign'])) $campaign_str_id = trim(stripslashes($_POST['ulp-campaign']));
		else $campaign_str_id  = '';
		if (isset($_POST['ulp-popup'])) $str_id = trim(stripslashes($_POST['ulp-popup']));
		else {
			$return_data = array();
			$return_data['status'] = 'FATAL';
			echo json_encode($return_data);
			exit;
		}
		$campaign_str_id = preg_replace('/[^a-zA-Z0-9-]/', '', $campaign_str_id);
		$str_id = preg_replace('/[^a-zA-Z0-9]/', '', $str_id);
		$popup_details = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."ulp_popups WHERE deleted = '0' AND str_id = '".$str_id."'", ARRAY_A);
		if (empty($popup_details)) {
			$return_data = array();
			$return_data['status'] = 'FATAL';
			echo json_encode($return_data);
			exit;
		}

		$popup_options = unserialize($popup_details['options']);
		if (is_array($popup_options)) $popup_options = array_merge($this->default_popup_options, $popup_options);
		else $popup_options = $this->default_popup_options;
		
		if ($this->options['recaptcha_enable'] == 'on' && $popup_options['recaptcha_mandatory'] == 'on') {
			$verified = false;
			foreach($_POST as $key => $value) {
				if (substr($key, 0, strlen('ulp-recaptcha-')) == 'ulp-recaptcha-') {
					$verified = true;
					if (!$this->verify_recaptcha($value)) {
						$return_data = array();
						$return_data[$key] = 'ERROR';
						$return_data['status'] = 'ERROR';
						echo json_encode($return_data);
						exit;
					}
				}
			}
			if (!$verified) {
				$return_data = array();
				$return_data['recaptcha'] = 'ERROR';
				$return_data['status'] = 'ERROR';
				echo json_encode($return_data);
				exit;
			}
		}

		$return_data = array();
		if ($email == '' || !preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,9})$/i", $email)) $return_data['ulp-email'] = 'ERROR';
		else {
			if ($this->options['email_validation'] == 'on') {
				$email_parts = explode('@',$email);
				if(checkdnsrr($email_parts[1], 'MX')) {
					//if(!fsockopen($email_parts[1], 25, $errno, $errstr, 30)) $return_data['ulp-email'] = 'ERROR';
				} else $return_data['ulp-email'] = 'ERROR';
			}
		}
	
		if ($popup_options['name_mandatory'] == 'on' && empty($name)) $return_data['ulp-name'] = 'ERROR';
		if ($popup_options['phone_mandatory'] == 'on' && empty($phone)) $return_data['ulp-phone'] = 'ERROR';
		if ($popup_options['message_mandatory'] == 'on' && empty($message)) $return_data['ulp-message'] = 'ERROR';
		
		$return_data = apply_filters('ulp_front_fields_check', $return_data, $popup_options);
		
		if (!empty($return_data)) {
			$return_data['status'] = 'ERROR';
			echo json_encode($return_data);
			exit;
		}
		
		$custom_fields = apply_filters('ulp_log_custom_fields', array(), $popup_options);
		$custom_fields = array_merge($custom_fields, array('ip' => array('name' => 'IP Address', 'value' => $_SERVER['REMOTE_ADDR']), 'agent' => array('name' => 'User Agent', 'value' => (array_key_exists('HTTP_USER_AGENT', $_SERVER) ? $_SERVER['HTTP_USER_AGENT'] : '')), 'url' => array('name' => 'URL', 'value' => (array_key_exists('HTTP_REFERER', $_SERVER) ? $_SERVER['HTTP_REFERER'] : ''))));
		
		//$subscriber_details = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."ulp_subscribers WHERE deleted = '0' AND popup_id = '".$popup_details['id']."' AND email = '".esc_sql($email)."'", ARRAY_A);
		//if (empty($subscriber_details)) {
			$sql = "INSERT INTO ".$wpdb->prefix."ulp_subscribers (
				popup_id, name, email, phone, message, custom_fields, created, deleted) VALUES (
				'".$popup_details['id']."',
				'".esc_sql($name)."',
				'".esc_sql($email)."',
				'".esc_sql($phone)."',
				'".esc_sql($message)."',
				'".esc_sql(serialize($custom_fields))."',
				'".time()."', '0')";
		//} else {
		//	$sql = "UPDATE ".$wpdb->prefix."ulp_subscribers SET name = '".esc_sql($name)."', created = '".time()."' WHERE id = '".$subscriber_details['id']."'";
		//}
		$wpdb->query($sql);
		$subscriber_id = $wpdb->insert_id;
		
		$wpdb->query("UPDATE ".$wpdb->prefix."ulp_popups SET clicks = clicks + 1 WHERE deleted = '0' AND blocked = '0' AND id = '".$popup_details['id']."'");
		if (!empty($campaign_str_id)) {
			$wpdb->query("UPDATE ".$wpdb->prefix."ulp_campaign_items t1 JOIN ".$wpdb->prefix."ulp_campaigns t2 ON t2.id = t1.campaign_id JOIN ".$wpdb->prefix."ulp_popups t3 ON t3.id = t1.popup_id SET t1.clicks = t1.clicks + 1 WHERE t1.deleted = '0' AND t2.deleted = '0' AND t2.blocked = '0' AND t2.str_id = '".esc_sql($campaign_str_id)."' AND t3.deleted = '0' AND t3.blocked = '0' AND t3.id = '".$popup_details['id']."'");
		}
		if (empty($name)) $name = substr($email, 0, strpos($email, '@'));
		
		$subscriber = array(
			'{id}' => $subscriber_id,
			'{name}' => $name, 
			'{email}' => $email, 
			'{e-mail}' => $email, 
			'{phone}' => $phone, 
			'{message}' => $message,
			'{subscription-name}' => $name, 
			'{subscription-email}' => $email, 
			'{subscription-phone}' => $phone, 
			'{subscription-message}' => $message,
			'{ip}' => $_SERVER['REMOTE_ADDR'],
			'{url}' => $_SERVER['HTTP_REFERER'],
			'{user-agent}' => $_SERVER['HTTP_USER_AGENT'],
			'{popup}' => $popup_options['title'],
			'{popup-id}' => $popup_details['str_id']
		);
		$subscriber = apply_filters('ulp_subscriber_details', $subscriber, $popup_options);
		
		do_action('ulp_subscribe', $popup_options, $subscriber);
		
		//setcookie('ulp-'.$popup_details['str_id'], $this->options['cookie_value'], time()+3600*24*180, "/");
		$urlencoded = $subscriber;
		foreach ($urlencoded as $key => $value) {
			$urlencoded[$key] = urlencode($value);
		}
		
		$return_url = apply_filters('ulp_thankyou_url', $popup_options['return_url'], $popup_options, $subscriber);
		
		$return_data = array();
		$return_data['status'] = 'OK';
		$return_data['return_url'] = strtr($return_url, $urlencoded);
		$return_data['close_delay'] = 1000*intval($popup_options['close_delay']);
		echo json_encode($return_data);
		exit;
	}

	function share() {
		global $wpdb;
		if (isset($_POST['ulp-campaign'])) $campaign_str_id = trim(stripslashes($_POST['ulp-campaign']));
		else $campaign_str_id  = '';
		if (isset($_POST['ulp-popup'])) $str_id = trim(stripslashes($_POST['ulp-popup']));
		else {
			$return_data = array();
			$return_data['status'] = 'FATAL';
			echo json_encode($return_data);
			exit;
		}
		$campaign_str_id = preg_replace('/[^a-zA-Z0-9-]/', '', $campaign_str_id);
		$str_id = preg_replace('/[^a-zA-Z0-9]/', '', $str_id);
		$popup_details = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."ulp_popups WHERE deleted = '0' AND str_id = '".$str_id."'", ARRAY_A);
		if (empty($popup_details)) {
			$return_data = array();
			$return_data['status'] = 'FATAL';
			echo json_encode($return_data);
			exit;
		}
		$return_data = array();
		$popup_options = unserialize($popup_details['options']);
		if (is_array($popup_options)) $popup_options = array_merge($this->default_popup_options, $popup_options);
		else $popup_options = $this->default_popup_options;
	
		if (!empty($return_data)) {
			$return_data['status'] = 'ERROR';
			echo json_encode($return_data);
			exit;
		}
		
		$wpdb->query("UPDATE ".$wpdb->prefix."ulp_popups SET clicks = clicks + 1 WHERE deleted = '0' AND blocked = '0' AND id = '".$popup_details['id']."'");
		if (!empty($campaign_str_id)) {
			$wpdb->query("UPDATE ".$wpdb->prefix."ulp_campaign_items t1 JOIN ".$wpdb->prefix."ulp_campaigns t2 ON t2.id = t1.campaign_id JOIN ".$wpdb->prefix."ulp_popups t3 ON t3.id = t1.popup_id SET t1.clicks = t1.clicks + 1 WHERE t1.deleted = '0' AND t2.deleted = '0' AND t2.blocked = '0' AND t2.str_id = '".esc_sql($campaign_str_id)."' AND t3.deleted = '0' AND t3.blocked = '0' AND t3.id = '".$popup_details['id']."'");
		}
		
		$return_data = array();
		$return_data['status'] = 'OK';
		$return_data['return_url'] = $popup_options['return_url'];
		$return_data['close_delay'] = 1000*intval($popup_options['close_delay']);
		echo json_encode($return_data);
		exit;
	}
	
	function filter_lp($_layer_options) {
		foreach ($_layer_options as $key => $value) {
			$_layer_options[$key] = str_replace(array('ULP-DEMO-IMAGES-URL', 'http://datastorage.pw/images'), array(plugins_url('/images/default', __FILE__), plugins_url('/images/default', __FILE__)), $value);
		}
		return $_layer_options;
	}
	
	function filter_lp_reverse($_layer_options) {
		foreach ($_layer_options as $key => $value) {
			$_layer_options[$key] = str_replace(array('http://datastorage.pw/images', plugins_url('/images/default', __FILE__)), array('ULP-DEMO-IMAGES-URL', 'ULP-DEMO-IMAGES-URL'), $value);
		}
		return $_layer_options;
	}
	
	function get_rgb($_color) {
		if (strlen($_color) != 7 && strlen($_color) != 4) return false;
		$color = preg_replace('/[^#a-fA-F0-9]/', '', $_color);
		if (strlen($color) != strlen($_color)) return false;
		if (strlen($color) == 7) list($r, $g, $b) = array($color[1].$color[2], $color[3].$color[4], $color[5].$color[6]);
		else list($r, $g, $b) = array($color[1].$color[1], $color[2].$color[2], $color[3].$color[3]);
		return array("r" => hexdec($r), "g" => hexdec($g), "b" => hexdec($b));
	}

	function random_string($_length = 16) {
		$symbols = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$string = "";
		for ($i=0; $i<$_length; $i++) {
			$string .= $symbols[rand(0, strlen($symbols)-1)];
		}
		return $string;
	}

	function page_switcher ($_urlbase, $_currentpage, $_totalpages) {
		$pageswitcher = "";
		if ($_totalpages > 1) {
			$pageswitcher = '<div class="tablenav bottom"><div class="tablenav-pages">'.__('Pages:', 'ulp').' <span class="pagiation-links">';
			if (strpos($_urlbase,"?") !== false) $_urlbase .= "&amp;";
			else $_urlbase .= "?";
			if ($_currentpage == 1) $pageswitcher .= "<a class='page disabled'>1</a> ";
			else $pageswitcher .= " <a class='page' href='".$_urlbase."p=1'>1</a> ";

			$start = max($_currentpage-3, 2);
			$end = min(max($_currentpage+3,$start+6), $_totalpages-1);
			$start = max(min($start,$end-6), 2);
			if ($start > 2) $pageswitcher .= " <b>...</b> ";
			for ($i=$start; $i<=$end; $i++) {
				if ($_currentpage == $i) $pageswitcher .= " <a class='page disabled'>".$i."</a> ";
				else $pageswitcher .= " <a class='page' href='".$_urlbase."p=".$i."'>".$i."</a> ";
			}
			if ($end < $_totalpages-1) $pageswitcher .= " <b>...</b> ";

			if ($_currentpage == $_totalpages) $pageswitcher .= " <a class='page disabled'>".$_totalpages."</a> ";
			else $pageswitcher .= " <a class='page' href='".$_urlbase."p=".$_totalpages."'>".$_totalpages."</a> ";
			$pageswitcher .= "</span></div></div>";
		}
		return $pageswitcher;
	}
	
	function check_for_plugin_update($checked_data) {
		global $wp_version;
		
		$file = basename(dirname(__FILE__)).'/'.basename(__FILE__);
		$purchase_code = preg_replace('/[^a-zA-Z0-9-]/', '', $this->options['purchase_code']);
		
		if (empty($checked_data->checked))
			return $checked_data;
			
		$args = array(
			'slug' => 'layered-popups',
			'version' => $checked_data->checked[$file],
		);
		$request_string = array(
				'body' => array(
					'action' => 'basic_check', 
					'request' => serialize($args),
					'api-key' => $purchase_code
				),
				'user-agent' => 'WordPress/'.$wp_version.'; '.get_bloginfo('url')
			);
		
		$raw_response = wp_remote_post(ULP_API_URL, $request_string);
		
		if (!is_wp_error($raw_response) && ($raw_response['response']['code'] == 200)) {
			$response = unserialize($raw_response['body']);
		}
		if (!empty($response) && is_object($response)) {
			$checked_data->response[$file] = $response;
		}
		return $checked_data;
	}
	
	function plugin_api_call($def, $action, $args) {
		global $wp_version;

		$file = basename(dirname(__FILE__));
		$purchase_code = preg_replace('/[^a-zA-Z0-9-]/', '', $this->options['purchase_code']);
		
		if (!isset($args->slug) || ($args->slug != 'layered-popups'))
			return false;
		
		$plugin_info = get_site_transient('update_plugins');
		
		$current_version = $plugin_info->checked[$file];
		$args->version = $current_version;
		
		$request_string = array(
				'body' => array(
					'action' => $action, 
					'request' => serialize($args),
					'api-key' => $purchase_code
				),
				'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo('url')
			);
		
		$request = wp_remote_post(ULP_API_URL, $request_string);
		
		if (is_wp_error($request)) {
			$res = new WP_Error('plugins_api_failed', __('An Unexpected HTTP Error occurred during the API request.', 'ulp').' <a href="#" onclick="document.location.reload(); return false;">'.__('Try again.', 'ulp').'</a>', $request->get_error_message());
		} else {
			$res = unserialize($request['body']);
			if ($res === false) {
				$res = new WP_Error('plugins_api_failed', __('An unknown error occurred', 'ulp'), $request['body']);
			}
		}
		
		return $res;
	}
	
	function add_to_archive(&$_zip, $_image_url, &$_images_processed) {
		if (substr($_image_url, 0, 2) == '//') $_image_url = 'http:'.$_image_url;
		if (strtolower(substr($_image_url, 0, 8)) == 'https://') $processed_key = substr($_image_url, 8);
		else $processed_key = substr($_image_url, 7);
		if (strtolower(substr($processed_key, 0, 4)) == 'www.') $processed_key = substr($processed_key, 4);
		if (array_key_exists($processed_key, $_images_processed)) {
			return $_images_processed[$processed_key]['image'];
		}
		$filename = 'img-'.sizeof($_images_processed);
		$mime_types = array(
			'image/png' => 'png',
			'image/jpeg' => 'jpg',
			'image/gif' => 'gif',
			'image/bmp' => 'bmp',
			'image/vnd.microsoft.icon' => 'ico',
			'image/tiff' => 'tiff',
			'image/svg+xml' => 'svg',
			'image/svg+xml' => 'svgz'
		);
		$download_file = download_url($_image_url);
		if (is_wp_error($download_file)) {
			return false;
		}
		$img_data = getimagesize($download_file);
		if (is_array($img_data) && array_key_exists('mime', $img_data)) {
			if (array_key_exists($img_data['mime'], $mime_types)) {
				$filename .= '.'.$mime_types[$img_data['mime']];
			}
		}
		if ($_zip->addFile($download_file, $filename)) {
			$_images_processed[$processed_key] = array(
				'image' => $filename,
				'temp' => $download_file
			);
			return $filename;
		}
		unlink($download_file);
		return false;
	}						
	function import_zip($_filename, $_title = '') {
		global $wpdb;
		error_reporting(0);
		$str_id = $this->random_string(16);
		//if (!class_exists('ZipArchive')) {
		//	return new WP_Error('ulp_no_required_classes', __('This operation <strong>requires</strong> <em>ZipArchive</em> class. It is <strong>not found</strong>.', 'ulp'));
		//}
		$upload_dir = wp_upload_dir();
		if (!file_exists($upload_dir["basedir"].'/'.ULP_UPLOADS_DIR.'/temp')) {
			return new WP_Error('ulp_no_temp_folder', __('Please <strong>re-activate</strong> the plugin and try again.', 'ulp'));
		}
		$temp_dir = $upload_dir["basedir"].'/'.ULP_UPLOADS_DIR.'/'.$str_id;
		if (!wp_mkdir_p($temp_dir)) {
			return new WP_Error('ulp_no_temp_folder', __('Make sure that the following folder has write permission:', 'ulp').' '.$upload_dir["basedir"].'/'.ULP_UPLOADS_DIR);
		}
		require_once(ABSPATH.'wp-admin/includes/file.php');
		WP_Filesystem();
		$result = unzip_file($_filename, $temp_dir);
		if (is_wp_error($result)) {
			$zip = new ZipArchive;
			if ($zip->open($_filename) === TRUE) {
				$zip->extractTo($temp_dir);
				$zip->close();
			} else {
				return new WP_Error('ulp_cant_unzip', __('Can not unzip archive into folder', 'ulp').' '.$temp_dir);
			}
		}
		if (!file_exists($temp_dir.'/popup.txt')) {
			$this->remove_dir($temp_dir);
			return new WP_Error('ulp_invalid_archive', __('Please make sure that you uploaded valid popup file. Error #1.', 'ulp'));
		}
		$lines = file($temp_dir.'/popup.txt');
		if (sizeof($lines) != 3) {
			$this->remove_dir($temp_dir);
			return new WP_Error('ulp_invalid_archive', __('Please make sure that you uploaded valid popup file. Error #2.', 'ulp'));
		}
		$version = intval(trim($lines[0]));
		if ($version > intval(ULP_EXPORT_VERSION)) {
			$this->remove_dir($temp_dir);
			return new WP_Error('ulp_invalid_archive', __('Please make sure that you uploaded valid popup file. Error #3.', 'ulp'));
		}
		$md5_hash = trim($lines[1]);
		$popup_data = trim($lines[2]);
		$popup_data = base64_decode($popup_data);
		if (!$popup_data || md5($popup_data) != $md5_hash) {
			$this->remove_dir($temp_dir);
			return new WP_Error('ulp_invalid_archive', __('Please make sure that you uploaded valid popup file. Error #4.', 'ulp'));
		}
		$popup = unserialize($popup_data);
		if ($popup === false) {
			$this->remove_dir($temp_dir);
			return new WP_Error('ulp_invalid_archive', __('Please make sure that you uploaded valid popup file. Error #5.', 'ulp'));
		}
		$popup_details = $popup['popup'];
		if (!empty($_title)) $popup_details['title'] = $_title;
		
		$upload_url = trailingslashit($upload_dir['baseurl']).ULP_UPLOADS_DIR.'/'.$str_id;
		if (strtolower(substr($upload_url, 0, 7)) == 'http://') $upload_url = substr($upload_url, 5);
		else if (strtolower(substr($upload_url, 0, 8)) == 'https://') $upload_url = substr($upload_url, 6);
		
		$sql = "INSERT INTO ".$wpdb->prefix."ulp_popups (str_id, title, width, height, options, created, blocked, deleted) VALUES (
			'".$str_id."', 
			'".esc_sql($popup_details['title'])."', 
			'".intval($popup_details['width'])."', 
			'".intval($popup_details['height'])."', 
			'".esc_sql($popup_details['options'])."', 
			'".time()."', '1', '0')";
		$wpdb->query($sql);
		$popup_id = $wpdb->insert_id;
		$layers = $popup['layers'];
		if (sizeof($layers) > 0) {
			foreach ($layers as $layer) {
				$layer_options = unserialize($layer['details']);
				if (is_array($layer_options)) $layer_options = array_merge($this->default_layer_options, $layer_options);
				else $layer_options = $this->default_layer_options;
				$layer_options['content'] = str_replace('ULP-UPLOADS-DIR', $upload_url, $layer_options['content']);
				$layer_options['background_image'] = str_replace('ULP-UPLOADS-DIR', $upload_url, $layer_options['background_image']);
				$layer['content'] = str_replace('ULP-UPLOADS-DIR', $upload_url, $layer['content']);
				$layer['details'] = serialize($layer_options);
				$sql = "INSERT INTO ".$wpdb->prefix."ulp_layers (popup_id, title, content, zindex, details, created, deleted) VALUES (
					'".$popup_id."',
					'".esc_sql($layer['title'])."',
					'".esc_sql($layer['content'])."',
					'".esc_sql($layer['zindex'])."',
					'".esc_sql($layer['details'])."',
					'".time()."', '0')";
				$wpdb->query($sql);
			}
		}
		return true;
	}
	function remove_dir($_dir) { 
		$files = array_diff(scandir($_dir), array('.','..')); 
		foreach ($files as $file) { 
			if (is_dir($_dir.'/'.$file)) {
				$this->remove_dir($_dir.'/'.$file);
			} else {
				unlink($_dir.'/'.$file); 
			}
		}
		return rmdir($_dir);
	}
	function verify_recaptcha($_response) {
		$request = http_build_query(array(
			'secret' => $this->options['recaptcha_secret_key'],
			'response' => $_response,
			'remoteip' => $_SERVER['REMOTE_ADDR']
		));
		try {
			$curl = curl_init('https://www.google.com/recaptcha/api/siteverify');
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $request);

			curl_setopt($curl, CURLOPT_TIMEOUT, 20);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_FORBID_REUSE, 1);
			curl_setopt($curl, CURLOPT_FRESH_CONNECT, 1);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($curl, CURLOPT_HEADER, 0);
								
			$response = curl_exec($curl);
			curl_close($curl);
			$result = json_decode($response, true);
			if(!$result) return false;
			if (array_key_exists('success', $result)) {
				return $result['success'];
			} else return false;
		} catch (Exception $e) {
			return false;
		}
	}
}
$ulp = new ulp_class();
?>