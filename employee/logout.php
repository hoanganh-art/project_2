<?php
session_start();

// Xóa tất cả session
$_SESSION = array();

// Hủy session
session_destroy();

// Chuyển hướng về trang đăng nhập
header("Location:  ../login/index.php");
exit();
?>