<?php
if (!$field_id) {
    header("Location: " . BASE_URL . "/all-forms");
    exit();
}
$sql = "DELETE from fields where id = $field_id";
$res = mysqli_query($con, $sql);
if ($res) {
    // header("Location: " . BASE_URL . "/form-fields" . "/" . $field_id);
    header("Location: " . $_SERVER['HTTP_REFERER']);
}

$row = mysqli_fetch_assoc($res);
?>