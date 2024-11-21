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

$sql2 = "SELECT * from fields where form_id = $form_id AND is_active = 1";
$res2 = mysqli_query($con, $sql2);

if ($res2) {
    $fieldsData = [];

    while ($row = mysqli_fetch_assoc($res2)) {
        $fieldsData[] = $row; 
    }
} 

$form = mysqli_fetch_assoc($res);

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    // echo '<pre>';
    // print_r($_POST);
    // print_r($fieldsData);
    // die();
    $isError = false;
    foreach ($fieldsData as $index => $field) {
        if ($field['is_required'] == '1') {
            $isError = true;
            $fieldsData[$index]['error'] = 'This field is required';
        }
    }

    if(!$isError){

    foreach ($_POST as $key => $value) {
        $sql3 = "INSERT into responses (`form_id`,`field_id`,`value`) VALUES ('$form_id','$key','$value')";
        $res3 = mysqli_query($con, $sql3);
    }
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
    <div class="absolute inset-0 bg-gray-100  overflow-y-scroll h-screen w-full">
        <form method="post" class="w-full max-w-[600px] flex-col  px-4 gap-4 flex items-center py-10 justify-start mx-auto">
        <div class="w-full border-t-4 border-rose-950 border border-l-4 bg-white rounded-md px-4 py-5">
            <div class="text-2xl font-semibold"><?php echo $form['title'] ?></div>
            <div class="text-lg font-normal"><?php echo $form['description'] ?></div>
        </div>
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
                if (in_array($field['field_type'], ['input', 'number', 'password','url'])) {
                ?>
            <input type="<?php echo $field['field_type'] ?>"
                class="<?php echo isset($field['error']) ? 'border-red-500' : '' ?> flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                id="<?php echo $field['id']; ?>" name="<?php echo $field['id']; ?>"
                placeholder="<?php echo $field['placeholder']; ?>" value="<?php echo $field['default_value']; ?>">
               
            <?php
                }
                ?>

            <?php
                if ($field['field_type'] == 'textarea') {
                ?>
            <textarea
                class="flex min-h-[60px] w-full rounded-md border border-input bg-transparent px-3 py-2 text-base shadow-sm placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50 md:text-sm"
                id="<?php echo $field['id']; ?>" name="<?php echo $field['id']; ?>"
                placeholder="<?php echo $field['placeholder']; ?>" value="<?php echo $field['default_value']; ?>"></textarea>

            <?php
                }
                ?>
            
            <?php
                if ($field['field_type'] == 'radio') {
                    $options = explode(",",$field['options']);
                foreach($options as $option){
                ?>
            <div class="flex items-center mb-1">
                <input id="<?php echo $option?>" type="radio" name="<?php echo $field['id']?>" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 dark:bg-gray-700 dark:border-gray-600"
                <?php echo $field['default_value'] == $field ? 'checked' : '' ?>
                >
                <label for="<?php echo $option?>" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300"><?php echo $option;?></label>
            </div>
                <?php
                }        
                    }
                    ?>
            <div>
            </div>
            <div class="transition-all text-red-500 font-normal text-sm leading-[12px] <?php echo isset($field['error']) ? 'h-[12px]' : 'h-0' ?>"><?php echo isset($field['error'])  ?  $field['error'] : ''?></div>
        </div>
        
        <?php
        }
        ?>
        <button type="submit" class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mb-2 w-full">Submit</button>
        </form>
    </div>
</body>

</html>