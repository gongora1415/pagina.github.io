<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user = $_POST["user"];
    $pass = $_POST["pass"];

    if ($user === "admin" && $pass === "1234") {
        $_SESSION["admin"] = true;
        header("Location: admin.php");
        exit;
    }

    $error = "Datos incorrectos";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Login Admin</title>

<style>
body{
  background:#111;
  color:#fff;
  font-family:Arial;
  display:flex;
  align-items:center;
  justify-content:center;
  height:100vh;
}
form{
  background:#222;
  padding:30px;
  border-radius:15px;
  width:300px;
}
input,button{
  width:100%;
  padding:10px;
  margin:8px 0;
}
button{
  background:#4fc3f7;
  border:none;
  font-weight:bold;
}
</style>
</head>

<body>

<form method="POST">
  <h2>🔐 Admin</h2>

  <?php if(isset($error)) echo "<p style='color:red'>$error</p>"; ?>

  <input name="user" placeholder="Usuario" required>
  <input name="pass" type="password" placeholder="Contraseña" required>
  <button>Entrar</button>
</form>

</body>
</html>
