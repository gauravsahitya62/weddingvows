<footer class="wvn-footer">
  <div class="wvn-footer-grid">
    <div>
      <h2>Wedding Vows<br>by Nikhil</h2>
      <p>Destination wedding planner in Udaipur — palace, lakeside and heritage celebrations across Rajasthan and India.</p>
      <div class="wvn-social">
        <a href="https://www.instagram.com/weddingvowsbynikhil" target="_blank" rel="noopener" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
        <a href="https://www.facebook.com/share/16DJ386egg/?mibextid=wwXIfr" target="_blank" rel="noopener" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
        <a href="https://wa.me/message/ECDOSKZJH772M1" target="_blank" rel="noopener" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
      </div>
    </div>
    <div>
      <h4>Explore</h4>
      <ul>
        <li><a href="<?php echo esc_url(home_url('/weddings-in-udaipur/')); ?>">Weddings in Udaipur</a></li>
        <li><a href="<?php echo esc_url(home_url('/wedding-planner-udaipur/')); ?>">Wedding planner in Udaipur</a></li>
        <li><a href="<?php echo esc_url(home_url('/destination-wedding-planner-udaipur/')); ?>">Destination wedding planner</a></li>
        <li><a href="<?php echo esc_url(home_url('/luxury-wedding-planner-udaipur/')); ?>">Luxury wedding planner</a></li>
        <li><a href="<?php echo esc_url(home_url('/destination-wedding-udaipur/')); ?>">Destination wedding in Udaipur</a></li>
        <li><a href="<?php echo esc_url(home_url('/portfolio/')); ?>">Real Udaipur weddings</a></li>
        <li><a href="<?php echo esc_url(home_url('/what-we-do/')); ?>">Wedding planning services</a></li>
      </ul>
    </div>
    <div>
      <h4>Services</h4>
      <ul>
        <li><a href="<?php echo esc_url(home_url('/what-we-do/')); ?>">Full destination wedding planning</a></li>
        <li><a href="<?php echo esc_url(home_url('/what-we-do/')); ?>">Wedding décor in Udaipur</a></li>
        <li><a href="<?php echo esc_url(home_url('/what-we-do/')); ?>">Palace venue sourcing</a></li>
        <li><a href="<?php echo esc_url(home_url('/what-we-do/')); ?>">Guest hospitality</a></li>
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
    <span>53, Sun city, Delhite, Behind Celebration Mall, Bhuwana, Udaipur, Rajasthan 313001</span>
  </div>
</footer>

<button class="wvn-theme" type="button" aria-label="Toggle color theme"><i>☀</i></button>
<button class="wvn-ask" type="button" data-open-ask><span>⌕</span> Ask anything...</button>

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