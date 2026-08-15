<?php
get_header();
while (have_posts()) :
    the_post();
    ?>
<main id="content" class="wvn-page">
    <h1><?php echo is_page('contact-us') ? 'Book a destination wedding planner in Udaipur' : get_the_title(); ?></h1>
    <div class="wvn-content">
        <?php if (is_page('contact-us') && !wvn_elementor_editing()) : ?>
            <p class="wvn-lede" style="margin-bottom:32px;">Tell us about your destination wedding in Udaipur — guest count, season, and whether you are looking at a palace, a lakeside hotel, or a heritage courtyard. Our studio in Bhuwana will reply with a clear next step.</p>
            <div class="wvn-contact-grid">
                <aside>
                    <p class="wvn-kicker">Reach us</p>
                    <h2 class="wvn-display" style="font-size:28px;">Address &amp; contact</h2>
                    <p><strong>Wedding Vows By Nikhil</strong><br>53, Sun city, Delhite, Behind Celebration Mall, Bhuwana<br>Udaipur, Rajasthan 313001</p>
                    <p><a href="mailto:weddingvowsbynikhil@gmail.com">weddingvowsbynikhil@gmail.com</a></p>
                    <p><a href="https://wa.me/message/ECDOSKZJH772M1">Message on WhatsApp ↗</a></p>
                </aside>
                <div>
                    <?php the_content(); ?>
                    <form class="quick-contact-form" id="quickContactForm">
                        <input type="hidden" name="action" value="submit_quick_contact">
                        <input type="text" name="full_name" placeholder="Your name" required>
                        <input type="text" name="phone" placeholder="Phone number" required>
                        <input type="email" name="email" placeholder="Email" required>
                        <button type="submit">Send an enquiry</button>
                    </form>
                    <div id="form-message"></div>
                </div>
            </div>
        <?php else : ?>
            <?php the_content(); ?>
        <?php endif; ?>
    </div>
</main>
    <?php
endwhile;
get_footer();
