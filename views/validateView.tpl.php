@extends(head)

<style>
    .validate-container {
        background-color: var(--fondo-caja);
        padding: 2rem 3rem;
        border-radius: 12px;
        box-shadow: 0 4px 15px var(--sombra-caja);
        width: 100%;
        max-width: 500px;
        text-align: center;
        margin: 50px auto;
    }

    .validate-container h2 {
        margin-bottom: 1.5rem;
        font-size: 2rem;
        color: var(--fondo-header-gradiente-fin);
    }

    .success-message {
        background-color: #e8f5e8;
        color: #2e7d32;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        border: 1px solid #4caf50;
    }

    .error-message {
        background-color: #ffebee;
        color: #c62828;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        border: 1px solid #ef5350;
    }

    .btn-login {
        display: inline-block;
        padding: 12px 25px;
        background-color: var(--fondo-boton);
        color: var(--texto-invertido);
        text-decoration: none;
        border-radius: 25px;
        font-weight: bold;
        margin-top: 15px;
        transition: background 0.3s;
    }

    .btn-login:hover {
        background-color: var(--fondo-boton-hover);
    }
</style>

<body>
    <div class="validate-container">
        <h2>Activación de Cuenta</h2>
        
        {{ MESSAGE }}
    </div>
    
    @extends(footer)
</body>
</html>