
<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>

<html lang="es">
<head>
    

<meta charset="UTF-8">
<title>Panel Admin</title>

<a href="logout.php" class="btn-logout">Cerrar sesión</a>

<style>
body {
  font-family: Arial;
  background:#111;
  color:#fff;
  padding:30px;
}

.btn-logout{
  display:inline-block;
  background:#ff5252;
  color:#fff;
  padding:10px 18px;
  border-radius:25px;
  text-decoration:none;
  font-weight:bold;
  margin-bottom:20px;
}
.btn-logout:hover{
  background:#ff1744;
}

input, select, textarea, button {
  width:100%;
  padding:10px;
  margin:6px 0;
}

button {
  background:#4fc3f7;
  border:none;
  font-weight:bold;
  cursor:pointer;
}

.producto {
  background:#222;
  padding:15px;
  margin:10px 0;
  border-radius:10px;
}

.producto button {
  margin-top:8px;
}
</style>
</head>

<body>

<h1>📦 Panel de Productos</h1>

<h2>Agregar / Modificar</h2>

<form id="formProducto">
  <input type="hidden" id="id">

  <input id="nombre" placeholder="Nombre" required>
  <input id="precio" type="number" placeholder="Precio" required>

  <select id="categoria">
    <option value="paneles">Paneles</option>
    <option value="lamparas">Lámparas</option>
    <option value="baterias">Baterías</option>
  </select>

 <input type="file" id="imagen" accept="image/*">

  <textarea id="descripcion" placeholder="Descripción"></textarea>

  <button type="submit">Guardar</button>
</form>

<hr>

<h2>Productos existentes</h2>
<div id="lista"></div>

<script>
let productos = [];

function cargarProductos() {
  fetch("../productos.json")
    .then(res => res.json())
    .then(data => {
      productos = data;
      mostrarLista();
    });
}

function mostrarLista() {
  const lista = document.getElementById("lista");
  lista.innerHTML = "";

  productos.forEach(p => {
    lista.innerHTML += `
      <div class="producto">
        <strong>${p.nombre}</strong><br>
        $${Number(p.precio).toLocaleString()}<br>
        <button onclick="editar(${p.id})">Modificar</button>
        <button onclick="eliminar(${p.id})">Eliminar</button>
      </div>
    `;
  });
}

function editar(id) {
  const p = productos.find(x => x.id === id);
  if (!p) return;

  document.getElementById("id").value = p.id;
  nombre.value = p.nombre;
  precio.value = p.precio;
  categoria.value = p.categoria;
  descripcion.value = p.descripcion;

  // ⚠️ IMPORTANTE: no se puede prellenar un input file
  imagen.value = "";
}

function eliminar(id) {
  if (!confirm("¿Eliminar producto?")) return;

  const formData = new FormData();
  formData.append("borrar", id);

  fetch("guardar.php", {
    method: "POST",
    body: formData
  }).then(() => cargarProductos());
}

document.getElementById("formProducto").addEventListener("submit", e => {
  e.preventDefault();

  const formData = new FormData();
  formData.append("id", id.value);
  formData.append("nombre", nombre.value);
  formData.append("precio", precio.value);
  formData.append("categoria", categoria.value);
  formData.append("descripcion", descripcion.value);

  if (imagen.files[0]) {
    formData.append("imagen", imagen.files[0]);
  }

  fetch("guardar.php", {
    method: "POST",
    body: formData
  }).then(() => {
    e.target.reset();
    cargarProductos();
  });
});

cargarProductos();
</script>


</body>
</html>
