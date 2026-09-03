<?php if (!is_page('contact')) { wbc_render_cta(); } ?>
<?php
$socials = wbc_footer_socials();
$strip = array_slice(array_merge(
    wbc_get_ordered_posts('wbc_wedding', 4),
    wbc_get_ordered_posts('wbc_destination', 3)
), 0, 5);
$year = wbc_mod('wbc_founding_year', '2018');
$mono = strtoupper(substr(wbc_brand_name(), 0, 1));
$email = wbc_mod('wbc_email', get_option('admin_email'));
$phone = wbc_mod('wbc_phone', '+91 76667 78899');
?>
<footer class="wbc-footer">
    <div class="wbc-footer-top">
        <div class="wbc-social">
            <?php foreach ($socials as $item) : ?>
                <a href="<?php echo esc_url($item['url']); ?>"<?php echo $item['url'] !== '#' ? ' target="_blank" rel="noopener"' : ''; ?> aria-label="<?php echo esc_attr(ucfirst($item['name'])); ?>">
                    <?php echo wbc_svg_icon($item['name']); ?>
                </a>
            <?php endforeach; ?>
        </div>
        <a class="wbc-mono" href="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php echo esc_attr(wbc_brand_name()); ?>">
            <svg class="wbc-mono-wreath" viewBox="0 0 140 140" fill="none" aria-hidden="true">
                <path d="M70 16c-24 8-40 34-41 54 1 22 17 46 41 54" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
                <path d="M70 16c24 8 40 34 41 54-1 22-17 46-41 54" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
                <path d="M56 22c-7 1-12 8-9 14M46 32c-8 3-12 12-7 18M39 46c-8 5-10 14-4 20M35 64c-8 5-8 16-1 22M36 84c-7 6-4 16 4 20M42 102c-5 7 0 14 8 16M54 118c-4 4 2 8 8 7M84 22c7 1 12 8 9 14M94 32c8 3 12 12 7 18M101 46c8 5 10 14 4 20M105 64c8 5 8 16 1 22M104 84c7 6 4 16-4 20M98 102c5 7 0 14-8 16M86 118c4 4-2 8-8 7" stroke="currentColor" stroke-width="1.1" stroke-linecap="round"/>
            </svg>
            <span><?php echo esc_html($mono); ?></span>
            <small>Est. <?php echo esc_html($year); ?></small>
        </a>
        <form class="wbc-footer-search" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
            <button type="submit" aria-label="<?php esc_attr_e('Search', 'weddingsbychetanparihar'); ?>"><?php echo wbc_svg_icon('search'); ?></button>
            <input type="search" name="s" placeholder="Search" value="<?php echo esc_attr(get_search_query()); ?>">
        </form>
    </div>
    <div class="wbc-footer-base">
        <?php if ($strip) : ?>
        <div class="wbc-footer-strip">
            <?php foreach ($strip as $i => $item) : ?>
                <a href="<?php echo esc_url(get_permalink($item)); ?>">
                    <img src="<?php echo esc_url(wbc_default_image('strip-' . ($i + 1))); ?>" alt="<?php echo esc_attr(get_the_title($item)); ?>" loading="lazy">
                </a>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        <nav class="wbc-footer-links" aria-label="<?php esc_attr_e('Footer', 'weddingsbychetanparihar'); ?>">
            <a href="<?php echo esc_url(wbc_journal_url()); ?>">Blogs</a>
            <span aria-hidden="true">|</span>
            <a href="<?php echo esc_url(wbc_weddings_url()); ?>">Portfolio</a>
            <span aria-hidden="true">|</span>
            <a href="<?php echo esc_url(wbc_contact_url()); ?>">Contact Us</a>
        </nav>
        <p class="wbc-legal">
            <span>© <?php echo esc_html(gmdate('Y')); ?> <?php echo esc_html(wbc_brand_name()); ?>. All rights reserved.</span>
            <span aria-hidden="true">|</span>
            <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
            <span aria-hidden="true">|</span>
            <a href="tel:<?php echo esc_attr(wbc_phone_plain()); ?>"><?php echo esc_html($phone); ?></a>
        </p>
    </div>
</footer>
<a class="wbc-whatsapp" href="<?php echo esc_url(wbc_whatsapp_url()); ?>" target="_blank" rel="noopener" aria-label="<?php esc_attr_e('Chat on WhatsApp', 'weddingsbychetanparihar'); ?>">
    <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18.4 5.6A8.95 8.95 0 0 0 12.05 3a8.98 8.98 0 0 0-7.78 13.46L3 21.12l4.76-1.25a8.98 8.98 0 0 0 4.29 1.09h.01a8.98 8.98 0 0 0 6.34-15.32Zm-6.35 13.79a7.48 7.48 0 0 1-3.81-1.05l-.27-.16-2.83.74.75-2.76-.18-.28a7.46 7.46 0 1 1 6.34 3.51Zm4.1-5.6c-.22-.11-1.33-.66-1.54-.73-.2-.08-.36-.12-.5.11-.15.23-.59.73-.72.88-.13.15-.26.17-.49.06-.22-.11-.95-.35-1.81-1.12-.67-.6-1.12-1.34-1.25-1.56-.13-.23-.01-.35.1-.46.1-.1.22-.26.33-.39.12-.13.15-.23.23-.38.07-.15.04-.28-.02-.39-.06-.12-.5-1.22-.69-1.67-.18-.44-.37-.38-.51-.39h-.43c-.15 0-.39.06-.6.28-.2.23-.79.77-.79 1.88s.81 2.17.92 2.32c.11.15 1.59 2.42 3.84 3.4.54.23.96.37 1.29.47.54.17 1.03.15 1.42.09.43-.06 1.33-.54 1.52-1.07.19-.52.19-.98.13-1.07-.06-.1-.21-.15-.43-.26Z"/></svg>
</a>
<?php wp_footer(); ?>
</body>
</html>
