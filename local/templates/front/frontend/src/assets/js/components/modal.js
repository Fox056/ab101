import { getScrollbarWidth, lockBody, unlockBody } from "../lib/helpers"

document.addEventListener("DOMContentLoaded", () => {
  const html = document.querySelector("html")
  const modal = document.querySelector(".modal")

  if (modal) {
    const openBtn = document.querySelector(".hero__btn")

    if (openBtn) {
      openBtn.addEventListener("click", () => {
        modal.classList.add("open")
        html.classList.add("lock")
        lockBody()
      })
    }

    modal.addEventListener("click", (event) => {
      const links = document.querySelectorAll(".modal__link")
      if (!event.target.closest(".modal__content") || [...links].includes(event.target)) {
        modal.classList.remove("open")
        html.classList.remove("lock")
        unlockBody()
      }
    })
  }
})
