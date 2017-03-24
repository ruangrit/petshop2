<?php
/*
  Plugin Name: Templatemela Shortcode
  Plugin URI: http://www.templatemela.com
  Description: Templatemela Custom Shortcodes for templatemela wordpress themes.
  Version: 1.0
  Author: Templatemela
  Author URI: http://www.templatemela.com
 */


add_shortcode('map', 'mgms_map');

function mgms_map($args) {
    $args = shortcode_atts(array(
        'address' => 'india',
        'type' => 'ROADMAP',
        'map_icon' => '',
        'width' => '500px',
        'zoom' => '8',
        'height' => '300px'
            ), $args, 'map');

$output = '';
    $id = substr(sha1("Google Map" . time()), rand(2, 10), rand(5, 8));
    $output ='<div class="map_canvas" style="height:'.$args["height"].'; width:'.$args["width"].'; margin-bottom: 1.6842em" id="map-'.$id.'"></div>';
    $output .= "<script type='text/javascript'>\n";
    $output .= "\t  function DisplayMapAddress(address) {\n";
    $output .= "\t var geocoder = new google.maps.Geocoder();\n";
    $output .= "\t geocoder.geocode({address: address}, function (results, status) {\n";
    $output .= "\t if (status == google.maps.GeocoderStatus.OK) { \n";
    $output .= "\t var location = results[0].geometry.location; \n";
    $output .= "\t  var options = { \n";
    $output .= "\t zoom: ".$args['zoom'].", \n";
    $output .= "\t center: location, \n";
    $output .= "\t streetViewControl: true, \n";     
    $output .= "\t mapTypeId: google.maps.MapTypeId.". $args['type'].", \n";
    $output .= "\t scrollwheel: false, \n";
    $output .= "\t draggable: true, \n";
    $output .= "\t panControl: true, \n";
    $output .= "\t zoomControl: true, \n";
    $output .= "\t zoomControlOptions: { \n";
    $output .= "\t style: google.maps.ZoomControlStyle.SMALL \n";
    $output .= "\t } }; \n";
    $output .= "\t var mymap = new google.maps.Map(document.getElementById('map-".$id."'), options); \n";  
    $output .= "\t var marker = new google.maps.Marker({ \n";  
    $output .= "\t map: mymap, \n";  
    $output .= "\t flat: true, \n"; 
    $output .= "\t icon: '".$args['map_icon']."', \n"; 
    $output .= "\t position: results[0].geometry.location }); \n"; 
    $output .= "\t var infowindow = new google.maps.InfoWindow({ \n"; 
    $output .= "\t content: 'india' }); \n";     
    $output .= "\t google.maps.event.addListener(marker, 'click', function () { \n";  
    $output .= "\t infowindow.open(mymap, marker); }); \n";
    $output .= "\t } }); \n";
    $output .= "\t } \n";
    $output .= "\t DisplayMapAddress('".$args['address']."'); \n";
    $output .= "</script>\n\n";
    return $output;
}


/* * *************** Services *************** */

function services_shortcode($atts, $content = null) {
    extract(shortcode_atts(array(
                "color" => '#cccccc',
                "icon_background_color" => '',
                "icon" => 'fa-arrows-alt',
                "title" => '',
                "link_text" => '',
                "link_url" => '',
                "style" => '1'
                    ), $atts));

    $style_css = 'color:' . $color . ';';
    if (!empty($icon_background_color)):
        $style_css .= 'background-color: ' . $icon_background_color . ';';
        $icon_class = '';
    else:
        $icon_class = ' no-background';
    endif;

    $output = '';
    $output .= '<div class="service style-' . $style . '">';
    $output .= '<div class="service-content style-' . $style . '">';

    if ($style == '1' || $style == '2'):
        if (!empty($icon))
            $output .= '<div class="icon"><i class="service-icon fa ' . $icon . $icon_class . '" style="' . $style_css . '"></i></div>';
        $output .= '<div class="service-content">';
        if (!empty($title))
            $output .= '<div class="title service-text">' . esc_html($title) . '</div>';
    endif;

    if ($style == '3'):
        $output .= '<div class="service-top">';
        if (!empty($icon))
            $output .= '<div class="icon"><i class="service-icon fa ' . $icon . $icon_class . '" style="' . $style_css . '"></i></div>';
        if (!empty($title))
            $output .= '<div class="title service-text">' . esc_html($title) . '</div>';
        $output .= '</div>';
        $output .= '<div class="service-content">';
    endif;

    if ($style == '4'):
        if (!empty($title))
            $output .= '<div class="title service-text">' . esc_html($title) . '</div>';
        if (!empty($icon))
            $output .= '<div class="icon"><i class="service-icon fa ' . $icon . $icon_class . '" style="color:' . $color . ';background-color: ' . $icon_background_color . ';"></i></div>';
        $output .= '<div class="service-content">';
    endif;

    if ($style == '5'):
        if (!empty($icon))
            $output .= '<div class="icon"><i class="service-icon fa ' . $icon . $icon_class . '" style="' . $style_css . '"></i></div>';
        $output .= '<div class="service-content">';
        if (!empty($title))
            $output .= '<div class="title service-text"><span class="text-first">' . esc_html($title) . '</span><span class="text-second">' . esc_html($title) . '</span></div>';
    endif;

    $output .= '<div class="description other-font">' . do_shortcode($content) . '</div>';

    if (!empty($link_text)):
        if (!empty($link_url)):
            $output .= '<div class="service-read-more other-font"><a href="' . esc_url($link_url) . '" class="other-read-more">' . esc_html($link_text) . '<i class="fa fa-arrow-right"></i></a></div>';
        else:
            $output .= '<div class="service-read-more other-font">' . esc_html($link_text) . '></div>';
        endif;
    endif;

    $output .= '</div>';
    $output .= '</div>';
    $output .= '</div>';
    return $output;
}

add_shortcode("tt_service", "services_shortcode");

/* * ***************************Counter**************** */

function shortcode_counter($atts, $content = null) {
    extract(shortcode_atts(array(
                'id' => '',
                'start' => 0,
                'icon' => '',
                'icon_color' => '#000',
                'image' => '',
                'type' => '',
                'color' =>'#000',
                'end' => '154',
                'decimal' => '0',
                'duration' => '20',
                'title_color' => '#000',
                'title' => '',
                'separator' => ','
                    ), $atts));
    $output = '';
            $output .="<div class='counter ".$type."'>";
            $output .="<div class='counter_wrap'>";
    if($icon){
        $output .="<div class='counter_icon icon_wrap'><i class='fa ".$icon."' style='color:".$icon_color."'></i></div>";
    }elseif($image){
        $output .="<div class='counter_image icon_wrap'>";
        $output .= '<img src="'. $image .'" alt="'. tt_get_attachment_data( $image, 'alt' ) .'" width="'. tt_get_attachment_data( $image, 'width' ) .'" height="'. tt_get_attachment_data( $image, 'height' ) .'"/></div>';
    }
    
    $output .="<div class='counter_desc'>";
    $output .="<div class='counter_number'>";
    $output .="<h1 class='count' id='" . $id . "' style='color:".$color."'>0</h1></div>";
    $output .="<div class='counter_title' style='color:".$title_color."'>" . $title . "</div>";
    $output .="</div></div></div>";

    $output .= "<script type='text/javascript'>\n";
    $output .= "\t var options = {\n";
    $output .= "\t useEasing : true,\n";
    $output .= "\t useGrouping : true,\n";
    $output .= "\t separator : ',', \n";
    $output .= "\t decimal : '.', \n";
    $output .= "\t }\n";
    $output .= "\t  jQuery.noConflict(); jQuery(document).ready(function() { \n";
    $output .= "\t var demo = new CountUp(" . $id . ", " . $start . ", " . $end . ", " . $decimal . ", " . $duration . ", options); \n";
    $output .="\t demo.start(); \n";
    $output .="\t }); \n";
    $output .= "</script>\n\n";

    return $output;
}

add_shortcode('tt_counter', 'shortcode_counter');

/* * *************** Code *************** */

function shortcode_code($atts, $content = null) {

    extract(shortcode_atts(array(
                'style' => '1'
                    ), $atts));

    $output = '';
    $output .= '<div class="code">';
    $output .= do_shortcode($content);
    $output .= '</div>';
    return $output;
}

add_shortcode('tt_code', 'shortcode_code');
/* shortcode for messagebox */

function message_box_func($args, $content = "") {
    $args = shortcode_atts(array(
        'type' => 'success'
            ), $args);
    //ob_start();
    $output = '';
    if ($args['type'] == 'success') {
        $output .= '<div class="alert alert-success alert-dismissible">';
        $output .= '<a class="close" data-dismiss="alert" aria-label="Close">x</a>';
        $output .= $content;
        $output .= '</div>';
    } elseif ($args['type'] == 'danger') {
        $output .= '<div class="alert alert-danger alert-dismissible">';
        $output .= '<a class="close" data-dismiss="alert" aria-label="Close">x</a>';
        $output .= $content;
        $output .= '</div>';
    } elseif ($args['type'] == 'warning') {
        $output .= '<div class="alert alert-warning alert-dismissible">';
        $output .= '<a class="close" data-dismiss="alert" aria-label="Close">x</a>';
        $output .= $content;
        $output .= '</div>';
    } elseif ($args['type'] == 'info') {
        $output .= '<div class="alert alert-info alert-dismissible">';
        $output .= '<a class="close" data-dismiss="alert" aria-label="Close">x</a>';
        $output .= $content;
        $output .= '</div>';
    }
    return $output;
}

add_shortcode('message_box', 'message_box_func');

/* * *************** Progress Bar  *************** */

function shortcode_progressbar_container($atts, $content = null, $code) {
    extract(shortcode_atts(array(
                'style' => '1',
                    ), $atts));
    $output = '';
    $output .= '<div class="progressbar-container">';
    $output .= '<div class="progressbar-content ' . $style . '">';
    $output .= do_shortcode($content);
    $output .= '</div>';
    $output .= '</div>';
    return $output;
}

add_shortcode('progressbar', 'shortcode_progressbar_container');

function shortcode_progressbar($atts, $content = null) {
    extract(shortcode_atts(array(
                'value' => '90',
                'color' => '#1f2022 ',
                'background_color' => '#87CFC5',
                'show_percentage' => 'yes',
                'style' => '1'
                    ), $atts));
    $output = '';
    $output .= '<div class="template_trip_progresbar style-' . $style . '">';

    if ($style == 4):
        $output .= '<small class="progress_detail">';
        $output .= do_shortcode($content);
        if ($show_percentage == 'yes') {
            $output .= '<span class="template_trip_progress_label">' . $value . '%</span>';
        }
        $output .= '</small>';
        $output .= '<div class="active_progresbar" style="color:' . $color . '" data-value="' . $value . '" data-percentage-value="' . $value . '">';
    else:
        $output .= '<div class="active_progresbar" style="color:' . $color . '" data-value="' . $value . '" data-percentage-value="' . $value . '">';
        $output .= '<small class="progress_detail" style="color:' . $color . '">';
        $output .= do_shortcode($content);
        if ($show_percentage == 'yes') {
            $output .= '<span class="template_trip_progress_label">' . $value . '%</span>';
        }
        $output .= '</small>';
    endif;


    $output .= '<span class="value animated" data-animated="fadeInLeft" style="width:' . $value . '%; background-color:' . $background_color . ';"></span>';
    $output .= '</div></div>';

    return $output;
}

add_shortcode('tt_progressbar', 'shortcode_progressbar');
/* * *************** PIE Chart *************** */

function shortcode_piechart($atts, $content = null) {
    extract(shortcode_atts(array(
                'percentage' => 20,
                'background_color' => '#87CFC5',
                'title' => '',
                'style' => '1',
                    ), $atts));

    $output = '';
    $randomdValue = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz123456789"), 0, 2);
    $output = '';

    $output .='<div class="template_trip_piechart column4">';
    $output .='<div class="chart_top">';
    $output .='<span class="chart_' . $randomdValue . ' tmchat_wrapper animated" data-percent="' . $percentage . '">';
    if ($style == 1) {
        $output .= '<span class="percent" style="color:' . $background_color . ';"></span>';
        $output .= '</span>';
    }
    $output .='</div>';
    $output .='<div class="chart_bottom">';
    if (!empty($title))
        $output .='<h2 class="chart_title">' . $title . '</h2>';
    $output .='<div class="chart_desc">' . do_shortcode($content) . '</div>';
    $output .='</div>';
    $output .='</div>';

    $output .= "<script type='text/javascript'>\n";
    $output .= "\t jQuery(function() {\n";
    $output .= "\t jQuery('.chart_" . $randomdValue . "').waypoint(function() {\n";
    $output .= "\t jQuery(this).easyPieChart({\n";
    $output .= "\t easing:'easeOutBounce',\n";
    $output .= "\t animate: {duration: 2000, enabled: true},\n";
    $output .= "\t barColor: '" . $background_color . "',\n";
    $output .= "\t trackColor: '#EAEAEB',\n";
    $output .= "\t scaleColor: '',\n";
    $output .= "\t lineWidth: 8,\n";
    $output .= "\t size: 130,\n";
    $output .= "\t onStep: function(from, to, percent) { {\n";
    $output .= "\t\t jQuery(this.el).find('.percent').text(Math.round(percent));\n";
    $output .= "\t } \n";
    $output .= "\t } }); \n";
    $output .= "\t }, {
			  triggerOnce: true,
			  offset: 'bottom-in-view'
			});\n";
    $output .= "\t}); \n";
    $output .= "</script>\n\n";

    return $output;
}

add_shortcode('tt_piechart', 'shortcode_piechart');
/* * *************** Blockquote  *************** */

function shortcode_quote($atts, $content = null) {
    extract(shortcode_atts(array(
                'style' => '1',
                'author' => '',
                'link' => ''
                    ), $atts));

    $output = '';
    $output .= '<div class="blockquote-container">';
    $output .= '<div class="blockquote-inner style-' . $style . '">';
    if ($style == '3' || $style == '4')
        $output .= '<blockquote class="blockquote"><i class="fa fa-quote-left"></i>' . do_shortcode($content) . '<i class="fa fa-quote-right"></i>';
    else
        $output .= '<blockquote class="blockquote">' . do_shortcode($content);
    if($author !=""){
    $output .='<p class="author"><cite><a href="'.esc_url($link).'" target="_blanck"><i class="fa fa-user"></i> '.esc_html($author).'</a></cite></p>';
    }
    $output .= '</blockquote></div>';
    $output .= '</div>';
    return $output;
}

add_shortcode('tt_blockquote', 'shortcode_quote');
/* * *************** Horizontal Tab *************** */
$maintab_div = '';

function tabs_group($atts, $content = null) {
    global $maintab_div;
    extract(shortcode_atts(array(
                'tab_type' => 'horizontal',
                'style' => '1'
                    ), $atts));

    switch ($tab_type) {
        case 'vertical' :
            $element_class = 'vertical_tab';
            break;
        default :
            $element_class = 'horizontal_tab';
            break;
            break;
    }


    $maintab_div = '';
    $output = '<div id="' . $element_class . '" class="' . $element_class . ' style' . $style . '"><div id="tab" class="tab"><ul class="tabs">';
    $output.= do_shortcode($content) . '</ul>';
    $output.= '<div class="tab_groupcontent">' . $maintab_div . '</div></div></div>';
    return $output;
}

add_shortcode('tt_tabs', 'tabs_group');

function tab($atts, $content = null) {
    global $maintab_div;

    static $oddeven_class = 0;
    $oddeven_class++;
    $newclass = '';
    $output = '';
    if ($oddeven_class % 2 == 0) {
        $newclass .= "even";
    } else {
        $newclass .= "odd";
    }

    extract(shortcode_atts(array(
                'title' => '',
                    ), $atts));
    $dummy_title = __( 'Tab', 'megashop' );

    if ($title != NULL) {
        $output .= '<li class="' . $newclass . '"><a href="#">' . $title . '<span class="leftarrow"></span></a></li>';
    } else {
        $output .= '<li class="' . $newclass . '"><a href="#">' . $dummy_title . '<span class="leftarrow"></span></a></li>';
    }
    $maintab_div.= '<div class="tabs_tab">' . $content . '</div>';
    return $output;
}

add_shortcode('tt_tab', 'tab');
/* * *************** Pricing Table *************** */

function shortcode_pricingtable($atts, $content = null) {
    extract(shortcode_atts(array(
                "style" => '1',
                "image" => '',
                "heading" => '',
                "button_text" => '',
                "button_link" => '#',
                "currency" => '$',
                "price" => '',
                "subtitle" => '',
                "price_per" => '',
                "selected" => 'no',
                    ), $atts));

    if ($selected == 'yes') {
        $selected = 'selected';
    }
    $output = '';
    $output .='<div class="pricing_wrapper">';
    $output .='<div class="pricing_wrapper_inner style-' . $style . ' ' . $selected . '"><div class="pricing_inner">';
    
    if ($style == '1') {
        if ($heading != '' && $price_per != '' && $price != '') {
            if( $image ){
                    $output .= '<div class="image">';
                            $output .= '<img src="'. esc_url($image) .'" alt="'. tt_get_attachment_data( $image, 'alt' ) .'" width="'. tt_get_attachment_data( $image, 'width' ) .'" height="'. tt_get_attachment_data( $image, 'height' ) .'"/>';
                    $output .= '</div>';
            }
            $output .='<div class="pricing_heading">' . $heading . '</div>';
            $output .='<div class="pricing_top"><div class="pricing_top_inner">';
            $output .= '<sup class="currency">'. $currency .'</sup>';
            $output .= '<span class="pricing_price">' . $price . '</span>';
            $output .= '<sup class="pricing_per"> / ' . $price_per . '</sup></div></div>';
        } else {
            $output .='<div class="nopricing_heading"></div>';
            $output .='<div class="nopricing_top"><div class="pricing_per"></div><div class="pricing_price"></div></div>';
        }
    } elseif ($style == '2') {
        if ($heading != '' && $price_per != '' && $price != '') {
            $output .='<div class="pricing_heading">' . $heading . '</div>';
            $output .='<div class="pricing_top"><div class="pricing_top_inner">';
            $output .= '<sup class="currency">'. $currency .'</sup>';
            $output .='<span class="pricing_price">' . $price . '</span>';
            $output .='<sup class="pricing_per"> / ' . $price_per . '</sup></div></div>';
        } else {
            $output .='<div class="nopricing_top"><div class="nopricing_heading"></div>';
            $output .='<div class="pricing_per"></div><div class="pricing_price"></div></div>';
        }
    }
if( $subtitle ) $output .= '<p class="subtitle"><big>'. $subtitle .'</big></p>';
    $output .='<div class="pricing_bottom">';
    $output .='<ul>';
    $output .= do_shortcode($content);
    $output .='</ul>';
    $output .='<div class="pricing_button">';
    if ($button_text != '') {
        $output .='<a href="' . esc_url($button_link) . '" target="_blank" class="button" id="pricing-btn">' . esc_html($button_text) . '</a>';
    }
    $output .='</div></div>';
    $output .='</div></div></div>';
    return $output;
}

add_shortcode("tt_pricingtable", "shortcode_pricingtable");

function shortcode_pricingtable_row($atts, $content = null) {
    extract(shortcode_atts(array(
                "symbol" => '',
                    ), $atts));
    $output = '';
    if (!empty($symbol))
        $output .= '<li><i class="fa ' . $symbol . '"></i> ' . $content . '</li>';
    else
        $output .= '<li>' . $content . '</li>';
    return $output;
}

add_shortcode('price_row', 'shortcode_pricingtable_row');

/* ============ accordions style shortcode =========== */

function accordions_func($args, $content = "") {
    $args = shortcode_atts(array(
        'style' => '1'
            ), $args);
    if ($args['style'] == '1') {
        $class = 'style1';
    } elseif ($args['style'] == '2') {
        $class = 'style2';
    } elseif ($args['style'] == '3') {
        $class = 'style3';
    } elseif ($args['style'] == '4') {
        $class = 'style4';
    }
    $output = '';
    $output .= '<div class="accordians_wrap '.$class.'">';
    $output .= do_shortcode($content);
    $output .= '</div>';
    return $output;
}

add_shortcode('accordions', 'accordions_func');

function accordion_func($args, $content = "") {
    $args = shortcode_atts(array(
        'title' => ''
            ), $args);
    $output = '';
    $output .= '<div class="accordion-single">';
    $output .= '<div class="accordion_heading accoodionclose">';
    $output .= '<i class="fa"></i>';
    $output .= '<span>' . $args["title"] . '</span>';
    $output .= '</div>';
    $output .= '<div class="accordion-answer"  style="display: none;">';
    $output .= '<p>' . $content . '</p>';
    $output .= '</div>';
    $output .= '</div>';
    return $output;
}

add_shortcode('accordion', 'accordion_func');

function toggles_func($args, $content = "") {
    $args = shortcode_atts(array(
        'style' => '1'
            ), $args);
    $output = '';
    if ($args['style'] == '1') {
        $class = 'style1';
    } elseif ($args['style'] == '2') {
        $class = 'style2';
    } elseif ($args['style'] == '3') {
        $class = 'style3';
    } elseif ($args['style'] == '4') {
        $class = 'style4';
    }
    $output .= '<div class="toggles_wrap ' . $class . '">';
    $output .= do_shortcode($content);
    $output .= '</div>';
    return $output;
}

add_shortcode('toggles', 'toggles_func');

/* ============ Toggle style shortcode =========== */

function toggle_func($args, $content = "") {
    $args = shortcode_atts(array(
        'title' => ''
            ), $args);
    $output = '';
    $output .= '<div class="toggle-single">';
    $output .= '<div class="toggle_heading toggleclose">';
    $output .= '<i class="fa"></i>';
    $output .= '<span>' . $args['title'] . '</span>';
    $output .= '</div>';
    $output .= '<div class="toggle-answer"  style="display: none;">';
    $output .= '<p>' . $content . '</p>';
    $output .= '</div>';
    $output .= '</div>';
    return $output;
}

add_shortcode('toggle', 'toggle_func');


/* ============ list style shortcode =========== */

function tt_list_shortcode($atts, $content = null) {

    return '<ul class="tt_list">' . do_shortcode($content) . '</ul>';
}

add_shortcode('tt_list', 'tt_list_shortcode');

function list_item_func($args, $content = "") {
    $args = shortcode_atts(array(
        'list_icon' => 'fa-square'
            ), $args);
    $output = '';
    $output .= '<li>';
    $output .= '<i class="fa ' . $args['list_icon'] . '"></i>';
    $output .= $content;
    $output .= '</li>';
    return $output;
}

add_shortcode('list_item', 'list_item_func');

/* ============ divider shortcode =========== */

function divider_shortcode($args, $content = "") {
    $args = shortcode_atts(array(
        'type' => 'solid',
        'space' => '10'
            ), $args);
    $output = '';
    $output .= '<div class="divider_content">';
    $output .= '<div class="divider_content_inner">';
    $output .= '<p>' . $content . '</p>';
    $output .= '<div class="' . $args['type'] . '" style="height:' . $args['space'] . 'px"></div>';
    $output .= '</div>';
    $output .= '</div>';
    return $output;
}

add_shortcode('tt_divider', 'divider_shortcode');
/***************** Addess ****************/
function shortcode_address($atts, $content = null)
{
	extract(shortcode_atts(array(
			'title' => '',	
			'description' => '',
			'address_label' => 'Address:',
			'phone_label' => 'Phone numbers:',
			'phone' => '',
			'fax_label' => 'Fax numbers:',
			'fax' => '123456789',
			'email_label' => 'Email:',
			'email' => '',
			'email_link' => '',									 
		), $atts));
		$output = '';
		$output .= '<div class="address-container right-to-left">';
		if(!empty($title))
			$output .= '<h1 class="small-title"><span>'.esc_html($title).'</span></h1>';
		if(!empty($description))
			$output .= '<div class="address-description description">'.esc_html($description).'</div>';
			

		$output .= '<div class="address-text first"><div class="icon"><i class="fa fa-map-marker"></i></div> <div class="content"><div class="address-label">'.$address_label.'</div>'.do_shortcode($content).'</div> </div>';
		
		if(!empty($phone)):
			$output .= '<div class="address-text second"><div class="icon"><i class="fa fa-phone"></i></div> <div class="content"><div class="address-label">'.$phone_label.'</div>'.$phone.'</div> </div>';
		endif;
		
		if(!empty($fax)):
			$output .= '<div class="address-text second"><div class="icon"><i class="fa fa-fax"></i></div> <div class="content"><div class="address-label">'.$fax_label.'</div>'.$fax.'</div> </div>';
		endif;
		
		if(!empty($email)):
			if(!empty($email_link)):
				$output .= '<div class="address-text third"><div class="icon"><i class="fa fa-envelope "></i></div> <div class="content"><div class="address-label">'.$email_label.'</div><a href="'.$email_link.'">'.$email.'</a><p>'.$other.'</p></div></div>';	
			else:
				$output .= '<div class="address-text><div class="icon"><i class="fa fa-envelope "></i></div>  <div class="content"><div class="address-label">'.$email_label.'</div>'.$email.'></div></div>';	
			endif;
		endif;	
		$output .= '</div>';
		return $output;
	}
add_shortcode('tt_address', 'shortcode_address');

/* ============ Container =========== */

function shortcode_container($atts, $content = null) {
    extract(shortcode_atts(array(
                'background_color' => '',
                'background_image' => '',
                'background_repeat' => '',
                'background_attachment' => '',
                'background_position' => '',
                'background_size' => '',
                'padding' => '0',
                'margin' => '0',
                'align' => '',
                'color' => '',
                'border_color' => '',
                'classname' => '',
                    ), $atts));
    $variables = '';
    $datasource = '';
    if (!empty($background_color))
        $variables .= 'background-color: ' . $background_color . ';';
    $variables .= 'padding:' . $padding . ';';
    $variables .= 'margin:' . $margin . ';';
    if (!empty($color))
        $variables .= 'color:' . $color . ';';
    $variables .= 'overflow: hidden;';

    if (!empty($background_image)):
        $variables .= 'background-image: url(' . $background_image . ');';        
        if (!empty($background_repeat)) :
            $variables .= 'background-repeat:' . $background_repeat . ';';
        endif;
        if (!empty($background_size)) :
            $variables .= 'background-size:' . $background_size . ';';
        endif;
        if (!empty($background_attachment)) :
            $variables .= 'background-attachment:' . $background_attachment . ';';
        endif;
        if (!empty($background_position)) :
            $variables .= 'background-position:' . $background_position . ';';
        endif;
    endif;

    $output = '';
    $output .= '<div class="main-container ' . $align . ' ' . $classname . '" style="' . $variables . ';">';
    $output .= '<div class="inner-container">';    
    $output .= do_shortcode($content);
    $output .= '</div></div>';
    return $output;
}

add_shortcode('container', 'shortcode_container');

/* ============ One half =========== */

function shortcode_one($atts, $content = null) {
    extract(shortcode_atts(array(
                'content_width' => '100%',
                'margin' => '0',
                'padding' => '0',
                'align' => 'left',
                'classname' => '',
                'background_color' => '',
                'background_image' => '',
                'background_repeat' => 'no-repeat',
                'background_attachment' => '',
                'background_size' => ''
                    ), $atts));

    $variables = '';
    if (!empty($background_color))
        $variables .= 'background-color: #' . $background_color . ';';
    if (!empty($color))
        $variables .= 'color:#' . $color . ';';
    if (!empty($background_image)):
        $variables .= 'background-image: url(' . esc_url($background_image) . ');';
        $variables .= 'background-repeat:' . $background_repeat . ';';
        $variables .= 'background-size:' . $background_size . ';';
        $variables .= 'background-attachment:' . $background_attachment . ';';
    endif;
    $output = '';
    $output .= '<div class="one ' . $classname . '" style="' . $variables . '">';
    $output .= '<div class="one_inner content_inner ' . $align . '" style="margin:' . $margin . ';width:' . $content_width . ';padding:' . $padding . '">';
    $output .= do_shortcode($content);
    $output .= '</div>';
    $output .= '</div>';
    return $output;
}

add_shortcode('one', 'shortcode_one');

/* ============ One half =========== */

function shortcode_one_half($atts, $content = null) {
    extract(shortcode_atts(array(
                'content_width' => '100%',
                'margin' => '0',
                'padding' => '0',
                'align' => 'left',
                'classname' => '',
                'background_color' => '',
                'background_image' => '',
                'background_repeat' => 'no-repeat',
                'background_attachment' => '',
                'background_size' => ''
                    ), $atts));

    $variables = '';
    if (!empty($background_color))
        $variables .= 'background-color: #' . $background_color . ';';
    if (!empty($color))
        $variables .= 'color:#' . $color . ';';
    if (!empty($background_image)):
        $variables .= 'background-image: url(' . esc_url($background_image) . ');';
        $variables .= 'background-repeat:' . $background_repeat . ';';
        $variables .= 'background-size:' . $background_size . ';';
        $variables .= 'background-attachment:' . $background_attachment . ';';
    endif;
    $output = '';
    $output .= '<div class="one_half ' . $classname . '" style="' . $variables . '">';
    $output .= '<div class="one_half_inner content_inner ' . $align . '" style="margin:' . $margin . ';width:' . $content_width . ';padding:' . $padding . '">';
    $output .= do_shortcode($content);
    $output .= '</div>';
    $output .= '</div>';
    return $output;
}

add_shortcode('one_half', 'shortcode_one_half');
/* ============ Inner One half =========== */

function shortcode_inner_one_half($atts, $content = null) {
    extract(shortcode_atts(array(
                'classname' => '',
                'padding' => '0',
                'content_width' => '100%',
                'margin' => '0',                
                'align' => 'left'
                    ), $atts));

    $output = '';
    $output .= '<div class="one_half ' . $classname . '">';
    $output .= '<div class="one_half_inner content_inner ' . $align . '" style="margin:' . $margin . ';padding:' . $padding . ';width:' . $content_width . ';">';
    $output .= do_shortcode($content);
    $output .= '</div>';
    $output .= '</div>';
    return $output;
}

add_shortcode('inner_one_half', 'shortcode_inner_one_half');
/* ============ One third =========== */

function shortcode_one_third($atts, $content = null) {
    extract(shortcode_atts(array(
                'classname' => '',
                'content_width' => '100%',
                'margin' => '0',
                'padding' => '0',
                'align' => ''
                    ), $atts));

    $output = '';
    $output .= '<div class="one_third ' . $classname . '">';
    $output .= '<div class="one_third_inner content_inner ' . $align . '" style="margin:' . $margin . ';padding:' . $padding . ';width:' . $content_width . ';">';
    $output .= do_shortcode($content);
    $output .= '</div>';
    $output .= '</div>';
    return $output;
}

add_shortcode('one_third', 'shortcode_one_third');
/* ============ One fourth =========== */

function shortcode_one_fourth($atts, $content = null) {
    extract(shortcode_atts(array(
                'classname' => '',
                'padding' => '0',
                'content_width' => '100%',
                'margin' => '0',
                'align' => 'left'
                    ), $atts));

    $output = '';
    $output .= '<div class="one_fourth">';
    $output .= '<div class="one_fourth_inner content_inner ' . $align . '" style="margin:' . $margin . ';padding:' . $padding . ';width:' . $content_width . ';">';
    $output .= do_shortcode($content);
    $output .= '</div>';
    $output .= '</div>';
    return $output;
}

add_shortcode('one_fourth', 'shortcode_one_fourth');
/* ============ One Fifth =========== */

function shortcode_one_fifth($atts, $content = null) {
    extract(shortcode_atts(array(
                'content_width' => '100%',
                'classname' => '',
                'padding' => '0',
                'margin' => '0',
                'align' => 'left'
                    ), $atts));

    $output = '';
    $output .= '<div class="one_fifth">';
    $output .= '<div class="one_fifth_inner content_inner ' . $align . '" style="margin:' . $margin . ';padding:' . $padding . ';width:' . $content_width . ';">';
    $output .= do_shortcode($content);
    $output .= '</div>';
    $output .= '</div>';
    return $output;
}

add_shortcode('one_fifth', 'shortcode_one_fifth');
/* ============ One sixth =========== */

function shortcode_one_sixth($atts, $content = null) {
    extract(shortcode_atts(array(
                'content_width' => '100%',
                'margin' => '0',
                'align' => 'left'
                    ), $atts));

    $output = '';
    $output .= '<div class="one_sixth">';
    $output .= '<div class="one_sixth_inner content_inner ' . $align . '" style="margin:' . $margin . ';padding:' . $padding . ';width:' . $content_width . ';">';
    $output .= do_shortcode($content);
    $output .= '</div>';
    $output .= '</div>';
    return $output;
}

add_shortcode('one_sixth', 'shortcode_one_sixth');
/* ============ Two third =========== */

function shortcode_two_third($atts, $content = null) {
    extract(shortcode_atts(array(
                'content_width' => '100%',
                'classname' => '',
                'padding' => '0',
                'margin' => '0',
                'align' => 'left',
                'classname' => ''
                    ), $atts));

    $output = '';
    $output .= '<div class="two_third ' . $classname . '">';
    $output .= '<div class="two_third_inner content_inner ' . $align . '" style="margin:' . $margin . ';padding:' . $padding . ';width:' . $content_width . ';">';
    $output .= do_shortcode($content);
    $output .= '</div>';
    $output .= '</div>';
    return $output;
}

add_shortcode('two_third', 'shortcode_two_third');

/* ============ Two Fourth =========== */

function shortcode_two_fourth($atts, $content = null) {
    extract(shortcode_atts(array(
                'content_width' => '100%',
                'margin' => '0',
                'classname' => '',
                'padding' => '0',
                'align' => 'left'
                    ), $atts));

    $output = '';
    $output .= '<div class="two_fourth ' . $classname . '">';
    $output .= '<div class="two_fourth_inner content_inner ' . $align . '" style="margin:' . $margin . ';padding:' . $padding . ';width:' . $content_width . ';">';
    $output .= do_shortcode($content);
    $output .= '</div>';
    $output .= '</div>';
    return $output;
}

add_shortcode('two_fourth', 'shortcode_three_fourth');
/* ============ Three Fourth =========== */

function shortcode_three_fourth($atts, $content = null) {
    extract(shortcode_atts(array(
                'content_width' => '100%',
                'margin' => '0',
                'classname' => '',
                'padding' => '0',
                'align' => 'left'
                    ), $atts));

    $output = '';
    $output .= '<div class="three_fourth ' . $classname . '">';
    $output .= '<div class="three_fourth_inner content_inner ' . $align . '" style="margin:' . $margin . ';padding:' . $padding . ';width:' . $content_width . ';">';
    $output .= do_shortcode($content);
    $output .= '</div>';
    $output .= '</div>';
    return $output;
}

add_shortcode('three_fourth', 'shortcode_three_fourth');

/* ============ Two Fifth =========== */
function shortcode_two_fifth($atts, $content = null) {
    extract(shortcode_atts(array(
                'content_width' => '100%',
                'classname' => '',
                'padding' => '0',
                'margin' => '0',
                'align' => 'left'
                    ), $atts));

    $output = '';
    $output .= '<div class="two_fifth ' . $classname . '">';
    $output .= '<div class="two_fifth_inner content_inner ' . $align . '" style="margin:' . $margin . ';padding:' . $padding . ';width:' . $content_width . ';">';
    $output .= do_shortcode($content);
    $output .= '</div>';
    $output .= '</div>';
    return $output;
}
add_shortcode('two_fifth', 'shortcode_two_fifth');
/* ============ Three Fifth =========== */

function shortcode_three_fifth($atts, $content = null) {
    extract(shortcode_atts(array(
                'content_width' => '100%',
                'margin' => '0',
                'classname' => '',
                'padding' => '0',
                'align' => 'left'
                    ), $atts));

    $output = '';
    $output .= '<div class="three_fifth ' . $classname . '">';
    $output .= '<div class="three_fifth_inner content_inner ' . $align . '" style="margin:' . $margin . ';padding:' . $padding . ';width:' . $content_width . ';">';
    $output .= do_shortcode($content);
    $output .= '</div>';
    $output .= '</div>';
    return $output;
}

add_shortcode('three_fifth', 'shortcode_three_fifth');
/* ============ Four Fifth =========== */

function shortcode_four_fifth($atts, $content = null) {
    extract(shortcode_atts(array(
                'content_width' => '100%',
                'margin' => '0',
                'classname' => '',
                'padding' => '0',
                'align' => 'left'
                    ), $atts));

    $output = '';
    $output .= '<div class="four_fifth ' . $classname . '">';
    $output .= '<div class="four_fifth_inner content_inner ' . $align . '" style="margin:' . $margin . ';padding:' . $padding . ';width:' . $content_width . ';">';
    $output .= do_shortcode($content);
    $output .= '</div>';
    $output .= '</div>';
    return $output;
}

add_shortcode('four_fifth', 'shortcode_four_fifth');

/* ============ Two Sixth =========== */

function shortcode_two_sixth($atts, $content = null) {
    extract(shortcode_atts(array(
                'content_width' => '100%',
                'margin' => '0',
                'classname' => '',
                'padding' => '0',
                'align' => 'left'
                    ), $atts));

    $output = '';
    $output .= '<div class="two_sixth ' . $classname . '">';
    $output .= '<div class="two_sixth_inner content_inner ' . $align . '" style="margin:' . $margin . ';padding:' . $padding . ';width:' . $content_width . ';">';
    $output .= do_shortcode($content);
    $output .= '</div>';
    $output .= '</div>';
    return $output;
}

add_shortcode('two_sixth', 'shortcode_two_sixth');

/* ============ Three Sixth =========== */

function shortcode_three_sixth($atts, $content = null) {
    extract(shortcode_atts(array(
                'content_width' => '100%',
                'margin' => '0',
                'classname' => '',
                'padding' => '0',
                'align' => 'left'
                    ), $atts));

    $output = '';
    $output .= '<div class="three_sixth ' . $classname . '">';
    $output .= '<div class="three_sixth_inner content_inner ' . $align . '" style="margin:' . $margin . ';padding:' . $padding . ';width:' . $content_width . ';">';
    $output .= do_shortcode($content);
    $output .= '</div>';
    $output .= '</div>';
    return $output;
}

add_shortcode('three_sixth', 'shortcode_three_sixth');
/* ============ Four Sixth =========== */

function shortcode_four_sixth($atts, $content = null) {
    extract(shortcode_atts(array(
                'content_width' => '100%',
                'margin' => '0',
                'classname' => '',
                'padding' => '0',
                'align' => 'left'
                    ), $atts));

    $output = '';
    $output .= '<div class="four_sixth ' . $classname . '">';
    $output .= '<div class="four_sixth_inner content_inner ' . $align . '" style="margin:' . $margin . ';padding:' . $padding . ';width:' . $content_width . ';">';
    $output .= do_shortcode($content);
    $output .= '</div>';
    $output .= '</div>';
    return $output;
}
add_shortcode('four_sixth', 'shortcode_four_sixth');
/* ============ five Sixth =========== */

function shortcode_five_sixth($atts, $content = null) {
    extract(shortcode_atts(array(
                'content_width' => '100%',
                'margin' => '0',
                'classname' => '',
                'padding' => '0',
                'align' => 'left'
                    ), $atts));

    $output = '';
    $output .= '<div class="five_sixth ' . $classname . '">';
    $output .= '<div class="five_sixth_inner content_inner ' . $align . '" style="margin:' . $margin . ';padding:' . $padding . ';width:' . $content_width . ';">';
    $output .= do_shortcode($content);
    $output .= '</div>';
    $output .= '</div>';
    return $output;
}

add_shortcode('five_sixth', 'shortcode_five_sixth');
/* ============ Static Text =========== */

function shortcode_static_text($atts, $content = null) {
    extract(shortcode_atts(array(
                'align' => 'left'
                    ), $atts));

    $output = '';
    $output .= '<div class="static-text-container ' . $align . '">';
    $output .= '<div class="text">' . do_shortcode($content) . '</div>';
    $output .= '</div>';
    return $output;
}

add_shortcode('text', 'shortcode_static_text');
/* ============ Button shortcode =========== */

function tt_button_shortcode($args, $content = "") {
    $args = shortcode_atts(array(
        'size' => 'small',
        'type' => '',
        'icon' => '',
        'link' => '#',
        'icon_align' => ''
            ), $args);
    $class = "";
    if ($args['size'] == 'small') {
        $class .= "btn-small";
    } elseif ($args['size'] == 'medium') {
        $class .= "";
    } elseif ($args['size'] == 'large') {
        $class .= "btn-large";
    } elseif ($args['size'] == 'mini') {
        $class .= "btn-mini";
    }
    if ($args['type'] == 'basic') {
        $class .= "";
    } elseif ($args['type'] == 'primary') {
        $class .= " btn-primary";
    } elseif ($args['type'] == 'info') {
        $class .= " btn-info";
    } elseif ($args['type'] == 'success') {
        $class .= " btn-success";
    } elseif ($args['type'] == 'warning') {
        $class .= " btn-warning";
    } elseif ($args['type'] == 'danger') {
        $class .= " btn-danger";
    } elseif ($args['type'] == 'inverse') {
        $class .= " btn-inverse";
    }
    $output = '';
    $output .= '<div class="button_content_inner">';
    $output .= '<a class="tt_btn  ' . $class . '" href="' . esc_url($args['link']) . '" style="">';
    if ($args['icon_align'] == 'left') {
        $output .= '<i class="fa ' . $args['icon'] . '"></i>';
    } $output .= $content;
    if ($args['icon_align'] == 'right') {
        $output .= '<i class="fa ' . $args['icon'] . '"></i>';
    }
    $output .= '</a>';
    $output .= '</div>';
    return $output;
}

add_shortcode('tt_button', 'tt_button_shortcode');
/* ============ Shareicon shortcode =========== */

function tt_shareicon_shortcode($args, $content = "") {
    $args = shortcode_atts(array(
        'size' => 'small',
        'shape' => 'circle'
            ), $args);
    $class = "";
    if ($args['size'] == 'small') {
        $class .= "small";
    } elseif ($args['size'] == 'large') {
        $class .= "large";
    }
    if ($args['shape'] == 'circle') {
        $class .= " circle";
    } elseif ($args['shape'] == 'square') {
        $class .= " square";
    }
    $output = '';
    $output .= '<div class="tt_shareicon_div ' . $class . '">';
    $output .= '<a class="tt_shareicon facebook" href="https://www.facebook.com/sharer/sharer.php?u=' . get_permalink() . '" target="_blank">';
    $output .= '<i class="fa fa-facebook"></i>';
    $output .= '</a>';
    $output .= '<a class="tt_shareicon twitter" href="https://twitter.com/share?url=' . get_permalink() . '" target="_blank">';
    $output .= '<i class="fa fa-twitter"></i>';
    $output .= '</a>';
    $output .= '<a class="tt_shareicon mail" href="mailto:emailid@gmail.com?subject=Checkout this awesome website&body=Hi%20emaild%40gmail.com,%0A%0AI%20found%20this%20interesting%20article%20or%20topics%20and%20thought%20of%20sharing%20it%20with%20you.%20%0A%0ACheck%20it%20out%3A%20' . get_permalink() . '%0A%0AThanks,%0AFrom%20Email%20Address%20Name">';
    $output .= '<i class="fa fa-envelope-o"></i>';
    $output .= '</a>';
    $output .= '<a class="tt_shareicon pinterest" href="https://pinterest.com/pin/create/button/?url=' . get_permalink() . '" target="_blank">';
    $output .= '<i class="fa fa-pinterest"></i>';
    $output .= '</a>';
    $output .= '<a class="tt_shareicon google-plus" href="https://plus.google.com/share?url=' . get_permalink() . '" target="_blank">';
    $output .= '<i class="fa fa-google-plus"></i>';
    $output .= '</a>';
    $output .= '</div>';
    return $output;
}

add_shortcode('tt_shareicon', 'tt_shareicon_shortcode');
/* ============ Followicon shortcode =========== */

function tt_followicon_shortcode($args, $content = "") {
    $args = shortcode_atts(array(
        'size' => 'small',
        'shape' => 'circle',
        'facebook' => '',
        'twitter' => '',
        'pinterest' => '',
        'google-plus' => '',
        'rss' => '',
        'instagram' => '',
        'linkedin' => '',
        'youtube' => '',
        'flickr' => ''
            ), $args);
    $output = '';
    $class = "";
    if ($args['size'] == 'small') {
        $class .= "small";
    } elseif ($args['size'] == 'large') {
        $class .= "large";
    }
    if ($args['shape'] == 'circle') {
        $class .= " circle";
    } elseif ($args['shape'] == 'square') {
        $class .= " square";
    }
    $output .= '<div class="tt_followicon_div ' . $class . '">';
    if ($args['facebook'] != '') {
        $output .= '<a class="tt_followicon facebook" href="' . esc_url($args['facebook']) . '" target="_blank">';
        $output .= '<i class="fa fa-facebook"></i>';
        $output .= '</a>';
    }
    if ($args['twitter'] != '') {
        $output .= '<a class="tt_followicon twitter" href="' . esc_url($args['twitter']) . '" target="_blank">';
        $output .= '<i class="fa fa-twitter"></i>';
        $output .= '</a>';
    }
    if ($args['pinterest'] != '') {
        $output .= '<a class="tt_followicon pinterest" href="' . esc_url($args['pinterest']) . '" target="_blank">';
        $output .= '<i class="fa fa-pinterest"></i>';
        $output .= '</a>';
    }
    if ($args['google-plus'] != '') {
        $output .= '<a class="tt_followicon google-plus" href="' . esc_url($args['google-plus']) . '" target="_blank">';
        $output .= '<i class="fa fa-google-plus"></i>';
        $output .= '</a>';
    }
    if ($args['rss'] != '') {
        $output .= '<a class="tt_followicon rss" href="' . esc_url($args['rss']) . '" target="_blank">';
        $output .= '<i class="fa fa-rss"></i>';
        $output .= '</a>';
    }
    if ($args['instagram'] != '') {
        $output .= '<a class="tt_followicon instagram" href="' . esc_url($args['instagram']) . '" target="_blank">';
        $output .= '<i class="fa fa-instagram"></i>';
        $output .= '</a>';
    }
    if ($args['linkedin'] != '') {
        $output .= '<a class="tt_followicon linkedin" href="' . esc_url($args['linkedin']) . '" target="_blank">';
        $output .= '<i class="fa fa-linkedin"></i>';
        $output .= '</a>';
    }
    if ($args['youtube'] != '') {
        $output .= '<a class="tt_followicon youtube" href="' . esc_url($args['youtube']) . '" target="_blank">';
        $output .= '<i class="fa fa-youtube"></i>';
        $output .= '</a>';
    }
    if ($args['flickr'] != '') {
        $output .= '<a class="tt_followicon flickr" href="' . esc_url($args['flickr']) . '" target="_blank">';
        $output .= '<i class="fa fa-flickr"></i>';
        $output .= '</a>';
    }
    $output .= '</div>';

    return $output;
}

add_shortcode('tt_followicon', 'tt_followicon_shortcode');

function tt_product_tab_shortcode($args, $content = "") {
    $args = shortcode_atts(array(
        'title' => '',
        'no_of_product' => '-1',
        'product_tabs' => '',
        'products_columns' => '4',
        'auto_slide' => 'true',
        'slide_speed' => '1000'
            ), $args);
    global $woocommerce;
    $Products_type = explode(",", $args['product_tabs']);
    $Products_columns = $args['products_columns'];
    $title = $args['title'];
    $no_of_product = $args['no_of_product'];
    $auto_slide = $args['auto_slide'];
    $slide_speed = $args['slide_speed'];
    $id = rand();
    $output = '';

    $output .= '<div class="woocommerce padding_0 TTProduct-Tab woo_product">';
    $output .= '<div class="col-xs-12 padding_0">';
    if (!empty($title)) {
        $output .= '<div class="box-heading tthometab-title">';
        $output .= '<h3>' . esc_html($title) . '</h3>';
        $output .= '</div>';
    }
    $output .= '<div class="tab-box-heading">';
    $output .= '<ul id="home-page-tabs" class="nav nav-tabs clearfix">';
    for ($i = 0; $i < count($Products_type); $i++) {
        if ($i == 0) {
            $clas = 'active';
        } else {
            $clas = '';
        }
        $output .= '<li class="' . $clas . '">';
        $output .= '<a class="tt' . $Products_type[$i] . ' text-capitalize" data-toggle="tab" href="#' . $Products_type[$i] . '">' . strtr($Products_type[$i], array('_' => ' ', 'products' => '')) . '</a>';
        $output .= '</li>';
    }
    $output .= '</ul>';
    $output .= '</div>';
    $output .= '<div class="tttab-content col-xs-12">';
    $output .= '<div class="tab-content">';
    $theme_layout = of_get_option('theme_layout');    
    if($theme_layout == 'both_sidebar_layout'){
        $product_col = 2;
    }else{
        $product_col = 3;
    }
    for ($i = 0; $i < count($Products_type); $i++) {
        $output .= "<script type='text/javascript'>\n";
        $output .= "\t jQuery(document).ready(function () {\n";
        $output .= "\t var ttfeature = jQuery('.tt" . $Products_type[$i] . "_" . $id . "');\n";
        $output .= "\t ttfeature.owlCarousel({\n";
        $output .= "\t items : " . $Products_columns . ",\n";        
        $output .= "\t itemsDesktop : [1200,".$product_col."],\n";
        $output .= "\t itemsDesktopSmall : [991,".$product_col."],\n";
        $output .= "\t itemsTablet: [767,2],\n";
        $output .= "\t itemsMobile : [480,1],\n";
        $output .= "\t slideSpeed : " . $slide_speed . ",\n";
        $output .= "\t autoPlay : " . $auto_slide . ",stopOnHover:true\n";
        $output .= "\t });\n";
        $output .= "\t if(jQuery('.tt" . $Products_type[$i] . "_" . $id . " .owl-controls.clickable').css('display') == 'none'){ \n";
        $output .= "\t jQuery('." . $Products_type[$i] . "_" . $id . " .customNavigation').hide();\n";
        $output .= "\t }else{ \n";
        $output .= "\t jQuery('." . $Products_type[$i] . "_" . $id . " .customNavigation').show(); \n";
        $output .= "\t jQuery('.tt" . $Products_type[$i] . '_' . $id . "_next').click(function(){ \n";
        $output .= "\t ttfeature.trigger('owl.next');\n";
        $output .= "\t });\n";
        $output .= "\t jQuery('.tt" . $Products_type[$i] . '_' . $id . "_prev').click(function(){ \n";
        $output .= "\t ttfeature.trigger('owl.prev');\n";
        $output .= "\t }); } });\n";
        $output .= "</script>\n\n";
        if ($i == 0) {
            $act = 'active';
        } else {
            $act = '';
        } $output .= '<div id="' . $Products_type[$i] . '" class="' . $Products_type[$i] . '_' . $id . ' product-carousel tab-pane block products_block clearfix  ' . $act . '">';
        $output .= '<div class="customNavigation">';
        $output .= '<a class="btn prev tt' . $Products_type[$i] . '_' . $id . '_prev">' . __('Prev', 'megashop') . '</a>';
        $output .= '<a class="btn next tt' . $Products_type[$i] . '_' . $id . '_next"> ' . __('Next', 'megashop') . '</a>';
        $output .= '</div>';
        $output .= '<div class="block_content">';
        $output .= '<ul class="tt' . $Products_type[$i] . '_' . $id . '">';
        if ($Products_type[$i] == 'featured_products') {
            $args = array(
                'post_type' => 'product',
                'meta_key' => '_featured',
                'meta_value' => 'yes',
                'post_status' => 'publish',
                'posts_per_page' => $no_of_product
            );
        } elseif ($Products_type[$i] == 'best_selling_products') {
            $meta_query = WC()->query->get_meta_query();
            $args = array(
                'post_type' => 'product',
                'post_status' => 'publish',
                'posts_per_page' => $no_of_product,
                'meta_key' => 'total_sales',
                'orderby' => 'meta_value_num',
                'meta_query' => $meta_query
            );
        } elseif ($Products_type[$i] == 'top_rated_products') {

            $args = array(
                'posts_per_page' => $no_of_product,
                'post_status' => 'publish',
                'post_type' => 'product',
                'meta_key' => '_wc_average_rating',
                'orderby' => 'meta_value_num',
            );
        } elseif ($Products_type[$i] == 'sale_products') {
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => $no_of_product,
                'post_status' => 'publish',
                'meta_query' => array(
                    'relation' => 'OR',
                    array(// Simple products type
                        'key' => '_sale_price',
                        'value' => 0,
                        'compare' => '>',
                        'type' => 'numeric'
                    ),
                    array(// Variable products type
                        'key' => '_min_variation_sale_price',
                        'value' => 0,
                        'compare' => '>',
                        'type' => 'numeric'
                    )
                )
            );
        } elseif ($Products_type[$i] == 'recent_products' || $Products_type[$i] == 'all') {
            $args = array(
                'post_type' => 'product',
                'orderby' => 'date',
                'post_status' => 'publish',
                'posts_per_page' => $no_of_product
            );
        }
        $cnt = 1;
        $loop1 = new WP_Query($args);
        $found_posts = $loop1->found_posts;
        while ($loop1->have_posts()) : $loop1->the_post();
            if (($found_posts >= $Products_columns * 2) && ($no_of_product >= ($Products_columns * 2))) {
                if ($cnt % 2 != 0) {
                    $output .= "<li class='li_single'><ul class='single-column'>";
                }
            }
            $content = return_get_template_part('woocommerce/content', 'product');
            $output .=$content;
            if (($found_posts >= $Products_columns * 2) && ($no_of_product >= ($Products_columns * 2))) {
                if ($cnt % 2 == 0) {
                    $output .= '</ul></li>';
                }
            }
            $cnt++;            
        endwhile;
        if(($found_posts > $Products_columns * 2) && ($no_of_product > ($Products_columns * 2))) { if($cnt % 2 == 0) { $output.= '</li></ul>'; } }
        if ($Products_type[$i] != 'top_rated_products') {
            remove_filter('posts_clauses', array(WC()->query, 'order_by_rating_post_clauses'));
        }
        $output .= '</ul>';
        $output .= '</div>';
        $output .= '</div>';
        wp_reset_postdata();
    }
    $output .= '</div>';
    $output .= '</div>';
    $output .= '</div>';
    $output .= '</div>';
    return $output;
}

add_shortcode('tt_product_tab', 'tt_product_tab_shortcode');

function tt_product_type_shortcode($args, $content = "") {
    $args = shortcode_atts(array(
        'title' => '',
        'no_of_product' => '-1',
        'product_type' => '',
        'products_columns' => '4',
        'auto_slide' => 'true',
        'slide_speed' => '1000'
            ), $args);
    $output = "";
    global $woocommerce;
    $Products_type = $args['product_type'];
    $Products_columns = $args['products_columns'];
    $title = $args['title'];
    $no_of_product = $args['no_of_product'];
    $auto_slide = $args['auto_slide'];
    $slide_speed = $args['slide_speed'];
    $id = rand();
    if ($Products_type == 'featured_products') {
        $args = array(
            'post_type' => 'product',
            'meta_key' => '_featured',
            'meta_value' => 'yes',
            'post_status' => 'publish',
            'posts_per_page' => $no_of_product
        );
    } elseif ($Products_type == 'best_selling_products') {
        $args = array(
            'post_type' => 'product',
            'post_status' => 'publish',
            'posts_per_page' => $no_of_product,
            'meta_key' => 'total_sales',
            'orderby' => 'meta_value_num',
        );
    } elseif ($Products_type == 'top_rated_products') {
        $args = array(
            'posts_per_page' => $no_of_product,
            'post_status' => 'publish',
            'post_type' => 'product',
            'meta_key' => '_wc_average_rating',
            'orderby' => 'meta_value_num',
            'order' => 'DESC',
        );
    } elseif ($Products_type == 'sale_products') {
        $args = array(
            'post_type' => 'product',
            'post_status' => 'publish',
            'posts_per_page' => $no_of_product,
            'meta_query' => array(
                'relation' => 'OR',
                array(// Simple products type
                    'key' => '_sale_price',
                    'value' => 0,
                    'compare' => '>',
                    'type' => 'numeric'
                ),
                array(// Variable products type
                    'key' => '_min_variation_sale_price',
                    'value' => 0,
                    'compare' => '>',
                    'type' => 'numeric'
                )
            )
        );
    } elseif ($Products_type == 'recent_products' ) {
        $args = array(
            'post_type' => 'product',
            'orderby' => 'date',
            'post_status' => 'publish',
            'posts_per_page' => $no_of_product
        );
    }
    $output .='<div class="col-xs-12 padding_0">';
    if (!empty($title)) {
        $output .='<div class="box-heading">';
        $output .='<h3>' . $title . '</h3>';
        $output .='</div>';
    }
    $theme_layout = of_get_option('theme_layout');
    if($theme_layout == 'both_sidebar_layout'){
        $product_col = 2;
    }else{
        $product_col = 3;
    }
    $output .= "<script type='text/javascript'>\n";
    $output .= "\t jQuery(document).ready(function () {\n";
    $output .= "\t var ttfeature = jQuery('.Products_wrap_" . $id . "');\n";
    $output .= "\t jQuery('.Products_wrap_" . $id . "').owlCarousel({\n";
    $output .= "\t items : " . $Products_columns . ",\n";
    $output .= "\t itemsDesktop : [1200,".$product_col."],\n";
    $output .= "\t itemsDesktopSmall : [991,".$product_col."],\n";
    $output .= "\t itemsTablet: [767,2],\n";
    $output .= "\t itemsMobile : [480,1],\n";
    $output .= "\t slideSpeed : " . $slide_speed . ",\n";
    $output .= "\t navigation:true,\n";
    $output .= "\t autoPlay : " . $auto_slide . ",pagination: false,stopOnHover:true\n";
    $output .= "\t });\n";
    $output .= "\t if(jQuery('.Products_wrap_" . $id . " .owl-controls.clickable').css('display') == 'none'){ \n";
    $output .= "\t jQuery('.products_wrap_" . $id . " .customNavigation').hide();\n";
    $output .= "\t }else{ \n";
    $output .= "\t jQuery('.products_wrap_" . $id . " .customNavigation').show(); \n";
    $output .= "\t jQuery('.tt" . $Products_type . '_' . $id . "_next').click(function(){ \n";
    $output .= "\t ttfeature.trigger('owl.next');\n";
    $output .= "\t });\n";
    $output .= "\t jQuery('.tt" . $Products_type . '_' . $id . "_prev').click(function(){ \n";
    $output .= "\t ttfeature.trigger('owl.prev');\n";
    $output .= "\t }); } });\n";
    $output .= "</script>\n\n";
    $output .='<div class="woocommerce products_block products_wrap_' . $id . ' woo_product col-xs-12">';
    $output .='<div class="customNavigation">';
    $output .= '<a class="btn prev tt' . $Products_type . '_' . $id . '_prev">' . __('Prev', 'megashop') . '</a>';
    $output .= '<a class="btn next tt' . $Products_type . '_' . $id . '_next"> ' . __('Next', 'megashop') . '</a>';
    $output .= '</div>';
    $output .= '<ul class="tt-carousel Products_wrap_' . $id . ' product-carousel">';
    $cnt = 1;
        $loop1 = new WP_Query($args);
        $found_posts = $loop1->found_posts;
        while ($loop1->have_posts()) : $loop1->the_post();
            if (($found_posts >= $Products_columns * 2) && ($no_of_product >= ($Products_columns * 2))) {
                if ($cnt % 2 != 0) {
                    $output .= "<li class='li_single'><ul class='single-column'>";
                }
            }
            $content = return_get_template_part('woocommerce/content', 'product');
            $output .=$content;
            if (($found_posts >= $Products_columns * 2) && ($no_of_product >= ($Products_columns * 2))) {
                if ($cnt % 2 == 0) {
                    $output .= '</ul></li>';
                }
            }
            $cnt++;            
        endwhile;
        if(($found_posts > $Products_columns * 2) && ($no_of_product > ($Products_columns * 2))) { if($cnt % 2 == 0) { $output.= '</li></ul>'; } }
    if ($Products_type == 'top_rated_products') {
        add_filter('posts_clauses', array(WC()->query, 'order_by_rating_post_clauses'));
    }
    wp_reset_postdata();
    $output .= '</ul>';
    $output .= '</div>';
    $output .= '</div>';
    return $output;
}

add_shortcode('tt_product_type', 'tt_product_type_shortcode');

function tt_testimonial_shortcode($args, $content = "") {
    $args = shortcode_atts(array(
        'title' => '',
        'no_of_testimonial' => '5',
        'testimonial_columns' => '1',
        'show_thumbnail' => 'true',
        'show_designation' => 'true'
            ), $args);
    $output = "";
    $show_designation = $args['show_designation'];
    $show_thumbnail = $args['show_thumbnail'];
    $testimonial_columns = $args['testimonial_columns'];
    $title = $args['title'];
    $no_of_testimonial = $args['no_of_testimonial'];
    $id = rand();
    $r = new WP_Query(apply_filters('widget_posts_args', array(
                        'posts_per_page' => $no_of_testimonial,
                        'no_found_rows' => true,
                        'post_status' => 'publish',
                        'post_type' => 'testimonial',
                        'ignore_sticky_posts' => true
                    )));

    if ($r->have_posts()) :
        $output .= "<script type='text/javascript'>\n";
        $output .= "\t jQuery(document).ready(function () {\n";
        $output .= "\t jQuery('.testimonial_wrap_" . $id . "').owlCarousel({\n";
        $output .= "\t items : " . $testimonial_columns . ",\n";
        $output .= "\t itemsDesktop : [1200," . $testimonial_columns . "],\n";
        $output .= "\t itemsDesktopSmall : [991,1],\n";
        $output .= "\t itemsTablet: [767,1],\n";
        $output .= "\t itemsMobile : [480,1],\n";
        $output .= "\t autoPlay : true,\n";
        $output .= "\t navigation: true,\n";
        $output .= "\t pagination: false,stopOnHover:true }); });\n";
        $output .= "</script>\n\n";
        if (!empty($title)) {
            $output .='<div class="box-heading">';
            $output .='<h3>' . esc_html($title) . '</h3>';
            $output .='</div>';
        }
        $output .='<div class="testimonial_slider_wrap">';
        $output .='<ul class="padding_0 testimonial_slider testimonial_wrap_' . $id . '">';
        while ($r->have_posts()) : $r->the_post();
            $output .='<li><div class="testimonial-image">';
            if ($show_thumbnail == 'true') :
                if (has_post_thumbnail()) {
                    $output .='<img src="' . get_the_post_thumbnail_url() . '" alt="'.  get_the_title().'"/>';
                }
            endif;
            $output .='</div>';
            $output .='<div class="testimonial-user-title"><h3>' . get_the_title() . '</h3>';
            if ($show_designation == 'true') :
                $output .='<span class="tttestimonial-subtitle">';
                $output .= get_post_meta(get_the_ID(), 'testimonial_designation', true);
                $output .='</span>';
            endif;
            $output .='</div>';
            $output .='<div class="testimonial-content">';
            $output .='<div class="testimonial-desc">';
            $output .= get_the_content();
            $output .='</div>';
            $output .='</div>';
            $output .='</li>';
        endwhile;
        wp_reset_postdata();

        $output .='</ul>';
        $output .='</div>';
    endif;
    return $output;
}

add_shortcode('tt_testimonial', 'tt_testimonial_shortcode');

function tt_ourbrand_shortcode($args, $content = "") {
    $args = shortcode_atts(array(
        'title' => '',
        'no_of_ourbrand' => '-1',
        'ourbrand_columns' => '5',
        'show_newtab' => 'true'
            ), $args);
    //ob_start();
    $show_newtab = $args['show_newtab'];
    $ourbrand_columns = $args['ourbrand_columns'];
    $title = $args['title'];
    $no_of_ourbrand = $args['no_of_ourbrand'];
    $id = rand();
    $output = '';
    $r = new WP_Query(apply_filters('widget_posts_args', array(
                        'posts_per_page' => $no_of_ourbrand,
                        'no_found_rows' => true,
                        'post_status' => 'publish',
                        'post_type' => 'ourbrand',
                        'ignore_sticky_posts' => true
                    )));

    if ($r->have_posts()) :
        $output .='<div class="our_brand col-xs-12 padding_0">';
        $output .= "<script type='text/javascript'>\n";
        $output .= "\t jQuery(document).ready(function () {\n";
        $output .= "\t jQuery('.ourbrand_wrap_" . $id . "').owlCarousel({\n";
        $output .= "\t items : " . $ourbrand_columns . ",\n";
        $output .= "\t itemsDesktop : [1200,4],\n";
        $output .= "\t itemsDesktopSmall : [991,3],\n";
        $output .= "\t itemsTablet: [767,3],\n";
        $output .= "\t itemsMobile : [480,2],\n";
        $output .= "\t autoPlay : true,\n";
        $output .= "\t navigation:true,stopOnHover:true,\n";
        $output .= "\t pagination: false });\n";
        $output .= "\t if(jQuery('.our_brand_" . $id . " .owl-controls.clickable').css('display') == 'none'){\n";
        $output .= "\t jQuery('.our_brand_" . $id . " .customNavigation').hide(); }else{\n";
        $output .= "\t  jQuery('.our_brand_" . $id . " .customNavigation').show();\n";
        $output .= "\t jQuery('.our_brand_" . $id . " .ttmanufacturer_next').click(function(){\n";
        $output .= "\t jQuery('.ourbrand_wrap_" . $id . "').trigger('owl.next'); });\n";
        $output .= "\t jQuery('.our_brand_" . $id . " .ttmanufacturer_prev').click(function(){ jQuery('.ourbrand_wrap_" . $id . "').trigger('owl.prev');\n";
        $output .= "\t  }); } });\n";
        $output .= "</script>\n\n";
        $output .='<div id="ttbrandlogo" class="brand-carousel our_brand_' . $id . '">';
        if (!empty($title)) {
            $output .='<div class="box-heading">';
            $output .='<h3>' . $title . '</h3>';
            $output .='</div>';
        }
        $output .='<div class="customNavigation">';
        $output .='<a class="btn prev ttmanufacturer_prev"></a>';
        $output .='<a class="btn next ttmanufacturer_next"></a>';
        $output .='</div>';
        $output .='<div class="ourbrand_wrap_' . $id . ' brand-carousel-wrap">';
        while ($r->have_posts()) : $r->the_post();
            if (has_post_thumbnail()) {
                $brand_url = get_post_meta(get_the_ID(), 'brand_url', true);
                $output .='<div class="item">';
                if (!empty($brand_url)) {
                    $url = $brand_url;
                } else {
                    $url = '#';
                }
                if ($show_newtab == 'true' && !empty($brand_url)) {
                    $target = 'target="_blank"';
                } else {
                    $target = '';
                }
                $output .='<a href="' . $url . '" ' . $target . '>';
                $output .='<img src="' . get_the_post_thumbnail_url() . '" alt="'.  get_the_title().'"/>';
                $output .='</a>';
                $output .='</div>';
            }
        endwhile;
        wp_reset_postdata();
        $output .='</div>';
        $output .='</div>';
        $output .='</div>';
    endif;
    return $output;
}

add_shortcode('tt_ourbrand', 'tt_ourbrand_shortcode');

function tt_latestblog_shortcode($args, $content = "") {
    $args = shortcode_atts(array(
        'title' => '',
        'no_of_post' => '-1',
        'no_of_column' => '3',
        'show_date' => 'true',
        'show_comment' => 'true'
            ), $args);
//        ob_start();
    $show_date = $args['show_date'];
    $title = $args['title'];
    $no_of_post = $args['no_of_post'];
    $no_of_column = $args['no_of_column'];
    $show_comment = $args['show_comment'];
    if ($no_of_column == '1') {
        $no_of_column = 1;
        $class = '';
    } elseif ($no_of_column == '2') {
        $no_of_column = 2;
    } elseif ($no_of_column == '3') {
        $no_of_column = 3;
    } else {
        $no_of_column = 3;
    }
    $output = '';
    $id = rand();
    $r = new WP_Query(apply_filters('widget_posts_args', array(
                        'posts_per_page' => $no_of_post,
                        'no_found_rows' => true,
                        'post_status' => 'publish',
                        'post_type' => 'post',
                        'ignore_sticky_posts' => true
                    )));

    if ($r->have_posts()) :
        $output .='<div id="latest_blog_' . $id .'" class="latest_blog_' . $id . ' latest_blog_wrap col-xs-12 padding_0">';
        $output .= "<script type='text/javascript'>\n";
        $output .= "\t jQuery(document).ready(function () {\n";
        $output .= "\t jQuery('.latestblog_wrap_" . $id . "').owlCarousel({\n";
        $output .= "\t items : " . $no_of_column . ",\n";
        if ($no_of_column > 2) {
            $no_of_column1 = $no_of_column - 1;
        } elseif ($no_of_column >= 2) {
            $no_of_column1 = $no_of_column;
        } elseif ($no_of_column == 1) {
            $no_of_column1 = $no_of_column;
        }
        $output .= "\t itemsDesktop : [1200," . $no_of_column . "],\n";
        $output .= "\t itemsDesktopSmall : [991," . $no_of_column1 . "],\n";
        $output .= "\t itemsTablet: [767,2],\n";
        $output .= "\t itemsMobile : [480,1],\n";
        $output .= "\t navigation:true,\n";
        $output .= "\t autoPlay : true,stopOnHover:true,\n";
        $output .= "\t pagination: false });\n";
        $output .= "\t if(jQuery('.latest_blog_" . $id . " .owl-controls.clickable').css('display') == 'none'){\n";
        $output .= "\t jQuery('.latest_blog_" . $id . " .customNavigation').hide(); }else{\n";
        $output .= "\t  jQuery('.latest_blog_" . $id . " .customNavigation').show();\n";
        $output .= "\t jQuery('.latest_blog_" . $id . " .ttblog_next').click(function(){\n";
        $output .= "\t jQuery('.latestblog_wrap_" . $id . "').trigger('owl.next'); });\n";
        $output .= "\t jQuery('.latest_blog_" . $id . " .ttblog_prev').click(function(){ jQuery('.latestblog_wrap_" . $id . "').trigger('owl.prev');\n";
        $output .= "\t  }); } });\n";
        $output .= "</script>\n\n";
        if (!empty($title)) {
            $output .='<div class="box-heading">';
            $output .='<h3>' . $title . '</h3>';
            $output .='</div>';
        }
        $output .='<div class="customNavigation">';
        $output .='<a class="btn prev ttblog_prev"></a>';
        $output .='<a class="btn next ttblog_next"></a>';
        $output .='</div>';
        $output .='<ul class="latestblog_wrap_' . $id . ' latestblog-carousel latestblog-wrap list-unstyled">';
        while ($r->have_posts()) : $r->the_post();
            $thumb = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'latest-blog');
            $full = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full');
            $url = $thumb['0'];
            $output .='<li>';
            $output .='<div class="blog-content">';
            $content = get_the_content();
            $post_media = megashop_get_post_format_media();
            if (get_post_format() == 'video') {
                $is_shortcode = ( 0 === strpos($post_media, '[') );
                if ($post_media) {
                    $content = str_replace($post_media, '', $content);
                }
                if ($post_media) {
                    if ($is_shortcode) {
                        $post_media = do_shortcode($post_media);
                    } else {
                        $post_media = '<div class="video-container">' . wp_oembed_get($post_media) . '</div>';
                    }
                    $output .= $post_media;
                }
            } elseif (get_post_format() == 'audio') {
                $is_shortcode = ( 0 === strpos($post_media, '[') );
                $display_image = true;
                //Disable featured image display when using [playlist] shortcode
                if (0 === strpos($post_media, '[playlist') || !$is_shortcode) {
                    $display_image = false;
                }
                if ($post_media && $is_shortcode) {
                    $content = str_replace($post_media, '', $content);
                }
                if (has_post_thumbnail(get_the_ID())) {
                    $output .= get_the_post_thumbnail(get_the_ID());
                }
                if ($post_media && (!is_single() || $is_shortcode )) {
                    if ($is_shortcode) {
                        $post_media = do_shortcode($post_media);
                    } else {
                        $post_media = wp_oembed_get($post_media);
                    }
                    $output .= $post_media;
                }
            } elseif (get_post_format() == 'gallery') {
                if (!is_array($post_media)) {
                    $post_media = explode(',', $post_media);
                }
                if (is_array($post_media) && !empty($post_media)) {
                    $output .='<div class="format-gallery"><div class="entry-media enable-slider">';
                    foreach ($post_media as $image_id) {
                        $output .='<a href="' . esc_url(get_permalink()) . '" class="slide">' . wp_get_attachment_image(absint($image_id), 'full') . '</a>';
                    }
                    $output .='</div></div>';
                }
            }elseif(get_post_format() == 'quote'){
                $content = preg_replace('/<(\/?)blockquote(.*?)>/', '', get_the_content());
            $quote_source = trim(get_post_meta(get_the_ID(), 'quote_source', true));
            if (empty($quote_source)) {
                $quote_source = strip_tags(get_the_title());
            }
            if ( false === stristr($content, '<cite') && $quote_source) {
                $content .= '<cite class="quote-source">' . $quote_source . '</cite>';
            }
            $content = explode('<cite', $content);
           $output .='<blockquote class="quote-content">' . $content[0] . '</blockquote>';
            if (isset($content[1]) && $content[1]) {
                $output .= '<cite' . $content[1];
            }                
            } elseif(has_post_thumbnail()) {
                $output .='<div class="ttblog_image_holder blog_image_holder col-xs-12 col-sm-12 padding_0">';
                $output .='<a href="' . get_the_permalink() . '">';
                $output .='<img class="image_thumb" src="' . esc_url($url) . '" alt="' . esc_html__('Latest Blog', 'megashop') . '" title="' . esc_html__('Latest Blog', 'megashop') . '">';
                $output .='<div class="blog-hover"></div>';
                $output .='</a><span class="bloglinks">';
                $output .='<a class="icon zoom" data-lightbox="example-set" href="' . esc_url($full[0]) . '" title="' . get_the_title() . '">';
                $output .='<i class="fa fa-search"></i>';
                $output .='</a>';
                $output .='</span>';
                $output .='</div>';
            }
            $output .='<div class="blog-caption blog-sub-content col-xs-12 col-sm-12 padding_0">';
            if ($show_comment == 'true' || $show_date == 'true') {
                $output .='<div class="col-xs-12 padding_0">';
                if ($show_date == 'true') {
                    $output .='<span class="blog-date" style="display: block">';
                    $output .='<i class="fa fa-calendar"></i>';
                    $output .='<span class="date">' . get_the_date(' M') . '</span>';
                    $output .='<span class="month">' . get_the_date(' d, Y') . '</span>';
                    $output .='</span>';
                } $num_comments = get_comments_number(get_the_ID()); // get_comments_number returns only a numeric value
                if ($show_comment == 'true') {
                    $output .='<div class="comment" style="display: block">';
                    if (comments_open()) {
                        if ($num_comments == 0) {
                            $comments = __('0 Comments', 'megashop');
                        } elseif ($num_comments > 1) {
                            $comments = $num_comments . __(' Comments', 'megashop');
                        } else {
                            $comments = __('1 Comment', 'megashop');
                        }
                        $output .= $write_comments = '<a href="' . get_comments_link() . '"><i class="fa fa-comments-o"></i> ' . $comments . '</a>';
                    } else {
                        $output .= $write_comments = __('Comments are off for this post.', 'megashop');
                    }
                    $output .='</div>';
                }
                $output .='</div>';
            }
            $output .='<div class="col-xs-12 padding_0">';
            $output .='<h5 class="post_title">';
            $output .='<a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h5>';
            if(get_post_format() != 'quote'){
            $output .='<div class="blog-description">';
            $content_legth = 12;
            $trimexcerpt = wp_trim_excerpt();
            $shortexcerpt = wp_trim_words($trimexcerpt, $content_legth, '..<div class="continue_read"><a href="' . get_the_permalink() . '" class="read-more">' . __('Read More', 'megashop') . '</a></div>');
            $output .= $shortexcerpt;
            $output .='</div>';
            }elseif(get_post_format() == 'quote'){
                 $output .='<div class="continue_read"><a href="' . get_the_permalink() . '" class="read-more">' . esc_html__('Read More', 'megashop') . '</a></div>';
            }
            $output .='</div>';
            $output .='</div>';
            $output .='</div>';
            $output .='</li>';
        endwhile;
        wp_reset_postdata();
        $output .='</ul>';
        $output .='</div>';
    endif;
    return $output;
}

add_shortcode('tt_latestblog', 'tt_latestblog_shortcode');

function tt_banner_shortcode($args, $content = "") {
    $args = shortcode_atts(array(
        'hover_style' => 'style1',
        'background_color' => '',
        'layout' => 'layout1',
        'img_src_1' => '',
        'img_link_1' => '#',
        'img_src_2' => '',
        'img_link_2' => '#',
        'img_src_3' => '',
        'img_link_3' => '#',
        'img_src_4' => '',
        'img_link_4' => '#'
            ), $args);
    $layout = $args['layout'];
    $hover_style = $args['hover_style'];
    $img_link_1 = esc_url($args['img_link_1']);
    $img_link_2 = esc_url($args['img_link_2']);
    $img_link_3 = esc_url($args['img_link_3']);
    $img_link_4 = esc_url($args['img_link_4']);
    $img_src_1 = esc_url($args['img_src_1']);
    $img_src_2 = esc_url($args['img_src_2']);
    $img_src_3 = esc_url($args['img_src_3']);
    $img_src_4 = esc_url($args['img_src_4']);
    $background_color = $args['background_color'];
    if(!empty($background_color)){
        $back_color = 'background-color:'.$background_color.';';
    }else{
        $back_color = '';
    }
    $output = '';
    if ($layout == 'layout1') {
        if ($img_src_1 != "" && $img_src_2 == '' && $img_src_3 == '') {
            $class = 'col-xs-12';
        }if ($img_src_1 != "" && $img_src_2 != "") {
            $class = 'col-sm-6 col-xs-6';
        }
        $output .='<div class="ttbannerblock layout1 ' . $hover_style . '">';
        if ($img_src_1 != "") {
            $output .='<div class="ttbanner1 ttbanner ' . $class . '" style="'.$back_color.'">';
            $output .=' <div class="ttbanner-img">';
            $output .='<a href="' . esc_url($img_link_1) . '">';
            $output .='<img src="' . esc_url($img_src_1) . '" alt="banner-01">';
            if ($hover_style == 'style1') {
                $output .='<span class="hover hover1">test</span>';
                $output .='<span class="hover hover2">test</span>';
                $output .='<span class="hover hover3">test</span>';
                $output .='<span class="hover hover4">test</span>';
            }
            $output .='</a>';
            $output .='</div>';
            $output .='</div>';
        }if ($img_src_1 != "" && $img_src_2 != "") {
            $output .='<div class="ttbanner2 ttbanner ' . $class . '" style="'.$back_color.'">';
            $output .='<div class="ttbanner-row1">';
            $output .='<div class="ttbanner-img">';
            $output .='<a href="' . esc_url($img_link_2) . '">';
            $output .='<img src="' . esc_url($img_src_2) . '" alt="banner-02">';
            if ($hover_style == 'style1') {
                $output .='<span class="hover hover1">test</span>';
                $output .='<span class="hover hover2">test</span>';
                $output .='<span class="hover hover3">test</span>';
                $output .='<span class="hover hover4">test</span>';
            }
            $output .='</a>';
            $output .='</div>';
            $output .='</div>';
            if ($img_src_1 != "" && $img_src_2 != "" && $img_src_3 != "") {
                $output .='<div class="ttbanner-row2">';
                $output .='<div class="ttbanner-img">';
                $output .='<a href="' . esc_url($img_link_3) . '">';
                $output .='<img src="' . esc_url($img_src_3) . '" alt="banner-03">';
                if ($hover_style == 'style1') {
                    $output .='<span class="hover hover1">test</span>';
                    $output .='<span class="hover hover2">test</span>';
                    $output .='<span class="hover hover3">test</span>';
                    $output .='<span class="hover hover4">test</span>';
                }
                $output .='</a>';
                $output .='</div>';
                $output .='</div>';
            }
            $output .='</div>';
        }
        $output .=' </div>';
    } elseif ($layout == 'layout2') {
        if ($img_src_1 != "" && $img_src_2 == '' && $img_src_3 == '' && $img_src_4 == '') {
            $class = 'col-xs-12';
        }if ($img_src_1 != "" && $img_src_2 != "" && $img_src_3 == '' && $img_src_4 == '') {
            $class = 'col-sm-6 col-xs-6';
        }
        if ($img_src_1 != "" && $img_src_2 != "" && $img_src_3 != '' && $img_src_4 == '') {
            $class = 'col-sm-4 col-xs-4';
        }
        if ($img_src_1 != "" && $img_src_2 != "" && $img_src_3 != '' && $img_src_4 != '') {
            $class = 'col-sm-3 col-xs-3';
        }
        $output .='<div class="ttbannerblock layout2 ' . $hover_style . '">';
        if ($img_src_1 != "") {
            $output .='<div class="ttbanner1 ttbanner ' . $class . '" style="'.$back_color.'">';
            $output .='<div class="ttbanner-img">';
            $output .='<a href="' . esc_url($img_link_1) . '">';
            $output .='<img src="' . esc_url($img_src_1) . '" alt="banner-01">';
            if ($hover_style == 'style1') {
                $output .='<span class="hover hover1">test</span>';
                $output .='<span class="hover hover2">test</span>';
                $output .='<span class="hover hover3">test</span>';
                $output .='<span class="hover hover4">test</span>';
            }
            $output .='</a>';
            $output .='</div>';
            $output .='</div>';
        }
        if ($img_src_1 != "" && $img_src_2 != "") {
            $output .='<div class="ttbanner2 ttbanner ' . $class . '" style="'.$back_color.'">';
            $output .='<div class="ttbanner-row1">';
            $output .='<div class="ttbanner-img">';
            $output .='<a href="' . esc_url($img_link_2) . '">';
            $output .='<img src="' . esc_url($img_src_2) . '" alt="banner-02">';
            if ($hover_style == 'style1') {
                $output .='<span class="hover hover1">test</span>';
                $output .='<span class="hover hover2">test</span>';
                $output .='<span class="hover hover3">test</span>';
                $output .='<span class="hover hover4">test</span>';
            }
            $output .='</a>';
            $output .='</div>';
            $output .='</div>';
            $output .='</div>';
        }
        if ($img_src_1 != "" && $img_src_2 != "" && $img_src_3 != "") {
            $output .='<div class="ttbanner3 ttbanner ' . $class . '" style="'.$back_color.'">';
            $output .='<div class="ttbanner-row2">';
            $output .='<div class="ttbanner-img">';
            $output .='<a href="' . esc_url($img_link_3) . '">';
            $output .='<img src="' . esc_url($img_src_3) . '" alt="banner-03">';
            if ($hover_style == 'style1') {
                $output .='<span class="hover hover1">test</span>';
                $output .='<span class="hover hover2">test</span>';
                $output .='<span class="hover hover3">test</span>';
                $output .='<span class="hover hover4">test</span>';
            }
            $output .='</a>';
            $output .='</div>';
            $output .='</div>';
            $output .='</div>';
        }
        if ($img_src_1 != "" && $img_src_2 != "" && $img_src_3 != "" && $img_src_4 != "") {

            $output .='<div class="ttbanner4 ttbanner ' . $class . '" style="'.$back_color.'">';
            $output .='<div class="ttbanner-row2">';
            $output .='<div class="ttbanner-img">';
            $output .='<a href="' . esc_url($img_link_4) . '">';
            $output .='<img src="' . esc_url($img_src_4) . '" alt="banner-04">';
            if ($hover_style == 'style1') {
                $output .='<span class="hover hover1">test</span>';
                $output .='<span class="hover hover2">test</span>';
                $output .='<span class="hover hover3">test</span>';
                $output .='<span class="hover hover4">test</span>';
            }
            $output .='</a>';
            $output .='</div>';
            $output .='</div>';
            $output .='</div>';
        }
        $output .='</div>';
    }elseif ($layout == 'layout3') {
        if ($img_src_1 != "" && $img_src_2 == '' && $img_src_3 == '') {
            $class = 'col-xs-12';
        }if ($img_src_1 != "" && $img_src_2 != "") {
            $class = 'col-sm-6 col-xs-6';
        }
        if ($img_src_1 != "" && $img_src_2 != "" && $img_src_3 != "") {
            $class1 = 'col-xs-12';
        }
        $output .='<div class="ttbannerblock layout3 ' . $hover_style . '">';
        if ($img_src_1 != "" && $img_src_2 == "") {
            $output .='<div class="ttbanner1 ttbanner ' . $class . '" style="'.$back_color.'">';
            $output .=' <div class="ttbanner-img">';
            $output .='<a href="' . esc_url($img_link_1) . '">';
            $output .='<img src="' . esc_url($img_src_1) . '" alt="banner-01">';
            if ($hover_style == 'style1') {
                $output .='<span class="hover hover1">test</span>';
                $output .='<span class="hover hover2">test</span>';
                $output .='<span class="hover hover3">test</span>';
                $output .='<span class="hover hover4">test</span>';
            }
            $output .='</a>';
            $output .='</div>';
            $output .='</div>';
        }if ($img_src_1 != "" && $img_src_2 != "") {
             $output .='<div class="ttbanner1 ttbanner col-xs-12 padding_left_0 padding_right_0" style="'.$back_color.'">';
            $output .='<div class="ttbanner-row1 ' . $class . '">';
            $output .='<div class="ttbanner-img">';
            $output .='<a href="' . esc_url($img_link_1) . '">';
            $output .='<img src="' . esc_url($img_src_1) . '" alt="banner-02">';
            if ($hover_style == 'style1') {
                $output .='<span class="hover hover1">test</span>';
                $output .='<span class="hover hover2">test</span>';
                $output .='<span class="hover hover3">test</span>';
                $output .='<span class="hover hover4">test</span>';
            }
            $output .='</a>';
            $output .='</div>';
            $output .='</div>';  
            $output .='<div class="ttbanner-row1 ' . $class . '">';
            $output .='<div class="ttbanner-img">';
            $output .='<a href="' . esc_url($img_link_2) . '">';
            $output .='<img src="' . esc_url($img_src_2) . '" alt="banner-02">';
            if ($hover_style == 'style1') {
                $output .='<span class="hover hover1">test</span>';
                $output .='<span class="hover hover2">test</span>';
                $output .='<span class="hover hover3">test</span>';
                $output .='<span class="hover hover4">test</span>';
            }
            $output .='</a>';
            $output .='</div>';
            $output .='</div>';  
            $output .='</div>';
            $output .='<div class="ttbanner2 ttbanner ' . $class1 . '" style="'.$back_color.'">';
            if ($img_src_1 != "" && $img_src_2 != "" && $img_src_3 != "") {
                $output .='<div class="ttbanner-row2">';
                $output .='<div class="ttbanner-img">';
                $output .='<a href="' . esc_url($img_link_3) . '">';
                $output .='<img src="' . esc_url($img_src_3) . '" alt="banner-03">';
                if ($hover_style == 'style1') {
                    $output .='<span class="hover hover1">test</span>';
                    $output .='<span class="hover hover2">test</span>';
                    $output .='<span class="hover hover3">test</span>';
                    $output .='<span class="hover hover4">test</span>';
                }
                $output .='</a>';
                $output .='</div>';
                $output .='</div>';
                
            $output .='</div>';
            }
        }
        $output .=' </div>';
    }
    return $output;
}

add_shortcode('tt_banner', 'tt_banner_shortcode');


/*text widget add filter*/
add_filter('widget_text','do_shortcode');