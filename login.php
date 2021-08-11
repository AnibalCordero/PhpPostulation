<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Odontología</title>
    <link rel="icon" type="image/png" href="./favicon.png"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./css/login.css">
    <script src="./js/login.js"></script>
</head>
<body>  
    <div class="container" id="loginContainer">
        <div class="row">
            <div class="col">
                <div id="loginLogoContainer">
                    Odontología
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="input-group mb-2">
                    <input type="text" class="form-control" placeholder="Rut" required id="loginRut">
                </div> 
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="input-group mb-2">
                    <input type="password" class="form-control" placeholder="Contraseña" required id="loginPass">
                </div> 
            </div>
        </div>
        <div class="row">
            <div id="loginErrMsg"></div>
        </div>
        <div class="row">
            <div class="d-grid">
                <div class="btn btn-primary" onclick="validLoginUser()" id="loginSubmitBtn">Iniciar</div>
            </div>
        </div>
    </div>
</body>
</html> 