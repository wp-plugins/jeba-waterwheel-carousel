<?php
/*
Plugin Name: Jeba Waterwheel Carousel
Plugin URI: http://prowpexpert.com
Description: This is Jeba wordpress Waterwheel Carousel plugin really looking awesome sliding. Everyone can use the cute Waterwheel Carousel plugin easily like other wordpress plugin. By using [carousel] shortcode use the slider every where post, page and template.
Author: Md Jahed
Version: 1.0
Author URI: http://prowpexpert.com/
*/
function jeba_wp_latest_jquery_d() {
	wp_enqueue_script('jquery');
}
add_action('init', 'jeba_wp_latest_jquery_d');

function plugin_function_jeba_slider() {

    wp_enqueue_script( 'jeba-js-dssss', plugins_url( '/js/jquery.waterwheelCarousel.js', __FILE__ ), true);
    wp_enqueue_style( 'jebacss-d', plugins_url( '/js/style.css', __FILE__ ));
}

add_action('init','plugin_function_jeba_slider');
function jeba_script_slider_function () {?>
 
	<script type="text/javascript">
      jQuery(document).ready(function () {
        var carousel = jQuery("#carousel").waterwheelCarousel({
          flankingItems: 3,
          movingToCenter: function ($item) {
            jQuery('#callback-output').prepend('movingToCenter: ' + $item.attr('id') + '<br/>');
          },
          movedToCenter: function ($item) {
            jQuery('#callback-output').prepend('movedToCenter: ' + $item.attr('id') + '<br/>');
          },
          movingFromCenter: function ($item) {
            jQuery('#callback-output').prepend('movingFromCenter: ' + $item.attr('id') + '<br/>');
          },
          movedFromCenter: function ($item) {
            jQuery('#callback-output').prepend('movedFromCenter: ' + $item.attr('id') + '<br/>');
          },
          clickedCenter: function ($item) {
            jQuery('#callback-output').prepend('clickedCenter: ' + $item.attr('id') + '<br/>');
          }
        });

        jQuery('#prev').bind('click', function () {
          carousel.prev();
          return false
        });

        jQuery('#next').bind('click', function () {
          carousel.next();
          return false;
        });

        jQuery('#reload').bind('click', function () {
          newOptions = eval("(" + $('#newoptions').val() + ")");
          carousel.reload(newOptions);
          return false;
        });

      });
    </script>

<?php
}
add_action('wp_footer','jeba_script_slider_function');

function jeba_slider_shortcode_d($atts){
	extract( shortcode_atts( array(
		'post_type' => 'carousel-items',
		'title' => '',
		'count' => '7',
	), $atts) );
	
    $q = new WP_Query(
        array('posts_per_page' => $count, 'post_type' => $post_type)
        );		
		
		$plugins_url = plugins_url();
		
	$list = '<h1>'.$title.'</h1>
    <div id="carousel">';
	while($q->have_posts()) : $q->the_post();
		$idd = get_the_ID();
		$jeba_img_large = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large-portfolio' );
		
		$list .= '
			<a href="#"><img src="'.$jeba_img_large[0].'" id="item-'.$idd.'" /></a>
		';        
	endwhile;
	$list.= '</div>
    <a href="#" id="prev">Prev</a> | <a href="#" id="next">Next</a>';
	wp_reset_query();
	return $list;
}
add_shortcode('carousel', 'jeba_slider_shortcode_d');

add_action( 'init', 'jeba_siler_custom_post_d' );
function jeba_siler_custom_post_d() {

	register_post_type( 'carousel-items',
		array(
			'labels' => array(
				'name' => __( 'carousel' ),
				'singular_name' => __( 'carousel' )
			),
			'public' => true,
			'supports' => array('title', 'editor', 'thumbnail'),
			'has_archive' => true,
			'rewrite' => array('slug' => 'carousel-item'),
			'taxonomies' => array('category', 'post_tag') 
		)
	);	
	}

add_image_size( 'large-portfolio', 320, 180, true );
?>