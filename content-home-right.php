<?php
/**
 * The template used for displaying right column content on the home page (page-home.php)
**/
global $post;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <div class="entry-meta">

        <div class="author-avatar">
            <?php $author_email = get_the_author_meta('user_email'); 
			$author_id = get_the_author_meta( 'ID' );
			$author_imgid = get_field('user_photo', 'user_'. $author_id ); // image field, return type = "ID" 
			$author_img = wp_get_attachment_image_src( $author_imgid, 'med-thumbnail' );
			
			if(function_exists('get_avatar')) {
                if(validate_gravatar($author_email)){
                    echo get_avatar( $author_email, 55 );
                } elseif ($author_imgid > 0) { ?>
                <img src="<?php echo $author_img['0']; ?>" alt="<?php the_author_meta('display_name'); ?>" width="55" height="55" />
                <?php } else { 
                echo get_avatar( $author_email, 55, get_template_directory_uri() .'/images/no-avatar.png' ); 
                }
            } ?>
        </div><!-- #author-avatar -->

        <div class="meta-line post-author"><?php the_author(); ?></div>

        <div class="meta-line post-date"><?php the_time('F j, Y') ?></div>

    </div>
    <!-- /entry-meta -->

	<header class="entry-header" id="podcast-info">
		<h1 class="entry-title append-bottom">
        	<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Link to %s', 'mithpress' ), the_title_attribute( 'echo=0' ) ); ?>"><?php the_title(); ?></a>
        </h1>
	</header>
    <!-- /entry-header-->
    
	<div class="entry-content">
	
	<?php if ('podcast' == get_post_type() ) { echo podcast_info_snippet(); } ?>
	
	<?php the_excerpt(); ?>
    
    </div>
    <!-- /entry-content -->
    
    <br clear="all" />

</article>
<!-- /right-column -->