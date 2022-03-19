<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Bài 12: Hướng dẫn tạo trang quản trị (admin): quản lý sản phẩm - Phần 1</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            .box-content{
                margin: 0 auto;
                width: 800px;
                border: 1px solid #ccc;
                text-align: center;
                padding: 20px;
            }
            #user_login form{
                width: 200px;
                margin: 40px auto;
            }
            #user_login form input{
                margin: 5px 0;
            }
        </style>
    </head>
    <body>
        <?php
        session_start();
        include '../connect_db.php';
        include '../function.php';
        // $url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        // $regexResult = checkPrivileges($url);
        // if(!$regexResult) {
        //     echo "You are not allowed to access this page!";
        //     exit;
        // }

        $error = false;
        if (isset($_POST['username']) && !empty($_POST['username']) && isset($_POST['password']) && !empty($_POST['password'])) {
            $result = mysqli_query($con, "Select `id`,`username`,`fullname`,`birthday` from `user` WHERE (`username` ='" . $_POST['username'] . "' AND `password` = md5('" . $_POST['password'] . "'))");
            if (!$result) {
                $error = mysqli_error($con);
            } else {
                $user = mysqli_fetch_assoc($result);
                if ($user['username'] == "admin") {
                    $user['privileges'] = array(
                        "product_listing\.php$",
                        "product_editing\.php$",
                        "product_editing\.php\?id=\d+&task=copy$",
                        "product_editing\.php\?id=\d+$",
                        "product_delete\.php\?id=\d+$",
                        "menu_listing\.php$",
                        "menu_editing\.php$",
                        "menu_editing\.php\?id=\d+&task=copy$",
                        "menu_editing\.php\?id=\d+$",
                        "menu_delete\.php\?id=\d+$",
                        "member_listing\.php$",
                        "member_editing\.php$",
                        "member_editing\.php\?id=\d+&task=copy$",
                        "member_editing\.php\?id=\d+$",
                        "member_delete\.php\?id=\d+$",
                        "order_listing\.php$",
                        "order_editing\.php$",
                        "order_editing\.php\?id=\d+&task=copy$",
                        "order_editing\.php\?id=\d+$",
                        "order_delete\.php\?id=\d+$"
                    );
                }else{
                    $user['privileges'] = array(
                        "product_listing\.php$",
                        "product_editing\.php$",
                        "product_editing\.php\?id=\d+&task=copy$",
                        "product_editing\.php\?id=\d+$",
                        "product_delete\.php\?id=\d+$"
                    );
                }
                $_SESSION['current_user'] = $user;
                // var_dump($_SESSION['current_user']);
            }
            mysqli_close($con);
            if ($error !== false || $result->num_rows == 0) {
                ?>
                <div id="login-notify" class="box-content">
                    <h1>Thông báo</h1>
                    <h4><?= !empty($error) ? $error : "Thông tin đăng nhập không chính xác" ?></h4>
                    <a href="./index.php">Quay lại</a>
                </div>
                <?php
                exit;
            }
            ?>
        <?php } ?>
        <?php if (empty($_SESSION['current_user'])) { ?>
            <div id="user_login" class="box-content">
                <h1>Đăng nhập tài khoản</h1>
                <form action="./index.php" method="Post" autocomplete="off">
                    <label>Username</label></br>
                    <input type="text" name="username" value="" /><br/>
                    <label>Password</label></br>
                    <input type="password" name="password" value="" /></br>
                    <br>
                    <input type="submit" value="Đăng nhập" />
                </form>
            </div>
            <?php
        } else {
            $currentUser = $_SESSION['current_user'];
            ?>
            <div id="login-notify" class="box-content">
                Xin chào <?= $currentUser['fullname'] ?><br/>
                <a href="./product_listing.php">Quản lý sản phẩm</a><br/>
                <a href="./edit.php">Đổi mật khẩu</a><br/>
                <a href="./logout.php">Đăng xuất</a>
            </div>
        <?php } ?>
    </body>
</html>