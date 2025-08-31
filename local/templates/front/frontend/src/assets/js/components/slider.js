import $ from "jquery"
import Swiper, { Navigation, Pagination } from "swiper"

document.addEventListener("DOMContentLoaded", () => {
  const sliders = $(".slider")
  if (sliders.length > 0) {
    sliders.each(function() {
      const swiperSlider = new Swiper(this, {
        modules: [Pagination],
        pagination: {
          el: this.querySelector(".slider__pagination"),
        }
      })
      $(this).find(".slider__slide:not(.swiper-slide-duplicate) .slider__image-link[data-fancybox]").fancybox({
        buttons: [
          "close"
        ],
        backFocus: false,
      })
    })
  }

  const faqSlider = document.querySelector("[data-faq-slider]");
  if (faqSlider) {
    let faqSwiperInstance = null;

    const initFaqSlider = () => {
      if (window.innerWidth <= 1279) {
        if (!faqSwiperInstance) {
          faqSwiperInstance = new Swiper(faqSlider, {
            modules: [Navigation, Pagination],
            loop: true,
            pagination: {
              el: '.faq-slider [data-faq-pagination]',
              type: 'fraction',
              renderFraction: function (currentClass, totalClass) {
                return `<span class="${currentClass}"></span>/<span class="${totalClass}"></span>`;
              }
            },
            navigation: {
              nextEl: '.faq-slider [data-faq-next]',
              prevEl: '.faq-slider [data-faq-prev]',
            },
            slidesPerView: 1,
            breakpoints: {
              640: {
                slidesPerView: 2,
                spaceBetween: 10
              },
              1280: {
                slidesPerView: 3,
                spaceBetween: 20,
              }
            }
          })
        }
      } else {
        if (faqSwiperInstance) {
          faqSwiperInstance.destroy(true, true);
          faqSwiperInstance = null;
        }
      }
    }

    initFaqSlider();
    window.addEventListener('resize', initFaqSlider);
  }

  const casesSlider = document.querySelector("[data-case-slider]");
  if (casesSlider) new Swiper(casesSlider, {
    modules: [Navigation, Pagination],
    loop: true,
    pagination: {
      el: '.case-slider [data-case-pagination]',
      type: 'fraction',
      renderFraction: function (currentClass, totalClass) {
        return `<span class="${currentClass}"></span>/<span class="${totalClass}"></span>`;
      }
    },
    navigation: {
      nextEl: '.case-slider [data-case-next]',
      prevEl: '.case-slider [data-case-prev]',
    },
    slidesPerView: 1,
  })

  const casesSlider2 = document.querySelector("[data-case-slider-2]");
  if (casesSlider2) new Swiper(casesSlider2, {
    modules: [Navigation, Pagination],
    loop: true,
    pagination: {
      el: '.cases-slider-secondary__slider [data-case-pagination]',
      type: 'fraction',
      renderFraction: function (currentClass, totalClass) {
        return `<span class="${currentClass}"></span>/<span class="${totalClass}"></span>`;
      }
    },
    navigation: {
      nextEl: '.cases-slider-secondary__slider [data-case-next]',
      prevEl: '.cases-slider-secondary__slider [data-case-prev]',
    },
    spaceBetween: 10,
    slidesPerView: 1,
    breakpoints: {
      640: {
        slidesPerView: 'auto',
        spaceBetween: 10
      },
      1280: {
        slidesPerView: 3,
        spaceBetween: 20,
      }
    }
  })
})
