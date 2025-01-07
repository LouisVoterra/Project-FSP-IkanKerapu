<?php
    require_once(__DIR__ . "/../Database/db.php");
    

    class Game extends DBParent {
        public function __construct() {
            parent::__construct();
        }

        public function getGame($keyword_judul, $offset=null,$limit = null) {
            $sql = "SELECT * FROM game WHERE name LIKE ?";
            if(!is_null($offset)) {
                $sql.= " LIMIT ?,?";
            }


            $stmt = $this->mysqli->prepare($sql);
            $keyword = "%{$keyword_judul}%";            
            if(!is_null($offset)) {
                $stmt->bind_param("sii", $keyword, $offset, $limit);
            } else {
                $stmt->bind_param("s", $keyword);
            }
            $stmt->execute();
            $result = $stmt->get_result();
            return $result;
        }

        public function getTotalData($keyword_judul) {
            $res = $this->getGame($keyword_judul);
            return $res->num_rows;
        }

        public function insertGame($arr_col) {
            $sql = "INSERT INTO game(name,description) 
            VALUES (?,?)";
            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param("ss",$arr_col['name'],$arr_col['description']);
            $stmt->execute();
            return $this->mysqli->insert_id;
        }

        public function updateGame($arr_col) {
            $sql = "UPDATE game SET name = ?, description = ? WHERE idgame = ?";
            $stmt = $this->mysqli->prepare($sql);
            
            if ($stmt === false) {
                die("Error preparing statement: " . $this->mysqli->error);
            }
        
            $stmt->bind_param("ssi", $arr_col['name'], $arr_col['description'], $arr_col['idgame']);
        
            $stmt->execute();
        
            if ($stmt->affected_rows > 0) {
                return true; 
            } else {
                return false; 
            }
        }

        public function getGameById($id) {
            $sql = "SELECT * FROM game WHERE idgame = ?";
            $stmt = $this->mysqli->prepare($sql);
            if ($stmt === false) {
                die("Error preparing statement: " . $this->mysqli->error);
            }
            
            $stmt->bind_param("i", $id);  
            $stmt->execute();
            
            $result = $stmt->get_result(); 
            $team = $result->fetch_assoc();
        
            $stmt->close();
            return $team;  
        }
        

        public function deleteGame($arr_col) {
            
            $sql = "DELETE FROM game WHERE idgame = ?";
            $stmt = $this->mysqli->prepare($sql);
            if ($stmt === false) {
                die("Error preparing statement: " . $this->mysqli->error);
            }
            $stmt->bind_param("i", $arr_col['idgame']);
            $stmt->execute();
            if ($stmt->affected_rows > 0) {
                return true; 
            } else {
                return false; 
            }
        }
    }
?>