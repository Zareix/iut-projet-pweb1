<?php


namespace App\Controller;

use App\Entity\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class inscription extends AbstractController {
    /**
     * @Route ("/inscription", name="inscription")
     */
    public function Inscription() {
        $nom = isset($_POST['nom']) ? ($_POST['nom']) : '';
        $mdp = isset($_POST['mdp']) ? ($_POST['mdp']) : '';
        $email = isset($_POST['email']) ? ($_POST['email']) : '';

        if (count($_POST) == 0) {
            return $this->render('utilisateur/inscription.html.twig', [
                'msg' => '',
                'nom' => $nom,
                'mdp' => $mdp,
                'email' => $email
            ]);
        } else {
            if ($this->verifAll($mdp, $nom, $email, $msg))
                return $this->render('utilisateur/inscription.html.twig', [
                    'msg' => $msg,
                    'nom' => $nom,
                    'mdp' => $mdp,
                    'email' => $email
                ]);
            else {
                //session_start();
                $client = $this->nouvUser($nom, $mdp, $email);
                return $this->redirectToRoute("accueilAbo", ['id' => $client->getId()]);
                //return $this->redirectToRoute("accueiltest");
            }
        }
    }

    function verifAll($mdp, $nom, $email, &$msg) {
        if ($this->champNul($mdp) || $this->champNul($nom) || $this->champNul($email)) {
            $msg = "Tout les champs ne sont pas complet.";
            return true;
        } else if (strlen($nom) > 20) {
            $msg = "Le nom ne doit dépasser 20 caractères.";
            return true;
        } else if ($this->isNotAlphabetic($nom)) {
            $msg = "Le nom doit être uniquement des lettres.";
            return true;
        } else if ($this->verifmdp($mdp)) {
            $msg = "Le matricule doit contenir au moins un chiffre et faire plus 8 caractères.";
            return true;
        } else if ($this->verifIdent($nom, $mdp)) {
            $msg = "Utilisateur déjà inscrit.";
            return true;
        }
        return false;
    }

    function champNul($string) {
        if ($string == '')
            return true;
        return false;
    }

    function isNotAlphabetic($string) {
        if (!preg_match("/^[a-zA-Zëéè\s\-]+$/", $string))
            return true;
        return false;
    }

    function verifMdp($mdp) {
        if (!preg_match('~[0-9]~', $mdp) || strlen($mdp) < 8)
            return true;
        return false;
    }

    function nouvUser($nom, $mdp, $email) {
        $entityManager = $this->getDoctrine()->getManager();

        //Création entité client
        $client = new Client();
        $client->setNom($nom);
        $client->setMdp($mdp);
        $client->setEmail($email);

        //Prepare l'ajout
        $entityManager->persist($client);

        //Ajoute a la BD
        $entityManager->flush();

        return $client;
    }

    function verifIdent($nom, $mdp) {
        $repository = $this->getDoctrine()->getRepository(Client::class);

        $client = $repository->findOneBy([
            'nom' => $nom,
            'mdp' => $mdp
        ]);

        if ($client)
            return true;
        return false;
    }
}