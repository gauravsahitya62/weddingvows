jQuery(document).ready(function($) {
    $('.owl-carousel').owlCarousel({
      loop: true,
      margin: 20,
      nav: true,
      dots: false,
      autoplay: true,
      autoHeight: false, // Force uniform height
      autoplayTimeout: 3000,
      responsive: {
        0: { items: 1 },
        576: { items: 2 },
        768: { items: 3 },
        1024: { items: 4 }
      }
    });
  });
  