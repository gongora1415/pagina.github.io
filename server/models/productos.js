let productos = [];

const grid = document.getElementById("gridProductos");
const categoria = document.getElementById("categoria");
const buscar = document.getElementById("buscar");

function cargarProductos() {
  fetch("productos.json?v=" + Date.now())
    .then(res => res.json())
    .then(data => {
      productos = data;
      renderProductos(productos);
    })
    .catch(err => console.error("Error:", err));
}

function renderProductos(lista) {
  grid.innerHTML = "";

  lista.forEach(p => {
    grid.innerHTML += `
      <a href="producto.html?id=${p.id}" class="card">
        <img src="${p.imagen}" alt="${p.nombre}">
        <h3>${p.nombre}</h3>
        <p>$${Number(p.precio).toLocaleString()}</p>
      </a>
    `;
  });
}

function filtrar() {
  const cat = categoria.value;
  const texto = buscar.value.toLowerCase();

 const filtrados = productos.filter(p =>
  (cat === "all" || p.categoria.startsWith(cat)) &&
  p.nombre.toLowerCase().includes(texto)
);


  renderProductos(filtrados);
}

categoria.addEventListener("change", filtrar);
buscar.addEventListener("keyup", filtrar);

document.addEventListener("DOMContentLoaded", cargarProductos);
