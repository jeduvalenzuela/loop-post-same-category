<?php
/**
 * Plugin Name: WP Posts Relacionados
 * Description: Este plugin muestra un listado de posts basándose en las categorías del post que está visualizando el usuario
 * Version: 1.0.0
 * Author: Vicino Software
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
        'posts_per_page' => '20',
        'post__not_in' => array( $post_id )
    );


    $query = new WP_Query( $args );
 
if ( $query->have_posts() ) {
 
    ?>
        <ul class="related-products">
            <?php
 
                while ( $query->have_posts() ) {
 
                    $query->the_post();
 
                    ?>
                    <li>
                        <a class="related-product" href="<?php the_permalink(); ?>">
                            <h3 class="related-title" ><?php the_title(); ?></h3>
                            <?php the_post_thumbnail();?>
                        </a>
                    </li>
                    <?php
 
                }
 
            ?>
        </ul>
    <?php
 
}

}


 
wp_reset_postdata();

add_shortcode('looppostrelated', 'wp_related_posts');
