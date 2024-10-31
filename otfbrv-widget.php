<?php

/**
 * Facebook Reviews Widget
 *
 * @description: The Facebook Reviews Widget
 * @since      : 1.0
 */

class OT_Facebook_Reviews_Widget extends WP_Widget {

    public $options;

    public $widget_fields = array(
        'title'                => '',
        'layout'           => '',
        'reviewlimit'           => 10,
        'reviewcolumns'         => 1,
        'reviewempty'           => '1',
        'reviewstar'           => '4',
        'imagewidth'           => 100,
        'imageheight'           => 100,
        'widgetclass'           => '',
    );

    public function __construct() {
        parent::__construct(
            'otfbrv_widget', // Base ID
            'OT Facebook Reviews', // Name
            array(
                'classname'   => 'otfbrv-widget',
                'description' => otfbrv_e('Display Facebook Reviews on your website.')
            )
        );
        add_action( 'wp_enqueue_scripts', array($this,'otfbrv_widget_style_scripts') );
    }

    function otfbrv_widget_style_scripts() {
        $settings = (array) get_option( 'otfbrv-plugin-settings' );
        wp_enqueue_style( 'otfbrv_widget_css', plugins_url('/assets/css/otfbrv.css', __FILE__) );
        if($settings['otfbrv_bootstrap'] == '1') {
            wp_enqueue_script( 'otfbrv_widget_bootstrap_js', plugins_url('/assets/js/bootstrap.min.js', __FILE__), array( 'jquery' ) );
            wp_enqueue_style('otfbrv_widget_bootstrap_css', plugins_url('/assets/css/bootstrap.min.css', __FILE__));
        }
    }

    function widget($args, $instance) {
        extract($args);
        foreach ($this->widget_fields as $variable => $value) {
            ${$variable} = !isset($instance[$variable]) ? $this->widget_fields[$variable] : esc_attr($instance[$variable]);
        }
        $settings = (array) get_option( 'otfbrv-plugin-settings' ); ?>

        <div class="widget otfbrv-widget <?php echo $widgetclass ?>">
            <?php if($title) echo '<h2 class="otfbrv-widget-title widget-title">'.$title.'</h2>'; ?>
            <?php if($layout == '1') {
                echo otfbrv_slide_layout_output($settings['otfbrv_pageid'],$settings['otfbrv_token'],$reviewlimit,$reviewstar,$reviewempty);
            } elseif ($layout == '2') {
                echo otfbrv_list_layout_output($settings['otfbrv_pageid'],$settings['otfbrv_token'],$reviewlimit,$reviewstar,$reviewempty,$imagewidth,$imageheight);
            } else {
                echo otfbrv_grid_layout_output($settings['otfbrv_pageid'],$settings['otfbrv_token'],$reviewlimit,$reviewstar,$reviewempty,$reviewcolumns,$imagewidth,$imageheight);
            }
            ?>
        </div>
        

        <?php 
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        foreach ($this->widget_fields as $field => $value) {
            $instance[$field] = strip_tags(stripslashes($new_instance[$field]));
        }
        return $instance;
    }

    function form($instance) {
        global $wp_version;
        foreach ($this->widget_fields as $field => $value) {
            if (array_key_exists($field, $this->widget_fields)) {
                ${$field} = !isset($instance[$field]) ? $value : esc_attr($instance[$field]);
            }
        } ?>

        <div id="<?php echo $this->id; ?>">
            <?php include(dirname(__FILE__) . '/otfbrv-options.php'); ?>
        </div>

        <?php
    }
}
?>