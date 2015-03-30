<?php 

if ( ! function_exists( 'get_top_level_category' )) {
	function get_top_level_category($id, $taxonomy = 'category'){
		$term = get_top_level($id, $taxonomy);
		$term_id = ($term) ? $term : $id;
		return get_term_by( 'id', $term_id, $taxonomy);
	}
}

if ( ! function_exists( 'get_top_level_term' ) ) {
	function get_top_level_term($id, $taxonomy = 'category'){
		$term = get_top_level($id, $taxonomy);
		$term_id = ($term) ? $term : $id;
		return get_term_by( 'id', $term_id, $taxonomy);
	}
}

if ( ! function_exists( 'get_top_level' )) {
	function get_top_level($id, $object){
		$terms = get_ancestors($id, $object);
		return (!empty($terms)) ? $terms[count($terms) - 1] : null;
	}
}

if ( ! function_exists( 'get_sub_category' )) {
	function get_sub_category($id){
		$sub_categories = get_categories( array('child_of' => $id, 'hierarchical' => false, 'orderby' => 'count'));
		foreach($sub_categories as $sub_category){
			if(has_category($sub_category->term_id)){
				$category = $sub_category;
			}
		}

		return (isset($category)) ? $category : null;
	}
}

if ( ! function_exists( 'get_adjacent_fukn_post' )) {
	function get_adjacent_fukn_post($adjacent, $args = array()){
		$previous = ($adjacent == 'next') ? false : true;
		return get_adjacent_post(false, '', $previous);
	}
}

if ( ! function_exists( 'get_latest_post' )) {
	function get_latest_post() {
		$posts = get_posts(array('posts_per_page' => 1));
		return $posts[0];
	}
}

if ( ! function_exists( 'get_current_url' )) {
	function get_current_url() {
		$url = 'http';
		if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') $url .= 's';
			$url .= '://';

		if ($_SERVER['SERVER_PORT'] != '80') {
			$url .= $_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].$_SERVER['REQUEST_URI'];
		} else {
			$url .= $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
		}
		return $url;
	}
}

if ( ! function_exists( 'get_queried_page' )) {
	function get_queried_page($depth = 0){
		$curr_url = get_current_url();
		if($depth != -1) $curr_url = strtok($curr_url, '?');

		$curr_uri = str_replace(get_bloginfo('url'), '', $curr_url);
		
		if($depth){
			$curr_uri_ary = array_filter(explode('/', $curr_uri));
			$curr_uri = trailingslashit(implode('/', array_splice($curr_uri_ary, 0, $depth)));
		}
		
		$page = get_page_by_path($curr_uri);
		if($page) return $page;
		return null;
	}
}

if(!function_exists('get_attachment_id_from_url')) {
	function get_attachment_id_from_url( $attachment_url = '' ) {
	 	global $wpdb;
		return $wpdb->get_var("SELECT ID FROM {$wpdb->posts} WHERE guid='$attachment_url'");		
	}
}

if(!function_exists('get_excerpt')) {
	function get_excerpt($count = 100, $post_id = null){
		global $post;
		
		if($post_id) {
			$post = get_post($post_id);
		}
		
		$excerpt = ( !empty($post->post_excerpt) ) ? $post->post_excerpt : get_the_content();
		$excerpt = strip_tags($excerpt);
		$excerpt = substr($excerpt, 0, $count);
		$excerpt = strip_shortcodes($excerpt);

		if( !empty($excerpt) ) $excerpt .= '...';
		return $excerpt;
	}
}

if(!function_exists('get_post_thumbnail_src')) {
	function get_post_thumbnail_src($size = 'thumbnail'){
		global $post;
		$thumbnail_id = get_post_thumbnail_id();
		return get_image($thumbnail_id, $size);
	}
}

if(!function_exists('get_image')) {
	function get_image($id, $size = 'thumbnail'){
		
		if( is_array($size) ) $size['bfi_thumb'] = true;

		$image = wp_get_attachment_image_src($id, $size);

		if( !empty($image[0]) ) return $image[0];
		return;
	}
}

if ( ! function_exists( 'include_template_part' ) ) {
	function include_template_part($slug, $data = array()){
		
		$templates = array();
		$templates[] = "{$slug}.php";
		
		do_action( "get_template_part_{$slug}", $slug, $data );

		if( is_array($data) ) extract($data);
		
		include(locate_template($templates));		
	}
}

if ( ! function_exists( 'include_module' ) ) {
	function include_module($slug, $data = '') {
		include_template_part('inc/modules/'. $slug, $data);
	}
}