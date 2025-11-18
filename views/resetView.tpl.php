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
    .reset-container {
        background-color: var(--fondo-caja);
        padding: 2rem 3rem;
        border-radius: 12px;
        box-shadow: 0 4px 15px var(--sombra-caja);
        width: 100%;
        max-width: 400px;
        text-align: center;
        margin: 50px auto;
    }

    .reset-container h2 {
        margin-bottom: 1.5rem;
        font-size: 2rem;
        color: var(--fondo-header-gradiente-fin);
    }

    .reset-container input[type="password"] {
        width: 100%;
        padding: 0.8rem 1rem;
        margin-bottom: 1rem;
        border-radius: 8px;
        border: 1px solid #ccc;
        font-size: 1rem;
    }

    .reset-container button {
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

    .reset-container button:hover {
        background-color: var(--fondo-boton-hover);
    }

    .error-message {
        background-color: #ffebee;
        color: #c62828;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 15px;
        border: 1px solid #ef5350;
    }
</style>

<body>
    <div class="reset-container">
        <h2>Restablecer Contraseña</h2>
        
        {{ ERROR_MESSAGE }}
        {{ FORM_CONTENT }}
        <p><a href="?slug=login">Volver al Login</a></p>
    </div>
    
    @extends(footer)
</body>
</html>