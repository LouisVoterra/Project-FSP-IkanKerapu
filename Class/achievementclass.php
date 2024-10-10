<?php
require_once("../Database/db.php");

class Achievement extends DBParent {
    public function __construct() {
        parent::__construct();
    }

    public function getAchievement($keyword_judul, $offset=null, $limit=null) {
        $sql = "SELECT a.idachievement, t.name as team_name, a.name as name_achievement,
        a.date, a.description FROM achievement a 
        INNER JOIN team t ON t.idteam = a.idteam
        WHERE a.name LIKE ?";
        
        if (!is_null($offset)) {
            $sql .= " LIMIT ?, ?";
        }

        $stmt = $this->mysqli->prepare($sql);
        $keyword = "%{$keyword_judul}%";
        
        if (!is_null($offset)) {
            $stmt->bind_param("sii", $keyword, $offset, $limit);
        } else {
            $stmt->bind_param("s", $keyword);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    public function getTotalData($keyword_judul) {
        $res = $this->getAchievement($keyword_judul);
        return $res->num_rows;
    }

    public function insertAchievement($arr_col) {
        $sql = "INSERT INTO achievement (idteam, name, date, description)
                VALUES (?, ?, ?, ?)";
        $stmt = $this->mysqli->prepare($sql);
        
        if ($stmt === false) {
            die("Error preparing statement: " . $this->mysqli->error);
        }

        $stmt->bind_param("isss", $arr_col['idteam'], $arr_col['name'], $arr_col['date'], $arr_col['description']);
        $stmt->execute();
        return $this->mysqli->insert_id;
    }

    public function updateAchievement($arr_col) {
        $sql = "UPDATE achievement SET name = ?, idteam = ?, date = ?, description = ? 
                WHERE idachievement = ?";
        $stmt = $this->mysqli->prepare($sql);
        
        if ($stmt === false) {
            die("Error preparing statement: " . $this->mysqli->error);
        }
        
        $stmt->bind_param("sissi", $arr_col['name'], $arr_col['idteam'], $arr_col['date'], $arr_col['description'], $arr_col['idachievement']);
        $stmt->execute();
        
        if ($stmt->affected_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getAchievementById($id) {
        $sql = "SELECT * FROM achievement WHERE idachievement = ?";
        $stmt = $this->mysqli->prepare($sql);
        
        if ($stmt === false) {
            die("Error preparing statement: " . $this->mysqli->error);
        }
        
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $achievement = $result->fetch_assoc();
        
        $stmt->close();
        return $achievement;
    }

    public function deleteAchievement($arr_col) {
        $sql = "DELETE idteam FROM achievement WHERE idteam = ?";
        $stmt = $this->mysqli->prepare($sql);
        
        if ($stmt === false) {
            die("Error preparing statement: " . $this->mysqli->error);
        }
        
        $stmt->bind_param("i", $arr_col['idachievement']);
        $stmt->execute();
        
        if ($stmt->affected_rows > 0) {
            return true;
        } else {
            return false;
        }
    }
}
?>
