<?php
/*
  Template Name: Front Page
 */
?>

<?php get_header(); ?>

<?php
$carousel_items = get_field('carousel_items');

if ($carousel_items):
    ?>
    <section id="carousel" class="flexslider">
        <ul class="slides">
            <?php foreach ($carousel_items as $post): // variable must be called $post (IMPORTANT) ?>
                <?php
                setup_postdata($post);
                $thumb_id = get_post_thumbnail_id(get_the_ID());

                if ($thumb_id) {
                    $image_attributes = wp_get_attachment_image_src($thumb_id, 'homepage-carousel');
                    ?>
                    <li>
                        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                            <img alt="<?php the_title_attribute(); ?>" src="<?php echo $image_attributes[0]; ?>"/>
                            <div class="item-text">
                                <h2><?php echo get_the_title(); ?></h2>
                                <p><?php echo get_the_excerpt(); ?></p>
                            </div>
                        </a>
                    </li>
                    <?php
                }
            endforeach;
            ?>
        </ul>
    </section>
    <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
<?php endif; ?>

    <div class="eightcol first clearfix">
<?php
$meta = get_post_meta( get_the_ID() );
if( isset( $meta['quote'][0] ) ) {
?>
        <figure class="quotation long-quotation">
            <blockquote>
                <p><?php echo $meta['quote'][0]; ?></p>
            </blockquote>
        <?php if( isset( $meta['attribution'][0] ) ) { ?>
            <figcaption><?php echo $meta['attribution'][0]; ?></figcaption>
        <?php } ?>
        </figure>


<?php } ?>
    </div>

    <div id="sidebar1" class="sidebar fourcol last clearfix" role="complementary">
        <?php if ( dynamic_sidebar('home_right') ) : else : endif; ?>
    </div>

<?php get_footer(); ?>
