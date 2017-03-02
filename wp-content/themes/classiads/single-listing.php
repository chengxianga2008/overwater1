<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage classiads
 * @since classiads 1.2.2
 */
get_header(); ?>
	
	<?php while ( have_posts() ) : the_post(); ?>


<?php 

global $redux_demo; 

global $current_user; get_currentuserinfo(); $user_ID == $current_user->ID;

$contact_email = get_the_author_meta( 'user_email', $user_ID );
$wpcrown_contact_email_error = $redux_demo['contact-email-error'];
$wpcrown_contact_name_error = $redux_demo['contact-name-error'];
$wpcrown_contact_message_error = $redux_demo['contact-message-error'];
$wpcrown_contact_thankyou = $redux_demo['contact-thankyou-message'];

global $nameError;
global $emailError;
global $commentError;
global $subjectError;
global $humanTestError;

//If the form is submitted
if(isset($_POST['submitted'])) {
	
		//Check to make sure that the name field is not empty
		if(trim($_POST['contactName']) === '') {
			$nameError = $wpcrown_contact_name_error;
			$hasError = true;
		} elseif(trim($_POST['contactName']) === 'Name*') {
			$nameError = $wpcrown_contact_name_error;
			$hasError = true;
		}	else {
			$name = trim($_POST['contactName']);
		}

		//Check to make sure that the subject field is not empty
		if(trim($_POST['subject']) === '') {
			$subjectError = $wpcrown_contact_subject_error;
			$hasError = true;
		} elseif(trim($_POST['subject']) === 'Subject*') {
			$subjectError = $wpcrown_contact_subject_error;
			$hasError = true;
		}	else {
			$subject = trim($_POST['subject']);
		}
		
		//Check to make sure sure that a valid email address is submitted
		if(trim($_POST['email']) === '')  {
			$emailError = $wpcrown_contact_email_error;
			$hasError = true;
		} else if (!eregi("^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,4}$", trim($_POST['email']))) {
			$emailError = $wpcrown_contact_email_error;
			$hasError = true;
		} else {
			$email = trim($_POST['email']);
		}
			
		//Check to make sure comments were entered	
		if(trim($_POST['comments']) === '') {
			$commentError = $wpcrown_contact_message_error;
			$hasError = true;
		} else {
			if(function_exists('stripslashes')) {
				$comments = stripslashes(trim($_POST['comments']));
			} else {
				$comments = trim($_POST['comments']);
			}
		}

		//Check to make sure that the human test field is not empty
		if(trim($_POST['humanTest']) != '8') {
			$humanTestError = "Not Human :(";
			$hasError = true;
		} else {

		}
			
		//If there is no error, send the email
		if(!isset($hasError)) {

			$emailTo = $contact_email;
			$subject = $subject;	
			$body = "Name: $name \n\nEmail: $email \n\nMessage: $comments";
			$headers = 'From <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;
			
			wp_mail($emailTo, $subject, $body, $headers);

			$emailSent = true;

	}
}

?>
	   <section class="ads-main-page">
			<div class="container">
					<?php
					if ( get_post_status ( $post->ID ) == 'private' ) {
					echo do_shortcode('[notification_box]Congratulations! Your business has been submitted and is pending review. After your business is approved, your ad will be live for all users. You cannot edit your business page until it has been approved.[/notification_box]');
					}
					?>
				</div>
				<div class="ad-title">
				<?php global $current_user; get_currentuserinfo(); 
						if ($post->post_author == $current_user->ID && get_post_status ( $post->ID ) == 'publish') { ?>

						<?php 
							$edit_post_page_id = $redux_demo['edit_post'];
							$postID = $post->ID;

							global $wp_rewrite;
							if ($wp_rewrite->permalink_structure == '')
							//we are using ?page_id
								$edit_post = $edit_post_page_id."&post=".$postID;
							else
							//we are using permalinks
								$edit_post = $edit_post_page_id."?post=".$postID;

							?>
							<a style="text-transform:capitalize;font-size:24px !important;color:#ccc" href="<?php echo $edit_post; ?>">Edit</a>
							

						<?php } ?> 
					<h2><?php the_title(); ?>
						<span class="ad-page-price">
						<?php $category = get_the_category();				
									if ($category) {
										echo '<a href="' . get_category_link( $category[0]->term_id ) . '" title="' . sprintf( __( "View all posts in %s", "agrg" ), $category[0]->name ) . '" ' . '>' . $category[0]->name.'</a> ';
									}
								?>
						</span>
					</h2>
				</div>

    	<div class="container">

	    	<div class="span8 first">
			
				<?php
				$attachments = get_children(array('post_parent' => $post->ID,
							'post_status' => 'inherit',
							'post_type' => 'attachment',
							'post_mime_type' => 'image',
							'order' => 'ASC',
							'orderby' => 'menu_order ID'));	
				if(!empty($attachments)){
				?>
				<style scoped>.frame {height: 470px;line-height: 470px;overflow: hidden;}</style>
				<?php
				}
				?>
				<div class="single-slider">
					<div class="frame" id="basic">
						<ul class="clearfix">
							<?php require_once(TEMPLATEPATH . '/inc/BFI_Thumb.php'); ?>

								<?php 

								$params = array( 'width' => 770, 'height' => 500, 'crop' => true );
								$params_small = array( 'width' => 100, 'height' => 70, 'crop' => true );

													

								foreach($attachments as $att_id => $attachment) {

									$full_img_url = wp_get_attachment_url($attachment->ID);

									echo "<li><img src='" . bfi_thumb( $full_img_url, $params ) . "', data-big='" . $full_img_url . "'' ></li>";
									

								} 

							?>
							</ul>
						<?php $post_price = get_post_meta($post->ID, 'post_price', true);
						if(!empty($post_price)){
						?>
						<div class="single-ad-price">
							<?php echo $post_price; ?>
						</div>
						<?php } ?>
				</div>
					 <ul class="pages"></ul>
					<div class="clearfix"></div>
				</div>
	    		<?php 

	    			$post_video = get_post_meta($post->ID, 'post_video', true);

	    			if(!empty($post_video)) {

	    		?>

	    		<div id="ab-video-text"><span><i class="fa fa-youtube-play"></i><?php _e( 'Video', 'agrg' ); ?></span></div>

	    		<div id="ab-video"><?php echo $post_video; ?></div>

	    		<?php } ?>
					<div class="post-detail">
						<div class="detail-cat clearfix">
								<?php
									$category = get_the_category();
									
									if ($category[0]->category_parent == 0) {

											$tag = $category[0]->cat_ID;

											$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
											if (isset($tag_extra_fields[$tag])) {
											    $category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
											    $category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
											}

										} else {

											$tag = $category[0]->category_parent;

											$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
											if (isset($tag_extra_fields[$tag])) {
											    $category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
											    $category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
											}

										}
								?>
								<div class="category-icon">
									<?php if(!empty($category_icon_code)) { ?>

										<div class="category-icon-box"><?php $category_icon = stripslashes($category_icon_code); echo $category_icon; ?></div>

									<?php } ?>
								</div>
				    			<?php 
								
									
									if ($category) {
										echo '<a href="' . get_category_link( $category[0]->term_id ) . '" title="' . sprintf( __( "View all posts in %s", "agrg" ), $category[0]->name ) . '" ' . '>' . $category[0]->name.'</a> ';
									}
								?>
							</div>	
				
				<table class="ad-detail-half-box first-half">
					
					<tr>
						<td>
						
							<?php
							    $listing_meta_obj =  get_listing_meta_by_postId($post->ID);
							    global $comment_rating_post_id;
							    $comment_rating_post_id = $post->ID;
							    
							?>

							<span class="ad-detail-info"><?php _e( 'Address', 'agrg' ); ?> 
							  <span class="ad-detail"><span class="bold-txt">
						    	  <?php echo $listing_meta_obj->street_address; ?>
						        </span>
						        <br>
						        <?php echo $listing_meta_obj->suburb; ?>
						        ,
						        <?php echo $listing_meta_obj->state; ?>
						        <?php echo $listing_meta_obj->post_code; ?>
						        
						      </span>
							</span>
							
							<span class="ad-detail-info"><?php _e( 'Region', 'agrg' ); ?> <span class="ad-detail">
						    	<?php echo $listing_meta_obj->region; ?></span>
							</span>
							
							
							<span class="ad-detail-info"><?php _e( 'Phone', 'agrg' ); ?> <a class="ad-detail" href="tel:<?php echo $listing_meta_obj->phone_number; ?>">
						    	<?php echo $listing_meta_obj->phone_number; ?></a>
							</span>
							
							<span class="ad-detail-info"><?php _e( 'Email', 'agrg' ); ?> <a class="ad-detail" href="mailto:<?php echo $listing_meta_obj->email_address; ?>">
						    	<?php echo $listing_meta_obj->email_address; ?></a>
							</span>
							
							<span class="ad-detail-info"><?php _e( 'Website', 'agrg' ); ?> <a class="ad-detail" href="<?php
							  $http_webaddress = $listing_meta_obj->website_address;
							  $pos = strpos($http_webaddress, "http");
							  
							  if($pos === false){
							  	$http_webaddress = "http://".$http_webaddress;
							  }
							  
							  echo $http_webaddress; 
							?>" target="_blank">
						    	<?php echo $listing_meta_obj->website_address; ?></a>
							</span>
							
							<span class="ad-detail-info"><?php _e( 'Listing Type', 'agrg' ); ?> <span class="ad-detail">
						    	<?php

						    	$product_txt = $listing_meta_obj->product;
						    	
						    	switch ($product_txt){
						    		case "top_of_list": 
						    			$product_txt = "Top of List";
						    			break;
						    		case "priority":
						    			$product_txt = "Priority";
						    			break;
						    		case "basic":
						    			$product_txt = "Basic";
						    			break;
						    		case "free":
						    			$product_txt = "Free";
						    			break;
						    		default :
						    	}
						    	
						    	echo $product_txt; ?></span>
							</span>
							
							<span class="ad-detail-info"><?php _e( 'Added', 'agrg' ); ?> <span class="ad-detail">
						    	<?php the_time('M j, Y') ?></span>
							</span>
							
							
							<span class="ad-detail-info"><?php _e( 'Views', 'agrg' ); ?> <span class="ad-detail">
				    			<?php echo wpb_get_post_views(get_the_ID()); ?></span>
							</span>


							<?php if(function_exists('the_ratings')) { ?>

								<span class="ad-detail-info"><?php _e( 'Rating', 'agrg' ); ?> 
									<span class="ad-detail"><?php the_ratings('div', 0, true, false, false); ?></span>
								</span>

							<?php } ?>
							
						</td>
					</tr>
				</table>
				<table class="ad-detail-half-box">
					
					<tr>
						<td>
								<div class="ad-detail-info description">
									<div class="description"><?php _e( 'DESCRIPTION:', 'agrg' ); ?> </div>
									<?php echo the_content(); ?>
								</div>
								<div class="ads-tags">

									<i class="fa fa-tags"></i><span class="tag-title"><a>Tags:</a></span><span><?php the_tags('','',''); ?></span>
								</div>
								<div class="social-single">
									<a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" target="_blank">
										<img src="<?php echo get_template_directory_uri(); ?>/images/fb-share.png" alt="Share on facebook" />
									</a>
									<a href="https://twitter.com/home?status=http://demo.designinvento.net/" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" target="_blank">
										<img src="<?php echo get_template_directory_uri(); ?>/images/twitter-share.png" alt="Share on Twitter" />
									</a>
								</div>
							</td>
					</tr>
				</table>
				<div class="clearfix"></div>
	    		<?php

					$post_latitude = $listing_meta_obj->latitude;
 	                $post_longitude = $listing_meta_obj->longitude;
					$post_street_address = $listing_meta_obj->street_address;
                    $post_suburb = $listing_meta_obj->suburb;
                    $post_state = $listing_meta_obj->state;
                    $post_post_code = $listing_meta_obj->post_code;
 	                $post_address = "$post_street_address, $post_suburb $post_state $post_post_code, Australia";

					if(!empty($post_latitude)) {

				?>
				
			    <div id="single-page-map">			    	

					<div id="single-page-main-map"></div>

					<script type="text/javascript">
					var mapDiv,
						map,
						infobox;
					jQuery(document).ready(function($) {

						mapDiv = $("#single-page-main-map");
						mapDiv.height(400).gmap3({
							map: {
								options: {
									"center": [<?php echo $post_latitude; ?>,<?php echo $post_longitude; ?>]
									,"zoom": 16
									,"draggable": true
									,"mapTypeControl": true
									,"mapTypeId": google.maps.MapTypeId.ROADMAP
									,"scrollwheel": false
									,"panControl": true
									,"rotateControl": false
									,"scaleControl": true
									,"streetViewControl": true
									,"zoomControl": true
									<?php global $redux_demo; $map_style = $redux_demo['map-style']; if(!empty($map_style)) { ?>,"styles": <?php echo $map_style; ?> <?php } ?>
								}
							}
							,marker: {
								values: [

								<?php

									$post_latitude = get_post_meta($post->ID, 'post_latitude', true);
									$post_longitude = get_post_meta($post->ID, 'post_longitude', true);

									$theTitle = get_the_title(); $theTitle = (strlen($theTitle) > 40) ? substr($theTitle,0,37).'...' : $theTitle;

									$post_price = get_post_meta($post->ID, 'post_price', true);

									$category = get_the_category();

									if ($category[0]->category_parent == 0) {

										$tag = $category[0]->cat_ID;

										$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
										if (isset($tag_extra_fields[$tag])) {
											$your_image_url = $tag_extra_fields[$tag]['your_image_url']; //i added this line.
										}

									} else {

										$tag = $category[0]->category_parent;

										$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
										if (isset($tag_extra_fields[$tag])) {
											$your_image_url = $tag_extra_fields[$tag]['your_image_url']; //i added this line.
										}

									}

									if(!empty($your_image_url)) {

								    	$iconPath = $your_image_url;

								    } else {

								    	$iconPath = get_template_directory_uri() .'/images/icon-services.png';

								    }

									?>

										 	{
										 		<?php require_once(TEMPLATEPATH . "/inc/BFI_Thumb.php"); ?>
												<?php $params = array( "width" => 560, "height" => 390, "crop" => true ); $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "single-post-thumbnail" ); ?>

												latLng: [<?php echo $post_latitude; ?>,<?php echo $post_longitude; ?>],
												options: {
													icon: "<?php echo $iconPath; ?>",
													shadow: "<?php echo get_template_directory_uri() ?>/images/shadow.png",
												},
												data: '<div class="marker-holder"><div class="marker-content"><div class="marker-image"><img src="<?php echo bfi_thumb( "$image[0]", $params ) ?>" /></div><div class="marker-info-holder"><div class="marker-info"><div class="marker-info-title"><?php echo $theTitle; ?></div><div class="marker-info-extra"><div class="marker-info-price"><?php echo $post_price; ?></div><div class="marker-info-link"><a href="<?php the_permalink(); ?>"><?php _e( "Details", "agrg" ); ?></a></div></div></div></div><div class="arrow-down"></div><div class="close"></div></div></div>'
											}	
									
								],
								options:{
									draggable: false
								},
								cluster:{
					          		radius: 20,
									// This style will be used for clusters with more than 0 markers
									0: {
										content: "<div class='cluster cluster-1'>CLUSTER_COUNT</div>",
										width: 62,
										height: 62
									},
									// This style will be used for clusters with more than 20 markers
									20: {
										content: "<div class='cluster cluster-2'>CLUSTER_COUNT</div>",
										width: 82,
										height: 82
									},
									// This style will be used for clusters with more than 50 markers
									50: {
										content: "<div class='cluster cluster-3'>CLUSTER_COUNT</div>",
										width: 102,
										height: 102
									},
									events: {
										click: function(cluster) {
											map.panTo(cluster.main.getPosition());
											map.setZoom(map.getZoom() + 2);
										}
									}
					          	},
								events: {
									click: function(marker, event, context){
										map.panTo(marker.getPosition());

										var ibOptions = {
										    pixelOffset: new google.maps.Size(-125, -88),
										    alignBottom: true
										};

										infobox.setOptions(ibOptions)

										infobox.setContent(context.data);
										infobox.open(map,marker);

										// if map is small
										var iWidth = 560;
										var iHeight = 560;
										if((mapDiv.width() / 2) < iWidth ){
											var offsetX = iWidth - (mapDiv.width() / 2);
											map.panBy(offsetX,0);
										}
										if((mapDiv.height() / 2) < iHeight ){
											var offsetY = -(iHeight - (mapDiv.height() / 2));
											map.panBy(0,offsetY);
										}

									}
								}
							}
							 		 	});

						map = mapDiv.gmap3("get");

					    infobox = new InfoBox({
					    	pixelOffset: new google.maps.Size(-50, -65),
					    	closeBoxURL: '',
					    	enableEventPropagation: true
					    });
					    mapDiv.delegate('.infoBox .close','click',function () {
					    	infobox.close();
					    });

					    if (Modernizr.touch){
					    	map.setOptions({ draggable : false });
					        var draggableClass = 'inactive';
					        var draggableTitle = "Activate map";
					        var draggableButton = $('<div class="draggable-toggle-button '+draggableClass+'">'+draggableTitle+'</div>').appendTo(mapDiv);
					        draggableButton.click(function () {
					        	if($(this).hasClass('active')){
					        		$(this).removeClass('active').addClass('inactive').text("Activate map");
					        		map.setOptions({ draggable : false });
					        	} else {
					        		$(this).removeClass('inactive').addClass('active').text("Deactivate map");
					        		map.setOptions({ draggable : true });
					        	}
					        });
					    }

					});
					</script>
				<div id="ad-address"><span><i class="fa fa-map-marker"></i><?php echo $post_address; ?></span></div>
				</div>

				<?php } ?>
				</div>
				<div class="clearfix"></div>
					<div class="author-info clearfix">
						<div class="author-avatar">
				    			<?php require_once(TEMPLATEPATH . '/inc/BFI_Thumb.php');
				    			$authorId = get_the_author_meta( 'ID' ); ?>
			    			<?php 

								$author_avatar_url = get_user_meta($authorId, "flatads_author_avatar_url", true); 

								if(!empty($author_avatar_url)) {

									$params = array( 'width' => 150, 'height' => 150, 'crop' => true );

									echo "<img src='" . bfi_thumb( "$author_avatar_url", $params ) . "' alt='' />";

								} else { 

							?>

								<?php $avatar_url = wpcook_get_avatar_url ( get_the_author_meta('user_email'), $size = '150' ); ?>
								<img src="<?php echo $avatar_url; ?>" alt="" />

							<?php } ?>
				    		</div>
							
						<div class="author-detail-right clearfix">

				    		<?php $curauth = get_user_by( 'id', $authorId); // get the info about the current author ?>
																		
							<?php
								$wpcrown_author_email = $curauth->user_email;
																																
								if(!empty($wpcrown_author_email)) {
							?>
								<span class="ad-detail-info">
					    			<span class="ad-details"><i class="fa fa-mail-forward"></i>Email: <a href="<?php echo "mailto:".$wpcrown_author_email; ?>"> <?php echo $wpcrown_author_email; ?> </a></span>
								</span>
							<?php
								} 		
							?>


				    		<?php $curauth = get_user_by( 'id', $authorId ); // get the info about the current author ?>
																		
							<?php
																			
								$wpcrown_author_phone = $curauth->phone;
																																
								if(!empty($wpcrown_author_phone)) {
							?>
								<span class="ad-detail-info"> 
				    				<span class="ad-details"><i class="fa fa-phone"></i>Phone: <?php echo $wpcrown_author_phone; ?></span>
								</span>
							<?php
								} 		
							?>

							<?php $curauth = get_user_by( 'id', $authorId ); // get the info about the current author ?>
																		
							<?php
								$wpcrown_author_web = $curauth->user_url;
																																
								if(!empty($wpcrown_author_web)) {
							?>
								<span class="ad-detail-info">
					    			<span class="ad-details"><i class="fa fa-globe"></i>Website: <a href="<?php echo $wpcrown_author_web; ?>"><?php echo $wpcrown_author_web; ?></a></span>
								</span>
							<?php } ?>
							</div>
							<div class="ad-detail-info author-btn">
								<span class="author-profile-ad-details"><a href="<?php echo site_url('contributor')."?contributor_name=".get_the_author_meta( 'user_nicename' ); ?>" class="button-ag large green"><span class="button-inner"><?php echo get_the_author_meta('display_name'); ?></span></a></span>
							</div>
					</div>

				<div class="ad-detail-content">	    			
	    			<?php wp_link_pages(); ?>

	    		</div>
	    		
	    		<div id="ad-comments">
					
	    			<?php comments_template(); ?>

	    		</div>
	
	    	</div>

			<div class="span4">
			
				<div class="related-abs">
				
	    			<h3><?php _e( 'RELATED LISTINGS', 'agrg' ); ?></h3>
					<div class="h3-seprator-sidebar"></div>
	    			<div class="frame-related" id="basic-related">
						<ul class="clearfix">

	    				<?php  
							$orig_post = $post;  
							global $post;  
							$tags = wp_get_post_tags($post->ID);  
										      
							if ($tags) {  
								$tag_ids = array();  
								foreach($tags as $individual_tag) 
								$tag_ids[] = $individual_tag->term_id; 
									
								$args=array(  
								    'tag__in' => $tag_ids,  
								    'post__not_in' => array($post->ID),  
								    'posts_per_page'=>3, // Number of related posts to display.  
								    'ignore_sticky_posts'=>1  
								);  

								$current = -1;
								      
								$my_query = new wp_query( $args );  
								while( $my_query->have_posts() ) { 

								    $my_query->the_post();  
								    global $postID;

								    $current++;
									
									$category = get_the_category();
									
									$tag = get_cat_ID( $category[0]->name );
									$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
									if (isset($tag_extra_fields[$tag])) {
										$category_icon_code = $tag_extra_fields[$tag]['category_icon_code']; 
										$category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
									}
								
								?>  
		    						
		    						
								<li>
		    					<a href="<?php the_permalink(); ?>">
		    					<?php 

		    					$thumb_id = get_post_thumbnail_id();
								$thumb_url = wp_get_attachment_image_src($thumb_id,'thumbnail-size', true);

								$params = array( 'width' => 255, 'height' => 218, 'crop' => true );
								echo "<img src='" . bfi_thumb( "$thumb_url[0]", $params ) . "'/>";

								?></a>
								</li>
		    					

		    			<?php 	}  
							}  
							$post = $orig_post;  
							wp_reset_query();  
						?>
						</ul>		
										

		    		</div>
					<ul class="pages"></ul>
	    		</div>
				
				<?php get_sidebar('pages'); ?>

	    	</div>

		    	

	    </div>



    </section>
	


    <?php endwhile; ?>
	
	    <?php 

		global $redux_demo; 

		$featured_ads_option = $redux_demo['featured-options-on'];

	?>

	<?php if($featured_ads_option == 1) { ?>

    <section id="featured-abs">
        
        <div class="container" style="width:100%">
            
            <div id="tabs" class="full">
			    	
                <?php $cat_id = get_cat_ID(single_cat_title('', false)); ?>
			    

                <div class="pane">
                 
                  	<div id="projects-carousel">

			    		<?php

							global $paged, $wp_query, $wp;

							$args = wp_parse_args($wp->matched_query);

							$temp = $wp_query;

							$wp_query= null;

							$wp_query = new WP_Query();

							$wp_query->query('post_type=post&posts_per_page=-1');

							$current = -1;

						?>

						<?php while ($wp_query->have_posts()) : $wp_query->the_post();

							$featured_post = "0";

							$post_price_plan_activation_date = get_post_meta($post->ID, 'post_price_plan_activation_date', true);
							$post_price_plan_expiration_date = get_post_meta($post->ID, 'post_price_plan_expiration_date', true);
							$post_price_plan_expiration_date_noarmal = get_post_meta($post->ID, 'post_price_plan_expiration_date_normal', true);
							$todayDate = strtotime(date('m/d/Y h:i:s'));
							$expireDate = $post_price_plan_expiration_date;

							if(!empty($post_price_plan_activation_date)) {

								if(($todayDate < $expireDate) or $post_price_plan_expiration_date == 0) {
									$featured_post = "1";
								}

						} ?>

						<?php if($featured_post == "1") { 

							$current++;

						?>

						<div class="ad-box span3">
							<?php
								if ( has_post_thumbnail()) {
								   $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large');
								   echo '<a class="ad-image" href="' .get_permalink($post->ID). '" title="' . the_title_attribute('echo=0') . '" >';
								   echo get_the_post_thumbnail($post->ID, 'premium-post-image'); 
								   echo '</a>';
								 }
							?>
			    			

			    			<div class="ad-hover-content">
			    				<div class="ad-category">
			    					
			    					<?php
 
						        		$category = get_the_category();

						        		if ($category[0]->category_parent == 0) {

											$tag = $category[0]->cat_ID;

											$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
											if (isset($tag_extra_fields[$tag])) {
											    $category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
											    $category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
											}

										} else {

											$tag = $category[0]->category_parent;

											$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
											if (isset($tag_extra_fields[$tag])) {
											    $category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
											    $category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
											}

										}

										if(!empty($category_icon_code)) {

									?>

					        		<div class="category-icon-box" ><?php $category_icon = stripslashes($category_icon_code); echo $category_icon; ?></div>

					        		<?php } 

					        		$category_icon_code = "";

					        		?>

			    				</div>
								
								
								<div class="post-title">
									<a href="<?php the_permalink(); ?>"><?php $theTitle = get_the_title(); $theTitle = (strlen($theTitle) > 40) ? substr($theTitle,0,37).'...' : $theTitle; echo $theTitle; ?></a>
								</div>
								
							</div>	
							<div class="ad-hover-content-class"></div>
			    				

			    			

						</div>

			    		<?php } ?>

			    		<?php endwhile; ?>	
												
						<?php wp_reset_query(); ?>

			    	</div>

			    	<?php wp_enqueue_script( 'jquery-carousel', get_template_directory_uri().'/js/jquery.carouFredSel-6.2.1-packed.js', array('jquery'),'',true); ?>
										
					<script>

						jQuery(document).ready(function ($) {

							jQuery('#projects-carousel').carouFredSel({
								auto: true,
								prev: '#carousel-prev',
								next: '#carousel-next',
								pagination: "#carousel-pagination",
								mousewheel: true,
								scroll: 2,
								swipe: {
									onMouse: true,
									onTouch: true
								}
							});

							$("#commentform").validate({
								    ignore: [],
								    rules: {
								    	rating_value: {
								    		required: true,
											range: [1, 5]
								    	}
								    },

								 
									messages: {
										rating_value: {
											      range: "Please rate the listing"
										},
										comment: {
										          required: "Please type in comment",
										          minlength: "Comment must consist of at least 50 characters"
										}
									} 
							});

							$(".post-ratings img").click(function(){
								console.log("click");
								$("#rating_value").valid();
							});
						    
					    });
											
					</script>
					<!-- end scripts -->

			    </div>

			    

			</div>
        
        </div>

    </section>

    <?php } ?>

<?php get_footer(); ?>