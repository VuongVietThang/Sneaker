<?php
include_once(__DIR__ . '/../model/db.php');

class Order extends Db
{
    public function getTotalOrderCount() {
        $sql = "SELECT COUNT(*) AS total FROM orders";
        $result = self::$connection->query($sql);
        $data = $result->fetch_assoc();
        return $data['total'];
    }
    // Phương thức lấy tất cả các đơn hàng với phân trang
    public function getAllOrders($page = 1) {
        $items_per_page = 10;
        $offset = ($page - 1) * $items_per_page;
        $sql = "SELECT * FROM orders LIMIT ? OFFSET ?";
        $stmt = self::$connection->prepare($sql);
        $stmt->bind_param("ii", $items_per_page, $offset);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Phương thức lấy các mục đơn hàng (ví dụ)
    public function getOrderItems($order_id) {
        $sql = "SELECT * FROM order_item WHERE order_id = ?";
        $stmt = self::$connection->prepare($sql);
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Phương thức xóa đơn hàng
    public function deleteOrder($order_id) {
        $sql = "DELETE FROM orders WHERE order_id = ?";
        $stmt = self::$connection->prepare($sql);
        $stmt->bind_param("i", $order_id);
        return $stmt->execute();
    }
    public function setCompleteOrder($status, $order_id) {
        $sql = "UPDATE orders SET status = ? WHERE order_id = ?";
        $stmt = self::$connection->prepare($sql);
        $stmt->bind_param("si", $status, $order_id);
        return $stmt->execute();
    }
    public function orderDetail($order_id) {
        $sql = "SELECT oi.order_item_id, oi.order_id, oi.product_id, oi.size_id, s.value AS size_name, 
                       oi.color_id, c.name AS color_name, oi.quantity, oi.price AS item_price, 
                       oi.created_at, oi.updated_at, p.name AS product_name, p.price AS product_price
                FROM order_item oi
                JOIN product p ON oi.product_id = p.product_id
                JOIN size s ON oi.size_id = s.size_id
                JOIN color c ON oi.color_id = c.color_id
                WHERE oi.order_id = ?";
        $stmt = self::$connection->prepare($sql);
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    
    
}
?>
