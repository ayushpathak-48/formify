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
// echo '<pre>';
// print_r($row);
// echo '</pre>';
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

            <div class="grid grid-cols-2 gap-4 items-end" id="options_box_wrapper" style="display: none;">
                <div class="colspan-2 gap-2 flex flex-col" id="options_box">
                </div>
                <button
                    class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-[#11131e] text-white hover:bg-[#11131e]/90 h-10 px-4 py-2 w-full"
                    type="button" onclick="addNewOption()">Add Option</button>
            </div>

            <div id="default_value_wrapper">
                <?php if (in_array($row['field_type'], ['dropdown', 'radio', 'checkbox'])) {
                    $options = explode(',', $row['options']);
                ?>
                    <label for="default_value" class="block mb-2 text-sm font-medium text-gray-900">
                        Default Value</label>
                    <select id="default_value" name="default_value"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        placeholder="">
                        <option>
                            Select Default Option
                        </option>
                        <?php

                        foreach ($options as $key => $value) {
                        ?>
                            <option value='<?php echo $value ?>'
                                <?php echo $row['default_value'] == $value ? 'selected' : '' ?>>
                                <?php echo $value ?></option>
                        <?php
                        }
                        ?>
                    </select>
                <?php } else {
                ?>
                    <label
                        class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
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
    const defaultValueWrapper = document.getElementById('default_value_wrapper');
    const optionsBoxWrapper = document.getElementById('options_box_wrapper');
    const optionsBox = document.getElementById('options_box');
    const optionBoxNames = [];
    const dropDownDefaultValueHTML = `<label for="default_value" class="block mb-2 text-sm font-medium text-gray-900">
                    Default Value</label>
                <select id="default_value" name="default_value"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="">
                    <option selected value="">Select Default Option</option>
                </select>`;

    const inputDefaultValueHTML = `<label
                        class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
                        for="default_value">Default Value</label>
                    <input type="default_value"
                        class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                        id="default_value" name="default_value" placeholder="Enter Default Value">`;

    function handleFieldTypeChange(e) {
        if (['dropdown', 'radio', 'checkbox'].includes(e.value)) {
            optionsBoxWrapper.style.display = 'grid';
            defaultValueWrapper.style.display = 'block';
            const optionDiv = getOptionDiv();
            optionsBox.appendChild(optionDiv);
            defaultValueWrapper.innerHTML = '';
        } else {
            optionsBoxWrapper.style.display = 'none';
            defaultValueWrapper.innerHTML = inputDefaultValueHTML;
            optionsBox.innerHTML = '';
        }
    }

    function addNewOption() {
        const optionDiv = getOptionDiv();
        optionsBox.appendChild(optionDiv);
        if (defaultValueWrapper.innerHTML.trim() == '') {
            defaultValueWrapper.innerHTML = dropDownDefaultValueHTML;
        }
        const optionValues = [];
        const defaultValueDropdown = document.getElementById('default_value');
        defaultValueDropdown.innerHTML = ``;
        handleAddDropdownDefaultValue('Select Default Option', 'Select Default Option')
        optionBoxNames.forEach((option) => {
            const value = document.getElementById(option).value;
            if (value.trim() != '') {
                handleAddDropdownDefaultValue(value, option);
            }
        });

    }

    function getOptionDiv() {
        const option_name = `option_${Date.now()}`;
        optionBoxNames.push(option_name);
        const optionDiv = document.createElement('div');
        optionDiv.innerHTML = `
            <div>
                        <label
                            class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
                            for="${option_name}">Option ${optionBoxNames?.length}</label>
                        <input type="option"
                            class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                            id="${option_name}" name="${option_name}" placeholder="Enter Option" required onkeyup="handleOptionChange('${option_name}',this.value)">
                    </div>
                            `;

        return optionDiv;

    }

    function handleOptionChange(option_name, value) {
        if (defaultValueWrapper.innerHTML.trim() == '') {
            defaultValueWrapper.innerHTML = dropDownDefaultValueHTML;
        }
        const singleDefaultOption = document.getElementById(`default_value_${option_name}`);
        if (singleDefaultOption) {
            singleDefaultOption.value = value || '';
            singleDefaultOption.innerHTML = value || '';
        } else {
            handleAddDropdownDefaultValue(value, option_name);
        }
    }

    function handleAddDropdownDefaultValue(value, option) {
        const defaultValueDropdown = document.querySelector('#default_value');
        const optionElement = document.createElement('option');
        optionElement.setAttribute('id', `default_value_${option}`);
        optionElement.value = value == 'Select Default Option' ? '' : value;
        optionElement.selected = false;
        optionElement.innerHTML = value;
        defaultValueDropdown.appendChild(optionElement);
        console.log(defaultValueDropdown)
    }
</script>