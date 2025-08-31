//получить ширину скроллбара
export function getScrollbarWidth() {
  const scrollDiv = document.createElement("div")
  scrollDiv.style.overflowY = "scroll"
  scrollDiv.style.width = "50px"
  scrollDiv.style.height = "50px"
  document.body.append(scrollDiv)
  const scrollbarWidth = scrollDiv.offsetWidth - scrollDiv.clientWidth
  scrollDiv.remove()

  return scrollbarWidth
}

export function lockBody() {
  const body = document.querySelector("body")
  body.classList.add("lock")
  body.style.paddingRight = `${getScrollbarWidth()}px`
}

export function unlockBody() {
  const body = document.querySelector("body")
  body.classList.remove("lock")
  body.style.paddingRight = "0px"
}

export function offset(el) {
  const rect = el.getBoundingClientRect(),
    scrollLeft = window.pageXOffset || document.documentElement.scrollLeft,
    scrollTop = window.pageYOffset || document.documentElement.scrollTop;
  return { top: rect.top + scrollTop, left: rect.left + scrollLeft }
}

export function handleMessageOfError(el, message = "Произошла ошибка!") {
  el.classList.add("error")
  el.innerHTML = message
}

function handleMessageOfSuccess(el, message = "Сообщение успешно отправлено!") {
  el.classList.remove("error")
  el.innerHTML = message
}

export function formSubmit(url, body, elementForResponse) {
  fetch(url, {
    method: "POST",
    body,
    headers: {
      "Content-Type": "application/json"
    }
  })
    .then(response => {
      if (!response.ok) {
        handleMessageOfError(elementForResponse)
      }
      return response.json()
    })
    .then(data => {
      if (data.status) {
        handleMessageOfSuccess(elementForResponse)
      } else {
        handleMessageOfError(elementForResponse)
      }
    })
    .catch(error => {
      handleMessageOfError(elementForResponse)
    })
}