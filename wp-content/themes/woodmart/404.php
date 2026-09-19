<?php
/**
 * 404 template — never leave an empty cream shell with only the footer.
 */
get_header();
?>
<main id="content" class="wvn-content-page">
  <div class="wvn-standard-page-inner">
    <header class="wvn-standard-page-header">
      <p class="wvn-kicker">Page not found</p>
      <h1 class="wvn-display">This page isn’t available</h1>
    </header>
    <div class="wvn-standard-page-content">
      <p>The link may be outdated, or the page hasn’t been published yet. Try one of these instead:</p>
      <ul>
        <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
        <li><a href="<?php echo esc_url(home_url('/portfolio/')); ?>">Real Weddings</a></li>
        <li><a href="<?php echo esc_url(home_url('/what-we-do/')); ?>">What We Do</a></li>
        <li><a href="<?php echo esc_url(home_url('/contact-us/')); ?>">Contact</a></li>
      </ul>
    </div>
  </div>
</main>
<?php
get_footer();
