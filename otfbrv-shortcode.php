<?php
/**
 * Function otfb_message_shortcode()  is used to create shortcode for plugin.
*/
function otfbrv_shortcode($atts) {
	$settings = (array) get_option( 'otfbrv-plugin-settings' );
	extract(shortcode_atts(array(
      'layout' => '',
      'limit' => '',
      'columns' => '',
      'width' => '',
      'height' => '',
      ), $atts));
	
	if($atts && $atts['layout']) {
		$layout = $atts['layout'];
	} else {
	    $layout = 'list';
  	}

  	if($atts && $atts['limit']) {
		$limit = $atts['limit'];
	} else {
	    $limit = $settings['otfbrv_limit'];
  	}

  	if($atts && $atts['columns']) {
		$columns = intval($atts['columns']);
	} else {
	    $columns = 1;
  	}

  	if($atts && $atts['width']) {
		$width = intval($atts['width']);
	} else {
	    $width = 100;
  	}

  	if($atts && $atts['height']) {
		$height = intval($atts['height']);
	} else {
	    $height = 100;
  	}

	ob_start();
 	?>
	<?php 
	if($layout == 'list') {
		echo otfbrv_list_layout_output($settings['otfbrv_pageid'],$settings['otfbrv_token'],$limit,$settings['otfbrv_reviewstar'],$settings['otfbrv_reviewempty'],$width,$height);
	} elseif($layout == 'grid') {
		echo otfbrv_grid_layout_output($settings['otfbrv_pageid'],$settings['otfbrv_token'],$limit,$settings['otfbrv_reviewstar'],$settings['otfbrv_reviewempty'],$columns,$width,$height);
	} elseif($layout == 'slider') {
		echo otfbrv_slide_layout_output($settings['otfbrv_pageid'],$settings['otfbrv_token'],$limit,$settings['otfbrv_reviewstar'],$settings['otfbrv_reviewempty']);
	}

	$shortcodeData = ob_get_contents(); 
	ob_end_clean();
	return $shortcodeData;
}

/**
 * Function ottwitter_register_shortcodes()  is used to register shortcode.
*/
function otfbrv_register_shortcodes(){
	add_shortcode('otfbrv', 'otfbrv_shortcode');
}
add_action( 'init', 'otfbrv_register_shortcodes');

add_action( 'wp_enqueue_scripts', 'otfbrv_required_style_scripts' );
function otfbrv_required_style_scripts() {
    $settings = (array) get_option( 'otfbrv-plugin-settings' );
    wp_enqueue_style( 'otfbrv_css', plugins_url('/assets/css/otfbrv.css', __FILE__) );
    if($settings['otfbrv_bootstrap'] == '1') {
    	wp_enqueue_script( 'otfbrv_bootstrap_js', plugins_url('/assets/js/bootstrap.min.js', __FILE__), array( 'jquery' ) );
		wp_enqueue_style('otfbrv_bootstrap_css', plugins_url('/assets/css/bootstrap.min.css', __FILE__));
	}
}