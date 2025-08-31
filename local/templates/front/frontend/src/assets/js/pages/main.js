// import WOW from "wowjs/dist/wow"
import {formSubmit, handleMessageOfError} from "../lib/helpers"
import 'simplebar'; // or "import SimpleBar from 'simplebar';" if you want to use it manually.

document.addEventListener("DOMContentLoaded", () => {
  //инициализация анимаций
  // new WOW.WOW().init()

  //аккордеон
  const accs = document.querySelectorAll(".accordion__item")
  accs.forEach(acc => {
    const title = acc.querySelector(".accordion__title")
    title.addEventListener("click", () => {
      acc.classList.toggle("active")
      const body = acc.querySelector(".accordion__body")
      if (body.style.maxHeight) {
        body.style.maxHeight = null
      } else {
        body.style.maxHeight = `${body.scrollHeight}px`
      }
    })
  })

  //отправка формы
  const form = document.querySelector(".form")

  if (form) {
    const formInput = document.querySelector(".form__input")
    const formField = form.querySelector(".form__field")
    const formMessage = form.querySelector(".form__message")

    formInput.addEventListener("input", (e) => {
      if (e.target.value.length > 0 && formField.classList.contains("error")) {
        formField.classList.remove("error")
        formMessage.innerHTML = ""
      }
    })

    form.addEventListener("submit", function (e) {
      e.preventDefault()
      formMessage.innerHTML = ""
      formMessage.classList.remove("error")

      const message = formInput.value

      if (message.length > 0) {
        formSubmit(form.action, JSON.stringify({message}), formMessage)
        formField.classList.remove("error")
      } else {
        formField.classList.add("error")
        handleMessageOfError(formMessage, "Введите сообщение!")
      }
    })
  }

  //анимация заголовков, которые не помещаются в контейнер
  const titles = document.querySelectorAll(".section__title")
  const arrTimer = []
  function animateBigTitle(title) {
    let animTimer
    title.style.transform = `translateX(0)`
    const scrollWidth = title.scrollWidth
    const offsetWidth = title.offsetWidth
    if (scrollWidth > offsetWidth) {
      let f = true
      animTimer = setInterval(() => {
        if (f) {
          title.style.transform = `translateX(-${scrollWidth - offsetWidth}px)`
          f = false
        } else {
          title.style.transform = `translateX(0)`
          f = true
        }
      }, 2500)
      arrTimer.push(animTimer)
    } else {
      title.style.transform = `translateX(0)`
    }
  }

  titles.forEach(title => {
    animateBigTitle(title)
  })

  window.addEventListener("resize", () => {
    arrTimer.forEach(t => clearInterval(t))
    titles.forEach(title => {
      animateBigTitle(title)
    })
  })

  // год в футере
  const footerYearHosts = document.querySelectorAll("[data-year]")
  if (footerYearHosts.length) {
    footerYearHosts.forEach(year => {
      year.textContent = new Date().getFullYear().toString();
    })
  }

  // таблица-аккордеон
  const workTableHost = document.querySelector(".work-table")
  if (workTableHost) {
    const blockTriggers = workTableHost.querySelectorAll(".work-table__trigger");
    blockTriggers.forEach(trigger => {
      trigger.addEventListener("click", (e) => {
        trigger.parentElement.classList.toggle("active");
      })
    })
  }

  const whyTableHost = document.querySelector(".why-table")
  if (whyTableHost) {
    const blockTrigger = whyTableHost.querySelectorAll(".why-table__trigger");
    blockTrigger.forEach(trigger => {
      trigger.addEventListener("click", (e) => {
        trigger.parentElement.classList.toggle("active");
      })
    })

    const loadButton = whyTableHost.querySelector("[data-why-load]")
    const hiddenBlock = whyTableHost.querySelector("[data-why-hidden]")
    loadButton.addEventListener("click", () => {
      hiddenBlock.classList.toggle("hidden");
      loadButton.remove();
    })
  }
})
