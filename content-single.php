<?php
/**
 * The template for displaying content in the single.php template
 *
**/
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <div class="entry-meta span-5 append-1">

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
        
        <div class="meta-line post-author"><?php the_author(); ?></div>
        <div class="meta-line post_date"><?php the_time('F j, Y') ?></div>
        <div class="meta-line post-categories"><?php the_category(' <span>, </span> '); ?></div>
		<?php edit_post_link( __( 'Edit', 'mithpress' ), '<div class="meta-line post-edit">', '</div>' ); ?>
        <div class="meta-line post-comments"><?php comments_popup_link(__('No Comments'), __('1 Comment'), __('% Comments'), '', __('')); ?></div>
        
    </div>
    <!-- /entry-meta -->
	
    <div class="post-wrap">
	
        <header class="entry-header">

            <h1 class="entry-title append-bottom"><?php the_title(); ?></h1>

        </header>
        <!-- /entry-header -->

        <div class="entry-content">
    
            <?php the_content(); ?>
    
        </div>
        <!-- /entry-content -->
    
    	<?php get_template_part('sharing', 'post'); ?>
    
    </div>
    <!-- /post-wrap -->
    
    <br clear="all" />

</article><!-- /post-<?php the_ID(); ?> -->