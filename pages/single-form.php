<?php
session_start();

if (!$form_id) {
    header("Location: " . BASE_URL . "/");
    exit();
}

$isFormSubmitted = false;

if (isset($_SESSION['form_submitted_' . $form_id])) {
    $isFormSubmitted = true;
}

$sql = "SELECT * from forms where id = $form_id";
$res = mysqli_query($con, $sql);

if (mysqli_num_rows($res) == 0) {
    header("Location: " . BASE_URL . "/");
}

$sql2 = "SELECT * from fields where form_id = $form_id AND is_active = 1";
$res2 = mysqli_query($con, $sql2);

if ($res2) {
    $fieldsData = [];

    while ($row = mysqli_fetch_assoc($res2)) {
        $fieldsData[] = $row;
    }
}

$form = mysqli_fetch_assoc($res);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $isError = false;
    foreach ($fieldsData as $index => $field) {
        if ($field['field_type'] == 'checkbox' && isset($_POST[$form_id . "_checkbox_" . $field['id']])) {
            if ($field['is_required'] == '1' && $_POST[$form_id . "_checkbox_" . $field['id']] == '') {
                $isError = true;
                $fieldsData[$index]['error'] = 'This field is required';
            }
        } else if (isset($_POST[$field['id']])) {
            if ($field['is_required'] == '1' && $_POST[$field['id']] == '') {
                $isError = true;
                $fieldsData[$index]['error'] = 'This field is required';
            }
        }
    }
    $checkbox_options = [];
    foreach ($_POST as $key => $value) {
        if (str_contains($key, 'checkbox')) {
            array_push($checkbox_options, $value);
        }
    }
    $checkbox_options = implode(',', $checkbox_options);
    $checkboxId = '';
    if (!$isError) {
        foreach ($_POST as $key => $value) {
            if (str_contains($key, 'checkbox') && $checkboxId != explode('_', $key)[0]) {
                $checkboxId = explode('_', $key)[0];
                $_POST[$checkboxId] = $checkbox_options;
                unset($_POST[$key]);
            }
        }
        $values =  json_encode($_POST, JSON_UNESCAPED_SLASHES);
        $sqltoInsert = "INSERT into responses (`form_id`,`field_id`,`response_values`) VALUES ('$form_id','$key','$values')";
        $insertResult = mysqli_query($con, $sqltoInsert);
        $_SESSION['form_submitted_' . $form_id] = true;
    }
}
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
    <?php if (!$isFormSubmitted) { ?>
    <div class="absolute inset-0 bg-gray-100  overflow-y-scroll h-screen w-full">
        <div class="w-full max-w-[600px] flex-col  px-4 gap-4 flex items-center py-10 justify-start mx-auto">
            <div class="w-full border-t-4 border-rose-950 border border-l-4 bg-white rounded-md px-4 py-5">
                <div class="text-2xl font-semibold"><?php echo $form['title'] ?></div>
                <div class="text-lg font-normal"><?php echo $form['description'] ?></div>
            </div>
            <form method="post" class="w-full flex flex-col gap-4">
                <?php
                    foreach ($fieldsData as $field) {
                    ?>
                <div class="w-full border-rose-950 border bg-white rounded-md px-4 py-5 flex flex-col gap-2">
                    <label
                        class="<?php echo isset($field['error']) ? 'text-red-500' : 'text-[#11131e]' ?> text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
                        for="<?php echo $field['id']; ?>">
                        <?php echo $field['label']; ?>
                    </label>
                    <?php
                            if (in_array($field['field_type'], ['input', 'number', 'password', 'url', 'date', 'time'])) {
                            ?>
                    <input type="<?php echo $field['field_type'] ?>"
                        class="<?php echo isset($field['error']) ? 'border-red-500' : '' ?> flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                        id="<?php echo $field['id']; ?>" name="<?php echo $field['id']; ?>"
                        placeholder="<?php echo $field['placeholder']; ?>"
                        value="<?php echo $field['default_value']; ?>">

                    <?php
                            }
                            ?>

                    <?php
                            if ($field['field_type'] == 'textarea') {
                            ?>
                    <textarea
                        class="flex min-h-[60px] w-full rounded-md border border-input bg-transparent px-3 py-2 text-base shadow-sm placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50 md:text-sm"
                        id="<?php echo $field['id']; ?>" name="<?php echo $field['id']; ?>"
                        placeholder="<?php echo $field['placeholder']; ?>"
                        value="<?php echo $field['default_value']; ?>"></textarea>

                    <?php
                            }
                            ?>

                    <?php
                            if ($field['field_type'] == 'checkbox') {
                                $options = explode(',', $field['options']);
                                foreach ($options as $key => $value) {
                            ?>
                    <div class="flex items-center">
                        <input id="<?php echo $key ?>" type="checkbox"
                            name="<?php echo $field['id'] ?>_checkbox_<?php echo $key ?>"
                            <?php echo $field['default_value'] == $value ? 'checked' : '' ?>
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                            value="<?php echo $value ?>">
                        <label for="<?php echo $key ?>"
                            class="ms-2 text-sm font-medium text-gray-900"><?php echo $value ?></label>
                    </div>
                    <?php
                                }
                            }
                            ?>

                    <?php
                            if ($field['field_type'] == 'dropdown') {
                                $options = explode(',', $field['options']);
                            ?>
                    <select id="field_type" name="<?php echo $field['id']; ?>"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <?php
                                    foreach ($options as $key => $value) {
                                    ?>
                        <option value='<?php echo $value ?>'
                            <?php echo $field['default_value'] == $value ? 'selected' : '' ?>>
                            <?php echo $value ?>
                        </option>
                        <?php
                                    }
                                    ?>
                    </select>
                    <?php
                            }
                            ?>

                    <?php
                            if ($field['field_type'] == 'radio') {
                                $options = explode(",", $field['options']);
                                foreach ($options as $option) {
                            ?>
                    <div class="flex items-center mb-1">
                        <input id="<?php echo $option ?>" type="radio" name="<?php echo $field['id'] ?>"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300"
                            <?php echo $field['default_value'] == $value ? 'checked' : '' ?>
                            value="<?php echo $option; ?>">
                        <label for="<?php echo $option ?>"
                            class="ms-2 text-sm font-medium text-gray-900"><?php echo $option; ?></label>
                    </div>
                    <?php
                                }
                            }
                            ?>
                    <div>
                    </div>
                    <div
                        class="transition-all text-red-500 font-normal text-sm leading-[12px] <?php echo isset($field['error']) ? 'h-[12px]' : 'h-0' ?>">
                        <?php echo isset($field['error'])  ?  $field['error'] : '' ?></div>
                </div>

                <?php
                    }
                    ?>
                <button type="submit"
                    class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mb-2 w-full">Submit</button>
            </form>
        </div>
        <?php } else {
        ?>

        <div>Form already submitted</div>
        <?php
    } ?>
    </div>

</body>

</html>