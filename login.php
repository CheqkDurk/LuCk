<?php
session_start();

const USER_OK = 'player';
const PASS_OK = 'secret123';

if (!empty($_GET['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit;
}

if (!empty($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['user'] ?? '';
    $pass = $_POST['pass'] ?? '';

    if ($user === USER_OK && $pass === PASS_OK) {
        $_SESSION['loggedin'] = true;
        $_SESSION['user'] = $user;
        header('Location: index.php');
        exit;
    }

    $error = 'Usuario o contraseña incorrectos';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - LuCk</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .login-container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 350px;
        }
        h1 { text-align: center; color: #333; margin-bottom: 30px; }
        input { 
            width: 100%; 
            padding: 12px; 
            border: 2px solid #ddd; 
            border-radius: 5px; 
            margin-bottom: 15px; 
            box-sizing: border-box;
        }
        input:focus { border-color: #667eea; outline: none; }
        button { 
            width: 100%; 
            padding: 12px; 
            background: #667eea; 
            color: white; 
            border: none; 
            border-radius: 5px; 
            font-size: 16px; 
            cursor: pointer;
        }
        button:hover { background: #764ba2; }
        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>LuCk</h1>
        
        <form method="POST">
            <input type="text" name="user" placeholder="Usuario" required>
            <input type="password" name="pass" placeholder="Contraseña" required>
            <button type="submit">Entrar</button>
        </form>
        
    </div>
</body>
</html>
