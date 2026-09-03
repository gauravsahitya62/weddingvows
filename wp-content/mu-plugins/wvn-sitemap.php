<?php
/**
 * Plugin Name: WVN Sitemap
 * Description: Renders the public XML sitemap from WordPress content without duplicate URLs.
 */

if (!defined('ABSPATH')) {
    exit;
}

function wvn_sitemap_is_indexable() {
    return !is_search() && !is_404() && !is_attachment() && !is_author() && !is_date() && !is_tag() && !is_paged();
}

function wvn_sitemap_add_url(&$urls, &$seen, $loc, $lastmod = '') {
    if (!$loc) {
        return;
    }
    $key = untrailingslashit($loc);
    if (isset($seen[$key])) {
        return;
    }
    $seen[$key] = true;
    $urls[] = array('loc' => $loc, 'lastmod' => $lastmod);
}

function wvn_sitemap_render() {
    if ((string) get_query_var('wvn_sitemap') !== '1') {
        return;
    }

    $urls = array();
    $seen = array();

    wvn_sitemap_add_url($urls, $seen, home_url('/'));
    wvn_sitemap_add_url($urls, $seen, home_url('/weddings-in-udaipur/'));
    wvn_sitemap_add_url($urls, $seen, home_url('/what-we-do/'));
    wvn_sitemap_add_url($urls, $seen, home_url('/portfolio/'));
    wvn_sitemap_add_url($urls, $seen, home_url('/contact-us/'));

    $blog = get_permalink((int) get_option('page_for_posts'));
    if ($blog) {
        wvn_sitemap_add_url($urls, $seen, $blog);
    }

    foreach (get_categories(array('hide_empty' => true)) as $cat) {
        wvn_sitemap_add_url($urls, $seen, get_category_link($cat));
    }

    $posts = new WP_Query(array(
        'post_type' => array('post', 'portfolio', 'page'),
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'fields' => 'ids',
        'no_found_rows' => true,
        'orderby' => 'modified',
        'order' => 'DESC',
    ));

    foreach ($posts->posts as $post_id) {
        if ($post_id === (int) get_option('page_on_front') || $post_id === (int) get_option('page_for_posts')) {
            continue;
        }
        $post_type = get_post_type($post_id);
        if (!$post_type || !wvn_sitemap_post_type_allowed($post_type)) {
            continue;
        }
        $loc = get_permalink($post_id);
        if (!$loc) {
            continue;
        }
        $lastmod = get_post_modified_time('c', true, $post_id);
        wvn_sitemap_add_url($urls, $seen, $loc, $lastmod);
    }

    nocache_headers();
    header('Content-Type: application/xml; charset=utf-8');
    echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
    foreach ($urls as $item) {
        echo '  <url><loc>' . esc_url($item['loc']) . '</loc>';
        if (!empty($item['lastmod'])) {
            echo '<lastmod>' . esc_html($item['lastmod']) . '</lastmod>';
        }
        echo '</url>' . "\n";
    }
    echo '</urlset>';
    exit;
}

function wvn_sitemap_post_type_allowed($post_type) {
    return in_array($post_type, array('post', 'portfolio', 'page'), true);
}

add_action('template_redirect', 'wvn_sitemap_render', -1);
