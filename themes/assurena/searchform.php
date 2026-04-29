<?php

/**
 * Template for displaying search forms in assurena
 *
 * @package       WordPress
 * @subpackage    assurena
 * @since         1.0
 * @version       1.0
 */

?>
<form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="search-form">
    <input required type="text" class="search-field" placeholder="<?php echo esc_attr_x( 'Search here..', 'placeholder', 'assurena' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
    <input class="search-button" type="submit" value="<?php esc_attr_e('Search', 'assurena'); ?>">
    <i class="search__icon fa fa-search"></i>
</form>