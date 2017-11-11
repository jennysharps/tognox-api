<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap clearfix">

				    <div id="main" class="twelvecol first clearfix" role="main">

						<h1 class="archive-title">
							<span><?php _e("Resources", "bonestheme"); ?></span>
						</h1>

						<ul class="filter" data-filter-type="resources">
							<li class="filter-text">Filter: </li>
							<li class="filter-button" data-filter="code">Code</li>
							<li class="filter-button" data-filter="video">Videos</li>
							<li class="filter-button" data-filter="poster">Posters &amp; Presentations</li>
						</ul>

						<div class="items items-resources clearfix show-poster show-video show-code">
						    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
						    	<?php 
						    		$meta = get_post_meta(get_the_ID());
						    		$resource_type = $meta['resource_type'][0];

						    		switch($meta['resource_type'][0]) {
						    			case "gist":
						    			case "github":
						    				$type = "code";
						    				break;
						    			case "video":
						    				$type = "video";
						    				break;
						    			case "file":
						    				$type = "poster";
						    				break;
						    		}
						    	?>
						    	
							    <article id="post-<?php the_ID(); ?>" <?php post_class("clearfix item item-resources filter-{$type}"); ?> role="article">
	                                <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
	                                    <?php the_post_thumbnail( '16x9' ); ?>
	                                    <span class="fa-icon fa-icon-<?php echo $type; ?>"></span>
	                                    <h1 class="h2 "><?php the_title(); ?></h1>
	                                </a>
							    </article> <!-- end article -->
						    <?php endwhile; ?>
						</div>

					    <?php else : ?>

    					    <article id="post-not-found" class="hentry clearfix">
    						    <header class="article-header">
    							    <h1><?php _e("Oops, Post Not Found!", "bonestheme"); ?></h1>
    					    	</header>
    						    <section class="entry-content">
    							    <p><?php _e("Uh Oh. Something is missing. Try double checking things.", "bonestheme"); ?></p>
        						</section>
    	    					<footer class="article-footer">
    		    				    <p><?php _e("This is the error message in the archive-resources.php template.", "bonestheme"); ?></p>
    			    			</footer>
    				    	</article>

					    <?php endif; ?>

    				</div> <!-- end #main -->

                </div> <!-- end #inner-content -->

			</div> <!-- end #content -->

<?php get_footer(); ?>
