<?php
session_start();
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $error = '';
    $pwd = $_POST['password'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $name = $_POST['name'];
    $password = password_hash($pwd, PASSWORD_BCRYPT);
    $sql = "select * from users where `username`='$username' OR `email`='$email'";
    $res = mysqli_query($con, $sql);
    if (mysqli_num_rows($res) > 0) {
        $error = 'Email or Username is already taken';
    } else {
        $sql2 = "insert into users (`username`,`email`,`name`,`password`) values ('$username','$email','$name','$password')";
        $res2 = mysqli_query($con, $sql2);
        if ($res2) {
            header('Location: ' . BASE_URL . '/auth/sign-in');
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Signup - Formify</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div class=" mt-4 p-4">
        <div class="rounded-lg border bg-card text-card-foreground shadow-sm mx-auto max-w-sm">
            <div class="flex flex-col space-y-1.5 p-6">
                <h3 class="font-semibold tracking-tight text-2xl">Sign Up</h3>
                <p class="text-sm text-muted-foreground">Enter your username below to login to your account</p>
                <p class="text-red-500 text-center"><?php echo $error ?></p>
            </div>
            <div class="p-6 pt-0">
                <form method="POST">
                    <div class="mb-3">
                        <label
                            class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
                            for="name">Name</label>
                        <input type="name"
                            class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                            id="name" name="name" placeholder="Enter Name" required>
                    </div>
                    <div class="mb-3">

                        <label
                            class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
                            for="email">Email</label>
                        <input type="email"
                            class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                            id="email" name="email" placeholder="Enter Email" required>
                    </div>
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
                        type="submit">Register</button>
                </form>
                <div class="mt-4 text-center text-sm">Already have an account?
                    <a class="underline" href="<?php echo BASE_URL ?>/auth/sign-in">
                        Sign in
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>


<!-- <script src="../js/script.js"></script> -->
<!-- <script>
    async function submitForm(event) {
        const formData = {};
        const form = document.getElementById('registerForm'); // Get the form by ID
        const inputs = form.elements;

        for (let i = 0; i < script inputs.length; i++) {
            const input = inputs[i];
            if (input.name) {
                formData[input.name] = input.value;
            }
        }
        event.innerHTML =
            `<span class="flex items-center gap-2"><span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Please Wait...</span>`;
        const registerFetch = await customFetch(formData, 'auth/register', 'POST');
        if (registerFetch.success) {
            window.location.href = window.location.origin + '/aayush/form-generator/auth/login.php';
        } else {
            event.innerHTML = `Register`;
        }
    }
</script> -->

</html>