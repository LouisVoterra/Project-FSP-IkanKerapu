<?php
    require_once("../Database/db.php");

    class User extends DBParent {
        public function __construct() {
            parent::__construct();
        }
        
        public function Login($username, $password) {
            $sql = "SELECT * FROM member WHERE username = ?";
            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if($result->num_rows > 0) {
                // cek password
                $row = $result->fetch_assoc();
                if(password_verify($password, $row['password'])) {
                    return [
                        'status' => true,
                        'profile' => $row['profile']
                    ];
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }

        public function Registrasi($arr_col) {
            $sql = "INSERT INTO member(fname, lname,username, password,profile) 
            VALUES (?,?,?,?,'member')";
            $stmt = $this->mysqli->prepare($sql);
            $hash_password = password_hash($arr_col['password'], PASSWORD_DEFAULT);
            $stmt->bind_param("ssss", $arr_col['fname'], $arr_col['lname'],
            $arr_col['username'],$hash_password);
            $stmt->execute();
            
            return $this->mysqli->affected_rows;
        }

        public function join_proposal($arr_col){
            $sql = "INSERT INTO join_proposal (idmember,idteam,description,status)
            VALUES(?,?,?,'waiting')";
            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param("iis", $arr_col['idmember'], $arr_col['idteam'],
            $arr_col['description']);
            $stmt->execute();
            
            return $this->mysqli->affected_rows;
        }

        public function idUser($username){
            $sql = "SELECT idmember FROM member WHERE username =?";
            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            return $row['idmember'];
        }

        public function daftar_proposal($keyword_judul, $offset=null,$limit = null) {
            $sql = "SELECT p.idjoin_proposal as id, CONCAT(m.fname,' ',m.lname) as name, t.name as team_name, p.description as description 
            FROM member m INNER JOIN join_proposal p ON m.idmember = p.idmember INNER JOIN
            team t on t.idteam = p.idteam 
            WHERE name LIKE ?";
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
            $res = $this->daftar_proposal($keyword_judul);
            return $res->num_rows;
        }

        public function deniedProposal($arr_col){
            $sql = "UPDATE join_proposal SET status = 'rejected' WHERE idjoin_proposal =?";
            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param("i", $arr_col['id']);
            $stmt->execute();
            return $this->mysqli->affected_rows;

        }

        public function acceptProposal($arr_col){
            $sql = "UPDATE join_proposal SET status = 'approved' WHERE idjoin_proposal =?";
            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param("i", $arr_col['id']);
            $stmt->execute();
            return $this->mysqli->affected_rows;

        }
    }
?>