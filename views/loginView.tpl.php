@extends(head)

<style>
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

<!-- 	<h1>Ingreso de usuario {{ APP_NAME }}</h1>
	<h2>Y podras ser parte de los {{ CANT_USER }}</h2>
 -->
	

<!-- 
	<form action="?slug=login" method="POST">
		
		<input type="text" name="txt_email" id="txt_email" placeholder="email">
		<input type="text" name="txt_password" id="txt_password" placeholder="Contraseña">
		<input type="submit" name="btn_login" value="Ingresar">

	</form> -->

	<div class="login-container">
        <h2>Iniciar Sesión</h2>
        <form action="?slug=login" method="POST">
            <input type="email" name="txt_email" placeholder="Correo electrónico" required>
            <input type="password" name="txt_password" placeholder="Contraseña" required>
            <button type="submit" name="btn_login">Iniciar</button>
        </form>
    </div>
	
	@extends(footer)
</body>
</html>


<!-- sdfsdfsdfsd -->



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Huerta en Red</title>
    
</head>
<body>
    
</body>
</html>
