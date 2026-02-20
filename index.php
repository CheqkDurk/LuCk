<?php
session_start();

$is_logged_in = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;

if(!isset($_SESSION['cart'])){
    $_SESSION['cart'] = [];
}

if(isset($_POST['add_to_cart']) && $is_logged_in){
    $_SESSION['cart'][] = [
        "name" => $_POST['game'],
        "price" => floatval($_POST['price'])
    ];
    $showPopup = true;
}

if(isset($_GET['clear_cart'])){
    $_SESSION['cart'] = [];
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>LuCk Store</title>
<link rel="stylesheet" href="css.css">
</head>
<body>

<header>
    <h1>🎮 LUCK STORE</h1>

    <div class="top-right">
        <?php if($is_logged_in): ?>
            <span>👤 Sesión iniciada</span>
            <a href="logout.php" class="login-btn">Cerrar sesión</a>
        <?php else: ?>
            <a href="login.php" class="login-btn">Iniciar sesión</a>
        <?php endif; ?>
    </div>

    <a href="/juego/home.php" class="btn-blackjack">🃏 JUGAR BLACKJACK</a>
</header>

<!-- CARRITO -->
<div class="cart-floating" onclick="toggleCart()">
    🛒 <span><?php echo count($_SESSION['cart']); ?></span>
</div>

<div class="cart-panel" id="cartPanel">
    <div class="cart-header">
        <h3>Tu carrito</h3>
        <span class="close-cart" onclick="toggleCart()">✖</span>
    </div>

    <?php 
    $total = 0;
    foreach($_SESSION['cart'] as $item){
        echo "<p>{$item['name']} - {$item['price']}€</p>";
        $total += $item['price'];
    }
    ?>

    <hr>
    <strong>Total: <?php echo number_format($total,2); ?>€</strong>
    <br><br>

    <?php if($total > 0): ?>
        <a href="checkout.php" class="pay-btn">Processar el pagament</a>
    <?php endif; ?>

    <br><br>
    <a href="?clear_cart=true" class="clear-btn">Vaciar carrito</a>
</div>

<div class="games">

<!-- EJEMPLO FORMATO CORRECTO -->

<div class="game">
    <img src="https://imgs.search.brave.com/X0RzOhngnVc_WOWUo-0fFQZq9-5eum8Kimf7Qm7M4Eo/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly93YWxs/cGFwZXJzLmNvbS9p/bWFnZXMvZmVhdHVy/ZWQvcmVkLWRlYWQt/cmVkZW1wdGlvbi0y/LXBpY3R1cmVzLXoy/azltN2NvdnZuZ2xh/dG0uanBn">
    <div class="game-info">
        <h2>Red Dead Redemption 2</h2>
        <p>Obra maestra del salvaje oeste con mundo abierto realista.</p>
        <form method="POST">
            <input type="hidden" name="game" value="Red Dead Redemption 2">
            <input type="hidden" name="price" value="59.99">
            <?php if($is_logged_in): ?>
                <button type="submit" name="add_to_cart" class="buy-btn">
                    59.99€ - Añadir al carrito
                </button>
            <?php else: ?>
                <button type="button" class="buy-btn disabled">
                    Inicia sesión para comprar
                </button>
            <?php endif; ?>
        </form>
    </div>
</div>

<!-- COPIA ESTE BLOQUE PARA LOS DEMÁS JUEGOS CAMBIANDO NOMBRE, PRECIO E IMAGEN -->

</div>

<?php if(isset($showPopup)): ?>
<div class="popup show">
    ✅ Juego añadido correctamente
    <span onclick="closePopup()">✖</span>
</div>
<?php endif; ?>

<script>
function toggleCart(){
    document.getElementById("cartPanel").classList.toggle("active");
}
function closePopup(){
    document.querySelector(".popup").style.display="none";
}
</script>

</body>
</html>