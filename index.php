<?php
session_start();

if (isset($_GET['logout'])) {
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }
    session_destroy();
    header('Location: index.php');
    exit;
}

$is_logged_in = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;

function normalize_cart(){
    if(!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])){
        $_SESSION['cart'] = [];
        return;
    }
    // detect legacy numeric array with ['name','price'] entries
    $legacy = false;
    foreach($_SESSION['cart'] as $k => $v){
        if(is_int($k) || isset($v['name'])){ $legacy = true; break; }
    }
    if($legacy){
        $new = [];
        foreach($_SESSION['cart'] as $it){
            if(!isset($it['name'])) continue;
            $name = $it['name'];
            $price = floatval($it['price']);
            if(isset($new[$name])) $new[$name]['qty'] += 1;
            else $new[$name] = ['price' => $price, 'qty' => 1];
        }
        $_SESSION['cart'] = $new;
    }
}

normalize_cart();

// AJAX handlers: add / remove_one / clear
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && isset($_POST['ajax'])){
    normalize_cart();
    $action = $_POST['action'];
    if($action === 'add' && $is_logged_in){
        $g = $_POST['game'] ?? '';
        $p = isset($_POST['price']) ? floatval($_POST['price']) : 0;
        if($g !== ''){
            if(isset($_SESSION['cart'][$g])) $_SESSION['cart'][$g]['qty'] += 1;
            else $_SESSION['cart'][$g] = ['price' => $p, 'qty' => 1];
        }
    } elseif($action === 'remove_one'){
        $g = $_POST['game'] ?? '';
        if($g !== '' && isset($_SESSION['cart'][$g])){
            $_SESSION['cart'][$g]['qty'] -= 1;
            if($_SESSION['cart'][$g]['qty'] <= 0) unset($_SESSION['cart'][$g]);
        }
    } elseif($action === 'clear'){
        $_SESSION['cart'] = [];
    }

    $items = [];
    $total = 0;
    $count = 0;
    foreach($_SESSION['cart'] as $name => $it){
        $items[] = ['name' => $name, 'price' => $it['price'], 'qty' => $it['qty']];
        $total += $it['price'] * $it['qty'];
        $count += $it['qty'];
    }
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'items' => $items, 'total' => number_format($total,2,'.',''), 'count' => $count]);
    exit;
}

// Legacy POST from non-AJAX forms (kept for fallback)
if(isset($_POST['add_to_cart']) && $is_logged_in){
    $g = $_POST['game'] ?? '';
    $p = isset($_POST['price']) ? floatval($_POST['price']) : 0;
    if($g !== ''){
        if(isset($_SESSION['cart'][$g])) $_SESSION['cart'][$g]['qty'] += 1;
        else $_SESSION['cart'][$g] = ['price' => $p, 'qty' => 1];
    }
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
            <a href="?logout=1" class="login-btn">Cerrar sesión</a>
        <?php else: ?>
            <a href="login.php" class="login-btn">Iniciar sesión</a>
        <?php endif; ?>
    </div>

    <a href="/juego/home.php" class="btn-blackjack">🃏 JUGAR BLACKJACK</a>
</header>

<!-- CARRITO -->
<?php
    $cartCount = 0;
    $total = 0;
    foreach($_SESSION['cart'] as $name => $it){
        $cartCount += $it['qty'];
        $total += $it['price'] * $it['qty'];
    }
?>
<div class="cart-floating" onclick="toggleCart()">
    🛒 <span id="cartCount"><?php echo $cartCount; ?></span>
</div>

<div class="cart-panel" id="cartPanel">
    <div class="cart-header">
        <h3>Tu carrito</h3>
        <span class="close-cart" onclick="toggleCart()">✖</span>
    </div>

    <div id="cartItems">
    <?php
        foreach($_SESSION['cart'] as $name => $it){
            $safe = htmlspecialchars($name, ENT_QUOTES);
            $price = number_format($it['price'],2);
            echo "<div class='cart-item'><span>{$safe} x{$it['qty']} - {$price}€</span> ";
            echo "<button class='cart-dec' data-game='".htmlspecialchars($name,ENT_QUOTES)."'>-</button> ";
            echo "<button class='cart-inc' data-game='".htmlspecialchars($name,ENT_QUOTES)."'>+</button>";
            echo "</div>";
        }
    ?>
    </div>

    <hr>
    <strong>Total: <span id="cartTotal"><?php echo number_format($total,2); ?></span>€</strong>
    <br><br>

 <a href="checkout.php" class="pay-btn">Ir con el pago</a>

    <br><br>
    <button type="button" id="clearCartBtn" class="clear-btn">Vaciar carrito</button>
</div>

<div class="games">


<div class="game">
    <img src="https://imgs.search.brave.com/X0RzOhngnVc_WOWUo-0fFQZq9-5eum8Kimf7Qm7M4Eo/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly93YWxs/cGFwZXJzLmNvbS9p/bWFnZXMvZmVhdHVy/ZWQvcmVkLWRlYWQt/cmVkZW1wdGlvbi0y/LXBpY3R1cmVzLXoy/azltN2NvdnZuZ2xh/dG0uanBn">
    <div class="game-info">
        <h2>Red Dead Redemption 2</h2>
        <p>Una obra maestra de Rockstar Games ambientada en el ocaso del salvaje oeste. Controlas a Arthur Morgan mientras la banda de Dutch lucha por sobrevivir en un mundo que cambia rápidamente. Con un mundo abierto vivo, decisiones morales profundas y un nivel de detalle impresionante, es considerado uno de los mejores juegos jamás creados.</p>
        <form method="POST">
            <input type="hidden" name="game" value="Red Dead Redemption 2">
            <input type="hidden" name="price" value="59.99">
            <?php if($is_logged_in): ?>
                <button type="button" class="buy-btn add-cart-btn">
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
<div class="game"> 
    <img src="https://imgs.search.brave.com/7ll2tFPV8T1UIXKXkic4KE3I3CWYWM5tvWcziCISiPc/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly93YWxs/cGFwZXJzLmNvbS9p/bWFnZXMvaGQvdGhl/LXRyaW8tb2YtZ3Rh/LTUtMjRnbzZyNGM1/OG42ZmRuaC5qcGc" alt="GTA V"> 
    <div class="game-info"> 
        <h2>Grand Theft Auto V</h2> 
        <p> Vive la historia de tres criminales en la ciudad de Los Santos. GTA V combina narrativa cinematográfica, libertad total y un modo online masivo que sigue activo tras años de su lanzamiento. Es uno de los títulos más vendidos y jugados de la historia. </p> 
        <form method="POST">
            <input type="hidden" name="game" value="Grand Theft Auto V">
            <input type="hidden" name="price" value="29.99">
            <?php if($is_logged_in): ?>
                <button type="button" class="buy-btn add-cart-btn">
                    29.99€ - Añadir al carrito
                </button>
            <?php else: ?>
                <button type="button" class="buy-btn disabled">
                    Inicia sesión para comprar
                </button>
            <?php endif; ?>
        </form>
    </div> 
</div>
<div class="game"> 
    <img src="https://imgs.search.brave.com/fyYKgu-SqHldDV9k6Ulf8n4RRxKZorkFRvwuzXSKjFQ/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly93YWxs/cGFwZXJjYXZlLmNv/bS93cC93cDE4NTQ2/NDMuanBn" alt="The Witcher 3"> 
    <div class="game-info"> 
        <h2>The Witcher 3: Wild Hunt</h2> 
        <p> Encarnas a Geralt de Rivia en una aventura épica repleta de decisiones morales, criaturas fantásticas y una narrativa profunda. Su mundo abierto y sus misiones secundarias son consideradas de las mejores jamás diseñadas. </p> 
        <form method="POST">
            <input type="hidden" name="game" value="The Witcher 3: Wild Hunt">
            <input type="hidden" name="price" value="39.99">
            <?php if($is_logged_in): ?>
                <button type="button" class="buy-btn add-cart-btn">
                    39.99€ - Añadir al carrito
                </button>
            <?php else: ?>
                <button type="button" class="buy-btn disabled">
                    Inicia sesión para comprar
                </button>
            <?php endif; ?>
        </form>
    </div> 
</div>

<div class="game"> 
    <img src="https://imgs.search.brave.com/treNpyfUL17dte0Nz6zZXdhS6ctWIB0hJbp06FTOSN0/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9pLnJl/ZGQuaXQvZWQwM2Fy/NnhkaTQ3MS5qcGc" alt="Elden Ring"> 
    <div class="game-info"> 
        <h2>Elden Ring</h2> 
        <p> Un RPG desafiante creado por FromSoftware que combina exploración libre y combates intensos. Con una ambientación oscura y misteriosa, ofrece libertad total para construir tu personaje y enfrentar enemigos colosales. </p> 
        <form method="POST">
            <input type="hidden" name="game" value="Elden Ring">
            <input type="hidden" name="price" value="49.99">
            <?php if($is_logged_in): ?>
                <button type="button" class="buy-btn add-cart-btn">
                    49.99€ - Añadir al carrito
                </button>
            <?php else: ?>
                <button type="button" class="buy-btn disabled">
                    Inicia sesión para comprar
                </button>
            <?php endif; ?>
        </form>
    </div> 
</div>

<div class="game"> 
    <img src="https://imgs.search.brave.com/8r2UGifR3UkCQySFDNOiqVoW-tzUVuVN5H0WYAxPaxE/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly93YWxs/cGFwZXJjYXQuY29t/L3cvZnVsbC82L2Iv/OC8xMzQyMzgtMzg0/MHgyMTYwLWRlc2t0/b3AtNGstZ29kLW9m/LXdhci1yYWduYXJv/ay1iYWNrZ3JvdW5k/LmpwZw" alt="God of War Ragnarok"> 
    <div class="game-info"> 
        <h2>God of War Ragnarök</h2> 
        <p> Kratos y Atreus regresan en una aventura épica inspirada en la mitología nórdica. Combate brutal, narrativa emocional y una dirección artística impresionante lo convierten en uno de los exclusivos más importantes de PlayStation. </p> 
        <form method="POST">
            <input type="hidden" name="game" value="God of War Ragnarok">
            <input type="hidden" name="price" value="69.99">
            <?php if($is_logged_in): ?>
                <button type="button" class="buy-btn add-cart-btn">
                    69.99€ - Añadir al carrito
                </button>
            <?php else: ?>
                <button type="button" class="buy-btn disabled">
                    Inicia sesión para comprar
                </button>
            <?php endif; ?>
        </form>
    </div> 
</div>

<div class="game"> 
    <img src="https://imgs.search.brave.com/PWk-nt5C0pPVxVGisXhdxGdCEd1JfdVT6ZWNr_dfq1o/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly93YWxs/cGFwZXJjYXQuY29t/L3cvZnVsbC80LzYv/NC8xMzUxMzYtMzQ4/MHgyMTYwLWRlc2t0/b3AtaGQtY3liZXJw/dW5rLTIwNzctYmFj/a2dyb3VuZC1pbWFn/ZS5qcGc" alt="Cyberpunk 2077"> 
    <div class="game-info"> 
        <h2>Cyberpunk 2077</h2> 
        <p> Explora Night City en este RPG futurista lleno de decisiones, tecnología avanzada y acción intensa. Tras múltiples mejoras, se ha consolidado como una experiencia sólida y visualmente espectacular. </p> 
        <form method="POST">
            <input type="hidden" name="game" value="Cyberpunk 2077">
            <input type="hidden" name="price" value="49.99">
            <?php if($is_logged_in): ?>
                <button type="button" class="buy-btn add-cart-btn">
                    49.99€ - Añadir al carrito
                </button>
            <?php else: ?>
                <button type="button" class="buy-btn disabled">
                    Inicia sesión para comprar
                </button>
            <?php endif; ?>
        </form>
    </div> 
</div>

<div class="game"> 
    <img src="https://imgs.search.brave.com/Qb8e1J3KgrMaFYfmKZJTBwU1kwb1AGal20pWhyyBxc4/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly93d3cu/cHN1LmNvbS93cC93/cC1jb250ZW50L3Vw/bG9hZHMvMjAyMC8w/OS9TZWtpcm8tU2hh/ZG93cy1EaWUtVHdp/Y2UtUFM0LVdhbGxw/YXBlcnMtMzAuanBn" alt="Sekiro"> 
    <div class="game-info"> 
        <h2>Sekiro: Shadows Die Twice</h2> 
        <p> Un título exigente centrado en el combate preciso con katana. Ambientado en el Japón feudal, ofrece una experiencia intensa donde cada enfrentamiento requiere concentración y habilidad. </p> 
        <form method="POST">
            <input type="hidden" name="game" value="Sekiro: Shadows Die Twice">
            <input type="hidden" name="price" value="39.99">
            <?php if($is_logged_in): ?>
                <button type="button" class="buy-btn add-cart-btn">
                    39.99€ - Añadir al carrito
                </button>
            <?php else: ?>
                <button type="button" class="buy-btn disabled">
                    Inicia sesión para comprar
                </button>
            <?php endif; ?>
        </form>
    </div> 
</div>

<div class="game"> 
    <img src="https://imgs.search.brave.com/fsx1_P3qLOZ555W4Kzz3TBBblBQWXmj8vkY8GnW0MWc/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly93d3cu/cHN1LmNvbS93cC93/cC1jb250ZW50L3Vw/bG9hZHMvMjAyMC8x/MC9Bc3Nhc3NpbnMt/Q3JlZWQtVmFsaGFs/bGEtUFM0LVBTNS1X/YWxscGFwZXJzLTM2/LmpwZw" alt="Assassin's Creed Valhalla"> 
    <div class="game-info"> 
        <h2>Assassin's Creed Valhalla</h2> 
        <p> Lidera un clan vikingo y conquista nuevas tierras en esta entrega histórica de la saga. Combina exploración, combate y gestión de asentamientos en un mundo abierto masivo. </p> 
        <form method="POST">
            <input type="hidden" name="game" value="Assassin's Creed Valhalla">
            <input type="hidden" name="price" value="49.99">
            <?php if($is_logged_in): ?>
                <button type="button" class="buy-btn add-cart-btn">
                    49.99€ - Añadir al carrito
                </button>
            <?php else: ?>
                <button type="button" class="buy-btn disabled">
                    Inicia sesión para comprar
                </button>
            <?php endif; ?>
        </form>
    </div> 
</div>

<div class="game"> 
    <img src="https://imgs.search.brave.com/zGsnD0T5PYbI8WpMGCLvpu28aHrI5wYTzfO0ADrRK3U/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9pbWFn/ZXMuaGRxd2FsbHMu/Y29tL2Rvd25sb2Fk/L2hvZ3dhcnRzLWxl/Z2FjeS01cS0xOTIw/eDEwODAuanBn" alt="Hogwarts Legacy"> 
    <div class="game-info"> 
        <h2>Hogwarts Legacy</h2> 
        <p> Vive tu propia historia mágica en el universo de Harry Potter. Explora Hogwarts, aprende hechizos y enfréntate a criaturas mágicas en un RPG lleno de aventuras. </p> 
        <form method="POST">
            <input type="hidden" name="game" value="Hogwarts Legacy">
            <input type="hidden" name="price" value="59.99">
            <?php if($is_logged_in): ?>
                <button type="button" class="buy-btn add-cart-btn">
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
 
<div class="game"> 
    <img src="https://imgs.search.brave.com/chcHb767eWaR83OU_26auobs3i-cCUe4tvCzntxzj7M/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly93YWxs/cGFwZXJhY2Nlc3Mu/Y29tL2Z1bGwvNTMz/MzEzLmpwZw" alt="Minecraft"> 
    <div class="game-info"> 
        <h2>Minecraft</h2> 
        <p> El juego de construcción y supervivencia más vendido del mundo. Libertad total para crear, explorar y sobrevivir en mundos generados proceduralmente. </p> 
                   <form method="POST">
            <input type="hidden" name="game" value="Minecraft">
            <input type="hidden" name="price" value="29.99">
            <?php if($is_logged_in): ?>
                <button type="button" class="buy-btn add-cart-btn">
                    29.99€ - Añadir al carrito
                </button>
            <?php else: ?>
                <button type="button" class="buy-btn disabled">
                    Inicia sesión para comprar
                </button>
            <?php endif; ?>
        </form> 
    </div> 
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
    const p = document.querySelector(".popup"); if(p) p.style.display="none";
}

async function postAction(formData){
    const res = await fetch('index.php', { method: 'POST', body: formData });
    return res.json();
}

function showTempPopup(msg){
    const d = document.createElement('div'); d.className = 'popup show'; d.innerHTML = msg + ' <span onclick="this.parentNode.style.display=\'none\'">✖</span>'; document.body.appendChild(d);
    setTimeout(()=>{ d.style.display='none'; d.remove(); }, 1800);
}

function updateCartUI(data){
    document.getElementById('cartCount').textContent = data.count;
    document.getElementById('cartTotal').textContent = parseFloat(data.total).toFixed(2);
    const wrap = document.getElementById('cartItems');
    wrap.innerHTML = '';
    data.items.forEach(it => {
        const div = document.createElement('div'); div.className = 'cart-item';
        const span = document.createElement('span'); span.textContent = `${it.name} x${it.qty} - ${parseFloat(it.price).toFixed(2)}€`;
        const dec = document.createElement('button'); dec.className='cart-dec'; dec.dataset.game = it.name; dec.textContent='-';
        const inc = document.createElement('button'); inc.className='cart-inc'; inc.dataset.game = it.name; inc.textContent='+';
        div.appendChild(span); div.appendChild(dec); div.appendChild(inc);
        wrap.appendChild(div);
    });
    attachCartButtons();
}

function attachCartButtons(){
    document.querySelectorAll('.cart-inc').forEach(btn => {
        btn.onclick = async () => {
            const fd = new FormData(); fd.append('action','add'); fd.append('ajax','1'); fd.append('game', btn.dataset.game);
            const data = await postAction(fd); updateCartUI(data);
        };
    });
    document.querySelectorAll('.cart-dec').forEach(btn => {
        btn.onclick = async () => {
            const fd = new FormData(); fd.append('action','remove_one'); fd.append('ajax','1'); fd.append('game', btn.dataset.game);
            const data = await postAction(fd); updateCartUI(data);
        };
    });
}

document.querySelectorAll('.add-cart-btn').forEach(b => {
    b.addEventListener('click', async (e) => {
        const form = e.target.closest('form');
        if(!form) return;
        const game = form.querySelector('input[name="game"]').value;
        const price = form.querySelector('input[name="price"]').value;
        const fd = new FormData(); fd.append('action','add'); fd.append('ajax','1'); fd.append('game',game); fd.append('price',price);
        const data = await postAction(fd);
        updateCartUI(data);
        showTempPopup('✅ Juego añadido correctamente');
    });
});

document.getElementById('clearCartBtn').addEventListener('click', async () => {
    const fd = new FormData(); fd.append('action','clear'); fd.append('ajax','1');
    const data = await postAction(fd);
    updateCartUI(data);
});

// Attach cart buttons on load
attachCartButtons();
</script>

</body>
</html>