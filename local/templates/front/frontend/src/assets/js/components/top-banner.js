document.addEventListener("DOMContentLoaded", () => {
  const FIRST_VISIT = "FIRST_VISIT"
  const body = document.body
  const banner = document.querySelector(".banner")

  if (banner) {
    const closeBtn = banner.querySelector(".banner__btn")
    const isFirstVisit = localStorage.getItem(FIRST_VISIT)

    if (isFirstVisit) {
      banner.classList.remove("open")
      body.style.paddingTop = "0px"
    } else {
      body.style.paddingTop = `${banner.offsetHeight}px`
      banner.classList.add("open")
      window.scrollTo(0, 0)
      localStorage.setItem(FIRST_VISIT, "true")
      closeBtn.addEventListener("click", () => {
        body.style.paddingTop = "0px"
        banner.classList.remove("open")
      })
    }
  }
})
