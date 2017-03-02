<?php

/**

 * The Template for displaying home page.

 *

 * @package WordPress

 * @subpackage classiads

 * @since classiads 1.2.2

 */

?>



<?php include_once "template-travel-header.php";?>



<?php

echo do_shortcode('[layerslider id="294"]');

?>


<div id="templatemo_Search_Box" class="">

	<div class="row">

		<div class="col-md-12 col-sm-12 col-xs-12 header-p right">


			<div class="row">

				<!--                    <div class="visible-lg visible-md frame4" ><center><iframe id="wtg" width="970" scrolling="No" height="80" frameborder="0" z-index:0="" style="padding:0px;"    src="http://worldtravelgroup.reslogic.com/?pl=555&tpl=TQW_IFRAME&iframe"></iframe></center></div> 
                  
                    <div class="visible-sm visible-xs frame4" ><center><iframe id="wtg" width="360" scrolling="No" height="290" frameborder="0" z-index:0="" style="padding:0px;"    src="http://worldtravelgroup.reslogic.com/?pl=555&tpl=TQW_IFRAME&iframe"></iframe></center></div> -->

				<!--          <div class="col-lg-12 col-md-12">

                                     <form action="<?php echo get_home_url(null,"package-search"); ?>" method="get">                 

                        <div class="col-md-5 remove-right-padding">

                          <input class="date-input-top" placeholder="Departure Date" data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-start-date="-1d" name="date" type="text">

                          <input id="des-hidden" name="des" type="hidden">

                          <input id="des-text-hidden" name="des-text" type="hidden">

                        </div>

                        <div class="col-md-5 dropdown remove-right-padding">

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

                        

 					  </form> 

              				  </div> -->

			</div>

		</div>

	</div>

</div>
<div id="package_wrap_anchor"></div>

<div id="package_wrap" class="wrap">
	<a name="CustomPackagesData"></a>
	<h3 id="package_text_anchor" class="home-travel-h3">Travel Packages</h3>
	
	<div class="textbox textbox1 textshadow1">
    	<span>If you find a cheaper hotel package we will match the price + also give you a AUD $100 voucher to use on your island getaway</span>
  	</div>
  	
  	<div class="clearfix"></div>
	

	<div class="box">

		<div class="boxInner">
			<a href="<?php echo get_term_link( "maldives-overwater", "package_taxonomy" );?>">
				<img src="<?php echo get_template_directory_uri() . '/images/cover/maldives_300.jpg'; ?>" alt="" />
				
				<div class="card_content">
					<h3>MALDIVES RESORT</h3>
				</div>
			</a>

		</div>

	</div>

	<div class="box">

		<div class="boxInner">
			<a href="<?php echo get_term_link( "tahiti-overwater", "package_taxonomy" );?>">
				<img src="<?php echo get_template_directory_uri() . '/images/cover/tahiti_300.jpg'; ?>" alt="" />

				<div class="card_content">
					<h3>TAHITI RESORT</h3>
				</div>

			</a>

		</div>

	</div>

	<div class="box">

		<div class="boxInner">
			<a href="<?php echo get_term_link( "fiji-overwater", "package_taxonomy" );?>">
				<img src="<?php echo get_template_directory_uri() . '/images/cover/fiji_300.jpg'; ?>" alt="" />
				
				<div class="card_content">
					<h3>FIJI RESORT</h3>
				</div>
			</a>

		</div>

	</div>

	<div class="box">

		<div class="boxInner">
			<a href="<?php echo get_term_link( "malaysia-overwater", "package_taxonomy" );?>">
				<img src="<?php echo get_template_directory_uri() . '/images/cover/malaysia_300.jpg'; ?>" alt="" />
				
				<div class="card_content">
					<h3>MALAYSIA RESORT</h3>
				</div>
			</a>

		</div>

	</div>

	<div class="box">

		<div class="boxInner">
			<a href="<?php echo get_term_link( "vanuatu-overwater", "package_taxonomy" );?>">
				<img src="<?php echo get_template_directory_uri() . '/images/cover/vanuatu_300.jpg'; ?>" alt="" />
				
				<div class="card_content">
					<h3>VANUATU RESORT</h3>
				</div>
			</a>

		</div>

	</div>

	<div class="box">

		<div class="boxInner">
			<a href="<?php echo get_term_link( "samoa-overwater", "package_taxonomy" );?>">
				<img src="<?php echo get_template_directory_uri() . '/images/cover/samoa_300.jpg'; ?>" alt="" />
				
				<div class="card_content">
					<h3>SAMOA RESORT</h3>
				</div>
			</a>

		</div>

	</div>

	<div class="box">

		<div class="boxInner">
			<a href="<?php echo get_term_link( "philippines-overwater", "package_taxonomy" );?>">
				<img src="<?php echo get_template_directory_uri() . '/images/cover/philippines_300.jpg'; ?>" alt="" />
				
				<div class="card_content">
					<h3>PHILIPPINES RESORT</h3>
				</div>
			</a>

		</div>

	</div>

	<div class="box">

		<div class="boxInner">
			<a href="<?php echo get_term_link( "cook-islands-overwater", "package_taxonomy" );?>">
				<img src="<?php echo get_template_directory_uri() . '/images/cover/other_islands_300.jpg'; ?>" alt="" />
				
				<div class="card_content">
					<h3>OTHER ISLANDS RESORT</h3>
				</div>
			</a>

		</div>

	</div>

	<style>
.prosenjitdiv a {
	color: #fff;
	background-color: #0086ac !important;
	font-family: arial;
}

.prosenjitdiv {
	display: block;
	padding-top: 59px;
	text-align: center;
}
</style>
<?php include_once "template-travel-footer.php";?>
