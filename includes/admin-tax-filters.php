<?php 

/* Filter Dropdowns */
/*-----------------------------------------------------------------------------------*/
 class MITHF_walker extends Walker_CategoryDropdown
{
    public $tree_type = 'category';
    public $db_fields = array(
        'parent' => 'parent',
        'id'     => 'term_id',
    );
    public $tax_name;

    public function start_el( &$output, $term, $depth, $args, $id = 0 )
    {
        $pad = str_repeat( '&nbsp;', $depth * 3 );
        $cat_name = apply_filters( 'list_cats', $term->name, $term );
        $output .= sprintf(
            '<option class="level-%s" value="%s" %s>%s%s</option>',
            $depth,
            $term->slug,
            selected(
                $args['selected'],
                $term->slug,
                false
            ),
            $pad.$cat_name,
            $args['show_count']
                ? "&nbsp;&nbsp;({$term->count})"
                : ''
        );
    }
}

add_action( 'plugins_loaded', array( 'MITH_Admin_PT_List_Tax_Filter', 'init' ) );

class MITH_Admin_PT_List_Tax_Filter
{
    private static $instance;

    public $post_type;

    public $taxonomies;

    static function init()
    {
        null === self::$instance AND self::$instance = new self;
        return self::$instance;
    }

    public function __construct()
    {
        add_action( 'load-edit.php', array( $this, 'setup' ) );
    }

    public function setup()
    {
        add_action( current_filter(), array( $this, 'setup_vars' ), 20 );

        add_action( 'restrict_manage_posts', array( $this, 'get_select' ) );

        add_filter( "manage_taxonomies_for_{$this->post_type}_columns", array( $this, 'add_columns' ) );
    }

    public function setup_vars()
    {
        $this->post_type  = get_current_screen()->post_type;
        $this->taxonomies = array_diff(
            get_object_taxonomies( $this->post_type ),
            get_taxonomies( array( 'show_admin_column' => 'false' ) )
        );
    }

    public function add_columns( $taxonomies )
    {
        return array_merge( taxonomies, $this->taxonomies );
    }


    public function get_select()
    {
        $walker = new MITHF_walker;
        foreach ( $this->taxonomies as $tax )
        {
            wp_dropdown_categories( array(
                'taxonomy'        => $tax,
                'hide_if_empty'   => true,
                'show_option_all' => sprintf(
                    get_taxonomy( $tax )->labels->all_items
                ),
                'hide_empty'      => true,
                'hierarchical'    => is_taxonomy_hierarchical( $tax ),
                'show_count'      => true,
                'orderby'         => 'name',
                'selected'        => '0' !== get_query_var( $tax )
                    ? get_query_var( $tax )
                    : false,
                'name'            => $tax,
                'id'              => $tax,
                'walker'          => $walker,
            ) );
        }

    }

} 

?>