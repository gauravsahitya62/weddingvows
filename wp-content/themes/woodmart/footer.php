<footer class="wvn-footer">
  <div class="wvn-footer-grid">
    <div>
      <h2>Wedding Vows<br>by Nikhil</h2>
      <p><?php echo esc_html(wvn_home_text('home_footer_tagline', 'Destination wedding planner in Udaipur — palace, lakeside and heritage celebrations across Rajasthan and India.')); ?></p>
      <div class="wvn-social">
        <a href="https://www.instagram.com/weddingvowsbynikhil" target="_blank" rel="noopener" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
        <a href="https://www.facebook.com/share/16DJ386egg/?mibextid=wwXIfr" target="_blank" rel="noopener" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
        <a href="https://wa.me/message/ECDOSKZJH772M1" target="_blank" rel="noopener" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
      </div>
    </div>
    <div>
      <h4><?php echo esc_html(wvn_home_text('home_footer_explore_title', 'Explore')); ?></h4>
      <ul>
        <?php
        $explore_rows = wvn_home_rows('home_footer_explore_links');
        if (!empty($explore_rows)) :
            foreach ($explore_rows as $item) :
                if (empty($item['label'])) continue; ?>
                <li><a href="<?php echo esc_url($item['url'] ?: '#'); ?>"><?php echo esc_html($item['label']); ?></a></li>
            <?php endforeach;
        else : ?>
          <li><a href="<?php echo esc_url(home_url('/weddings-in-udaipur/')); ?>">Weddings in Udaipur</a></li>
          <li><a href="<?php echo esc_url(home_url('/wedding-planner-udaipur/')); ?>">Wedding planner in Udaipur</a></li>
          <li><a href="<?php echo esc_url(home_url('/destination-wedding-planner-udaipur/')); ?>">Destination wedding planner</a></li>
          <li><a href="<?php echo esc_url(home_url('/luxury-wedding-planner-udaipur/')); ?>">Luxury wedding planner</a></li>
          <li><a href="<?php echo esc_url(home_url('/destination-wedding-udaipur/')); ?>">Destination wedding in Udaipur</a></li>
          <li><a href="<?php echo esc_url(home_url('/wedding-venues-udaipur/')); ?>">Wedding venues in Udaipur</a></li>
          <li><a href="<?php echo esc_url(home_url('/palace-wedding-venues-in-udaipur/')); ?>">Palace wedding venues</a></li>
          <li><a href="<?php echo esc_url(home_url('/udaipur-wedding-cost/')); ?>">Udaipur wedding cost</a></li>
          <li><a href="<?php echo esc_url(home_url('/portfolio/')); ?>">Real Udaipur weddings</a></li>
          <li><a href="<?php echo esc_url(home_url('/what-we-do/')); ?>">Wedding planning services</a></li>
        <?php endif; ?>
      </ul>
    </div>
    <div>
      <h4><?php echo esc_html(wvn_home_text('home_footer_services_title', 'Services')); ?></h4>
      <ul>
        <?php
        $services_rows = wvn_home_rows('home_footer_services_links');
        if (!empty($services_rows)) :
            foreach ($services_rows as $item) :
                if (empty($item['label'])) continue; ?>
                <li><a href="<?php echo esc_url($item['url'] ?: '#'); ?>"><?php echo esc_html($item['label']); ?></a></li>
            <?php endforeach;
        else : ?>
          <li><a href="<?php echo esc_url(home_url('/what-we-do/')); ?>">Full destination wedding planning</a></li>
          <li><a href="<?php echo esc_url(home_url('/what-we-do/')); ?>">Wedding décor in Udaipur</a></li>
          <li><a href="<?php echo esc_url(home_url('/what-we-do/')); ?>">Palace venue sourcing</a></li>
          <li><a href="<?php echo esc_url(home_url('/what-we-do/')); ?>">Guest hospitality</a></li>
        <?php endif; ?>
      </ul>
    </div>
    <div>
      <h4>Studio</h4>
      <ul>
        <li><a href="<?php echo esc_url(get_permalink((int) get_option('page_for_posts')) ?: home_url('/blog/')); ?>">Blog</a></li>
        <li><a href="<?php echo esc_url(home_url('/portfolio/')); ?>">Real Weddings</a></li>
        <li><a href="<?php echo esc_url(home_url('/contact-us/')); ?>">Contact</a></li>
      </ul>
    </div>
  </div>
  <div class="wvn-legal">
    <span>© <?php echo esc_html(date('Y')); ?> Wedding Vows By Nikhil. All rights reserved.</span>
    <span><?php echo esc_html(wvn_home_text('home_footer_address', '53, Sun city, Delhite, Behind Celebration Mall, Bhuwana, Udaipur, Rajasthan 313001')); ?></span>
  </div>
</footer>

<button class="wvn-theme" type="button" aria-label="Toggle color theme"><i>☀</i></button>
<button class="wvn-ask" type="button" data-open-ask><span>⌕</span> Ask anything...</button>
<a class="wvn-float-wa" href="https://wa.me/message/ECDOSKZJH772M1" target="_blank" rel="noopener" aria-label="Chat on WhatsApp">
  <svg width="30" height="30" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
    <path fill-rule="evenodd" clip-rule="evenodd" d="M18.403 5.638A8.955 8.955 0 0 0 12.053 3c-4.948 0-8.976 4.027-8.978 8.977 0 1.582.413 3.126 1.198 4.488L3 21.116l4.759-1.249a8.981 8.981 0 0 0 4.29 1.093h.004c4.947 0 8.975-4.027 8.977-8.977a8.926 8.926 0 0 0-2.627-6.345zm-6.35 13.792h-.003a7.48 7.48 0 0 1-3.812-1.045l-.273-.162-2.832.743.756-2.76-.177-.282a7.464 7.464 0 0 1-1.144-3.951c.002-4.12 3.354-7.47 7.48-7.47 1.996 0 3.873.777 5.284 2.189a7.435 7.435 0 0 1 2.184 5.285c-.002 4.12-3.353 7.468-7.466 7.468zm4.1-5.597c-.225-.113-1.332-.657-1.538-.732-.206-.075-.356-.113-.506.113-.15.225-.582.732-.713.882-.131.15-.262.169-.487.056-.225-.113-.95-.35-1.81-1.117-.67-.598-1.122-1.337-1.253-1.562-.131-.225-.014-.347.098-.459.102-.101.225-.263.338-.394.112-.132.15-.225.225-.376.075-.15.037-.281-.019-.394-.056-.113-.506-1.219-.694-1.67-.183-.439-.369-.379-.506-.386-.131-.007-.281-.008-.431-.008-.15 0-.394.056-.6.281-.206.225-.788.77-.788 1.876 0 1.107.806 2.176.919 2.326.112.15 1.586 2.422 3.842 3.396.537.232.956.37 1.283.474.539.171 1.03.147 1.418.089.433-.065 1.332-.544 1.52-1.07.188-.525.188-.976.131-1.07-.056-.094-.206-.15-.431-.263z"/>
  </svg>
</a>

<div class="wvn-modal" id="wvn-ask-modal" data-close-modal>
  <div class="wvn-modal-card" onclick="event.stopPropagation()">
    <h2 class="wvn-display" style="font-size:28px;margin-bottom:16px;">Ask anything</h2>
    <input id="wvn-ask-input" type="search" placeholder="Search questions, venues, timelines...">
    <div id="wvn-ask-results"></div>
    <p style="margin-top:18px;"><a class="wvn-btn" href="<?php echo esc_url(home_url('/contact-us/')); ?>">Book a Consultation ↗</a></p>
  </div>
</div>

<div class="wvn-modal" id="wvn-showreel-modal" data-close-modal>
  <div class="wvn-modal-card" onclick="event.stopPropagation()">
    <video controls playsinline src="<?php echo esc_url(wvn_showreel_video()); ?>"></video>
  </div>
</div>

<div class="wvn-modal" id="wvn-feature-modal" data-close-modal>
  <div class="wvn-modal-card" onclick="event.stopPropagation()">
    <p class="wvn-kicker">Featured in</p>
    <h2 class="wvn-display" style="font-size:32px;">Press &amp; recognition</h2>
    <p>Wedding Vows by Nikhil has been trusted by families across Udaipur, Jaipur, Jodhpur and Goa for luxury destination weddings — from palace celebrations to intimate lakeside vows.</p>
  </div>
</div>

<?php wp_footer(); ?>
</body>
</html>
