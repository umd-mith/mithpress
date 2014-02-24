<?php
/**
 * The default template for displaying content
 */
?>
	<article id="post-<?php the_ID(); ?>" <?php post_class('search-result'); ?>>
	
        <div class="entry-meta span-5 append-1">
        
            <?php if ( is_page() || 'event' == get_post_type() || 'people' == get_post_type() || 'job' == get_post_type()) : 
			// do nothing 
			else : ?>        	
            
            <div class="author-avatar">
				<?php $author_email = get_the_author_meta('user_email'); 
                $author_id = get_the_author_meta( 'ID' );
                $author_imgid = get_field('user_photo', 'user_'. $author_id ); // image field, return type = "ID" 
                $author_img = wp_get_attachment_image_src( $author_imgid, 'med-thumbnail' );
				$author_show_img = get_field('show_user_photo', 'user_'. $author_id );
                ?>
                <?php if(function_exists('get_avatar')) {
                    if(validate_gravatar($author_email)){
                        echo get_avatar( $author_email, 55 );
                    } elseif ($author_imgid > 0) { ?>
                    <img src="<?php echo $author_img['0']; ?>" alt="<?php the_author_meta('display_name'); ?>" width="55" height="55" />
                    <?php } else { 
					echo get_avatar( $author_email, 55, get_template_directory_uri() .'/images/no-avatar.png' ); 
					}
                }
                ?>
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
					if ( 'event' == get_post_type() || 'podcast' == get_post_type() || 'job' == get_post_type()) : $post_type = get_post_type_object(get_post_type() ); echo '<span class="content-type-title">' . $post_type->labels->singular_name . ':</span> '; 
					elseif ( 'people' == get_post_type() ) : echo '<span class="content-type-title">STAFF:</span> ';
					endif; ?>
				<?php $talk_title = get_post_meta( get_the_ID(), 'podcast_title', TRUE );
					if ($talk_title) { echo $talk_title; } else { the_title(); } ?></a></h1>
            
            </header>
            <!-- /entry-header -->
    
    		
			<?php if ( 'podcast' == get_post_type() ) : // PODCAST DISPLAY ?>
            <div class="entry-summary entry-content podcast-excerpt excerpt">
            
                <div id="podcast-info" class="append-bottom prepend-top clear">
            
                	<?php the_post_thumbnail( 'med-thumbnail', array('class'=>'alignleft entrythumb') ); ?>

					<?php echo podcast_info_snippet(); ?>
                
                </div>
                                    
				<?php the_excerpt(); ?>
                
            </div>
            <!-- /podcast excerpt -->
            
            <?php elseif (is_page() || 'event' == get_post_type() ) : // PAGE OR EVENT DISPLAY ?>
            
            <div class="entry-summary page-excerpt excerpt">
            	
                <?php the_post_thumbnail( 'horiz-thumbnail', array('class'=>'alignleft entrythumb') ); ?>

                <?php the_excerpt();  ?>
            
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