<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ APP_SECTION }} - {{ APP_NAME }}</title>

    <meta property="og:description" content="{{ APP_DESCRIPTION }}">


	<!-- Primary Meta Tags -->
	<meta name="title" content="{{ APP_NAME }}">
	<meta name="description" content="{{ APP_DESCRIPTION }}">
	
	<meta name="author" content="{{ APP_AUTHOR }}">
	<!-- <meta name="reply-to" content="elmattprofe@gmail.com">
	<link rev="made" href="mailto:elmattprofe@gmail.com">
	<meta name="keywords" content="Matias Baez,matias baez,mattprofe,MattProfe,Matt Profe,matt profe,programación,programacion,robotica,robótica,informática,informatica,desarrollo,web"> -->
	<meta name="Resource-type" content="Document">
	<meta name="DateCreated" content="Thu, 22 September 2020 00:00:00 GMT+3">

	<!-- Open Graph / Facebook -->
	<meta property="og:type" content="website">
	<meta property="og:url" content="{{ APP_URL }}">
	<meta property="og:title" content="{{ APP_NAME }}">
	<meta property="og:description" content="{{ APP_DESCRIPTION }}">
	<meta property="og:image" content="{{ APP_URL }}/img/hero.jpeg">


    <style>
      :root {
    --fondo-pagina: {{ FONDO_PAGINA }};
    --texto-principal: {{ TEXTO_PRINCIPAL }};
    --fondo-header-gradiente-inicio: {{ FONDO_HEADER_GRADIENTE_INICIO }};
    --fondo-header-gradiente-fin: {{ FONDO_HEADER_GRADIENTE_FIN }};
    --texto-invertido: {{ TEXTO_INVERTIDO }};
    --texto-hover-nav: {{ TEXTO_HOVER_NAV }};
    --fondo-boton: {{ FONDO_BOTON }};
    --fondo-boton-hover: {{ FONDO_BOTON_HOVER }};
    --fondo-seccion-clara: {{ FONDO_SECCION_CLARA }};
    --fondo-tarjeta: {{ FONDO_TARJETA }};
    --titulo-tarjeta: {{ TITULO_TARJETA }};
    --fondo-footer: {{ FONDO_FOOTER }};
    --sombra-suave: {{ SOMBRA_SUAVE }};
    --sombra-muy-suave: {{ SOMBRA_MUY_SUAVE }};
}

/* ====== Reset ====== */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', sans-serif;
    background-color: var(--fondo-pagina);
    color: var(--texto-principal);
}

header {
    background: linear-gradient(135deg, var(--fondo-header-gradiente-inicio), var(--fondo-header-gradiente-fin));
    color: var(--texto-invertido);
    text-align: center;
    padding: 3rem 1rem;
}

header h1 {
    font-size: 2.5rem;
    margin-bottom: 0.5rem;
}

header p {
    font-size: 1.2rem;
}

nav {
    background-color: var(--texto-principal);
    padding: 0.8rem;
    text-align: center;
}

nav a {
    color: var(--texto-invertido);
    text-decoration: none;
    margin: 0 1rem;
    font-weight: bold;
    transition: color 0.3s;
}

nav a:hover {
    color: var(--texto-hover-nav);
}

.hero {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: center;
    padding: 2rem;
    gap: 2rem;
}

.hero img {
    max-width: 450px;
    width: 100%;
    border-radius: 12px;
    box-shadow: 0 4px 15px var(--sombra-suave);
}

.hero-text {
    max-width: 500px;
}

.hero-text h2 {
    font-size: 2rem;
    margin-bottom: 1rem;
}

.hero-text p {
    font-size: 1.1rem;
    margin-bottom: 1.5rem;
}

.btn {
    display: inline-block;
    background-color: var(--fondo-boton);
    color: var(--texto-invertido);
    padding: 0.8rem 1.5rem;
    border-radius: 25px;
    text-decoration: none;
    font-weight: bold;
    transition: background 0.3s;
}

.btn:hover {
    background-color: var(--fondo-boton-hover);
}

.features {
    background-color: var(--fondo-seccion-clara);
    padding: 3rem 2rem;
    text-align: center;
}

.features h3 {
    font-size: 1.8rem;
    margin-bottom: 2rem;
}

.feature-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
}

.feature {
    background-color: var(--fondo-tarjeta);
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 2px 8px var(--sombra-muy-suave);
}

.feature h4 {
    margin-bottom: 0.8rem;
    color: var(--titulo-tarjeta);
}

footer {
    background-color: var(--fondo-footer);
    color: var(--texto-invertido);
    text-align: center;
    padding: 1rem;
    font-size: 0.9rem;
}

    </style>
</head>