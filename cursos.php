<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width-device-width, initial-scale=1.0">
  <title>Create User fields</title>
  <!-- Enlace Bootstrapt-->
  <link href="https://maxcdn.bootstraptcdn.com/bootstrapt/4.5.2/css/bootstrapt.min.css" rel="stylesheet">
  <style>
  .excel-table {
    border-collapse: collapse;
    width: 100%;
  }
  .excel-table th,   .excel-table td{
    border: 1px solid #ddd;
    padding: 8px;
    text-align: center;
  }

  .excel-table th{
    background: blue;
  }
  .excel-table th:first-child, .excel-table td:first-child{
    border-left: none;
  }
   .excel-table th:last-child, .excel-table td:last-child{
     border-right: none;
   }
   .excel-table tr:nth-child(even){
     background-color: #f2f2f2;
   }
</style>
</head>
  <body>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3 offset-md-4 text-center">
          <h2 class="text-center">Create Users Fields</h2>
        </div>
      </div>

      <div class="row">
        <div class="col-md-3 offset-md-4 text-center">
          <p class="text-center">Enter the number of user to add: </p>
          <input type="number" id="cantidadUsuarios" min="1" value="1">
          <br><br>
          <button class="btn btn-primary btn-block" onclick="createFields()">Create Fields</button>
        </div>
      </div>

      <div id="fieldContainer" class="mt-3">
        <!--nombre de los campos en la tablea-->
        <table class="excel-table">
          <thead>
            <tr>
              <th>Course</th>
              <th>Employee No.</th>
              <th>Fisrt Name</th>
              <th>Last Name</th>
              <th>Plant</th>
            <tr>
          </thead>
        </table>
      </div>
      <div id="userData" class="mt-3">
        <!--campos que seran agregados dependiendo la cantidad de usuarios-->
      </div>
      <div class="row">
        <div class="col-md-3 offset-md-4">
          <button id="addUsersBtn" style="display:none;" class="btn btn-success btn-block mt-3" onclick="addUsers()"> Add Users</button>
        </div>
      </div>
    </div>

<script>
function createFields(){
  var quantity = document.getElementById("cantidadUsuarios").value;
  var container = document.getElementById("userData");
  var addUsersBtn = document.getElementById("addUsersBtn");

  //limpiar el fieldContainer

  container.innerHTML = '';

  //crear los campos conel ciclo FOR
  for (var i = 0; i<quantity; i++){
    var newRow = document.createElement("div");
    newRow.className = "row";

    newRow.innerHTML = `
      <table class="excel-table">
        <tbody>
          <tr>
            <td><input type="text" id="course${i}" name="course${i}" class="form-control" placeholder="Enter Course"></td>
            <td><input type="text" id="employeeNumber${i}" name="employeeNumber${i}" class="form-control" placeholder="Enter Employee number"></td>
            <td><input type="text" id="firstName${i}" name="firstName${i}" class="form-control" placeholder="Enter First Name"></td>
            <td><input type="text" id="lastName${i}" name="lastName${i}" class="form-control" placeholder="Enter Last Name"></td>
            <td><input type="text" id="plant${i}" name="plant${i}" class="form-control" placeholder="Enter Plant"></td>
          </tr>
        </tbody>
      </table>
    `;
    container.appendChild(newRow);
  }
  //molstrar el boton para agregar usuarios
  addUsersBtn.style.display = "block";
}

function addUsers(){
  var quantity = document.getElementById("cantidadUsuarios").value;
  var formData = new FormData();
  //llenado de campos del formulario
  for (var i = 0; i < quantity; i++){
    var course = document.getElementById("course" + i).value;
    var employeeNumber = document.getElementById("employeeNumber" + i).value;
    var firstName = document.getElementById("firstName" + i).value;
    var lastName = document.getElementById("lastName" + i).value;
    var plant = document.getElementById("plant" + i).value;
    formData.append('course[]', course);
    formData.append('employeeNumber[]', employeeNumber);
    formData.append('firstName[]', firstName);
    formData.append('lastName[]', lastName);
    formData.append('plant[]', plant);
  }

  //documento donde ayudara a almacenar procesar los datos para el almacenamiento
  var url = 'insert.php';

// enviar el request al servidor
fetch(url,{
    method: 'POST',
    body: FormData
  })
  .then(response => {
    if (response.ok){
      //si la respues es satisfactoria se le mostrara el memsaje al cantidadUsuarios
      alert('Users Added Successfully.');
    }else{
      //si existe algun error arrojara el siguiente mensaje de error
      alert('Error Adding Users');
      }
  })
  .catch(error => {
    console.error('Error:', error);
  });
}
</script>
</body>
</html>
