<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Turbo Clean - Lavadero de Coches</title>
    <link rel="stylesheet" href="index.css"> 
    <link rel="icon" href="logotipo.jpg" type="image/png">
</head>

<body>
<?php
// Verifica si el usuario ha dado su consentimiento
$consentimiento = isset($_COOKIE['consentimiento']) ? $_COOKIE['consentimiento'] : '';

// Este es el mensaje que sale
if ($consentimiento !== 'aceptado') {
    echo '<div id="mensaje-consentimiento">Este sitio web utiliza cookies para mejorar la experiencia del usuario. Al hacer clic en Aceptar, aceptas el uso de cookies. <button onclick="aceptarConsentimiento()">Aceptar</button><button onclick="denegarConsentimiento()">Denegar</button></div>';
}
?>

<header>
    <h1>INICIO</h1>
    <nav>
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="servicios.html">Servicios</a></li>
            <li><a href="cliente.html">Registro</a></li>
            <li><a href="login.html">Inicio de Sesion</a></li>
            <li><a href="reservas.html">Reservas</a></li>
            <li><a href="contacto.html">Contacto</a></li>
        </ul>
    </nav>
</header>

<main>
    <div style="display:flex">
        <section id="inicio" class="two-columns section-divider" style="flex: 1;">
            <div>
                <h4>FIABILIDAD GARANTIZADA</h4>
                <p>Somos el lavadero de coches líder en limpieza y cuidado vehicular.</p>
                <p>¡Nos comprometemos a darte nuestro servicio de calidad!</p>
                <br>
                <img src="INICIO/lavadero.jpg" alt="Lavadero de Coches">
            </div>
        </section>
        <section id="inicio" class="two-columns section-divider" style="flex:1;">
            <div>
                <h4>DISPONIBILIDAD AL 100%</h4>
                <p>Tenemos <span class="letrabonita">total disponibilidad</span> siempre que quieras contactar con nosotros.</p>
                <br>
                <br>
                <br>
                <br>
                <div id="contwhats">
                    <button id="whatsbtn">667 80 61 83</button>
                </div>
                <script src="index.js"></script>
            </div>
        </section>
        <section id="inicio" class="two-columns section-divider" style="flex:1;">
            <h4>ACTUALIZADOS</h4>
                <p>Mantenemos nuestros servicios siempre actualizados a innovar; ¡cada semana <span class="special-act">OFERTAS</span> nuevas!</p>
                <br>
                <br>
                <br>
                <div class="contoferta" onmouseover="cambiocolor()">
                    <p class="ofertatext">¡DESCUENTOS DE HASTA UN 50%!</p>
                </div>
        </section>
        <section id="inicio" class="two-columns section-divider" style="flex:1;">
            <div>
                <h4>SIEMPRE AL DETALLE</h4>
                <p>Somos un <span class="letrabonita">lavadero al detalle</span>, si desea tener un acabado que
                    haga relucir los detalles de su coche, ¡este es su sitio! 
                </p>
                <p>Limpieza <span class="letrabonita">completa y exhaustiva</span>
                    de su vehículo con herramientas y productos <span class="letrabonita">especializados</span>.
                </p>
                <img src="INICIO/detalle.jpg" alt="Lavadero al Detalle"/>
            </div>
        </section>
    </div>

    <div>
            <h4>SOBRE NOSOTROS</h4>
            <section id="equipo">
                <div style="text-align: center;">
                    <p><span class="letrabonita">NUESTRO PERSONAL</span></p>
                </div>
                <div class="empleado-gallery">
                    <div>
                        <img src="trabajadores/juan.jpg" alt="Juan" onmouseover="mostrarNombre(this)" onmouseout="ocultarNombre(this)">
                        <div class="nombre" style="display: none;">Juan</div>
                    </div>
                    <div>
                        <img src="trabajadores/andres.jpg" alt="Andrés" onmouseover="mostrarNombre(this)" onmouseout="ocultarNombre(this)">
                        <div class="nombre" style="display: none;">Andrés</div>
                    </div>
                    <div>
                        <img src="trabajadores/guille.jpg" alt="Guille" onmouseover="mostrarNombre(this)" onmouseout="ocultarNombre(this)">
                        <div class="nombre" style="display: none;">Guille</div>
                    </div>
                </div>
                <br>
                <div class="sobre-nosotros" style="flex:1;">
                    <br>
                    <br>
                    <p style="text-align: center;">Somos un equipo de profesionales apasionados por el cuidado de tu vehículo. En Turbo Clean, nos esforzamos por brindar el mejor servicio de lavado y mantenimiento para que tu coche luzca impecable en todo momento.</p>
            </section>
            <br>
            <br>
            <section id="inicio" class="section-divider">
                <p style="text-align:center;"><span class="letrabonita">NUESTRA UBICACIÓN</span></p>
                <div class="ubicacioncont">
                    <section id="mapa" class="column">
                        <div class="column" style="text-align: center;">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6444.704085198641!2d-5.454267923623481!3d36.13364070498861!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd0c94ceaad65e99%3A0x7897e0a967658cc8!2sIES%20Kursaal!5e0!3m2!1ses!2ses!4v1713253634732!5m2!1ses!2ses" width="400" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                    </section>
                    <div class="ubicacion column">
                        <p class="direccion">Calle de la Lavadora, 123, 46001 Valencia</p>
                    </div>
                </div>
            </section>
        </section>
    </div>

</main>

<aside>
    <div class="gallery">
        <img src="ASIDE/imagen1.jpg" alt="Imagen 1">
        <img src="ASIDE/imagen2.jpg" alt="Imagen 2">
        <img src="ASIDE/imagen3.jpg" alt="Imagen 3">
        <img src="ASIDE/imagen4.jpg" alt="Imagen 4">
        <img src="ASIDE/imagen5.jpg" alt="Imagen 5">
        <img src="ASIDE/imagen6.jpg" alt="Imagen 6">
        <img src="ASIDE/imagen7.jpg" alt="Imagen 7">
    </div>
</aside>

<footer>
    <nav>
        <ul>
            <li><a href="terms.html">Términos y Condiciones</a></li>
            <li><a href="privacy.html">Política de Privacidad</a></li>
            <li><a href="cookies.html">Política de Cookies</a></li>
        </ul>
    </nav>
    <p style="color: white;">&copy; 2024 Turbo Clean - Lavadero de Coches</p>
</footer>

<script src="index.js"></script>

</body>
</html>