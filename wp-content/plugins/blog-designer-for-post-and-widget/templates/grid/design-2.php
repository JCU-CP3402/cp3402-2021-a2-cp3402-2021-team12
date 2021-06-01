<?php
/**
 * Template for Blog Designer - Post and Widget Design 1
 *
 * @package Blog Designer - Post and Widget
 * @version 1.0.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} 

global $post;

if($gridcol == '2') {
	$post_grid = "6";
} else if($gridcol == '3') {
	$post_grid = "4";
}  else if($gridcol == '4') {
	$post_grid = "3";
} else if ($gridcol == '1') {
	$post_grid = "12";
} else {
	$post_grid = "12";
}
?>

<div class="wpspw-post-grid wpspw-medium-<?php echo $post_grid; ?> wpspw-columns <?php echo $css_class; ?>">
	<div class="wpspw-post-grid-content <?php if ( empty($feat_image) ) { echo 'no-thumb-image'; } ?> ">

		<?php if ( $feat_image ) { ?>
			<div class="wpspw-post-image-bg">
				<a href="<?php the_permalink(); ?>">
					<img src="<?php echo $feat_image; ?>" alt="<?php the_title_attribute(); ?>" />
				</a>
				<?php if($show_date == "true" || $show_author == 'true') { ?>
					<div class="wpspw-post-date">
						<?php if($show_author == 'true') { ?>
							<span>
								<?php esc_html_e( 'By', 'blog-designer-for-post-and-widget' ); ?> <a href="<?php echo esc_url( get_author_posts_url( $post->post_author ) ); ?>"><?php the_author(); ?></a>
							</span>
						<?php } ?>

						<?php echo ($show_author == 'true' && $show_date == 'true') ? '&nbsp;/&nbsp;' : '' ?>

						<?php if($show_date == "true") { echo get_the_date(); } ?>
					</div>
				<?php } ?>
			</div>
		<?php } ?>
		<div class="wpspw-post-details-wrapper">
			<?php if($show_category == "true") { ?>
				<div class="wpspw-post-categories"><?php echo $cate_name; ?></div>
			<?php } ?>

			<h2 class="wpspw-post-title">
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</h2>

			<?php if($show_content == "true") { ?>
				<div class="wpspw-post-content">
					<?php if($show_full_content == "false" ) { ?>
						<div><?php echo bdpw_get_post_excerpt( $post->ID, get_the_content(), $words_limit); ?></div>
						<a class="wpspw-readmorebtn" href="<?php the_permalink(); ?>"><?php _e('Read More', 'blog-designer-for-post-and-widget'); ?></a>
						<?php
					} else {
						the_content();
					} ?>
				</div>
			<?php } ?>
			<?php if(!empty($tags) && $show_tags == 'true') { ?>
				<div class="wpswp-post-tags"><?php echo $tags;  ?></div>
			<?php } ?>

			<?php if(!empty($comments) && $show_comments == 'true') { ?>
				<div class="wpswp-post-comments">
					<a href="<?php the_permalink(); ?>/#comments"><?php echo $comments.' '.$reply;  ?></a>
				</div>
			<?php } ?>
		</div>
	</div>
</div>