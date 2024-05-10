function custom_post_shortcode($atts) {
    
    // Query posts
  $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
    $args = array(
        'post_type' => 'properties',   
        'posts_per_page' =>3,
		'order' => 'date',
		'paged' => $paged,
    );
    $query = new WP_Query($args);

    ob_start();

    if ($query->have_posts()) { ?>

		<div class="ofs_post_container">

            <?php while ($query->have_posts()) {
                     $query->the_post();
         
                         $post_image = get_the_post_thumbnail();
			             $thumbnail_url = get_the_post_thumbnail_url(get_the_ID());
                         $post_title = get_the_title();
                         $post_description = get_the_excerpt();
		                 $excerpt = wp_trim_words($post_description, 5, '...');
                         $prt_price = get_field('price');?>
			
			            <div class="ofs_post_item">

                             <?php if (!empty($thumbnail_url)) : ?>
                                      <div class="propery_image">
                                          <a href="<?php the_permalink(); ?>"><img src="<?php echo $thumbnail_url; ?>" alt="<?php the_title(); ?>" style="max-width: 100%; height: auto;"></a>
				                      </div>
                             <?php endif; ?>

                             <div class="propery_details">
                                  <h2 class="post_title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                  <div class="post_description"><p> <?php echo $excerpt ;?> </p> </div>
                                  <?php if (!empty($prt_price)) { ?> 
								      <div class="prt_price"> <?php echo $prt_price ; ?> </div> 
								 <?php } ?>
								 
                                 <div class="propery_ainfo">
								      <?php if (!empty(get_field('property_type'))) { ?> 
								          <div class="prt_type"> <?php echo get_field('property_type') ; ?> </div> 
								      <?php } ?>
								      <?php if (!empty(get_field('sqrt'))) { ?> 
								          <div class="prt_sqrt"> <?php echo get_field('sqrt') ; ?> </div> 
								      <?php } ?>
								 </div>

						  </div>
			        </div>
           
       <?php
         }
        echo '</div>';
       
         echo "<nav class=\"propery_pagination\">";
    $big = 999999999; // need an unlikely integer
    echo paginate_links( array(
        'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
        'format' => '?paged=%#%',
        'current' => max(
 1, get_query_var('paged') ),
        'total' => $query->max_num_pages
    ) );
    echo "</nav>";
		

    } 
	else {
        echo "No post found";
    }

    wp_reset_postdata();

    return ob_get_clean();
}

add_shortcode('custom_post_shortcode', 'custom_post_shortcode');
