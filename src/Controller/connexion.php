<?php


namespace App\Controller;


use App\Entity\Client;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class connexion extends AbstractController
{
    /**
     * @Route ("/connexion", name="connexion")
     */
    public function Connexion()
    {
        $nom = isset($_POST['nom']) ? ($_POST['nom']) : '';
        $mdp = isset($_POST['mdp']) ? ($_POST['mdp']) : '';
        $msgCo = "";


        if (count($_POST) == 0) {
            return $this->render('utilisateur/connexion.html.twig', [
                'msgCo' => '',
                'nom' => $nom,
                'mdp' => $mdp
            ]);
        } else {
            if ($nom == "" || $mdp == "") {
                $msgCo = "Tout les champs ne sont pas complet.";
                return $this->render('utilisateur/connexion.html.twig', [
                    'msgCo' => '',
                    'nom' => $nom,
                    'mdp' => $mdp
                ]);
            } else {
                $client = $this->verifIdent($nom, $mdp);
                if ($client) {
                    return $this->redirectToRoute('accueilAbo', ['id' => $client->getId()]);
                } else {
                    $msgCo = "Utilisateur inconnu";
                    return $this->render('utilisateur/connexion.html.twig', [
                        'msgCo' => '',
                        'nom' => $nom,
                        'mdp' => $mdp
                    ]);
                }
            }
        }

    }

    function verifIdent($nom, $mdp)
    {
        $repository = $this->getDoctrine()->getRepository(Client::class);

        $client = $repository->findOneBy([
            'nom' => $nom,
            'mdp' => $mdp
        ]);

        return $client;
    }
}