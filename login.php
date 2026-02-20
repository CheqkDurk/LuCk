<!DOCTYPE html>
<html>
<head>
    <style>
        /* Fondo de la página */
        body {
            background-color: #0b0f14;
            color: white;
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        /* Caja del formulario */
        form {
            background-color: #121821;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 255, 150, 0.2);
            text-align: center;
            width: 300px;
        }

        h2 {
            color: #00ff99;
            margin-bottom: 20px;
        }

        /* Estilo de los cuadros de texto */
        input {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #333;
            border-radius: 8px;
            background-color: #1a1f2b;
            color: white;
            box-sizing: border-box; /* Para que no se salgan del borde */
        }

        /* Cuando haces clic en el cuadro */
        input:focus {
            outline: none;
            border-color: #00ff99;
        }

        /* Estilo del botón */
        button {
            width: 100%;
            padding: 12px;
            background-color: #00ff99;
            color: black;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        /* Efecto al pasar el ratón por el botón */
        button:hover {
            background-color: #00cc77;
            transform: scale(1.02);
        }
    </style>
</head>
<body>

    <form action="login2.php" method="POST">
        <h2>Iniciar Sesión</h2>
        <input type="text" name="usuario" placeholder="Usuario">
        <input type="password" name="password" placeholder="Contraseña">
        <button type="submit">Entrar</button>
    </form>

</body>
</html>