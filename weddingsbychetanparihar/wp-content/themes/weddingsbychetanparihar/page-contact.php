<?php
/**
 * Template Name: Contact
 */
get_header();
?>
<main id="content" class="wbc-contact-page">
    <?php wbc_render_cta(true); ?>
    <section class="wbc-contact-intro">
        <p class="wbc-kicker"><?php echo esc_html(wbc_contact_setting('wbc_form_kicker', 'Enquiry')); ?></p>
        <h2><?php echo esc_html(wbc_contact_setting('wbc_cta_title', 'Tell us where the celebration begins.')); ?></h2>
        <p class="wbc-answer"><?php echo esc_html(wbc_contact_setting('wbc_cta_text', 'Share the date, city, guest count and the kind of wedding you imagine. Enquiries are stored in wp-admin under Contact Leads and emailed to the studio.')); ?></p>
    </section>
    <section class="wbc-contact-grid">
        <form class="wbc-form" data-contact-form>
            <input type="hidden" name="action" value="wbc_contact">
            <input type="hidden" name="nonce" value="<?php echo esc_attr(wp_create_nonce('wbc_contact')); ?>">
            <label class="wbc-honey" aria-hidden="true">Company<input name="company" tabindex="-1" autocomplete="off"></label>
            <?php foreach (wbc_visible_contact_fields() as $field) : ?>
                <label<?php echo !empty($field['wide']) ? ' class="is-wide"' : ''; ?>>
                    <?php echo esc_html($field['label']); ?>
                    <?php if ($field['type'] === 'textarea') : ?>
                        <textarea name="<?php echo esc_attr($field['key']); ?>" rows="5" placeholder="<?php echo esc_attr($field['placeholder']); ?>"<?php echo !empty($field['required']) ? ' required' : ''; ?>></textarea>
                    <?php else : ?>
                        <input name="<?php echo esc_attr($field['key']); ?>" type="<?php echo esc_attr($field['type']); ?>"<?php echo !empty($field['autocomplete']) ? ' autocomplete="' . esc_attr($field['autocomplete']) . '"' : ''; ?> placeholder="<?php echo esc_attr($field['placeholder']); ?>"<?php echo !empty($field['required']) ? ' required' : ''; ?>>
                    <?php endif; ?>
                </label>
            <?php endforeach; ?>
            <button class="wbc-btn" type="submit"><?php echo esc_html(wbc_contact_setting('wbc_form_button', 'Send enquiry')); ?> <?php echo wbc_svg_icon('arrow'); ?></button>
            <p class="wbc-form-message" data-form-message></p>
        </form>
        <aside class="wbc-contact-card">
            <h2><?php echo esc_html(wbc_brand_name()); ?></h2>
            <p><?php echo esc_html(wbc_mod('wbc_tagline', 'Destination wedding planning and celebration design from Udaipur.')); ?></p>
            <p><?php echo esc_html(wbc_full_address()); ?></p>
            <a href="tel:<?php echo esc_attr(wbc_phone_plain()); ?>"><?php echo esc_html(wbc_mod('wbc_phone', '+91 76667 78899')); ?></a>
            <a href="mailto:<?php echo esc_attr(wbc_studio_email()); ?>"><?php echo esc_html(wbc_studio_email()); ?></a>
            <a href="<?php echo esc_url(wbc_whatsapp_url()); ?>" target="_blank" rel="noopener">WhatsApp the studio</a>
        </aside>
    </section>
</main>
<?php get_footer(); ?>
