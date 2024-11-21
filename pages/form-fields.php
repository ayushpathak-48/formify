<?php
if (!$form_id) {
    header("Location: " . BASE_URL . "/all-forms");
    exit();
}
$sql = "SELECT * from fields where form_id = $form_id";
$res = mysqli_query($con, $sql);
$count = mysqli_num_rows($res);

?>
<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-500">
        <div class="flex items-center justify-between text-gray-900 bg-white p-5">
            <div class="text-lg font-semibold text-left ">
                <span>
                    Fields of Form 1
                </span>
                <span class="text-muted text-sm font-normal ml-2 border rounded-md p-2 px-4">Total
                    : <?php echo $count ?>
                </span>
            </div>
            <a href="<?php echo BASE_URL . '/create-form-field/' . $form_id ?>"
                class="w-max items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-[#11131e] text-white hover:bg-[#11131e]/90 h-10 px-4 py-2 w-full"
                type="submit">Create</a>
        </div>
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Field Type
                </th>
                <th scope="col" class="px-6 py-3">
                    Label
                </th>
                <th scope="col" class="px-6 py-3">
                    Placeholder
                </th>
                <th scope="col" class="px-6 py-3">
                    Default Value
                </th>
                <th scope="col" class="px-6 py-3">
                    Active
                </th>
                <th scope="col" class="px-6 py-3">
                    Required
                </th>
                <th scope="col" class="px-6 py-3">
                    Actions
                </th>
            </tr>
        </thead>
        <tbody>

            <?php
            while (
                $row = mysqli_fetch_assoc($res)
            ) {
            ?>
                <tr class="bg-white border-b">
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                        <?php echo $row['field_type'] ?>
                    </td>
                    <td class="px-6 py-4">
                        <?php echo $row['label'] ?>
                    </td>
                    <td class="px-6 py-4">
                        <?php echo $row['placeholder'] ?>
                    </td>
                    <td class="px-6 py-4">
                        <?php echo $row['default_value'] ?>
                    </td>
                    <td class="px-6 py-4">
                        <!-- <?php echo $row['is_active'] ?> -->
                        <?php echo $row['is_active'] == 1 ? '<span class="text-green-500">Active</span>' : '<span class="text-red-500">Inactive</span>' ?>

                    </td>
                    <td class="px-6 py-4">
                        <?php echo $row['is_required'] == 1 ? 'Required' : 'Not required' ?>
                    </td>
                    <td class="px-6 py-4 text-right gap-3 flex items-center justify-end">
                        <a href="<?php echo BASE_URL ?>/edit-form-field/<?php echo $row['id'] ?>"
                            class="font-medium text-blue-600 hover:underline"><button class="border-0 bg-indigo-500 rounded-md px-4 p-1 text-white no-underline">Edit</button></a>
                        <a href="<?php echo BASE_URL ?>/delete-field/<?php echo $row['id'] ?>"
                            class="font-medium text-blue-600 hover:underline"><button class="border-0 bg-indigo-500 rounded-md px-4 p-1 text-white no-underline">Delete</button></a>
                    </td>
                </tr>

            <?php
            }
            if ($count == 0) {
            ?>
                <tr class="bg-white border-b">
                    <td colspan="6" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap text-center">No Fields
                        Found</td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>