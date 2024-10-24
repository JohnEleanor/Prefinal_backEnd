<?php 

// แก้ปัญหาการติด CORS กรณียิงจากภายนอก
header("Access-Control-Allow-Origin: *");
// อนุญาติ Method
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

require_once 'config/db.php';
require_once 'controller/Postman.php';
require_once 'controller/User.php';


$method = $_SERVER["REQUEST_METHOD"];
$endpoint = $_SERVER["PATH_INFO"];

// การเข้าถึงข้อมูล ของ URL ที่ส่งมาเเบบไม่ต้อง Regex 😂
$decode_uri = [];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );
foreach ($uri as $value ) { // อ่านค่า UTF 8 ให้เป็นภาษาไทย
    $value = urldecode($value);
    $decode_uri[] = $value;
}


$postmanObj = new Postman($conn);
$userObj = new User($conn);

if ($method == "GET") {
  
    // ส่วนของ province
    if (isset($decode_uri[3]) && $decode_uri[3] == "province") {
        if (isset($decode_uri[4])) {
            $result = $postmanObj->showsubdistrict($decode_uri[4]);
            print(json_encode($result));
        }else {
            $result = $postmanObj->listProvince();
            print(json_encode($result));
        }
    }

    // ส่วนของ user
    if (isset($decode_uri[3]) && $decode_uri[3] == "user") {

        if (isset($decode_uri[4])) {
            $result = $userObj->getUserByid($decode_uri[4]);
            print(json_encode($result));
        } else {
            $result = $userObj->getAlluser();
            print(json_encode($result));
        }
    }

    
}
elseif ($method == "POST") {

    // ส่วนของ user
    if ( (isset($decode_uri[3])) && ($decode_uri[3] == "user") ) {

        if ($decode_uri[4] == "register") {
            $data = json_decode(file_get_contents("php://input"), true);
            $username = $data["username"];
            $password = $data["password"];
            $email = $data["email"];
    
            $result = $userObj->register($username, $password, $email);
            print(json_encode($result));
        }elseif ($decode_uri[4] == "login") {
            $data = json_decode(file_get_contents("php://input"), true);
            $username = $data["username"];
            $password = $data["password"];
    
            $result = $userObj->login($username, $password);
            print(json_encode($result));
        }
    }


}elseif ($method == "PUT") {

        // ส่วนของ user
    if (isset($decode_uri[3]) && $decode_uri[3] == "user" ) {
        $data = json_decode(file_get_contents("php://input"), true);
        $id = $decode_uri[4];
        $result = $userObj->updateUser($data, $id);
        print(json_encode($result));
    } else {
        echo "Not Found";
    }
}elseif ($method == "DELETE") {
        // ส่วนของ user
    if (isset($decode_uri[3]) && $decode_uri[3] == "user") {
        $data = json_decode(file_get_contents("php://input"), true);

        $id = $data["id"];
        $result = $userObj->deleteUser($id);
        print(json_encode($result));
    } else {
        echo "Not Found";
    }
}



?>