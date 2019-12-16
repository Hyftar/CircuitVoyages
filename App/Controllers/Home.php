<?php

namespace App\Controllers;

use \Core\View;

class Home extends \Core\Controller
{
    public function indexAction()
    {
        View::renderTemplate('Home/index.html.twig');
    }
    public function uploadAction()
    {
        if(isset($_FILES['image'])){
            $file_name = $_FILES['image']['name'];
            $file_size =$_FILES['image']['size'];
            $file_tmp =$_FILES['image']['tmp_name'];
            $file_type=$_FILES['image']['type'];
            $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));

            $extensions= array("jpeg","jpg","png","gif");

            if(in_array($file_ext,$extensions)=== false){
               $errors="extension not allowed, please choose a JPEG or PNG file.";
            }

            require dirname(__DIR__) . '/public/images/uploadedfile/';

            if(empty($errors)==true){
               move_uploaded_file($file_tmp,dirname(__DIR__).$file_name);
               echo "Success";
            }else{
               print_r($errors);
            }
         }
    }
}
