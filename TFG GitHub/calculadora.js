// CALCULADORA DE PRECIOS

document.addEventListener('DOMContentLoaded', function() {
    // De esta manera obtenemos todos los elementos de las casillas de selección
    const casillas = document.querySelectorAll('.casilla');
    // Así obtenemos el elemento del precio total
    const elementoPrecioTotal = document.getElementById('preciototal');

    // Con esta función calculamos el precio total
    function calcularPrecioTotal() {
        let precioTotal = 0;
        casillas.forEach((casilla) => {
            if (casilla.checked) {
                // Obtener el valor del servicio y sumarlo al precio total
                precioTotal += parseFloat(casilla.value);
            }
        });
        // Así mostraríamos el precio total con dos decimales
        elementoPrecioTotal.textContent = precioTotal.toFixed(2) + '€';
    }

    // Con este evento de cambio le permitimos a las casillas cambiar
    casillas.forEach((casilla) => {
        casilla.addEventListener('change', calcularPrecioTotal);
    });

    // Y llamamos a la función para calcular el precio total inicial
    calcularPrecioTotal();
});
