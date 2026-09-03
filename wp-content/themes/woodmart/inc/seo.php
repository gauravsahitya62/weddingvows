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
        return array('title' => 'Destination Wedding Planner in Udaipur | ' . $brand, 'description' => 'Plan a luxury destination wedding in Udaipur with Wedding Vows by Nikhil. Palace, lakeside and heritage celebrations across Udaipur, Jaipur, Jodhpur and Goa — one team, end to end.', 'image' => $img, 'type' => 'website');
    }
    if (is_page('what-we-do') || is_page_template('page-what-we-do.php')) {
        return array('title' => 'Destination Wedding Services in Udaipur | Venues, Décor & Planning', 'description' => 'Full-service destination wedding planning in Udaipur: venue sourcing, décor and design, photography, hospitality and on-ground execution by one studio.', 'image' => $img, 'type' => 'website');
    }
    if (is_page('contact-us')) {
        return array('title' => 'Book a Destination Wedding Planner in Udaipur | Contact', 'description' => 'Talk to Nikhil Salvi about your destination wedding in Udaipur. Share your date, guest count and venue ideas — we will reply with a clear next step.', 'image' => $img, 'type' => 'website');
    }
    if (wvn_is_udaipur_guide()) {
        return array('title' => 'Weddings in Udaipur: Venues, Costs & Planning | ' . $brand, 'description' => 'Hosting a 2-day wedding for 150 to 200 guests in Udaipur typically ranges from ₹50 lakhs to ₹3+ crores. Palace, resort and boutique venues — plus a local planner’s cost breakdown.', 'image' => $img, 'type' => 'website');
    }
    if (is_post_type_archive('portfolio') || is_page('portfolio')) {
        return array('title' => 'Real Destination Weddings in Udaipur | Wedding Gallery', 'description' => 'A gallery of destination weddings planned in Udaipur and across India — palace ceremonies, lakeside vows, and celebrations designed by Wedding Vows by Nikhil.', 'image' => $img, 'type' => 'website');
    }
    if (is_home()) {
        return array('title' => 'Destination Wedding Journal | Planning Tips from Udaipur', 'description' => 'Notes from an Udaipur destination wedding studio: palace venues, timelines, décor, costs, and real celebrations across India.', 'image' => $img, 'type' => 'website');
    }
    if (is_category()) {
        $cat = get_queried_object(); $name = $cat && !empty($cat->name) ? $cat->name : 'Journal';
        return array('title' => $name . ' — Destination Wedding Stories | ' . $brand, 'description' => 'Read ' . strtolower($name) . ' from Wedding Vows by Nikhil, a destination wedding planner in Udaipur.', 'image' => $img, 'type' => 'website');
    }
    if (is_singular('post')) {
        $id = get_the_ID(); $excerpt = wp_strip_all_tags(get_the_excerpt($id) ?: wp_trim_words(wp_strip_all_tags(get_post_field('post_content', $id)), 28));
        return array('title' => get_the_title($id) . ' | ' . $brand, 'description' => $excerpt ?: ('Destination wedding guidance from an Udaipur wedding planner — ' . get_the_title($id)), 'image' => get_the_post_thumbnail_url($id, 'full') ?: $img, 'type' => 'article');
    }
    if (is_singular('portfolio')) {
        $id = get_the_ID(); return array('title' => get_the_title($id) . ' — Destination Wedding in Udaipur', 'description' => wp_strip_all_tags(get_the_excerpt($id) ?: (get_the_title($id) . ' — a destination wedding planned by Wedding Vows by Nikhil in Udaipur.')), 'image' => get_the_post_thumbnail_url($id, 'full') ?: $img, 'type' => 'article');
    }
    if (is_singular()) {
        $id = get_the_ID(); return array('title' => get_the_title($id) . ' | ' . $brand, 'description' => wp_strip_all_tags(get_the_excerpt($id) ?: get_bloginfo('description')), 'image' => get_the_post_thumbnail_url($id, 'full') ?: $img, 'type' => 'website');
    }
    return array('title' => get_bloginfo('name') . ' | Destination Wedding Planner in Udaipur', 'description' => get_bloginfo('description') ?: 'Destination wedding planner in Udaipur.', 'image' => $img, 'type' => 'website');
}

function wvn_is_udaipur_guide() { return is_page('weddings-in-udaipur') || is_page_template('page-weddings-udaipur.php'); }

function wvn_udaipur_guide_venues() {
    return array(
        array('label' => 'Heritage palaces', 'items' => array(
            array('name' => 'Taj Lake Palace', 'note' => 'Island palace on Lake Pichola — intimate ceremonies and a full lake arrival.'),
            array('name' => 'Jagmandir Island Palace', 'note' => 'Heritage island setting for pheras and evening functions on the water.'),
            array('name' => 'The Leela Palace Udaipur', 'note' => 'Lakeside palace hotel with ceremony lawns and a strong room block for destination guests.'),
            array('name' => 'Taj Fateh Prakash Palace', 'note' => 'City-palace heritage rooms and courtyards for a classic Udaipur wedding.'),
            array('name' => 'The Oberoi Udaivilas', 'note' => 'Luxury palace-hotel campus when the guest list needs rooms, lawns and quiet hospitality together.'),
        )),
        array('label' => 'Hilltop & luxury resorts', 'items' => array(
            array('name' => 'The Ananta Udaipur', 'note' => 'Hilltop resort campus — popular for 150–200 guests who want every function on one property.'),
            array('name' => 'Fairmont Udaipur Palace', 'note' => 'Palace-style resort above the city for large destination weddings and produced sangeets.'),
            array('name' => 'Raffles Udaipur', 'note' => 'Island resort luxury when the celebration should feel private and highly designed.'),
            array('name' => 'Aurika Udaipur', 'note' => 'Contemporary luxury rooms and event spaces in the Fatehpura belt.'),
            array('name' => 'ITC Mementos Udaipur', 'note' => 'Resort-scale hospitality for families who want a full destination campus.'),
        )),
        array('label' => 'Boutique heritage', 'items' => array(
            array('name' => 'Chunda Palace', 'note' => 'Heritage courtyards for a warmer, more intimate Udaipur wedding.'),
            array('name' => 'Fateh Garh Palace', 'note' => 'Hilltop heritage stay — strong for smaller guest lists and sunset views.'),
            array('name' => 'The Lalit Laxmi Vilas Palace', 'note' => 'Palace architecture with lawns that still work for a mid-size destination wedding.'),
        )),
    );
}

function wvn_udaipur_guide_costs() { return array(array('item' => 'Venue & accommodation (2 days, 150–200 guests)', 'range' => '₹50 lakhs – ₹3+ crores'), array('item' => 'Catering (per day)', 'range' => '₹15 lakhs – ₹30 lakhs'), array('item' => 'Décor, lighting & production', 'range' => '₹8 lakhs – ₹45 lakhs'), array('item' => 'Photography & films', 'range' => '₹4 lakhs – ₹15 lakhs'), array('item' => 'Planning, coordination & on-ground team', 'range' => 'Studio fee, scoped to the wedding')); }
function wvn_udaipur_guide_faqs() { return array(array('q' => 'What is the average cost of getting married in Udaipur?', 'a' => 'A 2-day destination wedding for 150 to 200 guests in Udaipur typically ranges from ₹50 lakhs to ₹3+ crores. Venue and rooms are the largest line. Catering, décor and a produced sangeet move the total as much as the hotel name. Boutique heritage weddings sit lower; palace buyouts sit higher.'), array('q' => 'Why is Udaipur famous for weddings?', 'a' => 'Udaipur combines lake palaces, heritage courtyards and luxury resorts in a compact city. Guests can fly in, stay on campus, and move between mehendi, sangeet and pheras without long transfers. The setting is the photograph; the campus is why destination families choose it.'), array('q' => 'Which are the best wedding venues in Udaipur?', 'a' => 'Couples most often compare Taj Lake Palace, Jagmandir Island Palace, The Leela Palace Udaipur, The Ananta, Fairmont Udaipur Palace, Raffles Udaipur, Chunda Palace and Fateh Garh. The best venue is the one that fits your guest count, room block and rituals — not only the most photographed façade.'), array('q' => 'How far in advance should I book a wedding in Udaipur?', 'a' => 'Peak palace dates fill eight to twelve months ahead. If you need 80 or more rooms in October–February, start as soon as the season is decided. Artists and décor can follow once the venue is held.'), array('q' => 'Do I need a local wedding planner in Udaipur?', 'a' => 'A destination wedding in Udaipur is a small city for a few days: transfers, room blocks, hotel contracts, lighting, and minute-by-minute schedules. A local studio already knows which lawns hold pheras and what the package does not include. Wedding Vows by Nikhil plans and executes from Udaipur.')); }

function wvn_seo_title_parts($parts) { $seo = wvn_seo_current(); return !empty($seo['title']) ? array('title' => $seo['title']) : $parts; }
add_filter('document_title_parts', 'wvn_seo_title_parts', 40);
function wvn_seo_wpseo_title($title) { $seo = wvn_seo_current(); return !empty($seo['title']) ? $seo['title'] : $title; }
add_filter('wpseo_title', 'wvn_seo_wpseo_title', 40); add_filter('wpseo_opengraph_title', 'wvn_seo_wpseo_title', 40); add_filter('wpseo_twitter_title', 'wvn_seo_wpseo_title', 40);
function wvn_seo_wpseo_desc($desc) { $seo = wvn_seo_current(); return !empty($seo['description']) ? $seo['description'] : $desc; }
add_filter('wpseo_metadesc', 'wvn_seo_wpseo_desc', 40); add_filter('wpseo_opengraph_desc', 'wvn_seo_wpseo_desc', 40); add_filter('wpseo_twitter_description', 'wvn_seo_wpseo_desc', 40);
function wvn_seo_wpseo_image($img) { $seo = wvn_seo_current(); return !empty($seo['image']) ? $seo['image'] : $img; }
add_filter('wpseo_opengraph_image', 'wvn_seo_wpseo_image', 40); add_filter('wpseo_twitter_image', 'wvn_seo_wpseo_image', 40);
function wvn_seo_language_attributes($output) { return is_admin() ? $output : 'lang="en-IN" prefix="og: https://ogp.me/ns#"'; }
add_filter('language_attributes', 'wvn_seo_language_attributes');
function wvn_seo_head() {
    $seo = apply_filters('wvn_seo_current', wvn_seo_current()); $url = trailingslashit(esc_url(wp_get_canonical_url() ?: home_url('/'))); $title = esc_attr($seo['title']); $desc = esc_attr($seo['description']); $image = esc_url($seo['image']); $type = esc_attr($seo['type']); $profile = wvn_seo_profile();
    if (!defined('WPSEO_VERSION')) { echo '<meta name="description" content="' . $desc . '">' . "\n"; echo '<link rel="canonical" href="' . esc_url($url) . '">' . "\n"; echo '<meta property="og:title" content="' . $title . '">' . "\n"; echo '<meta property="og:description" content="' . $desc . '">' . "\n"; echo '<meta property="og:url" content="' . esc_url($url) . '">' . "\n"; echo '<meta property="og:image" content="' . $image . '">' . "\n"; echo '<meta name="twitter:card" content="summary_large_image">' . "\n"; echo '<meta name="twitter:title" content="' . $title . '">' . "\n"; echo '<meta name="twitter:description" content="' . $desc . '">' . "\n"; echo '<meta name="twitter:image" content="' . $image . '">' . "\n"; }
    echo '<meta property="og:type" content="' . $type . '">' . "\n"; echo '<meta property="og:locale" content="en_IN">' . "\n"; echo '<meta property="og:site_name" content="' . esc_attr($profile['name']) . '">' . "\n"; echo '<meta name="geo.region" content="IN-RJ">' . "\n"; echo '<meta name="geo.placename" content="Udaipur">' . "\n"; echo '<meta name="geo.position" content="' . esc_attr($profile['lat'] . ';' . $profile['lng']) . '">' . "\n"; echo '<meta name="ICBM" content="' . esc_attr($profile['lat'] . ', ' . $profile['lng']) . '">' . "\n"; echo '<meta name="theme-color" content="#6b3e3e">' . "\n"; echo '<link rel="alternate" hreflang="en-IN" href="' . esc_url($url) . '">' . "\n"; echo '<link rel="alternate" hreflang="x-default" href="' . esc_url($url) . '">' . "\n";
}
add_action('wp_head', 'wvn_seo_head', 5);
function wvn_seo_json_ld() {
    $p = wvn_seo_profile(); $seo = apply_filters('wvn_seo_current', wvn_seo_current()); $page_url = wp_get_canonical_url() ?: home_url('/'); $org_id = trailingslashit($p['url']) . '#organization'; $site_id = trailingslashit($p['url']) . '#website'; $graph = array();
    $graph[] = array('@type' => array('LocalBusiness', 'ProfessionalService'), '@id' => $org_id, 'name' => $p['name'], 'url' => $p['url'], 'logo' => $p['logo'], 'image' => $p['image'], 'email' => $p['email'], 'description' => $p['description'], 'foundingDate' => '2017', 'founder' => array('@type' => 'Person', 'name' => $p['founder'], 'jobTitle' => 'Founder & destination wedding planner'), 'address' => array('@type' => 'PostalAddress', 'streetAddress' => $p['street'], 'addressLocality' => $p['city'], 'addressRegion' => $p['region'], 'postalCode' => $p['postal'], 'addressCountry' => $p['country']), 'geo' => array('@type' => 'GeoCoordinates', 'latitude' => $p['lat'], 'longitude' => $p['lng']), 'areaServed' => array_map(function ($place) { return array('@type' => 'City', 'name' => $place); }, $p['area']), 'priceRange' => '₹₹₹', 'sameAs' => $p['same_as'], 'knowsAbout' => array('Destination wedding in Udaipur', 'Palace wedding Udaipur', 'Lakeside wedding Udaipur', 'Destination wedding planner India'), 'hasOfferCatalog' => array('@type' => 'OfferCatalog', 'name' => 'Destination wedding services', 'itemListElement' => array(array('@type' => 'Offer', 'itemOffered' => array('@type' => 'Service', 'name' => 'Destination wedding planning in Udaipur')), array('@type' => 'Offer', 'itemOffered' => array('@type' => 'Service', 'name' => 'Palace and venue sourcing')), array('@type' => 'Offer', 'itemOffered' => array('@type' => 'Service', 'name' => 'Wedding décor and design')), array('@type' => 'Offer', 'itemOffered' => array('@type' => 'Service', 'name' => 'Guest hospitality and logistics'))));
    $graph[] = array('@type' => 'WebSite', '@id' => $site_id, 'url' => $p['url'], 'name' => $p['name'], 'publisher' => array('@id' => $org_id), 'inLanguage' => 'en-IN', 'potentialAction' => array('@type' => 'SearchAction', 'target' => home_url('/?s={search_term_string}'), 'query-input' => 'required name=search_term_string'));
    $crumbs = array(array('name' => 'Home', 'url' => home_url('/')));
    if (is_front_page()) { } elseif (is_page('what-we-do') || is_page_template('page-what-we-do.php')) { $crumbs[] = array('name' => 'Wedding services', 'url' => $page_url); } elseif (wvn_is_udaipur_guide()) { $crumbs[] = array('name' => 'Weddings in Udaipur', 'url' => $page_url); } elseif (is_post_type_archive('portfolio') || is_singular('portfolio')) { $crumbs[] = array('name' => 'Real weddings', 'url' => home_url('/portfolio/')); if (is_singular('portfolio')) { $crumbs[] = array('name' => get_the_title(), 'url' => $page_url); } } elseif (is_home() || is_category() || is_singular('post')) { $blog = get_permalink((int) get_option('page_for_posts')) ?: home_url('/blog/'); $crumbs[] = array('name' => 'Journal', 'url' => $blog); if (is_category()) { $cat = get_queried_object(); $crumbs[] = array('name' => $cat->name, 'url' => $page_url); } elseif (is_singular('post')) { $crumbs[] = array('name' => get_the_title(), 'url' => $page_url); } } elseif (is_singular()) { $crumbs[] = array('name' => get_the_title(), 'url' => $page_url); }
    $crumb_items = array(); foreach ($crumbs as $i => $crumb) { $crumb_items[] = array('@type' => 'ListItem', 'position' => $i + 1, 'name' => $crumb['name'], 'item' => $crumb['url']); } $graph[] = array('@type' => 'BreadcrumbList', 'itemListElement' => $crumb_items);
    $faq_source = array(); if (wvn_is_udaipur_guide()) { $faq_source = wvn_udaipur_guide_faqs(); $list_items = array(); $position = 1; foreach (wvn_udaipur_guide_venues() as $group) { foreach ($group['items'] as $venue) { $list_items[] = array('@type' => 'ListItem', 'position' => $position, 'name' => $venue['name'], 'description' => $venue['note']); $position++; } } if ($list_items) { $graph[] = array('@type' => 'ItemList', 'name' => 'Top wedding venues in Udaipur', 'itemListElement' => $list_items); } } elseif (is_front_page() && function_exists('wvn_faqs')) { $faq_source = wvn_faqs(); }
    if ($faq_source) { $entities = array(); foreach ($faq_source as $faq) { if (empty($faq['q'])) { continue; } $entities[] = array('@type' => 'Question', 'name' => $faq['q'], 'acceptedAnswer' => array('@type' => 'Answer', 'text' => $faq['a'] ?? '')); } if ($entities) { $graph[] = array('@type' => 'FAQPage', 'mainEntity' => $entities); } }
    if (is_singular('post')) { $graph[] = array('@type' => 'Article', 'headline' => get_the_title(), 'datePublished' => get_the_date('c'), 'dateModified' => get_the_modified_date('c'), 'author' => array('@type' => 'Person', 'name' => $p['founder']), 'publisher' => array('@id' => $org_id), 'image' => $seo['image'], 'mainEntityOfPage' => $page_url, 'description' => $seo['description']); }
    echo '<script type="application/ld+json">' . wp_json_encode(array('@context' => 'https://schema.org', '@graph' => $graph), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
}
add_action('wp_head', 'wvn_seo_json_ld', 30);
function wvn_seo_disable_yoast_schema($output) { return false; }
add_filter('wpseo_json_ld_output', 'wvn_seo_disable_yoast_schema'); add_filter('wpseo_schema_graph', '__return_empty_array');
function wvn_seo_robots_meta($robots) { if (is_search() || is_404() || is_attachment() || is_author() || is_date() || is_tag() || is_paged()) { $robots['noindex'] = true; $robots['nofollow'] = true; } return $robots; }
add_filter('wp_robots', 'wvn_seo_robots_meta');
function wvn_seo_query_vars($vars) { $vars[] = 'wvn_sitemap'; return $vars; }
add_filter('query_vars', 'wvn_seo_query_vars');
function wvn_seo_rewrite() { add_rewrite_rule('^wvn-sitemap\\.xml$', 'index.php?wvn_sitemap=1', 'top'); if (get_option('_wvn_seo_rewrites') !== '1') { flush_rewrite_rules(false); update_option('_wvn_seo_rewrites', '1'); } }
add_action('init', 'wvn_seo_rewrite', 20);
function wvn_seo_sitemap_urls() { $urls = array(array('loc' => home_url('/'), 'priority' => '1.0', 'freq' => 'weekly'), array('loc' => home_url('/weddings-in-udaipur/'), 'priority' => '0.95', 'freq' => 'monthly'), array('loc' => home_url('/what-we-do/'), 'priority' => '0.9', 'freq' => 'monthly'), array('loc' => home_url('/portfolio/'), 'priority' => '0.9', 'freq' => 'weekly'), array('loc' => home_url('/contact-us/'), 'priority' => '0.8', 'freq' => 'monthly')); $blog = get_permalink((int) get_option('page_for_posts')); if ($blog) { $urls[] = array('loc' => $blog, 'priority' => '0.8', 'freq' => 'weekly'); } foreach (get_categories(array('hide_empty' => true)) as $cat) { $urls[] = array('loc' => get_category_link($cat), 'priority' => '0.6', 'freq' => 'weekly'); } $posts = get_posts(array('post_type' => array('post', 'portfolio', 'page'), 'post_status' => 'publish', 'posts_per_page' => 200, 'orderby' => 'modified', 'order' => 'DESC')); $skip = array((int) get_option('page_on_front'), (int) get_option('page_for_posts')); $seen = array(); foreach ($posts as $post) { if (in_array((int) $post->ID, $skip, true)) { continue; } $loc = get_permalink($post); if (!$loc) { continue; } $key = untrailingslashit($loc); if (isset($seen[$key])) { continue; } $seen[$key] = true; $urls[] = array('loc' => $loc, 'priority' => $post->post_type === 'page' ? '0.7' : '0.65', 'freq' => 'monthly', 'lastmod' => get_the_modified_date('c', $post)); } return $urls; }
function wvn_seo_render_sitemap() { if ((string) get_query_var('wvn_sitemap') !== '1') { return; } $file = ABSPATH . 'wvn-sitemap.xml'; nocache_headers(); header('Content-Type: application/xml; charset=utf-8'); if (is_readable($file)) { readfile($file); exit; } echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n"; foreach (wvn_seo_sitemap_urls() as $item) { echo '  <url><loc>' . esc_url($item['loc']) . '</loc>'; if (!empty($item['lastmod'])) { echo '<lastmod>' . esc_html($item['lastmod']) . '</lastmod>'; } echo '<changefreq>' . esc_html($item['freq']) . '</changefreq><priority>' . esc_html($item['priority']) . '</priority></url>' . "\n"; } echo '</urlset>'; exit; }
add_action('template_redirect', 'wvn_seo_render_sitemap', 0);
function wvn_seo_robots($output, $public) { if (!$public) { return "User-agent: *\nDisallow: /\n"; } $sitemap = home_url('/wvn-sitemap.xml'); return "# Wedding Vows by Nikhil\n# Allow search engines to index public pages.\n\nUser-agent: *\nAllow: /\nDisallow: /wp-admin/\nAllow: /wp-admin/admin-ajax.php\nDisallow: /wp-login.php\nDisallow: /xmlrpc.php\nDisallow: /readme.html\nDisallow: /trackback/\nDisallow: /feed/\nDisallow: /*/feed$\nDisallow: /search/\nDisallow: /*?s=\n\nSitemap: {$sitemap}\n"; }
add_filter('robots_txt', 'wvn_seo_robots', 99, 2);
function wvn_seo_img_attrs($attr, $attachment, $size) { if (empty($attr['alt'])) { $attr['alt'] = get_the_title($attachment) ?: 'Destination wedding in Udaipur — Wedding Vows by Nikhil'; } if (empty($attr['loading'])) { $attr['loading'] = 'lazy'; } $attr['decoding'] = 'async'; return $attr; }
add_filter('wp_get_attachment_image_attributes', 'wvn_seo_img_attrs', 10, 3);
