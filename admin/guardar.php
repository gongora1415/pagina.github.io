<?php
session_start();
if (!isset($_SESSION["admin"])) exit;

$file = "../productos.json";
$productos = file_exists($file)
  ? json_decode(file_get_contents($file), true)
  : [];

// BORRAR
if (isset($_POST["borrar"])) {
  $productos = array_values(array_filter($productos, fn($p) => $p["id"] != $_POST["borrar"]));
}

// AGREGAR / MODIFICAR
else {
  $id = $_POST["id"] ?: time();

  // BUSCAR PRODUCTO EXISTENTE
  $productoExistente = null;
  foreach ($productos as $p) {
    if ($p["id"] == $id) {
      $productoExistente = $p;
      break;
    }
  }

  // IMAGEN
  $imagen = $productoExistente["imagen"] ?? "uploads/default.png";

  if (!empty($_FILES["imagen"]["name"])) {
    $nombreImg = time() . "_" . basename($_FILES["imagen"]["name"]);
    $ruta = "../uploads/" . $nombreImg;
    move_uploaded_file($_FILES["imagen"]["tmp_name"], $ruta);
    $imagen = "uploads/" . $nombreImg;
  }

  $nuevo = [
    "id" => $id,
    "nombre" => $_POST["nombre"] ?? "",
    "precio" => intval($_POST["precio"] ?? 0),
    "categoria" => $_POST["categoria"] ?? "",
    "descripcion" => $_POST["descripcion"] ?? "",
    "imagen" => $imagen
  ];

  $actualizado = false;
  foreach ($productos as &$p) {
    if ($p["id"] == $id) {
      $p = $nuevo;
      $actualizado = true;
    }
  }

  if (!$actualizado) {
    $productos[] = $nuevo;
  }
}

file_put_contents(
  $file,
  json_encode($productos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
);
