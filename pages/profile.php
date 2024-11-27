<?php
$user_id = $_SESSION['user_id'];
$userQuery = "SELECT id,name,username,email from users where id='$user_id'";
$userRes = mysqli_query($con, $userQuery);
if (!$userRes) {
    header("location:" . BASE_URL . "/");
}
$user = mysqli_fetch_assoc($userRes);
echo '<pre>';
// print_r($user);
echo '</pre>';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $name = $_POST['name'];

    $userUpdateQuery = "UPDATE users set name='$name',username='$username' where id='$user_id'";
    $userUpdateRes = mysqli_query($con, $userUpdateQuery);
    if ($userUpdateRes) {
        header("location:" . BASE_URL . "/");
    }
}
?>

<div class=" mt-4 p-4">
    <div class="rounded-lg border bg-card text-card-foreground shadow-sm mx-auto max-w-sm">
        <div class="flex flex-col space-y-1.5 p-6">
            <h3 class="font-semibold tracking-tight text-2xl">Acccount Details</h3>
        </div>
        <div class="p-6 pt-0">
            <form method="POST">
                <div class="mb-3">

                    <label
                        class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
                        for="email">Email</label>
                    <input type="email"
                        class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                        id="email" name="email" placeholder="Enter Email" readonly disabled required
                        value="<?php echo $user['email'] ?>">
                </div>
                <div class="mb-3">
                    <label
                        class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
                        for="name">Name</label>
                    <input type="name"
                        class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                        id="name" name="name" placeholder="Enter Name" required value="<?php echo $user['name'] ?>">
                </div>
                <div class="mb-3">
                    <label
                        class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
                        for="username">Username</label>
                    <input type="username"
                        class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                        id="username" name="username" placeholder="Enter Username" required
                        value="<?php echo $user['username'] ?>">
                </div>
                <button
                    class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-[#11131e] text-white hover:bg-[#11131e]/90 h-10 px-4 py-2 w-full"
                    type="submit">Update Account</button>
            </form>
        </div>
    </div>
</div>