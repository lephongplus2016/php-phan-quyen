<?php
// hàm này dùng regex: nó tìm xem ở link có chuỗi nào khớp chuỗi bên này ko?
// dấu $ là kết thúc ko còn gì phía sau string nữa
function checkPrivileges() {
    $privileges = array(
        "product_listing\.php$",
        "product_editing\.php$",
        "product_editing\.php\?id=\d+&task=copy$",
        "product_editing\.php\?id=\d+$",
        "product_delete\.php\?id=\d+$",



    );
    $privileges = implode("|", $privileges);
    preg_match('/'.$privileges.'/', 'http://localhost/learn/an-dn-phan-quyen/lesson-26/admin/product_editing.php', $matches);
    return !empty($matches);
}

var_dump(checkPrivileges());

?>