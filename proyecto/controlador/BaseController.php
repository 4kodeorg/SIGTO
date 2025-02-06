<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/Database.php';

class BaseController extends Database {
    public function selectAllFrom($table, $filter, $field, $type) {
        $query = "SELECT * FROM ".$table ."WHERE ".$filter."=".$field.";";
        $stmt = $this->conn->prepare($query);
        $type = is_string($field) ? 's' : 'i';
        $stmt->bind_param($type, $field);
        
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $dataArr = $result->fetch_all(MYSQLI_ASSOC);
            } else {
                $dataArr = [];
            }
            $stmt->close();
            return $dataArr;
        } else {
            $stmt->close();
            throw new Exception("Error en la base de datos");
        }

    }

}