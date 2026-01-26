<?php
session_start();
$is_logged_in = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
$username = $is_logged_in ? $_SESSION['user'] : '';

if(isset($_GET['logout'])) {
    $_SESSION = array();
    session_destroy();
    header("Location: home.php");
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
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html, body { 
            margin: 0; 
            padding: 0; 
            background: linear-gradient(180deg, #071023 0%, #081428 100%) !important;
            color: #e6eef3;
            font-family: system-ui, -apple-system, Segoe UI, Roboto;
            min-height: 100vh;
        }
        /* HEADER */
        .site-header { 
            width: 100% !important;
            padding: 25px 0 !important;
            margin: 0 0 60px 0 !important;
            background: rgba(255,255,255,0.03) !important;
            border-bottom: 1px solid rgba(110,231,183,0.2) !important;
            box-shadow: 0 4px 20px rgba(2,6,23,0.6) !important;
        }
        .header-content { 
            max-width: 1200px; 
            margin: 0 auto !important;
            padding: 0 20px !important;
            display: flex; 
            justify-content: space-between;
            align-items: center;
            gap: 30px;
            flex-wrap: wrap;
        }
        .logo { font-size: 2rem; color: #6ee7b7; font-weight: bold; white-space: nowrap; }
        .auth-section { display: flex; gap: 12px; align-items: center; flex-wrap: wrap; }
        .welcome-msg { color: #6ee7b7; font-weight: bold; white-space: nowrap; }
        .btn { 
            padding: 8px 16px !important;
            border-radius: 6px !important;
            font-size: 0.9rem !important;
            text-decoration: none !important;
            display: inline-block !important;
        }
        .btn-primary { 
            background: #6ee7b7 !important;
            color: #0f1724 !important;
            border: none !important;
        }
        .btn-primary:hover { background: #5dd4a4 !important; }
        .btn-secondary {
            background: transparent !important;
            color: #6ee7b7 !important;
            border: 1px solid #6ee7b7 !important;
        }
        /* MAIN */
        main { 
            max-width: 1200px; 
            margin: 0 auto !important;
            padding: 0 20px 100px 20px !important;
            width: 100%;
        }
        .breadcrumb { 
            color: #6ee7b7; 
            font-size: 0.9rem; 
            margin: 0 0 50px 0 !important;
        }
        /* HERO */
        .hero-section { 
            text-align: center;
            margin-bottom: 80px;
            padding: 40px 0;
        }
        .hero-section h1 { 
            font-size: 3.5rem;
            color: #6ee7b7;
            margin: 0 0 20px 0 !important;
            text-shadow: 0 2px 10px rgba(110,231,183,0.3);
            font-weight: bold;
        }
        .hero-section p { 
            color: #9aa7b2;
            font-size: 1.2rem;
            margin: 0 !important;
        }
        /* GAME PREVIEW */
        .game-preview { 
            position: relative;
            background: rgba(11,18,32,0.6);
            border: 1px solid rgba(110,231,183,0.2);
            border-radius: 10px;
            padding: 50px;
            margin: 0 0 100px 0 !important;
            min-height: 450px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .restricted-overlay { 
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(15,23,36,0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            z-index: 10;
        }
        .restricted-content { text-align: center; }
        .restricted-icon { font-size: 4rem; margin-bottom: 20px; animation: bounce 2s infinite; }
        @keyframes bounce { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
        .restricted-content h3 { color: #6ee7b7; margin: 0 0 15px 0 !important; font-size: 1.5rem; font-weight: bold; }
        .restricted-content p { color: #9aa7b2; margin: 0 0 25px 0 !important; font-size: 1rem; }
        .play-btn { 
            background: #6ee7b7;
            color: #0f1724;
            padding: 12px 35px;
            border-radius: 8px;
            text-decoration: none !important;
            font-weight: bold;
            display: inline-block;
            font-size: 1rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .play-btn:hover { background: #5dd4a4; }
        #game { width: 100%; display: flex; flex-direction: column; gap: 40px; }
        #dealer, #player { text-align: center; }
        #dealer h3, #player h3 { 
            color: #9aa7b2; 
            margin: 0 0 20px 0 !important;
            font-size: 1.1rem;
            font-weight: 600;
        }
        #dhand, #phand { 
            display: flex;
            justify-content: center;
            gap: 15px;
            min-height: 100px;
            flex-wrap: wrap;
        }
        #money { 
            text-align: center;
            padding: 20px;
            background: rgba(110,231,183,0.1);
            border-radius: 8px;
            border: 1px solid rgba(110,231,183,0.3);
        }
        #cash, #bank { 
            display: block;
            font-size: 0.95rem;
            color: #6ee7b7;
            font-weight: bold;
            margin: 8px 0 !important;
        }
        /* FEATURES */
        .features { 
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 40px;
            margin: 0 0 100px 0 !important;
        }
        .feature-card { 
            background: rgba(11,18,32,0.6);
            border: 1px solid rgba(110,231,183,0.2);
            border-radius: 10px;
            padding: 40px 30px;
            text-align: center;
            transition: all 0.3s ease;
        }
        .feature-card:hover { 
            border-color: rgba(110,231,183,0.5);
            background: rgba(11,18,32,0.9);
            transform: translateY(-8px);
        }
        .feature-icon { font-size: 3.5rem; margin: 0 0 20px 0 !important; display: block; }
        .feature-card h4 { 
            color: #6ee7b7;
            margin: 0 0 15px 0 !important;
            font-size: 1.2rem;
            font-weight: 600;
        }
        .feature-card p { 
            color: #9aa7b2;
            font-size: 0.95rem;
            line-height: 1.6;
            margin: 0 !important;
        }
        /* CTA */
        .cta-section { 
            text-align: center;
            padding: 70px 40px;
            background: rgba(110,231,183,0.05);
            border: 1px solid rgba(110,231,183,0.2);
            border-radius: 12px;
            margin: 40px 0 0 0 !important;
        }
        .cta-section h2 { 
            color: #6ee7b7;
            font-size: 2.5rem;
            margin: 0 0 40px 0 !important;
            font-weight: bold;
        }
        .cta-buttons { 
            display: flex;
            gap: 25px;
            justify-content: center;
            flex-wrap: wrap;
        }
        .cta-btn { 
            padding: 16px 50px !important;
            border-radius: 8px;
            text-decoration: none !important;
            font-weight: bold;
            font-size: 1.05rem !important;
            display: inline-block !important;
            cursor: pointer;
        }
        .cta-btn-primary { 
            background: #6ee7b7 !important;
            color: #0f1724 !important;
        }
        .cta-btn-primary:hover { background: #5dd4a4 !important; }
        .cta-btn-secondary { 
            border: 2px solid #6ee7b7 !important;
            color: #6ee7b7 !important;
            background: transparent !important;
        }
        .cta-btn-secondary:hover { background: rgba(110,231,183,0.15) !important; }
        @media (max-width: 768px) {
            .hero-section h1 { font-size: 2.2rem; }
            .cta-section h2 { font-size: 1.8rem; }
            .game-preview { padding: 30px 20px; }
            main { padding: 0 15px 60px 15px !important; }
            .features { gap: 25px; grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="site-header">
        <div class="header-content">
            <h1 class="logo">🎮 LuCk</h1>
            <div class="auth-section">
                <?php if($is_logged_in): ?>
                    <span class="welcome-msg">¡Bienvenido, <strong><?php echo htmlspecialchars($username); ?></strong>!</span>
                    <a href="index.php" class="btn btn-primary">Jugar</a>
                    <a href="?logout=1" class="btn btn-secondary">Cerrar Sesión</a>
                <?php else: ?>
                    <a href="login.php" class="btn btn-primary">Iniciar Sesión</a>
                    <a href="login.php?register=1" class="btn btn-secondary">Registrarse</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <!-- Contenido principal -->
    <main>
        <!-- Breadcrumb -->
        <nav class="breadcrumb">
            <span>
                <a href="home.php" style="text-decoration: none; color: #6ee7b7;">Inicio</a>
            </span>
            <span style="margin: 0 8px;">»</span>
            <span style="color: #9aa7b2;">Blackjack</span>
        </nav>

        <!-- Sección Hero -->
        <div class="hero-section">
            <h1>🎰 BLACKJACK</h1>
            <p>El mejor juego de cartas en línea</p>
        </div>

        <!-- Vista previa del juego con juego restringido -->
        <div class="game-preview">
            <div class="restricted-overlay">
                <div class="restricted-content">
                    <div class="restricted-icon">🎮</div>
                    <h3>¡Acceso al Juego de Blackjack!</h3>
                    <a href="index.php" class="play-btn">Jugar</a>
                </div>
            </div>
            
            <div id="game" style="opacity: 0.3; pointer-events: none;">
                <div id="dealer">
                    <h3>Crupier</h3>
                    <div id="dhand"></div>
                </div>
                <div id="player">
                    <h3>Tu Mano</h3>
                    <div id="phand"></div>
                </div>
                <div id="money">
                    <span id="cash">Moni: $<span>0</span></span>
                    <div id="bank">Billetera: $<span>0</span></div>
                </div>
            </div>
        </div>

        <!-- Características -->
        <div class="features">
            <div class="feature-card">
                <span class="feature-icon">🎴</span>
                <h4>Juego Clásico</h4>
                <p>Disfruta del auténtico Blackjack con reglas estándar de casino</p>
            </div>
            <div class="feature-card">
                <span class="feature-icon">💰</span>
                <h4>Sistema de Apuestas</h4>
                <p>Gestiona tu dinero estratégicamente y aumenta tus ganancias</p>
            </div>
            <div class="feature-card">
                <span class="feature-icon">💳</span>
                <h4>Préstamos</h4>
                <p>Pide préstamos cuando lo necesites para seguir jugando</p>
            </div>
            <div class="feature-card">
                <span class="feature-icon">👤</span>
                <h4>Cuenta Personal</h4>
                <p>Tu perfil guardado con tus estadísticas de juego</p>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="cta-section">
            <h2>¿Listo para jugar?</h2>
            <div class="cta-buttons">
                <a href="index.php" class="cta-btn cta-btn-primary">Ir al Juego Ahora</a>
            </div>
        </div>
    </main>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
