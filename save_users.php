<?php
//conexiona la base de datos
$severName = "";
$opcionesconexcion = array(
  "Database" => "nombrebasededatos";
  "Uid" => "usuarioparaingresar";
  "PwD" => "contrasena"
);
$conexion = sqlsrv_connect($severName, $opcionesconexcion);

//validar la conexion
if ($conexion === false){
  echo "Cannot conect to server. Error: ". print_r(sqlsrv_errors(), true);
  exit();
}

//datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST"){
//obtener datos del formulario
$courses = $_POST['courses'];
$employeeNumbers = $_POST['employeeNumber'];
$firstNames = $_POST['firstName'];
$lastNames = $_POST['lastName'];
$plants = $_POST['plant'];

//insertar en la base de datos
$sql = "INSERT INTO users (course, employeeNumber, firstName, lastName, plant) VALUES (?, ?, ?, ?, ?)";
$params = array();
$smtp = sqlsrv_prepare($conexion, $sql, $params);

//verificiar si fue exitosa la conexion
if (smtp === false) {
 echo "error al preparar la consulta. Error: ". print_r(sqlsrv_errors(), true);
 sqlsrv_close($conexion);
 exit();
}

//ejecutar para cada ususario
for ($i = ; i < count($courses); $i++){
  $params = array($courses[$i], $employeeNumbers[$i], $firstNames[$i], $lastNames[$i], $plants[$i]);
  if (!sqlsrv_execute($stmt,$params)) {
      echo "Error al ejecutar la consulta para el usuario $i. Error: ".print_r(sqlsrv_errors(), true)
      sqlsrv_close($conexion);
      exit();
  }
}

//En caso de que todo saliera bien
echo "Usuarios agregados correctamente.";

//cerrar la conexion
sqlsrv_close($conexion);
}
 ?>
