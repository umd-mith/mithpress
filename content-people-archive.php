<?php 
/**
 * The template for displaying past staff 
 *
**/
?>
	<article id="post-<?php the_ID(); ?>" <?php post_class('archive'); ?>>
	
		<div class="entry-content">
			<div id="person" class="append-bottom prepend-top">                        	
				<div class="person-info">
					<span class="info-name"><?php the_title(); ?></span>
			
					<?php if (get_field('person_dates', $post->ID)) : ?>

					<?php while(has_sub_field('person_dates')) :
                        $person_title = get_sub_field('person_dates_title'); 
                        $date_start = get_sub_field('person_dates_start');
                        $date_end = get_sub_field('person_dates_end');
					?>
					<span class="info-dates">
                        <span class="span-date"><?php if ( $person_title != '') { ?>
                            <em><?php echo $person_title; } if ( $date_start != '' || $date_end != '' ) { echo ',&nbsp;</em>'; } else { echo '</em>'; }
						if ( $date_start != '') { 
                            echo $date_start;
						} if ( $date_start != '' && $date_end != '' ) { ?>
                        &ndash;  
                        <?php } if ( $date_end != '') { 
                            echo $date_end;
                        } ?> 
                        </span>  
					</span>
                    <?php endwhile; 
					endif; ?>
				</div>
			</div><!-- /person-->
		</div><!-- /entry-content -->
	
	</article>