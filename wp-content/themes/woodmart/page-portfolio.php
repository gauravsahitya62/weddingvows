<?php
/**
 * Portfolio page fallback.
 *
 * Used when WordPress has a normal Page with the /portfolio/ slug. This keeps
 * the public Portfolio URL working even when the page and Portfolio CPT share
 * the same route.
 */
get_header();
if (!function_exists('wvn_render_portfolio_page')) {
    require_once get_theme_file_path('/inc/portfolio-page.php');
}
wvn_render_portfolio_page();
get_footer();
