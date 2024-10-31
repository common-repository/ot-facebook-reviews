<?php
/*
Plugin Name: Facebook Reviews
Plugin URI: https://www.omegatheme.com/
Description:  Facebook Reviews plugin allow you get rating from facebook page to your Wordpress site. People do give reviews regarding the company/website/services on the Facebook page.
Author: Omegatheme
Version: 1.2.2
Company: XIPAT Flexible Solutions 
Author URI: http://www.omegatheme.com
*/

define('OTFBRV_PLUGIN_NAME', 'Facebook Reviews');
define('OTFBRV_PLUGIN_VERSION', '1.2.2');
define('OTFBRV_GRAPH_API','https://graph.facebook.com/');
define('OTFBRV_PLUGIN_URL',plugins_url(basename(plugin_dir_path(__FILE__ )), basename(__FILE__)));

include_once("otfbrv-shortcode.php");
include_once("functions.php");

/*-------------------------------- Menu --------------------------------*/
function otfbrv_setting_menu() {
     add_submenu_page(
         'options-general.php',
         'OT Facebook Reviews',
         'OT Facebook Reviews',
         'moderate_comments',
         'otfbrv',
         'otfbrv_setting'
     );
}
add_action('admin_menu', 'otfbrv_setting_menu', 10);

function otfbrv_setting() {
    include_once(dirname(__FILE__) . '/otfbrv-setting.php');
}

/*-------------------------------- Links --------------------------------*/
function otfbrv_plugin_action_links($links, $file) {
    $plugin_file = basename(__FILE__);
    if (basename($file) == $plugin_file) {
        $settings_link = '<a href="' . admin_url('options-general.php?page=otfbrv') . '">' . otfbrv_e('Settings') . '</a>';
        array_unshift($links, $settings_link);
    }
    return $links;
}
add_filter('plugin_action_links', 'otfbrv_plugin_action_links', 10, 2);


function otfbrv_e($text, $params=null) {
    if (!is_array($params)) {
        $params = func_get_args();
        $params = array_slice($params, 1);
    }
    return vsprintf(__($text, 'otfbrv'), $params);
}

/*-------------------------------- Widget --------------------------------*/
function otfbrv_init_widget() {
    if (!class_exists('OT_Facebook_Reviews_Widget' ) ) {
        require 'otfbrv-widget.php';
    }
}

add_action('widgets_init', 'otfbrv_init_widget');
add_action('widgets_init', create_function('', 'register_widget("OT_Facebook_Reviews_Widget");'));

function otfbrv_getRating($ratings,$setting) {
	$result = '';
	if($setting == 2) {
		$image = 'medium';
	} elseif ($setting == 3) {
		$image = 'small';
	} else {
		$image = 'default';
	}
	for ($i = 1; $i <= $ratings; $i++) {        // go through each star
		$result .= '<img src="'.OTFBRV_PLUGIN_URL.'/assets/images/star_'.$image.'_full.png" />';        // show it filled
	}    
	$starsLeft = 5 - $ratings;      
	if ($starsLeft > 0) {                       // if there are any more stars left
		for ($i = 1; $i <= $starsLeft; $i++) {  // go through each remaining star
			$result .= '<img src="'.OTFBRV_PLUGIN_URL.'/assets/images/star_'.$image.'_empty.png" />';     // show it empty
		}
	} 
	return $result;
}

function otfbrv_getReview($pageid,$pagetoken,$limit) {
    $url = OTFBRV_GRAPH_API . $pageid . '/ratings?access_token=' .$pagetoken.'&limit='.$limit;
    $api_response = wp_remote_get($url);
    $response_data = wp_remote_retrieve_body($api_response);
    $response_json = json_decode($response_data);
    if(isset($response_json->data)) {
        $reviews = $response_json->data;
    }
    
    return $reviews;
}

function otfbrv_randomkey($length) {
    $pattern = "0123456789";
    $key = '';
    for($i = 0; $i < $length; $i++)    {
        $key .= $pattern{rand(0,strlen($pattern)-1)};
    }
    return $key;
}

function otfbrv_list_layout_output ($pageid,$pagetoken,$limit,$reviewstar,$reviewempty,$width,$height) {
    $reviews = otfbrv_getReview($pageid,$pagetoken,$limit);
    $settings = (array) get_option( 'otfbrv-plugin-settings' );


    $html = '<div class="ot-facebook-reviews"><div class="ot-reviews">';
    if(count($reviews) > 0) {
        $html .= '<div class="list-view"><div class="row">';
        foreach ($reviews as $key => $review) {
            if($review->reviewer && $review->reviewer->id != 'h' && $review->rating >= $reviewstar) {
                if( $reviewempty == '0' && isset($review->review_text)) {
                    $content = '<div class="ot-review-items col-xs-12">
                                    <div class="ot_info">
                                        <div class="ot-review-image">
                                            <img src="'.OTFBRV_GRAPH_API.$review->reviewer->id.'/picture?type=large" width="'.$width.'" height="'.$height.'" />
                                        </div>
                                        <h3>
                                            <span itemprop="name">'.$review->reviewer->name.'</span>
                                        </h3>
                                        <span class="ot-review-date">
                                            <b>'.date("F j, Y, g:i a", strtotime($review->created_time)).'</b>
                                        </span>
                                        <span itemprop="reviewrating" itemscope="" itemtype="http://schema.org/Rating">
                                            <div class="ot-rating" title="100%">'.otfbrv_getRating($review->rating, $settings['otfbrv_starimage']).'
                                            </div>
                                        </span>
                                        <blockquote class="blockquote">
                                            <p itemprop="reviewBody" class="mb-0 ot-review-comment">'.$review->review_text.'</p>
                                        </blockquote>
                                    </div>
                                </div>';

                    $html .= $content;
                } elseif ($reviewempty == '1') {
                    $content = '<div class="ot-review-items col-xs-12">
                                    <div class="ot_info">
                                        <div class="ot-review-image">
                                            <img src="'.OTFBRV_GRAPH_API.$review->reviewer->id.'/picture?type=large" width="'.$width.'" height="'.$height.'" />
                                        </div>
                                        <h3>
                                            <span itemprop="name">'.$review->reviewer->name.'</span>
                                        </h3>
                                        <span class="ot-review-date">
                                            <b>'.date("F j, Y, g:i a", strtotime($review->created_time)).'</b>
                                        </span>
                                        <span itemprop="reviewrating" itemscope="" itemtype="http://schema.org/Rating">
                                            <div class="ot-rating" title="100%">'.otfbrv_getRating($review->rating, $settings['otfbrv_starimage']).'
                                            </div>
                                        </span>';
                    if(isset($review->review_text)) {
                        $content .= '<blockquote class="blockquote">
                                        <p itemprop="reviewBody" class="mb-0 ot-review-comment">'.$review->review_text.'</p>
                                    </blockquote>';
                    }
                    $content .= '</div></div>';
                    $html .= $content;
                }
            }
        }
        $html .= '</div></div>';
    }
    $html .= '</div></div>';
    return $html;
}

function otfbrv_grid_layout_output ($pageid,$pagetoken,$limit,$reviewstar,$reviewempty,$columns,$width,$height) {
    $reviews = otfbrv_getReview($pageid,$pagetoken,$limit);
    $settings = (array) get_option( 'otfbrv-plugin-settings' );
    $pwidth = 'col-xs-12 col-lg-' . floor (12 / $columns).' col-sm-' . floor (12 / $columns + 2);

    $html = '<div class="ot-facebook-reviews"><div class="ot-reviews">';
    if(count($reviews) > 0) {
        $html .= '<div class="grid-view"><div class="row">';
        $k = 1;

        foreach ($reviews as $key => $review) {
            if($review->reviewer && $review->reviewer->id != 'h' && $review->rating >= $reviewstar) {
                if( $reviewempty == '0' && isset($review->review_text)) {
                    $content = '<div class="ot-review-items '.$pwidth.'">
                                    <div class="ot-review-image col-sm-4 col-xs-12">
                                        <img src="'.OTFBRV_GRAPH_API.$review->reviewer->id.'/picture?type=large" width="'.$width.'" height="'.$height.'" />
                                    </div>
                                    <div class="col-sm-8 col-xs-12">
                                        <h3>
                                            <span itemprop="name">'.$review->reviewer->name.'</span>
                                        </h3>
                                        <span class="ot-review-date">
                                            <b>'.date("F j, Y, g:i a", strtotime($review->created_time)).'</b>
                                        </span>
                                        <span itemprop="reviewrating" itemscope="" itemtype="http://schema.org/Rating">
                                            <div class="ot-rating" title="100%">'.otfbrv_getRating($review->rating, $settings['otfbrv_starimage']).'
                                            </div>
                                        </span>
                                        <p itemprop="reviewBody" class="mb-0 ot-review-comment">'.$review->review_text.'</p>
                                    </div>
                                </div>';
                    if( $k % $columns==0 && $k != count($reviews)) $content .= '</div><div class="row">';
                    
                    $k++;
                    $html .= $content;
                } elseif ($reviewempty == '1') {
                    $content = '<div class="ot-review-items '.$pwidth.'">
                                    <div class="ot-review-image col-sm-4 col-xs-12">
                                        <img src="'.OTFBRV_GRAPH_API.$review->reviewer->id.'/picture?type=large" width="'.$width.'" height="'.$height.'" />
                                    </div>
                                    <div class="col-sm-8 col-xs-12">
                                        <h3>
                                            <span itemprop="name">'.$review->reviewer->name.'</span>
                                        </h3>
                                        <span class="ot-review-date">
                                            <b>'.date("F j, Y, g:i a", strtotime($review->created_time)).'</b>
                                        </span>
                                        <span itemprop="reviewrating" itemscope="" itemtype="http://schema.org/Rating">
                                            <div class="ot-rating" title="100%">'.otfbrv_getRating($review->rating, $settings['otfbrv_starimage']).'
                                            </div>
                                        </span>';
                    if(isset($review->review_text)) {
                        $content .= '<p itemprop="reviewBody" class="mb-0 ot-review-comment">'.$review->review_text.'</p>';
                    } 
                    $content .= '</div></div>';
                    if( $k % $columns==0 && $k != count($reviews)) $content .= '</div><div class="row">';
                    
                    $k++;
                    $html .= $content;
                }
            }
        }
        $html .= '</div></div>';
    }
    $html .= '</div></div>';
    return $html;
}

function otfbrv_slide_layout_output ($pageid,$pagetoken,$limit,$reviewstar,$reviewempty) {
    $reviews = otfbrv_getReview($pageid,$pagetoken,$limit);
    $settings = (array) get_option( 'otfbrv-plugin-settings' );
    $id = otfbrv_randomkey(4);

    $html = '<div class="ot-facebook-reviews"><div class="ot-reviews">';
    if(count($reviews) > 0) {
        $html .= '<div class="slide-view"><div class="row"><div id="otcarousel'.$id.'" class="otcarousel carousel slide noconflict" data-interval="3000" data-ride="carousel"><ol class="carousel-indicators">';

        $k = 0; 
        foreach ($reviews as $key => $review) {
            if($review->reviewer && $review->reviewer->id != 'h' && $review->rating >= $reviewstar) {
                if($k == 0) $active = "active";
                else $active = "";
                if( $reviewempty == '0' && isset($review->review_text)) {
                    $content = '<li class="'.$active.'" data-target="#otcarousel'.$id.'" data-slide-to="'.$k.'"><img class="img-responsive" src="'.OTFBRV_GRAPH_API.$review->reviewer->id.'/picture?type=large" alt=""></li>';
                    $k++;
                    $html .= $content;
                } elseif ($reviewempty == '1') {
                    $content = '<li class="'.$active.'" data-target="#otcarousel'.$id.'" data-slide-to="'.$k.'"><img class="img-responsive" src="'.OTFBRV_GRAPH_API.$review->reviewer->id.'/picture?type=large" alt=""></li>';
                    $k++;
                    $html .= $content;
                }
            }
        }
        $html .= '</ol><div class="carousel-inner text-center">';
        $k = 0; 
        foreach ($reviews as $key => $review) {
            if($review->reviewer && $review->reviewer->id != 'h' && $review->rating >= $reviewstar) {
                if($k == 0) $active = "item active";
                else $active = "item";
                if( $reviewempty == '0' && isset($review->review_text)) {
                    $content = '<div class="'.$active.' ot-review-items col-xs-12" data-id="'.$k.'">
                                    <blockquote>
                                        <div class="row">
                                            <div class="col-sm-8 col-sm-offset-2">
                                                <p>'.$review->review_text.'</p>
                                                <small>'.$review->reviewer->name.'</small>
                                                <small>'.otfbrv_getRating($review->rating, $settings['otfbrv_starimage']).'</small>
                                                <small>'.date("F j, Y, g:i a", strtotime($review->created_time)).'</small>
                                            </div>
                                        </div>
                                    </blockquote>   
                                </div>';
                    $k++;
                    $html .= $content;
                } elseif ($reviewempty == '1') {
                    $content = '<div class="'.$active.' ot-review-items col-xs-12" data-id="'.$k.'">
                                    <blockquote>
                                        <div class="row">
                                            <div class="col-sm-8 col-sm-offset-2">';
                    if(isset($review->review_text)) {
                        $content .=             '<p>'.$review->review_text.'</p>';
                    }
                    $content .= '               <small>'.$review->reviewer->name.'</small>
                                                <small>'.otfbrv_getRating($review->rating, $settings['otfbrv_starimage']).'</small>
                                                <small>'.date("F j, Y, g:i a", strtotime($review->created_time)).'</small>
                                            </div>
                                        </div>
                                    </blockquote>   
                                </div>';        
                    $k++;
                    $html .= $content;
                }
            }
        }

        $html .= '</div></div></div></div>';
    }
    $html .= '
            </div></div>
            <script type="text/javascript">
                jQuery.noConflict();
                jQuery(document).ready(function($) {
                    $("#otcarousel'.$id.' .carousel-indicators li").click(function(e){
                        e.stopPropagation();
                        var goTo = $(this).data("slide-to");
                        $(".carousel-inner .item").each(function(index){
                            if($(this).data("id") == goTo){
                                goTo = index;
                                return false;
                            }
                        
                        });
                        $("#otcarousel'.$id.'").carousel(goTo); 
                    });
                });
            </script>';
    return $html;
}