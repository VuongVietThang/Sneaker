<?php
require_once 'db.php';

class Order extends Db
{
    public function createOrder($user_id, $total_amount, $shipping_address)
    {
        $sql = self::$connection->prepare("INSERT INTO orders (user_id, total_amount, status, shipping_address) VALUES (?, ?, 'pending', ?)");
        $sql->bind_param("iis", $user_id, $total_amount, $shipping_address);

        if ($sql->execute()) {
            return self::$connection->insert_id;
        }
        return false;
    }

    public function addOrderItem($order_id, $product_id, $size_id, $color_id, $quantity, $price)
    {
        $sql = self::$connection->prepare("INSERT INTO order_item (order_id, product_id, size_id, color_id, quantity, price) VALUES (?, ?, ?, ?, ?, ?)");
        $sql->bind_param("iiiiii", $order_id, $product_id, $size_id, $color_id, $quantity, $price);
        return $sql->execute();
    }

    public function getOrders()
    {
        $sql = self::$connection->prepare("SELECT * FROM orders ORDER BY order_date DESC");
        $sql->execute();
        $result = $sql->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getOrderById($order_id)
    {
        $sql = self::$connection->prepare("SELECT * FROM orders WHERE order_id = ?");
        $sql->bind_param("i", $order_id);
        $sql->execute();
        $result = $sql->get_result();
        return $result->fetch_assoc();
    }

    public function getOrderItems($order_id)
    {
        $sql = self::$connection->prepare("SELECT oi.*, p.name as product_name FROM order_item oi JOIN product p ON oi.product_id = p.product_id WHERE oi.order_id = ?");
        $sql->bind_param("i", $order_id);
        $sql->execute();
        $result = $sql->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function updateOrderStatus($order_id, $status)
    {
        $sql = self::$connection->prepare("UPDATE orders SET status = ? WHERE order_id = ?");
        $sql->bind_param("si", $status, $order_id);
        return $sql->execute();
    }
}
