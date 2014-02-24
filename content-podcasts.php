<?php
/**
 * The template for displaying podcasts in the archive-podcast.php template
 *
**/
?>


    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <header class="entry-header">
			<?php $talk_title = get_post_meta( get_the_ID(), 'podcast_title', TRUE ); ?>
            <h1 class="entry-title append-bottom prepend-top"><a href="<?php the_permalink(); ?>" ><?php if ($talk_title) { echo $talk_title; } else { the_title(); } ?></a></h1>

        </header>
        <!-- /entry-header-->

        <div class="entry-content">

            <div id="podcast-info" class="excerpt append-bottom prepend-top clear">

                <?php the_post_thumbnail( 'med-thumbnail' ); ?>

				<?php echo podcast_info_snippet(); ?>

            </div>
            <!-- /podcast-info -->

            <div id="abstract" class="post-abstract">

                <?php the_excerpt(); ?>

            </div>
            <!-- /abstract -->

        </div>
        <!-- /entry-content -->

        <br clear="all" />

    </article><!-- /post-<?php the_ID(); ?> -->