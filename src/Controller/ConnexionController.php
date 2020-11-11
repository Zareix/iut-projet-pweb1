<?php


namespace App\Controller;

use App\Entity\Client;
use http\Client\Curl\User;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ConnexionController extends AbstractController {
    /**
     * @Route ("/connexion", name="connexion")
     */
    public function Connexion() {
        $email = isset($_POST['email']) ? ($_POST['email']) : '';
        $mdp = isset($_POST['mdp']) ? ($_POST['mdp']) : '';
        $msg = "";

        if (count($_POST) == 0) {
            return $this->render('utilisateur/connexion.html.twig', [
                'msg' => $msg,
                'email' => $email,
                'mdp' => $mdp
            ]);
        } else {
            if ($email == "" || $mdp == "") {
                $msg = "Tout les champs ne sont pas complet.";
                return $this->render('utilisateur/connexion.html.twig', [
                    'msg' => $msg,
                    'email' => $email,
                    'mdp' => $mdp
                ]);
            } else {
                $client = $this->verifIdent($email, $mdp);
                if ($client) {
                    if($client->getEmail() == "admin")
                        return $this->redirectToRoute('admin');
                    return $this->redirectToRoute('accueilAbo', ['id' => $client->getId()]);
                } else {
                    $msg = "Utilisateur inconnu";
                    return $this->render('utilisateur/connexion.html.twig', [
                        'msg' => $msg,
                        'email' => $email,
                        'mdp' => $mdp
                    ]);
                }
            }
        }

    }

    function verifIdent($email, $mdp) {
        $repository = $this->getDoctrine()->getRepository(Client::class);

        $client = $repository->findOneBy([
            'email' => $email,
        ]);

        if(password_verify($mdp, $client->getMdp()))
            return $client;

        return null;
    }
}