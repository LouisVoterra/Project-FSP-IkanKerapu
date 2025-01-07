<?php
    require_once("../Database/db.php");
    

    class Team extends DBParent {
        public function __construct() {
            parent::__construct();
        }

        public function getTeam($keyword_judul, $offset = null, $limit = null) {
            $sql = "SELECT t.idteam, g.name as game_name, t.name as team_name 
                    FROM team t 
                    INNER JOIN game g ON t.idgame = g.idgame
                    WHERE t.name LIKE ?";
            if (!is_null($offset) && !is_null($limit)) {
                $sql .= " LIMIT ?, ?";
            }
        
            $stmt = $this->mysqli->prepare($sql);
            $keyword = "%{$keyword_judul}%";            
            if (!is_null($offset) && !is_null($limit)) {
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
        public function getTeamsByGameId($gameId) {
            
            $sql = "SELECT t.idteam, t.name AS team_name, g.name AS game_name
                    FROM team t
                    INNER JOIN game g ON t.idgame = g.idgame
                    WHERE t.idgame = ?";
        
            $stmt = $this->mysqli->prepare($sql);
            if ($stmt === false) {
                die("Error preparing statement: " . $this->mysqli->error);
            }
            $stmt->bind_param("i", $gameId);
            $stmt->execute();
            $result = $stmt->get_result();
            $teams = [];
            while ($row = $result->fetch_assoc()) {
                $teams[] = $row;
            }
            $stmt->close();
            return $teams;
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

        public function displayTeam_Member($idteam, $offset = 0, $limit = 10) {
            $sql = "SELECT 
                        m.idmember, 
                        CONCAT(m.fname, ' ', m.lname) AS nama, 
                        t.name AS team_name 
                    FROM member m 
                    INNER JOIN team_members tm ON m.idmember = tm.idmember 
                    INNER JOIN team t ON tm.idteam = t.idteam 
                    WHERE tm.idteam = ? 
                    LIMIT ?, ?";
            
            $stmt = $this->mysqli->prepare($sql);
            if ($stmt === false) {
                die("Error preparing statement: " . $this->mysqli->error);
            }
        
            $stmt->bind_param("iii", $idteam, $offset, $limit);
            $stmt->execute();
        
            $result = $stmt->get_result();
            $members = [];
            while ($row = $result->fetch_assoc()) {
                $members[] = $row;
            }
        
            $stmt->close();
            return $members;
        }
        
        public function getMembersByGameAndTeam($idteam, $game_selected) {
            $sql = "SELECT CONCAT(m.fname, ' ', m.lname) AS name 
                    FROM member m
                    INNER JOIN team_members tm ON tm.idmember = m.idmember
                    INNER JOIN team t ON tm.idteam = t.idteam
                    INNER JOIN game g ON g.idgame = t.idgame
                    WHERE t.idteam = ? AND g.idgame = ?;";
        
            $stmt = $this->mysqli->prepare($sql);
            if ($stmt === false) {
                die("Error preparing statement: " . $this->mysqli->error);
            }
        
            $stmt->bind_param("ii", $idteam, $game_selected);
            $stmt->execute();
            
            $result = $stmt->get_result();
            $members = [];
            
            while ($row = $result->fetch_assoc()) {
                $members[] = $row;
            }
        
            $stmt->close();
            return $members;
        }
        
        public function displayEvent_Team($idmember, $offset = 0, $limit = 10) {
            $sql = "SELECT 
                        e.idevent as id, 
                        e.name AS name,
                        e.description as description,
                        e.date as date
                    FROM 
                        event e
                    INNER JOIN 
                        event_teams et ON e.idevent = et.idevent
                    INNER JOIN 
                        team_members tm ON et.idteam = tm.idteam
                    WHERE 
                        tm.idteam = ? 
                    LIMIT ?, ?";
        
            $stmt = $this->mysqli->prepare($sql);
            if ($stmt === false) {
                die("Error preparing statement: " . $this->mysqli->error);
            }
        
            $stmt->bind_param("iii", $idmember, $offset, $limit);
            $stmt->execute();
        
            $result = $stmt->get_result(); 
            $events = [];
            while ($row = $result->fetch_assoc()) {
                $events[] = $row;
            }
        
            $stmt->close();
            return $events;
        }
    
        public function getEvent_Teams($idteam, $keyword_judul = "", $offset = null, $limit = null) {
            
            $sql = "SELECT 
                        e.idevent AS event_id,
                        e.name AS event_name,
                        e.description AS event_description,
                        e.date AS event_date
                    FROM 
                        team t 
                    INNER JOIN 
                        event_teams et ON t.idteam = et.idteam 
                    INNER JOIN 
                        event e ON et.idevent = e.idevent 
                    WHERE 
                        t.idteam = ? AND et.idevent AND e.name LIKE ?";
        
            
            if (!is_null($offset) && !is_null($limit)) {
                $sql .= " LIMIT ?, ?";
            }
        
            
            $stmt = $this->mysqli->prepare($sql);
            if ($stmt === false) {
                die("Error preparing statement: " . $this->mysqli->error);
            }
        
           
            $keyword = "%{$keyword_judul}%";
            if (!is_null($offset) && !is_null($limit)) {
                $stmt->bind_param("isii", $idteam, $keyword, $offset, $limit);
            } else {
                $stmt->bind_param("is", $idteam, $keyword);
            }
        
            
            $stmt->execute();
            $result = $stmt->get_result();
        
            
            return $result;
        }
        
        
        public function getTotalDataEventTeams($idteam, $keyword_judul = "") {
           
            $sql = "SELECT COUNT(*) AS total
                    FROM 
                        team t 
                    INNER JOIN 
                        event_teams et ON t.idteam = et.idteam 
                    INNER JOIN 
                        event e ON et.idevent = e.idevent 
                    WHERE 
                        t.idteam = ? AND e.name LIKE ?";
            
            
            $stmt = $this->mysqli->prepare($sql);
            if ($stmt === false) {
                die("Error preparing statement: " . $this->mysqli->error);
            }
        
            
            $keyword = "%{$keyword_judul}%";
            $stmt->bind_param("is", $idteam, $keyword);
        
            
            $stmt->execute();
            $stmt->bind_result($total);
            $stmt->fetch();
        
           
            return $total;
        }
        

        public function displayAchievement_Team($idmember, $offset = 0, $limit = 10) {
            $sql = "SELECT DISTINCT
                        a.idachievement as id, a.name as name, a.description as description, a.date as date 
                    FROM 
                        team t
                    INNER JOIN
                        achievement a ON t.idteam = a.idteam
                    INNER JOIN
                        team_members tm ON t.idteam = tm.idteam
                    WHERE 
                        tm.idteam = ? 
                    LIMIT ?, ?";
        
            $stmt = $this->mysqli->prepare($sql);
            if ($stmt === false) {
                die("Error preparing statement: " . $this->mysqli->error);
            }
        
            $stmt->bind_param("iii", $idmember, $offset, $limit);  
            $stmt->execute();
        
            $result = $stmt->get_result(); 
            $achievements = [];
            while ($row = $result->fetch_assoc()) {
                $achievements[] = $row;
            }
        
            $stmt->close();
            return $achievements;
        }
        
        
        
        public function getAchievement_Teams($idteam, $keyword_judul = "", $offset = null, $limit = null) {
            
            $sql = "SELECT 
                        a.idachievement as idachievement ,
                        a.name as name_achievement ,
                        a.description as deskripsi
                    FROM 
                        team t
                    INNER JOIN
                        achievement a ON t.idteam = a.idteam 
                    WHERE 
                        t.idteam = ? AND a.name LIKE ?";
        
            
            if (!is_null($offset) && !is_null($limit)) {
                $sql .= " LIMIT ?, ?";
            }
        
            
            $stmt = $this->mysqli->prepare($sql);
            if ($stmt === false) {
                die("Error preparing statement: " . $this->mysqli->error);
            }
        
           
            $keyword = "%{$keyword_judul}%";
            if (!is_null($offset) && !is_null($limit)) {
                $stmt->bind_param("isii", $idteam, $keyword, $offset, $limit);
            } else {
                $stmt->bind_param("is", $idteam, $keyword);
            }
        
            
            $stmt->execute();
            $result = $stmt->get_result();
        
            
            return $result;
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
        
        
        public function getTotalDataAchievementTeams($idteam, $keyword_judul = "") {
           
            $sql = "SELECT COUNT(*) AS total
                    FROM 
                        team t
                    INNER JOIN
                        achievement a ON t.idteam = a.idteam 
                    WHERE 
                        t.idteam = ? AND a.name LIKE ?";
            
            
            $stmt = $this->mysqli->prepare($sql);
            if ($stmt === false) {
                die("Error preparing statement: " . $this->mysqli->error);
            }
        
            
            $keyword = "%{$keyword_judul}%";
            $stmt->bind_param("is", $idteam, $keyword);
        
            
            $stmt->execute();
            $stmt->bind_result($total);
            $stmt->fetch();
        
           
            return $total;
        }
        public function getTotalDataMembers($idteam) {
            $sql = "SELECT COUNT(*) AS total
                    FROM member m
                    INNER JOIN team_members tm ON m.idmember = tm.idmember
                    INNER JOIN team t ON tm.idteam = t.idteam
                    WHERE t.idteam = ?";
            
            $stmt = $this->mysqli->prepare($sql);
            if ($stmt === false) {
                die("Error preparing statement: " . $this->mysqli->error);
            }
        
            $stmt->bind_param("i", $idteam);
            $stmt->execute();
            $stmt->bind_result($total);
            $stmt->fetch();
            
            $stmt->close();
            return $total;
        }
        
        public function getTotalDataAchievements($idteam) {
            $sql = "SELECT COUNT(*) AS total
                    FROM achievement a
                    INNER JOIN team t ON a.idteam = t.idteam
                    WHERE t.idteam = ?";
            
            $stmt = $this->mysqli->prepare($sql);
            if ($stmt === false) {
                die("Error preparing statement: " . $this->mysqli->error);
            }
        
            $stmt->bind_param("i", $idteam);
            $stmt->execute();
            $stmt->bind_result($total);
            $stmt->fetch();
            
            $stmt->close();
            return $total;
        }
        
        public function getTotalDataEvents($idteam) {
            $sql = "SELECT COUNT(*) AS total
                    FROM event e
                    INNER JOIN event_teams et ON e.idevent = et.idevent
                    WHERE et.idteam = ?";
            
            $stmt = $this->mysqli->prepare($sql);
            if ($stmt === false) {
                die("Error preparing statement: " . $this->mysqli->error);
            }
        
            $stmt->bind_param("i", $idteam);
            $stmt->execute();
            $stmt->bind_result($total);
            $stmt->fetch();
            
            $stmt->close();
            return $total;
        }

        public function getTeamByIdMember($idmember) {
            $sql = "SELECT t.idteam 
                    FROM team t 
                    INNER JOIN team_members tm ON t.idteam = tm.idteam 
                    WHERE tm.idmember = ? LIMIT 1";
            
            $stmt = $this->mysqli->prepare($sql);
            if ($stmt === false) {
                die("Error preparing statement: " . $this->mysqli->error);
            }
        
            $stmt->bind_param("i", $idmember);
            $stmt->execute();
        
            $result = $stmt->get_result();
            $team = $result->fetch_assoc();
        
            $stmt->close();
            return $team; 
        }
        
    }
    
?>