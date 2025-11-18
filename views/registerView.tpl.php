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
        }

        .login-container h2 {
            margin-bottom: 1.5rem;
            font-size: 2rem;
            color: var(--fondo-header-gradiente-fin);
        }

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
        <h2>Registrarse</h2>
        
        <?php if($errno != ""): ?>
            <div style="background-color: #ffebee; color: #c62828; padding: 10px; border-radius: 5px; margin-bottom: 15px; border: 1px solid #ef5350;">
                {{ ERROR }}
            </div>
        <?php endif; ?>
        
        <form action="?slug=register" method="POST">
            <input type="email" name="txt_email" placeholder="Correo electrónico" required>
            <input type="password" name="txt_password" placeholder="Contraseña" required>
            <input type="password" name="txt_password2" placeholder="Repetir contraseña" required>
            <button type="submit" name="btn_register">Registrar</button>
            <p><a href="?slug=login">Ya tenes una cuenta? Inicia sesion</a></p>
        </form>
    </div>
	
	@extends(footer)
</body>
</html>