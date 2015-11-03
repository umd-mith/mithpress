<?php
/*
Template Name: Home
*/
?>
<?php get_header(); ?>
<div id="page-container" class="home-page">

    <div id="primary" class="width-limit">

        <div id="content" role="main" class="span-22 last">

        <?php get_template_part( 'slider', 'home' ); ?>
        <!-- /slideshow -->
        
        <?php dynamic_sidebar( 'home-center-widgets' ); ?>
            <!-- /twitter feed -->

            <div id="column-wrap">
            
                <div id="left-column">
            
                    <header class="page-header">
                        <h1 class="page-title">Research + Projects</h1>
                    </header>
                    
                    <div id="projects-wrap">
                    <?php $args = array(
                        'post_type' => 'project',
                        'posts_per_page' => 8,
                        'orderby' => 'rand',
                        'tax_query' => array(
                            'relation' => 'AND',
                            array(
                                'taxonomy' => 'projecttype',
                                'field' => 'slug',
                                'terms' => array( 'project')
                            ),
                            array(
                                'taxonomy' => 'projecttype',
                                'field' => 'slug',
                                'terms' => array( 'archive-project'),
                                'operator' => 'NOT IN'
                            )		
                        )
                    );
                    
                    $project_posts = new WP_Query( $args ); 
                
                    $i = 0; // set up a counter so we know which post we're currently showing
                    $counter_class = 'even'; // set up a variable to hold an extra CSS class
                
                    if ( $project_posts -> have_posts() ) : while ( $project_posts -> have_posts() ) : $project_posts -> the_post(); 
                    
                    $i++; // increment the counter
    
                    if( $i % 2 != 0) : $counter_class = 'odd'; // we're on an odd post
                    else : $counter_class = 'even'; 
                    endif; 
                    
                    ?>
                        
                        <article id="post-<?php the_ID(); ?>" <?php post_class($counter_class); ?>>
                        
                            <div class="entry-content">
                                <div id="project-info" class="append-bottom">
                                                    
                                <?php if ( has_post_thumbnail() ) { ?>
                                    <?php $full_img = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full'); ?>
                                    <a href="<?php the_permalink(); ?>" class="hasimg"><img src="<?php echo $full_img[0] ?>" width="195px" /></a>
                                <?php } else { ?>
                                    <a href="<?php the_permalink(); ?>" class="noimg"><?php the_title(); ?></a>
                                <?php } ?>        
            
                                </div>
            
                            </div>
                            <!-- /entry-content -->
                        
                        </article>
                        <!-- /post-<?php the_ID(); ?> -->
                        
                        <?php endwhile; ?>
                        
                    </div>
                    <!--/projects-wrap -->
                
                    <a href="<?php echo get_option('home'); ?>/research/current-projects/" class="readmore left" >More Projects</a>
                    
                    <?php endif; ?>
                    
                    <?php wp_reset_query(); ?>
                
                </div>
                <!-- /left-column -->
                
                <div id="right-column">
                
                    <header class="page-header">
                        <h1 class="page-title">Events + Community</h1>
                    </header>
                
                <?php 
    
                $args = array(
                    'post_type' => array('post','podcast','event'),
                    'posts_per_page' => '2',
                    'orderby' => 'date',
                    'order' => 'DESC'
                );
                
                $posts = new WP_Query( $args ); 
                
                ?>
    
                <?php if ( $posts -> have_posts() ) : ?>
                
                    <?php while ( $posts -> have_posts() ) : $posts -> the_post(); ?>
                
                        <?php get_template_part( 'content', 'home-right'); ?>
                
                    <?php endwhile; ?>
                
                    <a href="<?php echo get_option('home'); ?>/blog/" class="readmore left" >More From The Blog</a>
    
                <?php endif; ?>
                
                <?php wp_reset_query(); ?>
                
                </div>
                <!-- /right-column -->

            </div>
            <!-- /column-wrap -->

        </div>
        <!-- /#content-->

    </div>
    <!-- /primary -->

</div>
<!-- /page / start footer -->

<?php get_footer(); ?>