<?php
/**
* Widget Class
*
* Latest Post List
*
* @package Blog Designer - Post and Widget
* @since 1.0.0
*/

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function bdpw_post_widget() {
	register_widget( 'Post_Thumb_Widget' );
}

// Action to register widget
add_action( 'widgets_init', 'bdpw_post_widget' );

class Post_Thumb_Widget extends WP_Widget {

	var $defaults;

	function __construct() {
		$widget_ops = array('classname' => 'wpspw_pro_post_thumb_widget', 'description' => __('Displayed Latest WP Post in list view ', 'blog-designer-for-post-and-widget') );
		parent::__construct( 'wpspw_pro_post_thumb_widget', __('Latest Blog Post List', 'blog-designer-for-post-and-widget'), $widget_ops);

		$this->defaults = array(
			'limit'				=> 5,
			'title'				=> __('Latest Blog Post List' ,'blog-designer-for-post-and-widget'),
			'date'				=> 1, 
			'show_category'		=> 1,
			'sticky_posts'      => 'false',
			'category'			=> 0,
			'order' 			=> 'DESC',
			'orderby'			=> 'date',
		);
	}

	/**
	* Handles updating settings for the current widget instance.
	*
	* @package Blog Designer - Post and Widget
	* @since 1.0
	*/
	function update($new_instance, $old_instance) {
		$instance 					= $old_instance;
		$instance['title'] 			= sanitize_text_field( $new_instance['title'] );
		$instance['limit'] 			= $new_instance['limit'];
		$instance['date'] 			= !empty($new_instance['date']) ? 1 : 0;
		$instance['show_category'] 	= !empty($new_instance['show_category']) ? 1 : 0;
		$instance['category'] 		= $new_instance['category'];
		$instance['sticky_posts']	= $new_instance['sticky_posts'];
		$instance['order'] 			= $new_instance['order'];
		$instance['orderby'] 		= $new_instance['orderby'];
		return $instance;
	}

	/**
	* Outputs the settings form for the widget.
	*
	* @package Blog Designer - Post and Widget
	* @since 1.0
	*/
	function form($instance) {  
		$instance = wp_parse_args( $instance, $this->defaults ); ?>

		<!-- Post Title -->
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"> 
				<?php esc_html_e( 'Title', 'blog-designer-for-post-and-widget' ); ?>:
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
			</label>
		</p>

		<!-- Post Limit -->
		<p>
			<label for="<?php echo $this->get_field_id('limit'); ?>">
				<?php esc_html_e( 'Number of Items', 'blog-designer-for-post-and-widget' ); ?>:
				<input class="widefat" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="text" value="<?php echo esc_attr( $instance['limit'] ); ?>" />
			</label>
		</p>

		<!-- Show Date -->
		<p>
			<input id="<?php echo $this->get_field_id( 'date' ); ?>" name="<?php echo $this->get_field_name( 'date' ); ?>" type="checkbox" value="1" <?php checked( $instance['date'], 1 ); ?> />
			<label for="<?php echo $this->get_field_id( 'date' ); ?>">
				<?php _e( 'Display Date', 'blog-designer-for-post-and-widget' ); ?>
			</label>
		</p>

		<!-- Show Category -->
		<p>
			<input id="<?php echo $this->get_field_id( 'show_category' ); ?>" name="<?php echo $this->get_field_name( 'show_category' ); ?>" type="checkbox" value="1" <?php checked( $instance['show_category'], 1 ); ?> />
			<label for="<?php echo $this->get_field_id( 'show_category' ); ?>">
				<?php _e( 'Display Category', 'blog-designer-for-post-and-widget' ); ?>
			</label>
		</p>

		<!-- Post Category -->
		<p>
			<label for="<?php echo $this->get_field_id( 'category' ); ?>">
				<?php _e( 'Category', 'blog-designer-for-post-and-widget' ); ?>:
			</label>
			<?php
			$dropdown_args = array( 
								'taxonomy'          => BDPW_CAT, 
								'class'             => 'widefat', 
								'show_option_all'   => __( 'All', 'blog-designer-for-post-and-widget' ), 
								'id'                => $this->get_field_id( 'category' ), 
								'name'              => $this->get_field_name( 'category' ), 
								'selected'          => $instance['category'] 
							);
			wp_dropdown_categories( $dropdown_args ); 
			?>
		</p>

		<!-- Post Order -->
		<p>
			<label for="<?php echo $this->get_field_id( 'order' ); ?>">
				<?php _e( 'Order', 'blog-designer-for-post-and-widget' ); ?>:
			</label>
			<select name="<?php echo $this->get_field_name( 'order' ); ?>" style="width: 100%;">
				<option value="desc" <?php selected($instance['order'], 'desc'); ?>><?php _e('Descending','blog-designer-for-post-and-widget'); ?></option>
				<option value="asc" <?php selected($instance['order'], 'asc'); ?>><?php _e('Ascending','blog-designer-for-post-and-widget'); ?></option>
			</select>
		</p>

		<!-- Post Ordering -->
		<p>
			<label for="<?php echo $this->get_field_id( 'orderby' ); ?>">
				<?php _e( 'Order', 'blog-designer-for-post-and-widget' ); ?>:
			</label>
			<select name="<?php echo $this->get_field_name( 'orderby' ); ?>" class="widefat">
				<option value="date" <?php selected($instance['orderby'], 'date'); ?>><?php _e('Post Date','blog-designer-for-post-and-widget'); ?></option>
				<option value="ID" <?php selected($instance['orderby'], 'ID'); ?>><?php _e('Post ID','blog-designer-for-post-and-widget'); ?></option>
				<option value="author" <?php selected($instance['orderby'], 'author'); ?>><?php _e('Post Author','blog-designer-for-post-and-widget'); ?></option>
				<option value="title" <?php selected($instance['orderby'], 'title'); ?>><?php _e('Post Title','blog-designer-for-post-and-widget'); ?></option>
				<option value="modified" <?php selected($instance['orderby'], 'modified'); ?>><?php _e('Post Modified Date','blog-designer-for-post-and-widget'); ?></option>
				<option value="rand" <?php selected($instance['orderby'], 'rand'); ?>><?php _e('Random','blog-designer-for-post-and-widget'); ?></option>
			</select>
		</p>

		<!-- Sticky Post -->
		<p>
			<label for="<?php echo $this->get_field_id( 'sticky_posts' ); ?>"><?php _e( 'Sticky Posts', 'blog-designer-for-post-and-widget' ); ?>:</label>
			<select name="<?php echo $this->get_field_name( 'sticky_posts' ); ?>" class="widefat" id="<?php echo $this->get_field_id( 'sticky_posts' ); ?>">
				<option value="false" <?php selected( $instance['sticky_posts'], 'false' ); ?>><?php _e( 'False', 'blog-designer-for-post-and-widget' ); ?></option>
				<option value="true" <?php selected( $instance['sticky_posts'], 'true' ); ?>><?php _e( 'True', 'blog-designer-for-post-and-widget' ); ?></option>
			</select>
		</p>
		<?php
	}

	/**
	* Outputs the content for the current widget instance.
	*
	* @package Blog Designer - Post and Widget
	* @since 1.0
	*/
	function widget($blog_args, $instance) {

		$instance = wp_parse_args( (array) $instance, $this->defaults );
		extract($blog_args, EXTR_SKIP);

		$title 			= apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		$num_items 		= $instance['limit'];
		$date 			= $instance['date'];
		$show_category 	= $instance['show_category'];
		$category 		= $instance['category'];
		$order 			= $instance['order'];
		$orderby 		= $instance['orderby'];
		$sticky_posts 	= ( $instance['sticky_posts'] == 'true' )	? false		: true;

		// Taking some globals
		global $post;

		// WP Query Parameters
		$blog_args = array(
			'posts_per_page' 		=> $num_items,
			'post_type' 			=> BDPW_POST_TYPE,
			'order' 				=> $order,
			'orderby' 				=> $orderby,
			'ignore_sticky_posts' 	=> $sticky_posts,
			'suppress_filters' 		=> true,
		);

		if( !empty($category) ) {
			$blog_args['tax_query'] = array(
										array( 
											'taxonomy'	=> BDPW_CAT,
											'field' 	=> 'term_id',
											'terms' 	=> $category
										));
		}

		// WP Query
		$cust_loop  = new WP_Query($blog_args);

		echo $before_widget;

		if ( $title ) {
			echo $before_title . $title . $after_title;
		}

		// If Post is there
		if ($cust_loop->have_posts()) {
	?>
		<div class="wpspw-pro-widget-wrp wpspw-clearfix">
			<div id="wpspw-pro-widget" class="wpspw-pro-sp-static sp_wpspwpost_static wpspw-design-w3">

			<?php while ($cust_loop->have_posts()) : $cust_loop->the_post();
					
					$feat_image 	= bdpw_get_post_featured_image( $post->ID, array(80,80),true );
					$terms 			= get_the_terms( $post->ID, BDPW_CAT );
					$blog_links 	= array();

					if($terms) {
						foreach ( $terms as $term ) {
							$term_link 		= get_term_link( $term );
							$blog_links[] 	= '<a href="' . esc_url( $term_link ) . '">'.$term->name.'</a>';
						}
					}

					$cate_name = join( " ", $blog_links );
				?>

				<div class="wpspw-post-list">
					<div class="wpspw-post-list-content">
						<div class="wpspw-post-left-img">
							<div class="wpspw-post-image-bg">
								<a href="<?php the_permalink(); ?>">
									<?php if( !empty($feat_image) ) { ?>
										<img src="<?php echo $feat_image; ?>" alt="<?php the_title_attribute(); ?>" />
									<?php } ?>
								</a>
							</div>
						</div>
						<div class="wpspw-post-right-content">
							<?php if( $show_category ) { 
								if($cate_name !='') { ?>
									<div class="wpspw-post-categories">
										<?php echo $cate_name; ?>
									</div>
								<?php }
							} ?>

							<div class="wpspw-post-title">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</div>

							<?php if($date) { ?>
								<div class="wpspw-post-date">
									<?php echo get_the_date(); ?>
								</div>
							<?php }?>
						</div>
					</div>
				</div>
		<?php endwhile; ?>
			</div>
		</div>
	<?php
		} // End if

		echo $after_widget;

		wp_reset_postdata(); // Reset WP Query
	}
}