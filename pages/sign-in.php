<?php

session_start();
$error = '';

// Check if the user is already logged in
if (isset($_SESSION['username'])) {
    header("Location:" . BASE_URL . "/index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $error = '';
    $username = $_POST['username'];
    $password = $_POST['password'];
    $sql = "select * from users where username='$username'";
    $res = mysqli_query($con, $sql);
    $num = mysqli_num_rows(result: $res);
    if ($num == 1) {
        while ($row = mysqli_fetch_assoc($res)) {
            if ($res) {
                if (password_verify($password, $row['password'])) {
                    session_start();
                    $_SESSION['loggedIn'] = true;
                    $_SESSION['username'] = $username;
                    $_SESSION['user_id'] = $row['id'];
                    header('Location: ' . BASE_URL . '/');
                } else {
                    $error = 'Invalid Username or Password';
                }
            }
        }
    } else {
        $error = 'Invalid Username or Password';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div class="flex items-center justify-center w-full h-screen">
        <div class="rounded-lg border bg-card text-card-foreground shadow-sm mx-auto max-w-sm">
            <div class="flex flex-col space-y-1.5 p-6">
                <h3 class="font-semibold tracking-tight text-2xl">Sign In</h3>
                <p class="text-sm text-muted-foreground">Enter your username below to login to your account</p>
                <p class="text-red-500 text-center"><?php echo $error ?></p>
            </div>
            <div class="p-6 pt-0">
                <form method="POST">
                    <div class="mb-3">
                        <label
                            class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
                            for="username">Username</label>
                        <input type="username"
                            class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                            id="username" name="username" placeholder="Enter Username" required>
                    </div>
                    <div class="mb-3">
                        <label
                            class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
                            for="password">Password</label>
                        <input type="password"
                            class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                            id="password" name="password" placeholder="Enter Password" required>
                    </div>
                    <button
                        class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-[#11131e] text-white hover:bg-[#11131e]/90 h-10 px-4 py-2 w-full"
                        type="submit">Sign In</button>
                </form>
                <div class="mt-4 text-center text-sm">Don't have an account?
                    <a class="underline" href="<?php echo BASE_URL ?>/auth/sign-up">
                        Sign up
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>