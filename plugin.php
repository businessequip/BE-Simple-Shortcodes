<?php
/*
	Plugin Name: BE Simple Shortcodes
	Plugin URI: http://www.Businessequip.co.uk/plugins/
	Description: Simple Shortcode Plugin 
	Author: Jim Drew
	Author URI: http://www.jimdrew.co.uk

	Version: 1.0.1

	License: GNU General Public License v2.0 (or later)
	License URI: http://www.opensource.org/licenses/gpl-license.php
*/

    add_action( 'wp_enqueue_scripts', 'bess_add_stylesheet' );

    /**
     * Add stylesheet to the page
     */
    function bess_add_stylesheet() {
        wp_enqueue_style( 'bess-style', plugins_url('style.css', __FILE__) );
    }

add_shortcode('BlogPost', 'BlogPost_shortcode');
function BlogPost_shortcode( $attr, $headercontent = null) {
    extract(shortcode_atts(array(
		'term' => '',                           
	     ), $attr));   
		$query_args = array(
				'post_type' => 'Post',
	 			'taxonomy'=>'category',
				'term'=> $term,

		);


		$featured_posts = new WP_Query( $query_args );
		$content .=  '<div id="blogpost">';
		$content .=  '<div class="blogpost">';
		$content .= '<div class="title">'.$headercontent.'</div>';
		$content .= '<img src="/wp-content/uploads/2017/09/blogpost-grey-600x600.jpg">';
		$content .= '</div>';


		if ( $featured_posts->have_posts() ) : while ( $featured_posts->have_posts() ) : $featured_posts->the_post();
		
		$content .=  '<div class="blogpost">';
		$content .= '<a href="'.get_permalink().'">';
		$content .= '<div class="header">BLOG | ';
		$content .= '<div class="blogentry-date">'.get_the_date().'</div>';
		$content .= '</div>';
		$content .= '<div class="title"><h2>'.get_the_title().'</h2></div>';
		$content .= '<div class="excerpt">'.get_the_excerpt().'</div>';
		$img = genesis_get_image( array('format' => 'url','size' => 'featured-post', 'num' => 0, ) );
		$content .= "<img src='$img'>";
		$content .= '</a></div>';

		endwhile; 

		else:
		$content .= "No post yet,";
		endif;
		$content .= '</div>';
		$content .= '<div class="clear"></div>';
		wp_reset_query();

return $content;
}


add_shortcode('FeaturedPost', 'FeaturedPost_shortcode');
function FeaturedPost_shortcode($attr) {
    extract(shortcode_atts(array(
		'term' => '',                           
	     ), $attr));   
		$query_args = array(
				'post_type' => 'Post',
	 			'taxonomy'=>'category',
				'term'=> $term,

		);


		$featured_posts = new WP_Query( $query_args );
		$content .=  '<div id="featuredpost">';
		if ( $featured_posts->have_posts() ) : while ( $featured_posts->have_posts() ) : $featured_posts->the_post();
		
		$content .=  '<div class="featuredpost">';
		$content .= '<a href="'.get_permalink().'">';
		$content .= '<div class="title '.genesis_get_custom_field('position').'"><h2>'.get_the_title().'</h2></div>';
		$img = genesis_get_image( array('format' => 'url','size' => 'featured-post', 'num' => 0, ) );
		$content .= "<img src='$img'>";
		$content .= '</a></div>';

		endwhile; 

		else:
		$content .= "No post yet,";
		endif;
		$content .= '</div>';
		$content .= '<div class="clear"></div>';
		wp_reset_query();

return $content;
}

?>
