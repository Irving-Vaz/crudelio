<?php 

require_once "conexion.php";
$conexion = conexion();

error_reporting(E_ALL);
ini_set('display_errors', 1);

$nombre  = $_POST['nombrej'] ?? '';
$anio    = $_POST['anioj'] ?? '';
$empresa = $_POST['empresaj'] ?? '';

$sql = "CALL sp_insertar_datos('$nombre','$anio','$empresa')";

$result = mysqli_query($conexion, $sql);

if (!$result) {
    echo "MYSQL ERROR: " . mysqli_error($conexion);
    exit();
}

mysqli_next_result($conexion);

echo 1;
