// Evento que se ejecuta cuando se carga completamente la página
document.addEventListener("DOMContentLoaded", () => {

	// pedimos las estaciones
	loadEstaciones().then( data => {

		// recorremos el listado de estaciones
		data.forEach(function(element, index){

			// creamos los botones de estaciones
			addBtnEstacion(element)
		})
	})
})

// Petición asincrona de la lista de estaciones
async function loadEstaciones(){
	const response = await fetch("https://mattprofe.com.ar/proyectos/app-estacion/datos.php?mode=list-stations")
	const data = await response.json()

	return data
}

// Crea un nuevo botón con los datos de info
function addBtnEstacion(info){

	let tpl = document.querySelector("#tpl-btn-estacion")
	let clon = tpl.content.cloneNode(true)

	// cargamos los datos del botón clonado

	if(info.dias_inactivo > 0)
		clon.querySelector(".btn-estacion").classList.add("btn-estacion--inactiva");
	
	clon.querySelector(".btn-estacion").setAttribute("href", "?slug=estacion&chipid="+info.chipid)
	clon.querySelector(".estacion-ubicacion").innerHTML= '<i class="fas fa-map-marker-alt color-ubicacion"></i>&nbsp'+info.ubicacion
	clon.querySelector(".estacion-visitas").innerHTML = info.visitas+'&nbsp<i class="fa-solid fa-tower-observation color-visitas"></i>'
	clon.querySelector(".estacion-apodo").innerHTML = info.apodo
	
	// Agrega un nuevo botón de estación
	document.querySelector("#list-estacion").appendChild(clon)
}
