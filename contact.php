<?php
$nombre = $_POST['nombre'];
$telefono = $_POST['telefono'];
$correo = $_POST['correo'];
$servicio = $_POST['servicio'];
$fecha = $_POST['fecha'];
$observaciones = $_POST['observaciones'];

if(!empty($nombre) || !empty($telefono) || !empty($correo) || !empty($servicio) || !empty($fecha) || !empty($observaciones)) {
    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "81745014";
    $dbname = "farmiAhorro";
    $dbtable = "citas";

    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);
    if(mysqli_connect_error()) {
        die('connect error'(. mysqli_connect_errno().')'. mysqli_connect_error());
    } else {
        $SELECT = "SELECT telefono from citas where telefono = ? limit 1";
        $INSERT = "INSERT into citas (nombre, telefono, correo, servicio, fecha, observaciones) values(?, ?, ?, ?, ?, ?)";  

        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("s", $telefono);
        $stmt->execute();
        $stmt->bind_result($telefono);
        $stmt->store_result();
        $rnum = $stmt->num_rows;
        if($rnum==0) {
            $stmt->close();
            $stmt = $conn->prepare($INSERT);
            $stmt->bind_param("ssssss", $nombre, $telefono, $correo, $servicio, $fecha, $observaciones);
            if($stmt->execute()) {
                echo "Cita agendada correctamente";
            } else {
                echo "Error al agendar la cita";
            }
        } else {
            echo "Ya existe una cita con ese telefono";
        }
        $stmt->close();
        $conn->close();
    }
}
else {
    echo "Todos los datos son obligatorios";
    die();
}