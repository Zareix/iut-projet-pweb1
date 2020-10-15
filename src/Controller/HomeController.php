<?php


namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route ("/accueil", name="accueil")
     */
    public function Accueil(){
        $name = "Shepard";
        return $this->render("accueil/accueil.html.twig", [
            "name" => $name
        ]);
    }
}