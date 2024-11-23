<?php
class Color extends Db
{
    // Lấy tất cả màu sắc
    public function getAllColor()
    {
        $sql = self::$connection->prepare("SELECT * FROM color");

        $sql->execute();
        return $sql->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Lấy màu sắc theo ID
    public function getColorByID($color_id)
    {
        $sql = self::$connection->prepare("SELECT * FROM color WHERE color_id = ?");
        $sql->bind_param("i", $color_id);
        $sql->execute();

        return $sql->get_result()->fetch_assoc(); // Trả về một dòng dữ liệu duy nhất
    }

    // Lấy tất cả các màu sắc và số lượng sản phẩm theo màu
    public function getAllColorsWithCount()
    {
        $sql = self::$connection->prepare("
            SELECT c.color_id, c.name AS color_name, COUNT(p.product_id) AS product_count
            FROM color c
            LEFT JOIN product p ON c.color_id = p.color_id
            GROUP BY c.color_id
        ");

        $sql->execute();
        return $sql->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Kiểm tra xem tên màu có tồn tại không
    public function isColorNameExists($name)
    {
        $sql = self::$connection->prepare("SELECT name FROM color WHERE name = ?");
        $sql->bind_param("s", $name);
        $sql->execute();
        $result = $sql->get_result();
        return $result->num_rows > 0; // Trả về true nếu tồn tại, false nếu không
    }

    // Kiểm tra màu sắc có tồn tại không
    public function colorExists($color_id)
    {
        // Chuẩn bị câu lệnh SQL để kiểm tra sự tồn tại của màu sắc
        $sql = self::$connection->prepare("SELECT COUNT(*) FROM color WHERE color_id = ?");

        // Liên kết tham số với câu lệnh SQL
        $sql->bind_param('i', $color_id); // 'i' cho kiểu integer

        // Thực thi câu lệnh SQL
        $sql->execute();

        // Lấy kết quả trả về
        $sql->bind_result($count);
        $sql->fetch();

        // Nếu số lượng bản ghi lớn hơn 0, nghĩa là màu sắc tồn tại
        return $count > 0;
    }

    // Thêm màu sắc mới
    public function addColor($name)
    {
        // Chuẩn bị câu lệnh INSERT INTO
        $sql = self::$connection->prepare("INSERT INTO color (color_id, name) VALUES (NULL, ?)");

        // Gắn giá trị tham số
        $sql->bind_param("s", $name); // "s" là string

        // Thực thi câu lệnh
        $result = $sql->execute();

        // Trả về kết quả của truy vấn (true/false)
        return $result;
    }

    // Cập nhật màu sắc
    public function editColor($color_id, $name)
    {
        // Chuẩn bị câu lệnh UPDATE
        $sql = self::$connection->prepare("UPDATE color SET name = ? WHERE color_id = ?");

        // Gắn giá trị tham số
        $sql->bind_param("si", $name, $color_id); // "s" là string, "i" là int

        // Thực thi câu lệnh
        $result = $sql->execute();

        // Trả về kết quả của truy vấn (true/false)
        return $result;
    }

    // Xóa màu sắc
    public function deleteColor($color_id)
    {
        if ($this->colorExists($color_id)) {
            // Nếu tồn tại, chuẩn bị câu lệnh SQL để xóa màu sắc
            $sql = self::$connection->prepare("DELETE FROM color WHERE color_id = ?");

            // Liên kết tham số với câu lệnh SQL
            $sql->bind_param('i', $color_id); // 'i' cho kiểu integer

            // Thực thi câu lệnh SQL
            if ($sql->execute()) {
                // Nếu xóa thành công, trả về true
                return true;
            } else {
                // Nếu có lỗi, trả về false
                return false;
            }
        } else {
            // Nếu màu sắc không tồn tại, trả về false
            return false;
        }
    }
}
?>
