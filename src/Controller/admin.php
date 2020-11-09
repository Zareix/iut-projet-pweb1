<?php


namespace App\Controller;

use App\Entity\Vehicule;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class admin extends AbstractController {
    /**
     * @Route ("/admin", name="admin")
     */
    public function Admin() {
        $repository = $this->getDoctrine()->getRepository(Vehicule::class);
        $listeVehicules  = $repository->findAll();

        $type = isset($_POST['type']) ? ($_POST['type']) : '';
        $caract = isset($_POST['caract']) ? ($_POST['caract']) : '';
        $quantite = isset($_POST['quantite']) ? ($_POST['quantite']) : '';
        $photo = isset($_POST['photo']) ? ($_POST['photo']) : '';
        $prix = isset($_POST['prix']) ? ($_POST['prix']) : '';
        $msg = "";

        if (count($_POST) == 0) {
            return $this->render("utilisateur/admin.html.twig", [
                "listeVehicules" => $listeVehicules,
                "type" => $type,
                "caract" => $caract,
                "quantite" => $quantite,
                "photo" => $photo,
                "prix" => $prix,
                "msg" => $msg
            ]);
        } else {
            if ($this->verifAll($type, $caract, $quantite, $photo, $prix, $msg))
                return $this->render("utilisateur/admin.html.twig", [
                    "listeVehicules" => $listeVehicules,
                    "type" => $type,
                    "caract" => $caract,
                    "quantite" => $quantite,
                    "photo" => $photo,
                    "prix" => $prix,
                    "msg" => $msg
                ]);
            else {
                $this->nouvVoiture($type, $caract, $quantite, $photo, $prix);
                $listeVehicules  = $repository->findAll();
                return $this->render("utilisateur/admin.html.twig", [
                    "listeVehicules" => $listeVehicules,
                    "type" => "",
                    "caract" => "",
                    "quantite" => "",
                    "photo" => "",
                    "prix" => "",
                    "msg" => "Véhicule ajouté !"
                ]);
            }
        }
    }

    /**
     * @Route ("/admin/action=supprimer({idV})", name="adminSupprimer", methods={"GET"})
     */
    public function AdminSupprimer(int $idV) {
        $repository = $this->getDoctrine()->getRepository(Vehicule::class);
        $vehicule = $repository->find($idV);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($vehicule);
        $entityManager->flush();
        return $this->redirectToRoute("admin");
    }

    function champNul($string) {
        if ($string == '')
            return true;
        return false;
    }

    function nouvVoiture(string $type, string $caract, int $quantite, string $photo, int $prix) {
        $v = new Vehicule();
        $v->setType($type);
        $v->setCaract($caract);
        $v->setNb($quantite);
        $v->setPhoto($photo);
        $v->setPrix($prix);
        $v->setLocation("Disponible");

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($v);
        $entityManager->flush();
    }

    function verifAll(string $type, string $caract, string $quantite, string $photo, string $prix, string &$msg) {
        if ($this->champNul($type) || $this->champNul($caract) || $this->champNul($quantite) || $this->champNul($photo) || $this->champNul($prix)) {
            $msg = "Tout les champs ne sont pas complet.";
            return true;
        } else {
            return false;
        }
    }


}