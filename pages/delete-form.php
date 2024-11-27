<?php
if (!$form_id) {
    header("Location: " . BASE_URL . "/");
    exit();
}
$sql = "DELETE from forms where id = $form_id";
$res = mysqli_query($con, $sql);
if ($res) {
    header("Location: " . BASE_URL . "/");
}
?>