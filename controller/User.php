<?php 
Class User {
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }
    
    public function login($username, $password){
        $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$username, $password]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result > 1){
            $data = [
                "status" => "success",
                "message" => "Login Success",
                "data" => $result
            ];
            return $data;
        }
        return [
            "status" => "error",
            "message" => "Login Failed"
        ];
    }

    public function register($username, $password, $email) {
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$username]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result > 1){
            $data = [
                "status" => "error",
                "message" => "Username already exists"
            ];
            return $data;
        }else {
            $sql = "INSERT INTO users (username, password, email) VALUES (?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$username, $password, $email]);
            $data = [
                "status" => "success",
                "message" => "Register Success"
            ];
            return $data;
        }
    }
    
    public function getAlluser() {
        $sql = "SELECT * FROM users";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updateUser($data) {
        $sql = "UPDATE users SET username = ?, password = ?, email = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$data["username"], $data["password"], $data["email"], $data["id"]]);
        $data = [
            "status" => "success",
            "message" => "Update Success"
        ];
        return $data;
    }

    public function deleteUser($id) {
        $sql = "DELETE FROM users WHERE id = ?, name = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        $data = [
            "status" => "success",
            "message" => "Delete Success"
        ];
        return $data;
    }
}

?>