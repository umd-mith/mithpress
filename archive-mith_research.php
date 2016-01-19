<?php 

/* Template Name: MRE */

get_header(); ?>
	<div id="content" class="fusion-portfolio fusion-portfolio-two research-portfolio" style="float:none; width:100%;">
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
	
    echo do_shortcode('[one_third spacing="yes" last="no"]&nbsp;[/one_third]');
	echo do_shortcode('[two_third spacing="yes" last="yes" id="mre_sorting"]' . $sort_by . '[/two_third]');
	echo do_shortcode('[one_third spacing="yes" last="no" id="mre_filters" class="filters-column gform_wrapper"]' . $filter_by . '[/one_third]');
	echo do_shortcode('[two_third last="yes" spacing="yes" class="fusion-portfolio-wrapper" id="mre_items"]<!--RESEARCH ITEMS HERE-->[/two_third]');
	?>
	</div>
	<?php wp_reset_query(); ?>
	
	<?php // get_template_part('templates/sidebar', 'research-items');  ?>
    
<?php get_footer(); ?>