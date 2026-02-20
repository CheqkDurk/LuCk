<?php
session_start();
$is_logged_in = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
$username = $is_logged_in ? $_SESSION['user'] : '';

if(isset($_GET['logout'])) {
    $_SESSION = array();
    session_destroy();
    header("Location: /juego/home.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LuCk - Juego de Blackjack Online</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <style>

        /* CONFIGURACIÓN GENERAL (Colores del Login) */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { 
            background-color: #0b0f14 !important; /* El mismo fondo oscuro */
            color: #ffffff;
            font-family: 'Segoe UI', Tahoma, sans-serif;
            min-height: 100vh;
        }

        /* HEADER */
        .site-header { 
            background-color: #121821 !important;
            padding: 20px 0;
            border-bottom: 2px solid #00ff99;
            box-shadow: 0 0 15px rgba(0, 255, 153, 0.1);
        }
        
        .header-content { 
            max-width: 1100px; 
            margin: 0 auto; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            padding: 0 20px;
        }

        .logo { color: #00ff99; font-size: 24px; font-weight: bold; text-decoration: none; }
        
        /* BOTONES ESTILO NEÓN */
        .btn-luck {
            background-color: #00ff99;
            color: #000 !important;
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            transition: 0.3s;
            border: none;
            display: inline-block;
        }

        .btn-luck:hover {
            background-color: #00cc77;
            transform: scale(1.05);
            box-shadow: 0 0 10px #00ff99;
        }

        /* SECCIÓN HERO */
        .hero-section {
            text-align: center;
            padding: 60px 20px;
        }

        .hero-section h1 {
            font-size: 4rem;
            color: #00ff99;
            text-shadow: 0 0 20px rgba(0, 255, 153, 0.4);
            font-weight: 900;
        }

        /* CONTENEDOR DE JUEGO / ACCESO */
        .game-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
        }

        .lock-card {
            background-color: #121821;
            border-radius: 15px;
            padding: 40px;
            text-align: center;
            border: 1px solid #333;
            box-shadow: 0 0 25px rgba(0, 255, 153, 0.1);
            margin-bottom: 40px;
        }

        .lock-card h1 { color: #00ff99; margin-bottom: 15px; }

        /* FILA DE CARACTERÍSTICAS (Reemplaza la tabla) */
        .features-row {
            display: flex;
            gap: 20px;
            margin-bottom: 40px;
        }

        .feature-box {
            flex: 1;
            background-color: #1a1f2b;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            border-bottom: 3px solid #00ff99;
        }

        .feature-box h3 { color: #00ff99; font-size: 1.2rem; margin-top: 10px; }
        .feature-box p { color: #ccc; font-size: 0.9rem; }

        /* BOTÓN INFERIOR */
        .footer-nav { text-align: center; margin-top: 20px; }
        .link-muted { color: #999; text-decoration: none; font-size: 0.9rem; }
        .link-muted:hover { color: #00ff99; }

        @media (max-width: 768px) {
            .features-row { flex-direction: column; }
        }
    </style>
</head>
<body>

    <header class="site-header">
        <div class="header-content">
            <a href="/index.php" class="logo">LuCk</a>
            <div class="auth-section">
                <?php if($is_logged_in): ?>
                    <span style="margin-right: 15px;">Hola, <b><?php echo htmlspecialchars($username); ?></b></span>
                    <a href="index.php" class="btn-luck">Jugar Ahora</a>
                    <a href="?logout=1" style="color: #ff4444; margin-left: 10px;">Salir</a>
                <?php else: ?>
                    <a href="/login.php" class="btn-luck">Iniciar Sesión</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <main class="game-container">
        <div class="hero-section">
            <h1>BLACKJACK</h1>
            <p>El juego de cartas más adictivo, ahora con el mejor estilo online.</p>
        </div>

        <?php if(!$is_logged_in): ?>
            <div class="lock-card">
                <h1>🔒 Acceso Exclusivo</h1>
                <p style="margin-bottom: 25px; color: #aaa;">Para apostar y ganar en grande, necesitas una cuenta.</p>
                <a href="/login.php" class="btn-luck">ENTRAR A JUGAR</a>
            </div>
        <?php endif; ?>

        <div class="features-row">
            <div class="feature-box">
                <h3>🎴 Juego Clásico</h3>
                <p>Reglas oficiales de casino.</p>
            </div>
            <div class="feature-box">
                <h3>💰 Apuestas</h3>
                <p>Multiplica tus fichas virtuales.</p>
            </div>
            <div class="feature-box">
                <h3>💳 Préstamos</h3>
                <p>¿Te quedaste a cero? Te ayudamos.</p>
            </div>
        </div>

        <div class="footer-nav">
            <a class="link-muted" href="/index.php">← Volver a la biblioteca de juegos</a>
        </div>
    </main>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
</body>
</html>