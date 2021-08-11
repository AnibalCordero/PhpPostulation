<?php
    require_once('./../Libraries/connections.php');

    class Profile {
        /* Profile params */
        private $_id;
        private $_name;
        private $_description;
        private $conn;

        // consturctor with all data
        function __construct(){
            $connectionDb = new Connection;
            $this->conn =  $connectionDb->connect();
        }
        /* Getters and setters */
        public function getId(){ return $this->_id; }
        public function getName(){ return $this->_name; }
        public function getDescription(){ return $this->_description; }

        public function setId($id){ $this->_id = $id; }
        public function setName($name){ $this->_name = $name; }
        public function setDescription($description){ $this->_description = $description; }
        
        
        /**
         * Get profile data
        */
        public function getProfileData(){ 
            $sql = "select * from profile where id = $this->_id";
            $query = $this->conn->prepare($sql);
            $query->execute();
            if($query->rowCount() > 0){
                $profileData = $query->fetchAll(PDO::FETCH_OBJ)[0];
                $this->setName($profileData->name);
                $this->setDescription($profileData->description);
            }
        } 

        /**
         * Get all profiles
        */
        public function getAllProfiles(){
            $sql = "select * from profile";
            $query = $this->conn->prepare($sql);
            $query->execute();
    
            if($query->rowCount() > 0){
                $allProfilesObj = [];
                foreach ($query->fetchAll(PDO::FETCH_OBJ) as $profileData) {
                    $profileToArray = new Profile();
                    $profileToArray->setId($profileData->id);
                    $profileToArray->setName($profileData->name);
                    $profileToArray->setDescription($profileData->description);
                    $allProfilesObj[] = $profileToArray;
                };
                return $allProfilesObj;
            }
            return [];
        } 
    }
?>