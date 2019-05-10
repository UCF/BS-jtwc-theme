<?php /* =- =- =- =- =- =- =- =- =- =-

	FIND US CTA

=- =- =- =- =- =- =- =- =- =- =- =- =-*/ ?>
<?php /* Setup */ 

	$Page = get_page_by_title( 'Home' );
	$home_page_id = $Page->ID;

	$ls_heading = get_field('ls_heading', $home_page_id);
	$ls_body = get_field('ls_body', $home_page_id);
	$rs_heading = get_field('rs_heading', $home_page_id);
	$rs_body = get_field('rs_body', $home_page_id);


?>
<div id="find-us-cta" class="a-cta">
	
	<a href="<?php echo get_bloginfo('url'); ?>/contact" class="left">

		<div class="background"></div>

		
		<div class="inner">
			<?php if (isset($ls_heading) && $ls_heading != ''): ?>
				<h5><?php echo $ls_heading; ?></h5>
			<?php else: ?>
				<h5>FIND US</h5>
			<?php endif; ?>
			<?php if (isset($ls_body) && $ls_body != ''): ?>
				<?php echo $ls_body; ?>
			<?php else: ?>
				<p>Located on campus for your convenience</p>	
			<?php endif; ?>
		</div>

	</a>

	<a href="<?php echo get_bloginfo('url'); ?>/contact#faq" class="right">

		<div class="background"></div>

		<div class="inner">
			<?php if (isset($rs_heading) && $rs_heading != ''): ?>
				<h3><?php echo $rs_heading; ?></h3>
			<?php else: ?>
				<h3>FAQ</h3>
			<?php endif; ?>
			<?php if (isset($rs_body) && $rs_body != ''): ?>
				<?php echo $rs_body; ?>
			<?php else: ?>
				<p>Do you have questions?</p>
				<p>We Have answers.</p>
			<?php endif; ?>
			
			
		</div>
	</a>

	<div class="clear"></div>

</div><?php /* end .a-cta */ ?>