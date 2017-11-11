<?php
/*
This is the custom post type post template.
If you edit the post type name, you've got
to change the name of this template to
reflect that name change.

i.e. if your custom post type is called
register_post_type( 'bookmarks',
then your single template should be
single-bookmarks.php

*/
?>

<?php get_header(); ?>
<?php
    $meta = get_post_meta(  get_the_ID() );
    set_query_var('meta', $meta);

    $resource_type_id = $meta['resource_type'][0];
    $resource_type = get_term_by( 'id', $resource_type_id, 'attachment_types' );

    $terms = get_the_terms( get_the_ID(), 'attachment_types' );
    $gist = $meta['gist-id'];
    // echo $meta['resource_type'][0];
?>

			<div id="content">

				<div id="inner-content" class="wrap clearfix">

				    <div id="main" class="eightcol first clearfix" role="main">

					    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

					    <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">

						    <header class="article-header">

							    <h1 class="single-title custom-post-type-title"><?php the_title(); ?></h1>

						    </header> <!-- end article header -->

						    <section class="entry-content clearfix">

						    	<?php set_query_var('the_content', apply_filters('the_content', get_the_content())); ?>

						    	<?php get_template_part('library/content', $meta['resource_type'][0]); ?>

                                <p class="resource"></p>

						    </section> <!-- end article section -->

						    <footer class="article-header">


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
        						    <p><?php _e("This is the error message in the single-custom_type.php template.", "bonestheme"); ?></p>
        						</footer>
        					</article>

					    <?php endif; ?>

				    </div> <!-- end #main -->

				    <?php get_sidebar(); ?>

				</div> <!-- end #inner-content -->

			</div> <!-- end #content -->

<?php get_footer(); ?>