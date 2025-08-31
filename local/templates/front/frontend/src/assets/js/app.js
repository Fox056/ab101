import $ from "jquery"
import "what-input"

window.jQuery = $
require("foundation-sites")

// плагины
require("@fancyapps/fancybox")

// компоненты
import "./components/burger-menu"
import "./components/forms"
import "./components/hover-block"
import "./components/slider"
import "./components/modal"
// import "./components/top-banner"
import "./components/tooltip"
import "./components/faq"

// страницы
import "./pages/main"

$(document).foundation()
