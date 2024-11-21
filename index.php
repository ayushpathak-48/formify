<?php
require './config.php';
$request = $_SERVER['REQUEST_URI'];
$request = str_replace(BASE_URL, '', $request);
$arr = explode('/', $request);

$routePath = $arr[1];
$id;
if (isset($arr[2])) {
    $id = $arr[2];
}

switch ($request) {
    case ($routePath == 'forms'):
        if (isset($id)) {
            $form_id = $id;
        }
        include('./pages/single-form.php');
        exit();
        break;

    case '/auth/sign-in':
        include('./pages/sign-in.php');
        exit();
        break;

    case '/auth/sign-up':
        include('./pages/sign-up.php');
        exit();
        break;
}

include('./components/header.php');

switch ($routePath) {
    case '/':
        include('./pages/home.php');
        break;

    case 'all-forms':
        include('./pages/all-forms.php');
        break;

    case 'create-form':
        include('./pages/create-form.php');
        break;

    case ('edit-form'):
        if (isset($id)) {
            $form_id = $id;
        }
        include('./pages/edit-form.php');
        break;
    case ('delete-form'):
        if (isset($id)) {
            $form_id = $id;
        }
        include('./pages/edit-form.php');
        break;
    case ('delete-field'):
        if (isset($id)) {
            $field_id = $id;
        }
        include('./pages/delete-field.php');
        break;

    case ('form-fields'):
        if (isset($id)) {
            $form_id = $id;
        }
        include('./pages/form-fields.php');
        break;

    case ('create-form-field'):
        if (isset($id)) {
            $form_id = $id;
        }
        include('./pages/create-form-field.php');
        break;

    case ('edit-form-field'):
        if (isset($id)) {
            $field_id = $id;
        }
        include('./pages/edit-form-field.php');
        break;

    case '/form-responses':
        include('./pages/responses.php');
        break;
}
include('./components/footer.php');