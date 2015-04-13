<?php
/*
Template Name: Form
*/?>
<?php get_header(); ?>
<div id="form">
	<a class="back-btn" href="" onclick="window.history.back();"><?php _e('Back'); ?></a>
	<div class="inner container">
		<?php while ( have_posts() ) : the_post(); ?>
		<div id="content">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<div class="page-content">
					<?php the_content(); ?>
				</div>
			
			</article>
		</div>
	<?php endwhile; // end of the loop. ?>

</div><!-- #single -->