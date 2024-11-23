<?php
class Size extends Db
{
    // Lấy tất cả kích thước
    public function getAllSize()
    {
        $sql = self::$connection->prepare("SELECT * FROM size");

        $sql->execute();
        return $sql->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getSizeByID($size_id)
    {
        $sql = self::$connection->prepare("SELECT * FROM size WHERE size_id = ?");
        $sql->bind_param("i", $size_id);
        $sql->execute();

        return $sql->get_result()->fetch_assoc(); // Trả về một dòng dữ liệu duy nhất
    }

    public function getAllSizesWithCount()
    {
        $sql = self::$connection->prepare("
            SELECT s.size_id, s.value AS size_value, COUNT(p.product_id) AS product_count
            FROM size s
            LEFT JOIN product p ON s.size_id = p.size_id
            GROUP BY s.size_id
        ");

        $sql->execute();
        return $sql->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function isSizeExists($value)
    {
        $sql = self::$connection->prepare("SELECT value FROM size WHERE value = ?");
        $sql->bind_param("s", $value);
        $sql->execute();
        $result = $sql->get_result();
        return $result->num_rows > 0; // Trả về true nếu tồn tại, false nếu không
    }

    public function sizeExists($size_id)
    {
        // Chuẩn bị câu lệnh SQL để kiểm tra sự tồn tại của kích thước
        $sql = self::$connection->prepare("SELECT COUNT(*) FROM size WHERE size_id = ?");

        // Liên kết tham số với câu lệnh SQL
        $sql->bind_param('i', $size_id); // 'i' cho kiểu integer

        // Thực thi câu lệnh SQL
        $sql->execute();

        // Lấy kết quả trả về
        $sql->bind_result($count);
        $sql->fetch();

        // Nếu số lượng bản ghi lớn hơn 0, nghĩa là kích thước tồn tại
        return $count > 0;
    }

    public function addSize($value)
    {
        // Chuẩn bị câu lệnh INSERT INTO
        $sql = self::$connection->prepare("INSERT INTO size (size_id, value) VALUES (NULL, ?)");

        // Gắn giá trị tham số
        $sql->bind_param("s", $value); // "s" là string

        // Thực thi câu lệnh
        $result = $sql->execute();

        // Trả về kết quả của truy vấn (true/false)
        return $result;
    }

    public function editSize($size_id, $value)
    {
        // Chuẩn bị câu lệnh UPDATE
        $sql = self::$connection->prepare("UPDATE size SET value = ? WHERE size_id = ?");

        // Gắn giá trị tham số
        $sql->bind_param("si", $value, $size_id); // "s" là string, "i" là int

        // Thực thi câu lệnh
        $result = $sql->execute();

        // Trả về kết quả của truy vấn (true/false)
        return $result;
    }

    public function deleteSize($size_id)
    {
        if ($this->sizeExists($size_id)) {
            // Nếu tồn tại, chuẩn bị câu lệnh SQL để xóa kích thước
            $sql = self::$connection->prepare("DELETE FROM size WHERE size_id = ?");

            // Liên kết tham số với câu lệnh SQL
            $sql->bind_param('i', $size_id); // 'i' cho kiểu integer

            // Thực thi câu lệnh SQL
            if ($sql->execute()) {
                // Nếu xóa thành công, trả về true
                return true;
            } else {
                // Nếu có lỗi, trả về false
                return false;
            }
        } else {
            // Nếu kích thước không tồn tại, trả về false
            return false;
        }
    }
}
