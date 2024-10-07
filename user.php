<?php
    require_once("dbparent.php");

    class User extends DBParent {
        public function __construct() {
            parent::__construct();
        }

        public function login($idmember, $password) {
            $sql = "SELECT * FROM member WHERE idmember = ?";
            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param("s", $idmember);
            $stmt->execute();
            $result = $stmt->get_result();

            if($result->num_rows > 0) {
                // cek password
                $row = $result->fetch_assoc();
                if(password_verify($password, $row['password'])) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }

        public function registration($arr_col) {
            $sql = "INSERT INTO member(idmemeber, fname, lname, username, password) 
            VALUES (?,?,?)";
            $stmt = $this->mysqli->prepare($sql);
            $hash_password = password_hash($arr_col['password'], PASSWORD_DEFAULT);
            $stmt->bind_param("sss", $arr_col['iduser'], $arr_col['nama'],
                              $hash_password);
            $stmt->execute();
            
            return $this->mysqli->affected_rows;
        }

        public function checkHakAkses($iduser, $hakakses){

            $sql = "SELECT * FROM 'menu_profil
            WHERE $iduser = (SELECT users.idprofil FROM users WHERE users.iduser = '?')
            AND idmenu = ?";
            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param("si", $iduser, $hakakses);
            $stmt->execute();
            $result = $stmt->get_result();

            if($result->num_rows > 0){
                return true;
            } else {
                return false;
            }

        }
    }
?>