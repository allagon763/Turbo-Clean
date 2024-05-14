    //BOTÓN DE WHATSAPP

//Creamos una variable, a través de la cual obtenemos el boton de whatsapp con un getElementById 
const whatsbtn = document.getElementById('whatsbtn');

//Creamos un evento para el boton, que cuando se haga click nos llevará al enlace del numero de whatsapp
whatsbtn.addEventListener('click', function() {
    const numero = '667806183';
    const link = `https://wa.me/${667806183}`;
    window.open(link, '_blank');
});

    //NOMBRE DE LOS EMPLEADOS

//Mostrar y ocultar nombre de los empleados
function mostrarNombre(img) {
    var nombreEmpleado = img.nextElementSibling; // De esta manera obtenemos el div con el nombre del empleado, ya que se selecciona el elemento hermano
    nombreEmpleado.style.display="block"; // Así se muestra el nombre del empleado
}

function ocultarNombre(img) {
    var nombreEmpleado = img.nextElementSibling; 
    nombreEmpleado.style.display = "none"; // Así se oculta el nombre del empleado
}

    //CAMBIO COLOR OFERTAS

//De esta manera cambiamos el color del texto al colocar el cursor encima
let currentColorIndex = 0;
const colors = ['#ff5733', '#33ff57', '#5733ff']; // Este es un array que contiene los colores que saldran cada vez que pongamos el cursos encima

function cambiocolor() {
    const texto = document.querySelector('.ofertatext');
    texto.style.color = colors[currentColorIndex];
    currentColorIndex = (currentColorIndex + 1) % colors.length; // De esta manera avanza al siguiente color circularmente (basicamente, si no colocamos esto no cambian los colores)
}
