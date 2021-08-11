<?php 
    require_once('./../Models/profile.php');
    $json = file_get_contents('php://input');
    $data = json_decode($json);
    // switch to make router for Profile controller
    switch ($data->type) {
        case 'getAllProfiles':
            echo json_encode(getAllProfiles());
            break;
        case 'menuRouter':
            echo json_encode(menuRouter($data->menuType));
            break;
        default:
            echo json_encode(["error" => 'No se ha seleccionado una ruta registrada']);
            break;
    }

    function getAllProfiles(){
        $profileObj = new Profile();
        $profiles = $profileObj->getAllProfiles();
        $profilesArray = [];
        foreach ($profiles as $profile) {
            $profilesArray[] = [
                'id' => $profile->getId(),
                'name' => $profile->getName(),
            ];
        }
        return $profilesArray;
    }

    function menuRouter($menuType){
        switch ($menuType) {
            case 'adminUser':
                $pageSelected = file_get_contents('./../Views/Users/userList.php');
                break;
            
            default:
                $pageSelected = file_get_contents('./../Views/workInProgress.php');
                break;
        }
        return $pageSelected;
    }
    
?>