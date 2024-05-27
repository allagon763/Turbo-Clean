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
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    // El usuario no está autenticado, redirigir al formulario de inicio de sesión
    header("Location: login.html");
    exit();
}

// El usuario está autenticado, obtener su ID
$user_id = $_SESSION['user_id'];

// Verificar si se reciben datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $nombre = $_POST["nombre"];
    $fecha = $_POST["fecha"];
    $hora= $_POST["hora"]; // Hora ingresada por el usuario

    // Agregar ":00" para representar los segundos y formatear la hora
    $hora_formateada = $hora . ":00";

    // Conectar a la base de datos
    $conex = mysqli_connect("localhost", "root", "", "TFG");

    // Verificar la conexión
    if (!$conex) {
        die("Error al conectar con la base de datos: " . mysqli_connect_error());
    }

    // Obtener la fecha actual
    $fecha_actual = date('Y-m-d');

    // Verificar si la fecha seleccionada es anterior a la fecha actual
    if ($fecha < $fecha_actual) {
        echo '<div id="mensaje-error">No puedes reservar para fechas pasadas.</div>';
    } else {
        // Convertir la hora ingresada por el usuario a un objeto DateTime
        $hora_seleccionada = new DateTime($hora_formateada);

        // Definir el rango de horas permitidas
        $hora_inicio_manana = new DateTime('08:00:00');
        $hora_fin_manana = new DateTime('14:00:00');
        $hora_inicio_tarde = new DateTime('16:00:00');
        $hora_fin_tarde = new DateTime('20:00:00');

        // Verificar si la hora seleccionada está dentro de los rangos permitidos
        if (($hora_seleccionada >= $hora_inicio_manana && $hora_seleccionada <= $hora_fin_manana) ||
            ($hora_seleccionada >= $hora_inicio_tarde && $hora_seleccionada <= $hora_fin_tarde)) {

            // Calcular la hora 2 horas antes y después
            $hora_2_horas_antes = clone $hora_seleccionada;
            $hora_2_horas_antes->modify('-2 hours');
            $hora_2_horas_despues = clone $hora_seleccionada;
            $hora_2_horas_despues->modify('+2 hours');

            // Convertir la fecha seleccionada a formato de base de datos
            $fecha = date('Y-m-d', strtotime($fecha));

            // Preparar la consulta SQL para verificar si hay reservas dentro del rango de 2 horas
            $sql = "SELECT * FROM reserva WHERE fecha = '$fecha' AND hora BETWEEN '" . $hora_2_horas_antes->format('H:i:s') . "' AND '" . $hora_2_horas_despues->format('H:i:s') . "'";
            $resultado = mysqli_query($conex, $sql);

            if (mysqli_num_rows($resultado) > 0) {
                // Ya hay una reserva dentro del rango de 2 horas
                echo '<div id="mensaje-error">Ya hay una cita reservada dentro de las 2 horas antes o después de la hora seleccionada. Por favor, elige otra hora.</div><br>';
            } else {
                // No hay reservas dentro del rango de 2 horas, proceder con la inserción de la reserva
                // Convertir la hora seleccionada a formato de base de datos
                $hora = $hora_seleccionada->format('H:i:s');

                // Preparar la consulta SQL para insertar la reserva en la tabla reserva
                $sql_insert_reserva = "INSERT INTO reserva (nombre, fecha, hora, user_id) VALUES ('$nombre','$fecha','$hora', '$user_id')";

                // Ejecutar la consulta
                if (mysqli_query($conex, $sql_insert_reserva)) {
                    echo '<div id="mensaje-reserva">¡Reserva realizada con éxito!</div><br>';
                } else {
                    echo '<div id="mensaje-error">Error al procesar la reserva: ' . mysqli_error($conex) . '</div>';
                }
            }
        } else {
            // La hora seleccionada no está dentro de los rangos permitidos
            echo '<div id="mensaje-error">Lo sentimos, solo se pueden reservar citas entre las 8:00 - 14:00 y 16:00 - 20:00.</div>';
        }
    }

    // Cerrar la conexión
    mysqli_close($conex);
} else {
    // Si no se reciben datos del formulario, redirigir a la página de reservas
    header("Location: reservas.html");
    exit();
}
?>
    
<div class="button-container">
    <a href="reservas.html" class="return-button">Volver a Reservas</a>
</div> 

</body>
</html>
