<?php
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
             $hashedPassword = password_hash('admin123', PASSWORD_DEFAULT); // Hash mật khẩu mặc định
 
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
    public function adminLogin($username, $password){
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
    public function getProfileUser($userId) {
        $sql = self::$connection->prepare("SELECT user_id, name, email, phone, address, username FROM user WHERE user_id = ?");
        if (!$sql) {
            die('Error preparing SQL: ' . self::$connection->error); 
        }
        $sql->bind_param("i", $userId);
        $sql->execute();
        $result = $sql->get_result();
        if ($result->num_rows === 0) {
            return null; 
        }
        return $result->fetch_assoc();
    }
}
