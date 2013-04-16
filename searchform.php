<?php
/**
 * The template for displaying search form
 */
?>


<div id="search-box">
  <form action="<?php echo esc_url( home_url( "/" ) ); ?>" id="search-form" method="get" target="_top">
    <label for="s" class="assistive-text"><?php _e( "Search", "mithpress" ); ?></label>
    <input id="search-text" name="s" placeholder="<?php esc_attr_e( "SEARCH", "mithpress" ); ?>" type="text"/>
    <button id="search-button" type="submit"><span><?php esc_attr_e( "GO", "mithpress" ); ?></span></button>
  </form>
</div>