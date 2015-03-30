<?php get_header(); ?>
<section id="front-page">
	<div id="header">
		<h1 class="site-title"><?php bloginfo('name'); ?></h1>
	</div>

	<?php 
		$cooks = get_field('select_cookaholics');
	if( $cooks ): ?>
		<ul id="cook-list">
		<?php foreach( $cooks as $p ): // variable must NOT be called $post (IMPORTANT) ?>
		    <li>
				<?php 
					$image_size = array('width' => 214, 'height' => 214);
					$image = get_image(get_post_thumbnail_id($p->ID) , $image_size);					
				?>
				<a href="<?php echo get_permalink( $p->ID ); ?>">
					<img class="recipe-image" src="<?php echo $image; ?>" />
					<span class="cook-name">
		    			<?php echo get_the_title( $p->ID ); ?>
		    		</span>				    
		    	</a>
		    </li>
		<?php endforeach; ?>
		<?php wp_reset_postdata(); ?>
		</ul>
	<?php endif; ?>			

	<div id="content">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>		

				<?php the_content(); ?>

			<?php endwhile; ?>
		<?php endif; ?>
		<a href="<?php echo get_permalink(21); ?>" class="primary-btn"><?php _e('Meet the Cookaholics'); ?></a>
	</div>
</section>
<?php get_footer(); ?>
