@extends(head)

<style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        .login-container {
            background-color: var(--fondo-caja);
            padding: 2rem 3rem;
            border-radius: 12px;
            box-shadow: 0 4px 15px var(--sombra-caja);
            width: 100%;
            max-width: 400px;
            text-align: center;
            justify-content: center;
        }

        .login-container h2 {
            margin-bottom: 1.5rem;
            font-size: 2rem;
            color: var(--fondo-header-gradiente-fin);
        }

        .login-container input[type="text"],
        .login-container input[type="email"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 0.8rem 1rem;
            margin-bottom: 1rem;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 1rem;
        }

        .login-container button {
            width: 100%;
            padding: 0.8rem;
            background-color: var(--fondo-boton);
            color: var(--texto-invertido);
            border: none;
            border-radius: 25px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
        }

        .login-container button:hover {
            background-color: var(--fondo-boton-hover);
        }
    </style>

<body>
    
	<div class="login-container">
        <h2>Iniciar Sesión</h2>
        <form action="?slug=login" method="POST">
            <input type="text" name="txt_email" placeholder="Usuario o Email" required>
            <input type="password" name="txt_password" placeholder="Contraseña" required>
            <p><a href="?slug=recovery">Olvidaste tu contraseña?</a></p>
            <button type="submit" name="btn_login">Acceder</button>
            <p><a href="?slug=register">No tienes una cuenta? Registrarse</a></p>
            {{ ERROR }}
        </form>
    </div>
	
	@extends(footer)
</body>
</html>