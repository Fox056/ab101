// import { lockBody, unlockBody } from "../lib/helpers"
import openNav from "../common/openNav.js";

document.addEventListener("DOMContentLoaded", () => {
  const burger = document.querySelector(".burger")
  const menu = document.querySelector(".menu")
  const links = menu.querySelectorAll(".menu__link")

  burger.addEventListener("click", () => {
    openNav();
  });

  links.forEach(link => {
    link.addEventListener("click", () => {
      openNav();
    })
  })
})
