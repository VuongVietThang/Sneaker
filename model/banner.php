<?php
class Banner extends Db
{
    public function getAllBanner(){
        $sql = self::$connection->prepare("SELECT * FROM banner WHERE `action` = 1 ORDER BY `order` ASC");
        $sql->execute();
        return $sql->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getBannerById($banner_id) {
        // Chuẩn bị câu truy vấn SQL để lấy banner theo ID
        $sql = self::$connection->prepare("SELECT * FROM banner WHERE banner_id = ?");
        
        // Liên kết tham số
        $sql->bind_param('i', $banner_id);
        
        // Thực thi truy vấn
        $sql->execute();
        
        // Lấy kết quả
        $result = $sql->get_result();
        
        // Trả về kết quả dưới dạng một mảng kết hợp (associative array)
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            // Trả về null nếu không tìm thấy banner
            return null;
        }
    }
    
    public function editBanner($banner_id, $banner_image, $order, $action) {
        // Chuẩn bị câu lệnh SQL để cập nhật thông tin banner
        $sql = self::$connection->prepare("UPDATE banner SET image_url = ?, `order` = ?, action = ? WHERE banner_id = ?");
    
        // Liên kết tham số với câu lệnh SQL
        $sql->bind_param('sssi', $banner_image, $order, $action, $banner_id);
    
        // Thực thi câu lệnh SQL
        if ($sql->execute()) {
            // Nếu cập nhật thành công, trả về true
            return true;
        } else {
            // Nếu có lỗi, trả về false
            return false;
        }
    }

    public function addBanner($banner_image, $order, $action) {
        // Chuẩn bị câu lệnh SQL để thêm một banner mới
        $sql = self::$connection->prepare("INSERT INTO banner (image_url, `order`, action) VALUES (?, ?, ?)");
    
        // Liên kết tham số với câu lệnh SQL
        $sql->bind_param('sss', $banner_image, $order, $action);
    
        // Thực thi câu lệnh SQL
        if ($sql->execute()) {
            // Nếu thêm thành công, trả về true
            return true;
        } else {
            // Nếu có lỗi, trả về false
            return false;
        }
    }
    
    public function bannerExists($banner_id) {
        // Chuẩn bị câu lệnh SQL để kiểm tra sự tồn tại của banner
        $sql = self::$connection->prepare("SELECT COUNT(*) FROM banner WHERE banner_id = ?");
        
        // Liên kết tham số với câu lệnh SQL
        $sql->bind_param('i', $banner_id); // 'i' cho kiểu integer
        
        // Thực thi câu lệnh SQL
        $sql->execute();
        
        // Lấy kết quả trả về
        $sql->bind_result($count);
        $sql->fetch();
        
        // Nếu số lượng bản ghi lớn hơn 0, nghĩa là banner tồn tại
        return $count > 0;
    }


    public function deleteBanner($banner_id) {
        // Kiểm tra sự tồn tại của banner trước khi xóa
        if ($this->bannerExists($banner_id)) {
            // Nếu tồn tại, chuẩn bị câu lệnh SQL để xóa banner
            $sql = self::$connection->prepare("DELETE FROM banner WHERE banner_id = ?");
            
            // Liên kết tham số với câu lệnh SQL
            $sql->bind_param('i', $banner_id); // 'i' cho kiểu integer
            
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