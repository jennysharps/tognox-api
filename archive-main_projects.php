<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap clearfix">

				    <div id="main" class="eightcol first clearfix" role="main">

						<h1 class="archive-title">
							<span><?php _e("Projects", "bonestheme"); ?></span>
						</h1>

					    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

					    <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">

						    <header class="article-header">
                                                            <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
                                                                <?php the_post_thumbnail( 'three-col' ); ?>
                                                                <h1 class="h2"><?php the_title(); ?></h1>
                                                            </a>
                                                    </header> <!-- end article header -->

						    <p class=""entry-content">
							    <?php the_excerpt(); ?>
                                                    </p>

                                                    <div class="utility">
                                                    <?php
                                                    $meta = get_post_meta( get_the_ID() );
                                                    $github_url = isset( $meta['github_repo'] ) ?  $meta['github_repo'][0] : '';
                                                    if ( $github_url ) {
                                                    ?>
                                                        <a class="button git-link" href="<?php echo $github_url; ?>" target="_blank">View Related Code on GitHub</a>
                                                    <?php } ?>

                                                        <a class="button" href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">Read more &raquo;</a>
                                                    </div>

						    <?php /* <footer class="article-footer">

						    </footer> <!-- end article footer --> */ ?>

					    </article> <!-- end article -->

					    <?php endwhile; ?>

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