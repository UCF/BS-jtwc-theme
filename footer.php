</article>	<!-- site wrap -->

<article id="footer">

	<?php 

		$args = array(
			'post_type' => 'jtwc_partners',
			'posts_per_page' => -1,
			'post_status' => 'publish',
			'orderby' => 'name',
			'order' => 'ASC',
			'tax_query' => array(
				array (
					'taxonomy' => 'partner_type',
					'terms' => 'food',
					'field' => 'slug'
				)
			)
		);
		$food_partners = get_posts($args);

	 ?>

	<section class="inner">
		<div class="center">
			
			<div class="footer-about">
				<p><a href="<?php echo get_bloginfo('url'); ?>" class="gold">The John T. Washington Center</a>, also known as the breezeway, offers visitors shopping, dining, banking, and student services. It is located conveniently on the campus of <a href="http://ucf.edu" class="gold">The University of Central Florida</a></p>
			</div>

			<div class="footer-links">
				<div class="link-col one">
					<h5>Food</h5>
					<?php print_footer_partners('food'); ?>
				</div>
				<div class="link-col two">
					<h5>Retail</h5>
					<?php print_footer_partners('retail'); ?>
				</div>
				<div class="link-col three">
					<h5>Services</h5>
					<?php print_footer_partners('services'); ?>
				</div>
				<div class="link-col four">
					<h5>Contact</h5>
					<?php wp_nav_menu(array(
						'theme_location' => 'footer-nav4', 
						'container' => '',
						'menu_id' => 'footer-nav4'
					)); ?>
				</div>

				<div class="clear"></div>
			</div>

			<div class="footer-logo">
				<?php /* Setup */

					$logo_bottom = get_field('logo_bottom', 'option');
					$ba_line1 = get_field('ba_line1', 'option');
					$phone_number = get_field('phone_number', 'option');
					$valid_phone = isset($phone_number) && $phone_number != '';
					$fax_number = get_field('fax_number', 'option');
					$valid_fax = isset($fax_number) && $fax_number != '';
					$address = get_field('address', 'option');
					$valid_address = isset($address) && $address != '';


				?>
				<div class="logo-container"></div>
				<?php if (isset($logo_bottom) && $logo_bottom != ''): ?>
					<p class="small-text"><?php echo $logo_bottom; ?></p>
				<?php else: ?>
					<p class="small-text">We support education by taking care of business.</p>
				<?php endif ?>
			</div>

			<div class="disclaimer">
				<?php if (isset($ba_line1) && $ba_line1 != ''): ?>
					<p class="small-text"><?php echo $ba_line1; ?></p>
				<?php else: ?>
					<p class="small-text">&copy; UCF Business Services, a unit of the Division of Administration and Finance</p>
				<?php endif ?>
				<?php if ($valid_phone && $valid_address && $valid_fax): ?>
					<p class="small-text">Phone: <a href="tel:<?php echo $phone_number; ?>"><?php echo $phone_number; ?></a> | Fax: <?php echo $fax_number; ?></a> | <?php echo $address; ?></p>
				<?php else: ?>
					<p class="small-text">Phone: <a href="tel:4078232624">(407)823-2624</a> | Fax: <a href="tel:4078820715">(407)882-0175</a> | 12479 Research Pkwy Ste 600, Orlando, FL 32826</p>
				<?php endif ?>
			</div>

			<div class="clear"></div>
			
		</div>
	</section>

</article>

<?php wp_footer(); ?>
</body>
</html>