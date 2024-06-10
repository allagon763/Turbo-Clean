<?php
session_start();

// Verificamos si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    // Si el usuario no está autenticado, redirigimos al formulario de inicio de sesión
    header("Location: login.html");
    exit();
}

// Si el usuario está autenticado, obtenemos su ID
$user_id = $_SESSION['user_id'];

// Conectamos a la base de datos
$conex = mysqli_connect("localhost", "root", "", "TFG");

// Verificamos la conexión
if (!$conex) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}

// Manejamos la cancelación de reservas
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["cancelar_reserva_id"])) {
    $id_reserva = $_POST["cancelar_reserva_id"];
    $fecha_actual = date('Y-m-d');

    // Verificamos si la reserva es con al menos 1 día de antelación
    $sql_cancelar_reserva = "DELETE FROM reserva WHERE reserva_id = '$id_reserva' AND user_id = '$user_id'";
    if (mysqli_query($conex, $sql_cancelar_reserva)) {
        echo '<div id="mensaje-exito">¡Reserva cancelada con éxito!</div>';
    } else {
        echo '<div id="mensaje-error">Error al cancelar la reserva: ' . mysqli_error($conex) . '</div>';
    }
}

// Obtenemos el historial de reservas del usuario
$sql_historial_reservas = "SELECT * FROM reserva WHERE user_id = '$user_id' ORDER BY fecha DESC, hora DESC";
$resultado_historial_reservas = mysqli_query($conex, $sql_historial_reservas);

// Cerramos la conexión
mysqli_close($conex);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Turbo Clean - Lavadero de Coches</title>
    <link rel="stylesheet" href="index.css"> 
    <link rel="icon" href="logotipo.jpg" type="image/png">
    <style>
        #particles-js {
            position: absolute;
            width: 100%;
            height: 100%;
            background: #f5fbff;
            z-index: -1;
        }
        body {
            transition: background 1s ease;
            overflow: auto;
        }
        #contenido {
            position: relative;
            z-index: 1;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div id="particles-js"></div>
    <div id="contenido">
        <h1>Historial de Reservas</h1>

        <section id="historial">
            <div class="info-cancel">
                <p>Recuerde que no se pueden cancelar los servicios con menos de un día de antelación.</p>
            </div>
        </section>

        <div id="historialcont">
            <?php
            // Mostramos el historial de reservas
            if (mysqli_num_rows($resultado_historial_reservas) > 0) {
                while ($row = mysqli_fetch_assoc($resultado_historial_reservas)) {
                    // Aquí mostramos la información de cada reserva
                    echo "<div class='reserva'>";
                    echo "<h5>Fecha: " . $row["fecha"] . " - Hora: " . $row["hora"] . " - Servicio: " . $row["nombre"] . "</h5>";
                    $fecha_actual = date('Y-m-d');
                    $fecha_reserva = $row["fecha"];
                    if ($fecha_reserva > date('Y-m-d', strtotime($fecha_actual . ' + 1 day'))) {
                        // Solo se muestra el botón de cancelar si queda más de un día para la reserva
                        echo "<form method='POST' action='historial.php'>";
                        echo "<input type='hidden' name='cancelar_reserva_id' value='" . $row['reserva_id'] . "'>";
                        echo "<button type='submit' class='cancelar-btn' data-reserva-id='" . $row['reserva_id'] . "'>Cancelar Reserva</button>";
                        echo "</form>";
                    }
                    echo "</div>";
                }
            } else {
                echo "<p>No se encontraron reservas.</p>";
            }
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script>
        particlesJS("particles-js", {
            "particles": {
                "number": {
                    "value": 80,
                    "density": {
                        "enable": true,
                        "value_area": 800
                    }
                },
                "color": {
                    "value": "#475469"
                },
                "shape": {
                    "type": "circle",
                    "stroke": {
                        "width": 0,
                        "color": "#000000"
                    },
                    "polygon": {
                        "nb_sides": 5
                    }
                },
                "opacity": {
                    "value": 0.5,
                    "random": false,
                    "anim": {
                        "enable": false,
                        "speed": 1,
                        "opacity_min": 0.1,
                        "sync": false
                    }
                },
                "size": {
                    "value": 3,
                    "random": true,
                    "anim": {
                        "enable": false,
                        "speed": 40,
                        "size_min": 0.1,
                        "sync": false
                    }
                },
                "line_linked": {
                    "enable": true,
                    "distance": 150,
                    "color": "#ffffff",
                    "opacity": 0.4,
                    "width": 1
                },
                "move": {
                    "enable": true,
                    "speed": 6,
                    "direction": "none",
                    "random": false,
                    "straight": false,
                    "out_mode": "out",
                    "bounce": false,
                    "attract": {
                        "enable": false,
                        "rotateX": 600,
                        "rotateY": 1200
                    }
                }
            },
            "interactivity": {
                "detect_on": "canvas",
                "events": {
                    "onhover": {
                        "enable": true,
                        "mode": "repulse"
                    },
                    "onclick": {
                        "enable": true,
                        "mode": "push"
                    },
                    "resize": true
                },
                "modes": {
                    "grab": {
                        "distance": 400,
                        "line_linked": {
                            "opacity": 1
                        }
                    },
                    "bubble": {
                        "distance": 400,
                        "size": 40,
                        "duration": 2,
                        "opacity": 8,
                        "speed": 3
                    },
                    "repulse": {
                        "distance": 200,
                        "duration": 0.4
                    },
                    "push": {
                        "particles_nb": 4
                    },
                    "remove": {
                        "particles_nb": 2
                    }
                }
            },
            "retina_detect": true
        });

        document.addEventListener("DOMContentLoaded", function() {
            const botonesCancelar = document.querySelectorAll(".cancelar-btn");

            botonesCancelar.forEach(boton => {
                boton.addEventListener("click", function(evento) {
                    evento.preventDefault(); // Prevenir la acción por defecto del botón
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
    </script>
</body>
</html>
