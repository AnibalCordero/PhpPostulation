<?php 
    require_once('./../Libraries/connections.php');
    
    class User {
        /* User params */
        private $_id;
        private $_firstname;
        private $_pSurname;
        private $_birthdate;
        private $_rutNumber;
        private $_rutDigit;
        private $_password;
        private $_email;
        private $_profile_id;
        private $_secondname = null;
        private $_mSurname = null;
        private $conn;

        
        // consturctor with all data
        function __construct(){
            $connectionDb = new Connection;
            $this->conn =  $connectionDb->connect();
        }

        /* Getters and setters */
        public function getId(){ return $this->_id; }
        public function getFirstName(){ return $this->_firstname; }
        public function getPSurname(){ return $this->_pSurname; }
        public function getBirthdate(){ return $this->_birthdate; }
        public function getRutNumber(){ return $this->_rutNumber; }
        public function getRutDigit(){ return $this->_rutDigit; }
        public function getPassword(){ return $this->_password; }
        public function getEmail(){ return $this->_email; }
        public function getSecondname(){ return $this->_secondname; }
        public function getMSurname(){ return $this->_mSurname; }
        public function getProfileId(){ return $this->_profile_id; }
        
        public function setId($id){ $this->_id = $id; }
        public function setFirstname($firstname){ $this->_firstname = $firstname; }
        public function setpSurname($pSurname){ $this->_pSurname = $pSurname; }
        public function setBirthdate($birthdate){ $this->_birthdate = $birthdate; }
        public function setRutNumber($rutNumber){ $this->_rutNumber = $rutNumber; }
        public function setRutDigit($rutDigit){ $this->_rutDigit = $rutDigit; }
        public function setPassword($password){ $this->_password = $password; }
        public function setEmail($email){ $this->_email = $email; }
        public function setProfileId($profile_id){ $this->_profile_id = $profile_id; }
        public function setSecondname($secondname){ $this->_secondname = $secondname; }
        public function setMSurname($mSurname){ $this->_mSurname = $mSurname; }


        /**
         * Get all users
         */
        public function getAllUsers(){ 
            $sql = "select * from user where deleted_at is null";
            $query = $this->conn->prepare($sql);
            $query->execute();
            if($query->rowCount() > 0){
                $allUsersObj = [];
                foreach ($query->fetchAll(PDO::FETCH_OBJ) as $userData) {
                    $userToArray = new User();
                    $userToArray->setUserData($userData);
                    $allUsersObj[] = [
                        "id" => $userToArray->getId(),
                        "firstname" => $userToArray->getFirstName(),
                        "pSurname" => $userToArray->getPSurname(),
                        "rut" => $userToArray->getRutNumber().'-'.$userToArray->getRutDigit(),
                        "secondname" => $userToArray->getSecondname(),
                        "mSurname" => $userToArray->getMSurname(),
                    ];
                }
                return $allUsersObj;
            }
            return [];
        }
        
        /**
         * get all data user with id
         */
        public function getUserData(){
            $sql = "select * from user where id = ".$this->getId();
            $query = $this->conn->prepare($sql);
            $query->execute();
            $userDbData = $query->fetchAll(PDO::FETCH_OBJ)[0];
            $this->setUserData($userDbData);
           
        }

        /**
         * set data from user database obj
         */

        public function setUserData($userObj){
            $this->setId($userObj->id);
            $this->setFirstname($userObj->firstname);
            $this->setpSurname($userObj->p_surname);
            $this->setBirthdate($userObj->birthdate);
            $this->setRutNumber($userObj->rut_number);
            $this->setRutDigit($userObj->rut_digit);
            $this->setPassword($userObj->password);
            $this->setEmail($userObj->email);
            $this->setProfileId($userObj->profile_id);
            isset($userObj->secondname)?$this->setSecondname($userObj->secondname):'';
            isset($userObj->m_surname)?$this->setMSurname($userObj->m_surname):'';
        }
        
         /**
          * login user by Rut and Password
          */
        public function loginByRutAndPassword(){
            $sql = "select * from user where rut_digit = '".$this->getRutDigit()."' and rut_number = ".$this->getRutNumber()." and password = '".$this->getPassword()."' and deleted_at is null";
            $query = $this->conn->prepare($sql);
            $query->execute();
            if($query->rowCount() > 0){
                $userDbData = $query->fetchAll(PDO::FETCH_OBJ)[0];
                $this->setUserData($userDbData);
                return ['success' => true, 'userData' => [
                    "id" => $this->getId(),
                    "firstname" => $this->getFirstName(),
                    "rutNumber" => $this->getRutNumber(),
                    "rutDigit" => $this->getRutDigit(),
                    "profileId" => $this->getProfileId(),
                ]];
            }else{
                return ['success' => false, 'message' => 'Rut o Contraseña incorrecto'];
            }
        }

        /**
         * get User logged Data 
         */
        function getBaseData(){
            return[
                "id" => $this->getId(),
                "firstname" => $this->getFirstName(),
                "secondname" => $this->getSecondname(),
                "pSurname" => $this->getPSurname(),
                "mSurname" => $this->getMSurname(),
                "rutNumber" => $this->getRutNumber(),
                "rutDigit" => $this->getRutDigit(),
                "email" => $this->getEmail(),
                "birthdate" => $this->getBirthdate(),
                "profileId" => $this->getProfileId(),
            ];
        }
        

        /**
         * insert New User
         */
        function createNewUser(){
            $sql = "select * from user where rut_number = ".$this->getRutNumber()." and rut_digit = ".$this->getRutDigit();
            $query = $this->conn->prepare($sql);
            $query->execute();
            if($query->rowCount() > 0){
                return ["success" => false, "mesage" => "rut registrado"];
            }

            $sql = "INSERT INTO `user` (`id`, `firstname`, `secondname`, `p_surname`, `m_surname`, `birthdate`, `rut_number`, `rut_digit`, `password`, `email`, `profile_id`, `created_at`, `updated_at`, `deleted_at`) VALUES (NULL, '".$this->getFirstName()."', '".$this->getSecondname()."', '".$this->getPSurname()."', '".$this->getMSurname()."', '".$this->getBirthdate()."', ".$this->getRutNumber().", '".$this->getRutDigit()."', '".$this->getPassword()."', '".$this->getEmail()."', '".$this->getProfileId()."', current_timestamp(), current_timestamp(), NULL)";
            $query = $this->conn->prepare($sql);
            $query->execute();
            $newId = $this->conn->lastInsertId();
            $this->setId($newId);
            return ["success" => true, "newUserId" => $newId];
        }

        function editUser(){
            $sql = "UPDATE user SET firstname = '".$this->getFirstName()."', secondname = '".$this->getSecondname()."', p_surname = '".$this->getPSurname()."', m_surname = '".$this->getMSurname()."', birthdate = '".$this->getBirthdate()."', email = '".$this->getEmail()."', profile_id = '".$this->getProfileId()."' WHERE id = ".$this->getId().";";
            $query = $this->conn->prepare($sql);
            $query->execute();
            if($query->rowCount() > 0){
                return ["success" => true];
            }else{
                return ["success" => false, "message" => 'ha ocurrido un error al actualizar'];
            }
        }

        function deleteUser(){
            $sql = "UPDATE user SET deleted_at = current_timestamp() WHERE id = ".$this->getId().";";
            $query = $this->conn->prepare($sql);
            $query->execute();
            if($query->rowCount() > 0){
                return ["success" => true];
            }else{
                return ["success" => false, "message" => 'ha ocurrido al eliminar al usuario'];
            }
        }
    }
    

?>