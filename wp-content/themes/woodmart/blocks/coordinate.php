<?php
$image = get_field('background_image');
$hero_text = get_field('hero_text');
$form_heading = get_field('form_heading');
$social_links = get_field('social_links');
?>

<section class="hero-contact-section">

  <div class="hero-banner">
    <?php if ($image) : ?>
      <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
    <?php endif; ?>
    <div class="hero-text">
      <?php echo esc_html($hero_text); ?>
    </div>
  </div>

  <div class="contact-form-wrapper">
    <?php if ($form_heading) : ?>
      <h2><?php echo esc_html($form_heading); ?></h2>
    <?php endif; ?>

    <form class="quick-contact-form" id="quickContactForm">
    <input type="hidden" name="action" value="submit_quick_contact">
        <input type="text" name="full_name" placeholder="Full Name" required>
        <input type="text" name="phone" placeholder="Your Phone Number" required>
        <input type="email" name="email" placeholder="Your E-mail" required>
        <button type="submit">GET IN TOUCH</button>
    </form>

    
<div id="form-message"></div>

    <div class="social-icons">
      <a href="https://www.facebook.com/share/16DJ386egg/?mibextid=wwXIfr"><i class="fab fa-facebook-f"></i></a>
      <a href="https://www.instagram.com/weddingvowsbynikhil?igsh=bTIzZmN4ZWM5aHY2&utm_source=qr"><i class="fab fa-instagram"></i></a>
      <a href="https://wa.me/message/ECDOSKZJH772M1"><i class="fab fa-whatsapp"></i></a>
      <a href="mailto:weddingvowsbynikhil@gmail.com" aria-label="Email us"><i class="fas fa-envelope"></i></a>
    </div>
  </div>

</section>
<script>
document.getElementById('quickContactForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    var formData = new FormData(this);

    fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(result => {
        document.getElementById('form-message').innerHTML = '<p style="color:green;">Thank you! We will get back to you soon.</p>';
        document.getElementById('quickContactForm').reset();
    })
    .catch(error => {
        document.getElementById('form-message').innerHTML = '<p style="color:red;">Something went wrong. Please try again.</p>';
    });
});
</script>