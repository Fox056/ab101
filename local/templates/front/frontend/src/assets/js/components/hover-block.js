import hoverEffect from "hover-effect"

document.addEventListener("DOMContentLoaded", () => {
  // const path = process.env.NODE_ENV === "development"
  //   ? "/assets/img/heightMap.png"
  //   : "/local/templates/front/frontend/dist/assets/img/heightMap.png";

  function hover(parent, image1, image2) {
    if (parent) {
      new hoverEffect({
        parent,
        intensity: 0.3,
        image1,
        image2,
        displacementImage: "/local/templates/front/frontend/dist/assets/img/heightMap.png",
        imagesRatio: 500 / 800
      })
    }
  }

  const hoverBlock = document.querySelectorAll(".hover-block")

  if (hoverBlock.length > 0) {
    hoverBlock.forEach(el => {
      const image1 = el.dataset.image1
      const image2 = el.dataset.image2
      hover(el, image1, image2)
    })
  }
})