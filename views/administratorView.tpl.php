@extends(head)

<style>
    .admin-container {
        max-width: 800px;
        margin: 20px auto;
        padding: 20px;
        background-color: var(--fondo-caja);
        border-radius: 12px;
        box-shadow: 0 4px 15px var(--sombra-caja);
    }

    .admin-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        border-bottom: 2px solid var(--fondo-header-gradiente-fin);
        padding-bottom: 15px;
    }

    .admin-header h1 {
        color: var(--fondo-header-gradiente-fin);
        margin: 0;
    }

    .logout-btn {
        background-color: #D32F2F;
        color: white;
        padding: 8px 16px;
        text-decoration: none;
        border-radius: 5px;
        font-size: 14px;
        font-weight: bold;
    }

    .logout-btn:hover {
        background-color: #B71C1C;
    }

    .map-btn {
        display: inline-block;
        background-color: var(--fondo-boton);
        color: var(--texto-invertido);
        padding: 12px 25px;
        text-decoration: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 30px;
        transition: background 0.3s;
    }

    .map-btn:hover {
        background-color: var(--fondo-boton-hover);
    }

    .counters {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .counter-card {
        background-color: var(--fondo-tarjeta);
        padding: 20px;
        border-radius: 8px;
        text-align: center;
        border: 1px solid #ddd;
    }

    .counter-card h3 {
        color: var(--titulo-tarjeta);
        margin: 0 0 10px 0;
        font-size: 18px;
    }

    .counter-number {
        font-size: 36px;
        font-weight: bold;
        color: var(--fondo-boton);
        margin: 0;
    }
</style>

<body>
    <div class="admin-container">
        <div class="admin-header">
            <h1>Panel de Administrador</h1>
            <a href="?slug=logout" class="logout-btn">Cerrar Sesión</a>
        </div>
        
        <a href="?slug=map" class="map-btn">Mapa de clientes</a>
        
        <div class="counters">
            <div class="counter-card">
                <h3>Usuarios Registrados</h3>
                <p class="counter-number">{{ CANT_USUARIOS }}</p>
            </div>
            
            <div class="counter-card">
                <h3>Cantidad de Clientes</h3>
                <p class="counter-number">{{ CANT_CLIENTES }}</p>
            </div>
        </div>
    </div>
    
    @extends(footer)
</body>
</html>