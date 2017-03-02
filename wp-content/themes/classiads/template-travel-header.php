<?php
/**
 * The Template Header for displaying all single posts.
 *
 * @package WordPress
 * @subpackage classiads
 * @since classiads 1.2.2
 */
?>



<?php


	//Template
	wp_enqueue_style( 'bootstrap3-style', get_template_directory_uri() . '/css/bootstrap3.min.css', array(), '1.0.0' );
	
	wp_enqueue_style( 'select-style', get_template_directory_uri() . '/css/bootstrap-select.min.css', array(bootstrap3-style), '1.0.0' );

	wp_enqueue_style ( 'google-font-style', 'http://fonts.googleapis.com/css?family=Indie+Flower|Rock+Salt|Open+Sans+Condensed:300|Roboto|Great+Vibes|Oleo+Script', array (
	), '1.0.0' );
	
	//Template
	wp_enqueue_style( 'travel-style', get_template_directory_uri() . '/css/travel.css', array(), '1.0.0' );

	wp_enqueue_style( 'update-travel-style', get_stylesheet_directory_uri() . '/update-travel.css', array(), '1.0.0' );
	
	wp_enqueue_style( 'button-style', get_template_directory_uri() . '/css/buttons.css', array(), '1.0.0' );
	
	
	
	wp_enqueue_style( 'datepicker-style', get_template_directory_uri() . '/css/datepicker3.css', array(), '1.0.0' );
	
	wp_enqueue_style( 'fontawesome-style', get_template_directory_uri() . '/css/font-awesome.min.css', array(), '1.0.0' );
	
	//Template
	wp_enqueue_style( 'animate-style', get_stylesheet_directory_uri() . '/css/animate.min.css', array('bootstrap3-style'), '1.0.0' );
	
	//Template
	wp_enqueue_style( 'templatemo-style', get_template_directory_uri() . '/css/templatemo_style.css', array('bootstrap3-style'), '1.0.0' );

	// Loads JavaScript file with functionality specific to classiads.
	wp_enqueue_script( 'bootstrap3-js', get_template_directory_uri() . '/js/bootstrap3.min.js', array( 'jquery' ), '2014-07-18', true );
	
	// Loads JavaScript file with functionality specific to classiads.
	wp_enqueue_script( 'waypoint-js', get_stylesheet_directory_uri() . '/js/jquery.waypoints.min.js', array( 'jquery' ), '2014-07-18', true );
	
	
	// Loads JavaScript file with functionality specific to classiads.
	wp_enqueue_script( 'select-js', get_template_directory_uri() . '/js/bootstrap-select.min.js', array( 'bootstrap3-js' ), '2014-07-18', true );
	
	
	
	// Loads JavaScript file with functionality specific to classiads.
	wp_enqueue_script( 'easing', get_template_directory_uri() . '/js/jquery.easing.1.3.js', array( 'jquery' ), '2014-07-18', true );
	
	// Loads JavaScript file with functionality specific to classiads.
	wp_enqueue_script( 'mobile-customized', get_template_directory_uri() . '/js/jquery.mobile.customized.min.js', array( 'jquery','easing' ), '2014-07-18', true );
	
	// Loads JavaScript file with functionality specific to classiads.
	wp_enqueue_script( 'unslider', get_template_directory_uri() . '/js/unslider.min.js', array( 'jquery' ), '2014-07-18', true );
	
	// Loads JavaScript file with functionality specific to classiads.
	wp_enqueue_script( 'singlePageNav', get_template_directory_uri() . '/js/jquery.singlePageNav.min.js', array( 'jquery' ), '2014-07-18', true );
	
	wp_enqueue_script( 'datepicker-script', get_template_directory_uri() . '/js/bootstrap-datepicker.js', array( 'jquery', 'bootstrap3-js' ), '2014-07-18', true );
	
	
	wp_enqueue_script( 'moment', get_template_directory_uri() . '/js/moment.min.js', array(), '2014-07-18', true );
	
	
	// Loads JavaScript file with functionality specific to classiads.
	wp_enqueue_script( 'templatemo_scrip', get_template_directory_uri() . '/js/templatemo_script.js', array( 'jquery', 'bootstrap3-js','mobile-customized'), '2014-07-18', true );
	
	// load local script
	wp_register_script( 'custom_script', get_template_directory_uri() . '/js/custom.js', array( 'jquery'), '2014-07-18', true );
	
	wp_localize_script('custom_script', 'package_base_url', get_home_url( null, get_post_type_object( 'travel_package' )->rewrite['slug'] ));
	
	if(is_page_template("template-search.php")){
	
		wp_localize_script('custom_script', 'search_date', esc_attr($_GET['date']));
		wp_localize_script('custom_script', 'search_des', esc_attr($_GET['des']));
		wp_localize_script('custom_script', 'search_des_text', esc_attr($_GET['des-text']));
	
	}
	
	
	//wp_localize_script('custom_script', 'package_arr', get_all_packages_meta());
	wp_enqueue_script( 'custom_script' );
	
	
?> 

<?php

if(isset($_POST['submit']) && isset($_POST['package']) && isset($_POST['post_nonce_field']) && wp_verify_nonce($_POST['post_nonce_field'], 'post_nonce') && isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {

	//your site secret key
	$recaptcha_secret = '6Lc03xYUAAAAAAFIcPi0ky6YgO7itu8GtGvZU4rY';
	//get verify response data
	$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$recaptcha_secret.'&response='.$_POST['g-recaptcha-response']);
	$responseData = json_decode($verifyResponse);
	if($responseData->success){
		

		$is_honeymoon = false;
		$is_flight = false;
		$is_newsletter = false;
		$is_honeymoon_human = "no";
		$is_flight_human = "no";
		$is_newsletter_human = "no";
		
		$post_honeymoon = esc_attr(strip_tags($_POST['honeymoon']));
		$post_flight = esc_attr(strip_tags($_POST['flight']));
		$post_date_depart = esc_attr(strip_tags($_POST['date-depart']));
		
		$post_contact_method = esc_attr(strip_tags($_POST['contact-method']));
		$post_number_of_nights = esc_attr(strip_tags($_POST['number-of-nights']));
		$post_spend= esc_attr(strip_tags($_POST['spend']));
		$post_time_to_call = esc_attr(strip_tags($_POST['time-to-call']));
		$post_travel_occasion = esc_attr(strip_tags($_POST['travel-occasion']));
		
		
		$post_newsletter = esc_attr(strip_tags($_POST['newsletter']));
		
		if(!empty($post_honeymoon)) {
			$is_honeymoon = true;
			$is_honeymoon_human = "yes";
		}
		
		if(!empty($post_flight)) {
			$is_flight = true;
			$is_flight_human = "yes";
		}
		
		if(!empty($post_newsletter)) {
			$is_newsletter = true;
			$is_newsletter_human = "yes";
		}
		
		if(!empty($post_date_depart)) {
		
			$date_depart_timestamp = strtotime($post_date_depart);
		
			if(empty($date_depart_timestamp)){
				exit;
			}
			$departure_date = date('Y-m-d', $date_depart_timestamp);
		}
		
		$current_date = date('Y-m-d', current_time( 'timestamp'));
		
		$enquiry_category = esc_attr(strip_tags($_POST['submit']));
		
		$enquiry_information = array(
				'first_name' => esc_attr(strip_tags($_POST['first-name'])),
				'last_name' => esc_attr(strip_tags($_POST['last-name'])),
				'city_depart' => esc_attr(strip_tags($_POST['city-depart'])),
				'departure_date' => $departure_date,
				'email'    => esc_attr(strip_tags($_POST['email'])),
				'phone' => esc_attr(strip_tags($_POST['phone'])),
				'package' => esc_attr(strip_tags($_POST['package'])),
				'promo_code' => esc_attr(strip_tags($_POST['promo-code'])),
				'honeymoon' => $is_honeymoon,
				'flight' => $is_flight,
				'message' => esc_attr(strip_tags($_POST['message'])),
				'category' => $enquiry_category,
				'enquiry_date' => $current_date,
				'contact_method' => $post_contact_method,
				'number_of_nights' => $post_number_of_nights,
				'spend' => $post_spend,
				'time_to_call' => $post_time_to_call,
				'travel_occasion' => $post_travel_occasion,
		
		);
		
		
		// insert listing meta for each listing post in separate table
		$wpdb->insert ( $wpdb->prefix . 'travel_enquiry_booking', array (
				'First Name' => $enquiry_information["first_name"],
				'Last Name' => $enquiry_information["last_name"],
				'City Depart' => $enquiry_information["city_depart"],
				'Departure Date' => $enquiry_information["departure_date"],
				'Email' => $enquiry_information["email"],
				//'Region' => $obj->region,
				'Phone' => $enquiry_information["phone"],
				'Package' => $enquiry_information["package"],
				'Promo Code' => $enquiry_information["promo_code"],
				'Honeymoon' => $enquiry_information["honeymoon"],
				'Flight' => $enquiry_information["flight"],
				'Message' => $enquiry_information["message"],
				'category' => $enquiry_information["category"],
				'Enquiry Date' => $enquiry_information["enquiry_date"],
		)
				);
		
		$multiple_to_recipients = array(
				'sales@overwaterbungalows.com.au',
				'chengxianga2008@yahoo.com'
		);
		
		$content_here = <<<DOC
  First Name: {$enquiry_information["first_name"]}
  Last Name: {$enquiry_information["last_name"]}
  Arrival Date: {$enquiry_information["departure_date"]}
  Email: {$enquiry_information["email"]}
  Phone: {$enquiry_information["phone"]}
  Contact me via: {$enquiry_information["contact_method"]}
  Best time to call: {$enquiry_information["time_to_call"]}
  Package: {$enquiry_information["package"]}
  Promo Code: {$enquiry_information["promo_code"]}
  Number of nights stay: {$enquiry_information["number_of_nights"]}
  Maximum Spend AUD $: {$enquiry_information["spend"]}
  Travel Occasion: {$enquiry_information["travel_occasion"]}
  Deals subscription checked: $is_newsletter_human
  Message:
-------------------------
		
{$enquiry_information["message"]}
		
-------------------------
  Category: {$enquiry_information["category"]}
DOC;
		
		error_log($content_here);
		
		$mail_subject = ucwords($enquiry_category)." - Package: ".$enquiry_information["package"]." - Date: ".$current_date;
		
		wp_mail($multiple_to_recipients, $mail_subject, $content_here);
		
		$contact_message = $enquiry_category;
		
		
		// Mailchimp Add Subscriber part
		
		//if($is_newsletter){
		if(false){
			include_once 'Drewm/MailChimp.php';
		
			$MailChimp = new \Drewm\MailChimp('b54b29c0661fc003f612c8a1526ad5b5-us10');
			$result = $MailChimp->call('lists/subscribe', array(
					'id'                => '0d54271254',
					'email'             => array('email'=> $enquiry_information["email"] ),
					'merge_vars'        => array('FNAME'=>$enquiry_information["first_name"], 'LNAME'=>$enquiry_information["last_name"],'CITYDEPART'=>$enquiry_information["city_depart"]),
					'double_optin'      => false,
					'update_existing'   => true,
					'replace_interests' => false,
					'send_welcome'      => false,
			));
		}
		
		
		wp_redirect( get_home_url(null, "thank-you") );
		exit;
			
	}	
}

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <title>Overwater Bungalows</title>

    <meta name="description" content="We want your honeymoon, anniversary or holiday to be remembered and talked about for a long time, so let us share in your joy and you won’t be disappointed. " />
    <meta name="author" content="">
    <meta name="contact" content="reservations@overwaterbungalows.com.au" />
    <meta name="copyright" content="Copyright (c)<?php echo date("Y"); ?> Overwater Bungalows. All Rights Reserved." />
    <meta name="keywords" content="overwater, bungalow, honeymoon, love, package, cheap, deal" />
    <!-- Favicon-->
    
    <!-- Google Tag Manager -->
<!-- <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-TMG94GS');</script>  -->
<!-- End Google Tag Manager -->
    
   <!-- //// <link rel="shortcut icon" href="<?php echo get_template_directory_uri();?>/images/icon/favicon.ico" type="" /> -->
<style>

</style>
    
    
    
    <?php wp_head(); ?>
    
	<script src='https://www.google.com/recaptcha/api.js' async></script>
	
	<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-91113623-1', 'auto');
  ga('send', 'pageview');

</script>
   
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <script type="text/javascript">
		(function(a,e,c,f,g,b,d){var h={ak:"958318293",cl:"GbOfCP_HxGUQ1Y37yAM"};a[c]=a[c]||function(){(a[c].q=a[c].q||[]).push(arguments)};a[f]||(a[f]=h.ak);b=e.createElement(g);b.async=1;b.src="//www.gstatic.com/wcm/loader.js";d=e.getElementsByTagName(g)[0];d.parentNode.insertBefore(b,d);a._googWcmGet=function(b,d,e){a[c](2,b,h,d,null,new Date,e)}})(window,document,"_googWcmImpl","_googWcmAk","script");
	</script>

  </head>
  <body class="travel-style" onload="_googWcmGet('google-forwarding-number', '1300-256-067')">
  <!-- Google Tag Manager (noscript) -->
<!--  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TMG94GS"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript> -->
<!-- End Google Tag Manager (noscript) -->
  <div id="templatemo_mobile_menu_wap" class="col-xs-12 visible-sm visible-xs">
        <p id="mobile_menu_btn"> <span class="glyphicon glyphicon-align-justify"></span></p>
        <div id="mobile_menu" style="display: none;">
            <div id="mobile_menu_hide_div">
            <ul class="nav nav-stacked">
              <li><a id="mobile_menu_hide_btn" href="#"><span class="glyphicon glyphicon-align-justify"></span></a>
              </li>
            </ul>
            </div>
            <div>
            <!--<form action="<?php echo get_home_url(null,"package-search"); ?>" method="get">                 
                        <div class="date-mobile" >
                          <input class="date-input-top" placeholder="Departure Date" data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-start-date="-1d" name="date" type="text">
                          <input id="des-hidden_mobile" name="des" type="hidden">
                          <input id="des-text-hidden_mobile" name="des-text" type="hidden">
                        </div>
                        <div class="dropdown" >
                        <button class="btn btn-default dropdown-toggle" id="package_dropdown_mobile" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                           Destination
                           <span class="caret"></span>
                        </button>
                        <ul id="package_list_mobile" class="dropdown-menu" role="menu" aria-labelledby="package_dropdown_mobile">
                         
   		    			  <?php 
   		    			  $term_args = array( 'hide_empty=0' );
   					  
   		    			  $terms = get_terms( 'package_taxonomy', $term_args );
   		    			  foreach ( $terms as $term ) {
   		    			  ?>
   	    				  <li role="presentation">
     					  	  <a role="menuitem" tabindex="-1" href="#" data-slug="<?php echo $term->slug; ?>" ><?php echo $term->name; ?></a>
   		    			  </li>
   					  	
   					      <?php
   				    	  }
   				    	  ?>
 					    
 					    </ul>
                        </div>
                        <div class="submit-mobile">
                      
                          <button id="package_search_submit_mobile" class="btn btn-warning submit-mobile-button" type="submit" value="Search">
						    <i class="fa fa-search"></i> Search
					      </button>
                     
                        </div>
 			</form>-->
 			</div>
        
            <ul class="nav nav-pills nav-stacked menu-mobile">
                <li><a id="mobile_menu_phone" class="google-forwarding-number" href="tel:1300256067"> <strong class="fa-phone"> 1300 256 067</strong></a></li>
                <li><a href="<?php echo get_home_url();?>"><strong>Home Page </strong></a></li>
                <!--  <li><a href="http://holidays.overwaterbungalows.com.au/?pl=6"><strong>Holiday</strong></a></li>
                <li><a href="http://honeymoon.overwaterbungalows.com.au/?pl=7"><strong>Honeymoon</strong></a></li> -->
                <?php if(!$hide_enquiry){?> 
                <li><a id="enquiry-button-1" href="<?php echo get_home_url(null,"package-enquiry"); ?>"><strong>ENQUIRY</strong></a></li>
                <?php } ?>
            </ul>
        </div>
  </div>

  <div id="templatemo_banner_top" class="container_wapper " style="background:#fff !important;">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
					<div class="visible-lg visible-md center-block visible-xs visible-sm logo-group-block">
						<a href="<?php echo get_home_url();?>"><img src="<?php bloginfo('template_url'); ?>/images/sitelogo.jpg" alt="logo"/></a>
					</div>
                </div>
                <div class="visible-xs visible-sm hidden-md hidden-lg">
                	<div id="quote-mobile" class="text-center ">
                 		<a class="btn enquiry_anchor book-now1 buton_custom  header_enquiry header_quote" href="http://overwaterbungalows.reslogic.com" >Get a Quote</a> 
                	</div>
                </div>
                <div class="col-md-5 col-lg-3">
                	<div class="prosenjitdiv">  

                     <div class="plan-trip-dropdown btn-group">
                                                 
                           <!--  <a href="javascript:;" class="button button--nanuk button--border-thin button--round-s getquote_anchor quote buton_custom button_effect dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" > -->
							
                           <a href="#package_wrap_anchor" class="button button--nanuk button--border-thin button--round-s getquote_anchor quote buton_custom button_effect" >
							<span>Y</span><span>o</span><span>u</span><span>r</span><span>&nbsp;</span>
							<span>O</span><span>v</span><span>e</span><span>r</span><span>w</span><span>a</span><span>t</span><span>e</span><span>r</span><span>&nbsp;</span>
							<span>S</span><span>p</span><span>e</span><span>c</span><span>i</span><span>a</span><span>l</span><span>i</span><span>s</span><span>t</span><span>s</span>
						   </a>
                           
         					<!--  
                           <ul class="trip dropdown-menu">
                                <li><a href="http://holidays.overwaterbungalows.com.au/?pl=6">Holiday</a></li>
                                <li><a href="http://honeymoon.overwaterbungalows.com.au/?pl=7">Honeymoon</a></li>
                                
                           </ul> 
                           -->
                                                 
                     </div>

                    </div>
                
                </div>
                <div class="col-md-3 col-lg-5 header-p right">
                  <div class="row" style="margin-left: 0px;">
                    
                      <div class="col-lg-1 col-md-1">
                      </div>
                      
                    
                     <!-- <form action="<?php echo get_home_url(null,"package-search"); ?>" method="get">                 
                        <div class="col-md-3 remove-right-padding">
                          <input class="date-input-top" placeholder="Departure Date" data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-start-date="-1d" name="date" type="text">
                          <input id="des-hidden" name="des" type="hidden">
                          <input id="des-text-hidden" name="des-text" type="hidden">
                        </div>
                        <div class="col-md-2 dropdown remove-right-padding">
                        <button class="btn btn-default dropdown-toggle" id="package_dropdown" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                           Destination
                           <span class="caret"></span>
                        </button>
                        <ul id="package_list" class="dropdown-menu" role="menu" aria-labelledby="package_dropdown">
                         
   		    			  <?php 
   		    			  $term_args = array( 'hide_empty=0' );
   					  
   		    			  $terms = get_terms( 'package_taxonomy', $term_args );
   		    			  foreach ( $terms as $term ) {
   		    			  ?>
   	    				  <li role="presentation">
     					  	  <a role="menuitem" tabindex="-1" href="#" data-slug="<?php echo $term->slug; ?>" ><?php echo $term->name; ?></a>
   		    			  </li>
   					  	
   					      <?php
   				    	  }
   				    	  ?>
 					    
 					    </ul>
                        </div>
                        <div class="visible-lg col-lg-1">
                      
                          <button id="package_search_submit1" type="submit" value="Search">
						    <i class="fa fa-search"></i>
					      </button>
                     
                        </div>
                        
                        <div class="visible-md col-md-1">
                      
                          <button id="package_search_submit2" type="submit" value="Search">
						    <i class="fa fa-search"></i>
					      </button>
                     
                        </div>
                        
 					  </form>-->
 					 <div class="row remove-left-padding margin-left-adjust">
<!-- 				    	<a href="<?php echo get_home_url();?>#package_text_anchor" class="getquote_anchor quote buton_custom"  id="SliderPackagesbtn">Plan Your Trip</a> -->
<!-- 				    	<a href="#package_text_anchor" class="getquote_anchor quote buton_custom hidden-sm hidden-xs"  id="SliderPackagesbtn">
                               Packages
                            </a> -->
                           
                       <a class="btn enquiry_anchor book-now1 buton_custom hidden-sm hidden-xs header_enquiry header_quote" href="http://overwaterbungalows.reslogic.com" >Get a Quote</a>       
                      <?php if(!$hide_enquiry){?> 
 				    	<a class="btn enquiry_anchor book-now1 buton_custom hidden-sm hidden-xs hidden-md header_enquiry " href="#" data-toggle="modal" data-target="#enquiryModal" data-package_quote="general"><i class="fa fa-hand-o-right"></i> ENQUIRE</a>  
 				      <?php } ?>
				     	<a class="google-forwarding-number phone-txt mob_txt mob_align hidden-sm hidden-xs hidden-md header_phone " href="tel:1300256067">1300 256 067</a>
				     	
 				     </div>
                   
 				
 					
 				  </div>
                </div>
               
                
            </div>
        </div>
  </div>
  <!--
 <div id="templatemo_banner_logo" class="container_wapper">
        <div class="container">
            <div class="row">
                <div class="visible-lg visible-md center-block logo-group-block">
                    <a href="<?php echo get_home_url();?>"><img src="http://0a7.47f.myftpupload.com/wp-content/uploads/2015/06/WTGLogo-Large1.jpg" alt="logo"/></a>
                    
                </div>
                <div class="visible-xs visible-sm center-block logo-group-block">
                    <img src="http://0a7.47f.myftpupload.com/wp-content/uploads/2015/06/WTGLogo-Large1.jpg" alt="logo"/>
                    
                </div>
                
            </div>
        </div>
  </div>
  -->
   <div class="container banner-fixed-offset">
   <?php

    if(!empty($contact_message)){
    	if($contact_message == "enquiry"){
	        echo do_shortcode('[notification_box]Thank you, your enquiry has been received. One of our consultants will be in touch shortly to answer your questions.[/notification_box]');
    	}
    	else if($contact_message == "booking"){
    		echo do_shortcode('[notification_box]Thank you, your booking request has been received. You will be contacted by our booking agent shortly to confirm your booking.[/notification_box]');
    	}
    	else{
    		echo do_shortcode('[notification_box]Your submission is invalid, please check all fields re-submit.[/notification_box]');
    		 
    	}
    }
   ?>
   </div>
    
   <section class="ads-main-page">

    	<div class="container">

	    	<div class="full" style="padding: 0 0;">

				<div class="ad-detail-content">

	    			