<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Reviews;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ReviewsType;
use App\Entity\Horaires;
use App\Entity\Services;

class HomeController extends AbstractController{
    #[Route('/', name: 'app_home_number')]
    public function index(Request $request, EntityManagerInterface $entityManager) : Response{
        $reviewf = new Reviews();
        $reviewForm = $this->createForm(ReviewsType::class, $reviewf);
        $reviewForm->handleRequest($request);
        if ($reviewForm->isSubmitted() && $reviewForm->isValid()) {
            $entityManager->persist($reviewf);
            $entityManager->flush();

            return $this->redirectToRoute('app_home_number');
        }
        $reviews = $entityManager->getRepository(Reviews::class)->findAll();
        $horaires = $entityManager->getRepository(Horaires::class)->findAll();
        $services = $entityManager->getRepository(Services::class)->findAll();
        return $this->render('base.html.twig', [
            'reviewForm' => $reviewForm->createView(),
            'services' => $services,
            'reviews' => $reviews,
            'horaires' => $horaires
        ]);
    }
}
