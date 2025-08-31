document.addEventListener("DOMContentLoaded", () => {
    const faq = document.getElementById("faq");

    if (faq) {
        const more = faq.querySelector(".faq-more");
        const slider = faq.querySelector(".faq-slider");
        const slidesHidden = Array.from(slider.querySelectorAll(".swiper-slide--hidden"));

        if (more) {
            more.addEventListener("click", () => {
                slidesHidden.forEach(slide => {
                    slide.classList.remove("swiper-slide--hidden");
                });

                more.classList.add("faq-more--hidden");
            });
        }
    }
})
