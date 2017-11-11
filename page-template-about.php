<?php
/*
Template Name: About Page
*/
?>

<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap clearfix">

				    <div id="main" class="eightcol first clearfix" role="main">

					    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

					    <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">

						    <header class="article-header">

							    <h1 class="page-title"><?php the_title(); ?></h1>

						    </header> <!-- end article header -->

                                                    <?php
                                                    $meta = get_post_meta( get_the_ID() );
                                                    $file_one_url = wp_get_attachment_url( $meta['file_1'][0]);
                                                    $file_one_text = $meta['file_1_name'][0];
                                                    $file_two_url = wp_get_attachment_url( $meta['file_2'][0]);
                                                    $file_two_text = $meta['file_2_name'][0];
                                                    ?>

						    <section class="entry-content">
                                                    <div class="resume-section">
                                                    <?php if( $file_one_url ) { ?>
                                                        <a target="_blank" class="icon icon-large resume" href="<?php echo $file_one_url; ?>">
                                                            <div class="ribbon">
                                                                <h4><?php echo $file_one_text; ?></h4>
                                                            </div>
                                                        </a>
                                                    <?php } ?>
                                                    <?php if( $file_two_url ) { ?>
                                                        <a target="_blank" class="icon icon-large cv" href="<?php echo $file_two_url; ?>">
                                                            <div class="ribbon">
                                                                <h4><?php echo $file_two_text; ?></h4>
                                                            </div>
                                                        </a>
                                                    <?php } ?>
                                                    </div>

							    <?php the_content(); ?>
						    </section> <!-- end article section -->

						    <footer class="article-footer">

							    <p class="clearfix"><?php the_tags('<span class="tags">Tags: ', ', ', '</span>'); ?></p>

						    </footer> <!-- end article footer -->

						    <?php comments_template(); ?>

					    </article> <!-- end article -->

					    <?php endwhile; ?>

					    <?php else : ?>

        					<article id="post-not-found" class="hentry clearfix">
        					    <header class="article-header">
        						    <h1><?php _e("Oops, Post Not Found!", "bonestheme"); ?></h1>
        						</header>
        					    <section class="entry-content">
        						    <p><?php _e("Uh Oh. Something is missing. Try double checking things.", "bonestheme"); ?></p>
        						</section>
        						<footer class="article-footer">
        						    <p><?php _e("This is the error message in the page-custom.php template.", "bonestheme"); ?></p>
        						</footer>
        					</article>

					    <?php endif; ?>

				    </div> <!-- end #main -->

				    <?php get_sidebar('about'); ?>

				</div> <!-- end #inner-content -->

			</div> <!-- end #content -->

<?php get_footer(); ?>