<?php
get_header();
if (!function_exists('wvn_render_portfolio_page')) {
    require_once get_theme_file_path('/inc/portfolio-page.php');
}
wvn_render_portfolio_page();
get_footer();
