<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit;
}

$productos = json_decode(file_get_contents("../productos.json"), true);
?>

<h2>Productos</h2>

<form action="guardar.php" method="POST">
    <input name="nombre" placeholder="Nombre" required>
    <input name="precio" placeholder="Precio" required>
    <input name="categoria" placeholder="Categoria" required>
    <input name="imagen" placeholder="Ruta imagen (img/...)">
    <textarea name="descripcion" placeholder="Descripción"></textarea>
    <button>Agregar producto</button>
</form>

<hr>

<?php foreach ($productos as $i => $p): ?>
    <div>
        <strong><?= $p["nombre"] ?></strong>
        <a href="borrar.php?id=<?= $i ?>">❌ Borrar</a>
    </div>
<?php endforeach; ?>
