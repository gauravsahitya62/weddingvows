<?php

/* Theme Features */
function theme_features()
{
    add_theme_support('title-tag');
    add_theme_support('align-wide');
    add_theme_support('disable-custom-font-sizes');
    add_theme_support('disable-custom-colors');
    add_theme_support('disable-custom-gradients');
    add_theme_support('editor-styles');
    add_editor_style('css/editor.css');
    add_theme_support('post-thumbnails');
    add_theme_support('responsive-embeds');
    add_post_type_support('page', 'excerpt');
    register_nav_menu('menu-main', 'Main Menu');
    register_nav_menu('menu-utility', 'Utility Menu');
    register_nav_menu('menu-classes', 'Classes Menu');
}
add_action('after_setup_theme', 'theme_features');

$theme_inc_dir = 'inc';
$theme_includes = array(
    '/bts-data.php',
    '/acf-home.php',
    '/acf-portfolio.php',
    '/acf-services.php',
    '/acf-guide.php',
    '/blog.php',
    '/seo.php',
    '/custom-post-types.php',                   // Register Custom Post types & Taxonomies
    '/nav-walker.php',                          // Register Menu Walkers 
    '/enqueue.php',                             // Enqueue scripts and styles.
    '/widgets.php',                             // Contains the Widgets
    '/templates.php',                           // Contains the Templates
    '/patterns.php',                            // Contains Patterns
    '/theme-features.php',                      // Contains the Theme Features
    '/block-styles.php',                        // Contains the Updated Block Styles
);
foreach ($theme_includes as $file) {
    require_once get_theme_file_path($theme_inc_dir . $file);
}
// Register Standard Blocks
require_once get_theme_file_path($theme_inc_dir . '/acf-standard-blocks.php');
add_action('acf/init', 'hfm_acf_init_standard_blocks');

// Register Custom Blocks
require_once get_theme_file_path($theme_inc_dir . '/acf-custom-blocks.php');
add_action('acf/init', 'hfm_acf_init_custom_blocks');

@ini_set('upload_max_size', '256M');
@ini_set('post_max_size', '256M');
@ini_set('max_execution_time', '300');


add_filter('wpseo_breadcrumb_separator', function () {
    return '<i class="fa fa-chevron-right" aria-hidden="true"></i>'; // Replace with your preferred Font Awesome icon class
});

function register_menus() {
    register_nav_menus([
        'left-menu' => __('Left Menu'),
        'right-menu' => __('Right Menu')
    ]);
}

function create_wedding_portfolio_post_type() {
    register_post_type('portfolio', array(
        'labels' => array(
            'name'               => __('Portfolio'),
            'singular_name'      => __('Portfolio'),
            'menu_name'          => __('Portfolio'),
            'name_admin_bar'     => __('Portfolio'),
            'add_new'            => __('Add New'),
            'add_new_item'       => __('Add New Wedding'),
            'edit_item'          => __('Edit Wedding'),
            'new_item'           => __('New Wedding'),
            'view_item'          => __('View Wedding'),
            'search_items'       => __('Search Portfolio'),
            'not_found'          => __('No portfolio items found'),
            'not_found_in_trash' => __('No portfolio items found in Trash'),
            'all_items'          => __('All Portfolio'),
        ),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_nav_menus'  => true,
        'show_in_admin_bar'  => true,
        'show_in_rest'       => true,
        'has_archive'        => true,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-heart',
        'capability_type'    => 'post',
        'map_meta_cap'       => true,
        'rewrite'            => array('slug' => 'portfolio'),
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt'),
    ));

    if (get_option('_wvn_portfolio_cpt_v3') !== '1') {
        flush_rewrite_rules(false);
        update_option('_wvn_portfolio_cpt_v3', '1');
    }
}
add_action('init', 'create_wedding_portfolio_post_type', 5);

function wvn_seed_portfolio_posts() {
    if (get_option('_wvn_portfolio_seed_v1')) {
        return;
    }
    $existing = get_posts(array(
        'post_type'      => 'portfolio',
        'posts_per_page' => 1,
        'post_status'    => 'any',
        'fields'         => 'ids',
    ));
    if ($existing) {
        update_option('_wvn_portfolio_seed_v1', '1');
        return;
    }

    require_once ABSPATH . 'wp-admin/includes/media.php';
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/image.php';

    $samples = array(
        array('title' => 'Jehana & Kanishk', 'venue' => 'Udaipur, Rajasthan', 'image' => '2025/04/NVP_JEHANAXKANISHK_WEDDING-1450.jpg'),
        array('title' => 'A Royal Evening', 'venue' => 'Palace Courtyard, Udaipur', 'image' => '2025/04/2J0A7886-1200x800-1.jpg'),
        array('title' => 'Candlelit Vows', 'venue' => 'Heritage Venue, Udaipur', 'image' => '2025/04/2J0A1820-1200x800-1.jpg'),
        array('title' => 'Marigold Procession', 'venue' => 'Udaipur, Rajasthan', 'image' => '2025/04/2J0A1818.jpg'),
        array('title' => 'The First Look', 'venue' => 'Udaipur, Rajasthan', 'image' => '2025/04/2J0A0682.jpg'),
        array('title' => 'Guest Welcome', 'venue' => 'Udaipur, Rajasthan', 'image' => '2025/04/2J0A0986-534x800-1.jpg'),
        array('title' => 'Palace Vows', 'venue' => 'Udaipur, Rajasthan', 'image' => '2025/04/2J0A2532-533x800-1.jpg'),
    );

    foreach ($samples as $sample) {
        $post_id = wp_insert_post(array(
            'post_title'   => $sample['title'],
            'post_excerpt' => $sample['venue'],
            'post_content' => '',
            'post_status'  => 'publish',
            'post_type'    => 'portfolio',
        ));
        if (!$post_id || is_wp_error($post_id)) {
            continue;
        }
        $image_url = function_exists('wvn_media') ? wvn_media($sample['image']) : '';
        if ($image_url) {
            $image_id = media_sideload_image($image_url, $post_id, $sample['title'], 'id');
            if (!is_wp_error($image_id) && $image_id) {
                set_post_thumbnail($post_id, (int) $image_id);
            }
        }
    }
    update_option('_wvn_portfolio_seed_v1', '1');
}
add_action('init', 'wvn_seed_portfolio_posts', 30);

add_action('wp_ajax_nopriv_submit_quick_contact', 'submit_quick_contact_form');
add_action('wp_ajax_submit_quick_contact', 'submit_quick_contact_form');

function submit_quick_contact_form() {
    $name = sanitize_text_field($_POST['full_name'] ?? '');
    $phone = sanitize_text_field($_POST['phone'] ?? '');
    $email = sanitize_email($_POST['email'] ?? '');
    $note = sanitize_textarea_field($_POST['message'] ?? '');

    $to = 'weddingvowsbynikhil@gmail.com';
    $subject = 'New Contact Form Submission';
    $message = "Name: $name\nPhone: $phone\nEmail: $email";
    if ($note) {
        $message .= "\nMessage: $note";
    }
    $headers = ['Content-Type: text/plain; charset=UTF-8'];

    wp_mail($to, $subject, $message, $headers);

    echo 'success';
    wp_die();
}

/**
 * Keyword-led landing pages. These pages are created once if they do not
 * already exist, while existing editorial pages remain untouched.
 */
function wvn_seo_landing_config($slug = '') {
    $pages = array(
        'wedding-planner-udaipur' => array(
            'title' => 'Wedding Planner in Udaipur',
            'seo_title' => 'Wedding Planner in Udaipur | Wedding Vows by Nikhil',
            'description' => 'Looking for a wedding planner in Udaipur? Wedding Vows by Nikhil plans palace, lakeside and luxury destination weddings with one team from venue to farewell.',
            'intro' => 'A wedding planner in Udaipur who knows the venues, vendors, timelines and details that make a destination celebration feel effortless.',
            'image' => function_exists('wvn_hero_image') ? wvn_hero_image() : '',
            'highlights' => array(
                array('label' => 'Venue strategy', 'title' => 'Find the right Udaipur venue', 'text' => 'We help compare palace hotels, island venues, hilltop resorts and heritage properties around your guest count, room block, rituals and budget.'),
                array('label' => 'Design & production', 'title' => 'Make every function feel intentional', 'text' => 'From mehendi and haldi to sangeet and pheras, décor, lighting, sound and guest movement are planned as one experience.'),
                array('label' => 'On-ground execution', 'title' => 'One team stays through the wedding', 'text' => 'Hospitality, transport, vendor coordination, schedules and last-minute decisions are handled locally so families can stay present.'),
            ),
            'faqs' => array(
                array('q' => 'How much does a wedding planner in Udaipur cost?', 'a' => 'Planning fees depend on guest count, number of functions, venue complexity and the level of production. We scope the studio fee around the actual wedding rather than using a one-size-fits-all package.'),
                array('q' => 'How early should I hire a wedding planner in Udaipur?', 'a' => 'For peak October to February dates, 8 to 12 months is a strong starting point, especially when a large room block or a palace venue is involved.'),
                array('q' => 'Can you plan weddings outside Udaipur?', 'a' => 'Yes. Wedding Vows by Nikhil is based in Udaipur and plans destination celebrations across Rajasthan, Jaipur, Jodhpur and Goa.'),
            ),
        ),
        'destination-wedding-planner-udaipur' => array(
            'title' => 'Destination Wedding Planner in Udaipur',
            'seo_title' => 'Destination Wedding Planner in Udaipur | Wedding Vows by Nikhil',
            'description' => 'Luxury destination wedding planner in Udaipur for palace, lakeside and resort celebrations. Venue sourcing, design, hospitality and complete on-ground execution.',
            'intro' => 'Destination weddings need more than décor. They need a local team that can make the venue, guest journey and celebration work together.',
            'image' => function_exists('wvn_hero_image') ? wvn_hero_image() : '',
            'highlights' => array(
                array('label' => 'Destination expertise', 'title' => 'Udaipur from the inside', 'text' => 'We plan around Udaipur’s palace hotels, lake venues, resort campuses, transfer routes, room blocks and local production realities.'),
                array('label' => 'Guest experience', 'title' => 'Hospitality from arrival to departure', 'text' => 'Airport transfers, welcome moments, room drops, itineraries and guest communication are coordinated with the wedding schedule.'),
                array('label' => 'Complete planning', 'title' => 'A single point of responsibility', 'text' => 'Venue, design, entertainment, photography, catering coordination and production stay connected under one planning team.'),
            ),
            'faqs' => array(
                array('q' => 'What makes Udaipur good for a destination wedding?', 'a' => 'Udaipur combines lake palaces, heritage architecture and luxury resorts with a compact city footprint, making it possible to create a complete multi-day celebration without excessive guest travel.'),
                array('q' => 'Which venues can a destination wedding planner in Udaipur arrange?', 'a' => 'Depending on availability and guest count, couples can compare Taj Lake Palace, Jagmandir, The Leela Palace Udaipur, Oberoi Udaivilas, The Ananta, Fairmont, Raffles, Chunda Palace and other heritage and resort properties.'),
                array('q' => 'Do you manage guests as well as wedding vendors?', 'a' => 'Yes. Guest hospitality and vendor execution are planned together so arrivals, room blocks, transfers and functions run from the same master schedule.'),
            ),
        ),
        'luxury-wedding-planner-udaipur' => array(
            'title' => 'Luxury Wedding Planner in Udaipur',
            'seo_title' => 'Luxury Wedding Planner in Udaipur | Wedding Vows by Nikhil',
            'description' => 'Luxury wedding planning in Udaipur for palace and resort celebrations, with refined design, hospitality, production and discreet on-ground execution.',
            'intro' => 'Luxury is not a checklist of expensive elements. It is a wedding where every detail feels considered, calm and beautifully connected.',
            'image' => function_exists('wvn_hero_image') ? wvn_hero_image() : '',
            'highlights' => array(
                array('label' => 'Refined design', 'title' => 'Design with restraint', 'text' => 'We build palettes, florals, stationery, lighting and spatial details around the architecture instead of covering it up.'),
                array('label' => 'Private hospitality', 'title' => 'A considered guest journey', 'text' => 'Room blocks, transfers, welcome experiences and function flow are designed to feel personal without becoming intrusive.'),
                array('label' => 'Production', 'title' => 'Beautifully executed at scale', 'text' => 'Complex sound, lighting, stages, entertainment and live-show requirements are coordinated with the venue and design teams.'),
            ),
            'faqs' => array(
                array('q' => 'What does a luxury wedding planner in Udaipur handle?', 'a' => 'We can coordinate venue sourcing, concept and décor, hospitality, entertainment, photography, production, guest movement and detailed on-ground execution.'),
                array('q' => 'Which Udaipur venues suit a luxury wedding?', 'a' => 'Palace and luxury resort options include Taj Lake Palace, Jagmandir Island Palace, The Leela Palace Udaipur, Oberoi Udaivilas, Raffles Udaipur, Fairmont Udaipur Palace and other properties selected around the guest list.'),
                array('q' => 'Can you plan an intimate luxury wedding?', 'a' => 'Yes. A smaller guest list can allow the planning team to focus even more deeply on venue character, dining, design details and the guest experience.'),
            ),
        ),
        'destination-wedding-udaipur' => array(
            'title' => 'Destination Wedding in Udaipur',
            'seo_title' => 'Destination Wedding in Udaipur | Venues, Costs & Planning',
            'description' => 'Planning a destination wedding in Udaipur? Compare palace and resort venues, understand major cost heads and build a practical wedding timeline with a local planner.',
            'intro' => 'Udaipur gives destination weddings a rare combination of palace architecture, lake views and luxury hospitality. The planning challenge is turning that setting into a smooth multi-day celebration.',
            'image' => function_exists('wvn_hero_image') ? wvn_hero_image() : '',
            'highlights' => array(
                array('label' => 'Choose the venue first', 'title' => 'Guest count changes everything', 'text' => 'Room inventory, ceremony lawns, function capacity and transfer requirements should be compared before a venue is shortlisted on photographs alone.'),
                array('label' => 'Budget clearly', 'title' => 'Build around the major cost heads', 'text' => 'Venue and rooms, catering, décor and production, photography and planning are the main buckets. Understanding them early prevents expensive surprises.'),
                array('label' => 'Plan the timeline', 'title' => 'Give every function its own rhythm', 'text' => 'Arrival, welcome, mehendi, haldi, sangeet and wedding functions should be mapped against guest comfort, venue rules and production setup time.'),
            ),
            'faqs' => array(
                array('q' => 'What is the typical cost of a destination wedding in Udaipur?', 'a' => 'A 2-day wedding for around 150 to 200 guests can range widely, from roughly ₹50 lakhs to ₹3+ crores depending on venue, room inventory, food, décor, production and entertainment.'),
                array('q' => 'How many days should a destination wedding in Udaipur be?', 'a' => 'Two to three days works well for most families: guest arrivals and welcome, core celebrations such as mehendi and sangeet, and the wedding ceremony with departure hospitality.'),
                array('q' => 'What is the best time for a destination wedding in Udaipur?', 'a' => 'October through February is generally the most sought-after season for comfortable outdoor celebrations. Popular dates should be held well in advance.'),
            ),
        ),
    );
    return $slug && isset($pages[$slug]) ? $pages[$slug] : $pages;
}

function wvn_seed_seo_landing_pages() {
    if (get_option('wvn_seo_landing_pages_v1') === '1') {
        return;
    }

    $pages = wvn_seo_landing_config();
    foreach ($pages as $slug => $config) {
        $existing = get_page_by_path($slug, OBJECT, 'page');
        if ($existing) {
            continue;
        }
        $content = '<p>' . esc_html($config['intro']) . '</p>';
        if ($slug === 'wedding-planner-udaipur') {
            $content .= '<h2>Wedding planning in Udaipur, from venue to farewell</h2><p>Wedding Vows by Nikhil plans destination celebrations for families who want one experienced team responsible for the details. We help with venue selection, wedding design, vendor coordination, hospitality, production and the minute-by-minute running of the celebration.</p><p>Our home base is Udaipur, so planning starts with the realities of the city: hotel contracts, room blocks, guest transfers, local vendors, venue rules and production schedules. The result is a wedding that looks considered and runs quietly behind the scenes.</p><h2>What our Udaipur wedding planning covers</h2><ul><li>Venue research, comparisons and negotiations</li><li>Wedding concept, décor and production planning</li><li>Vendor sourcing and coordination</li><li>Guest hospitality, rooms and transportation</li><li>Function timelines and on-ground execution</li></ul><p>See our <a href="' . esc_url(home_url('/weddings-in-udaipur/')) . '">Udaipur wedding guide</a> for venue and cost planning, or <a href="' . esc_url(home_url('/contact-us/')) . '">contact us</a> to discuss your date.</p>';
        } elseif ($slug === 'destination-wedding-planner-udaipur') {
            $content .= '<h2>A destination wedding planner who is local to Udaipur</h2><p>When a wedding brings families from different cities or countries, the planner becomes the operating layer between the venue, vendors and guests. Wedding Vows by Nikhil manages that layer from Udaipur, with a single master plan for hospitality, design, production and celebration flow.</p><h2>From palace arrivals to the last farewell</h2><p>We build the guest journey around airport arrivals, room check-ins, welcome experiences, functions, transfers and departure. At the same time, our production team coordinates décor, lighting, entertainment and vendor access with the venue.</p><p>Explore <a href="' . esc_url(home_url('/what-we-do/')) . '">our wedding services</a> or <a href="' . esc_url(home_url('/weddings-in-udaipur/')) . '">compare Udaipur wedding venues and costs</a>.</p>';
        } elseif ($slug === 'luxury-wedding-planner-udaipur') {
            $content .= '<h2>Luxury wedding planning built around the venue</h2><p>Udaipur’s palaces and luxury resorts already provide the visual language. Our job is to add the right design, hospitality and production without losing what makes the property special.</p><h2>Discreet planning, detailed execution</h2><p>We work with families who value clarity and calm: a strong production schedule, carefully selected vendors, thoughtful guest touchpoints and a team that stays close to the details on the wedding days.</p><p>Explore <a href="' . esc_url(home_url('/what-we-do/')) . '">our complete wedding planning services</a> or <a href="' . esc_url(home_url('/contact-us/')) . '">book a consultation</a>.</p>';
        } else {
            $content .= '<h2>Why choose Udaipur for a destination wedding?</h2><p>Lake Pichola, palace architecture, heritage courtyards and luxury resort campuses give couples a wide range of settings within one destination. The right choice depends on guest count, room inventory, function requirements and the kind of experience you want guests to remember.</p><h2>Plan the destination before planning the décor</h2><p>Start with the venue and accommodation block, then map guest arrivals, food, décor, production, entertainment and function timings. This sequence makes the budget clearer and protects the guest experience.</p><p>For a detailed breakdown, read our <a href="' . esc_url(home_url('/weddings-in-udaipur/')) . '">Weddings in Udaipur guide</a> or <a href="' . esc_url(home_url('/contact-us/')) . '">speak with our Udaipur planning team</a>.</p>';
        }

        $page_id = wp_insert_post(wp_slash(array(
            'post_title' => $config['title'],
            'post_name' => $slug,
            'post_content' => $content,
            'post_excerpt' => $config['description'],
            'post_status' => 'publish',
            'post_type' => 'page',
            'comment_status' => 'closed',
        )), true);
        if (!is_wp_error($page_id)) {
            update_post_meta($page_id, '_wp_page_template', 'page-seo-landing.php');
            update_post_meta($page_id, '_wvn_seo_seeded', '1');
        }
    }
    update_option('wvn_seo_landing_pages_v1', '1', false);
}
add_action('init', 'wvn_seed_seo_landing_pages', 30);

function wvn_landing_seo_data() {
    if (!is_page()) {
        return null;
    }
    $slug = get_post_field('post_name', get_queried_object_id());
    $config = wvn_seo_landing_config($slug);
    return is_array($config) && !empty($config['seo_title']) ? $config : null;
}

function wvn_landing_document_title($parts) {
    $seo = wvn_landing_seo_data();
    return $seo ? array('title' => $seo['seo_title']) : $parts;
}
add_filter('document_title_parts', 'wvn_landing_document_title', 60);

function wvn_landing_wpseo_title($title) {
    $seo = wvn_landing_seo_data();
    return $seo ? $seo['seo_title'] : $title;
}
add_filter('wpseo_title', 'wvn_landing_wpseo_title', 60);
add_filter('wpseo_opengraph_title', 'wvn_landing_wpseo_title', 60);
add_filter('wpseo_twitter_title', 'wvn_landing_wpseo_title', 60);

function wvn_landing_wpseo_desc($description) {
    $seo = wvn_landing_seo_data();
    return $seo ? $seo['description'] : $description;
}
add_filter('wpseo_metadesc', 'wvn_landing_wpseo_desc', 60);
add_filter('wpseo_opengraph_desc', 'wvn_landing_wpseo_desc', 60);
add_filter('wpseo_twitter_description', 'wvn_landing_wpseo_desc', 60);

function wvn_landing_schema() {
    $seo = wvn_landing_seo_data();
    if (!$seo) {
        return;
    }
    $url = trailingslashit(get_permalink());
    $schema = array(
        '@context' => 'https://schema.org',
        '@graph' => array(
            array(
                '@type' => 'Service',
                '@id' => $url . '#service',
                'name' => $seo['title'],
                'serviceType' => $seo['title'],
                'description' => $seo['description'],
                'url' => $url,
                'areaServed' => array('@type' => 'City', 'name' => 'Udaipur'),
                'provider' => array('@id' => trailingslashit(home_url('/')) . '#business'),
            ),
            array(
                '@type' => 'FAQPage',
                '@id' => $url . '#faq',
                'mainEntity' => array_map(function ($faq) {
                    return array(
                        '@type' => 'Question',
                        'name' => $faq['q'],
                        'acceptedAnswer' => array('@type' => 'Answer', 'text' => $faq['a']),
                    );
                }, $seo['faqs']),
            ),
        ),
    );
    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
}
add_action('wp_head', 'wvn_landing_schema', 30);

/**
 * Publish a small set of evergreen planning articles once. These target
 * informational searches and feed authority into the commercial landing pages.
 */
function wvn_seed_seo_articles() {
    if (get_option('wvn_seo_articles_v1') === '1') {
        return;
    }

    $articles = array(
        array(
            'slug' => 'best-time-destination-wedding-udaipur',
            'title' => 'Best Time for a Destination Wedding in Udaipur',
            'excerpt' => 'A practical guide to wedding seasons in Udaipur, from weather and guest comfort to venue demand and booking timelines.',
            'content' => '<p>Udaipur works beautifully for destination weddings because the city combines lake views, heritage architecture and luxury hospitality. The month you choose still changes the guest experience, venue demand and how comfortably you can plan outdoor functions.</p><h2>October to February: the most sought-after season</h2><p>For many couples, the cooler months are the easiest period for outdoor ceremonies, welcome evenings and multi-function celebrations. This is also when popular palace and resort dates can become difficult to secure, so venue research should start early.</p><h2>March to June: warmer celebrations</h2><p>Spring and early summer can work when the venue has strong indoor options and the schedule is designed around the heat. Evening functions, shaded areas, cooling and guest transport become more important planning details.</p><h2>July to September: monsoon character</h2><p>Monsoon can bring a different visual mood to Rajasthan, but weather contingency planning matters. Before choosing a date, check the venue’s covered function spaces, rain plans and guest movement between rooms and events.</p><h2>How far ahead should you book?</h2><p>If your wedding needs a large room block or a high-demand palace venue, start roughly 8 to 12 months ahead. Peak dates can require more lead time. Once the venue is held, the rest of the production calendar becomes much easier to build.</p><p>Need help choosing dates and venues? See our <a href="' . esc_url(home_url('/destination-wedding-udaipur/')) . '">destination wedding in Udaipur guide</a> or <a href="' . esc_url(home_url('/contact-us/')) . '">talk to our planning team</a>.</p>',
        ),
        array(
            'slug' => 'udaipur-destination-wedding-cost-guide',
            'title' => 'Udaipur Destination Wedding Cost: A Practical Planning Guide',
            'excerpt' => 'Understand the major cost heads behind a destination wedding in Udaipur and where your guest count changes the budget.',
            'content' => '<p>There is no single price for a destination wedding in Udaipur. A 2-day celebration for around 150 to 200 guests can range broadly from about ₹50 lakhs to ₹3+ crores depending on the hotel, rooms, food, décor, production and entertainment.</p><h2>The major cost buckets</h2><ul><li><strong>Venue and accommodation:</strong> often the largest commitment, especially when a large room block is required.</li><li><strong>Catering:</strong> menu, number of meals, beverage service and guest count all affect the total.</li><li><strong>Décor and production:</strong> florals, structures, lighting, sound, staging and power requirements can change significantly by function.</li><li><strong>Photography and films:</strong> coverage, team size and deliverables vary by studio.</li><li><strong>Planning and coordination:</strong> the fee depends on scope, functions, guest count and execution complexity.</li></ul><h2>Start with the venue, not the décor</h2><p>Before building mood boards, compare room inventory, function capacities, venue restrictions, food arrangements and guest transfers. A venue that looks less expensive can become more costly once rooms, production access or transportation are added.</p><h2>Build a working budget</h2><p>Keep separate allowances for venue and rooms, food, décor and production, entertainment, photography, hospitality and planning. Then keep a contingency for changes that happen once vendors and venues are locked.</p><p>For venue comparisons, visit our <a href="' . esc_url(home_url('/weddings-in-udaipur/')) . '">Udaipur wedding guide</a>. If you want a planner to build the budget with you, <a href="' . esc_url(home_url('/contact-us/')) . '">book a consultation</a>.</p>',
        ),
        array(
            'slug' => 'udaipur-palace-wedding-guide',
            'title' => 'Palace Wedding in Udaipur: How to Choose the Right Venue',
            'excerpt' => 'How to compare Udaipur palace wedding venues by guest count, rooms, function spaces, logistics and guest experience.',
            'content' => '<p>A palace wedding in Udaipur is about more than a beautiful backdrop. The right property needs enough rooms, practical function spaces and a layout that lets guests move comfortably between celebrations.</p><h2>Start with your guest count</h2><p>Ask how many rooms the property can realistically allocate to your wedding, which rooms are available on your dates and where each function can happen. A beautiful venue becomes difficult when the guest block and event capacities do not match.</p><h2>Compare the full wedding journey</h2><p>Look at airport transfers, check-in, welcome events, mehendi, haldi, sangeet and the wedding ceremony as one journey. Island or heritage properties may create extraordinary arrivals, while larger resort campuses can make logistics easier for bigger groups.</p><h2>Questions to ask every palace venue</h2><ul><li>What is the room inventory for the wedding dates?</li><li>Which spaces can host each function?</li><li>What are the venue’s décor, sound and production rules?</li><li>How are outside vendors handled?</li><li>What happens if an outdoor function needs a rain or heat backup?</li></ul><p>Compare properties in our <a href="' . esc_url(home_url('/weddings-in-udaipur/')) . '">Udaipur wedding venues guide</a>, or <a href="' . esc_url(home_url('/wedding-planner-udaipur/')) . '">work with a local wedding planner in Udaipur</a> to shortlist the right fit.</p>',
        ),
        array(
            'slug' => 'udaipur-wedding-planning-checklist',
            'title' => 'Udaipur Destination Wedding Planning Checklist',
            'excerpt' => 'A practical destination wedding checklist covering venue, rooms, guests, vendors, design, production and the wedding-week schedule.',
            'content' => '<p>Planning a destination wedding in Udaipur becomes much easier when decisions are made in the right order. Use this checklist as a working sequence rather than trying to solve every detail at once.</p><h2>8–12 months before</h2><ul><li>Set the guest-count range and preferred dates.</li><li>Shortlist venues and compare room blocks.</li><li>Hold the venue before committing to major vendors.</li><li>Choose your planner and build the master budget.</li></ul><h2>5–8 months before</h2><ul><li>Lock décor direction and production requirements.</li><li>Book photography, films and entertainment.</li><li>Map guest travel, rooms and hospitality touchpoints.</li><li>Build the first function-by-function schedule.</li></ul><h2>2–4 months before</h2><ul><li>Confirm menus and guest preferences.</li><li>Finalize stationery, signage and room drops.</li><li>Confirm vendor arrival times and venue access.</li><li>Share the guest itinerary and transport plan.</li></ul><h2>Wedding week</h2><p>Run one master schedule covering guests, venue teams, décor, production, transport and family responsibilities. The planner’s job is to keep that schedule moving while the family enjoys the celebration.</p><p>For a complete venue and cost overview, read <a href="' . esc_url(home_url('/weddings-in-udaipur/')) . '">Weddings in Udaipur</a>. For full-service execution, explore our <a href="' . esc_url(home_url('/destination-wedding-planner-udaipur/')) . '">destination wedding planning service</a>.</p>',
        ),
    );

    foreach ($articles as $article) {
        if (get_page_by_path($article['slug'], OBJECT, 'post')) {
            continue;
        }
        $post_id = wp_insert_post(wp_slash(array(
            'post_title' => $article['title'],
            'post_name' => $article['slug'],
            'post_excerpt' => $article['excerpt'],
            'post_content' => $article['content'],
            'post_status' => 'publish',
            'post_type' => 'post',
            'comment_status' => 'closed',
        )), true);
        if (!is_wp_error($post_id)) {
            update_post_meta($post_id, '_wvn_seo_seeded', '1');
        }
    }
    update_option('wvn_seo_articles_v1', '1', false);
}
add_action('init', 'wvn_seed_seo_articles', 31);
