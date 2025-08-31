import { offset } from "../lib/helpers"

document.addEventListener("DOMContentLoaded", () => {

  document.addEventListener("click", (event) => {
    const target = event.target
    const tooltipHtml = target.dataset.myTooltip
    const tooltipColor = target.dataset.tooltipColor
    const tooltipRotate = target.dataset.tooltipRotate

    const el = document.querySelectorAll(".tooltip")
    if (el.length > 0) {
      el.forEach(i => i.remove())
    }

    if (!tooltipHtml) {
      return
    }

    event.preventDefault()

    const tooltipElem = document.createElement("div")
    tooltipElem.className = `tooltip ${tooltipColor && "tooltip--white"} ${tooltipRotate && "tooltip--rotate"}`
    tooltipElem.innerHTML = tooltipHtml
    document.body.append(tooltipElem)

    const coords = offset(target)
    let left = coords.left + (target.offsetWidth - tooltipElem.offsetWidth) / 2
    if (left < 0) left = 0
    let top = coords.top - tooltipElem.offsetHeight - 10
    if (top < 0) top = coords.top + target.offsetHeight + 10

    if (tooltipRotate) {
      left -=70
      top +=70
    }

    tooltipElem.style.left = left + "px"
    tooltipElem.style.top = top + "px"
  })
})
