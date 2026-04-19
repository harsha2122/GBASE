// Hero Carousel Initialization
var heroSwiper = new Swiper('.gbase-hero-carousel', {
  loop: true,
  // effect: 'fade', // Removed fade effect for sliding
  autoplay: {
    delay: 4000,
    disableOnInteraction: false,
  },
  navigation: {
    nextEl: '.gbase-hero-next',
    prevEl: '.gbase-hero-prev',
  },
  slidesPerView: 1,
  speed: 800, // Smooth sliding speed
});
