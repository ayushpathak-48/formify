<?php
$user_id = $_SESSION['user_id'];
$query = "SELECT  forms.*,  COUNT(responses.form_id) AS response_count FROM forms LEFT JOIN responses ON forms.id = responses.form_id WHERE forms.user_id = $user_id GROUP BY forms.id";
$res = mysqli_query($con, $query);
$count = mysqli_num_rows($res);

?>
<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-500">
        <div class="flex items-center justify-between text-gray-900 bg-white p-5">
            <div class="text-lg font-semibold text-left ">
                <span>
                    Forms
                </span>
                <span class="text-muted text-sm font-normal ml-2 border rounded-md p-2 px-4">Total
                    : <?php echo $count ?>
                </span>
            </div>
            <a href="<?php echo BASE_URL . '/create-form' ?>"
                class="w-max items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-[#11131e] text-white hover:bg-[#11131e]/90 h-10 px-4 py-2 w-full"
                type="submit">Create</a>
        </div>

        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Title
                </th>
                <th scope="col" class="px-6 py-3">
                    Fields
                </th>
                <th scope="col" class="px-6 py-3">
                    Total Responses
                </th>
                <th scope="col" class="px-6 py-3 text-right">
                    Action
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

                    <?php echo $row['title'] ?>
                </td>
                <td class="px-6 py-4">
                    <?php echo $row['response_count'] ?>
                </td>
                <td class="px-6 py-4">
                    <?php echo $row['response_count'] ?>
                </td>
                <td class="px-6 py-4 text-right gap-3 flex items-center justify-end">
                    <a class="font-medium text-blue-600 hover:underline border border-blue-500 px-2 p-1 rounded-md hover:no-underline"
                        href="<?php echo BASE_URL ?>/responses/<?php echo $row['id'] ?>">
                        Responses</a>
                    <a class="font-medium text-blue-600 hover:underline border border-blue-500 px-2 p-1 rounded-md hover:no-underline"
                        href="<?php echo BASE_URL ?>/form-fields/<?php echo $row['id'] ?>">
                        Fields</a>
                    <a href="<?php echo BASE_URL ?>/edit-form/<?php echo $row['id'] ?>"
                        class="font-medium text-blue-600 hover:underline border border-blue-500 px-2 p-1 rounded-md hover:no-underline">Edit</a>
                </td>
            </tr>

            <?php
            }

            if ($count == 0) {
            ?>
            <tr class="bg-white border-b">
                <td colspan="6" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap text-center">
                    No Forms Found
                </td>
            </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>