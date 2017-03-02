<?php
/**
 * The template for displaying Category pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage classiads
 * @since classiads 1.2.2
 */

get_header(); 

	global $redux_demo, $maximRange; 
	$max_range = $redux_demo['max_range'];
	if(!empty($max_range)) {
		$maximRange = $max_range;
	} else {
		$maximRange = 1000;
	}
	
	global $listing_query_vars;
	
	if(get_query_var('cat') > 0) {
	
		$listing_query_vars['catSearchID'] = get_query_var('cat');
	
	} else {
		
		$listing_query_vars['catSearchID'] = '-1';
	}

?>
	<div class="ad-title">
	

        	<?php

        		$cat_id = get_cat_ID(single_cat_title('', false));

				$this_category = get_category($cat);

				if ($this_category->category_parent == 0) {

					$tag = $cat_id;

					$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
					if (isset($tag_extra_fields[$tag])) {
						$category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
						$category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
					}

				} else {

					$parent_category = get_category($this_category->category_parent);
					$getParentCatId = $parent_category->cat_ID;

					$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
					if (isset($tag_extra_fields[$getParentCatId])) {
						$category_icon_code = $tag_extra_fields[$getParentCatId]['category_icon_code'];
						$category_icon_color = $tag_extra_fields[$getParentCatId]['category_icon_color'];
					}

				}

				if(!empty($category_icon_code)) {

				?>

				

			<?php } ?>

			<?php

				$cat_id = get_cat_ID(single_cat_title('', false));
			
				$cat_parent_ID = isset( $cat_id->category_parent ) ? $cat_id->category_parent : '';

				if ($cat_parent_ID == 0) {

					$tag = $cat_id;

				} else {

					$tag = $cat_parent_ID;

				}

				$category = get_category($tag);
				$count = $category->category_count;

				$catName = get_cat_name( $tag );

				echo '<h2>';
				echo $catName;
				
											
			?>

			<span class="ad-page-price">

				<?php

					$q = new WP_Query( array(
						'nopaging' => true,
						'tax_query' => array(
							array(
								'taxonomy' => 'category',
								'field' => 'id',
								'terms' => $tag,
								'include_children' => true,
							),
						),
						'fields' => 'ids',
					) );
					$allPosts = $q->post_count;

					echo $allPosts;
				?>

				ads in

				<?php 

					 $args = array(
						'type' => 'post',
						'child_of' => $tag,
						'parent' => get_query_var(''),
						'orderby' => 'name',
						'order' => 'ASC',
						'hide_empty' => 0,
						'hierarchical' => 1,
						'exclude' => '',
						'include' => '',
						'number' => '',
						'taxonomy' => 'category',
						'pad_counts' => true );

					$categories = get_categories($args);

					$subCateCount = 0;

					foreach($categories as $category) {

						$subCateCount++;
														 
					} 

					echo $subCateCount;

				?>

				subcategories

			</span>
			
        </div>


    <section id="big-map">

		<div id="classiads-main-map"></div>

		<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/listing_search.js" ></script>
		
		<!--  Search Bar Panel -->
		
	    <div class="container search-bar">
			<div id="advanced-search-widget-version2" class="home-search">

				<div class="container">

					<div class="advanced-search-widget-content">

						<form action="<?php echo home_url()."/listing-search/"; ?>" method="get" id="views-exposed-form-search-view-other-ads-page" accept-charset="UTF-8">
							
							<div id="edit-field-top-category-wrapper" class="views-exposed-widget views-widget-filter-field_category">
								<div class="views-widget">
									<div class="control-group form-type-select form-item-field-category form-item">
										<div class="controls"> 
											<select id="edit-field-top-category" name="top_category_name" class="form-select" style="display: none;">
														
												<option value="All" data-subcategory="" selected="selected">Select Category</option>
												
							<?php
	
								$args = array(
										'orderby' => 'name',
										'parent' => 0,
										'hide_empty' => 0,
										'hierarchical' => 0
								);
								$categories = get_categories($args);
									
								foreach ($categories as $cat) {
									
									$catID = $cat->cat_ID;
								
									$args1 = array(
											'orderby' => 'name',
											'parent' => $catID,
											'hide_empty' => 0,
											'hierarchical' => 0
									);
									
									$categories1 = get_categories($args1);
									
									//error_log(count($categories1));
									
									
									$subCategoryArr = array();
										
									foreach ($categories1 as $cat1) {
										
										$catID1 = $cat1->cat_ID;
										$catName1 = $cat1->cat_name;
																			
										$subCategoryArr[] = array("catID" => $catID1, "catName" => $catName1);
									}
									
									
								?>
								    
									<option value="<?php echo $cat->cat_ID; ?>" data-subcategory='<?php echo json_encode($subCategoryArr)?>'><?php echo $cat->cat_name; ?></option>
									
								<?php		
								}
								?>

											</select>
										</div>
									</div>
								</div>
							</div>
							
							<div id="edit-field-sub-category-wrapper" class="views-exposed-widget views-widget-filter-field_category">
								<div class="views-widget">
									<div class="control-group form-type-select form-item-field-category form-item">
										<div class="controls"> 
											<select id="edit-field-sub-category" name="sub_category_name" class="form-select" style="display: none;">
														
												<option value="All" selected="selected">Select Sub Category</option>

											</select>
										</div>
									</div>
								</div>
							</div>
							
							<div id="edit-ad-location-wrapper" class="views-exposed-widget views-widget-filter-field_ad_location">
								<div class="views-widget">
									<div class="control-group form-type-select form-item-ad-location form-item">
										<div class="controls"> 
											<select id="edit-ad-location" name="listing_region" class="form-select" style="display: none;">
												<option value="All" selected="selected">Select Region</option>

												<?php

													$region_arr = list_all_regions();
													$region_state_arr = array();

													foreach( $region_arr as $region ) {
														$state = $region->state;
														$region_state_arr[$state][] = $region;
													
													    
													}
													
													foreach ($region_state_arr as $key => $region_subarr){?>
													  <optgroup label="<?php echo $key?>">
													  <?php 
													    foreach ($region_subarr as $region){?>
													    	<option value="<?php echo $region->id; ?>"><?php echo $region->region_name; ?></option>
													  <?php 
													    }
													  ?>
													  </optgroup>
														
													<?php 
													}


												?>
											</select>
										</div>
									</div>
								</div>
							</div>

							


<!-- 							<input type="text" name="geo-location" id="geo-location" value="off" data-default-value="off"> -->

<!-- 							<input type="text" name="geo-radius-search" id="geo-radius-search" value="500" data-default-value="500"> -->

<!-- 							<input type="text" name="geo-search-lat" id="geo-search-lat" value="0" data-default-value="0"> -->

<!-- 							<input type="text" name="geo-search-lng" id="geo-search-lng" value="0" data-default-value="0"> -->

							<div id="edit-search-api-views-fulltext-wrapper" class="views-exposed-widget views-widget-filter-search_api_views_fulltext">
								<div class="views-widget">
									<div class="control-group form-type-textfield form-item-search-api-views-fulltext form-item">
										<div class="controls"> 
											<input placeholder="Enter keyword..." type="text" id="edit-search-api-views-fulltext" name="keyword_all" value="" size="30" maxlength="128" class="form-text">
											<input type="hidden" id="hidden-keyword" name="keyword_all" value="all" size="30" maxlength="128" class="form-text">
										</div>
									</div>
								</div>
							</div>
							
							<div class="views-exposed-widget views-submit-button">
								<button class="btn btn-primary form-submit" id="edit-submit-search-view" name="" value="Search" type="submit"><i class="fa fa-search"></i></button>
							</div>

						</form>
						
					</div>

				</div>

		    </div>
	    </div>

	</section>
	

    <!-- Featured Ads Carousel Panel -->

    <section id="featured-abs">
        
         <div class="container" style="width:100%">
            
              <div id="tabs" class="full">
			    			    	
               
			    <div class="pane">                 
                  

					<div id="projects-carousel">	

			<?php
			    	
			    	global $listing_query_vars;

			    	$listing_query_vars['isfeatured_query'] = true;
			    	
			    	$args = array('post_type' => 'listing',
			    			'posts_per_page' => 20,
			    			'post_status' => 'publish',
			    			'cat' => $listing_query_vars['catSearchID']);
			    		
			    	$car_query = new WP_Query($args);
			    	
			    	$current = -1;
			    	$current2 = 0;
			    	
					$featuredCurrent = 0;
					$emptyPost = 0;

					while ($car_query->have_posts()) : $car_query->the_post(); 
					
					    $emptyPost++;
					    $current++; $current2++; $featuredCurrent++; 
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

	      <?php endwhile; ?>
												
		  <?php wp_reset_query(); ?>

					</div>

		  <?php wp_enqueue_script( 'jquery-carousel', get_template_directory_uri().'/js/jquery.carouFredSel-6.2.1-packed.js', array('jquery'),'',true); ?>
										
					<script>

						jQuery(document).ready(function () {

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

						});
											
					</script>
					<!-- end scripts -->

			    </div>

			    
			    <?php if($emptyPost == 0) { ?>
					<div class="full view-empty">
						<p><?php _e( 'No results found for the selected search criteria.', 'agrg' ); ?></p>
					</div>
				<?php } ?>

			</div>
        
        </div>

    </section>
 

	
	<section class="container">
		<div class="span8 first">
		
	<?php
	$homeAd2='';
		$homeAdImg2= $redux_demo['post_ad']['url']; 
		$homeAdCode2= $redux_demo['post_ad_code']; 
		$homeAdurl= $redux_demo['post_ad_url']; 
		if(!empty($homeAdCode2) || !empty($homeAdImg2)){
			if(!empty($homeAdCode2)){
					$homeAd2 = $homeAdCode2;
			}else{
					$homeAd2 = '<a href="'.$homeAdurl.'"><img src="'.$homeAdImg2.'" /></a>';
			}
		}
	?>
	<div class="cat-page-ad home-page-ad1">				
				<?php echo $homeAd2; ?>
	</div>
		
    <section id="ads-homepage" class="category-page-ads">

	    	<div class="span8 first">
			
				<ul class="tabs quicktabs-tabs quicktabs-style-nostyle clearfix">
				    <div class="three-tabs">
					<li>
						<a class="current" href="#"><?php _e( 'Featured', 'agrg' ); ?></a>
					</li>
					<li>
						<a class="" href="#"><?php _e( 'Highly Rated', 'agrg' ); ?></a>
					</li>
					<li>
						<a class="" href="#"><?php _e( 'All Business', 'agrg' ); ?></a>
					</li>
					</div>
				</ul>

				<div class="pane latest-ads-holder">

					<div class="latest-ads-grid-holder">

					<?php


					global $listing_query_vars, $wp;
					
					$listing_query_vars['isfeatured_query'] = false;
					
					$current_page = (get_query_var('paged')) ? absint(get_query_var('paged')) : 1;
					
					error_log("haha".get_query_var('paged'));
						
						
					$args = array('post_type' => 'listing',
							'posts_per_page'=> 12,
							'paged' => $current_page,
							'post_status' => 'publish',
							'cat' => $listing_query_vars['catSearchID']
						    );
					$the_query = new WP_Query($args);
						
						
					$current = -1;
					$current2 = 0;
					
					$emptyPost2 = 0;
						
						
					
					?>
					
					   <?php 
							require_once(TEMPLATEPATH . "/inc/BFI_Thumb.php");
										
							global $listing_arr;
										
							$listing_arr = array();
							
							$iconPath = get_template_directory_uri(). '/images/icon-services.png';
							
							//listing loop

							while ($the_query->have_posts()) : $the_query->the_post();
								
							
							$current++; $current2++; $emptyPost2++;
							
							$params = array( "width" => 370, "height" => 240, "crop" => true );
							$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "single-post-thumbnail" );
							 
							$listing_permalink = get_permalink();
							$listing_thumb_src = bfi_thumb( "$image[0]", $params );
							$listing_title = get_the_title();
							 
							$data_here = <<<DOC
<div class="marker-holder">
  <div class="marker-content">
    <div class="marker-image">
      <img src="$listing_thumb_src" />
    </div>
    <div class="marker-info-holder">
      <div class="marker-info-price">
        $post_price
      </div>
      <div class="marker-info">
        <div class="marker-info-title">
          <a href="$listing_permalink">
            $listing_title
          </a>
        </div>
		<div id="marker-info-distance-id" class="marker-info-distance">
        </div>
      </div>
	</div>
	<div class="arrow-down"></div>
	<div class="close"></div>
  </div>
</div>
DOC;
							
							
							$listing_profile = array("id" => $post->ID,
									"title" => $post->post_title,
									"contact_name" => $post->contact_name,
									"street_address" => $post->street_address,
									"suburb" => $post->suburb,
									"state" => $post->state,
									"post_code" => $post->post_code,
									"phone_number" => $post->phone_number,
									"region" => $post->region,
									"email_address" => $post->email_address,
									"website_address" => $post->website_address,
									"address" => $post->street_address.", ". $post->suburb. ", ". $post->state." ".$post->post_code.", Australia",
									"latLng" => [ $post->latitude, $post->longitude],
									"options" => [
											"icon" => $iconPath,
											"shadow" => get_template_directory_uri(). "/images/shadow.png",
									],
									"data" => $data_here
							);
							
							if(!empty($post->latitude)&&!empty($post->longitude))
								unset($listing_profile["address"]);
							
							$listing_arr[] = $listing_profile;
							
							
							
							?>
							
								<div class="ad-box span3 latest-posts-grid <?php if($current%3 == 0) { echo 'first'; } ?>">
							
								<?php
									if ( has_post_thumbnail()) {
										$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large');
										echo '<a class="ad-image" href="' .get_permalink($post->ID). '" title="' . the_title_attribute('echo=0') . '" >';
										echo get_the_post_thumbnail($post->ID, '270x220'); 
										echo '</a>';
									}
								?>
								
											    		
								<div class="post-title-cat">
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
							
									  <div class="category-icon-box"><?php $category_icon = stripslashes($category_icon_code); echo $category_icon; ?></div>
							
							  <?php } 
							
									$category_icon_code = "";
							
									?>
							
									</div>
							
											    			
											    			
															
											    		
									<div class="post-title">
										<a href="<?php the_permalink(); ?>"><?php $theTitle = get_the_title(); $theTitle = (strlen($theTitle) > 22) ? substr($theTitle,0,22).'...' : $theTitle; echo $theTitle; ?></a>
									</div>
								</div>
							
								</div>
							
				        <?php 
							
						endwhile; ?>

					</div>
												
				<!-- Begin wpcrown_pagination-->	
				<?php
						
			      $wpcrown_pagination = array(

	                'total' => $the_query->max_num_pages,
	                'current' => $current_page,
	                'show_all' => false,
	                'type' => 'plain',
					'add_args' => $_GET
	              );
			
			      echo '<div class="pagination">' . paginate_links($wpcrown_pagination) . '</div>';
																
			      wp_reset_query(); ?>
			 
			      <?php if($emptyPost2 == 0) { ?>
				    <div class="full view-empty">
					  <p><?php _e( 'No results found for the selected search criteria.', 'agrg' ); ?></p>
				    </div>
				    
			    <?php } ?>

				</div>

				<div class="pane popular-ads-grid-holder">

					<div class="popular-ads-grid">

						<?php

							global $paged, $wp_query, $wp;

							$args = wp_parse_args($wp->matched_query);

							if ( !empty ( $args['paged'] ) && 0 == $paged ) {

								$wp_query->set('paged', $args['paged']);

								$paged = $args['paged'];

							}

							$cat_id = get_cat_ID(single_cat_title('', false));


							$current = -1;
							$current2 = 0;


							$popularpost = new WP_Query( array( 'posts_per_page' => '12', 'cat' => $cat_id, 'posts_type' => 'post', 'paged' => $paged, 'meta_key' => 'wpb_post_views_count', 'orderby' => 'meta_value_num', 'order' => 'DESC'  ) );				

							while ( $popularpost->have_posts() ) : $popularpost->the_post(); $current++; $current2++;

							?>

							<div class="ad-box span3 popular-posts-grid <?php if($current%3 == 0) { echo 'first'; } ?>">

							<?php
								if ( has_post_thumbnail()) {
								   $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large');
								   echo '<a class="ad-image" href="' .get_permalink($post->ID). '" title="' . the_title_attribute('echo=0') . '" >';
								   echo get_the_post_thumbnail($post->ID, '270x220'); 
								   echo '</a>';
								 }
							?>

				    			<?php
								$post_price = get_post_meta($post->ID, 'post_price', true);
								if(!empty($post_price)){								
								?>
								<div class="add-price"><span><?php echo $post_price; ?></span></div> 
								<?php } ?>
				    		
							<div class="post-title-cat">
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

						        	<div class="category-icon-box"><?php $category_icon = stripslashes($category_icon_code); echo $category_icon; ?></div>

						        	<?php } 

						        	$category_icon_code = "";

						        	?>

				    			</div>

				    			
				    			
								
				    		
								<div class="post-title">
									<a href="<?php the_permalink(); ?>"><?php $theTitle = get_the_title(); $theTitle = (strlen($theTitle) > 22) ? substr($theTitle,0,22).'...' : $theTitle; echo $theTitle; ?></a>
								</div>
							</div>

						</div>

						<?php endwhile; ?>

					</div>
												
					<!-- Begin wpcrown_pagination-->	
					<?php get_template_part('pagination'); ?>
					<!-- End wpcrown_pagination-->	
																	
					<?php wp_reset_query(); ?>

				</div>

				<div class="pane random-ads-grid-holder">

					<div class="random-ads-grid">

						<?php

						global $paged, $wp_query, $wp;

						$args = wp_parse_args($wp->matched_query);

						if ( !empty ( $args['paged'] ) && 0 == $paged ) {

							$wp_query->set('paged', $args['paged']);

							$paged = $args['paged'];

						}

						$cat_id = get_cat_ID(single_cat_title('', false));

						$temp = $wp_query;

						$wp_query= null;

						$wp_query = new WP_Query();

						$wp_query->query('orderby=title&post_type=post&posts_per_page=12&paged='.$paged.'&cat='.$cat_id);

						$current = -1;
						$current2 = 0;

						?>

						<?php while ($wp_query->have_posts()) : $wp_query->the_post(); $current++; $current2++; ?>

							<div class="ad-box span3 random-posts-grid <?php if($current%3 == 0) { echo 'first'; } ?>">

							<?php
								if ( has_post_thumbnail()) {
								   $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large');
								   echo '<a class="ad-image" href="' .get_permalink($post->ID). '" title="' . the_title_attribute('echo=0') . '" >';
								   echo get_the_post_thumbnail($post->ID, '270x220'); 
								   echo '</a>';
								 }
							?>

				    						    			<?php
								$post_price = get_post_meta($post->ID, 'post_price', true);
								if(!empty($post_price)){								
								?>
								<div class="add-price"><span><?php echo $post_price; ?></span></div> 
								<?php } ?>
				    		
							<div class="post-title-cat">
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

						        	<div class="category-icon-box"><?php $category_icon = stripslashes($category_icon_code); echo $category_icon; ?></div>

						        	<?php } 

						        	$category_icon_code = "";

						        	?>

				    			</div>

				    			
				    			
								
				    		
								<div class="post-title">
									<a href="<?php the_permalink(); ?>"><?php $theTitle = get_the_title(); $theTitle = (strlen($theTitle) > 22) ? substr($theTitle,0,22).'...' : $theTitle; echo $theTitle; ?></a>
								</div>
							</div>
						</div>

						<?php endwhile; ?>

					</div>
												
					<!-- Begin wpcrown_pagination-->	
					<?php get_template_part('pagination'); ?>
					<!-- End wpcrown_pagination-->	
																	
					<?php wp_reset_query(); ?>

				</div>

	    	</div>

	    	


    </section>
	</div>
	<div class="span4">

		    	<div class="cat-widget custom-widget">
				
					<h3><?php _e( 'SUBCATEGORIES', 'agrg' ); ?></h3>
					<div class="h3-seprator-sidebar"></div>
		    		<div class="cat-widget-content">

		    			<ul> 

						  	<?php 

						  		$args = array(
									'type' => 'post',
									'child_of' => $tag,
									'parent' => get_query_var(''),
									'orderby' => 'name',
									'order' => 'ASC',
									'hide_empty' => 0,
									'hierarchical' => 1,
									'exclude' => '',
									'include' => '',
									'number' => '',
									'taxonomy' => 'category',
									'pad_counts' => true );

								$categories = get_categories($args);
								
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

										

						        	

								foreach($categories as $category) { ?>

								<li>
									<?php
									if(!empty($category_icon_code)) {

									?>

						        	<div class="category-icon-box"><?php $category_icon = stripslashes($category_icon_code); echo $category_icon; ?></div>

						        	<?php } ?>
						  			<a href="<?php echo get_category_link( $category->term_id )?>" title="View posts in <?php echo $category->name?>"><?php echo $category->name ?></a>

						  			<span class="category-counter"><?php echo $category->count ?></span>

						  		</li>

							<?php } ?>         
						  									
						</ul>

		    		</div>

		    	</div>

		    	<?php get_sidebar('pages'); ?>

	    	</div>
		
	</section>
	
    <script type="text/javascript">

        jQuery(document).ready(function($){

          var listing_arr = new Array();

          <?php $json_listing = json_encode($listing_arr);

          ?>

          gm_listing = new GooglemapListing(<?php echo $json_listing?>);
        });

		// perform JavaScript after the document is scriptable.
		jQuery(document).ready(function ($) {
			
			jQuery("ul.tabs").tabs("> .pane", {effect: 'fade', fadeIn: 200});

			$('#edit-field-top-category').change(function(){

				$('#edit-field-sub-category option:gt(0)').remove();

				var sub_category_obj = $("#edit-field-top-category option:selected").data("subcategory");

				$.each(sub_category_obj, function(index,ele){

					var option = $('<option></option>').attr("value", ele.catID).text(ele.catName);
					$("#edit-field-sub-category").append(option);


				});

				$('.form-select').trigger('chosen:updated');

			});

			var autocomplete_op = {
					source: function(request, response) {

						$.getJSON( "<?php echo admin_url( 'admin-ajax.php' );?>", {
							            'action': 'keyword_suggestion',
							            'keyword': request.term
						               }, 
						  function(data) {
							response(data);
						  }
			            );
				    },
				    
			        delay: 500,
			        minLength: 3
			    };

			$("#edit-search-api-views-fulltext").autocomplete(autocomplete_op);
			
		});
	</script>

<?php get_footer(); ?>