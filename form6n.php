<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COMPLAINT REPORT</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
    <script type="text/javascript" src="../js/downloadFile.js"></script>
    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title">COMPLAINT REPORT</h3>
        </div>
        <div class="card-body">
            <form action="upload.php" method="post" enctype="multipart/form-data">
                <!-- Otros campos del formulario -->
                
                <div class="form-group mb-3">
                    <label class="form-check-label">DO YOU WANT ADD IMAGE OR VIDEO?</label>
                    <input class="form-check-input" type="checkbox" id="displayCheck">
                    <div class="form-row mb-3" id="fileInput" style="display:none;">
                        <hr>
                        <label for="imageUpload" class="form-label">SELECT IMAGE OR VIDEO</label>
                        <input class="form-control" type="file" name="imageUpload[]" id="imageUpload" multiple accept="image/*,video/*">
                    </div>
                </div>
                
                <div class="form-group mb-3">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('displayCheck').onchange = function(){
    if (this.checked) {
        document.getElementById('fileInput').style.display='block';
    } else {
        document.getElementById('fileInput').style.display='none';
    }
}
</script>
<!-- Bootstrap core JavaScript-->
<script src="../vendor/jquery/jquery.min.js"></script>
<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Core plugin JavaScript-->
<script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
<!-- Custom scripts for all pages-->
<script src="../js/sb-admin-2.min.js"></script>
<!-- Page level plugins -->
<script src="../vendor/datatables/jquery.dataTables.min.js"></script>
<script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>
<!-- Page level custom scripts -->
<script src="../js/demo/datatables-demo.js"></script>
<script>
    $(document).ready(function() {
        $(".selected-row").click(function() {
            $(this).toggleClass("highlight");
        });
    });
</script>
<script>
    var dateRequest = new Date();
    var year = dateRequest.getFullYear();
    var month = (dateRequest.getMonth() + 1).toString().padStart(2, '0');
    var day = dateRequest.getDate().toString().padStart(2, '0');
    var formattedDate = year + '-' + month + '-' + day;
    document.getElementById('dateRequest').value = formattedDate;
</script>
</body>
</html>
