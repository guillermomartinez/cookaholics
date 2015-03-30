<?php global $post; ?>
<?php get_header(); ?>
<div id="cookaholic">
	<div class="inner container">
		<header class="cook-header">
			<?php 
				$image_size = array('width' => 357, 'height' => 357);
				$image = get_post_thumbnail_src($image_size);					
			?>
			<div class="title">
				<h2><?php _e('Ask the cookaholics'); ?></h2>
				<h1><?php the_title(); ?></h1>
			</div>	
			
			<img class="featured-image" src="<?php echo $image; ?>" alt="<?php the_title(); ?>">		
		</header>
		<?php while ( have_posts() ) : the_post(); ?>

		<?php

		$post_object = get_field('choose_form');

		if( $post_object ): 

			// override $post
			$post = $post_object;
			setup_postdata( $post ); 

			?>
		    	<a class="ask-me-btn" href="<?php the_permalink(); ?>"><?php _e('Ask me a Question'); ?></a>

		    <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
		<?php endif; ?>			

		
		<div class="details">
			<?php 
				$image_size = array('width' => 240, 'height' => 291);
				$img = get_field('recipe_image');
				$image = bfi_thumb($img, $image_size);					
			?>				
			<img class="recipe-image" src="<?php echo $image; ?>" />
			<div class="list">
				<?php if(get_field('name')): ?>
					<div class="item"><span><?php _e('Name: ') ?></span><?php the_field('name');  ?></div>
				<?php endif; ?>
				<?php if(get_field('from')): ?>
					<div class="item"><span><?php _e('From: ') ?></span><?php the_field('from');  ?></div>
				<?php endif; ?>		
				<?php if(get_field('age')): ?>
					<div class="item"><span><?php _e('Age: ') ?></span><?php the_field('age');  ?></div>
				<?php endif; ?>	
				<?php if(get_field('key_baking_skills')): ?>
					<div class="item margin"><span><?php _e('Key Baking Skills: ') ?></span><?php the_field('key_baking_skills');  ?></div>
				<?php endif; ?>	
				<?php if(get_field('best_recipe')): ?>
					<div class="item margin"><span><?php _e('Best recipe: ') ?></span><?php the_field('best_recipe');  ?></div>
				<?php endif; ?>																									
				<?php if(get_field('favorite_recipe_book')): ?>
					<div class="item margin"><span><?php _e('Favorite Recipe Book: ') ?></span><?php the_field('favorite_recipe_book');  ?></div>
				<?php endif; ?>					
			</div>
		</div>

		<div id="content">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>	
				<div class="page-content">
					<?php the_content(); ?>
				</div>
				<a class="back-btn" href="" onclick="history.back();"><?php _e('Back'); ?></a>		
				<?php if( is_singular('cookaholic') ) { ?>
					<?php next_post_link( '%link', 'Next Expert' ) ?>
				<?php } ?>					
			</article>		
		</div>
	<?php endwhile; // end of the loop. ?>

</div><!-- #single -->
<?php get_footer(); ?>