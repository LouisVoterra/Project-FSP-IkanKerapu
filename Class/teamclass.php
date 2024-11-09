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

        public function updateTeam($arr_col) {
            $sql = "UPDATE team SET name = ?, idgame = ? WHERE idteam = ?";
            $stmt = $this->mysqli->prepare($sql);
            
            if ($stmt === false) {
                die("Error preparing statement: " . $this->mysqli->error);
            }
        
            $stmt->bind_param("sii", $arr_col['name'], $arr_col['idgame'], $arr_col['idteam']);
        
            $stmt->execute();
        
            if ($stmt->affected_rows > 0) {
                return true; 
            } else {
                return false; 
            }
        }

        public function getAllTeams() {
            
            $sql = "SELECT * FROM team";
            $stmt = $this->mysqli->prepare($sql);
        
            if ($stmt === false) {
                error_log("Error preparing statement: " . $this->mysqli->error);
                return null;
            }
        
            $stmt->execute();
            $result = $stmt->get_result();
            $teams = [];
            while ($row = $result->fetch_assoc()) {
                $teams[] = $row;
            }
            $stmt->close();
            return $teams;
        }
        
        public function getTeamsByGameId($idgame) {
            $sql = "SELECT idteam, name FROM team WHERE idgame = ?";
            $stmt = $this->mysqli->prepare($sql);
            if ($stmt === false) {
                die("Error preparing statement: " . $this->mysqli->error);
            }
            
            $stmt->bind_param("i", $idgame);
            $stmt->execute();
            
            $result = $stmt->get_result();
            $teams = [];
            while ($row = $result->fetch_assoc()) {
                $teams[] = $row;
            }
            
            $stmt->close();
            return $teams;
        }
    

        public function getTeamById($id) {
            $sql = "SELECT * FROM team WHERE idteam = ?";
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
        

        public function deleteTeam($arr_col) {
            $sql = "DELETE FROM team WHERE idteam = ?";
            $stmt = $this->mysqli->prepare($sql);
            if ($stmt === false) {
                die("Error preparing statement: " . $this->mysqli->error);
            }
            $stmt->bind_param("i", $arr_col['idteam']);
            $stmt->execute();
            if ($stmt->affected_rows > 0) {
                return true; 
            } else {
                return false; 
            }
        }

        public function displayTeam_Member($id) {
            $sql = "SELECT 
                        CONCAT(m.fname,' ',m.lname) as nama, 
                        t.name as team_name 
                    FROM member m 
                    INNER JOIN team_members tm ON m.idmember = tm.idmember 
                    INNER JOIN team t ON tm.idteam = t.idteam
                    WHERE t.idteam = ?";
            $stmt = $this->mysqli->prepare($sql);
            if ($stmt === false) {
                die("Error preparing statement: " . $this->mysqli->error);
            }
            
            $stmt->bind_param("i", $id);  
            $stmt->execute();
            
            $result = $stmt->get_result(); 
            $members = [];
            while ($row = $result->fetch_assoc()) {
                $members[] = $row;
            }
        
            $stmt->close();
            return $members;
        }

        public function displayEvent_Team($idteam) {
            $sql = "SELECT 
                        e.idevent as id, 
                        e.name AS event_name
                    FROM 
                        event e
                    INNER JOIN 
                        event_teams et ON 
                        e.idevent = et.idevent
                    WHERE 
                        et.idteam = ?";
            $stmt = $this->mysqli->prepare($sql);
            if ($stmt === false) {
                die("Error preparing statement: " . $this->mysqli->error);
            }
        
            $stmt->bind_param("i", $idteam);
            $stmt->execute();
        
            $result = $stmt->get_result(); 
            $events = [];
            while ($row = $result->fetch_assoc()) {
                $events[] = $row;
            }
        
            $stmt->close();
            return $events;
        }
        

        public function displayAchievement_Team($idteam) {
            $sql = "SELECT 
                        a.idachievement as id ,a.name as name 
                    FROM 
                        team t
                    INNER JOIN
                        achievement a ON t.idteam = a.idteam
                    INNER JOIN 
                        event_teams et ON t.idteam = et.idteam
                    INNER JOIN 
                        event e ON et.idevent = e.idevent
                    WHERE 
                        t.idteam = ?";
            $stmt = $this->mysqli->prepare($sql);
            if ($stmt === false) {
                die("Error preparing statement: " . $this->mysqli->error);
            }
        
            $stmt->bind_param("i", $idteam);  
            $stmt->execute();
        
            $result = $stmt->get_result(); 
            $achievements = [];
            while ($row = $result->fetch_assoc()) {
                $achievements[] = $row;
            }
        
            $stmt->close();
            return $achievements;
        }
        
        
    }
?>