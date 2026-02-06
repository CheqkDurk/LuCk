<?php
session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: home.php");
    exit;
}

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
            <h1 class="logo">LuCk</h1>
            <div class="auth-section">
                <span id="user-display" class="welcome-msg">¡Bienvenido, <strong><?php echo htmlspecialchars($username); ?></strong>!</span>
                <a href="home.php?logout=1" class="btn btn-secondary">Cerrar Sesión</a>
            </div>
        </div>
    </header>

    <!-- Contenido principal -->
    <main>
        <!-- Breadcrumb -->
        <nav class="breadcrumb" style="color: #9aa7b2; font-size: 0.9rem; margin-bottom: 20px;">
            <span style="display: inline-block;">
            <span style="display: inline-block; color: #9aa7b2;">Inicio</span>
            </span> 
            <span style="margin: 0 8px;">»</span>
            <span style="display: inline-block; color: #6ee7b7;">Blackjack</span>
        </nav>

<script>
// Script para actualizar estadísticas en tiempo real
function updateStatsPanel() {
    const stats = JSON.parse(localStorage.getItem('blackjack_stats') || '{}');
    
    $('#current-cash').text('$' + (player?.getCashRaw?.() || 1000).toLocaleString());
    $('#win-count').text(stats.gamesWon || 0);
    $('#loss-count').text(stats.gamesLost || 0);
    $('#win-streak').text(stats.currentStreak || 0);
}

// Actualizar cada segundo
setInterval(updateStatsPanel, 1000);
</script>

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
                            <button id="loan" class="btn">💰 Pedir Préstamo</button>
                            <button id="repay" class="btn" style="background: #ff6b6b; border-color: #ff6b6b;">📊 Devolver Préstamo</button>
                            <div style="background: #6ee7b7; padding: 10px 15px; border-radius: 8px; display: inline-block; margin-top: 15px;">
                                <label for="wager" style="color: #0f1724; font-weight: bold; font-size: 14px; margin: 0; margin-right: 8px; display: inline-block;">💵 APUESTA:</label>
                                <span style="color: #0f1724; font-size: 14px; font-weight: bold;">$</span><input id="wager" type="text" style="width: 80px; padding: 6px 8px; font-size: 14px; font-weight: bold; border: 2px solid #0f1724; border-radius: 5px; background: rgba(15, 23, 36, 0.1); color: #0f1724; text-align: center;" placeholder="100" />
                            </div>
                        </div>
                    </div>
                    <div id="myModal" class="modal fade" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="modalTitle">¡Sin dinero!</h4>
                                </div>
                                <div class="modal-body">
                                    <p id="modalDescription">Te has quedado sin dinero para jugar. ¿Deseas pedir un préstamo a la banca para continuar?</p>
                                    <p style="font-weight: bold; color: #666;">Préstamo máximo disponible: <span id="maxLoanDisplay">$20,000</span></p>
                                    <div style="margin-top: 20px;">
                                        <div style="margin-bottom: 10px; display: flex; align-items: center;">
                                            <input type="radio" id="loan100" name="loanAmount" value="100"> <label for="loan100" style="margin-left: 8px; margin-bottom: 0;">$100</label>
                                        </div>
                                        <div style="margin-bottom: 10px; display: flex; align-items: center;">
                                            <input type="radio" id="loan1000" name="loanAmount" value="1000" checked> <label for="loan1000" style="margin-left: 8px; margin-bottom: 0;">$1,000</label>
                                        </div>
                                        <div style="margin-bottom: 10px; display: flex; align-items: center;">
                                            <input type="radio" id="loan10000" name="loanAmount" value="10000"> <label for="loan10000" style="margin-left: 8px; margin-bottom: 0;">$10,000</label>
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
                                    <button type="button" class="btn btn-default" id="cancel" data-dismiss="modal">Cancelar</button>
                                    <button type="button" class="btn btn-primary" id="newGame">Pedir Préstamo</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal para Devolver Préstamo -->
                    <div id="repayModal" class="modal fade" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">💳 Devolver Préstamo</h4>
                                </div>
                                <div class="modal-body">
                                    <p id="loanStatusMessage">No tienes préstamos pendientes.</p>
                                    <div id="repayLoanContent" style="display: none;">
                                        <div style="background: #f0f0f0; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                                            <p style="margin: 0 0 8px 0; color: #666;"><strong>Deuda Total:</strong></p>
                                            <p style="margin: 0; font-size: 1.3rem; color: #ff6b6b;"><strong>$<span id="totalDebt">0</span></strong></p>
                                            <p style="margin: 5px 0 0 0; font-size: 0.9rem; color: #999;"><span id="debtBreakdown"></span></p>
                                        </div>
                                        <p style="font-weight: bold; color: #333; margin-bottom: 10px;">Monto a devolver:</p>
                                        <div style="margin-bottom: 20px;">
                                            <div style="margin-bottom: 10px; display: flex; align-items: center;">
                                                <input type="radio" id="repay50" name="repayAmount" value="percent50"> <label for="repay50" style="margin-left: 8px; margin-bottom: 0;">50% de la deuda</label>
                                            </div>
                                            <div style="margin-bottom: 10px; display: flex; align-items: center;">
                                                <input type="radio" id="repay100" name="repayAmount" value="percent100" checked> <label for="repay100" style="margin-left: 8px; margin-bottom: 0;">100% de la deuda (Pago Completo)</label>
                                            </div>
                                            <div style="margin-bottom: 10px; display: flex; align-items: center;">
                                                <input type="radio" id="repayCustom" name="repayAmount" value="custom"> <label for="repayCustom" style="margin-left: 8px; margin-bottom: 0;">Cantidad personalizada:</label>
                                            </div>
                                            <div style="margin-left: 25px;">
                                                <input type="text" id="customRepayAmount" placeholder="Cantidad" style="width: 100px; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                                            </div>
                                        </div>
                                        <div style="background: #e8f5e9; padding: 10px; border-left: 4px solid #4caf50; border-radius: 4px;">
                                            <p style="margin: 0; font-size: 0.9rem; color: #2e7d32;"><strong>✓ A Pagar:</strong> $<span id="repayAmount">0</span></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                    <button type="button" class="btn btn-danger" id="confirmRepay" style="display: none;">Confirmar Devolución</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal de Expulsión del Jefe -->
                    <div id="bossModal" class="modal fade" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content" style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); border: 3px solid #ff3333; border-radius: 0;">
                                <div class="modal-header" style="background: #ff3333; border-bottom: 3px solid #cc0000; border-radius: 0;">
                                    <h4 class="modal-title" style="color: white; font-weight: bold; font-size: 1.5rem;">👔 EL JEFE</h4>
                                </div>
                                <div class="modal-body" style="text-align: center; padding: 40px 20px;">
                                    <div style="font-size: 4rem; margin-bottom: 20px; animation: shake 0.5s;">👿</div>
                                    <h3 style="color: #ff3333; margin-bottom: 20px; font-weight: bold;">¡FUERA DE AQUÍ!</h3>
                                    <p style="color: #fff; font-size: 1.1rem; margin-bottom: 20px; line-height: 1.6;">
                                        <strong>Te has quedado sin dinero.</strong><br>
                                        Has perdido TODO lo que tenías, incluyendo el préstamo que te di.<br><br>
                                        <span style="color: #ff6666;">No vuelvas hasta que tengas dinero para jugar limpio.</span>
                                    </p>
                                    <div style="background: rgba(255, 51, 51, 0.2); border-left: 4px solid #ff3333; padding: 15px; margin: 20px 0; border-radius: 4px;">
                                        <p style="margin: 0; color: #ffaaaa; font-weight: bold;">💀 DEBES PAGAR LO QUE DEBES</p>
                                    </div>
                                </div>
                                <div class="modal-footer" style="border-top: 3px solid #ff3333; background: #1a1a1a;">
                                    <button type="button" class="btn btn-danger" id="exitGame" style="background: #ff3333; border-color: #cc0000;">Abandonar Juego</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <style>
                        @keyframes shake {
                            0%, 100% { transform: translateX(0); }
                            25% { transform: translateX(-10px); }
                            75% { transform: translateX(10px); }
                        }
                    </style>

    <!-- jQuery para Blackjack -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Bootstrap JS para modales y popovers -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- Blackjack Game Script -->
    <script src="blackjack.js"></script>
</body>
</html>
