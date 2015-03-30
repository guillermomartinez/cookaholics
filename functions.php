<?php

define('THEME_NAME', 'cookaholics');

$template_directory = get_template_directory();

$template_directory_uri = get_template_directory_uri();

require( $template_directory . '/inc/default/functions.php' );

require( $template_directory . '/inc/default/hooks.php' );

require( $template_directory . '/inc/default/shortcodes.php' );

// Custom Actions

add_action( 'after_setup_theme', 'custom_setup_theme' );

add_action( 'init', 'custom_init');

add_action( 'wp', 'custom_wp');

add_action( 'widgets_init', 'custom_widgets_init' );

add_action( 'wp_enqueue_scripts', 'custom_scripts', 30);

add_action( 'wp_print_styles', 'custom_styles', 30);


// Custom Filters



//Custom shortcodes


function custom_setup_theme() {
	
	add_theme_support( 'automatic-feed-links' );
	
	add_theme_support( 'post-thumbnails' );
	
	add_theme_support( 'html5' );

	add_theme_support('editor_style');

	add_post_type_support('page', 'excerpt');


	register_nav_menus( array(
		'primary' => __( 'Primary', THEME_NAME ),
		'secondary' => __( 'Secondary', THEME_NAME ),
	) );

	add_editor_style('css/editor-style.css');

}

function custom_init(){
	global $template_directory;

	require( $template_directory . '/inc/classes/bfi-thumb.php' );

	require( $template_directory . '/inc/classes/custom-post-type.php' );	

		$cookaholics = new Custom_Post_Type( 'Cookaholic', 
			array(
				'rewrite' => array('with_front' => false, 'slug' => 'cookaholics'),
				'capability_type' => 'post',
				'publicly_queryable' => true,
				'has_archive' => false, 
				'hierarchical' => true,
				'menu_position' => null,
				'menu_icon' => 'dashicons-admin-users',
				'supports' => array('title',  'page-attributes', 'thumbnail', 'editor'),
				'plural' => "Cookaholics",		
			)
		);

		$cookaholics->register_post_type();


	$edit_editor = get_role('editor'); // Get the user role
    $edit_editor->add_cap('edit_users');
    $edit_editor->add_cap('list_users');
    $edit_editor->add_cap('promote_users');
    $edit_editor->add_cap('create_users');
    $edit_editor->add_cap('add_users');
    $edit_editor->add_cap('delete_users');
    $edit_editor->add_cap('manage_nav_menus');
    $edit_editor->add_cap('manage_widgets');
    $edit_editor->add_cap('edit_theme_options');
}

//if( function_exists('acf_add_options_page') ) acf_add_options_page();

function custom_wp(){
	
}

function custom_widgets_init() {
	global $template_directory;

	//require( $template_directory . '/inc/widgets/post.php' );
	
	register_sidebar( array(
		'name' => __( 'Default', THEME_NAME ),
		'id' => 'default',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',	
	) );

	register_sidebar( array(
		'name' => __( 'Homepage - Carousel', THEME_NAME ),
		'id' => 'homepage_carousel',
		'description' => __('The Post widget is only supported for this widget area'),
		'before_widget' => '<div id="%1$s" class="widget item %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',			
	) );

	register_sidebar( array(
		'name' => __( 'Homepage - Sidebar', THEME_NAME ),
		'id' => 'homepage_sidebar',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',			
	) );

	register_sidebar( array(
		'name' => __( 'Homepage - Top', THEME_NAME ),
		'id' => 'homepage_top',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>'
	) );

	register_sidebar( array(
		'name' => __( 'Homepage - Bottom', THEME_NAME ),
		'id' => 'homepage_bottom',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>'
	) );

	register_sidebar( array(
		'name' => __( 'Categories', THEME_NAME ),
		'id' => 'categories',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>'
	) );

	register_sidebar( array(
		'name' => __( 'About Page', THEME_NAME ),
		'id' => 'about-page',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>'
	) );	

	
}

function custom_scripts() {
	global $template_directory_uri, $post;

	wp_enqueue_script('jquery');

	wp_enqueue_script('modernizr', $template_directory_uri.'/js/libs/modernizr.min.js', null, '', true);
	//wp_enqueue_script('plugins', $template_directory_uri.'/js/plugins.js', array('jquery', 'modernizr'), '', true);
	wp_enqueue_script('owlcarousel', $template_directory_uri.'/js/plugins/jquery.owlcarousel.js', array('jquery'), '', true);
	wp_enqueue_script('imagesloaded', $template_directory_uri.'/js/plugins/jquery.imagesloaded.js', array('jquery'), '', true);
	wp_enqueue_script('main', $template_directory_uri.'/js/main.js', array('jquery', 'modernizr'), '', true);

	wp_localize_script( 'main', 'url', array(
		'template' => $template_directory_uri,
		'base' => site_url(),
		'ajax' => admin_url('admin-ajax.php')
	));

	if( !empty($post) ) {
		wp_localize_script( 'main', 'post', array(
			'id' => $post->ID
		));
	}

	wp_register_script('infinitescroll', $template_directory_uri.'/js/plugins/jquery.infinitescroll.js', array('jquery'), '', true);
}


function custom_styles() {
	global $wp_styles, $template_directory_uri;

	wp_enqueue_style( 'style', $template_directory_uri . '/css/style.css' );	

	wp_dequeue_style('gforms_formsmain_css');

}

add_filter('next_post_link', 'post_link_attributes');
add_filter('previous_post_link', 'post_link_attributes');
 
function post_link_attributes($output) {
    $code = 'class="next-btn"';
    return str_replace('<a href=', '<a '.$code.' href=', $output);
}

//Page Slug Body Class
function add_slug_body_class( $classes ) {
	global $post;
	if ( isset( $post ) ) {
		$classes[] = $post->post_type . '-' . $post->post_name;
	}
	return $classes;
}
add_filter( 'body_class', 'add_slug_body_class' );
