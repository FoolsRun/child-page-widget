<?php
/*
Plugin Name: Child Pages
Description: Display child pages of a particular parent as a widget
Author: FoolsRun
Version: 1.1
*/
 
 
class SubPagesWidget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'Sub_Pages_Widget',
            'Child Pages',
            array( 'description' => 'Choose a page and show only its sub pages as links in a widget.' )
        );
    }
  
  /* Widget Display */
	public function widget( $args, $instance )
	{
	 
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
	 
		echo $before_widget;
		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;
				
		//Get the parent page
		$parent_page     = $instance['parentpage'];
		
		//Limit the number of pages shown
		$limit_pages     = $instance['pagestoshow'];
		
		//What should we sort the pages by?
		$sort_by     = $instance['pagesortby'];
		
		//Secending or descending?
		$pageorderby     = $instance['pageorderby'];		
		
		$args = array(
			'depth'        => 0,
			'child_of'     => $parent_page,
			'title_li'     => '',
			'echo'         => 1,
			'sort_column'  => $sort_by,
			'post_type'    => 'page',
				'post_status'  => 'publish' 
		);
		?> <ul> <?php
		wp_list_pages( $args );
		?> </ul> <?php
	}
		
		
	/* Widget Update Functions */
	public function update( $new_instance, $old_instance )
	{
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['parentpage'] = strip_tags( $new_instance['parentpage'] );
		$instance['pagestoshow'] = strip_tags( $new_instance['pagestoshow'] );
		$instance['pagesortby'] = strip_tags( $new_instance['pagesortby'] );
		$instance['pageorderby'] = strip_tags( $new_instance['pageorderby'] );
		
		return $instance;
	}

	
	/* Widget Configuration Form */
	public function form( $instance )
	{
		$title = isset( $instance[ 'title' ] )  ? $instance[ 'title' ] : 'Sub-Pages';
		$parentpage = isset( $instance[ 'parentpage' ] )  ? $instance[ 'parentpage' ] : '';
		$pagestoshow = isset( $instance[ 'pagestoshow' ] )  ? $instance[ 'pagestoshow' ] : '5';
		$pagesortby = isset( $instance[ 'pagesortby' ] )  ? $instance[ 'pagesortby' ] : 'post_date';
		$pageorderby = isset( $instance[ 'pageorderby' ] )  ? $instance[ 'pageorderby' ] : 'DESC';

		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'parentpage' ); ?>"><?php _e( 'Display sub pages of this page (required):' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'parentpage' ); ?>" name="<?php echo $this->get_field_name( 'parentpage' ); ?>" type="text" value="<?php echo esc_attr( $parentpage ); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'pagestoshow' ); ?>"><?php _e( 'Number of sub-pages to display:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'pagestoshow' ); ?>" name="<?php echo $this->get_field_name( 'pagestoshow' ); ?>" type="text" value="<?php echo esc_attr( $pagestoshow ); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'pagesortby' ); ?>"><?php _e( 'Sort sub-pages by:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'pagesortby' ); ?>" name="<?php echo $this->get_field_name( 'pagesortby' ); ?>" type="text" value="<?php echo esc_attr( $pagesortby ); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'pageorderby' ); ?>"><?php _e( 'Sort pages by:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'pageorderby' ); ?>" name="<?php echo $this->get_field_name( 'pageorderby' ); ?>" type="text" value="<?php echo esc_attr( $pageorderby ); ?>" />
		</p>
		<?php
	}

}
add_action( 'widgets_init', create_function( '', 'register_widget( "SubPagesWidget" );' ) );
?>
