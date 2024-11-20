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

$sql2 = "SELECT * from fields where form_id = $form_id AND is_active=1";
$res2 = mysqli_query($con, $sql2);

$form = mysqli_fetch_assoc($res);
$fields = mysqli_fetch_assoc($res2);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form - <?php echo $form['title'] ?></title>
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="relative">
    <div class="flex items-center py-10 justify-start absolute inset-0 bg-gray-100 flex-col h-screen px-4 gap-4">
        <div class="w-full max-w-[600px] border-t-4 border-purple-500 border border-l-4 bg-white rounded-md px-4 py-5">
            <div class="text-2xl font-semibold"><?php echo $form['title'] ?></div>
            <div class="text-lg font-normal"><?php echo $form['description'] ?></div>
        </div>
        <!-- <pre> -->
        <?php
        while ($field = mysqli_fetch_assoc($res2)) {
        ?>

        <div class="w-full max-w-[600px] border-purple-500 border bg-white rounded-md px-4 py-5 flex flex-col gap-2">
            <label
                class="text-[#11131e] text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
                for="<?php echo $field['id']; ?>">
                <?php echo $field['label']; ?>
            </label>

            <?php
                if (in_array($field['field_type'], ['input', 'number', 'password'])) {
                ?>
            <input type="<?php echo $field['field_type'] ?>"
                class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                id="<?php echo $field['id']; ?>" name="<?php echo $field['id']; ?>"
                placeholder="<?php echo $field['placeholder']; ?>" value="<?php echo $field['default_value']; ?>"
                <?php echo $field['is_required'] == 1 ? 'required' : '' ?>>
            <?php
                }
                ?>

            <?php
                if ($field['field_type'] == 'textarea') {
                ?>

            <textarea
                class="flex min-h-[60px] w-full rounded-md border border-input bg-transparent px-3 py-2 text-base shadow-sm placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50 md:text-sm"
                id="<?php echo $field['id']; ?>" name="<?php echo $field['id']; ?>"
                placeholder="<?php echo $field['placeholder']; ?>" value="<?php echo $field['default_value']; ?>"
                <?php echo $field['is_required'] == 1 ? 'required' : '' ?>></textarea>

            <?php
                }
                ?>
            <div>
            </div>
        </div>
    </div>
    <?php
        }
?>
    <!-- </pre> -->
    </div>
</body>

</html>