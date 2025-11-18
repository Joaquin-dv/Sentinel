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
    .recovery-container {
        background-color: var(--fondo-caja);
        padding: 2rem 3rem;
        border-radius: 12px;
        box-shadow: 0 4px 15px var(--sombra-caja);
        width: 100%;
        max-width: 400px;
        text-align: center;
        margin: 50px auto;
    }

    .recovery-container h2 {
        margin-bottom: 1.5rem;
        font-size: 2rem;
        color: var(--fondo-header-gradiente-fin);
    }

    .recovery-container input[type="email"] {
        width: 100%;
        padding: 0.8rem 1rem;
        margin-bottom: 1rem;
        border-radius: 8px;
        border: 1px solid #ccc;
        font-size: 1rem;
    }

    .recovery-container button {
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

    .recovery-container button:hover {
        background-color: var(--fondo-boton-hover);
    }
</style>

<body>
    <div class="recovery-container">
        <h2>Recuperar Contraseña</h2>
        
        {{ MESSAGE }}
        {{ FORM_CONTENT }}
        
        <p><a href="?slug=login">Volver al Login</a></p>
    </div>
    
    @extends(footer)
</body>
</html>