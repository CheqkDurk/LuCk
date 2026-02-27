<?php
session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header("Location: login1.php");
    exit;
}

$total = 0;
foreach($_SESSION['cart'] as $item){
    if(isset($item['qty'])) $total += $item['price'] * $item['qty'];
    elseif(isset($item['price'])) $total += $item['price'];
}

$errors = [];
if(isset($_POST['pay'])){
    $card = trim($_POST['card_number'] ?? '');
    $expiry = trim($_POST['expiry'] ?? '');
    $cvv = trim($_POST['cvv'] ?? '');

    if(!preg_match('/^\d{16}$/', $card)){
        $errors[] = 'El número de tarjeta debe tener exactamente 16 dígitos y solo números.';
    }
    if(!preg_match('/^(0[1-9]|1[0-2])\/\d{2}$/', $expiry)){
        $errors[] = 'La fecha debe tener el formato MM/AA y mes válido (01-12).';
    }
    if(!preg_match('/^\d{3}$/', $cvv)){
        $errors[] = 'El CVV debe ser de exactamente 3 dígitos y solo números.';
    }

    if(empty($errors)){
        $_SESSION['cart'] = [];
        $paid = true;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Pago</title>
<link rel="stylesheet" href="css.css">
</head>
<body>

<div class="checkout-box">
    <h2>Procesar  Pago</h2>
    <p>Total: <?php echo number_format($total,2); ?>€</p>
    <?php if(isset($paid)): ?>
        <h3>✅ Pago realizado correctamente</h3>
        <a href="index.php" class="back-btn">Volver a la tienda</a>
    <?php else: ?>
        <?php if(!empty($errors)): ?>
            <div class="checkout-errors" style="color:red;margin-bottom:12px;">
                <ul>
                    <?php foreach($errors as $err) echo '<li>'.htmlspecialchars($err).'</li>'; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" id="checkoutForm" novalidate>
            <input type="text" name="card_number" id="card_number" maxlength="16" inputmode="numeric" pattern="\d{16}" placeholder="Número de tarjeta (16 dígitos)" required>
            <input type="text" name="expiry" id="expiry" maxlength="5" inputmode="numeric" pattern="(0[1-9]|1[0-2])\/\d{2}" placeholder="Caducidad MM/AA" required>
            <input type="text" name="cvv" id="cvv" maxlength="3" inputmode="numeric" pattern="\d{3}" placeholder="CVV (0.3 dígitos)" required>

            <div id="checkoutError" style="color:red;margin-top:8px;display:none;"></div>

            <div class="checkout-actions">
                <a href="index.php" class="back-btn">Volver a la tienda</a>
                <button type="submit" name="pay" class="pay-btn">
                    Confirmar Pago
                </button>
            </div>
        </form>

        <script>
        (function(){
            const form = document.getElementById('checkoutForm');
            const errDiv = document.getElementById('checkoutError');
            function showErr(msg){ errDiv.style.display='block'; errDiv.textContent = msg; }

            form.addEventListener('submit', function(e){
                errDiv.style.display='none'; errDiv.textContent='';
                const card = document.getElementById('card_number').value.replace(/\s+/g,'');
                const expiry = document.getElementById('expiry').value.trim();
                const cvv = document.getElementById('cvv').value.trim();

                if(!/^\d{16}$/.test(card)){
                    e.preventDefault(); showErr('El número de tarjeta debe ser exactamente 16 dígitos y sin letras.'); return false;
                }
                if(!/^(0[1-9]|1[0-2])\/\d{2}$/.test(expiry)){
                    e.preventDefault(); showErr('La fecha debe ser MM/AA con mes válido (01-12) y sin letras.'); return false;
                }
                if(!/^\d{3}$/.test(cvv)){
                    e.preventDefault(); showErr('El CVV debe tener exactamente 3 dígitos y solo números.'); return false;
                }
                return true;
            });
        })();
        </script>
    <?php endif; ?>
</div>

</body>
</html>