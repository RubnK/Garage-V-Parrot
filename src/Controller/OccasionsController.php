<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Occasions;

class OccasionsController extends AbstractController
{
    #[Route('/occasions', name: 'app_occasions')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $occasions = $entityManager->getRepository(Occasions::class)->findBy(array(),array('post_date' => 'DESC', 'id' => 'DESC'));;
        return $this->render('occasions/index.html.twig', [
            'occasions' => $occasions,
            'controller_name' => 'OccasionsController',
        ]);
    }
}
