<?php
    require_once("../Database/db.php");
    

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
            $sql = "INSERT INTO game(idgame, name) 
            VALUES (?,?)";
            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param("is", $arr_col['idgame'],
                              $arr_col['name']);
            $stmt->execute();
            return $this->mysqli->insert_id;
        }
    }
?>