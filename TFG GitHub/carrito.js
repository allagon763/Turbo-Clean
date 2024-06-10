document.addEventListener('DOMContentLoaded', function() {
    // Obtenemos los elementos de las casillas
    const casillas = document.querySelectorAll('.casilla');
    // Obtenemos el elemento del precio total
    const elementoPrecioTotal = document.getElementById('preciototal');
    // Obtenemos el contenedor del carrito
    const contenedorCarrito = document.getElementById('cart-container');
    // Obtenemos la lista de servicios seleccionados
    const listaServiciosSeleccionados = document.getElementById('seleccion');
    // Obtenemos el elemento del precio total en el carrito
    const elementoTotalCarrito = document.getElementById('cart-total');

    // Con esta función calculamos el precio total y mostramos los servicios seleccionados en el carrito
    function actualizarCarrito() {
        let precioTotal = 0;
        let serviciosSeleccionados = [];

        casillas.forEach((casilla) => {
            if (casilla.checked) {
                // Obtenemos el valor del servicio y lo sumamos al precio total
                precioTotal += parseFloat(casilla.value);
                // Obtenemos el nombre del servicio y lo agregamos a la lista de servicios seleccionados
                serviciosSeleccionados.push(casilla.parentElement.querySelector('h4').textContent);
            }
        });

        // Mostramos el precio total en el carrito
        elementoTotalCarrito.textContent = precioTotal.toFixed(2) + '€';

        // Mostramos los servicios seleccionados en el carrito
        listaServiciosSeleccionados.innerHTML = ''; // Limpiar la lista antes de actualizar
        serviciosSeleccionados.forEach((servicio) => {
            const listItem = document.createElement('li');
            listItem.textContent = servicio;
            listaServiciosSeleccionados.appendChild(listItem);
        });

        // Mostramos u ocultamos el contenedor del carrito según si hay servicios seleccionados
        if (serviciosSeleccionados.length > 0) {
            contenedorCarrito.style.display = 'block';
        } else {
            contenedorCarrito.style.display = 'none';
        }
    }

    // Agregamos eventos de cambio a cada casilla de verificación
    casillas.forEach((casilla) => {
        casilla.addEventListener('change', actualizarCarrito);
    });

    // Llamamos a la función para actualizar el carrito inicialmente
    actualizarCarrito();
});
