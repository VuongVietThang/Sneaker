<?php
// hàm mã hóa Hex product_id
function encryptProductId($product_id) {
    $key = 'secret_key'; 
    $iv = '1234567890123456'; // Đảm bảo sử dụng IV ngẫu nhiên trong môi trường thực tế
    $encrypted = openssl_encrypt($product_id, 'aes-128-cbc', $key, 0, $iv);
    return bin2hex($encrypted); // Mã hóa thành chuỗi hex
  }
    // hàm giải mã Hex product_id
    function decryptProductId($encrypted_product_id) {
        $key = 'secret_key';
        $iv = '1234567890123456';
        $encrypted_data = hex2bin($encrypted_product_id); // Chuyển từ hex về dạng nhị phân
        return openssl_decrypt($encrypted_data, 'aes-128-cbc', $key, 0, $iv);
    }
?>