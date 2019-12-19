<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\Promotion;

class Promotions extends \Core\Controller
{
    public function before()
    {
        if (empty($_SESSION['employee'])) {
            http_response_code(401);
            header('Location: /admin/login');
            return false;
        }
    }

    public function indexAction(){
        $promotions = Promotion::getAll();
        View::renderTemplate(
            'Promotions/index.html.twig',
            [ 'promotions' => $promotions ]
        );
    }

    public function indexCurrentAction(){
        $promotions = Promotion::getAllDate();
        View::renderTemplate(
            'Promotions/index.html.twig',
            [ 'promotions' => $promotions ]
        );
    }

    public function createAction(){
        $code = Promotion::generatePromoCode(10);
        //$code = "deuwidhe";
        $promoPlaces = -1;
        if(!isset($_POST['promo-unlimited'])){
            $promoPlaces = $_POST['promo-availability'];
        }
        Promotion::add($_POST["promo-date-start"],
            $_POST["promo-end-date"],
            $_POST['promo-type-id'],
            $code,
            $_POST["promo-value"],
            $_POST["promo-description"],
            $promoPlaces);
    }

    public function indexIdAction(){
        $promotions = Promotion::get($_POST["id"]);
        View::renderTemplate(
            'Promotions/describe.html.twig',
            ['promotions' => $promotions]
        );
    }

    public function indexIdModalAction(){
        $promotions = Promotion::get($_POST["id"]);
        $types = Promotion::getAllTypes();
        View::renderTemplate(
            'Promotions/update.html.twig',
            ['promotions' => $promotions, 'types' => $types]
        );
    }

    public function emptyModalAction(){
        $types = Promotion::getAllTypes();
        View::renderTemplate(
            'Promotions/promotions.html.twig',
            ['types' => $types]
        );
    }

    public function updateAction(){
        $promoPlaces = -1;
        if(!isset($_POST['promo-unlimited'])){
            $promoPlaces = $_POST['promo-availability'];
        }
        Promotion::update($_POST["promo-id"],
            $_POST["promo-date-start"],
            $_POST["promo-end-date"],
            $_POST["promo-type-id"],
            $_POST["promo-value"],
            $_POST["promo-description"],
            $promoPlaces);
    }

    public function getApplicationAction(){
        $promotions = Promotion::get($_POST["id"]);
        $circuits = Promotion::getPromotionsCircuit($_POST["id"]);
        $voyages = Promotion::getAllCircuitsTrips();
        View::renderTemplate(
            'Promotions/application.html.twig',
            ['promotions' => $promotions, 'circuits' => $circuits, 'voyages' => $voyages]
        );
    }

    public function updatePromotionCircuitsAction(){
        Promotion::removeAllPromotionsCircuits($_POST["promo-id"]);
        if (isset($_POST['circuit-unlimited'])){
            Promotion::addPromotionToAllCircuits(
                $_POST["promo-id"]);
        }
        else {
            foreach ($_POST["circuit-trip-id"] as $ctid) {
                Promotion::addPromotionToOneCircuitTrip(
                    $_POST["promo-id"],
                    $ctid);
            }
        }
   }

   public function deactivateAction(){
        Promotion::setExpired($_POST["id"]);
   }

}
