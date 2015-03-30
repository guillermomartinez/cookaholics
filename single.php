<?php get_header(); ?>
<?php wp_enqueue_script('expander'); ?>
<div id="single" class="container">
	<?php while ( have_posts() ) : the_post(); ?>
		<?php 
			$post_type = get_field('post_type');
			$featured_image_position = get_field('featured_image_position');
			$author_img_url = get_avatar_url ( get_the_author_meta('ID'), $size = '40' );
			$author_id = get_the_author_meta('ID');
			$category = get_post_category(); 
		?>

		<div class="sidebar-container">

			<div class="sidebar-content">

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<?php 
					$image_size = ($featured_image_position == 'top') ? array('width' => 800, 'height' => 530) : array('width' => 400, 'height' => 530);
					$image_url = get_post_thumbnail_src($image_size);
					$class = array( $featured_image_position . '-layout' ); 
					$class[] = (has_post_thumbnail()) ? 'has-featured-image' : 'no-featured-image'; 
					?>
				
					<?php include_module('single-post-header', array(
						'title' => get_the_title(),
						'image_url' => $image_url,
						'author' => array(
							'name' => 'Words by ' .get_the_author(),
							'image_url' => $author_img_url,
							'url' => get_author_posts_url($author_id),
						),
						'excerpt' => get_the_excerpt(),
						'category' => array(
							'name' => $category->name,
						),
						'class' => implode( ' ', $class)
					)); ?>

					<?php if( $post_type == 'recipe') :  ?>

					<div class="post-recipe">
						<?php include_module('post-ingredients'); ?>

						<?php include_module('post-tips'); ?>
					</div>

					<?php endif; ?>

					<div class="post-content">
						<?php the_content(); ?>
						<div class="written-by">
							<?php _e('Written by '); ?><?php the_author_posts_link(); ?>
						</div>
					</div>

					<?php include_module('post-products'); ?>				

				</article>

				<?php include_module('post-social', array(
					'title' => get_the_title(),
					'url' => get_permalink(),
					'image_url' => $image_url,
					'excerpt' => get_the_excerpt()
				)); ?>
	
				<?php include_module('post-navigation'); ?>

				<?php include_module('post-comments'); ?>
		
				<?php include_module('post-more-in-category', array(


				)); ?>				
			</div>
			<?php get_sidebar(); ?>
		</div>
	<?php endwhile; // end of the loop. ?>
	<?php //include_module('featured-posts'); ?>
</div><!-- #single -->
<?php include_module('featured-posts'); ?>

<?php get_footer(); ?>
