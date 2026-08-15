<?php
/**
 * On-page, technical, and local SEO for Wedding Vows by Nikhil.
 */

function wvn_seo_profile() {
    return array(
        'name'        => 'Wedding Vows by Nikhil',
        'legal'       => 'Wedding Vows By Nikhil',
        'founder'     => 'Nikhil Salvi',
        'email'       => 'weddingvowsbynikhil@gmail.com',
        'url'         => home_url('/'),
        'logo'        => wvn_logo_src(),
        'image'       => wvn_hero_image(),
        'description' => 'Luxury destination wedding planner in Udaipur. Palace, lakeside and heritage weddings across Udaipur, Jaipur, Jodhpur and Goa.',
        'area'        => array('Udaipur', 'Jaipur', 'Jodhpur', 'Goa', 'India'),
        'street'      => '53, Sun city, Delhite, Behind Celebration Mall, Bhuwana',
        'city'        => 'Udaipur',
        'region'      => 'Rajasthan',
        'postal'      => '313001',
        'country'     => 'IN',
        'lat'         => 24.6126,
        'lng'         => 73.6989,
        'same_as'     => array(
            'https://www.instagram.com/weddingvowsbynikhil',
            'https://www.facebook.com/share/16DJ386egg/?mibextid=wwXIfr',
            'https://www.wedmegood.com/profile/Wedding-Vows-by-Nikhil-25668282',
        ),
    );
}

function wvn_seo_current() {
    $brand = 'Wedding Vows by Nikhil';
    $img   = wvn_hero_image();

    if (is_front_page()) {
        return array(
            'title'       => 'Destination Wedding Planner in Udaipur | ' . $brand,
            'description' => 'Plan a luxury destination wedding in Udaipur with Wedding Vows by Nikhil. Palace, lakeside and heritage celebrations across Udaipur, Jaipur, Jodhpur and Goa — one team, end to end.',
            'image'       => $img,
            'type'        => 'website',
        );
    }
    if (is_page('what-we-do') || is_page_template('page-what-we-do.php')) {
        return array(
            'title'       => 'Destination Wedding Services in Udaipur | Venues, Décor & Planning',
            'description' => 'Full-service destination wedding planning in Udaipur: venue sourcing, décor and design, photography, hospitality and on-ground execution by one studio.',
            'image'       => $img,
            'type'        => 'website',
        );
    }
    if (is_page('contact-us')) {
        return array(
            'title'       => 'Book a Destination Wedding Planner in Udaipur | Contact',
            'description' => 'Talk to Nikhil Salvi about your destination wedding in Udaipur. Share your date, guest count and venue ideas — we will reply with a clear next step.',
            'image'       => $img,
            'type'        => 'website',
        );
    }
    if (wvn_is_udaipur_guide()) {
        return array(
            'title'       => 'Weddings in Udaipur: Venues, Costs & Planning | ' . $brand,
            'description' => 'Hosting a 2-day wedding for 150 to 200 guests in Udaipur typically ranges from ₹50 lakhs to ₹3+ crores. Palace, resort and boutique venues — plus a local planner’s cost breakdown.',
            'image'       => $img,
            'type'        => 'website',
        );
    }
    if (is_post_type_archive('portfolio') || is_page('portfolio')) {
        return array(
            'title'       => 'Real Destination Weddings in Udaipur | Wedding Gallery',
            'description' => 'A gallery of destination weddings planned in Udaipur and across India — palace ceremonies, lakeside vows, and celebrations designed by Wedding Vows by Nikhil.',
            'image'       => $img,
            'type'        => 'website',
        );
    }
    if (is_home()) {
        return array(
            'title'       => 'Destination Wedding Journal | Planning Tips from Udaipur',
            'description' => 'Notes from an Udaipur destination wedding studio: palace venues, timelines, décor, costs, and real celebrations across India.',
            'image'       => $img,
            'type'        => 'website',
        );
    }
    if (is_category()) {
        $cat = get_queried_object();
        $name = $cat && !empty($cat->name) ? $cat->name : 'Journal';
        return array(
            'title'       => $name . ' — Destination Wedding Stories | ' . $brand,
            'description' => 'Read ' . strtolower($name) . ' from Wedding Vows by Nikhil, a destination wedding planner in Udaipur.',
            'image'       => $img,
            'type'        => 'website',
        );
    }
    if (is_singular('post')) {
        $id = get_the_ID();
        $excerpt = wp_strip_all_tags(get_the_excerpt($id) ?: wp_trim_words(wp_strip_all_tags(get_post_field('post_content', $id)), 28));
        return array(
            'title'       => get_the_title($id) . ' | ' . $brand,
            'description' => $excerpt ?: ('Destination wedding guidance from an Udaipur wedding planner — ' . get_the_title($id)),
            'image'       => get_the_post_thumbnail_url($id, 'full') ?: $img,
            'type'        => 'article',
        );
    }
    if (is_singular('portfolio')) {
        $id = get_the_ID();
        return array(
            'title'       => get_the_title($id) . ' — Destination Wedding in Udaipur',
            'description' => wp_strip_all_tags(get_the_excerpt($id) ?: (get_the_title($id) . ' — a destination wedding planned by Wedding Vows by Nikhil in Udaipur.')),
            'image'       => get_the_post_thumbnail_url($id, 'full') ?: $img,
            'type'        => 'article',
        );
    }
    if (is_singular()) {
        $id = get_the_ID();
        return array(
            'title'       => get_the_title($id) . ' | ' . $brand,
            'description' => wp_strip_all_tags(get_the_excerpt($id) ?: get_bloginfo('description')),
            'image'       => get_the_post_thumbnail_url($id, 'full') ?: $img,
            'type'        => 'website',
        );
    }
    return array(
        'title'       => get_bloginfo('name') . ' | Destination Wedding Planner in Udaipur',
        'description' => get_bloginfo('description') ?: 'Destination wedding planner in Udaipur.',
        'image'       => $img,
        'type'        => 'website',
    );
}

function wvn_is_udaipur_guide() {
    return is_page('weddings-in-udaipur') || is_page_template('page-weddings-udaipur.php');
}

function wvn_udaipur_guide_venues() {
    return array(
        array(
            'label' => 'Heritage palaces',
            'items' => array(
                array('name' => 'Taj Lake Palace', 'note' => 'Island palace on Lake Pichola — intimate ceremonies and a full lake arrival.'),
                array('name' => 'Jagmandir Island Palace', 'note' => 'Heritage island setting for pheras and evening functions on the water.'),
                array('name' => 'The Leela Palace Udaipur', 'note' => 'Lakeside palace hotel with ceremony lawns and a strong room block for destination guests.'),
                array('name' => 'Taj Fateh Prakash Palace', 'note' => 'City-palace heritage rooms and courtyards for a classic Udaipur wedding.'),
                array('name' => 'The Oberoi Udaivilas', 'note' => 'Luxury palace-hotel campus when the guest list needs rooms, lawns and quiet hospitality together.'),
            ),
        ),
        array(
            'label' => 'Hilltop & luxury resorts',
            'items' => array(
                array('name' => 'The Ananta Udaipur', 'note' => 'Hilltop resort campus — popular for 150–200 guests who want every function on one property.'),
                array('name' => 'Fairmont Udaipur Palace', 'note' => 'Palace-style resort above the city for large destination weddings and produced sangeets.'),
                array('name' => 'Raffles Udaipur', 'note' => 'Island resort luxury when the celebration should feel private and highly designed.'),
                array('name' => 'Aurika Udaipur', 'note' => 'Contemporary luxury rooms and event spaces in the Fatehpura belt.'),
                array('name' => 'ITC Mementos Udaipur', 'note' => 'Resort-scale hospitality for families who want a full destination campus.'),
            ),
        ),
        array(
            'label' => 'Boutique heritage',
            'items' => array(
                array('name' => 'Chunda Palace', 'note' => 'Heritage courtyards for a warmer, more intimate Udaipur wedding.'),
                array('name' => 'Fateh Garh Palace', 'note' => 'Hilltop heritage stay — strong for smaller guest lists and sunset views.'),
                array('name' => 'The Lalit Laxmi Vilas Palace', 'note' => 'Palace architecture with lawns that still work for a mid-size destination wedding.'),
            ),
        ),
    );
}

function wvn_udaipur_guide_costs() {
    return array(
        array('item' => 'Venue & accommodation (2 days, 150–200 guests)', 'range' => '₹50 lakhs – ₹3+ crores'),
        array('item' => 'Catering (per day)', 'range' => '₹15 lakhs – ₹30 lakhs'),
        array('item' => 'Décor, lighting & production', 'range' => '₹8 lakhs – ₹45 lakhs'),
        array('item' => 'Photography & films', 'range' => '₹4 lakhs – ₹15 lakhs'),
        array('item' => 'Planning, coordination & on-ground team', 'range' => 'Studio fee, scoped to the wedding'),
    );
}

function wvn_udaipur_guide_faqs() {
    return array(
        array(
            'q' => 'What is the average cost of getting married in Udaipur?',
            'a' => 'A 2-day destination wedding for 150 to 200 guests in Udaipur typically ranges from ₹50 lakhs to ₹3+ crores. Venue and rooms are the largest line. Catering, décor and a produced sangeet move the total as much as the hotel name. Boutique heritage weddings sit lower; palace buyouts sit higher.',
        ),
        array(
            'q' => 'Why is Udaipur famous for weddings?',
            'a' => 'Udaipur combines lake palaces, heritage courtyards and luxury resorts in a compact city. Guests can fly in, stay on campus, and move between mehendi, sangeet and pheras without long transfers. The setting is the photograph; the campus is why destination families choose it.',
        ),
        array(
            'q' => 'Which are the best wedding venues in Udaipur?',
            'a' => 'Couples most often compare Taj Lake Palace, Jagmandir Island Palace, The Leela Palace Udaipur, The Ananta, Fairmont Udaipur Palace, Raffles Udaipur, Chunda Palace and Fateh Garh. The best venue is the one that fits your guest count, room block and rituals — not only the most photographed façade.',
        ),
        array(
            'q' => 'How far in advance should I book a wedding in Udaipur?',
            'a' => 'Peak palace dates fill eight to twelve months ahead. If you need 80 or more rooms in October–February, start as soon as the season is decided. Artists and décor can follow once the venue is held.',
        ),
        array(
            'q' => 'Do I need a local wedding planner in Udaipur?',
            'a' => 'A destination wedding in Udaipur is a small city for a few days: transfers, room blocks, hotel contracts, lighting, and minute-by-minute schedules. A local studio already knows which lawns hold pheras and what the package does not include. Wedding Vows by Nikhil plans and executes from Udaipur.',
        ),
    );
}

function wvn_seo_title_parts($parts) {
    $seo = wvn_seo_current();
    if (!empty($seo['title'])) {
        return array('title' => $seo['title']);
    }
    return $parts;
}
add_filter('document_title_parts', 'wvn_seo_title_parts', 40);

function wvn_seo_wpseo_title($title) {
    $seo = wvn_seo_current();
    return !empty($seo['title']) ? $seo['title'] : $title;
}
add_filter('wpseo_title', 'wvn_seo_wpseo_title', 40);
add_filter('wpseo_opengraph_title', 'wvn_seo_wpseo_title', 40);
add_filter('wpseo_twitter_title', 'wvn_seo_wpseo_title', 40);

function wvn_seo_wpseo_desc($desc) {
    $seo = wvn_seo_current();
    return !empty($seo['description']) ? $seo['description'] : $desc;
}
add_filter('wpseo_metadesc', 'wvn_seo_wpseo_desc', 40);
add_filter('wpseo_opengraph_desc', 'wvn_seo_wpseo_desc', 40);
add_filter('wpseo_twitter_description', 'wvn_seo_wpseo_desc', 40);

function wvn_seo_wpseo_image($img) {
    $seo = wvn_seo_current();
    return !empty($seo['image']) ? $seo['image'] : $img;
}
add_filter('wpseo_opengraph_image', 'wvn_seo_wpseo_image', 40);
add_filter('wpseo_twitter_image', 'wvn_seo_wpseo_image', 40);

function wvn_seo_language_attributes($output) {
    if (is_admin()) {
        return $output;
    }
    return 'lang="en-IN" prefix="og: https://ogp.me/ns#"';
}
add_filter('language_attributes', 'wvn_seo_language_attributes');

function wvn_seo_head() {
    $seo = wvn_seo_current();
    $url = wp_get_canonical_url() ?: home_url(add_query_arg(array(), $GLOBALS['wp']->request));
    $url = trailingslashit(esc_url($url));
    $title = esc_attr($seo['title']);
    $desc = esc_attr($seo['description']);
    $image = esc_url($seo['image']);
    $type = esc_attr($seo['type']);
    $profile = wvn_seo_profile();

    if (!defined('WPSEO_VERSION')) {
        echo '<meta name="description" content="' . $desc . '">' . "\n";
        echo '<link rel="canonical" href="' . esc_url($url) . '">' . "\n";
        echo '<meta property="og:title" content="' . $title . '">' . "\n";
        echo '<meta property="og:description" content="' . $desc . '">' . "\n";
        echo '<meta property="og:url" content="' . esc_url($url) . '">' . "\n";
        echo '<meta property="og:image" content="' . $image . '">' . "\n";
        echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
        echo '<meta name="twitter:title" content="' . $title . '">' . "\n";
        echo '<meta name="twitter:description" content="' . $desc . '">' . "\n";
        echo '<meta name="twitter:image" content="' . $image . '">' . "\n";
    }

    echo '<meta property="og:type" content="' . $type . '">' . "\n";
    echo '<meta property="og:locale" content="en_IN">' . "\n";
    echo '<meta property="og:site_name" content="' . esc_attr($profile['name']) . '">' . "\n";
    echo '<meta name="geo.region" content="IN-RJ">' . "\n";
    echo '<meta name="geo.placename" content="Udaipur">' . "\n";
    echo '<meta name="geo.position" content="' . esc_attr($profile['lat'] . ';' . $profile['lng']) . '">' . "\n";
    echo '<meta name="ICBM" content="' . esc_attr($profile['lat'] . ', ' . $profile['lng']) . '">' . "\n";
    echo '<meta name="theme-color" content="#6b3e3e">' . "\n";
    echo '<link rel="alternate" hreflang="en-IN" href="' . esc_url($url) . '">' . "\n";
    echo '<link rel="alternate" hreflang="x-default" href="' . esc_url($url) . '">' . "\n";
}
add_action('wp_head', 'wvn_seo_head', 5);

function wvn_seo_json_ld() {
    $p = wvn_seo_profile();
    $seo = wvn_seo_current();
    $page_url = wp_get_canonical_url() ?: home_url('/');
    $org_id = trailingslashit($p['url']) . '#organization';
    $site_id = trailingslashit($p['url']) . '#website';

    $graph = array();

    $graph[] = array(
        '@type' => array('LocalBusiness', 'ProfessionalService'),
        '@id'   => $org_id,
        'name'  => $p['name'],
        'url'   => $p['url'],
        'logo'  => $p['logo'],
        'image' => $p['image'],
        'email' => $p['email'],
        'description' => $p['description'],
        'foundingDate' => '2017',
        'founder' => array(
            '@type' => 'Person',
            'name'  => $p['founder'],
            'jobTitle' => 'Founder & destination wedding planner',
        ),
        'address' => array(
            '@type'           => 'PostalAddress',
            'streetAddress'   => $p['street'],
            'addressLocality' => $p['city'],
            'addressRegion'   => $p['region'],
            'postalCode'      => $p['postal'],
            'addressCountry'  => $p['country'],
        ),
        'geo' => array(
            '@type'     => 'GeoCoordinates',
            'latitude'  => $p['lat'],
            'longitude' => $p['lng'],
        ),
        'areaServed' => array_map(function ($place) {
            return array('@type' => 'City', 'name' => $place);
        }, $p['area']),
        'priceRange' => '₹₹₹',
        'sameAs' => $p['same_as'],
        'knowsAbout' => array(
            'Destination wedding in Udaipur',
            'Palace wedding Udaipur',
            'Lakeside wedding Udaipur',
            'Destination wedding planner India',
        ),
        'hasOfferCatalog' => array(
            '@type' => 'OfferCatalog',
            'name'  => 'Destination wedding services',
            'itemListElement' => array(
                array('@type' => 'Offer', 'itemOffered' => array('@type' => 'Service', 'name' => 'Destination wedding planning in Udaipur')),
                array('@type' => 'Offer', 'itemOffered' => array('@type' => 'Service', 'name' => 'Palace and venue sourcing')),
                array('@type' => 'Offer', 'itemOffered' => array('@type' => 'Service', 'name' => 'Wedding décor and design')),
                array('@type' => 'Offer', 'itemOffered' => array('@type' => 'Service', 'name' => 'Guest hospitality and logistics')),
            ),
        ),
    );

    $graph[] = array(
        '@type' => 'WebSite',
        '@id'   => $site_id,
        'url'   => $p['url'],
        'name'  => $p['name'],
        'publisher' => array('@id' => $org_id),
        'inLanguage' => 'en-IN',
        'potentialAction' => array(
            '@type' => 'SearchAction',
            'target' => home_url('/?s={search_term_string}'),
            'query-input' => 'required name=search_term_string',
        ),
    );

    $crumbs = array(
        array('name' => 'Home', 'url' => home_url('/')),
    );
    if (is_front_page()) {
        // home only
    } elseif (is_page('what-we-do') || is_page_template('page-what-we-do.php')) {
        $crumbs[] = array('name' => 'Wedding services', 'url' => $page_url);
    } elseif (wvn_is_udaipur_guide()) {
        $crumbs[] = array('name' => 'Weddings in Udaipur', 'url' => $page_url);
    } elseif (is_post_type_archive('portfolio') || is_singular('portfolio')) {
        $crumbs[] = array('name' => 'Real weddings', 'url' => home_url('/portfolio/'));
        if (is_singular('portfolio')) {
            $crumbs[] = array('name' => get_the_title(), 'url' => $page_url);
        }
    } elseif (is_home() || is_category() || is_singular('post')) {
        $blog = get_permalink((int) get_option('page_for_posts')) ?: home_url('/blog/');
        $crumbs[] = array('name' => 'Journal', 'url' => $blog);
        if (is_category()) {
            $cat = get_queried_object();
            $crumbs[] = array('name' => $cat->name, 'url' => $page_url);
        } elseif (is_singular('post')) {
            $crumbs[] = array('name' => get_the_title(), 'url' => $page_url);
        }
    } elseif (is_singular()) {
        $crumbs[] = array('name' => get_the_title(), 'url' => $page_url);
    }

    $crumb_items = array();
    foreach ($crumbs as $i => $crumb) {
        $crumb_items[] = array(
            '@type'    => 'ListItem',
            'position' => $i + 1,
            'name'     => $crumb['name'],
            'item'     => $crumb['url'],
        );
    }
    $graph[] = array(
        '@type'           => 'BreadcrumbList',
        'itemListElement' => $crumb_items,
    );

    $faq_source = array();
    if (wvn_is_udaipur_guide()) {
        $faq_source = wvn_udaipur_guide_faqs();
        $list_items = array();
        $position = 1;
        foreach (wvn_udaipur_guide_venues() as $group) {
            foreach ($group['items'] as $venue) {
                $list_items[] = array(
                    '@type'    => 'ListItem',
                    'position' => $position,
                    'name'     => $venue['name'],
                    'description' => $venue['note'],
                );
                $position++;
            }
        }
        if ($list_items) {
            $graph[] = array(
                '@type'           => 'ItemList',
                'name'            => 'Top wedding venues in Udaipur',
                'itemListElement' => $list_items,
            );
        }
    } elseif (is_front_page() && function_exists('wvn_faqs')) {
        $faq_source = wvn_faqs();
    }
    if ($faq_source) {
        $entities = array();
        foreach ($faq_source as $faq) {
            if (empty($faq['q'])) {
                continue;
            }
            $entities[] = array(
                '@type' => 'Question',
                'name'  => $faq['q'],
                'acceptedAnswer' => array(
                    '@type' => 'Answer',
                    'text'  => $faq['a'] ?? '',
                ),
            );
        }
        if ($entities) {
            $graph[] = array(
                '@type'      => 'FAQPage',
                'mainEntity' => $entities,
            );
        }
    }

    if (is_singular('post')) {
        $graph[] = array(
            '@type' => 'Article',
            'headline' => get_the_title(),
            'datePublished' => get_the_date('c'),
            'dateModified' => get_the_modified_date('c'),
            'author' => array('@type' => 'Person', 'name' => $p['founder']),
            'publisher' => array('@id' => $org_id),
            'image' => $seo['image'],
            'mainEntityOfPage' => $page_url,
            'description' => $seo['description'],
        );
    }

    $payload = array(
        '@context' => 'https://schema.org',
        '@graph'   => $graph,
    );
    echo '<script type="application/ld+json">' . wp_json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
}
add_action('wp_head', 'wvn_seo_json_ld', 30);

function wvn_seo_disable_yoast_schema($output) {
    return false;
}
add_filter('wpseo_json_ld_output', 'wvn_seo_disable_yoast_schema');
add_filter('wpseo_schema_graph', '__return_empty_array');

function wvn_seo_robots_meta($robots) {
    if (is_search() || is_404() || is_attachment()) {
        $robots['noindex'] = true;
        $robots['nofollow'] = true;
    }
    return $robots;
}
add_filter('wp_robots', 'wvn_seo_robots_meta');

function wvn_seo_query_vars($vars) {
    $vars[] = 'wvn_sitemap';
    return $vars;
}
add_filter('query_vars', 'wvn_seo_query_vars');

function wvn_seo_rewrite() {
    add_rewrite_rule('^wvn-sitemap\\.xml$', 'index.php?wvn_sitemap=1', 'top');
    if (get_option('_wvn_seo_rewrites') !== '1') {
        flush_rewrite_rules(false);
        update_option('_wvn_seo_rewrites', '1');
    }
}
add_action('init', 'wvn_seo_rewrite', 20);

function wvn_seo_sitemap_urls() {
    $urls = array(
        array('loc' => home_url('/'), 'priority' => '1.0', 'freq' => 'weekly'),
        array('loc' => home_url('/weddings-in-udaipur/'), 'priority' => '0.95', 'freq' => 'monthly'),
        array('loc' => home_url('/what-we-do/'), 'priority' => '0.9', 'freq' => 'monthly'),
        array('loc' => home_url('/portfolio/'), 'priority' => '0.9', 'freq' => 'weekly'),
        array('loc' => home_url('/contact-us/'), 'priority' => '0.8', 'freq' => 'monthly'),
    );
    $blog = get_permalink((int) get_option('page_for_posts'));
    if ($blog) {
        $urls[] = array('loc' => $blog, 'priority' => '0.8', 'freq' => 'weekly');
    }
    foreach (get_categories(array('hide_empty' => true)) as $cat) {
        $urls[] = array('loc' => get_category_link($cat), 'priority' => '0.6', 'freq' => 'weekly');
    }
    $posts = get_posts(array(
        'post_type'      => array('post', 'portfolio', 'page'),
        'post_status'    => 'publish',
        'posts_per_page' => 200,
        'orderby'        => 'modified',
        'order'          => 'DESC',
    ));
    $skip = array((int) get_option('page_on_front'), (int) get_option('page_for_posts'));
    foreach ($posts as $post) {
        if (in_array((int) $post->ID, $skip, true)) {
            continue;
        }
        $urls[] = array(
            'loc'      => get_permalink($post),
            'priority' => $post->post_type === 'page' ? '0.7' : '0.65',
            'freq'     => 'monthly',
            'lastmod'  => get_the_modified_date('c', $post),
        );
    }
    return $urls;
}

function wvn_seo_render_sitemap() {
    if ((string) get_query_var('wvn_sitemap') !== '1') {
        return;
    }
    $file = ABSPATH . 'wvn-sitemap.xml';
    nocache_headers();
    header('Content-Type: application/xml; charset=utf-8');
    if (is_readable($file)) {
        readfile($file);
        exit;
    }
    echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
    foreach (wvn_seo_sitemap_urls() as $item) {
        echo '  <url>';
        echo '<loc>' . esc_url($item['loc']) . '</loc>';
        if (!empty($item['lastmod'])) {
            echo '<lastmod>' . esc_html($item['lastmod']) . '</lastmod>';
        }
        echo '<changefreq>' . esc_html($item['freq']) . '</changefreq>';
        echo '<priority>' . esc_html($item['priority']) . '</priority>';
        echo "</url>\n";
    }
    echo '</urlset>';
    exit;
}
add_action('template_redirect', 'wvn_seo_render_sitemap', 0);

function wvn_seo_robots($output, $public) {
    if (!$public) {
        return "User-agent: *\nDisallow: /\n";
    }
    $sitemap = home_url('/wvn-sitemap.xml');
    $plain   = home_url('/sitemap.xml');
    return "# Wedding Vows by Nikhil\n"
        . "# Allow search engines to index public pages.\n\n"
        . "User-agent: Googlebot\nAllow: /\n\n"
        . "User-agent: Googlebot-Image\nAllow: /\n\n"
        . "User-agent: Bingbot\nAllow: /\n\n"
        . "User-agent: *\n"
        . "Allow: /\n"
        . "Disallow: /wp-admin/\n"
        . "Allow: /wp-admin/admin-ajax.php\n"
        . "Disallow: /wp-login.php\n"
        . "Disallow: /xmlrpc.php\n"
        . "Disallow: /readme.html\n"
        . "Disallow: /trackback/\n"
        . "Disallow: /feed/\n"
        . "Disallow: /*/feed$\n"
        . "Disallow: /?s=\n"
        . "Disallow: /search/\n"
        . "Disallow: /*?s=\n\n"
        . "Sitemap: {$sitemap}\n"
        . "Sitemap: {$plain}\n";
}
add_filter('robots_txt', 'wvn_seo_robots', 99, 2);

function wvn_seo_img_attrs($attr, $attachment, $size) {
    if (empty($attr['alt'])) {
        $attr['alt'] = get_the_title($attachment) ?: 'Destination wedding in Udaipur — Wedding Vows by Nikhil';
    }
    if (empty($attr['loading'])) {
        $attr['loading'] = 'lazy';
    }
    $attr['decoding'] = 'async';
    return $attr;
}
add_filter('wp_get_attachment_image_attributes', 'wvn_seo_img_attrs', 10, 3);

function wvn_seed_seo_meta() {
    if (get_option('_wvn_seo_meta_v1') || !function_exists('update_post_meta')) {
        return;
    }
    $map = array(
        (int) get_option('page_on_front') => array(
            'title' => 'Destination Wedding Planner in Udaipur | Wedding Vows by Nikhil',
            'desc'  => 'Plan a luxury destination wedding in Udaipur with Wedding Vows by Nikhil. Palace, lakeside and heritage celebrations across India — one team, end to end.',
            'kw'    => 'destination wedding planner Udaipur',
        ),
    );
    $services = get_page_by_path('what-we-do');
    if ($services) {
        $map[(int) $services->ID] = array(
            'title' => 'Destination Wedding Services in Udaipur | Venues, Décor & Planning',
            'desc'  => 'Full-service destination wedding planning in Udaipur: venues, décor, photography, hospitality and on-ground execution.',
            'kw'    => 'destination wedding services Udaipur',
        );
    }
    $contact = get_page_by_path('contact-us');
    if ($contact) {
        $map[(int) $contact->ID] = array(
            'title' => 'Book a Destination Wedding Planner in Udaipur | Contact',
            'desc'  => 'Talk to Nikhil Salvi about your destination wedding in Udaipur. Share your date, guest count and venue ideas.',
            'kw'    => 'wedding planner Udaipur contact',
        );
    }
    foreach ($map as $id => $meta) {
        if (!$id) {
            continue;
        }
        if (!get_post_meta($id, '_yoast_wpseo_title', true)) {
            update_post_meta($id, '_yoast_wpseo_title', $meta['title']);
        }
        if (!get_post_meta($id, '_yoast_wpseo_metadesc', true)) {
            update_post_meta($id, '_yoast_wpseo_metadesc', $meta['desc']);
        }
        if (!get_post_meta($id, '_yoast_wpseo_focuskw', true)) {
            update_post_meta($id, '_yoast_wpseo_focuskw', $meta['kw']);
        }
    }
    update_option('_wvn_seo_meta_v1', '1');
}
add_action('init', 'wvn_seed_seo_meta', 60);

function wvn_seed_seo_copy() {
    if (get_option('_wvn_seo_copy_v1') || !function_exists('update_field')) {
        return;
    }
    $home = (int) get_option('page_on_front');
    if ($home) {
        $intro = array(
            'home_intro_kicker'  => 'Destination wedding planner in Udaipur',
            'home_intro_heading' => 'Destination weddings in Udaipur, planned with quiet luxury.',
            'home_intro_text'    => 'Wedding Vows by Nikhil is an Udaipur-based destination wedding studio. We plan palace, lakeside and heritage weddings across Udaipur, Jaipur, Jodhpur and Goa — one team from the first venue walk to the last pheras.',
        );
        foreach ($intro as $name => $value) {
            update_field($name, $value, $home);
        }
    }
    $services = get_page_by_path('what-we-do');
    if ($services && function_exists('get_field')) {
        $rows = get_field('service_sections', $services->ID);
        if (is_array($rows) && isset($rows[0]['heading'])) {
            $rows[0]['heading'] = 'Destination wedding services in Udaipur';
            $rows[0]['text'] = 'Venues, décor, photography, hospitality and beauty for destination weddings in Udaipur and across India — designed and delivered by one trusted team.';
            $rows[0]['crumb'] = 'Home / Destination wedding services';
            update_field('service_sections', $rows, $services->ID);
        }
    }
    update_option('_wvn_seo_copy_v1', '1');
}
add_action('acf/init', 'wvn_seed_seo_copy', 80);

function wvn_seed_seo_posts() {
    if (get_option('_wvn_seo_posts_v1')) {
        return;
    }
    if (!function_exists('wvn_blog_ensure_categories')) {
        return;
    }
    wvn_blog_ensure_categories();
    require_once ABSPATH . 'wp-admin/includes/media.php';
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/image.php';

    $posts = array(
        array(
            'title'   => 'How to plan a destination wedding in Udaipur',
            'slug'    => 'how-to-plan-a-destination-wedding-in-udaipur',
            'cat'     => 'destinations',
            'excerpt' => 'A clear path to planning a destination wedding in Udaipur — venues, guest travel, timelines, and what a local planner actually handles.',
            'image'   => wvn_media('2025/04/NVP_JEHANAXKANISHK_WEDDING-1450.jpg'),
            'content' => '<p>A destination wedding in Udaipur is not a hotel booking with flowers. It is a four-day city that has to work for grandparents, cousins flying in from abroad, and a couple who still want the day to feel like theirs.</p>
<p>Start with the season and the guest count. Peak palace dates in Udaipur fill eight to twelve months ahead. Once those two numbers are honest, venue shortlists become simple: lakeside palaces, heritage courtyards, or a resort that can hold every function on one campus.</p>
<p>Then plan the guest journey. Airport transfers, room blocks, welcome dinners, and a quiet morning before pheras matter as much as the mandap. This is where a destination wedding planner in Udaipur earns the role — one team that already knows the venues, the artists, and how long a baraat actually takes on those roads.</p>
<p>Wedding Vows by Nikhil plans destination weddings in Udaipur end to end: venue, décor, hospitality, and the run of show. If you already have a palace, we still take over design and execution so the number you approve is the wedding you host.</p>
<p><a href="' . esc_url(home_url('/contact-us/')) . '">Book a consultation</a> if you are choosing between Udaipur, Jaipur, Jodhpur or Goa — we will tell you which city fits your guest list, not just which one photographs well.</p>',
        ),
        array(
            'title'   => 'Wedding planner in Udaipur: what we actually do',
            'slug'    => 'wedding-planner-in-udaipur-what-we-do',
            'cat'     => 'planning-tips',
            'excerpt' => 'What a wedding planner in Udaipur handles on a destination celebration — and why one local team is calmer than a dozen vendors.',
            'image'   => wvn_media('2025/04/2J0A1820-1200x800-1.jpg'),
            'content' => '<p>Couples search for a wedding planner in Udaipur when the venue is beautiful and the logistics are not. Palaces do not run themselves. Guest lists do not seat themselves. Lighting does not arrive because someone posted a reference image.</p>
<p>A local planner holds the venue relationship, the artist timeline, the décor lead time, and the people on the floor. Wedding Vows by Nikhil is based in Udaipur, so the same studio that walks the courtyard with you is the studio that stays until the last farewell.</p>
<p>We design the spaces, brief every vendor, and build minute-by-minute schedules for mehendi, sangeet, pheras and send-off. If you already love a photographer or a florist, we work with them. If you want us to curate the full team, we will.</p>
<p>Destination weddings in Udaipur, Jaipur, Jodhpur and Goa all follow the same idea: one team, so you are not managing a production. <a href="' . esc_url(home_url('/what-we-do/')) . '">See what we do</a>, then tell us about your day.</p>',
        ),
        array(
            'title'   => 'Palace wedding venues in Udaipur — how we help you choose',
            'slug'    => 'palace-wedding-venues-in-udaipur',
            'cat'     => 'destinations',
            'excerpt' => 'How to choose a palace wedding venue in Udaipur: guest count, ceremony lawns, room blocks, and what the hotel package does not include.',
            'image'   => wvn_media('2025/04/2J0A7886-1200x800-1.jpg'),
            'content' => '<p>Udaipur’s palace wedding venues are famous for a reason. Lake arrivals, courtyards that hold a pheras, and rooms on campus so grandparents are not in traffic. The mistake is choosing the photograph before the guest count.</p>
<p>We walk couples through what each palace can actually host: ceremony lawns, sangeet indoor options, and how many rooms you must block in season. The Leela Palace, Oberoi Udaivilas, and heritage properties each behave differently once 80 families arrive.</p>
<p>A destination wedding planner in Udaipur also reads the contract. Lighting, mandap, hospitality desks, and late-night sound are often outside the hotel package. Those lines are where budgets surprise families — unless they are written down early.</p>
<p>If you are comparing palace wedding venues in Udaipur, start with dates and headcount, then walk the sites. <a href="' . esc_url(home_url('/contact-us/')) . '">Write to us</a> and we will tell you which courtyards fit your rituals, not only which ones trend this year.</p>',
        ),
    );

    foreach ($posts as $sample) {
        if (get_page_by_path($sample['slug'], OBJECT, 'post')) {
            continue;
        }
        $post_id = wp_insert_post(array(
            'post_title'   => $sample['title'],
            'post_name'    => $sample['slug'],
            'post_excerpt' => $sample['excerpt'],
            'post_content' => $sample['content'],
            'post_status'  => 'publish',
            'post_type'    => 'post',
        ));
        if (!$post_id || is_wp_error($post_id)) {
            continue;
        }
        wp_set_object_terms($post_id, $sample['cat'], 'category');
        update_post_meta($post_id, '_yoast_wpseo_title', $sample['title'] . ' | Wedding Vows by Nikhil');
        update_post_meta($post_id, '_yoast_wpseo_metadesc', $sample['excerpt']);
        $image_id = media_sideload_image($sample['image'], $post_id, $sample['title'], 'id');
        if (!is_wp_error($image_id) && $image_id) {
            set_post_thumbnail($post_id, (int) $image_id);
        }
    }
    update_option('_wvn_seo_posts_v1', '1');
}
add_action('init', 'wvn_seed_seo_posts', 70);

function wvn_seed_udaipur_guide_page() {
    if (get_option('_wvn_udaipur_guide_v1')) {
        return;
    }
    $page = get_page_by_path('weddings-in-udaipur');
    if (!$page) {
        $id = wp_insert_post(array(
            'post_title'   => 'Weddings in Udaipur',
            'post_name'    => 'weddings-in-udaipur',
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'post_content' => '',
            'post_excerpt' => 'Hosting a 2-day wedding for 150 to 200 guests in Udaipur typically ranges from ₹50 lakhs to ₹3+ crores. Palace, resort and boutique venues, with a local planner’s cost breakdown.',
        ));
        $page = $id && !is_wp_error($id) ? get_post($id) : null;
    }
    if ($page) {
        update_post_meta($page->ID, '_wp_page_template', 'page-weddings-udaipur.php');
        update_post_meta($page->ID, '_yoast_wpseo_title', 'Weddings in Udaipur: Venues, Costs & Planning | Wedding Vows by Nikhil');
        update_post_meta($page->ID, '_yoast_wpseo_metadesc', 'Hosting a 2-day wedding for 150 to 200 guests in Udaipur typically ranges from ₹50 lakhs to ₹3+ crores. Palace, resort and boutique venues — plus a local planner’s cost breakdown.');
        update_post_meta($page->ID, '_yoast_wpseo_focuskw', 'weddings in udaipur');
    }
    update_option('_wvn_udaipur_guide_v1', '1');
}
add_action('init', 'wvn_seed_udaipur_guide_page', 75);
