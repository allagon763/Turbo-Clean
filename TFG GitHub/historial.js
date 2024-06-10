document.addEventListener("DOMContentLoaded", function() {
    const botonesCancelar = document.querySelectorAll(".cancelar-btn");

    botonesCancelar.forEach(boton => {
        boton.addEventListener("click", function(evento) {
            evento.preventDefault(); // Así se previene la acción por defecto del botón
            const idReserva = this.getAttribute("data-reserva-id");

            if (confirm("¿Estás seguro de que deseas cancelar esta reserva?")) {
                // Creamos un formulario para enviar la solicitud de cancelación
                const formulario = document.createElement("form");
                formulario.method = "POST";
                formulario.action = "historial.php";

                // Creamos un campo oculto para el ID de la reserva
                const entrada = document.createElement("input");
                entrada.type = "hidden";
                entrada.name = "cancelar_reserva_id";
                entrada.value = idReserva;

                formulario.appendChild(entrada);
                document.body.appendChild(formulario);
                formulario.submit();
            }
        });
    });
});
