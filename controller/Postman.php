<?php 
Class Postman {
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function listProvince() {
        $sql = "SELECT * FROM province"; // เตรียมคำสั้ง SQL
        $stmt = $this->conn->prepare($sql); // เตรียมความพร้อม
        $stmt->execute(); // ประมวลผล
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC); // เอามา fetch ข้อมูล โดยใช้ fetchALL ชนิดข้อมูลเป็น FETCH::ASSOC
        return $result;
    }

    public function showsubdistrict($provincename) {
        $sql = "SELECT district.name_th as district, province.name_th as province, subdistrict.name_th as subdistrict, subdistrict.zipcode as zipcode, subdistrict.long as longtitude, subdistrict.lat as latitude FROM district
                INNER JOIN province
                ON district.province_id = province.province_id
                INNER JOIN subdistrict
                ON subdistrict.district_id = district.district_id
                WHERE province.name_th = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$provincename]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}
?>