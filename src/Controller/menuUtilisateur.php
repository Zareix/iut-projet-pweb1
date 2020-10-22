<?php


namespace App\Controller;

use App\Entity\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class menuUtilisateur extends AbstractController {
    /**
     * @Route ("/menuUtilisateur/{id}", name="menuUtilisateur", methods={"GET"})
     */
    public function Menu(int $id) {
        $repository = $this->getDoctrine()->getRepository(Client::class);
        $client = $repository->find($id);

        if ($client->getNom() == "admin" && $client->getMdp() == "admin")
            return $this->redirectToRoute("admin");

        return $this->render("utilisateur/menuUtilisateur.twig", [
            'client' => $client
        ]);
    }
}