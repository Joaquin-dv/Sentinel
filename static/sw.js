;
const CACHE_NAME = 'v10_cache_app-estacion', 
urlsToCache = ['./',
'https://fonts.googleapis.com/css2?family=Roboto:wght@300;500;900&family=Ubuntu:wght@300;500;700&display=swap',
'https://use.fontawesome.com/releases/v5.15.1/css/all.css',
'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js',
'./css/estaciones.css',
'./css/panel.css',
'./js/estaciones.js',
'./js/panel.js',
'./index.html']

self.addEventListener("install", e => {
	e.waitUntil(
		caches.open(CACHE_NAME)
		.then( cache => {
			return cache.addAll(urlsToCache)
			.then( () => self.skipWaiting())
		})
		.catch(err => console.log('Falló registro de cache', err))
	)
})

// cuando pierde conexion a internet
self.addEventListener("activate", e => {
	const cacheWhitelist = [ CACHE_NAME ]

	e.waitUntil(
		caches.keys()
		.then(cachesNames => {
			cachesNames.map(cacheName => {
				if( cacheWhitelist.indexOf(cacheName) === -1){
					return caches.delete(cacheName)
				}
			})
		})

		.then(() => self.clients.claim())
	)
})

// cuando el navegador recupera un url
self.addEventListener("fetch", e => {
	e.respondWith(
		caches.match(e.request)
		.then( res => {
			if(res){
				return res
			}

			return fetch(e.request)
		})

	)
})
