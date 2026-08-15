<?php get_header(); ?>
<main id="content" class="wvn-page wvn-portfolio">
  <p class="wvn-kicker wvn-center">Real destination weddings</p>
  <h1>Destination weddings in Udaipur, captured behind the scenes</h1>
  <p class="wvn-lede">Palace, lakeside and heritage celebrations planned in Udaipur and across India by Wedding Vows by Nikhil.</p>
  <div class="wvn-mosaic">
    <?php foreach (wvn_portfolio_images() as $image) : ?>
      <a href="<?php echo esc_url($image); ?>" data-wvn-lightbox>
        <img src="<?php echo esc_url($image); ?>" alt="Destination wedding in Udaipur — Wedding Vows by Nikhil" loading="lazy" decoding="async">
      </a>
    <?php endforeach; ?>
  </div>
</main>
<?php get_footer(); ?>
