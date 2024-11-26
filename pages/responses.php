<?php
$user_id = $_SESSION['user_id'];
$fieldsQuery = "SELECT  * from fields where form_id=$form_id";
$fieldsRes = mysqli_query($con, $fieldsQuery);
$row = mysqli_fetch_assoc($fieldsRes);
$fieldsData = [];

while ($row = mysqli_fetch_assoc($fieldsRes)) {
    $fieldsData[] = $row;
}


$query = "SELECT  * from responses where form_id=$form_id";
$res = mysqli_query($con, $query);
$responsesData = [];

while ($row = mysqli_fetch_assoc($res)) {
    $responsesData[] = json_decode($row['response_values'], true);
}


$count = mysqli_num_rows($res);

?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table id="responsesTable" class="w-full text-sm text-left text-gray-500">
        <div class="flex items-center justify-between text-gray-900 bg-white p-5">
            <div class="text-lg font-semibold text-left ">
                <span>
                Responses
                </span>
                <span class="text-muted text-sm font-normal ml-2 border rounded-md p-2 px-4">Total
                    : <?php echo $count ?>
                </span>
            </div>
            <button id="exportBtn"
                class="w-max items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-[#11131e] text-white hover:bg-[#11131e]/90 h-10 px-4 py-2 w-full"
                type="submit">Export</button>
        </div>

        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border">
            <tr>
                <?php foreach ($fieldsData as $key => $value) {
                    ?>
                    <th scope="col" class="px-6 py-3">
                        <?php echo $value['label'] ?>
                    </th>
                    <?php
                } ?>
            </tr>
        </thead>
        <tbody>

            <?php
            foreach ($responsesData as $responseKey => $responseValue) {
                ?>
                <tr class="bg-white border-b">
                    <pre>
                    <?php foreach ($fieldsData as $key => $value) {
                        ?>
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                            <?php echo $responseValue[$value['id']] ?>
                        </td>
                        <?php
                    } ?>
                </tr>

                <?php
            }

            if ($count == 0) {
                ?>
                <tr class="bg-white border-b">
                    <td colspan="6" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap text-center">
                        No Responses Found
                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
</div>

<script>
document.getElementById('exportBtn').addEventListener('click', function () {
    // Get the table
    var table = document.getElementById('responsesTable');

    // Use SheetJS to export the table to Excel
    var wb = XLSX.utils.table_to_book(table, {sheet: "Responses"});

    // Write the Excel file and trigger the download
    XLSX.writeFile(wb, "exported_table.xlsx");
});
</script>
