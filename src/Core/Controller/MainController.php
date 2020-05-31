<?php

namespace App\Core\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Admin\Entity\MenuSociety;

class MainController extends AbstractController
{
    public function getManager()
    {
        return $this->getDoctrine()->getManager();
    }

    public function checkAccessSociety($route)
    {
        if($this->getUser() === null) {
            return $this->redirectToRoute('app_login');
        }

        if($this->getUser()->getSociety() === null) {
            throw new \Exception("Vous n'avez pas de société");
        }

        $currentSociety = $this->getUser()->getSociety();

        $menuSociety = $this->getManager()->getRepository(MenuSociety::class)
            ->getMenuForSociety($currentSociety, $route);

        if($menuSociety === null) {
            throw new \Exception("La fonctionnalité a été désactivé par l'administrateur du site");
        }

        $enableSociety = $currentSociety->getEnable();

        if($menuSociety->getMenu()->getEnable() === false) {
            throw new \Exception("La fonctionnalité a été désactivé par l'administrateur du site");
        }

        if($menuSociety === null || $enableSociety === false) {
            throw new \Exception("Votre société n'a pas accès à cette page");
        }
    }
}
