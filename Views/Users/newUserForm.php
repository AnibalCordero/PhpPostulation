<head>
    <link rel="stylesheet" href="css/userForms.css">
</head>
<form class="container">
    <div class="row userFormContainer mb-4">
        <div class="col text-center">
            <div class="returnBtnContainer">
                <div class="btn btn-sm btn-primary" onclick="selectMenu('adminUser')"><i class="fas fa-arrow-left"></i></div>
            </div>
            <div class="createUserTitle" id="createUserTitle">Crear nuevo usuario</div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="input-group mb-2">
                <span class="input-group-text">Rut (*)</span>
                <input type="text" class="form-control" placeholder="Ingresar Rut" required id="userInputRut">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="input-group mb-2">
                <span class="input-group-text">Nombre (*)</span>
                <input type="text" class="form-control" placeholder="Ingresar primer nombre" id="userInputFirstname" required>
            </div>
        </div>
        <div class="col">
            <div class="input-group mb-2">
                <span class="input-group-text">Segundo nombre</span>
                <input type="text" class="form-control" placeholder="Ingresar segundo nombre" id="userInputSecondname">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="input-group mb-2">
                <span class="input-group-text">Apellido Paterno (*)</span>
                <input type="text" class="form-control" placeholder="Ingresar apellido paterno" id="userInputPSurname" required>
            </div> 
        </div>
        <div class="col">
            <div class="input-group mb-2">
                <span class="input-group-text">Apellido Materno</span>
                <input type="text" class="form-control" placeholder="Ingresar apellido paterno" id="userInputMSurname">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="input-group mb-2">
                <span class="input-group-text">Cumpleaños</span>
                <input type="date" class="form-control" required id="userInputBirthdate">
            </div>
        </div>
        <div class="col">
            <div class="input-group mb-2">
                <span class="input-group-text">Email</span> 
                <input type="text" class="form-control" placeholder="Ingresar email"  id="userInputEmail">
            </div>
        </div>
        <div class="col">
            <div class="input-group mb-4">
                <span class="input-group-text">Perfil</span>
                <select class="form-select" id="userProfileSelect">
                    <option selected value="0">--</option>
                </select>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col">
            <div id="userPassMessage">El usuario tendrá por contraseña su apellido y el dígito verificador de su RUT</div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div id="userFormErrMsg"></div>
        </div>
    </div>

    <div class="row">
        <div class="d-grid">
            <div class="btn btn-success" id="userFormBtn" onclick="validateNewUser()">
                Añadir  nuevo usuario
            </div>
        </div>
    </div>
</form>