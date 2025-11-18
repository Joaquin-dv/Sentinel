@extends(head)

<body>

    <header>
        <h1>{{ APP_NAME }}</h1>
        <p>{{ APP_DESCRIPTION }}</p>
    </header>

    <nav>
        <!-- <a href="#features">Funcionalidades</a>
        <a href="#seguridad">Seguridad</a>
        <a href="#analiticas">Analíticas</a> -->
        <a href="?slug=login">Iniciar Sesión</a>
    </nav>

    <section class="hero">
        <img src="https://tecscience.tec.mx/es/wp-content/uploads/sites/8/2024/12/gencast-prediccion-clima.jpg" alt="Estación Meteorológica en Campo">
        <div class="hero-text">
            <h2>Monitoreo Climático y Seguridad Avanzada</h2>
            <p>Accede a datos en tiempo real de temperatura, humedad y presión de nuestras estaciones. Visualiza tendencias con gráficos dinámicos y mantén tu cuenta segura con nuestro sistema de notificaciones.</p>
            <a href="?slug=panel" class="btn">Ver Estaciones Ahora</a>
        </div>
    </section>

    <section class="features" id="features">
        <h3>¿Qué ofrece {{ APP_NAME }}?</h3>
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