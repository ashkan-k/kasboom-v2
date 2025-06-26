const swiperIndexWidth = new Swiper(".swiper-education-index", {
  slidesPerView: 1,
  spaceBetween: 5,
  effect: "fade",
  centeredSlides: true,
  loop: true,
  autoplay: {
    delay: 5000,
    disableOnInteraction: false,
  },
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
});

const swiperCourses = new Swiper(".swiper-courses", {
  slidesPerView: 1,
  spaceBetween: 25,
  autoplay: {
    delay: 4000,
    disableOnInteraction: false,
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  breakpoints: {
    0: {
      slidesPerView: 1,
      spaceBetween: 10,
    },
    480: {
      slidesPerView: 2,
      spaceBetween: 10,
    },
    768: {
      slidesPerView: 3,
      spaceBetween: 20,
    },
    992: {
      slidesPerView: 3,
    },
    1200: {
      slidesPerView: 4,
    },
  },
});

const swiperComments = new Swiper(".swiper-comments", {
  slidesPerView: 1,
  spaceBetween: 80,
  centeredSlides: true,
  loop: true,
  autoHeight: true,
  autoplay: {
    delay: 5000,
    disableOnInteraction: false,
  },
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
    dynamicBullets: true,
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  breakpoints: {
    480: {
      slidesPerView: 1,
    },
    768: {
      slidesPerView: 1,
    },
    992: {
      slidesPerView: 2,
      spaceBetween: 30,
    },
    1200: {
      slidesPerView: 2,
    },
  },
});

var swiperImageThumbs = new Swiper(".swiper-course-thumb", {
  spaceBetween: 15,
  slidesPerView: 2,
  watchSlidesProgress: true,
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  autoplay: {
    delay: 4000,
    disableOnInteraction: false,
  },
  breakpoints: {
    390: {
      slidesPerView: 3,
      spaceBetween: 5,
    },
    480: {
      slidesPerView: 4,
      spaceBetween: 5,
    },
    768: {
      slidesPerView: 4,
      spaceBetween: 10,
    },
    992: {
      slidesPerView: 5,
    },
    1200: {
      slidesPerView: 6,
    },
  },
});

const swiperCoursesVideo = new Swiper(".swiper-course-video", {
  slidesPerView: 1,
  spaceBetween: 10,
  thumbs: {
    swiper: swiperImageThumbs,
  },
});

const swiperWorkshop = new Swiper(".swiper-workshop", {
  spaceBetween: 15,
  autoplay: {
    delay: 4000,
    disableOnInteraction: false,
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  breakpoints: {
    480: {
      slidesPerView: 1,
    },
    650: {
      slidesPerView: 2,
    },
    768: {
      slidesPerView: 2,
    },
    992: {
      slidesPerView: 3,
    },
    1200: {
      slidesPerView: 4,
    },
  },
});

const swiperClass = new Swiper(".swiper-infographics", {
  spaceBetween: 15,
  autoplay: {
    delay: 40000000,
    disableOnInteraction: false,
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  breakpoints: {
    490: {
      slidesPerView: 1,
    },
    500: {
      slidesPerView: 2,
    },
    768: {
      slidesPerView: 2,
    },
    992: {
      slidesPerView: 2,
    },
    1200: {
      slidesPerView: 3,
    },
  },
});

const swiperCertificate = new Swiper(".swiper-certificate", {
  spaceBetween: 15,
  autoplay: {
    delay: 3000,
    disableOnInteraction: false,
  },
});

const swiperSwiper = new Swiper(".swiper-ebooks", {
  spaceBetween: 20,
  slidesPerView: 2,
  autoplay: {
    delay: 4000,
    disableOnInteraction: false,
  },
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  breakpoints: {
    0: {
      slidesPerView: 2,
      spaceBetween: 5,
    },
    480: {
      slidesPerView: 3,
      spaceBetween: 5,
    },
    768: {
      slidesPerView: 4,
      spaceBetween: 10,
    },
    992: {
      slidesPerView: 5,
      spaceBetween: 15,
    },
    1200: {
      slidesPerView: 6,
    },
  },
});

const swiperLogin = new Swiper(".swiper-login", {
  slidesPerView: 1,
  effect: "fade",
  centeredSlides: true,
  loop: true,
  autoplay: {
    delay: 5000,
    disableOnInteraction: false,
  },
});

const swiperLandingWidth = new Swiper(".swiper-landing-index", {
  slidesPerView: 1,
  spaceBetween: 10,
  effect: "fade",
  centeredSlides: true,
  loop: true,
  autoplay: {
    delay: 5000,
    disableOnInteraction: false,
  },
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
});

const swiperLandingComments = new Swiper(".swiper-landing-comment", {
  slidesPerView: 2,
  spaceBetween: 40,
  centeredSlides: true,
  loop: true,
  autoplay: {
    delay: 5000,
    disableOnInteraction: false,
  },
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  breakpoints: {
    250: {
      slidesPerView: 1,
    },
    480: {
      slidesPerView: 1,
    },
    768: {
      slidesPerView: 1,
    },
    992: {
      slidesPerView: 2,
      spaceBetween: 30,
    },
    1200: {
      slidesPerView: 2,
    },
  },
});
