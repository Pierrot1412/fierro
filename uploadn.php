<?php
require_once ("../includes/config.ini.php");
date_default_timezone_set('US/Eastern');
require_once ("../includes/clases/conexion.php");
$conexion = sqlsrv_connect($serverName, $connectionInfo);

session_save_path($CONFIG->path);
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recibir los datos del formulario
    $numberCase = $_POST['numberCase'];
    $month = $_POST['month'];
    $year = $_POST['year'];
    $dateRequest = $_POST['dateRequest'];
    $upcNumber = $_POST['upcNumber'];
    $fsorretail = $_POST['fsorretail'];
    $item = $_POST['item'];
    $description = $_POST['description'];
    $complaintCategory = $_POST['complaintCategory'];
    $assignedEmployee = $_POST['asiggnedEmployee'];
    $lotCode = $_POST['lotCode'];
    $plant = $_POST['plant'];
    $lineType = $_POST['lineType'];
    $productionDate = $_POST['productionDate'];
    $productionTime = $_POST['productionTime'];
    $productionShift = $_POST['productionShift'];
    $expiryDate = $_POST['expiryDate'];
    $issueDescription = $_POST['issueDescription'];
    $customerContact = $_POST['customerContact'];
    $yearQuarter = $_POST['yearQuarter'];
    $week = $_POST['week'];
    $ComplaintSource = $_POST['ComplaintSource'];
    $CustomerName = $_POST['CustomerName'];
    $CouponType = $_POST['CouponType'];
    $assignedCoupons = $_POST['assignedCoupons'];
    $Address = $_POST['Address'];
    $DateResolved = $_POST['DateResolved'];
    $Phone = $_POST['Phone'];
    $Email = $_POST['Email'];
    $Comments = $_POST['Comments'];

    // Configuración para la carga de archivos
    $target_dir = "uploads/";
    $imageUpload = $_FILES['imageUpload'];
    $uploadOk = 1;
    $imageFileType = "";
    $uploadedFiles = [];
    $valorImagen = "NO";

    // Procesar cada archivo subido
    for ($i = 0; $i < count($imageUpload['name']); $i++) {
        if ($imageUpload['name'][$i] != '') {
            $imageFileType = strtolower(pathinfo($imageUpload['name'][$i], PATHINFO_EXTENSION));
            $target_file = $target_dir . basename($imageUpload['name'][$i]);
            $uploadOk = 1;

            // formatos permitidos
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "mp4") {
                echo "Sorry, only JPG, JPEG, PNG, GIF, and MP4 files are allowed.<br>";
                $uploadOk = 0;
            }

            // Subida de archivo
            if ($uploadOk == 1) {
                // case + file
                $final_file_name = $numberCase . '_' . pathinfo($imageUpload['name'][$i], PATHINFO_FILENAME) . '.' . $imageFileType;
                $final_file = $target_dir . $final_file_name;
                $counter = 1;
                while (file_exists($final_file)) {
                    $final_file_name = $numberCase . '_' . pathinfo($imageUpload['name'][$i], PATHINFO_FILENAME) . "_" . $counter . "." . $imageFileType;
                    $final_file = $target_dir . $final_file_name;
                    $counter++;
                }
                if (move_uploaded_file($imageUpload["tmp_name"][$i], $final_file)) {
                    echo "The file " . basename($final_file) . " has been uploaded.<br>";
                    $uploadedFiles[] = $final_file_name;
                    $valorImagen = "YES";
                } else {
                    echo "Sorry, there was an error uploading the file " . $imageUpload['name'][$i] . ".<br>";
                }
            } else {
                echo "Sorry, the file " . $imageUpload['name'][$i] . " was not uploaded.<br>";
            }
        }
    }

    // Preparar y ejecutar la declaración SQL
    $sqlInsertData = "INSERT INTO ComplaintManagement (
        CaseNum, Month, Year, Date, UPCNum, Channel, ItemNum, ItemDesc, Complaint_Category,
        Assigned_Employee, LotCode, Plant, LineType, ProdDate, ProdTime, ProdShift, ExpDate,
        IssueDesc, CustContact, YearQt, Week, ComplaintSource, CustomerName, CouponType,
        CouponQty, Address, DateResolved, Phone, Email, Comments, PictureProvided
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $params = array(
        $numberCase, $month, $year, $dateRequest, $upcNumber, $fsorretail, $item, $description,
        $complaintCategory, $assignedEmployee, $lotCode, $plant, $lineType, $productionDate,
        $productionTime, $productionShift, $expiryDate, $issueDescription, $customerContact,
        $yearQuarter, $week, $ComplaintSource, $CustomerName, $CouponType, $assignedCoupons,
        $Address, $DateResolved, $Phone, $Email, $Comments, $valorImagen
    );

    $stmtInsert = sqlsrv_query($conexion, $sqlInsertData, $params);
    if ($stmtInsert === false) {
        echo "Error in executing statement 3.\n";
        die(print_r(sqlsrv_errors(), true));
    }

    // Insertar información de los archivos subidos en la base de datos
    foreach ($uploadedFiles as $file) {
        $sqlInsertFile = "INSERT INTO PictureTable (CaseNumber, FileName) VALUES (?, ?)";
        $paramsFile = array($numberCase, $file);
        $stmtInsertFile = sqlsrv_query($conexion, $sqlInsertFile, $paramsFile);
        if ($stmtInsertFile === false) {
            echo "Error in executing file statement.\n";
            die(print_r(sqlsrv_errors(), true));
        }
    }

    // Redirigir al formulario principal
    header("Location: form6.php");
}
?>
