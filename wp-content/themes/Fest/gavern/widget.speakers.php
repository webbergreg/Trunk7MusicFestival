<?php

/**
 * 
 * GK Speakers Widget class
 *
 **/

class GK_Speakers_Widget extends WP_Widget {
	/**
	 *
	 * Constructor
	 *
	 * @return void
	 *
	 **/
	function GK_Speakers_Widget() {
		$this->WP_Widget(
			'widget_gk_speakers', 
			__( 'GK Speakers', GKTPLNAME ), 
			array( 
				'classname' => 'widget_gk_speakers', 
				'description' => __( 'Use this widget to show rotator with speakers', GKTPLNAME) 
			)
		);
		
		$this->alt_option_name = 'widget_gk_speakers';

		add_action( 'save_post', array(&$this, 'refresh_cache' ) );
		add_action( 'delete_post', array(&$this, 'refresh_cache' ) );
		add_action('wp_enqueue_scripts', array('GK_Speakers_Widget', 'add_scripts'));
	}
		
	static function add_scripts() {
		wp_register_script( 'gk-speakers', get_template_directory_uri() . '/js/widgets/speakers.js', array('jquery'));
		wp_enqueue_script('gk-speakers');
	}

	/**
	 *
	 * Outputs the HTML code of this widget.
	 *
	 * @param array An array of standard parameters for widgets in this theme
	 * @param array An array of settings for this widget instance
	 * @return void
	 *
	 **/
	function widget($args, $instance) {
		$cache = get_transient(md5($this->id));
		
		// the part with the title and widget wrappers cannot be cached! 
		// in order to avoid problems with the calculating columns
		//
		extract($args, EXTR_SKIP);
		
		$title = apply_filters('widget_title', empty($instance['title']) ? __( 'Speakers', GKTPLNAME ) : $instance['title'], $instance, $this->id_base);
		
		echo $before_widget;
		echo $before_title;
		echo $title;
		echo $after_title;
		
		if($cache) {
			echo $cache;
			echo $after_widget;
			return;
		}

		ob_start();
		//
		$options_tmp = get_option('speakers_options');
		$category = empty($instance['category']) ? '' : $instance['category'];
		$anim_speed = empty($instance['anim_speed']) ? 500 : $instance['anim_speed'];
		$anim_interval = empty($instance['anim_interval']) ? 5000 : $instance['anim_interval'];
		//
		$gk_loop = new WP_Query( 'category_name=' . $category . '&post_type=' .$options_tmp['name'] . '&posts_per_page=-1');
		$speakers = array();
		
		while($gk_loop->have_posts()) {
			$gk_loop->the_post();
			
			array_push($speakers, array(
				'title' => get_the_title(),
				'img' => wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) ),
				'url' => get_permalink()
			));
		}
		
		wp_reset_postdata();
		
		if (count($speakers)) {			
			if(count($speakers) >= 5) {
				echo '<div class="gkw-speakers" data-animinterval="'.$anim_interval.'" data-animspeed="'.$anim_speed.'">
					<div class="gkw-speaker-big speaker-hide">
						<div>
							<a href="'.$speakers[2]['url'].'">
								<img src="'.$speakers[2]['img'].'" alt="'.$speakers[2]['title'].'" />
							</a>
						</div>
						<h4>
							<a href="'.$speakers[2]['url'].'" title="'.$speakers[2]['title'].'">'.$speakers[2]['title'].'</a>
						</h4>		
					</div>
				
					<div class="gkw-speakers-small-left">
						<div class="gkw-speaker-small speaker-hide">
							<div>
								<a href="'.$speakers[0]['url'].'">
									<img src="'.$speakers[0]['img'].'" alt="'.$speakers[0]['title'].'" />
								</a>
							</div>
							<h4>
								<a href="'.$speakers[0]['url'].'" title="'.$speakers[0]['title'].'">'.$speakers[0]['title'].'</a>
							</h4>
						</div>
					
						<div class="gkw-speaker-small speaker-hide">
							<div>
								<a href="'.$speakers[1]['url'].'">
									<img src="'.$speakers[1]['img'].'" alt="'.$speakers[1]['title'].'" />
								</a>
							</div>
							<h4>
								<a href="'.$speakers[1]['url'].'" title="'.$speakers[1]['title'].'">'.$speakers[1]['title'].'</a>
							</h4>
						</div>
					</div>
				
					<div class="gkw-speakers-small-right">
						<div class="gkw-speaker-small speaker-hide">
							<div>
								<a href="'.$speakers[3]['url'].'">
									<img src="'.$speakers[3]['img'].'" alt="'.$speakers[3]['title'].'" />
								</a>
							</div>
							<h4>
								<a href="'.$speakers[3]['url'].'" title="'.$speakers[3]['title'].'">'.$speakers[3]['title'].'</a>
							</h4>
						</div>
						
						<div class="gkw-speaker-small speaker-hide">
							<div>
								<a href="'.$speakers[4]['url'].'">
									<img src="'.$speakers[4]['img'].'" alt="'.$speakers[4]['title'].'" />
								</a>
							</div>
							<h4>
								<a href="'.$speakers[4]['url'].'" title="'.$speakers[4]['title'].'">'.$speakers[4]['title'].'</a>
							</h4>
						</div>
					</div>
				</div>
			
				<div class="gkw-rest-speakers">';
				
				for($i = 0; $i < count($speakers); $i++) {
				
					echo '<div class="gkw-speaker">
						<div>
							<a href="'.$speakers[$i]['url'].'">
								<img src="'.$speakers[$i]['img'].'" alt="'.$speakers[$i]['title'].'" />
							</a>
						</div>
						<h4>
							<a href="'.$speakers[$i]['url'].'" title="'.$speakers[$i]['title'].'">'.$speakers[$i]['title'].'</a>
						</h4>
					</div>';
				}
					
				echo '</div>';
			}
		}
		// save the cache results
		$cache_output = ob_get_flush();
		set_transient(md5($this->id) , $cache_output, 3 * 60 * 60);
		// 
		echo $after_widget;
	}

	/**
	 *
	 * Used in the back-end to update the module options
	 *
	 * @param array new instance of the widget settings
	 * @param array old instance of the widget settings
	 * @return updated instance of the widget settings
	 *
	 **/
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['category'] = strip_tags( $new_instance['category'] );
		$instance['anim_speed'] = strip_tags( $new_instance['anim_speed'] );
		$instance['anim_interval'] = strip_tags( $new_instance['anim_interval'] );
		$this->refresh_cache();

		$alloptions = wp_cache_get('alloptions', 'options');
		if(isset($alloptions['widget_gk_speakers'])) {
			delete_option( 'widget_gk_speakers' );
		}

		return $instance;
	}

	/**
	 *
	 * Refreshes the widget cache data
	 *
	 * @return void
	 *
	 **/

	function refresh_cache() {
		delete_transient(md5($this->id));
	}
	
	/**
	 *
	 * Limits the comment text to specified words amount
	 *
	 * @param string input text
	 * @param int amount of words
	 * @return string the cutted text
	 *
	 **/
	
	function comment_text($input, $amount = 20) {
		$output = '';
		$input = strip_tags($input);
		$input = explode(' ', $input);
		
		for($i = 0; $i < $amount; $i++) {
			$output .= $input[$i] . ' ';
		}
	
		return $output;
	}

	/**
	 *
	 * Outputs the HTML code of the widget in the back-end
	 *
	 * @param array instance of the widget settings
	 * @return void - HTML output
	 *
	 **/
	function form($instance) {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$category = isset($instance['category']) ? esc_attr($instance['category']) : '';
		$anim_speed = isset($instance['anim_speed']) ? esc_attr($instance['anim_speed']) : '';
		$anim_interval = isset($instance['anim_interval']) ? esc_attr($instance['anim_interval']) : '';
	
	?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', GKTPLNAME ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>"><?php _e( 'Category slug:', GKTPLNAME ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'category' ) ); ?>" type="text" value="<?php echo esc_attr( $category ); ?>" />
		</p>
		
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'anim_speed' ) ); ?>"><?php _e( 'Animation speed (in ms):', GKTPLNAME ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'anim_speed' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'anim_speed' ) ); ?>" type="text" value="<?php echo esc_attr( $anim_speed ); ?>" />
		</p>
		
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'anim_interval' ) ); ?>"><?php _e( 'Animation interval (in ms):', GKTPLNAME ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'anim_interval' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'anim_interval' ) ); ?>" type="text" value="<?php echo esc_attr( $anim_interval ); ?>" />
		</p>		
	<?php
	}
}

// EOF