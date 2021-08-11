<?php 
    require_once('./../Models/user.php');
    $json = file_get_contents('php://input');
    $data = json_decode($json);
    // switch to make router for Profile controller
    switch ($data->type) {
        case 'validateUser':
            echo json_encode(validateUser($data->userData));
            break;
        case 'loginUser':
            echo json_encode(loginUser($data->userData));
            break;
        case 'getAllUsersList':
            echo json_encode(getAllUsersList());
            break;
        case 'getNewUserForm':
            echo json_encode(createOrEditUser($data->userId));
            break;
        case 'createNewUser':
            echo json_encode(createNewuser($data->userData));
            break;
        case 'editUser':
            echo json_encode(editUser($data->userData));
            break;
        case 'deleteUser':
            echo json_encode(deleteUser($data->userId));
            break;
        default:
            echo json_encode(["success" => false, "error" => 'No se ha seleccionado una ruta registrada']);
            break;
    }

    function validateUser($userData){
        if(isset($userData)){
            $user = new User;
            $user->setId($userData->id);
            $user->getUserData();
            $userDataRes = $user->getBaseData();
            $userDataRes['menuView'] = getUserMenu($userDataRes);
            if($userData->firstname == $user->getFirstName() && $userData->rutNumber == $user->getRutNumber() && $userData->rutDigit == $user->getRutDigit()){
                return ['success' => true, 'message' => 'usuario registrado', 'userData' => $userDataRes];
            }
        }else{
            return ['success' => false, 'message' => 'usuario no identificado'];
        }
    }

    function getUserMenu($userData){
        switch ($userData['profileId']) {
            case "1":
                $menuView = file_get_contents('./../Views/Menu/adminMenu.php');
                break;
            case "2":
                $menuView = file_get_contents('./../Views/Menu/doctorMenu.php');
                break;
            case "3":
                $menuView = file_get_contents('./../Views/Menu/clienteMenu.php');
                break;
            default:
                $menuView = 'No hay menú disponible';
                break;
        }
        return $menuView;
    }

    function loginUser($userData){
        $userToValidate = new User;
        $userToValidate->setRutDigit(explode('-',$userData->rut)[1]);
        $userToValidate->setRutNumber(implode('',explode('.',explode('-',$userData->rut)[0])));
        $userToValidate->setPassword($userData->password);
        return $userToValidate->loginByRutAndPassword();
    }

    function getAllUsersList(){
        $userToList = new User;
        $usersList = $userToList->getAllUsers();
        return $usersList;
    }

    function createNewUser($userData){
        $userToCreate = new User;
        $userToCreate->setRutDigit(explode('-',$userData->rut)[1]);
        $userToCreate->setRutNumber(implode('',explode('.',explode('-',$userData->rut)[0])));
        $userToCreate->setFirstname($userData->firstname);
        $userToCreate->setSecondname($userData->secondname);
        $userToCreate->setpSurname($userData->pSurname);
        $userToCreate->setMSurname($userData->mSurname);
        $userToCreate->setBirthdate($userData->birthdate);
        $userToCreate->setEmail($userData->email);
        $userToCreate->setProfileId($userData->userProfileId);
        $userToCreate->setPassword($userData->pSurname.explode('-',$userData->rut)[1]);
        return $userToCreate->createNewUser();
    }

    function editUser($userData){
        $userToEdit = new User;
        $userToEdit->setId($userData->id);
        $userToEdit->setRutDigit(explode('-',$userData->rut)[1]);
        $userToEdit->setRutNumber(implode('',explode('.',explode('-',$userData->rut)[0])));
        $userToEdit->setFirstname($userData->firstname);
        $userToEdit->setSecondname($userData->secondname);
        $userToEdit->setpSurname($userData->pSurname);
        $userToEdit->setMSurname($userData->mSurname);
        $userToEdit->setBirthdate($userData->birthdate);
        $userToEdit->setEmail($userData->email);
        $userToEdit->setProfileId($userData->userProfileId);
        $userToEdit->setPassword($userData->pSurname.explode('-',$userData->rut)[1]);
        return $userToEdit->editUser();

    }
    
    function createOrEditUser($userId){
        if(isset($userId) && $userId != null){
            $userToEdit = new User;
            $userToEdit->setId($userId);
            $userToEdit->getUserData();
            return (['html' => file_get_contents('./../Views/Users/newUserForm.php'), "userData" => $userToEdit->getBaseData()]);
        }else{
            return (['html' => file_get_contents('./../Views/Users/newUserForm.php')]);
        }
    }

    function deleteUser($userId){
        $userToDelete = new User();
        $userToDelete->setId($userId);
        return $userToDelete->deleteUser();
    }
    
?>