<?php
/**
 * The default template for displaying content
 */
?>
	<article id="post-<?php the_ID(); ?>" <?php post_class('search-result'); ?>>
	
        <div class="entry-meta span-5 append-1">
        
            <?php if ( is_page() || 'event' == get_post_type() ) : 
			// do nothing 
			else : ?>        	
            
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
            
            <?php endif; ?>
        
        </div>
        <!-- /entry-meta -->
        
        <div class="post-wrap">
        
            <header class="entry-header">
            
            
                <h1 class="entry-title append-bottom"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'mithpress' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
				<?php $post_type = get_post_type(); 
					if ( 'event' == get_post_type() || 'podcast' == get_post_type() ) : $post_type = get_post_type_object(get_post_type() ); echo '<span>' . $post_type->labels->singular_name . ':</span> '; endif; ?>
				<?php the_title(); ?></a></h1>
            
            </header>
            <!-- /entry-header -->
    
    		
			<?php if ( 'podcast' == get_post_type() ) : 

				global $podcast_mb;
				$podcast_mb->the_meta();
				$twitter = $podcast_mb->get_the_value('twitter');
				$stitle = $podcast_mb->get_the_value('speakertitle');
			?>
            <div class="entry-summary entry-content podcast-excerpt excerpt">
            
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
                                    
				<?php the_excerpt(); // regular post excerpt ?>
                
            </div>
            <!-- /podcast excerpt -->
            
            <?php elseif (is_page() || 'event' == get_post_type() ) : ?>
            
            <div class="entry-summary page-excerpt excerpt">
            	
                <?php the_post_thumbnail( 'horiz-thumbnail', array('class'=>'alignleft entrythumb') ); ?>

                <?php the_excerpt(); // regular post excerpt ?>
            
            </div>
            <!-- /page or event excerpt -->
            <?php else : ?>
            
            <div class="entry-content entry-summary excerpt">

                <?php the_post_thumbnail( 'horiz-thumbnail', array('class'=>'alignleft entrythumb') ); ?>

                <?php the_excerpt(); // regular post excerpt ?>

            </div>
            <!-- /.entry-summary / search -->
           
            <?php endif; ?>

        </div>
	    <!-- /post-wrap -->

	</article>
    <!-- /post-<?php the_ID(); ?> -->