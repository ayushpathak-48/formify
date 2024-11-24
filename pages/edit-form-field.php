<?php
$options = [];
$isShowOption = false;
$error = '';
if (!$field_id) {
    header("Location: " . BASE_URL . "/all-forms");
    exit();
}
$sql = "SELECT * from fields where id = $field_id";
$res = mysqli_query($con, $sql);
if (mysqli_num_rows($res) == 0) {
    header("Location: " . BASE_URL . "/all-forms");
}

$row = mysqli_fetch_assoc($res);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $error = '';
    $options = [];

    foreach ($_POST as $key => $value) {
        if (str_contains($key, 'option')) {
            array_push($options, $value);
        }
    }
    $options = implode(',', $options);

    $field_type = $_POST['field_type'];
    $label = $_POST['label'];
    $placeholder = $_POST['placeholder'];
    $is_required = $_POST['is_required'];
    $is_active = $_POST['is_active'];

    $default_value = '';
    if (isset($_POST['default_value'])) {
        $default_value = $_POST['default_value'];
    }

    $sql = "Update fields SET 
    `field_type`= '$field_type',
    `is_required`='$is_required',
    `label`='$label',
    `placeholder`='$placeholder',
    `options`='$options',
    `is_active`='$is_active',
    `default_value`='$default_value' WHERE id=$field_id";

    $res = mysqli_query($con, $sql);
    if ($res) {
        header('Location: ' . BASE_URL . '/form-fields/' . $row['form_id']);
    } else {
        $error = 'Failed to update field';
    }
}

?>
<div>
    <div class="text-2xl font-semibold mx-auto w-max">Update Field</div>
    <p class="text-red-500 text-center"><?php echo $error ?></p>
    <div class="max-w-[600px] w-full mt-4 mx-auto">
        <form method="POST" class="grid gap-4">

            <div>
                <label for="field_type" class="block mb-2 text-sm font-medium text-gray-900">Field Type</label>
                <select onchange="handleFieldTypeChange(this)" id="field_type" name="field_type"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option value="input" <?php echo $row['field_type'] == 'input' ? 'selected' : '' ?>>Input</option>
                    <option value="textarea" <?php echo $row['field_type'] == 'textarea' ? 'selected' : '' ?>>Textarea
                    </option>
                    <option value="number" <?php echo $row['field_type'] == 'number' ? 'selected' : '' ?>>Number
                    </option>
                    <option value="password" <?php echo $row['field_type'] == 'password' ? 'selected' : '' ?>>Password
                    </option>
                    <option value="date" <?php echo  $row['field_type'] == 'date' ? 'selected' : '' ?>>Date</option>
                    <option value="url" <?php echo  $row['field_type'] == 'url' ? 'selected' : '' ?>>URL</option>
                    <option value="dropdown" <?php echo  $row['field_type'] == 'dropdown' ? 'selected' : '' ?>>Dropdown
                    </option>
                    <option value="radio" <?php echo  $row['field_type'] == 'radio' ? 'selected' : '' ?>>Radio Button
                    </option>
                    <option value="checkbox" <?php echo  $row['field_type'] == 'checkbox' ? 'selected' : '' ?>>Checkbox
                    </option>
                </select>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="colspan-2 gap-2">
                    <label
                        class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
                        for="label">Label</label>
                    <input type="label"
                        class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                        id="label" name="label" value="<?php echo $row['label'] ?>" placeholder="Enter label" required>
                </div>
                <div class="colspan-2 gap-2">
                    <label
                        class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
                        for="placeholder">Placeholder</label>
                    <input type="placeholder"
                        class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                        id="placeholder" name="placeholder" value="<?php echo $row['placeholder'] ?>"
                        placeholder="Enter Placeholder" required>
                </div>
            </div>

            <?php if (in_array($row['field_type'], ['dropdown', 'radio', 'checkbox'])) {
                $options = explode(',', $row['options']);
            ?>
            <div class="grid grid-cols-2 gap-4 items-end" id="options_box_wrapper">
                <div class="colspan-2 gap-2 flex flex-col" id="options_box">
                    <?php
                        foreach ($options as $key => $value) {
                        ?>
                    <div class="option-item">
                        <label for="option_<?php echo $key + 1 ?>" class="block mb-1 text-sm">Option</label>
                        <input type="text" id="option_<?php echo $key + 1 ?>" name="option_<?php echo $key + 1 ?>"
                            placeholder="Enter Option"
                            class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                            oninput="updateDefaultValue()" value="<?php echo $value ?>" />
                        <button type="button" class="text-xs text-gray-500 italic"
                            onclick="removeOption(this)">Remove</button>
                    </div>
                    <?php
                        }
                        ?>
                </div>
                <button
                    class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-[#11131e] text-white hover:bg-[#11131e]/90 h-10 px-4 py-2 w-full"
                    type="button" onclick="addNewOption()">Add Option</button>
            </div>
            <?php } ?>

            <div id="default_value_wrapper">
                <?php if (in_array($row['field_type'], ['dropdown', 'radio', 'checkbox'])) {
                    $options = explode(',', $row['options']);
                ?>
                <label for="default_value" class="block mb-2 text-sm font-medium text-gray-900">
                    Default Value</label>
                <select id="default_value" name="default_value"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <?php
                        foreach ($options as $key => $value) {
                        ?>
                    <option value='<?php echo $value ?>'
                        <?php echo $row['default_value'] == $value ? 'selected' : '' ?>>
                        <?php echo $value ?>
                    </option>
                    <?php
                        }
                        ?>
                </select>
                <?php } else {
                ?>
                <label
                    class=" text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
                    for="default_value">Default Value</label>
                <input type="default_value"
                    class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                    id="default_value" name="default_value" value="<?php echo $row['default_value'] ?>"
                    placeholder="Enter Default Value">
                <?php
                } ?>
            </div>
            <div class="flex flex-col gap-3">
                <label
                    class="inline-flex items-center cursor-pointer justify-between border border-gray-300 rounded-lg p-3">
                    <span class="ms-3 text-sm font-medium text-gray-900">Required</span>
                    <input type="hidden" name="is_required" value="<?php echo $row['is_required'] ?>">
                    <input <?php echo $row['is_required'] == 1 ? 'checked' : '' ?> type="checkbox" class="sr-only peer"
                        onchange="document.getElementsByName('is_required')[0].value = this.checked ? '1' : '0'">
                    <div
                        class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-1 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full  peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all peer-checked:bg-[#11131e]">
                    </div>
                </label>
                <label
                    class="inline-flex items-center cursor-pointer justify-between border border-gray-300 rounded-lg p-3">
                    <span class="ms-3 text-sm font-medium text-gray-900">Active</span>
                    <input type="hidden" name="is_active" value="<?php echo $row['is_active'] ?>">
                    <input <?php echo $row['is_active'] == 1 ? 'checked' : '' ?> type="checkbox" class="sr-only peer"
                        onchange="document.getElementsByName('is_active')[0].value = this.checked ? '1' : '0'">
                    <div
                        class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-1 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full  peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all peer-checked:bg-[#11131e]">
                    </div>
                </label>
            </div>
            <button
                class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-[#11131e] text-white hover:bg-[#11131e]/90 h-10 px-4 py-2 w-full"
                type="submit">Update Field</button>
        </form>
    </div>
</div>
<script>
const optionsBoxWrapper = document.getElementById("options_box_wrapper");
const optionsBox = document.getElementById("options_box");
const defaultValueWrapper = document.getElementById("default_value_wrapper");

const inputDefaultValueHTML = `
  <label class="text-sm font-medium" for="default_value">Default Value</label>
  <input type="text" id="default_value" name="default_value" placeholder="Enter Default Value" class="form-input" />`;

const dropDownDefaultValueHTML = `
  <label for="default_value" class="block mb-2 text-sm font-medium">Default Value</label>
  <select id="default_value" name="default_value" class="form-select">
    <option value="" selected>Select Default Option</option>
  </select>`;

function handleFieldTypeChange(e) {
    const fieldType = e.value;
    if (["dropdown", "radio", "checkbox"].includes(fieldType)) {
        optionsBoxWrapper.style.display = "grid";
        defaultValueWrapper.innerHTML = dropDownDefaultValueHTML;
    } else {
        optionsBoxWrapper.style.display = "none";
        defaultValueWrapper.innerHTML = inputDefaultValueHTML;
        optionsBox.innerHTML = "";
    }
}

function addNewOption() {
    const optionId = `option_${Date.now()}`;
    const optionDiv = document.createElement("div");
    optionDiv.innerHTML = `
    <div class="option-item">
      <label for="${optionId}" class="block mb-1 text-sm">Option</label>
      <input type="text" id="${optionId}" name="${optionId}" placeholder="Enter Option" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" oninput="updateDefaultValue()" />
      <button type="button" class="text-xs text-gray-500 italic" onclick="removeOption(this)">Remove</button>
    </div>`;
    optionsBox.appendChild(optionDiv);

    updateDefaultValue();
}

function removeOption(button) {
    button.closest(".option-item").remove();
    updateDefaultValue();
}

function updateDefaultValue() {
    const options = optionsBox.querySelectorAll("input");
    const defaultValueDropdown = document.getElementById("default_value");

    if (defaultValueDropdown.tagName === "SELECT") {
        defaultValueDropdown.innerHTML = `<option value="" selected>Select Default Option</option>`;
        options.forEach((input) => {
            if (input.value.trim() !== "") {
                const option = document.createElement("option");
                option.value = input.value;
                option.textContent = input.value;
                defaultValueDropdown.appendChild(option);
            }
        });
    }
}
</script>