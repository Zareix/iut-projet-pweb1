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

class menuUtilisateur extends AbstractController {
    /**
     * @Route ("/menuUtilisateur/id={id}", name="menuUtilisateur", methods={"GET"})
     */
    public function Menu(int $id) {
        $repository = $this->getDoctrine()->getRepository(Client::class);
        $client = $repository->find($id);
        $mesVehicules = $client->getVehicules();

        $repository = $this->getDoctrine()->getRepository(Vehicule::class);
        $listeVehicules = $repository->findAll();

        return $this->render("utilisateur/menuUtilisateur.twig", [
            'client' => $client,
            'mesVehicules' => $mesVehicules,
            'listeVehicules' => $listeVehicules
        ]);
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
        $facture->setValeur(10);

        $vehicule->setLocation("Disponible");

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($client);
        $entityManager->persist($vehicule);
        $entityManager->persist($facture);
        $entityManager->flush();

        return $this->redirect("/menuUtilisateur/id=" . $client->getId());
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

        return $this->redirect("/menuUtilisateur/id=" . $client->getId());
    }
}