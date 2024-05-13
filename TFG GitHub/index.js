//Creamos una variable, a través de la cual obtenemos el boton de whatsapp con un getElementById 
const whatsbtn = document.getElementById('whatsbtn');

//Creamos un evento para el boton, que cuando se haga click nos llevará al enlace del numero de whatsapp
whatsbtn.addEventListener('click', function() {
    const numero = '667806183';
    const link = `https://wa.me/${667806183}`;
    window.open(link, '_blank');
});

