window.addEventListener('DOMContentLoaded', () => {
  var swiper = new Swiper('.mySwiper', {
    loop: true,
    spaceBetween: 10,
    slidesPerView: 4,
    freeMode: true,
    watchSlidesProgress: true,
    breakpoints: {
      '@0.00': {
        slidesPerView: 1,
        spaceBetween: 10,
      },
      '@0.75': {
        slidesPerView: 2,
        spaceBetween: 20,
      },
      '@1.00': {
        slidesPerView: 3,
        spaceBetween: 40,
      },
      '@1.50': {
        slidesPerView: 4,
        spaceBetween: 50,
      },
    },
  })

  var swiper = new Swiper('.testimonials', {
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    spaceBetween: 30,
    autoplay: {
      delay: 5000,
      disableOnInteraction: false,
    },
    thumbs: {
      swiper: swiper,
    },
  })

  const tabTrigger = document.querySelectorAll('.tab-trigger')

  tabTrigger.forEach((tab, index) => {
    tab.addEventListener('click', () => {
      tabTrigger.forEach((tabs, index2) => {
        tabs.setAttribute('data-active', 'false')
      })

      tab.setAttribute('data-active', 'true')
    })
  })
})
