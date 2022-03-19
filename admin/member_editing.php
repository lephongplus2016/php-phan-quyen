<?php
// CONTROLLER =====================================================================================
include 'header.php';
if (!empty($_SESSION['current_user'])) {
	?>
	<div class="main-content">
		<h1><?= !empty($_GET['id']) ? ((!empty($_GET['task']) && $_GET['task'] == "copy") ? "Copy thành viên" : "Sửa thành viên") : "Thêm thành viên" ?></h1>
		<div id="content-box">
			<?php
			if (isset($_GET['action']) && ($_GET['action'] == 'add' || $_GET['action'] == 'edit')) {

			// if($_SERVER['REQUEST_METHOD'] === 'POST'){

				var_dump($_POST);
				if (isset($_POST['username']) && !empty($_POST['username']) 
					&& isset($_POST['password']) && !empty($_POST['password'])
					&& isset($_POST['re_password']) && !empty($_POST['re_password'])) {
					if (empty($_POST['username'])) {
						$error = "Bạn phải nhập tên đăng nhập";
					} elseif (empty($_POST['password'])) {
						$error = "Bạn phải nhập mật khẩu";
					} elseif (empty($_POST['re_password'])) {
						$error = "Bạn phải nhập xác nhận mật khẩu";
					} elseif ($_POST['password'] != $_POST['re_password']) {
						$error = "Mật khẩu xác nhận không khớp";
					}
					// nếu ko có lỗi
					if (!isset($error)) {
						
								// edit
                    		if ($_GET['action'] == 'edit' && !empty($_GET['id'])) { //Cập nhật lại thành viên
	                        	$result = mysqli_query($con, "UPDATE `user` SET `fullname` = '".$_POST['fullname']."', `password` = MD5('".$_POST['password']."'), `birthday` = '".time()."' WHERE `user`.`id` = ".$_GET['id'].";");
	                        } else { 
								//Thêm thành viên
								// $checkExistUser = mysqli_query($con, "SELECT * FROM `user` WHERE `username` = '".$_POST['username']."'  AND id != ".$_GET['id']);
								$checkExistUser = mysqli_query($con, "SELECT * FROM `user` WHERE `username` = '".$_POST['username']."' ");

								var_dump( "SELECT * FROM `user` WHERE `username` = '".$_POST['username']."' ") ;
								var_dump($checkExistUser); 
                    			if($checkExistUser->num_rows != 0){ //tồn tại user rồi
									$error = "Username đã tồn tại. Bạn vui lòng chọn username khác";
								} 
								else{
										$result = mysqli_query($con, "INSERT INTO `user` (`id`, `username`, `fullname`, `password`, `birthday`, `created_time`, `last_updated`) VALUES (NULL, '".$_POST['username']."', '".$_POST['fullname']."', MD5('".$_POST['password']."'), '".time()."', '".time()."', ".time().");");
									}
                    	}
                        // nếu query bị lỗi gì đó
                        if (isset($result) && empty($result)) { //Nếu có lỗi xảy ra
                        	$error = "Có lỗi xảy ra trong quá trình thực hiện.";
                        } 
						
                    }
                } else {
                	$error = "Bạn chưa nhập thông tin thành viên.";
                }
                ?>


<!-- END CONTROLLER ===================================================================================== -->

<!-- VIEW ================================================================================================ -->
                <div class = "container">
                	<div class = "error"><?= isset($error) ? $error : "Cập nhật thành công" ?></div>
                	<a href = "member_listing.php">Quay lại danh sách thành viên</a>
                </div>
                <?php
            } else {
				// nếu là sửa thì api get sẽ có id, cần tìm user đó
            	if (!empty($_GET['id'])) {
            		$result = mysqli_query($con, "SELECT * FROM `user` WHERE `id` = " . $_GET['id']);
            		$user = $result->fetch_assoc();
					echo "đã chạy get id";
            	}
				// mới thêm hôm 17/3
				// không hiểu sao mà nó tự hiểu $user = root , nên nó luôn nhảy vào edit , rồi đang là add
				else{
					$user = null;
				}

				if (!empty($user) && !isset($_GET['task'])) {
					echo "edit";
				}
				else {
					echo "add";
				}

            	?>
            	<form id="editing-form" method="POST" action="<?= (!empty($user) && !isset($_GET['task'])) ? "?action=edit&id=" . $_GET['id'] : "?action=add" ?>"  enctype="multipart/form-data">
            	
				<!-- <form id="editing-form" method="POST" action=""  enctype="multipart/form-data"> -->

				<input type="submit" title="Lưu thành viên" value="" />
            		<div class="clear-both"></div>
            		<div class="wrap-field">
            			<label>Tên đăng nhập:  </label >
						<!-- <label>	 <?= (!empty($user) ? $user['username'] : "") ?> </label > -->
																	<!-- trong trường hợp có user
																nghĩa là đang edit
																thì sẽ hiện thông tin các trường khác password, vì password là bảo mật
																-->
            			<input type="text" name="username" value="<?= (!empty($user) ? $user['username'] : "") ?>" />
            			<div class="clear-both"></div>
            		</div>
            		<div class="wrap-field">
            			<label>Mật khẩu: </label>
            			<input type="password" name="password" value="" />
            			<div class="clear-both"></div>
            		</div>
            		<div class="wrap-field">
            			<label>Xác nhận mật khẩu: </label>
            			<input type="password" name="re_password" value="" />
            			<div class="clear-both"></div>
            		</div>
            		<div class="wrap-field">
            			<label>Họ tên: </label>
            			<input type="text" name="fullname" value="<?= !empty($user) ? $user['fullname'] : "" ?>" />
            			<div class="clear-both"></div>
            		</div>
            	</form>
            	<div class="clear-both"></div>
            	
            <?php } ?>
        </div>
    </div>

    <?php
}
include './footer.php';
?>