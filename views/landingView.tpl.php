@extends(head)

<body>

    <header>
        <h1>{{ APP_NAME }}</h1>
        <p>{{ APP_DESCRIPTION }}</p>
    </header>

    <nav>
        <a href="#features">Funcionalidades</a>
        <a href="#seguridad">Seguridad</a>
        <a href="#analiticas">Analíticas</a>
        <a href="?slug=login">Iniciar Sesión</a>
    </nav>

    <section class="hero">
        <img src="https://images.unsplash.com/photo-1549416562-42ecceeb2995?q=80&w=2942&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Estación Meteorológica en Campo">
        <div class="hero-text">
            <h2>Monitoreo Climático y Seguridad Avanzada</h2>
            <p>Accede a datos en tiempo real de temperatura, humedad y presión de nuestras estaciones. Visualiza tendencias con gráficos dinámicos y mantén tu cuenta segura con nuestro sistema de notificaciones.</p>
            <a href="?slug=panel" class="btn">Ver Estaciones Ahora</a>
        </div>
    </section>

    <section class="features" id="features">
        <h3>¿Qué ofrece App-Estación?</h3>
        <div class="feature-grid">
            <div class="feature">
                <h4>📊 Datos en Tiempo Real</h4>
                <p>Visualiza tendencias con gráficos de temperatura, humedad y riesgo de incendio, actualizados cada 60 segundos.</p>
            </div>
            <div class="feature">
                <h4>🔒 Seguridad Reforzada</h4>
                <p>Sistema de registro con validación por email y notificaciones ante inicios de sesión o intentos fallidos.</p>
            </div>
            <div class="feature">
                <h4>📍 Ubicación de Clientes</h4>
                <p>El administrador puede rastrear la ubicación de los visitantes en un mapa interactivo con Leaflet.</p>
            </div>
        </div>
    </section>

    @extends(footer)

</body>
</html>