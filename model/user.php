<?php
require_once 'db.php';
class User extends Db
{
    // Constructor - rename branch cart thành auth admin hihi
    public function __construct()
    {
        // Tạo tài khoản admin mặc định -> SeederDefaultAdmin 
        parent::__construct();
        $stmt = self::$connection->prepare("SELECT username FROM admin WHERE username = ?");
        $username = 'admin';
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        // Nếu chưa có tài khoản admin, tạo tài khoản mặc định
        if ($result->num_rows === 0) {
            $hashedPassword = password_hash('123123', PASSWORD_DEFAULT); // Hash mật khẩu mặc định

            // Thêm tài khoản admin mặc định vào bảng admin
            $stmt = self::$connection->prepare(
                "INSERT INTO admin (name, username, password, created_at, updated_at) 
                  VALUES (?, ?, ?, NOW(), NOW())"
            );
            $name = 'admin'; // Tên của admin mặc định
            $stmt->bind_param("sss", $name, $username, $hashedPassword);

            if ($stmt->execute()) {
                return $result->num_rows > 0;
            } else {
                return $result->num_rows > 0;
            }
        }
    }
    // Kiểm tra xem tên người dùng đã tồn tại chưa
    public function isUsernameExists($username)
    {
        $sql = self::$connection->prepare("SELECT username FROM user WHERE username = ?");
        $sql->bind_param("s", $username);
        $sql->execute();
        $result = $sql->get_result();
        return $result->num_rows > 0; // Trả về true nếu tồn tại, false nếu không
    }

    // Đăng ký người dùng mới
    public function register($name, $email, $phone, $address, $username, $password)
    {

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Mã hóa mật khẩu
        $sql = self::$connection->prepare(
            "INSERT INTO user (user_id, name, email, phone, address, username, password) 
             VALUES (NULL, ?, ?, ?, ?, ?, ?)"
        );
        $sql->bind_param("ssssss", $name, $email, $phone, $address, $username, $hashedPassword);
        return $sql->execute(); // Trả về true nếu thành công
    }

    // Đăng nhập người dùng
    public function login($username, $password)
    {
        // Chuẩn bị truy vấn
        $sql = self::$connection->prepare("SELECT * FROM user WHERE username = ?");
        if (!$sql) {
            die('Error preparing SQL: ' . self::$connection->error); // Xử lý lỗi SQL
        }

        // Gán tham số và thực hiện truy vấn
        $sql->bind_param("s", $username);
        $sql->execute();
        $result = $sql->get_result();

        // Kiểm tra xem có kết quả không
        if ($result->num_rows === 0) {
            return "Username not found"; // Không tìm thấy người dùng
        }

        $user = $result->fetch_assoc();


        // Kiểm tra mật khẩu
        if (password_verify($password, $user['password'])) {
            // Mật khẩu mã hóa trong DB

            return $user; // Trả về thông tin người dùng nếu thành công
        }

        return "Mật khẩu không đúng"; // Mật khẩu không đúng
    }
    public function adminLogin($username, $password)
    {
        // Chuẩn bị truy vấn
        $sql = self::$connection->prepare("SELECT * FROM admin WHERE username = ?");
        if (!$sql) {
            die('Error preparing SQL: ' . self::$connection->error); // Xử lý lỗi SQL
        }

        // Gán tham số và thực hiện truy vấn
        $sql->bind_param("s", $username);
        $sql->execute();
        $result = $sql->get_result();

        // Kiểm tra xem có kết quả không
        if ($result->num_rows === 0) {
            return "Username not found"; // Không tìm thấy người dùng
        }

        $user = $result->fetch_assoc();


        // Kiểm tra mật khẩu
        if (password_verify($password, $user['password'])) {
            // Mật khẩu mã hóa trong DB

            return $user; // Trả về thông tin người dùng nếu thành công
        }

        return "Mật khẩu không đúng"; // Mật khẩu không đúng
    }
    public function isAdminExists($username)
    {
        $sql = self::$connection->prepare("SELECT username FROM admin WHERE username = ?");
        $sql->bind_param("s", $username);
        $sql->execute();
        $result = $sql->get_result();
        return $result->num_rows > 0; // Trả về true nếu tồn tại, false nếu không
    }

    public function getAllUser()
    {
        $sql = self::$connection->prepare("SELECT * FROM user");
        $sql->execute();
        $result = $sql->get_result();

        // Trả về mảng chứa tất cả người dùng, hoặc trả về mảng rỗng nếu không có người dùng
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function editUser($user_id, $name, $email, $phone, $address, $username, $password = null)
    {

        // Kiểm tra nếu có mật khẩu mới thì cập nhật, nếu không thì bỏ qua trường mật khẩu
        if ($password) {
            $sql = self::$connection->prepare("UPDATE user SET name = ?, email = ?, phone = ?, address = ?, username = ?, password = ? WHERE user_id = ?");
            $sql->bind_param("ssssssi", $name, $email, $phone, $address, $username, $password, $user_id);
        } else {
            $sql = self::$connection->prepare("UPDATE user SET name = ?, email = ?, phone = ?, address = ?, username = ? WHERE user_id = ?");
            $sql->bind_param("sssssi", $name, $email, $phone, $address, $username, $user_id);
        }

        // Thực thi câu lệnh SQL và trả về kết quả
        return $sql->execute();
    }

    public function userExists($user_id)
    {
        // Chuẩn bị câu lệnh SQL để kiểm tra sự tồn tại của banner
        $sql = self::$connection->prepare("SELECT COUNT(*) FROM user WHERE user_id = ?");

        // Liên kết tham số với câu lệnh SQL
        $sql->bind_param('i', $user_id); // 'i' cho kiểu integer

        // Thực thi câu lệnh SQL
        $sql->execute();

        // Lấy kết quả trả về
        $sql->bind_result($count);
        $sql->fetch();

        // Nếu số lượng bản ghi lớn hơn 0, nghĩa là banner tồn tại
        return $count > 0;
    }

    public function getUserById($user_id)
    {
        // Chuẩn bị câu truy vấn SQL để lấy banner theo ID
        $sql = self::$connection->prepare("SELECT * FROM user WHERE user_id = ?");

        // Liên kết tham số
        $sql->bind_param('i', $user_id);

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

    public function deleteUser($user_id)
    {
        if ($this->userExists($user_id)) {
            // Nếu tồn tại, chuẩn bị câu lệnh SQL để xóa banner
            $sql = self::$connection->prepare("DELETE FROM user WHERE user_id = ?");
            
            // Liên kết tham số với câu lệnh SQL
            $sql->bind_param('i', $user_id); // 'i' cho kiểu integer
            
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
