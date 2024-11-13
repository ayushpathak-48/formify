<?php
if (!$form_id) {
    header("Location: " . BASE_URL . "/");
    exit();
}

$sql = "SELECT * from forms where id = $form_id";
$res = mysqli_query($con, $sql);

if (mysqli_num_rows($res) == 0) {
    header("Location: " . BASE_URL . "/");
}

$sql2 = "SELECT * from fields where form_id = $form_id";
$res2 = mysqli_query($con, $sql2);

$row = mysqli_fetch_assoc($res);
$fields = mysqli_fetch_assoc($res2);

echo '<pre>';
print_r($row);
while ($field = mysqli_fetch_assoc($res2)) {
    print_r($field);
}
echo '</pre>';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form - <?php echo $row['title'] ?></title>
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="relative">
    <div class="flex items-center just-center absolute inset-0 bg-gray-100">

    </div>
</body>

</html>