<?php
class Brand extends Db
{
    // Lấy tất cả danh mục
    public function getAllBrand()
    {
        $sql = self::$connection->prepare("SELECT * FROM brand");

        $sql->execute();
        return $sql->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getBrandByID($brand_id)
    {
        $sql = self::$connection->prepare("SELECT * FROM brand WHERE brand_id = ?");
        $sql->bind_param("i", $brand_id);
        $sql->execute();

        return $sql->get_result()->fetch_assoc(); // Trả về một dòng dữ liệu duy nhất
    }



    public function getAllBrandsWithCount()
    {
        $sql = self::$connection->prepare("
            SELECT b.brand_id, b.name AS brand_name, COUNT(p.product_id) AS product_count
            FROM brand b
            LEFT JOIN product p ON b.brand_id = p.brand_id
            GROUP BY b.brand_id
        ");

        $sql->execute();
        return $sql->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function isBrandnameExists($name)
    {
        $sql = self::$connection->prepare("SELECT name FROM brand WHERE name = ?");
        $sql->bind_param("s", $name);
        $sql->execute();
        $result = $sql->get_result();
        return $result->num_rows > 0; // Trả về true nếu tồn tại, false nếu không
    }

    public function brandExists($brand_id)
    {
        // Chuẩn bị câu lệnh SQL để kiểm tra sự tồn tại của banner
        $sql = self::$connection->prepare("SELECT COUNT(*) FROM brand WHERE brand_id = ?");

        // Liên kết tham số với câu lệnh SQL
        $sql->bind_param('i', $brand_id); // 'i' cho kiểu integer

        // Thực thi câu lệnh SQL
        $sql->execute();

        // Lấy kết quả trả về
        $sql->bind_result($count);
        $sql->fetch();

        // Nếu số lượng bản ghi lớn hơn 0, nghĩa là banner tồn tại
        return $count > 0;
    }

    public function addBrand($name)
    {
        // Chuẩn bị câu lệnh INSERT INTO
        $sql = self::$connection->prepare("INSERT INTO brand (brand_id, name) VALUES (NULL, ?)");

        // Gắn giá trị tham số
        $sql->bind_param("s", $name); // "i" là int, "s" là string

        // Thực thi câu lệnh
        $result = $sql->execute();

        // Trả về kết quả của truy vấn (true/false)
        return $result;
    }

    public function editBrand($brand_id, $name)
    {
        // Chuẩn bị câu lệnh UPDATE
        $sql = self::$connection->prepare("UPDATE brand SET name = ? WHERE brand_id = ?");

        // Gắn giá trị tham số
        $sql->bind_param("si", $name, $brand_id); // "s" là string, "i" là int

        // Thực thi câu lệnh
        $result = $sql->execute();

        // Trả về kết quả của truy vấn (true/false)
        return $result;
    }

    public function deleteBrand($brand_id)
    {
        if ($this->brandExists($brand_id)) {
            // Nếu tồn tại, chuẩn bị câu lệnh SQL để xóa banner
            $sql = self::$connection->prepare("DELETE FROM brand WHERE brand_id = ?");

            // Liên kết tham số với câu lệnh SQL
            $sql->bind_param('i', $brand_id); // 'i' cho kiểu integer

            // Thực thi câu lệnh SQL
            if ($sql->execute()) {
                // Nếu xóa thành công, trả về true
                return true;
            } else {
                // Nếu có lỗi, trả về false
                return false;
            }
        } else {
            // Nếu banner không tồn tại, trả về false
            return false;
        }
    }
}
