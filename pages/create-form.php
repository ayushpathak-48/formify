<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $error = '';
    $title = $_POST['title'];
    $description = $_POST['description'];
    $user_id = $_SESSION['user_id'];
    $sql = "insert into forms (`user_id`,`title`,`description`) values ('$user_id','$title','$description')";
    $res = mysqli_query($con, $sql);
    if ($res) {
        header("Location: " . BASE_URL . "/");
    }
}
?>
<div>
    <div class="text-2xl font-semibold mx-auto w-max">Create Form</div>
    <div class="max-w-[600px] w-full mt-4 mx-auto">
        <form method="POST" id="createForm" class="grid gap-4">
            <div class="grid gap-2">
                <label
                    class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
                    for="title">Enter Title</label>
                <input type="title"
                    class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                    id="title" name="title" placeholder="Enter Title" required>
            </div>
            <div class="grid gap-2">
                <div class="flex items-center">
                    <label
                        class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
                        for="description">Enter Description</label>
                </div>
                <textarea
                    class="flex w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                    id="description" name="description" id="description" rows="3"></textarea>
            </div>
            <button
                class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-[#11131e] text-white hover:bg-[#11131e]/90 h-10 px-4 py-2 w-full"
                type="submit">Create</button>
        </form>
    </div>
</div>