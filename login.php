<?php
session_start();

$nombre_valido = 'player';
$contrasenya_valida = 'secret';

if(isset($_REQUEST['logout'])) {
    $_SESSION = array();
    session_destroy();
    header("Location: login.php");
    exit;
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = isset($_REQUEST['nombre']) ? $_REQUEST['nombre'] : '';
    $contrasenya = isset($_REQUEST['contrasenya']) ? $_REQUEST['contrasenya'] : '';
    
    if($nombre === $nombre_valido && $contrasenya === $contrasenya_valida) {
        $_SESSION['user'] = $nombre;
        $_SESSION['loggedin'] = true;
        header("Location: index.php");
        exit;
    } else {
        $error = "Nombre o contraseña incorrectos";
    }
}

if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - LuCk</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        
        .login-container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }
        
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
            font-size: 28px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: bold;
        }
        
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        
        input[type="text"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #667eea;
        }
        
        button {
            width: 100%;
            padding: 12px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
        }
        
        button:hover {
            background: #764ba2;
        }
        
        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
        }
        
        .info {
            background: #d1ecf1;
            color: #0c5460;
            padding: 12px;
            border-radius: 5px;
            margin-top: 20px;
            border: 1px solid #bee5eb;
            font-size: 13px;
        }
        
        .info strong {
            display: block;
            margin-bottom: 8px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>🎮 LuCk</h1>
        
        <?php if(isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required placeholder="Escribe: player">
            </div>
            
            <div class="form-group">
                <label for="contrasenya">Contraseña:</label>
                <input type="password" id="contrasenya" name="contrasenya" required placeholder="Escribe: secret">
            </div>
            
            <button type="submit">Entrar</button>
        </form>
        
        <div class="info">
            <strong>Credenciales:</strong>
            player / secret
        </div>
    </div>
</body>
</html>
