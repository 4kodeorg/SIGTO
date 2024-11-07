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
            $stmt->execute();
            $purchaseIdCarrito = $stmt->insert_id;
            $stmt->close();

            if ($purchaseIdCarrito) {
                $query = "UPDATE carrito SET purchase_id = ?, is_deleted = 1 WHERE id_usu_com = ? AND is_deleted = 0;";
                $stmt = $this->conn->prepare($query);
                $stmt->bind_param("ii", $purchaseIdCarrito, $idComprador);
                $stmt->execute();
                $stmt->close();

                return $purchaseIdCarrito;
            }
        }
        throw new Exception("Error:");
    }
    // public function getLastTotal() {
    //     $query = "SELECT ";
    // }
    public function getLastPurchaseItems($idComprador)
    {
        $query = "SELECT registro_compra
            FROM confirmar_compra
            WHERE id_usu_com = ?
            ORDER BY fecha_confirmacion DESC
            LIMIT 1;";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $idComprador);
        $stmt->execute();
        $stmt->bind_result($latestPurchaseId);
        $stmt->fetch();
        $stmt->close();
    
        if ($latestPurchaseId) {
            $query = "SELECT c.purchase_id, c.cantidad, c.titulo, c.precio_prod, c.sku_prod 
                FROM carrito c
                WHERE c.id_usu_com = ? 
                  AND c.purchase_id = ? 
                  AND c.is_deleted = 1;";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("ii", $idComprador, $latestPurchaseId);
            $stmt->execute();
    
            $result = $stmt->get_result();
            $items = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
    
            return $items ?: [];
        }
        
        return []; 
    }

    public function getHistoryPurchase($userId)
    {
       $query =  "SELECT 
            cc.registro_compra AS purchase_id,
            mp.monto_total AS total,
            cc.fecha_confirmacion AS fecha_com,
            cc.estado_confirmacion AS confirmacion,
            mp.nombre_met_pago AS met_pago
        FROM 
            confirmar_compra cc
        JOIN 
            medio_pago mp ON cc.id_pago = mp.id_pago
        WHERE 
            cc.id_usu_com = ?
        ORDER BY 
            cc.fecha_confirmacion DESC;";
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
