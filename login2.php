<?php
session_start();

$usuario_correcto = ["admin", "player"];
$password_correcta = ["1234", "secret123"];

$usuario = $_POST['usuario'] ?? '';
$password = $_POST['password'] ?? '';

if (in_array($usuario, $usuario_correcto) && in_array($password, $password_correcta)) {
    $_SESSION['loggedin'] = true;
    $_SESSION['user'] = $usuario;
    
    header("Location: index.php"); 
    exit;
} else {
    echo "<h2 style='color:red;text-align:center;'>❌ Usuario o contraseña incorrectos</h2>";
    echo "<p style='text-align:center;'><a href='login.php'>Volver</a></p>";
}
?>