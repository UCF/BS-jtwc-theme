<?php

error_reporting(E_ALL);

show_admin_bar(false);

if(!defined('THEME_URL'))
	define('THEME_URL', get_bloginfo('template_directory'));

//	fix db after server move
//require_once( TEMPLATEPATH.'/library/includes/mysql-replace.php' );
//MySQL_Replace::replace('old', 'new');

//	dependicies
require_once( TEMPLATEPATH . '/library/includes/wp-header-remove.php' );
require_once( TEMPLATEPATH . '/library/includes/ajax/loading_functions.php' );

//	menus
register_nav_menus(array(
	'main-nav' => 'Main Navigation',
	'footer-nav1' => 'Footer Nav 1',
	'footer-nav2' => 'Footer Nav 2',
	'footer-nav3' => 'Footer Nav 3',
	'footer-nav4' => 'Footer Nav 4'
));

//	post thumbnails
add_theme_support( 'post-thumbnails' );
add_image_size('partner-logo', 264, 169, false);

/* Google Analytics Settings Code */
$google_analytics_setting = new google_analytics_setting();
class google_analytics_setting {

    function google_analytics_setting() {
        add_filter( 'admin_init' , array( &$this , 'register_fields' ) );
    }

    function register_fields() {
        register_setting( 'general', 'google_analytics_code', '' );
        add_settings_field( 'fav_color', '<label for="google_analytics_code">' . __( 'Google Analytics Code' , 'google_analytics_code' ).'</label>' , array( &$this, 'fields_html' ) , 'general' );
    }

    function fields_html() {
        $value = get_option( 'google_analytics_code', '' );
        echo '<textarea rows="7" id="google_analytics_code" name="google_analytics_code" style="width: 100%;">' . $value . '</textarea>';
    }

}

/* Print Within WP Head */
add_action( 'wp_head', 'google_head' );
function google_head() {
	/* Google Analytics */ 
	if ( get_option( 'google_analytics_code' ) != FALSE ) { 
		echo get_option( 'google_analytics_code', '' );
	}
}

/**
 * Is login or register page
 */
function smc_is_login_page() {
    return in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'));
}

#	Scripts
########################################################
add_action( 'wp_print_scripts', 'spry_print_scripts' );

function spry_print_scripts() {
	
	if( is_admin() )
		return false;
	
	wp_enqueue_script( 'jquery' );
	wp_register_script( 'lib', THEME_URL.'/library/js/lib.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'lib' );

	wp_enqueue_script( 'jqueryui', THEME_URL.'/library/js/jqueryui/jquery-ui.min.js', array( 'jquery' ), '', true );


	wp_enqueue_script( 'fancy1', THEME_URL.'/library/js/fancybox/source/jquery.fancybox.pack.js', array( 'jquery' ) );
	wp_enqueue_script( 'fancy2', THEME_URL.'/library/js/fancybox/source/helpers/jquery.fancybox-buttons.js', array( 'jquery' ) );
	wp_enqueue_script( 'fancy3', THEME_URL.'/library/js/fancybox/source/helpers/jquery.fancybox-media.js', array( 'jquery' ) );
	wp_enqueue_script( 'fancy4', THEME_URL.'/library/js/fancybox/source/helpers/jquery.fancybox-thumbs.js', array( 'jquery' ) );


	wp_enqueue_script( 'fancyselect', THEME_URL.'/library/js/fancyselect/fancySelect.js', array( 'jquery' ) );

	if(!smc_is_login_page()){
		wp_enqueue_script( 'ucfhb', '//universityheader.ucf.edu/bar/js/university-header.js', array( 'jquery' ) );
	}

}

/* =- =- =- =-  -= - = -= -= -= =- =- 
//
//	Spry WP-Admin Favicon!!!!
//
// =- =- =- =- =- =- =- - = =- -= = - */

// First, create a function that includes the path to your favicon
function add_favicon() {
  	$favicon_url = get_stylesheet_directory_uri() . '/library/images/admin-favicon.png';
	echo '<link rel="shortcut icon" href="' . $favicon_url . '" />';
}
  
// Now, just make sure that function runs when you're on the login page and admin pages  
add_action('login_head', 'add_favicon');
add_action('admin_head', 'add_favicon');



#	General Functions
########################################################

//custom length excerpt
function my_excerpt($limit) {
  $excerpt = explode(' ', get_the_excerpt(), $limit);
  if (count($excerpt)>=$limit) {
	array_pop($excerpt);
	$excerpt = implode(" ",$excerpt).'...';
  } else {
	$excerpt = implode(" ",$excerpt);
  } 
  $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
  return $excerpt;
}

// =- =- =- =- -= =- =- =- =- =- =-
//
//	print_r with pre tags
//
// =- =- =- =- =- =- =- =- =- =- =- */

function pre_print_r($array){

	echo '<pre style="font-family: monospace; font-size: 14px; text-align:left!important">';
	print_r($array);
	echo '</pre>';

}


// =- =- =- =- -= =- =- =- =- =- =-
//
//	Custom Length Excerpts
//
// =- =- =- =- =- =- =- =- =- =- =- */
function custom_excerpt($content, $limit) {

	$excerpt = explode(' ', $content, $limit);	

	if (count($excerpt)>=$limit) {

		array_pop($excerpt);
		$excerpt = implode(" ",$excerpt).'...';

	} else {

		$excerpt = implode(" ",$excerpt);
		
	} 

	$excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
	return $excerpt;
}




// =- =- =- =- -= =- =- =- =- =- =-
//
//	Contact Form Submission
//
//		(Not in Use)
//
// =- =- =- =- =- =- =- =- =- =- =- */
add_action( 'wp_ajax_contactsubmit', '_contactsubmit' );
add_action( 'wp_ajax_nopriv_contactsubmit', '_contactsubmit' );

function _contactsubmit() {



	$form_type = filter_var( $_POST['form_type'], FILTER_SANITIZE_STRING );

	$ers = array();

	switch ($form_type) {

		case 'general':

			$fields = array(			
				'general_full_name' 	=>	filter_var( $_POST['general_full_name'], FILTER_SANITIZE_STRING ),
				'general_phone' 		=>	filter_var( $_POST['general_phone'], FILTER_SANITIZE_STRING ),
				'general_email'		=>	filter_var( $_POST['general_email'], FILTER_SANITIZE_EMAIL ),
				'general_message' 		=>	filter_var( $_POST['general_message'], FILTER_SANITIZE_STRING )
			);

		

			if (isset($_POST['general_sign_up'])) {
				$fields['general_sign_up'] = filter_var( $_POST['general_sign_up'], FILTER_SANITIZE_STRING );
			}
			$form_label = 'General';
			
			$not_required = array('general_email', 'general_phone', 'general_sign_up');
			foreach($fields as $field => $value){
				if(!in_array($field, $not_required) && empty($value)){
					$ers[] = $field;
				}
			}

			//	Email Validation
			$email_pattern = '/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/';
			if(!preg_match($email_pattern, $fields['general_email'])){
				$ers[] = 'general_email';
			}

			break;

		case 'digital_sign':

			$fields = array(			
				'signage_merchant_name' 		=>	filter_var( $_POST['signage_merchant_name'], FILTER_SANITIZE_STRING ),
				'signage_start_date' 		=>	filter_var( $_POST['signage_start_date'], FILTER_SANITIZE_STRING ),
				'signage_end_date' 			=>	filter_var( $_POST['signage_end_date'], FILTER_SANITIZE_STRING ),
				'signage_full_name' 		=>	filter_var( $_POST['signage_full_name'], FILTER_SANITIZE_STRING ),
				'signage_phone' 			=>	filter_var( $_POST['signage_phone'], FILTER_SANITIZE_STRING ),
				'signage_email'			=>	filter_var( $_POST['signage_email'], FILTER_SANITIZE_EMAIL )
			);
			$form_label = 'Signage';
			$not_required = array('signage_email');
			foreach($fields as $field => $value){
				if(!in_array($field, $not_required) && empty($value)){
					$ers[] = $field;
				}
			}

			//	Email Validation
			$email_pattern = '/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/';
			if(!preg_match($email_pattern, $fields['signage_email'])){
				$ers[] = 'signage_email';
			}

			break;

		case 'maintenance':

			$fields = array(			
				'maintenance_full_name' 			=>	filter_var( $_POST['maintenance_full_name'], FILTER_SANITIZE_STRING ),
				'maintenance_phone' 			=>	filter_var( $_POST['maintenance_phone'], FILTER_SANITIZE_STRING ),
				'maintenance_email'				=>	filter_var( $_POST['maintenance_email'], FILTER_SANITIZE_EMAIL ),
				'maintenance_building_name' 		=>	filter_var( $_POST['maintenance_building_name'], FILTER_SANITIZE_STRING ),
				'maintenance_tenant_name' 		=>	filter_var( $_POST['maintenance_tenant_name'], FILTER_SANITIZE_STRING ),
				'maintenance_repair_item' 		=>	filter_var( $_POST['maintenance_repair_item'], FILTER_SANITIZE_STRING ),
				'maintenance_message' 			=>	filter_var( $_POST['maintenance_message'], FILTER_SANITIZE_STRING )
			);
			$form_label = 'Maintenance';
			$not_required = array('maintenance_email', 'maintenance_phone');
			foreach($fields as $field => $value){
				if(!in_array($field, $not_required) && empty($value)){
					$ers[] = $field;
				}
			}

			//	Email Validation
			$email_pattern = '/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/';
			if(!preg_match($email_pattern, $fields['maintenance_email'])){
				$ers[] = 'maintenance_email';
			}

			break;

	}

	if( !empty($ers) ) {
		
		die(json_encode(array(
			'post' => $_POST,
			'code' => 0,
			'message' => 'Please correct all errors before submitting.',
			'fields' => $ers
		)));
		
	} else {
			
		$to = '';

		$subject = "John T. Washington Center - $form_label Form Submission";
		$message = "Someone has contacted you from a form on your site.<br /><br />";
		foreach( $fields as $k => $v ){
			$form_field_name = ucwords( str_replace('_', ' ', $k) );
			$pattern = '/'.$form_label.'/';
			$form_field_name = preg_replace($pattern, '', $form_field_name);
			$message .= $form_field_name . ': ' . stripslashes($v) . '<br />';
		}

		$headers = "From: \r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		$mail = mail($to, $subject, $message, $headers);

		die(json_encode(array(
			'post' => $_POST,
			'code' => 1,
			'message' => 'Thank you for your interest.'
		)));

	}
}



// =- =- =- =- -= =- =- =- -= =- =- =- -=
//	Partners - Post Type
// =- =- =- =- =- =- =- =- -= =- =- =- -=*/
add_action( 'init', 'register_partners_post_type' );
function register_partners_post_type() {
	$labels = array(
		'name' => __("Partners"),
		'singular_name' => __('Partner'),
		'add_new_item' => __('Add New Partner'),
		'edit_item' => __('Edit Partner')
	);
	$args = array(
		'labels'             	=> $labels,
		'public'             	=> true,
		'publicly_queryable' 	=> true,
		'show_ui'				=> true,
		'show_in_menu'			=> true,
		'menu_icon'			=> 'dashicons-groups',
		'query_var'         	=> true,
		'capability_type'   	=> 'post',
		'has_archive'       	=> true,
		'hierarchical'      	=> true,
		'menu_position'     	=> null,
		'supports'         	 	=> array( 'title', 'thumbnail', 'editor')
		// 'taxonomies'			=> array('cs_type')
	);

	register_post_type( 'jtwc_partners', $args );
}

// =- =- =- =- -= =- =- =- -= =- =- =- -=
//	Partners - Partners Type Taxonomy
// =- =- =- =- =- =- =- =- -= =- =- =- -=*/
add_action( 'init', 'register_partner_type_taxonomy' );
function register_partner_type_taxonomy() {

	$taxonomy = 'partner_type';
	$object_type = 'jtwc_partners';

	$labels = array(
		'name'             			 => __( 'Partner Types'),
		'singular_name'              => __( 'Partner Type'),
		'edit_item'         		=> __( 'Edit Partner Type' ),
		'add_new_item'				=> __('Add New Partner Type')
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => false,
		'rewrite'           => array( 'slug' => 'type' ),
	);

	register_taxonomy( $taxonomy, $object_type, $args );
}

// =- =- =- =- -= =- =- =- -= =- =- =- -=
//	Parking Garages - Post Type
// =- =- =- =- =- =- =- =- -= =- =- =- -=*/
add_action( 'init', 'register_ucf_parking_post_type' );
function register_ucf_parking_post_type() {
	$labels = array(
		'name' => __("Parking"),
		'singular_name' => __('Parking'),
		'add_new_item' => __('Add New Parking Location'),
		'edit_item' => __('Edit Parking Location')
	);
	$args = array(
		'labels'             	=> $labels,
		'public'             	=> true,
		'publicly_queryable' 	=> true,
		'show_ui'				=> true,
		'show_in_menu'			=> true,
		'menu_icon'			=> 'dashicons-location',
		'query_var'         	=> true,
		'capability_type'   	=> 'post',
		'has_archive'       	=> true,
		'hierarchical'      	=> true,
		'menu_position'     	=> null,
		'supports'         	 	=> array( 'title', 'editor')
		// 'taxonomies'			=> array('cs_type')
	);

	register_post_type( 'ucf_parking', $args );
}


// =- =- =- =- -= =- =- =- -= =- =- =- -=
//	UCF Parking - Parking Type Taxonomy
// =- =- =- =- =- =- =- =- -= =- =- =- -=*/
add_action( 'init', 'register_parking_type_taxonomy' );
function register_parking_type_taxonomy() {

	$taxonomy = 'parking_type';
	$object_type = 'ucf_parking';

	$labels = array(
		'name'             			 => __( 'Parking Types'),
		'singular_name'              => __( 'Parking Type'),
		'edit_item'         		=> __( 'Edit Parking Type' ),
		'add_new_item'				=> __('Add New Parking Type')
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => false,
		'rewrite'           => array( 'slug' => 'type' ),
	);

	register_taxonomy( $taxonomy, $object_type, $args );
}

// =- =- =- =- =- =- =- =- =- =- =- =- =-
//
//	Signage Upload
//
// =- =- =- =- =- =- =- =- =- =- =- =- =- 
add_action('wp_ajax_signageupload', 'jtwc_upload_signage');
add_action('wp_ajax_nopriv_signageupload', 'jtwc_upload_signage');

// Upload and parse resume via AJAX
function jtwc_upload_signage() {
	
	ini_set('upload_max_filesize', '20M');
	ini_set('post_max_size', '20M');
	
	//define directory
	$dir = TEMPLATEPATH.'/library/includes/signage/';
	
	//store the resume locally. We can remove it later
	$the_file = $_FILES['signage_file'];
	
	// Extract file extension
	$ext = pathinfo($the_file['name'], PATHINFO_EXTENSION);
	$valid_ext = array( 'jpg', 'jpeg', 'png', 'pdf', 'txt', 'pages' );
	$is_valid_ext = (in_array($ext, $valid_ext)) ? true : false;

	$move = '';

	// die(json_encode($the_file));

	if($is_valid_ext){
		//move file
		$move = move_uploaded_file( $the_file['tmp_name'], $dir.$the_file['name'] );
	}

	
	//success?
	if($move && $is_valid_ext) {
		$result = array(
			'code' => 1,
			'filename' => $the_file['name'],
			'ext' => $ext,
			'valid_ext' => $valid_ext
		);
	}else {
		//error
		$result = array(
			'code' => 2,
			'message' => 'File Upload Error',
		);
	}
	
	header('Content-Type: application/json');
	die(json_encode($result));
}

function print_footer_partners($slug){

	global $post;

	$args = array(
		'post_type' => 'jtwc_partners',
		'posts_per_page' => -1,
		'post_status' => 'publish',
		'orderby' => 'name',
		'order' => 'ASC',
		'tax_query' => array(
			array (
				'taxonomy' => 'partner_type',
				'terms' => $slug,
				'field' => 'slug'
			)
		)
	);
	$posts_array = get_posts($args);

	?>

		<ul class="menu">

			<?php foreach($posts_array as $post){ setup_postdata($post); ?>
					
				<?php if (get_field('partner_url', $post->ID)){ ?>
					<li class="menu-item">
						<a href="<?php echo get_field('partner_url', $post->ID); ?>" target="_blank"><?php echo get_the_title(); ?></a>
					</li>
				<?php } else { ?>
					<li class="menu-item">
						<a href="https://businessservices.ucf.edu" target="_blank"><?php echo get_the_title(); ?></a>
					</li>
				<?php } ?>

			<?php } ?>

		</ul>

	<?php wp_reset_postdata(); ?>

<?php }


if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title' 	=> 'Footer Custom Fields',
		'menu_title'	=> 'Footer',
		'menu_slug' 	=> 'footer-fields',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
	
}