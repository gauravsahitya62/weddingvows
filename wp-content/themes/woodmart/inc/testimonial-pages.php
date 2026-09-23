<?php
/**
 * Virtual, stable testimonial detail routes backed by the existing ACF home_quotes data.
 */

function wvn_testimonial_slug($quote, $index = 0) {
    $name = is_array($quote) ? trim((string) ($quote['name'] ?? '')) : '';
    $text = is_array($quote) ? trim((string) ($quote['text'] ?? '')) : '';
    $base = sanitize_title($name);

    if ($base === '') {
        $base = 'testimonial';
    }

    $quotes = function_exists('wvn_testimonials') ? wvn_testimonials() : array();
    $matches = 0;
    foreach ($quotes as $candidate) {
        if (sanitize_title((string) ($candidate['name'] ?? '')) === $base) {
            $matches++;
        }
    }

    if ($matches > 1) {
        $hash = substr(md5($name . '|' . $text), 0, 8);
        return $base . '-' . $hash;
    }

    return $base;
}

function wvn_testimonial_detail_url($quote, $index = 0) {
    return home_url('/testimonials/' . rawurlencode(wvn_testimonial_slug($quote, $index)) . '/');
}

function wvn_testimonial_find_by_slug($slug) {
    $slug = sanitize_title((string) $slug);
    if ($slug === '') {
        return null;
    }

    $quotes = function_exists('wvn_testimonials') ? wvn_testimonials() : array();
    foreach ($quotes as $index => $quote) {
        if (wvn_testimonial_slug($quote, $index) === $slug) {
            return array(
                'quote' => $quote,
                'index' => (int) $index,
                'slug'  => $slug,
            );
        }
    }

    return null;
}

function wvn_testimonial_add_rewrite_rules() {
    add_rewrite_tag('%wvn_testimonial_slug%', '([^&]+)');
    add_rewrite_rule(
        '^testimonials/([^/]+)/?$',
        'index.php?pagename=testimonials&wvn_testimonial_slug=$matches[1]',
        'top'
    );

    if (get_option('wvn_testimonial_routes_v1') !== '1') {
        flush_rewrite_rules(false);
        update_option('wvn_testimonial_routes_v1', '1', false);
    }
}
add_action('init', 'wvn_testimonial_add_rewrite_rules', 20);

function wvn_testimonial_query_vars($vars) {
    $vars[] = 'wvn_testimonial_slug';
    return $vars;
}
add_filter('query_vars', 'wvn_testimonial_query_vars');

function wvn_testimonial_current() {
    $slug = get_query_var('wvn_testimonial_slug');
    if ($slug !== '') {
        return wvn_testimonial_find_by_slug($slug);
    }

    if (isset($_GET['testimonial']) && is_scalar($_GET['testimonial'])) {
        $index = max(0, (int) $_GET['testimonial']);
        $quotes = function_exists('wvn_testimonials') ? wvn_testimonials() : array();
        if (isset($quotes[$index])) {
            return array(
                'quote' => $quotes[$index],
                'index' => $index,
                'slug'  => wvn_testimonial_slug($quotes[$index], $index),
            );
        }
    }

    return null;
}

function wvn_testimonial_excerpt_plain($text, $max_chars = 170) {
    $text = trim(wp_strip_all_tags((string) $text));
    if ($text === '' || mb_strlen($text) <= $max_chars) {
        return $text;
    }

    $candidate = mb_substr($text, 0, $max_chars + 1);
    $last_space = mb_strrpos($candidate, ' ');
    if ($last_space !== false) {
        $candidate = mb_substr($candidate, 0, $last_space);
    }

    $sentences = preg_split('/(?<=[.!?])\s+/u', $candidate);
    if (is_array($sentences) && count($sentences) > 1) {
        array_pop($sentences);
        $candidate = trim(implode(' ', $sentences));
    }

    return rtrim($candidate, " .,!?:;") . '…';
}

function wvn_testimonial_seo_title($title) {
    $current = wvn_testimonial_current();
    if (!$current) {
        return $title;
    }

    $name = trim((string) ($current['quote']['name'] ?? 'Their Story'));
    return $name . ' | In Their Words | Wedding Vows by Nikhil';
}

function wvn_testimonial_seo_description($description) {
    $current = wvn_testimonial_current();
    if (!$current) {
        return $description;
    }

    $text = wvn_testimonial_excerpt_plain($current['quote']['text'] ?? '', 155);
    return $text !== '' ? $text : $description;
}

add_filter('document_title_parts', function ($parts) {
    if (wvn_testimonial_current()) {
        $parts = array('title' => wvn_testimonial_seo_title(''));
    }
    return $parts;
}, 80);

add_filter('wpseo_title', function ($title) {
    return wvn_testimonial_seo_title($title);
}, 80);

add_filter('wpseo_opengraph_title', function ($title) {
    return wvn_testimonial_seo_title($title);
}, 80);

add_filter('wpseo_twitter_title', function ($title) {
    return wvn_testimonial_seo_title($title);
}, 80);

add_filter('wpseo_metadesc', function ($description) {
    return wvn_testimonial_seo_description($description);
}, 80);

add_filter('wpseo_opengraph_desc', function ($description) {
    return wvn_testimonial_seo_description($description);
}, 80);

add_filter('wpseo_twitter_description', function ($description) {
    return wvn_testimonial_seo_description($description);
}, 80);
