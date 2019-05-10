	<?php /*
Template Name: Contact
*/ ?>

<?php get_header(); ?>

<section id="content" class="contact">

	<?php /* =- =- =- =- =- =- =- = =- 

		MAP

	=- =- =- =- =- =- =- =- =- =- =- */ ?>
	<div id="hero">
		<!-- <div class="overlay"></div>
		<div class="lockup"></div> -->

		<div id="map-canvas"></div>

	</div>

	<div class="center">

		<div id="home-pin-container" style="display: none">
			<div class="home-pin home">

				<?php 

					$hp_heading = get_field('hp_headline');
					$hp_address = get_field('hp_address');
					$hp_phone = get_field('hp_phone');

				 ?>
				 <div class="inner">
				 	
				 	<div class="top">
				 		<h2><?php echo $hp_heading ?></h2>
				 	</div>
				 	<div class="address">
				 		<?php echo $hp_address ?>
				 	</div>
				 	<div class="phone">
				 		<p><?php echo $hp_phone ?></p>
				 	</div>

				 </div>
				
			</div>
		</div>

		<?php /* =- =- =- =- -= 

			Parking Garages COntent

		=- =- =- =- =- =-  =- */ ?>

		<!-- <div class="garages-wrapper"> -->
		<div class="garages-wrapper" style="display: none;">

			<?php 

				global $post;
				$args = array(
					'post_type' => 'ucf_parking',
					'posts_per_page'   => -1,
					'order' => 'ASC',
					'tax_query' => array(
						array(
							'taxonomy' => 'parking_type',
							'field'    => 'slug',
							'terms'    => 'garage'
						)
					)
				);

				$garages = get_posts($args);

				$count = 0;

			 ?>

			 <?php foreach($garages as $post){ setup_postdata($post); ?>

			 	<div class="a-marker garage" id="garage-<?php echo $count; ?>-container" data-title="<?php echo get_the_title(); ?>" data-ilat="<?php echo get_field('imap_lat'); ?>" data-ilng="<?php echo get_field('imap_lng'); ?>">
			 		<div class="garage-pin">

			 			
			 			 <div class="inner">
			 			 	
			 			 	<div class="top">
			 			 		<h2><?php echo get_the_title(); ?></h2>
			 			 	</div>
			 			 	<?php if (get_the_content()): ?>
			 			 		<div class="body">
			 			 			<?php the_content(); ?>
			 			 		</div>
			 			 	<?php endif ?>
			 			 	

			 			 </div>
			 			
			 		</div>
			 	</div>



			 	<?php $count++; ?>

			 <?php } ?>

			 <?php wp_reset_postdata(); ?>
			
		</div>

		<div class="col left">
			<?php /* =- =- =- =- =- =- =- = =- 

				GENERAL CONTACT

			=- =- =- =- =- =- =- =- =- =- =- */ ?>
			<div id="general-contact" class="contact-section">

				<?php if (get_field('general_body')): ?>
					<h2><?php echo get_field('general_heading'); ?></h2>
					<div class="gc-body"><?php echo get_field('general_body'); ?></div>
				<?php endif ?>
				
				<div class="phone-row">
					
					<?php if (get_field('phone_number')): ?>
						<h4 class="contact">Phone:</h4><span class="p-style"><?php echo get_field('phone_number'); ?></span>
					<?php endif ?>

				</div>

				<div class="phone-row">

					<?php if (get_field('fax_number')): ?>
						<h4 class="contact">Fax:</h4><span class="p-style"><?php echo get_field('fax_number'); ?></span>
					<?php endif ?>

				</div>

				<div class="clear"></div>
				
			</div>
			
			<?php /* =- =- =- =- =- =- =- = =- 

				PARKING & DIRECTIONS

			=- =- =- =- =- =- =- =- =- =- =- */ ?>
			<div class="parking-directions" class="contact-section">
				
				<?php if (get_field('pd_heading')): ?>
					<h2><?php echo get_field('pd_heading'); ?></h2>
				<?php endif ?>

				<?php if (get_field('pd_sub1')): ?>
					<h3><?php echo get_field('pd_sub1'); ?></h3>
				<?php endif ?>

				<?php if (get_field('pd_body')): ?>
					<div class="parking-info"><?php echo get_field('pd_body'); ?></div>
				<?php endif ?>

				<?php if (get_field('pd_sub2')): ?>
					<h3 class="sub-2"><?php echo get_field('pd_sub2'); ?></h3>
				<?php endif ?>

				<?php if (get_field('directions')): ?>

					<?php $directions = get_field('directions'); 


						$count = 0;

					?>

					<?php foreach($directions as $direction_row){ ?>

						<a href="#" class="direction-row <?php if($count == 0){ echo 'active'; } ?>" data-count="<?php echo $count; ?>">
							<div class="indicator">
								<div class="inner">
									<span class="line line1"></span>
									<span class="line line2"></span>
								</div>
							</div>
							<h4><?php echo $direction_row['direction_heading']; ?></h4>

							<?php $options = $direction_row['direction_options']; ?>
							<?php if ($options): ?>
								<div class="options-wrap">
									<?php foreach($options as $option){ ?>


										<div class="an-option">
											<span class="option-heading"><?php if($option['option_heading']){ echo $option['option_heading']; } ?></span><?php if($option['option_body']){ echo ' - '.$option['option_body']; } ?>
										</div>

									<?php } ?>
								</div>
							<?php endif ?>

							<?php $count++; ?>

						</a>
						<?php //pre_print_r($direction_row); ?>
					<?php } ?>
				<?php endif ?>



				<?php if (get_field('pd_sub3')): ?>
					<h3 class="sub-3"><?php echo get_field('pd_sub3'); ?></h3>
				<?php endif ?>

				<?php if (get_field('pd_body2')): ?>
					<div class="parking-info"><?php echo get_field('pd_body2'); ?></div>
				<?php endif ?>

			</div>
		</div>
		
		<div class="col right">


			<?php /* =- =- =- =- =- =- =- = =- 

				CONTACT FORMS

			=- =- =- =- =- =- =- =- =- =- =- */ ?>
			<div id="contact-forms" class="contact-section">


				<div class="the-forms">
					
					<?php /************ Let's Talk **************/ ?>
					<div class="a-form active" id="general-form" data-form="1">

						<a href="#" class="title-bar" data-form="1"><span class="form-title"><?php the_field( 'contact_form_title_1' ); ?></span></a>

						<div class="collapser">
							<div class="inner">

								<?php gravity_form( 1, false, true, false, null, true, null ); ?>
								<div class="clear"></div>

							</div>
						</div>
						
					</div>




					<?php /************ Digital Sign Request **************/ ?>
					<div class="a-form" id="sign-request-form" data-form="2">

						<a href="#" class="title-bar" data-form="2"><span class="form-title"><?php the_field( 'contact_form_title_2' ); ?></span></a>

						<div class="collapser">
							<div class="inner">

								<?php gravity_form( 2, false, true, false, null, true, null ); ?>
								<div class="clear"></div>
								
							</div><?php /* end .inner */ ?>
						</div><?php /* end .collapser */ ?>


					</div><?php /* end .a-form */ ?>



					<?php /************ Maintenance Work Order **************/ ?>
					<?php /*
					<div class="a-form" data-form="3">

						<a href="#" class="title-bar" data-form="3"><span class="form-title">Maintenance Work Order</span></a>

						<div class="collapser">
							<div class="inner">

								<?php gravity_form( 3, false, true, false, null, true, null ); ?>

								<div class="clear"></div>
								
							</div>
						</div>


					</div>

					*/ ?>



					
				</div><?php /* end .the-forms */ ?>


			</div><?php /* end #contact-forms */ ?>

			<div id="maintenance-cta">
				
				<?php if (get_field('mwo_cta_heading')): ?>
					<h2><?php echo get_field('mwo_cta_heading'); ?></h2>
				<?php endif ?>

				<?php if (get_field('mwo_cta_body')): ?>
					<?php echo get_field('mwo_cta_body'); ?>
				<?php endif ?>

				<?php if (get_field('mwo_cta_link')): ?>
					<a href="<?php echo get_field('mwo_cta_link'); ?>" class="black-btn" data-post='<?php echo $post->ID; ?>'>
						<?php if (get_field('mwo_cta_link_text')): ?>
							<span><?php echo get_field('mwo_cta_link_text'); ?></span>
						<?php else: ?>
							<span>Read More</span>
						<?php endif ?>
					</a>
				<?php endif ?>

			</div>
			

			<?php /* =- =- =- =- =- =- =- = =- 

				FAQ

			=- =- =- =- =- =- =- =- =- =- =- */ ?>
			<div id="faq" class="contact-section">
				
					<div class="parking-directions contact-section">
						
						<?php if (get_field('faq_heading')): ?>
							<h2><?php echo get_field('faq_heading'); ?></h2>
						<?php endif ?>

						<?php if(get_field('faq')){ $faq = get_field('faq'); } ?>

						<?php foreach($faq as $row){ ?>

							<h4 class="question"><?php echo $row['question']; ?></h4>

							<div class="answer"><?php echo $row['answer']; ?></div>

						<?php } ?>

			
							


					</div>

			</div>

			
		</div>

		<div class="clear"></div>

	</div><?php /* end .center.wide */ ?>



</section>
<?php //end content ?>

<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/library/js/fileuploader/vendor/jquery.ui.widget.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/library/js/fileuploader/jquery.iframe-transport.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/library/js/fileuploader/jquery.fileupload.js"></script>

<?php 	wp_enqueue_script( 'infobubble', THEME_URL.'/library/js/infobubble.js', array( 'jquery' ) ); ?>
<?php 	wp_enqueue_script( 'contactmap', THEME_URL.'/library/js/contactmap.js', array( 'infobubble' ) ); ?>

<script type="text/javascript">
	jQuery(document).ready(function($){





		$('.maintenance-drop-down').fancySelect();
		$('#input_3_4').fancySelect();
		$('#input_3_5').fancySelect();
		$('#input_3_6').fancySelect();



		var BrowserDetect = {
	        init: function () {
	            this.browser = this.searchString(this.dataBrowser) || "Other";
	            this.version = this.searchVersion(navigator.userAgent) || this.searchVersion(navigator.appVersion) || "Unknown";
	        },
	        searchString: function (data) {
	            for (var i = 0; i < data.length; i++) {
	                var dataString = data[i].string;
	                this.versionSearchString = data[i].subString;

	                if (dataString.indexOf(data[i].subString) !== -1) {
	                    return data[i].identity;
	                }
	            }
	        },
	        searchVersion: function (dataString) {
	            var index = dataString.indexOf(this.versionSearchString);
	            if (index === -1) {
	                return;
	            }

	            var rv = dataString.indexOf("rv:");
	            if (this.versionSearchString === "Trident" && rv !== -1) {
	                return parseFloat(dataString.substring(rv + 3));
	            } else {
	                return parseFloat(dataString.substring(index + this.versionSearchString.length + 1));
	            }
	        },

	        dataBrowser: [
	            {string: navigator.userAgent, subString: "Chrome", identity: "Chrome"},
	            {string: navigator.userAgent, subString: "MSIE", identity: "Explorer"},
	            {string: navigator.userAgent, subString: "Trident", identity: "Explorer"},
	            {string: navigator.userAgent, subString: "Firefox", identity: "Firefox"},
	            {string: navigator.userAgent, subString: "Safari", identity: "Safari"},
	            {string: navigator.userAgent, subString: "Opera", identity: "Opera"}
	        ]

	    };
	    
	    BrowserDetect.init();

		// Init Datepicker
		$('#signage_start_date, #signage_end_date').datepicker();

		// =- =- =- =- =- =- =- =- =- =- =- =- =- =- =-
		//	
		//	AJAX Form Submission
		//
		// =- =- =- =- =- =- =- =- =- = =- =- =- =- =- =-

		var uploaded = false;

		$('.contact-form').on('submit', function(evt) {

			evt.preventDefault();
				
			var form = $(this),
				btn = form.find('button[type="submit"]'),
				successMsg = $('#form-success');
			
			//remove errors
			form.find('.er').removeClass('er');

			successMsg.removeClass('error-state');
			btn.removeClass('er');

			if(form.data('form') == 2 && uploaded == false){
				btn.addClass('disabled').attr('disabled', 'true');
			} else {
				btn.removeAttr('disabled');
			}
					
			//send	
			$.ajax({
				url: '<?php echo admin_url('admin-ajax.php'); ?>',
				type: 'POST',
				data: form.serialize(),
				success: function(result) {
			
					var data = JSON.parse( result );

					// console.log(result);
					console.log(data);
					
					//errors ?
					if( data.fields ) {
						$.each( data.fields, function(i, v) {

							form.find( '[name='+v+']' ).addClass('er');
							form.find( '[for='+v+']' ).addClass('er');
							
						});
						
					}
					//FAIL
					if(data.code == 0 ) {

						form.find('.notify-text').html(data.message);

					}
					
					//SUCCESS
					if( data.code && data.code == 1 ) {
						form.slideUp(200, function(){
							
							form.find('.notify-text').html(data.message);

						});
					}
					
				}
			});
			
			return false;
				
		});




			// =- =- =- =- =- =- =- =- =- =- =-
			//
			//	 	 File Upload 
			//
			// =- =- =- =- =- =- =- =- =- =- =-
			
			var 	upload = $('#signage_file'),
				filetxt = $('.browse-bar');

			//init uploader
			upload.fileupload({
				url: '<?php echo admin_url('admin-ajax.php'); ?>',
				formData: {
					action: 'signageupload'
				},
				acceptFileTypes: /(\.|\/)(jpg|png|jpeg|pdf)$/i,
				replaceFileInput: false,
				add: function (e, data) {

					if (BrowserDetect.browser == 'Explorer' && BrowserDetect.version <= 8) {

						var file_size = '';

		    		} else {

		    			var file_size = data.files[0].size;

		    		}

					// if (file_size <= 5000000) {
					if (20 > 10) {

						if (filetxt.hasClass('er_txt')) {
							filetxt.removeClass('er_txt');
						}
						// Edit label in the readonly input field, show the filename here, or in red if error
						filetxt.val(data.files[0].name);
						
						var file_name = data.files[0].name;
						var ext = file_name.split('.').pop().toLowerCase();
						
						if($.inArray(ext, ['jpg', 'png', 'jpeg', 'pdf', 'txt', 'pages']) == -1) {

							resume_status = 0;
							filetxt.addClass('er_txt');
							// updateNotify('Incompatible file type. Please use .jpg, .pdf, .pdf, .png, .txt, or .pages', 0);

						} else {

							resume_status = 1;

							// IMPORTANT!!!!!
							data.submit();

							// updateNotify('Resume Uploaded', 1);
							// $('.file-size-msg').fadeOut(200).remove();

						}

					} else {

						filetxt.addClass('er_txt');
						// updateNotify('Your file is too big. Please use a smaller file.', 0);

					}

					data_holder = data;
				},
				done: function(e, data) {
					
					result = data.result;

					console.log(data.result);
					
					if(result.code == '1') {

						uploaded = true;

						if($('#signage-submit-button').hasClass('disabled')){
							$('#signage-submit-button').removeClass('disabled').removeAttr('disabled');
						}

					} else {

						console.log('error... result.code = '+result.code);

						if(!$('#signage-submit-button').hasClass('disabled')){
							$('#signage-submit-button').addClass('disabled').attr('disabled', true);
						}

					}
					
				}
			});

			var scrollDest = function(){
				if($(window.location.hash).offset().top > $(document).height()-$(window).height()){
				     dest=$(document).height()-$(window).height();
				}else{
				     dest=$(window.location.hash).offset().top;
				}
				//go to destination
				console.log(dest);

				dest -= 40;

				console.log(dest);
				$('html,body').animate({scrollTop:dest}, 1000,'swing');
			}
			

			// =- =- =- =- =- =- =- =- =- =- =- =- =- =- =- =- -
			//
			//	If a hash is in the url. 
			//	pull the post id from it and 
			//	open the related case study
			//
			// =- =- =- =- =- =- =- =- =- =- =- =- =- =- =- =- 
			//check for hash
			var hash = window.location.hash;
			if(hash){
				var dest=0;

				if(hash == '#sign-request-form'){
					$('.a-form').removeClass('active');
					$('#sign-request-form').addClass('active');
					setTimeout(function() {
						scrollDest();
					}, 500);
				} else {
					scrollDest();
				}

		
			}





	});
</script>

<?php get_footer(); ?>