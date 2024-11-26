<?php

$sql = "
SELECT 
    (SELECT COUNT(*) FROM forms) AS total_forms,
    (SELECT COUNT(*) FROM forms WHERE created_at >= CURDATE() - INTERVAL 7 DAY) AS forms_last_7_days,
    (SELECT COUNT(*) FROM forms WHERE created_at >= CURDATE() - INTERVAL 28 DAY) AS forms_last_28_days,
    (SELECT COUNT(*) FROM forms WHERE YEAR(created_at) = YEAR(CURDATE())) AS forms_this_year;
";

echo '<pre>';
$result = mysqli_query($con,$sql);
print_r(mysqli_fetch_assoc($result));

?>