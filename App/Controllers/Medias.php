<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\Media;
use \App\Helpers\TranslationHelpers;

class Medias extends \Core\Controller
{
    public function before()
    {
        if (empty($_SESSION['employee'])) {
            http_response_code(401);
            header('Location: /admin/login');
            return false;
        }
    }

    public function indexAction()
    {
        $medias = Media::getAll();
        View::renderTemplate(
            '/Admin/media_index.html.twig',
            ['medias' => $medias]
        );
    }

    public function uploadAction()
    {
        $translator = TranslationHelpers::getInstance();

        $description = null;

        $errors = [];

        if (!empty($_POST['description'])) {
            $description = $_POST['description'];
        }

        if (empty($_FILES['media'])) {
            $errors[] = $translator->trans('Media.Please.Add.File');
        }

        if (empty($_POST['name'])) {
            $errors[] = $translator->trans('Media.Please.Add.Name');
        }

        $file_name = $_FILES['media']['name'];
        $file_size = $_FILES['media']['size'];
        $file_tmp = $_FILES['media']['tmp_name'];
        $file_type = $_FILES['media']['type'];
        $file_types = array("image/jpeg", "image/jpg", "image/png", "image/gif");

        $path = '/uploaded_files/' . $file_name;

        if (!in_array($file_type, $file_types)) {
            $errors = $translator->trans("Media.File.Forbidden");
        }

        if (!empty($errors)) {
            View::renderJSON(['errors' => $errors]);
            return;
        }

        $media_name = $_POST['name'];

        if (!Media::create($media_name, $file_type, $description, $path)) {
            http_response_code(500);
            return;
        }

        move_uploaded_file(
            $file_tmp,
            dirname(__DIR__) . '/../public/uploaded_files/' . $file_name
        );
    }
}
