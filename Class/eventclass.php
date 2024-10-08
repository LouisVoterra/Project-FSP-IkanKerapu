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
            $sql = "UPDATE event SET name = ?, date = ?, description = ? WHERE idevent = ?";
            $stmt = $this->mysqli->prepare($sql);
        
            if ($stmt === false) {
                die("Error preparing statement: " . $this->mysqli->error);
            }
        
            // Bind the parameters (correct order and types)
            $stmt->bind_param("sssi", $arr_col['name'], $arr_col['date'], $arr_col['description'], $arr_col['idevent']);
        
            $stmt->execute();
        
            // Check if any rows were affected
            if ($stmt->affected_rows > 0) {
                return true; 
            } else {
                return false; 
            }
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
            // Prepare the DELETE statement
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

        public function update_event_team($arr_col){
            $sql = "UPDATE event_teams SET idteam =? WHERE idevent =?";
            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param("ii", $arr_col['idteam'], $arr_col['idevent']);
            $stmt->execute();
            return $stmt->affected_rows;
        }
        
        public function deleteEventTeams($idevent) {
            // SQL query to delete all entries in the event_teams table related to a specific event (idevent)
            $sql = "DELETE FROM event_teams WHERE idevent = ?";
            
            // Prepare the SQL statement
            $stmt = $this->mysqli->prepare($sql);
            if ($stmt === false) {
                die("Error preparing statement: " . $this->mysqli->error);
            }
            
            // Bind the event ID (idevent) to the SQL statement
            $stmt->bind_param("i", $idevent);
            
            // Execute the SQL statement
            $stmt->execute();
            
            // Close the statement to free resources
            $stmt->close();
        }
        
    }
?>