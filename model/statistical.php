<?php
require_once 'db.php';
class Statistical extends Db
{
    public function getTotaSales($month, $year)
    {
        $sql = self::$connection->prepare("
            SELECT SUM(total_amount) AS total_sales
            FROM orders 
            WHERE status = 'completed'
            AND MONTH(created_at) = ? 
            AND YEAR(created_at) = ?
        ");
        $sql->bind_param("ii", $month, $year);
        $sql->execute();
        return $sql->get_result()->fetch_assoc()['total_sales'] ?? 0;
    }

    public function getTotalUser($month, $year)
    {
        // Chuẩn bị câu truy vấn
        $sql = self::$connection->prepare("
            SELECT COUNT(*) AS total_user
            FROM user
            WHERE MONTH(created_at) = ?
            AND YEAR(created_at) = ?
        ");

        // Gắn tham số
        $sql->bind_param("ii", $month, $year); // "ii" cho hai tham số kiểu integer

        // Thực thi câu truy vấn
        $sql->execute();

        // Lấy kết quả
        $result = $sql->get_result();
        $row = $result->fetch_assoc();

        // Trả về tổng số người dùng
        return $row['total_user'] ?? 0;
    }

    public function getTotalProductsSold($month, $year)
    {
        // Chuẩn bị câu truy vấn SQL
        $sql = self::$connection->prepare("
            SELECT SUM(oi.quantity) AS total_sold
            FROM order_item oi
            INNER JOIN orders o ON oi.order_id = o.order_id
            WHERE o.status = 'completed'
            AND MONTH(o.created_at) = ?
            AND YEAR(o.created_at) = ?
        ");
        $sql->bind_param("ii", $month, $year);
        // Thực thi truy vấn
        $sql->execute();

        // Lấy kết quả
        $result = $sql->get_result();
        $row = $result->fetch_assoc();

        // Trả về tổng sản phẩm đã bán (nếu NULL thì trả về 0)
        return $row['total_sold'] ?? 0;
    }
    public function getTotalOrders($month, $year)
    {
        // Chuẩn bị câu truy vấn SQL để đếm số lượng đơn hàng
        $sql = self::$connection->prepare("
            SELECT COUNT(order_id) AS total_order 
            FROM orders
            WHERE MONTH(created_at) = ?
            AND YEAR(created_at) = ?
        ");
        $sql->bind_param("ii", $month, $year);
        // Thực thi câu truy vấn
        $sql->execute();

        // Lấy kết quả và trả về tổng số đơn hàng
        $result = $sql->get_result()->fetch_assoc();

        // Trả về tổng số đơn hàng
        return $result['total_order'] ?? 0;
    }
}
