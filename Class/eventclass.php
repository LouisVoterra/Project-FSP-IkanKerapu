<?php
    require_once("../Database/db.php");
    

    class Event extends DBParent {
        public function __construct() {
            parent::__construct();
        }

        public function getEvent($keyword_judul, $offset=null,$limit = null) {
            $sql = "SELECT e.idevent AS event_id,t.name AS team_name,e.name AS event_name,e.description AS event_description,e.date AS event_date
            FROM team t INNER JOIN event_teams et ON t.idteam = et.idteam INNER JOIN event e ON et.idevent = e.idevent
            WHERE e.name LIKE ?";
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
            $res = $this->getEvent($keyword_judul);
            return $res->num_rows;
        }

        public function insertEvent($arr_col) {
            $sql = "INSERT INTO event( name,date,description) 
            VALUES (?,?,?)";
            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param("sss",
                              $arr_col['name'],$arr_col['date'],$arr_col['description']);
            $stmt->execute();
            return $this->mysqli->insert_id;
        }

        public function updateEvent($arr_col) {
            $updateFields = [];
            $params = [];
            $types = '';
        
            if (isset($arr_col['name'])) {
                $updateFields[] = 'name = ?';
                $params[] = $arr_col['name'];
                $types .= 's';
            }
            if (isset($arr_col['date'])) {
                $updateFields[] = 'date = ?';
                $params[] = $arr_col['date'];
                $types .= 's';
            }
            if (isset($arr_col['description'])) {
                $updateFields[] = 'description = ?';
                $params[] = $arr_col['description'];
                $types .= 's';
            }
        
            if (count($updateFields) > 0) {
                $sql = "UPDATE event SET " . implode(', ', $updateFields) . " WHERE idevent = ?";
                $params[] = $arr_col['idevent'];
                $types .= 'i';
        
                $stmt = $this->mysqli->prepare($sql);
        
                $stmt->bind_param($types, ...$params);
                $stmt->execute();
        
                return $stmt->affected_rows > 0;
            }
        
            return false;
        }
        
        

        public function getEventbyId($id) {
            $sql = "SELECT * FROM event WHERE idevent = ?";
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
        

        public function deleteEvent($arr_col) {
            $sql = "DELETE FROM event WHERE idevent = ?";
            $stmt = $this->mysqli->prepare($sql);
            if ($stmt === false) {
                die("Error preparing statement: " . $this->mysqli->error);
            }
            $stmt->bind_param("i", $arr_col['idevent']);
            $stmt->execute();
            if ($stmt->affected_rows > 0) {
                return true; 
            } else {
                return false; 
            }
        }

        public function event_team($arr_col){
            $sql = "INSERT INTO event_teams(idevent, idteam) 
            VALUES (?,?)";
            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param("ii", $arr_col['idevent'], $arr_col['idteam']);
            $stmt->execute();
            return $this->mysqli->insert_id;
        }

        
        
        public function deleteEventTeams($idevent,$idteam) {
            $sql = "DELETE FROM event_teams WHERE idevent = ? AND idteam = ?";
            $stmt = $this->mysqli->prepare($sql);
            if ($stmt === false) {
                die("Error preparing statement: " . $this->mysqli->error);
            }
            $stmt->bind_param("ii", $idevent,$idteam);
            $stmt->execute();
            return $stmt->affected_rows > 0;
        }

        public function addEventTeams($idevent,$idteam){
            $sql = "INSERT INTO event_teams(idevent, idteam) VALUES (?,?)";
            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param("ii", $idevent, $idteam);
            $stmt->execute();
            return $this->mysqli->insert_id;
        }

        public function getTeamsInEvent($idevent) {
            $sql = "SELECT idteam FROM event_teams WHERE idevent = ?";
            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param("i", $idevent);
            $stmt->execute();
            $result = $stmt->get_result();
            $teamsInEvent = [];
            while ($row = $result->fetch_assoc()) {
                $teamsInEvent[] = $row['idteam'];
            }
            
            return $teamsInEvent;
        }

        
        
        
        
    }
?>