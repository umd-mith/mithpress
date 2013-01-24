<?php
/**
 * The default template for displaying content
 */
?>
	<article id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
	
        <div class="entry-meta span-5 append-1">
    
            <div class="author-avatar">
                <?php $author_email = get_the_author_meta('user_email'); ?>
                <?php echo get_avatar( $author_email, 55, get_bloginfo('template_url').'/images/no-avatar.png' ); ?>
            </div>
            <!-- /author-avatar -->
    
            <div class="meta-line post-author"><?php the_author(); ?></div>
    
            <div class="meta-line post-date"><?php the_time('F j, Y') ?></div>
    
            <div class="meta-line post-categories"><?php the_category(' <span>, </span> '); ?></div>
            
            <?php edit_post_link( __( 'Edit', 'mithpress' ), '<div class="meta-line post-edit">', '</div>' ); ?>
                    
            <div class="meta-line post-comments"><?php comments_popup_link(__('No Comments'), __('1 Comment'), __('% Comments'), '', __('')); ?></div>
        
        </div>
        <!-- /entry-meta -->
        
        <div class="post-wrap">
        
            <header class="entry-header">
            
                <h1 class="entry-title append-bottom"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'mithpress' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
            
            </header>
            <!-- /entry-header -->
    
			<?php if ( is_search() ) : ?>
    
            <div class="entry-summary">
    
                <?php the_excerpt(); // search result excerpt ?>
    
            </div>
            <!-- /.entry-summary / search -->
    
            <?php endif; ?>
    		
			<?php if ( 'podcast' == get_post_type() ) : 

				global $podcast_mb;
				$podcast_mb->the_meta();
				$twitter = $podcast_mb->get_the_value('twitter');
				$stitle = $podcast_mb->get_the_value('speakertitle');
			?>

            <div class="entry-content excerpt">
            
                <div id="podcast-info" class="append-bottom prepend-top clear">
            
                	<?php the_post_thumbnail( 'med-thumbnail', array('class'=>'alignleft entrythumb') ); ?>
    
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
                                    
				<?php the_excerpt(); // regular post excerpt ?>
                
            </div>
            
            <?php else : ?>
            
            <div class="entry-content excerpt">

                <?php the_post_thumbnail( 'med-thumbnail', array('class'=>'alignleft entrythumb') ); ?>

                <?php the_excerpt(); // regular post excerpt ?>

            </div>
            
            <?php endif; ?>
            
            <!-- /entry-content -->

        </div>
	    <!-- /post-wrap -->

	</article>
    <!-- /post-<?php the_ID(); ?> -->