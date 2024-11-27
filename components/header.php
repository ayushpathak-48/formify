<?php
session_start();

if (!$_SESSION['username'] || !$_SESSION['loggedIn']) {
    header("location:" . BASE_URL . "/auth/sign-in");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formify</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="h-screen">
    <div class="h-[70px] bg-[#11131e] w-full text-white flex items-center justify-between px-5">
        <a href="<?php echo BASE_URL ?>/" class="text-2xl font-medium">Formify</a>
        <div class="flex items-center justify-center gap-4">
            <a href="<?php echo BASE_URL ?>/" class="font-medium">Home</a>
            <a href="<?php echo BASE_URL ?>/about" class="font-medium">About</a>
            <a href="<?php echo BASE_URL ?>/profile" class="font-medium">Profile</a>
        </div>
    </div>
    <div class="p-4 w-full relative ml-auto h-[calc(100%-70px)]">
        <div class="absolute overflow-y-auto inset-0 bg-gray-50  h-full w-full p-5">