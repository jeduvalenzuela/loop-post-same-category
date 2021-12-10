<?php
/**
 * Plugin Name: WP Posts Relacionados
 * Description: Este plugin muestra un listado de posts basándose en las categorías del post que está visualizando el usuario
 * Version: 1.0.0
 * Author: Eduardo Valenzuela
 * Author URI: https://gavaweb.com/Eduardo-Valenzuela
 * License: GPL-3.0+
 */

function wp_related_posts() {
 
    $post_id = get_the_ID();
    $cat_ids = array();
    $categories = get_the_category( $post_id );

    if ( $categories && ! is_wp_error( $categories ) ) {
         
        foreach ( $categories as $category ) {
     
            array_push( $cat_ids, $category->term_id );
     
        }
         
    }

    $current_post_type = get_post_type( $post_id );
     
    $args = array(
        'category__in' => $cat_ids,
        'post_type' => $current_post_type,
        'posts_per_page' => '6',
        'post__not_in' => array( $post_id )
    );
}

$query = new WP_Query( $args );
 
if ( $query->have_posts() ) {
 
    ?>
    <aside class="related-posts">
        <h3>
            <?php _e( 'Posts Relacionados', 'wpdirecto' ); ?>
        </h3>
        <ul class="related-posts">
            <?php
 
                while ( $query->have_posts() ) {
 
                    $query->the_post();
 
                    ?>
                    <li>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>
                    </li>
                    <?php
 
                }
 
            ?>
        </ul>
    </aside>
    <?php
 
}
 
wp_reset_postdata();

