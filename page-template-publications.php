<?php
/*
  Template Name: Publications Page
 */
?>

<?php get_header(); ?>


			<div id="content">

				<div id="inner-content" class="wrap clearfix">

				    <div id="main" class="eightcol first clearfix" role="main">

                                            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

                                            <h1><?php the_title(); ?></h1>

                                            <?php if( get_the_content() ) { ?>
                                            <section id="intro">
                                                <?php the_content(); ?>
                                            </section>
                                            <?php } ?>

                                            <?php endwhile; ?>
                                            <?php endif; ?>


					    <?php
                                            /* Start publications query */
                                            $args = array(
                                                    'post_type' => 'jls_citation',
						    'posts_per_page' => -1,
                                                    'meta_query' => array(
                                                            array(
                                                                    'key' => 'citation_type',
                                                                    'compare' => 'EXISTS'
                                                            )
                                                    )
                                            );

                                            $publications_query = new WP_Query( $args );

                                            if ( $publications_query->have_posts() ) :
                                                $prev_year = NULL;
                                                while ( $publications_query->have_posts()) : $publications_query->the_post();

                                                    $this_year = get_the_date('Y'); ?>

                                                    <?php if( $this_year != $prev_year ) {
                                                        if( $prev_year !== NULL ) { ?>

                                                        </ul>
                                                    </section>

                                                        <?php } ?>

                                                    <section class="<?php echo ' ' . $this_year; ?>">
                                                        <h1><?php echo $this_year; ?></h1>
                                                        <ul class="publication-list">

                                                    <?php } ?>

                                                        <li class="citation citation-<?php the_ID(); ?>">
                                                            <?php if( function_exists( 'get_citation' ) ) {
                                                                echo get_extended_citation( get_the_ID() );
                                                            } ?>
                                                        </li>

                                                        <?php $prev_year = $this_year; ?>

                                                <?php endwhile; ?>

                                                        </ul>
                                                    </section>

                                                <?php if (function_exists('bones_page_navi')) { ?>
                                                        <?php bones_page_navi(); ?>
                                                <?php } else { ?>
                                                        <nav class="wp-prev-next">
                                                                <ul class="clearfix">
                                                                        <li class="prev-link"><?php next_posts_link(__('&laquo; Older Entries', "bonestheme")) ?></li>
                                                                        <li class="next-link"><?php previous_posts_link(__('Newer Entries &raquo;', "bonestheme")) ?></li>
                                                                </ul>
                                                    </nav>
                                                <?php } ?>

					    <?php else : ?>

    					    <article id="post-not-found" class="hentry clearfix">
    						    <header class="article-header">
    							    <h1><?php _e("Oops, Post Not Found!", "bonestheme"); ?></h1>
    					    	</header>
    						    <section class="entry-content">
    							    <p><?php _e("Uh Oh. Something is missing. Try double checking things.", "bonestheme"); ?></p>
        						</section>
    	    					<footer class="article-footer">
    		    				    <p><?php _e("This is the error message in the archive.php template.", "bonestheme"); ?></p>
    			    			</footer>
    				    	</article>

					    <?php endif; ?>

    				</div> <!-- end #main -->

	    			<?php get_sidebar(); ?>

                </div> <!-- end #inner-content -->

			</div> <!-- end #content -->

<?php get_footer(); ?>
