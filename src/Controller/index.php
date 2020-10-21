<?php


namespace App\Controller;
use App\Entity\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class index extends AbstractController
{
    /**
     * @Route ("/", name="index")
     */
    public function Index(){
        return $this->redirectToRoute("accueil");
    }

    /**
     * @Route ("/accueil", name="accueil")
     */
    public function Accueil(){
        return $this->render("accueil/accueil.html.twig");
    }

    /**
     * @Route ("/accueil/{id}", name="accueilAbo", methods = {"GET"})
     */
    public function AccueilAbo(int $id){
        $repository = $this->getDoctrine()->getRepository(Client::class);
        $client = $repository->find($id);

        return $this->render("accueil/accueil.html.twig", [
            'client' => $client
        ]);
    }

}