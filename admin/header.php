<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
https://www.youtube.com/watch?v=lXhJZ1uOwHM
-->

<html>
    <head>
        <title>Bài 15: Hướng dẫn tạo quản trị menu đa cấp trong PHP - Phần 1</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../css/admin_style.css" >
        <script src="../resources/ckeditor/ckeditor.js"></script>
    </head>
    <body>
        <?php
        session_start();
        include '../connect_db.php';
        include '../function.php';
        if (!empty($_SESSION['current_user'])) { //Kiểm tra xem đã đăng nhập chưa?
            ?>
            <div id="admin-heading-panel">
                <div class="container">
                    <div class="left-panel">
                        Xin chào <span>Admin</span>
                    </div>
                    <div class="right-panel">
                        <img height="24" src="../images/home.png" />
                        <a href="../index.php">Trang chủ</a>
                        <img height="24" src="../images/logout.png" />
                        <a href="logout.php">Đăng xuất</a>
                    </div>
                </div>
            </div>
            <div id="content-wrapper">
                <div class="container">
                    <div class="left-menu">
                        <div class="menu-heading">Admin Menu</div>
                        <div class="menu-items">
                            <ul>
                                <li><a href="#">Cấu hình</a></li>

                                <?php if (checkPrivileges('menu_listing.php') ) {   ?>
                                    <li><a href="menu_listing.php">Danh mục</a></li>
                                   
                                   <?php }    ?>


                                <?php if (checkPrivileges('menu_listing.php') ) {   ?>
                                    <li><a href="#">Tin tức</a></li>
                                   
                                   <?php }    ?>

                                <?php if (checkPrivileges('product_listing.php') ) {   ?>
                                    <li><a href="product_listing.php">Sản phẩm</a></li>
                                   
                                   <?php }   ?>

                                <?php if (checkPrivileges('order_listing.php') ) {   ?>
                                    <li><a href="order_listing.php">Đơn hàng</a></li>
                                   
                                   <?php }    ?>

                                <?php if (checkPrivileges('member_listing.php') ) {   ?>
                                    <li><a href="member_listing.php">Quản lý thành viên</a></li>
                                   
                                   <?php }    ?>


                                
                            </ul>
                        </div>
                    </div>
                <?php } ?>