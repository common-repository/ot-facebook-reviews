<?php

if (!current_user_can('manage_options')) {
    die('The account you\'re logged in to doesn\'t have permission to access this page.');
}

wp_enqueue_script('jquery');

wp_enqueue_script('otfbrv_admin_js', plugins_url('/assets/js/bootstrap.min.js', __FILE__));
wp_enqueue_style('otfbrv_admin_css', plugins_url('/assets/css/bootstrap.min.css', __FILE__));
wp_enqueue_style('otfbrv_setting_css', plugins_url('/assets/css/otfbrv-setting.css', __FILE__));
?>
<span class="version"><?php echo otfbrv_e('Version: %s', esc_html(OTFBRV_PLUGIN_VERSION)); ?></span>
<div class="otfbrv-setting container-fluid">
    <div class="otfbrv-facebook"><?php echo otfbrv_e('OT Facebook Reviews'); ?></div>
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#about" aria-controls="about" role="tab" data-toggle="tab"><?php echo otfbrv_e('About'); ?></a>
        </li>
        <li role="presentation">
            <a href="#setting" aria-controls="setting" role="tab" data-toggle="tab"><?php echo otfbrv_e('Setting'); ?></a>
        </li>
        <li role="presentation">
            <a href="#shortcode" aria-controls="shortcode" role="tab" data-toggle="tab"><?php echo otfbrv_e('Shortcode'); ?></a>
        </li>
    </ul>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="about">
            <div class="row">
                <div class="col-sm-6">
                	<h5><?php echo otfbrv_e('OT Facebook Reviews Plugin for WordPress'); ?></h5>
	                <div class="otfbrv-selling-points">
			     		<ul>
							<li><?php echo otfbrv_e('Show Facebook page Reviews on your site'); ?></li>
							<li><?php echo otfbrv_e('Allows you to choose the view mode: Grid, List and Slide layout'); ?></li>
							<li><?php echo otfbrv_e('Admin can set the limit of reviews to show on the page'); ?></li>
			      		</ul>
				    </div>
	                <p><?php echo otfbrv_e('OT Facebook Reviews plugin allow you get rating from facebook page to your Wordpress site. People do give reviews regarding the company/website/services on the Facebook page. If you receive any testimonials on your Facebook page, you should share it on your store too. Showcasing testimonials and reviews of the Facebook page on your store allows you to increase your brand credibility and leads to faster sales.'); ?></p>
	                <h6><strong><?php echo otfbrv_e('Why you should use Facebook Reviews?'); ?></strong></h6>
	                <p><?php echo otfbrv_e('Show Facebook Reviews on website to increase user confidence, traffic and sales'); ?></p>
	                <p><?php echo otfbrv_e('Trim long reviews so that your users can read them comfortably'); ?></p>
	                <p><?php echo otfbrv_e('Your customers are already viewing your site so why not make it easy for them to view your positive reviews? Now you can! With Facebook Reviews you can quickly and easily embed your reviews directly on your store.'); ?></p>
                </div>
                <div class="col-sm-6">
                	<h5><?php echo otfbrv_e('FAQ'); ?></h5>
                	<h6><strong><?php echo otfbrv_e('How can I find my page ID in Facebook?'); ?></strong></h6>
                	<p><?php echo otfbrv_e('To find your page id in facebook:'); ?></p>
                	<ul style="font-size: 13px;list-style: disc inside;">
                		<li><?php echo otfbrv_e('Go to your page'); ?></li>
                		<li><?php echo otfbrv_e('Click "About"'); ?></li>
                		<li><?php echo otfbrv_e('Click "Page Infor"'); ?></li>
                		<li><?php echo otfbrv_e('You can see "Facebook Page ID"'); ?></li>
                	</ul>
                	<h6><strong><?php echo otfbrv_e('How can I get Page access token?'); ?></strong></h6>
                    <ul style="font-size: 13px;list-style: disc inside;">
                        <li><?php echo otfbrv_e('Go to'); ?> <a href="https://developers.facebook.com/" target="_blank">developers.facebook.com</a> <?php echo otfbrv_e('to Log in using your personal Facebook credentials or Register if this is your first time signing in to the Facebook Developer portal'); ?></li>
                        <li><?php echo otfbrv_e('Hover over My Apps and then click on Add a New App.'); ?></li>
                        <li><?php echo otfbrv_e('When your App is now set up.  Click on Dashboard to find your app information.'); ?></li>
                        <li><?php echo otfbrv_e('Go to'); ?> <a href="https://developers.facebook.com/tools/accesstoken/">Access Token Tool of Facebook</a> <?php echo otfbrv_e('to get Access Token'); ?></li>
                    </ul>
                    
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="setting">
         	<form action="options.php" method="POST">
		        <?php settings_fields('otfbrv-settings-group'); ?>
		        <?php do_settings_sections('otfbrv-plugin'); ?>
		        <?php submit_button(); ?>
	      	</form>
        </div>
        <div role="tabpanel" class="tab-pane" id="shortcode">
        	<div class="row">
        		<h5><?php echo otfbrv_e('How to add shortcode'); ?></h5>
				<p>1. <?php echo otfbrv_e('You can add this shortcode'); ?> <strong>[otfbrv {parameters}]</strong> <?php echo otfbrv_e('to your post or page content'); ?>.</p>  
				<p>2. <?php echo otfbrv_e('It has following parameters'); ?>: </p>  
				<p>
					<ul class="parameters">
						<li class="list_parameter"><strong><?php echo otfbrv_e('layout'); ?></strong> - <?php echo otfbrv_e('View layout: "slider", "list", "grid". This is required parameter.'); ?>.</li>
						<li class="list_parameter"><strong><?php echo otfbrv_e('limit'); ?></strong> - <?php echo otfbrv_e('Review limit to show (use default setting when empty)'); ?>.</li>
						<li class="list_parameter"><strong><?php echo otfbrv_e('columns'); ?></strong> - <?php echo otfbrv_e('only for Grid layout'); ?></li>
					</ul>
				</p>
				<p>3. When you add the shortcode without display, it will use value in plugin setting.</p>
        	</div>
        </div>
    </div>
</div>
