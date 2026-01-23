<?php
session_start();

// Verificar si el usuario está logueado
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Procesar logout
if(isset($_GET['logout'])) {
    $_SESSION = array();
    session_destroy();
    header("Location: login.php");
    exit;
}

$username = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LuCk - Juego</title>
    <link rel="stylesheet" href="styles.css">
    <!-- Bootstrap CSS para los modales y popovers -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
    <!-- Header con autenticación -->
    <header class="site-header">
        <div class="header-content">
            <h1 class="logo">🎮 LuCk</h1>
            <div class="auth-section">
                <span id="user-display" class="welcome-msg">¡Bienvenido, <strong><?php echo htmlspecialchars($username); ?></strong>!</span>
                <a href="?logout=1" class="btn btn-secondary">Cerrar Sesión</a>
            </div>
        </div>
    </header>

    <!-- Contenido principal -->
    <main>
        <!-- Breadcrumb -->
        <nav class="breadcrumb" style="color: #9aa7b2; font-size: 0.9rem; margin-bottom: 20px;">
            <span style="display: inline-block;">
                <a href="index.php" style="text-decoration: none; color: #6ee7b7;">Inicio</a>
            </span> 
            <span style="margin: 0 8px;">»</span>
            <span style="display: inline-block; color: #9aa7b2;">Blackjack</span>
        </nav>

        <!-- Título principal -->
        <div style="text-align: center; margin-bottom: 30px;">
            <h1 class="entry-title" style="font-size: 2.5rem; color: #6ee7b7; margin: 0; text-shadow: 0 2px 10px rgba(110, 231, 183, 0.3);">🎰 BLACKJACK</h1>
            <p style="color: #9aa7b2; margin-top: 8px; font-size: 0.95rem;">Juega contra el crupier. ¡Intenta sumar 21!</p>
        </div>

        <!-- BLACKJACK GAME CONTAINER -->
                    <div id="wrapper">
                        <div id="game">
                            <div id="alert" class="alert alert-error hide"><span></span></div>
                            <div id="dealer">
                                <div id="dhand"></div>
                            </div>
                            <div id="player">
                                <div id="phand"></div>
                            </div>
                            <div id="money" style="text-align: center; padding: 8px 12px; background: rgba(110, 231, 183, 0.1); border-radius: 6px; margin-bottom: 15px; border: 1px solid rgba(110, 231, 183, 0.3);">
                                <span id="cash" style="display: block; font-size: 12px; color: #6ee7b7; font-weight: bold; margin: 0;">Moni: $<span></span></span>
                                <div id="bank" style="display: block; font-size: 12px; color: #6ee7b7; font-weight: bold; margin: 0;">Billetera: $<span></span></div>
                            </div>
                        </div>
                        <div id="actions">
                            <button id="deal" class="btn">Deal</button>
                            <button id="hit" class="btn" disabled>Hit</button>
                            <button id="stand" class="btn" disabled>Stand</button>
                            <button id="double" class="btn" disabled>Double Down</button>
                            <button id="split" class="btn" disabled>Split</button>
                            <button id="insurance" class="btn" disabled>Insurance</button>
                            <button id="loan" class="btn">💰 Pedir Préstamo</button>
                            <div style="background: #6ee7b7; padding: 10px 15px; border-radius: 8px; display: inline-block; margin-top: 15px;">
                                <label for="wager" style="color: #0f1724; font-weight: bold; font-size: 14px; margin: 0; margin-right: 8px; display: inline-block;">💵 APUESTA:</label>
                                <span style="color: #0f1724; font-size: 14px; font-weight: bold;">$</span><input id="wager" type="text" style="width: 80px; padding: 6px 8px; font-size: 14px; font-weight: bold; border: 2px solid #0f1724; border-radius: 5px; background: rgba(15, 23, 36, 0.1); color: #0f1724; text-align: center;" placeholder="100" />
                            </div>
                        </div>
                    </div>
                    <div id="myModal" class="modal hide fade" data-backdrop="false">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 id="modalTitle">¡Sin dinero!</h3>
                        </div>
                        <div class="modal-body">
                            <p id="modalDescription">Te has quedado sin dinero para jugar. ¿Deseas pedir un préstamo a la banca para continuar?</p>
                            <p style="font-weight: bold; color: #666;">Préstamo máximo disponible: <span id="maxLoanDisplay">$20,000</span></p>
                            <div style="margin-top: 20px;">
                                <div style="margin-bottom: 10px;">
                                    <input type="radio" id="loan100" name="loanAmount" value="100"> <label for="loan100">$100</label>
                                </div>
                                <div style="margin-bottom: 10px;">
                                    <input type="radio" id="loan1000" name="loanAmount" value="1000" checked> <label for="loan1000">$1,000</label>
                                </div>
                                <div style="margin-bottom: 10px;">
                                    <input type="radio" id="loan10000" name="loanAmount" value="10000"> <label for="loan10000">$10,000</label>
                                </div>
                                <div style="margin-bottom: 10px;">
                                    <input type="text" id="customLoan" placeholder="Cantidad personalizada" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                                    <small style="color: #999;">O ingresa una cantidad personalizada (máx. $20,000)</small>
                                </div>
                            </div>
                            <div style="margin-top: 15px; padding: 10px; background: #fff3cd; border-left: 4px solid #ffc107; border-radius: 4px;">
                                <p style="margin: 0; font-size: 0.9rem; color: #856404;"><strong>⚠️ Nota:</strong> Los préstamos deben ser devueltos con intereses.</p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="#" id="cancel" class="btn">Cancelar</a>
                            <a href="#" id="newGame" class="btn btn-primary">Pedir Préstamo</a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- jQuery para Blackjack -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Bootstrap JS para modales y popovers -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- Blackjack Game Script -->
    <script src="blackjack.js"></script>
</body>
</html>
