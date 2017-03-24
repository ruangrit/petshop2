<?php
/**
 * Template Name: Right Sidebar Page
 *
 * @package WordPress
 * @subpackage Megashop
 * @since Megashop 1.0
 */

get_header(); ?>
<div class="container padding_0 rightsidebar">
   <div class="page-title-wrapper">
    <?php TT_wp_breadcrumb(); ?>
    </div>
<div id="main-content" class="main-content col-md-9 col-sm-9 col-xs-12">
	<div id="primary" class="content-area">
		<div id="content" class="site-content" >
			<?php
				// Start the Loop.
				while ( have_posts() ) : the_post();

					// Include the page content template.
					get_template_part( 'template-parts/content', 'page' );

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}
				endwhile; ?>
				
				    
		</div><!-- #content -->
	</div><!-- #primary -->
</div><!-- #main-content -->
<?php
$sidebar = 'sidebar-1';
if ( is_active_sidebar($sidebar)  ) : ?>
	<aside id="secondary" class="sidebar widget-area col-sm-3 col-md-3 col-xs-12">
		<?php dynamic_sidebar( $sidebar ); ?>
	</aside><!-- .sidebar .widget-area -->
<?php endif; 
get_footer();
