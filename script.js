document.querySelectorAll("[data-slider]").forEach(slider => {

    const track = slider.querySelector(".slider-track");
    const imgs = track.querySelectorAll("img");

    const imgWidth = 200;
    const gap = 30;
    const visible = 3;

    const step = imgWidth + gap;
    const max = imgs.length - visible;

    let index = 0;

    slider.querySelectorAll(".flecha").forEach(btn => {
        btn.addEventListener("click", () => {

            const dir = parseInt(btn.dataset.dir);
            index += dir;

            if (index < 0) index = 0;
            if (index > max) index = max;

            track.style.transform = `translateX(${-index * step}px)`;
        });
    });

});



window.addEventListener("scroll", () => {
    const barra = document.querySelector(".barra");

    if (window.scrollY > 50) {
        barra.classList.add("scrolled");
    } else {
        barra.classList.remove("scrolled");
    }
});



const escena = document.getElementById('escena-farola');

const observer = new IntersectionObserver(
  ([entry]) => {
    if (entry.isIntersecting) {
      escena.classList.add('activa');
    }
  },
  { threshold: 0.4 }
);

observer.observe(escena);

