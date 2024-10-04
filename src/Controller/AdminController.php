<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\OccasionsAdminType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Occasions;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use App\Entity\Reviews;
use App\Form\HorairesType;
use App\Entity\Horaires;
use App\Form\ServicesType;
use App\Entity\Services;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
       
        // Formulaire pour gérer les horaires d'ouverture
        $horaires = new Horaires();
        $horairesForm = $this->createForm(HorairesType::class, $horaires);
        $horairesForm->handleRequest($request);

        if ($horairesForm->isSubmitted() && $horairesForm->isValid()) {
            $existingHoraires = $entityManager->getRepository(Horaires::class)->findOneBy(['jour' => $horaires->getJour()]);

            if ($existingHoraires) {
            $existingHoraires->setOuverture($horaires->getOuverture());
            $existingHoraires->setFermeture($horaires->getFermeture());
            $existingHoraires->setClosed($horaires->getClosed());
            } else {
            $entityManager->persist($horaires);
            }

            $entityManager->flush();
            return $this->redirectToRoute('app_admin');
        }
        
        $reviews = $entityManager->getRepository(Reviews::class)->findAll();

        if ($request->isMethod('POST') && $request->request->has('review_id') && $request->request->has('action')) {
            $reviewId = $request->request->get('review_id');
            $action = $request->request->get('action');
            $review = $entityManager->getRepository(Reviews::class)->find($reviewId);

            if ($review) {
            if ($action === 'approve') {
                $review->setApproved(1);
            } elseif ($action === 'delete') {
                $entityManager->remove($review);
            }
            $entityManager->flush();
            }

            return $this->redirectToRoute('app_admin');
        }

        // Formulaire pour ajouter une voiture
        $car = new Occasions();
        $carForm = $this->createForm(OccasionsAdminType::class, $car);
        $carForm->handleRequest($request);

        if ($carForm->isSubmitted() && $carForm->isValid()) {
            /** @var UploadedFile $file */
            $file = $carForm->get('photo')->getData();

            if ($file) {
                // Générer un nom de fichier unique
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

                // Déplacer le fichier vers le répertoire configuré
                try {
                    $file->move(
                        $this->getParameter('uploads_directory'), // Doit pointer vers le répertoire public/assets/images/occasions
                        $newFilename
                    );
                    // Enregistrement du nom du fichier dans l'entité
                    $car->setPhoto($newFilename); // Utiliser setPhoto pour enregistrer le nom dans la colonne 'photo'
                } catch (FileException $e) {
                    // Gérer l'erreur en cas de problème avec l'upload
                    return $this->redirectToRoute('app_admin', ['error' => 'Erreur lors de l\'upload du fichier.']);
                }
            }

            // Persisting the car entity
            $entityManager->persist($car);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin');
        }

        // Affichage des entités déjà existantes
        $cars = $entityManager->getRepository(Occasions::class)->findAll();


        // Formulaire pour ajouter une voiture
        $services = new Services();
        $servicesForm = $this->createForm(ServicesType::class, $services);
        $servicesForm->handleRequest($request);

        if ($servicesForm->isSubmitted() && $servicesForm->isValid()) {
            /** @var UploadedFile $file */
            $file = $servicesForm->get('photo')->getData();

            if ($file) {
                // Générer un nom de fichier unique
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

                // Déplacer le fichier vers le répertoire configuré
                try {
                    $file->move(
                        $this->getParameter('services_uploads_directory'), // Doit pointer vers le répertoire public/assets/images/occasions
                        $newFilename
                    );
                    // Enregistrement du nom du fichier dans l'entité
                    $services->setPhoto($newFilename); // Utiliser setPhoto pour enregistrer le nom dans la colonne 'photo'
                } catch (FileException $e) {
                    // Gérer l'erreur en cas de problème avec l'upload
                    return $this->redirectToRoute('app_admin', ['error' => 'Erreur lors de l\'upload du fichier.']);
                }
            }

            // Persisting the car entity
            $entityManager->persist($services);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin');
        }

        // Affichage des entités déjà existantes
        $services = $entityManager->getRepository(Services::class)->findAll();


        return $this->render('admin/index.html.twig', [
            'cars' => $cars,
            'carForm' => $carForm->createView(),
            'horairesForm' => $horairesForm->createView(),
            'reviews' => $reviews,
            'services' => $services,
            'servicesForm' => $servicesForm->createView(),
        ]);
    }

    public function deleteCar(int $id, EntityManagerInterface $entityManager): Response
    {
        $car = $entityManager->getRepository(Occasions::class)->find($id);

        if ($car) {
            // Optionnel : Si tu veux supprimer aussi le fichier image
            $imagePath = $this->getParameter('uploads_directory') . '/' . $car->getPhoto();
            if (file_exists($imagePath)) {
                unlink($imagePath); // Supprimer le fichier de l'upload
            }

            $entityManager->remove($car);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin');
    }
}
