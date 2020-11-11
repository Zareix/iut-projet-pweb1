<?php


namespace App\Controller;

use App\Entity\Facture;
use ContainerXyG4jwO\getFactureRepositoryService;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Client;
use App\Entity\Vehicule;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;

class MenuUtilisateurController extends AbstractController {
    /**
     * @Route ("/menuUtilisateur/id={id}", name="menuUtilisateur", methods={"GET"})
     */
    public function Menu(int $id) {
        $repository = $this->getDoctrine()->getRepository(Client::class);
        $client = $repository->find($id);
        $mesVehicules = $client->getVehicules();

        $repository = $this->getDoctrine()->getRepository(Vehicule::class);
        $listeVehicules = $repository->findAll();

        $repository = $this->getDoctrine()->getRepository(Facture::class);
        $mesFactures = $repository->findBy([
            "idC" => $id
        ]);

        $vFactures =  [];
        if(sizeof($mesFactures) > 0){
            $vFactures = array_fill(0, $mesFactures[array_key_last($mesFactures)]->getId() + 1, new Vehicule());
            foreach ($mesFactures as $f){
                foreach($listeVehicules as $v){
                    if($f->getIdV() == $v->getId())
                        $vFactures[$f->getId()] = $v;
                }
            }
        }


        return $this->render("utilisateur/menuUtilisateur.twig", [
            'client' => $client,
            'mesFactures' => $mesFactures,
            'vFactures' => $vFactures,
            'mesVehicules' => $mesVehicules,
            'listeVehicules' => $listeVehicules
        ]);
    }

    /**
     * @Route ("/menuUtilisateur/id={idC}/action=Regler({idF})", name="aboRegler", methods={"GET"})
     */
    public function AboRegler(int $idC, int $idF) {
        $repository = $this->getDoctrine()->getRepository(Facture::class);
        $facture = $repository->find($idF);

        $facture->setEtat(1);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($facture);
        $entityManager->flush();

        return $this->redirect("/menuUtilisateur/id=" . $idC);
    }

    /**
     * @Route ("/menuUtilisateur/id={idC}/action=Supprimer({idV})", name="aboSupprimer", methods={"GET"})
     */
    public function AboSupprimer(int $idC, int $idV) {
        $repository = $this->getDoctrine()->getRepository(Client::class);
        $client = $repository->find($idC);

        $repository = $this->getDoctrine()->getRepository(Vehicule::class);
        $vehicule = $repository->find($idV);

        $repository = $this->getDoctrine()->getRepository(facture::class);
        $factures = $repository->findBy(
            ['idC' => $client->getId(),
            'idV' => $vehicule->getId()]
        );
        $facture = $factures[array_key_last($factures)];

        $client->removeVehicule($vehicule);

        $facture->setDateF(new \DateTime());

        $diff = abs($facture->getDateF()->getTimestamp() - $facture->getDateD()->getTimestamp());
        $years = floor($diff / (365*60*60*24));
        $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
        $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

        if($vehicule->getNb() >= 10)
            $facture->setValeur($days * $vehicule->getPrix() - 1/100);
        else
            $facture->setValeur($days * $vehicule->getPrix());

        $facture->setValeur($days * $vehicule->getPrix());

        $vehicule->setLocation("Disponible");

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($client);
        $entityManager->persist($vehicule);
        $entityManager->persist($facture);
        $entityManager->flush();

        return $this->redirect("/menuUtilisateur/id=" . $idC);
    }


    /**
     * @Route ("/menuUtilisateur/id={idC}/action=Ajouter({idV})", name="aboAjouter", methods={"GET"})
     */
    public function AboAjouter(int $idC, int $idV) {
        $repository = $this->getDoctrine()->getRepository(Client::class);
        $client = $repository->find($idC);

        $repository = $this->getDoctrine()->getRepository(Vehicule::class);
        $vehicule = $repository->find($idV);

        $client->addVehicule($vehicule);

        $facture = new Facture();
        $facture->setIdC($client->getId());
        $facture->setIdV($vehicule->getId());
        $facture->setDateD(new \DateTime());
        $facture->setEtat(false);

        $vehicule->setLocation("Loué");


        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($client);
        $entityManager->persist($vehicule);
        $entityManager->persist($facture);
        $entityManager->flush();

        return $this->redirect("/menuUtilisateur/id=" . $idC);
    }
}