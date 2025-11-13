<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>app-estacion</title>

    <!-- Primary Meta Tags -->
    <meta name="title" content="App-Estacion">
    <meta name="description" content="Monitor de estaciones metereologicas construidas con ESP8266, las mismas cuentan sensores de humedad, temperatura y viento que envian los datos vía wifi a un servidor.">
    
    <meta name="author" content="Matias Leonardo Baez MattProfe">
    <meta name="reply-to" content="elmattprofe@gmail.com">
    <link rev="made" href="mailto:elmattprofe@gmail.com">
    <meta name="keywords" content="mattprofe,MattProfe,appestacion,app-estacion,matias baez,Matias Baez,mbcorp,MBCorp">
    <meta name="Resource-type" content="Document">
    <meta name="DateCreated" content="Thu, 22 September 2019 00:00:00 GMT+3">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://mattprofe.com.ar/proyectos/app-estacion">
    <meta property="og:title" content="App-Estacion">
    <meta property="og:description" content="Monitor de estaciones metereologicas construidas con ESP8266, las mismas cuentan sensores de humedad, temperatura y viento que envian los datos via wifi a un servidor.">
    <meta property="og:image" content="https://mattprofe.com.ar/web/img/proyectos/app-estacion.png">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://mattprofe.com.ar/proyectos/app-estacion">
    <meta property="twitter:title" content="App-Estacion">
    <meta property="twitter:description" content="Monitor de estaciones metereologicas construidas con ESP8266, las mismas cuentan sensores de humedad, temperatura y viento que envian los datos via wifi a un servidor.">
    <meta property="twitter:image" content="https://mattprofe.com.ar/web/img/proyectos/app-estacion.png">
    

    <meta name="MobileOptimized" content="width">
    <meta name="HandheldFriendly" content="true">
    <!-- <link rel="manifest" href="manifest.json"> -->

    <link rel="stylesheet" type="text/css" href="./static/css/estaciones.css">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;500;900&family=Ubuntu:wght@300;500;700&display=swap" rel="stylesheet"> 

    <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous"> -->
    <script src="https://kit.fontawesome.com/2eb80ea257.js" crossorigin="anonymous"></script>

</head>


<body>
    <header>
        <h1>Panel de {{ USER_NAME }}</h1>
    </header>

    <div id="wrapper">

        <div id="list-estacion">
            <div id="list-estacion-title">estaciones</div>
        </div>

        <template id="tpl-btn-estacion">
            <a href="" class="btn-estacion">
                <div class="estacion-apodo">
                    
                </div>

                <div class="estacion-ubicacion">
                    
                </div>

                <div class="estacion-visitas">
                    
                </div>
            </a>
        </template>

        
    
    </div>

    @extends(footer)


    <script type="text/javascript" src="./static/js/estaciones.js"></script>
    <script type="text/javascript" src="./static/js/panelScript.js"></script>
</body>
</html>