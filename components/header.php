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
            <a href="<?php echo BASE_URL ?>/contact" class="font-medium">Contact</a>
        </div>
    </div>
    <div class="h-[calc(100%-70px)] fixed left-0 bottom-0 text-white p-3 w-[250px] bg-[#11131e]">
        <div class="flex flex-col gap-2">
            <a href="<?php echo BASE_URL ?>/all-forms" class="font-medium p-2 px-4 hover:bg-black/20 rounded">
                All Forms
            </a>
            <a href="<?php echo BASE_URL ?>/create-form" class="font-medium p-2 px-4 hover:bg-black/20 rounded">
                Create Forms
            </a>
            <a href="<?php echo BASE_URL ?>/form-responses" class="font-medium p-2 px-4 hover:bg-black/20 rounded">
                Responses
            </a>
        </div>
    </div>
    <div class="p-4 w-[calc(100%-250px)] relative ml-auto h-[calc(100%-70px)]">
        <div class="absolute overflow-y-auto inset-0 bg-gray-50  h-full w-full p-5">