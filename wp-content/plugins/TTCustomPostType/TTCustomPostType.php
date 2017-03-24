<?php
/*
  Plugin Name: TemplateTrip Custom Post Type
  Plugin URI: http://www.templatetrip.com
  Description: TemplateTrip Custom Taxonomy(Testimonials,OurBrand) for templatetrip wordpress themes.
  Version: 1.0
  Author: TemplateTrip
  Author URI: http://www.templatetrip.com
 */

add_filter( 'init', 'testimonial_init' );
/**
 * Register a Testimonial post type.
 *
 */
function testimonial_init() {
	$labels = array(
		'name'               => _x( 'Testimonials', 'post type general name', 'megashop' ),
		'singular_name'      => _x( 'Testimonial', 'post type singular name', 'megashop' ),
		'menu_name'          => _x( 'Testimonials', 'admin menu', 'megashop' ),
		'name_admin_bar'     => _x( 'Testimonial', 'add new on admin bar', 'megashop' ),
		'add_new'            => _x( 'Add New', 'testimonial', 'megashop' ),
		'add_new_item'       => __( 'Add New Testimonial', 'megashop' ),
		'new_item'           => __( 'New Testimonial', 'megashop' ),
		'edit_item'          => __( 'Edit Testimonial', 'megashop' ),
		'view_item'          => __( 'View Testimonial', 'megashop' ),
		'all_items'          => __( 'All Testimonials', 'megashop' ),
		'search_items'       => __( 'Search Testimonials', 'megashop' ),
		'parent_item_colon'  => __( 'Parent Testimonials:', 'megashop' ),
		'not_found'          => __( 'No testimonials found.', 'megashop' ),
		'not_found_in_trash' => __( 'No testimonials found in Trash.', 'megashop' )
	);

	$args = array(
		'labels'             => $labels,
                'description'        => __( 'Description.', 'megashop' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'testimonial' ),
		'capability_type'    => 'post',
		'menu_icon'          =>'dashicons-format-status',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail' )
	);

	register_post_type( 'testimonial', $args );
}
function add_testimonial_meta_box()
{
    add_meta_box("testimonial-meta-box", esc_html__( "Testimonial designation" , 'megashop' ), "testimonial_meta_box_markup", "testimonial", "side", "high", null);
}

add_action("add_meta_boxes", "add_testimonial_meta_box");
function testimonial_meta_box_markup($object)
{
    wp_nonce_field(basename(__FILE__), "testimonial-meta-box-nonce");
    $test_designition = get_post_meta($object->ID, "testimonial_designation", true);
    ?>
        <div>
            <label for="meta-box-text"><?php esc_html_e('designation','megashop') ?></label>
			<br>
            <input name="testimonial_designation" type="text" value="<?php echo esc_html($test_designition); ?>">

            
        </div>
    <?php  
}
function save_testimoinal_meta_box($post_id, $post, $update)
{
    if (!isset($_POST["testimonial-meta-box-nonce"]) || !wp_verify_nonce($_POST["testimonial-meta-box-nonce"], basename(__FILE__)))
        return $post_id;

    if(!current_user_can("edit_post", $post_id))
        return $post_id;

    if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE)
        return $post_id;

    $slug = "testimonial";
    if($slug != $post->post_type)
        return $post_id;

    $meta_box_text_value = "";

    if(isset($_POST["testimonial_designation"]))
    {
        $meta_box_text_value = esc_html($_POST["testimonial_designation"]);
    }   
    update_post_meta($post_id, "testimonial_designation", $meta_box_text_value);
    
}

add_action("save_post", "save_testimoinal_meta_box", 10, 3);

add_filter( 'manage_testimonial_posts_columns', 'set_custom_edit_testimonial_columns' );
add_action( 'manage_testimonial_posts_custom_column' , 'custom_testimonial_column', 10, 2 );

function set_custom_edit_testimonial_columns($columns) {
$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => esc_html__( 'Title', 'megashop' ),
		'thumbnail' => esc_html__( 'Thumbnail', 'megashop' ),
		'designation' => esc_html__( 'designation', 'megashop' ),
		'author' => esc_html__( 'Author', 'megashop' ),
		'date' => esc_html__( 'Date', 'megashop' )
	);
    return $columns;
}

function custom_testimonial_column( $column, $post_id ) {
    switch ( $column ) {

        case 'thumbnail' :
            if ( has_post_thumbnail() )
                echo get_the_post_thumbnail($post_id);
            break;

        case 'designation' :
            echo get_post_meta( $post_id , 'testimonial_designation' , true ); 
            break;
			/* Just break out of the switch statement for everything else. */
		default :
			break;

    }
}

add_filter( 'init', 'ourbrand_init' );
/**
 * Register a our brand post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function ourbrand_init() {
	$labels = array(
		'name'               => _x( 'Our Brands', 'post type general name', 'megashop' ),
		'singular_name'      => _x( 'Our Brand', 'post type singular name', 'megashop' ),
		'menu_name'          => _x( 'Our Brands', 'admin menu', 'megashop' ),
		'name_admin_bar'     => _x( 'Our Brand', 'add new on admin bar', 'megashop' ),
		'add_new'            => _x( 'Add New', 'Brand', 'megashop' ),
		'add_new_item'       => __( 'Add New Brand', 'megashop' ),
		'new_item'           => __( 'New Brand', 'megashop' ),
		'edit_item'          => __( 'Edit Brand', 'megashop' ),
		'view_item'          => __( 'View Brand', 'megashop' ),
		'all_items'          => __( 'All Our Brands', 'megashop' ),
		'search_items'       => __( 'Search Our Brands', 'megashop' ),
		'parent_item_colon'  => __( 'Parent Our Brands:', 'megashop' ),
		'not_found'          => __( 'No Our Brands found.', 'megashop' ),
		'not_found_in_trash' => __( 'No Our Brands found in Trash.', 'megashop' )
	);

	$args = array(
		'labels'             => $labels,
                'description'        => __( 'Description.', 'megashop' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'ourbrand' ),
		'capability_type'    => 'post',
		'menu_icon'          =>'dashicons-groups',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title','thumbnail','author')
	);

	register_post_type( 'ourbrand', $args );
}

add_action('do_meta_boxes', 'megashop_move_meta_box');

function megashop_move_meta_box(){
    remove_meta_box( 'postimagediv', 'ourbrand', 'side' );
    add_meta_box('postimagediv', esc_html__('Featured Image','megashop'), 'post_thumbnail_meta_box', 'ourbrand', 'normal', 'high');
}
function add_ourbrand_meta_box()
{
    add_meta_box("ourbrand-meta-box", esc_html__(" Our Brands Url", 'megashop'), "ourbrand_meta_box_markup", "ourbrand", "normal", "high", null);
}

add_action("add_meta_boxes", "add_ourbrand_meta_box");
function ourbrand_meta_box_markup($object)
{
    wp_nonce_field(basename(__FILE__), "ourbrand-meta-box-nonce");

    ?>
        <div>
            <label for="meta-box-text"><?php esc_html_e('Brand Url','megashop'); ?></label>
			<br>
            <input name="brand_url" type="text" value="<?php echo get_post_meta($object->ID, "brand_url", true); ?>">
            
        </div>
    <?php  
}
function save_ourbrand_meta_box($post_id, $post, $update)
{
    if (!isset($_POST["ourbrand-meta-box-nonce"]) || !wp_verify_nonce($_POST["ourbrand-meta-box-nonce"], basename(__FILE__)))
        return $post_id;

    if(!current_user_can("edit_post", $post_id))
        return $post_id;

    if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE)
        return $post_id;

    $slug = "ourbrand";
    if($slug != $post->post_type)
        return $post_id;

    $meta_box_text_value = "";

    if(isset($_POST["brand_url"]))
    {
        $meta_box_text_value = esc_url($_POST["brand_url"]);
    }   
    update_post_meta($post_id, "brand_url", $meta_box_text_value);
}

add_action("save_post", "save_ourbrand_meta_box", 10, 3);

add_filter( 'manage_ourbrand_posts_columns', 'set_custom_edit_ourbrand_columns' );
add_action( 'manage_ourbrand_posts_custom_column' , 'custom_ourbrand_column', 10, 2 );

function set_custom_edit_ourbrand_columns($columns) {
$columns = array(
		'cb' => '<input type="checkbox" />',                
		'thumbnail' => esc_html__( 'Thumbnail', 'megashop' ),
                'title' => esc_html__( 'Title', 'megashop' ),
		'brand_url' => esc_html__( 'Brand Url', 'megashop' ),
		'author' => esc_html__( 'Author', 'megashop' ),
		'date' => esc_html__( 'Date', 'megashop' )
	);
    return $columns;
}

function custom_ourbrand_column( $column, $post_id ) {
    switch ( $column ) {

        case 'thumbnail' :
            if ( has_post_thumbnail() )
                echo get_the_post_thumbnail($post_id);
            break;

        case 'brand_url' :
            echo get_post_meta( $post_id , 'brand_url' , true ); 
            break;
			/* Just break out of the switch statement for everything else. */
		default :
			break;

    }
}


/**
 * Media uploader code changed in Options Framework 1.5
 * and no longer uses a custom post type.
 *
 * Function removes the post type 'optionsframework'
 * Media attached to the post type remains in the media library
 *
 * @access      public
 * @since       1.5
 * @return      void
 */
function optionsframework_update_to_version_1_5() {
    register_post_type('megashop-framework', array(
        'labels' => array(
            'name' => esc_html__('Theme Options Media', 'megashop'),
        ),
        'show_ui' => false,
        'rewrite' => false,
        'show_in_nav_menus' => false,
        'public' => false
    ));

    // Get all the optionsframework post type
    $query = new WP_Query(array(
        'post_type' => 'megashop-framework',
        'numberposts' => -1,
    ));

    while ($query->have_posts()) :
        $query->the_post();
        $attachments = get_children(array(
            'post_parent' => the_ID(),
            'post_type' => 'attachment'
                )
        );
        if (!empty($attachments)) {
            // Unassign each of the attachments from the post
            foreach ($attachments as $attachment) {
                wp_update_post(array(
                    'ID' => $attachment->ID,
                    'post_parent' => 0
                        )
                );
            }
        }
        wp_delete_post(the_ID(), true);
    endwhile;

    wp_reset_postdata();
}
add_action( 'init', 'optionsframework_update_to_version_1_5', 21 );