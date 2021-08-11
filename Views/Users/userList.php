<head>
    <link rel="stylesheet" href="css/userForms.css">
</head>
<div class="row-fluid">
    <div class="userListContainer">
        <div class="col">
            <div class="userListTitle">
                Listado de Usuarios
            </div>
            <div class="userAddBtnContainer">
                <div class="btn btn-sm btn-success" onclick="openNewUserForm()" title="Crear nuevo usuario">
                    <i class="fas fa-plus"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="container">
        <div class="row userListTitleRow">
            <div class="col">
                Nombre
            </div>
            <div class="col">
                Rut
            </div>
            <div class="col">
                Acciones
            </div>
        </div>
    </div>
    <div class="container" id="usersListContainer"></div>
</div>