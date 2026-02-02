<?php
session_start();
if (!isset($_SESSION["admin"])) exit;

$archivo = "../productos.json";
$productos = json_decode(file_get_contents($archivo), true);

unset($productos[$_GET["id"]]);

file_put_contents($archivo, json_encode(array_values($productos), JSON_PRETTY_PRINT));
header("Location: panel.php");
