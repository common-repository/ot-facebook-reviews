<?php

add_action( 'admin_init', 'otfbrv_admin_init' );

function otfbrv_admin_init() {
  
  	register_setting( 'otfbrv-settings-group', 'otfbrv-plugin-settings' );
  	add_settings_section( 'section-1', __( 'Facebook page setting', 'otfbrv' ), 'otfbrv_section_1_callback', 'otfbrv-plugin' );
  	
  	add_settings_field( 'otfbrv_pageid', __( 'Facebook page ID', 'otfbrv' ), 'otfbrv_pageid_callback', 'otfbrv-plugin', 'section-1' );
  	add_settings_field( 'otfbrv_token', __( 'Facebook Page Access Token', 'otfbrv' ), 'otfbrv_token_callback', 'otfbrv-plugin', 'section-1' );
  	add_settings_field( 'otfbrv_limit', __( 'Review limit', 'otfbrv' ), 'otfbrv_limit_callback', 'otfbrv-plugin', 'section-1' );
  	add_settings_field( 'otfbrv_reviewempty', __( 'Show reviews without comment', 'otfbrv' ), 'otfbrv_reviewempty_callback', 'otfbrv-plugin', 'section-1' );
  	add_settings_field( 'otfbrv_starimage', __( 'Star Image', 'otfbrv' ), 'otfbrv_starimage_callback', 'otfbrv-plugin', 'section-1' );
  	add_settings_field( 'otfbrv_reviewstar', __( 'Show reviews from', 'otfbrv' ), 'otfbrv_reviewstar_callback', 'otfbrv-plugin', 'section-1' );
  	add_settings_field( 'otfbrv_bootstrap', __( 'Include Bootstrap', 'otfbrv' ), 'otfbrv_bootstrap_callback', 'otfbrv-plugin', 'section-1' );
}

function otfbrv_section_1_callback() {
	
}

function otfbrv_pageid_callback() {
	
	$settings = (array) get_option( 'otfbrv-plugin-settings' );
	$field = "otfbrv_pageid";
	
	$value = esc_attr( $settings[$field] );	
	
	echo "<input type='text' size='40' name='otfbrv-plugin-settings[$field]' value='$value' />";
}

function otfbrv_token_callback() {
	
	$settings = (array) get_option( 'otfbrv-plugin-settings' );
	$field = "otfbrv_token";
	
	$value = esc_attr( $settings[$field] );
	
	echo "<textarea type='text' rows='5' cols='41' name='otfbrv-plugin-settings[$field]'>".$value."</textarea>";
}

function otfbrv_limit_callback() {
	
	$settings = (array) get_option( 'otfbrv-plugin-settings' );
	$field = "otfbrv_limit";
	
	if(esc_attr( $settings[$field] )) {
		$value = esc_attr( $settings[$field] );
	} else {
		$value = 10;
	}
		
	echo "<input type='number' name='otfbrv-plugin-settings[$field]' value='$value' />";
}

function otfbrv_reviewempty_callback() {	
	$settings = (array) get_option( 'otfbrv-plugin-settings' );
	$field = "otfbrv_reviewempty";
	$value = esc_attr( $settings[$field] ); ?>
	 
	<select name='otfbrv-plugin-settings[<?php echo $field ?>]' id='otfbrv-plugin-settings[<?php echo $field ?>]'>
		<option value="1" <?php selected( $value, '1' ); ?>><?php echo otfbrv_e('Yes'); ?></option>
		<option value="0" <?php selected( $value, '0' ); ?>><?php echo otfbrv_e('No'); ?></option>
	</select>
	<?php
}

function otfbrv_starimage_callback() {	
	$settings = (array) get_option( 'otfbrv-plugin-settings' );
	$field = "otfbrv_starimage";
	$value = esc_attr( $settings[$field] ); ?>
	 
	<select name='otfbrv-plugin-settings[<?php echo $field ?>]' id='otfbrv-plugin-settings[<?php echo $field ?>]'>
		<option value="1" <?php selected( $value, '1' ); ?>><?php echo otfbrv_e('Default'); ?></option>
		<option value="2" <?php selected( $value, '2' ); ?>><?php echo otfbrv_e('Medium'); ?></option>
		<option value="3" <?php selected( $value, '3' ); ?>><?php echo otfbrv_e('Small'); ?></option>
	</select>
	<?php
}

function otfbrv_reviewstar_callback() {	
	$settings = (array) get_option( 'otfbrv-plugin-settings' );
	$field = "otfbrv_reviewstar";
	$value = esc_attr( $settings[$field] ); ?>
	 
	<select name='otfbrv-plugin-settings[<?php echo $field ?>]' id='otfbrv-plugin-settings[<?php echo $field ?>]'>
		<option value="1" <?php selected( $value, '1' ); ?>><?php echo otfbrv_e('1 star'); ?></option>
		<option value="2" <?php selected( $value, '2' ); ?>><?php echo otfbrv_e('2 star'); ?></option>
		<option value="3" <?php selected( $value, '3' ); ?>><?php echo otfbrv_e('3 star'); ?></option>
		<option value="4" <?php selected( $value, '4' ); ?>><?php echo otfbrv_e('4 star'); ?></option>
		<option value="5" <?php selected( $value, '5' ); ?>><?php echo otfbrv_e('5 star'); ?></option>
	</select>
	<?php
}

function otfbrv_bootstrap_callback() {	
	$settings = (array) get_option( 'otfbrv-plugin-settings' );
	$field = "otfbrv_bootstrap";
	$value = esc_attr( $settings[$field] ); ?>
	 
	<select name='otfbrv-plugin-settings[<?php echo $field ?>]' id='otfbrv-plugin-settings[<?php echo $field ?>]'>
		<option value="1" <?php selected( $value, '1' ); ?>><?php echo otfbrv_e('Yes'); ?></option>
		<option value="0" <?php selected( $value, '0' ); ?>><?php echo otfbrv_e('No'); ?></option>
	</select>
	<?php
}