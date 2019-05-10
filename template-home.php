<?php /*
Template Name: Home
*/ ?>

<?php get_header(); ?>

<section id="content" class="home">

	<?php /* =- =- =- =- =- =- =- = =- 

		HERO

	=- =- =- =- =- =- =- =- =- =- =- */ ?>
	<div id="hero">
		<img class="ie-fallback" src="<?php echo THEME_URL.'/library/images/background-home-hero.jpg'; ?>" alt="A student sitting outside the UCF John T Washington Center">
		<div class="overlay"></div>
		<div class="lockup"></div>
	</div>


	<?php /* =- =- =- =- =- =- =- = =- 

		PARTNERS

	=- =- =- =- =- =- =- =- =- =- =- */ ?>

	<div class="center wide partners-wrap">

		<div id="partners">

			<?php if (get_field('main_heading')){ ?>
				<h2 class="section-title"><?php echo get_field('main_heading'); ?></h2>
			<?php }else{ ?>
				<h2 class="section-title">Our Partners</h2>
			<?php } ?>

			<div id="partners-filter">
				<?php 

				$taxonomies = array('partner_type');

				$args = array(
				    'orderby'           => 'name', 
				    'order'             => 'ASC',
				    'hide_empty'        => true,
				    'fields'            => 'all'
				); 

				$partner_types = get_terms($taxonomies, $args);

				// pre_print_r($partner_types);

				?>

				<a href="#" class="a-filter active" data-partner-type="all">
					<span>ALL</span>
				</a>

				<?php foreach($partner_types as $term){ ?>

					<a href="#" class="a-filter" data-partner-type="<?php echo $term->slug; ?>">
						<span><?php echo $term->name; ?></span>
					</a>

				<?php } 

				wp_reset_postdata();

				?>
			</div>

			<?php /* || ----- PARTNERS CONTAINER ---- || */ ?>
			<div class="partners-container">
				<?php global $post;
					$args = array(
						'post_type' => 'jtwc_partners',
						'posts_per_page'   => -1,
						'order' => 'ASC',
					);
					$partners = get_posts($args); 

				?>
				
				<?php foreach($partners as $post){ setup_postdata($post); ?>
					
					<?php print_partner($post); ?>

				<?php } ?>

				<?php wp_reset_postdata(); ?>

				<div class="clear"></div>
			</div><?php /* end .partners-container */ ?>

		</div><?php /* end #partners */ ?>

	</div><?php /* end .center.wide */ ?>



	<?php /* =- =- =- =- =- =- =- =- =- =-

		Keep Up To Date CTA

	=- =- =- =- =- =- =- =- =- =- =- =- =-*/ ?>
	<?php /* Setup*/

		$heading_line1 = get_field('heading_line1');
		$heading_line2 = get_field('heading_line2');

		$link_text = get_field('link_text');


	 ?>
	<?php if ($heading_line1 || $heading_line2): ?>
		<div id="keep-up" class="a-cta">
			
			<div class="inner center">
				<?php if ($heading_line1): ?>
					<h3><?php echo $heading_line1; ?></h3>
				<?php endif ?>
				<?php if ($heading_line2): ?>
					<h4><?php echo $heading_line2; ?></h4>
				<?php endif ?>

				<a href="<?php echo get_bloginfo('url'); ?>/contact" class="border-btn-white">
					<?php if ($link_text): ?>
						<span><?php echo $link_text; ?></span>
					<?php else: ?>
						<span>Sign Up</span>
					<?php endif ?>
				</a>  

			</div>

		</div><?php /* end .a-cta */ ?>
	<?php endif ?>
	



	<?php /* =- =- =- =- =- =- =- =- =- =-

		WHATS HAPPENING

	=- =- =- =- =- =- =- =- =- =- =- =- =-*/ ?>
	<div id="whats-happening">
		<div class="center wide">

			<div id="posts">

				<div id="blue-bar">
					<h2>What's Happening</h2>
					<a href="<?php echo get_bloginfo('url'); ?>/blog" class="black-btn">
						<span>View All</span>
					</a>
				</div>
					
				<div class="posts-wrapper">
					<?php 

						global $post;
						$args = array(
							'post_type' => 'post',
							'posts_per_page'   => 3,
							'order' => 'DESC'
						);

						$latest_posts = get_posts($args);

					 ?>

					 <?php foreach($latest_posts as $post){ setup_postdata($post); ?>

					 	<?php print_post($post); ?>

					 <?php } ?>
				</div>

			</div><?php /* end #posts */ ?>

		</div><?php /* end .center */ ?>

	</div><?php /* end #whats-happening */ ?>



	<?php /* =- =- =- =- =- =- =- =- =- =-

		FIND US CTA

	=- =- =- =- =- =- =- =- =- =- =- =- =-*/ ?>
	<?php get_template_part('section', 'cta-find-us'); ?>



</section>
<?php //end content ?>


<script type="text/javascript">

	jQuery(document).ready(function($){

		var sw = document.body.clientWidth;

		$('window').on('resize', function(){

			var sw = document.body.clientWidth;			

		});

		//Employee Filter Click
		$('#partners .a-filter').on('click', function(e) {

			e.preventDefault();

			var 	filter = $(this).data('partner-type'),
				container = $('.partners-container'),
				loader = $('.partners-loading-indicator');

			//Remove Active Class From Other Filter
			$('#partners-filter .a-filter.active').removeClass('active');

			//Add Active Class to clicked filter
			$(this).addClass('active');

	
			var dataObj = {
				action: 'filter_partners',
				id: filter
			}

			$.ajax({
			    type: "POST",
			    url: '<?php echo admin_url('admin-ajax.php'); ?>',
			    data: dataObj,
			    beforeSend: function(arg) {

				    	//Show Ajax Loader
				    	loader.show();

				    	// console.log(arg);

			    },
			    error: function(xhr, status, error){

			    		console.log(xhr);

			    },
			    success: function(result, status, jqxhr) {

			    		//Add New Slides
			    		container.fadeOut(200, function(){
			    			container.html('');
			    			container.html(result).fadeIn(200);
			    		});

			    }/* end success */

			}); /* end $.ajax */


		});/* end .partner-filter click event */



		/* - = - = - = - = - = - = - =- = = - =- = = - =- =

			Load Post Info

		- = - = - = - = - = - = - = - = - = = - =- = = - =- = */
		$('.a-post[data-carousel="1"]').on('click', '.post-trigger', function(e){


			if(sw >= 1080 && !$('html').hasClass('lt-ie9')){

				e.preventDefault();

				var post_data = $(this).data(),
					container = $('#fancybox-content');

				var dataObj = {
					action: 'load_post_info',
					post_id: post_data.post,
					post_cat: post_data.cat
				}

				$.ajax({
				    type: "POST",
				    url: '<?php echo admin_url('admin-ajax.php'); ?>',
				    data: dataObj,
				    dataType: "html",
				    beforeSend: function(arg) {

				    },
				    responseText: function(result){

				    },
				    success: function(result) {

				    	container.html(result);

						$.fancybox.open([{ href : '#fancybox-content' }], {
							wrapCSS	  : 'modal-wrap',
							openEffect  : 'none',
							'padding'   : 0,
							fitToView   : false,
							autoSize    : false,
							closeEffect : 'none',
							scrolling	  : 'no',
							helpers     : {
								media  	: {},
								overlay	: {
									locked: false
								}
					    		}
						});

						$( '.slide-container' ).cycle();

				    }/* end success */

				}); /* end $.ajax */


				return false;
			}

		});



	});
</script>

<?php 
	wp_enqueue_script( 'cycle2_lib', THEME_URL.'/library/js/cycle2/cycle2.js', array( 'jquery' ) );
	wp_enqueue_script( 'cycle2_swipe', THEME_URL.'/library/js/cycle2/cycle2.swipe.js', array( 'jquery' ) );

?>

<?php get_footer(); ?>