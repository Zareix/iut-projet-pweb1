<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class admin extends AbstractController
{
    /**
     * @Route ("/admin", name="admin")
     */
    public function Admin(){
        return $this->render("utilisateur/admin.html.twig");
    }
}