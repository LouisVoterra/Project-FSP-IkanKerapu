<?php
    require_once("../Database/db.php");
    

    class Team extends DBParent {
        public function __construct() {
            parent::__construct();
        }

        public function getTeam($keyword_judul, $offset=null,$limit = null) {
            $sql = "SELECT t.idteam, g.name as game_name, t.name as team_name FROM team t 
                    INNER JOIN game g ON t.idgame = g.idgame
                    WHERE t.name LIKE ?";
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
            $res = $this->getTeam($keyword_judul);
            return $res->num_rows;
        }

        public function insertTeam($arr_col) {
            $sql = "INSERT INTO team(idgame, name) 
            VALUES (?,?)";
            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param("is",$arr_col['idgame'],
                              $arr_col['name']);
            $stmt->execute();
            return $this->mysqli->insert_id;
        }
    }
?>