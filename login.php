<?php
session_start();

// Archivo de almacenamiento de usuarios
$users_file = __DIR__ . '/users.json';

// Cargar usuarios del archivo
function load_users() {
    global $users_file;
    if(file_exists($users_file)) {
        $data = json_decode(file_get_contents($users_file), true);
        return $data ? $data : [];
    }
    return [];
}

// Guardar usuarios en el archivo
function save_users($users) {
    global $users_file;
    file_put_contents($users_file, json_encode($users, JSON_PRETTY_PRINT));
}

// Usuarios por defecto
$default_users = [
    'player' => 'secret'
];

// Inicializar archivo si no existe
if(!file_exists($users_file)) {
    save_users($default_users);
}

$users = load_users();
$error = '';
$success = '';
$show_register = isset($_GET['register']) && $_GET['register'] == '1';

if(isset($_REQUEST['logout'])) {
    $_SESSION = array();
    session_destroy();
    header("Location: login.php");
    exit;
}

// Procesar registro
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'register') {
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $contrasenya = isset($_POST['contrasenya']) ? $_POST['contrasenya'] : '';
    $contrasenya_confirm = isset($_POST['contrasenya_confirm']) ? $_POST['contrasenya_confirm'] : '';
    
    // Validaciones
    if(empty($nombre)) {
        $error = 'El nombre de usuario no puede estar vacío';
    } elseif(strlen($nombre) < 3) {
        $error = 'El nombre debe tener al menos 3 caracteres';
    } elseif(strlen($nombre) > 20) {
        $error = 'El nombre no puede exceder 20 caracteres';
    } elseif(isset($users[$nombre])) {
        $error = 'Este nombre de usuario ya existe';
    } elseif(empty($contrasenya)) {
        $error = 'La contraseña no puede estar vacía';
    } elseif(strlen($contrasenya) < 4) {
        $error = 'La contraseña debe tener al menos 4 caracteres';
    } elseif($contrasenya !== $contrasenya_confirm) {
        $error = 'Las contraseñas no coinciden';
    } else {
        // Crear nuevo usuario
        $users[$nombre] = password_hash($contrasenya, PASSWORD_DEFAULT);
        save_users($users);
        $success = '¡Cuenta creada exitosamente! Ahora puedes iniciar sesión.';
        $show_register = false;
    }
}

// Procesar login
if($_SERVER['REQUEST_METHOD'] == 'POST' && (!isset($_POST['action']) || $_POST['action'] == 'login')) {
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
    $contrasenya = isset($_POST['contrasenya']) ? $_POST['contrasenya'] : '';
    
    // Verificar credenciales de usuarios registrados
    $user_found = false;
    foreach($users as $user => $pass) {
        if($user === $nombre && password_verify($contrasenya, $pass)) {
            $user_found = true;
            break;
        }
    }
    
    // Verificar usuarios por defecto (sin hash)
    if(!$user_found && $nombre === 'player' && $contrasenya === 'secret') {
        $user_found = true;
    }
    
    if($user_found) {
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
        
        .success {
            background: #d4edda;
            color: #155724;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
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
        
        <?php if(!empty($error)): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <?php if(!empty($success)): ?>
            <div class="success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>
        
        <?php if($show_register): ?>
            <!-- FORMULARIO DE REGISTRO -->
            <form method="POST" action="login.php">
                <input type="hidden" name="action" value="register">
                
                <div class="form-group">
                    <label for="nombre">Nombre de usuario:</label>
                    <input type="text" id="nombre" name="nombre" required placeholder="Min. 3 caracteres" value="<?php echo isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label for="contrasenya">Contraseña:</label>
                    <input type="password" id="contrasenya" name="contrasenya" required placeholder="Min. 4 caracteres">
                </div>
                
                <div class="form-group">
                    <label for="contrasenya_confirm">Confirmar contraseña:</label>
                    <input type="password" id="contrasenya_confirm" name="contrasenya_confirm" required placeholder="Repite tu contraseña">
                </div>
                
                <button type="submit">Crear Cuenta</button>
            </form>
            
            <div style="text-align: center; margin-top: 20px;">
                <p style="color: #666; margin-bottom: 10px;">¿Ya tienes cuenta?</p>
                <a href="login.php" style="color: #667eea; text-decoration: none; font-weight: bold;">Volver a Login</a>
            </div>
        <?php else: ?>
            <!-- FORMULARIO DE LOGIN -->
            <form method="POST" action="login.php">
                <input type="hidden" name="action" value="login">
                
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" required placeholder="Tu usuario">
                </div>
                
                <div class="form-group">
                    <label for="contrasenya">Contraseña:</label>
                    <input type="password" id="contrasenya" name="contrasenya" required placeholder="Tu contraseña">
                </div>
                
                <button type="submit">Entrar</button>
            </form>
            
            <div style="text-align: center; margin-top: 20px;">
                <p style="color: #666; margin-bottom: 10px;">¿No tienes cuenta?</p>
                <a href="login.php?register=1" style="color: #667eea; text-decoration: none; font-weight: bold;">Crear una nueva</a>
            </div>
            
        <?php endif; ?>
    </div>
</body>
</html>
