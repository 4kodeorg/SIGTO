<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/Database.php';

class PaymentController extends Database
{
    public function insertPayAndConfirmation($montoTotal, $estado, $tipoPago, $nombreMetodoPago, $cuponDesc, $idUserVendedor, $idComprador)
    {
        $query = "INSERT INTO medio_pago (monto_total, estado, tipo_pago, nombre_met_pago) VALUES (?, ?, ?, ?);";
        $stmt = $this->conn->prepare($query);
        $tipoPago = "Paypal";
        $nombreMetodoPago = "PayPal";
        $stmt->bind_param("dsss", $montoTotal, $estado, $tipoPago, $nombreMetodoPago);
        $stmt->execute();

        $idPago = $stmt->insert_id;
        $stmt->close();
        if ($idPago) {
            $query = "INSERT INTO confirmar_compra (id_usu_com, id_usu_ven, id_pago, estado_confirmacion, cupon_desc) VALUES (?, ?, ?, ?, ?);";
            $stmt = $this->conn->prepare($query);
            $estadoConfirmacion = 'Confirmado';
            $stmt->bind_param("iiiss", $idComprador, $idUserVendedor, $idPago, $estadoConfirmacion, $cuponDesc);
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
            $stmt->close();
        }
    }
    public function getRecentPurchase($userId) {
        $query = "
        SELECT c.sku_prod, c.cantidad, c.titulo, c.precio_prod, m.monto_total, m.estado AS estado_pago
        FROM carrito c
        JOIN confirmar_compra cc ON c.id_usu_com = cc.id_usu_com AND c.id_usu_ven = cc.id_usu_ven
        JOIN medio_pago m ON cc.id_pago = m.id_pago
        WHERE c.id_usu_com = ? AND c.is_deleted = TRUE
        ;";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $userId);
        
        if ($stmt->execute()) {
            
            $result = $stmt->get_result();
        
            $purchasedItems = [];
            while ($row = $result->fetch_assoc()) {
                $purchasedItems[] = $row;
            }
        
            $stmt->close();
            return $purchasedItems;
        } else {
            $stmt->close();
            return [];
        }
    }   
}
