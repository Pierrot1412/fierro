<?php
$serverName = "WSF30279EESQUIV";
$connectionOptions = array(
    "Database" => "calendar",
    "Uid" => "sa",
    "PWD" => "Jose141290"
);

// Establecer la conexión
$conexion = sqlsrv_connect($serverName, $connectionOptions);
if ($conexion === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Consulta SQL
$sql = "SELECT * FROM [ProdInputInfo]";
$query = sqlsrv_query($conexion, $sql);
if ($query === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Obtener los datos
$data = [];
while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
    $data[] = $row;
}

// Convertir los datos a JSON para usar en JavaScript
header('Content-Type: application/json');
echo json_encode($data);
?>
