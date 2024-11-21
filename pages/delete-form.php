<?php
if (!$field_id) {
    header("Location: " . BASE_URL . "/all-forms");
    exit();
}
$sql = "DELETE from forms where id = $field_id";
$res = mysqli_query($con, $sql);
if ($res) {
    header("Location: " . BASE_URL . "/all-forms");
}

$row = mysqli_fetch_assoc($res);
?>