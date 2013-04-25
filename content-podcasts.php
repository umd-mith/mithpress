<?php
/**
 * The template for displaying podcasts in the archive-podcast.php template
 *
**/
?>

<?php

global $podcast_mb;
$podcast_mb->the_meta();
$stitle = $podcast_mb->get_the_value('speakertitle');
$date = $podcast_mb->get_the_value('talk-date');
$time = $podcast_mb->get_the_value('talk-time');
$ttitle = $podcast_mb->get_the_value('talk-title');
global $showdata; 

?>

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <header class="entry-header">

            <h1 class="entry-title append-bottom prepend-top"><a href="<?php the_permalink(); ?>" ><?php if ($ttitle) { echo $ttitle; } else { the_title(); } ?></a></h1>

        </header>
        <!-- /entry-header-->

        <div class="entry-content">

            <div id="podcast-info" class="excerpt append-bottom prepend-top clear">

                <?php the_post_thumbnail( 'med-thumbnail' ); ?>

                <span class="pods-speaker">
                    <?php $podcast_mb->the_value('speaker'); if ($stitle != null) { ?>, <span class="pods-stitle"><?php echo $stitle; ?></span><?php } ?>
                </span>

                <span class="pods-affiliation"><?php $podcast_mb->the_value('affiliation'); ?></span>

				<?php if ( $twitter != '') { ?>
                <span class="pods-twitter"><a href="http://www.twitter.com/#!/<?php echo $twitter ?>" rel="nofollow" target="_blank">@<?php echo $twitter ?></a></span>
                <?php } ?>
        
                <?php echo do_shortcode('[gigpress_related_shows]'); ?>
            </div>
            <!-- /podcast-info -->

            <div id="abstract">

                <?php the_excerpt(); ?>

            </div>
            <!-- /abstract -->

        </div>
        <!-- /entry-content -->

        <br clear="all" />

    </article><!-- /post-<?php the_ID(); ?> -->