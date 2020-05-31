<?php

namespace App\Core\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;
use App\Core\Controller\MainController;

/**
* @IsGranted("ROLE_USER")
*/
class HomeController extends MainController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('@Core/home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
