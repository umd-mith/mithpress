<?php 

/* Template Name: MRE */

get_header();
$content_css = 'width:100%';
$sidebar_css = 'display:none';
$content_class = '';
$sidebar_exists = false;
$sidebar_left = '';
$double_sidebars = false;
?>
	<div id="content" class="fusion-portfolio fusion-portfolio-two research-portfolio" style="<?php echo $content_css; ?>">
	<?php 
	
	$sort_by = '<form method="post" id="gform_1" class="start-year-sort">
	<div class="gform_wrapper">
		<ul class="gform_fields left_label">
		<li class="gfield">
			<label class="gfield_label" for="select_yr">Sort By</label>
			<div class="ginput_container">
				<div class="gravity-select-parent" style="width:33%;">
				<select id="select_yr" class="gfield_select sort-by" name="select" >
					<option value="year_newest">Most Recent First</option>
					<option value="year_oldest">Oldest First</option>
				</select>
				</div>
			</div>
		</li>
		</ul>
	</div>		
	</form>';
	$filter_by = '
	<div><a href="#" id="reset_filters">Reset all filters</a></div>
	<div id="activeProjects"></div>
	<div id="types">
		<label class="gfield_label filter-by filter-label">Filter By Type</label>
	</div>
	<div id="topics">
		<label class="gfield_label filter-by filter-label">Filter By Topic</label>
	</div>
	<div id="sponsors">
		<label class="gfield_label filter-by filter-label">Filter By Sponsor</label>
	</div>
	<div id="years">
		<label class="gfield_label filter-by filter-label">Filter By Start Year</label>
	</div>';
	
    echo do_shortcode('[one_fourth spacing="yes" last="no"]&nbsp;[/one_fourth]');
	echo do_shortcode('[three_fourth spacing="yes" last="yes" id="mre_sorting"]' . $sort_by . '[/three_fourth]');
	echo do_shortcode('[one_fourth spacing="yes" last="no" id="mre_filters" class="filters-column gform_wrapper"]' . $filter_by . '[/one_fourth]');
	echo do_shortcode('[three_fourth last="yes" spacing="yes" class="fusion-portfolio-wrapper clearfix" id="mre_items"]<!--RESEARCH ITEMS HERE-->[/three_fourth]');
	?>
		<?php wp_reset_query(); ?>
	</div>
	<?php if( $sidebar_exists == true ): ?>
	<?php wp_reset_query(); ?>
	<div id="sidebar" class="sidebar" style="<?php echo $sidebar_css; ?>">
		<?php
		if($sidebar_left == 1) {
			generated_dynamic_sidebar($sidebar_1);
		}
		if($sidebar_left == 2) {
			generated_dynamic_sidebar_2($sidebar_2);
		}
		?>
	</div>
	<?php endif; ?>
<?php get_footer();

// Omit closing PHP tag to avoid "Headers already sent" issues.
