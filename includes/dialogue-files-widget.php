<?php 
add_action( 'widgets_init', 'your_simple_widget' );
function your_simple_widget() {
    register_widget( 'Your_Simple_Same_Widget' );
}

class Dialogue_Files extends WP_Widget {

    //=======> Widget setup
    function Dialogue_Files() {
        /* Widget settings. */
    $widget_ops = array( 'classname' => 'mith_dd_files', 'description' => __('Displays the files associated with the digital dialogue on the page.', 'Avada') );

        /* Widget control settings. */
    $control_ops = array( 'id_base' => 'mith_dd_files-widget' );

    /* Create the widget. */
    $this->WP_Widget( 'mith_dd_files-widget', 'MITH: Dialogue Files', $widget_ops, $control_ops );
    }

    //=======> How to display the widget on the screen.
    function widget($args, $instance) {

		extract($args);
		
		$title = apply_filters('widget_title', $instance['title']);
		$description = apply_filters('widget_description', $instance['description']);

		echo $before_widget;

		if($title) {
			echo $before_title.$title.$after_title;
		}
		if($description) {
			echo '<p>' . $description . '</p>';
		}

        echo $after_widget;
    }

    //=======>Update the widget 
    function update($new_instance, $old_instance) {
		
        $instance = $old_instance;

        //Strip tags from title and name to remove HTML 
        $instance['title'] = $new_instance['title'];
        //$instance['description'] = $new_instance['description'];
        return $instance;
    }

    //=======>widget Display
    function form($instance) {
        //Set up some default widget settings.
        $instance = wp_parse_args((array) $instance);
?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">Widget Title:</label>
            <input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" style="width:275px;" />
        </p>
    <p>
            <label for="<?php echo $this->get_field_id('description'); ?>">Widget Title:</label>
            <input id="<?php echo $this->get_field_id('description'); ?>" name="<?php echo $this->get_field_name('description'); ?>" value="<?php echo $instance['description']; ?>" style="width:275px;" />
        </p>
<?php
    }

}
?>