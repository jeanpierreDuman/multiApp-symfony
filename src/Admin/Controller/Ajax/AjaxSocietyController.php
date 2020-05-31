<?php

namespace App\Admin\Controller\Ajax;

use App\Admin\Entity\MenuSociety;
use App\Core\Controller\MainController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
* @IsGranted("ROLE_USER")
*/
class AjaxSocietyController extends MainController
{
    /**
     * @Route("/ajax/menu/{id}/ajax/societies", name="ajax_society_menu")
     */
     public function ajaxGetSocietyForMenu(Request $request)
     {
         $id = $request->request->get('menuId');

         $ms = $this->getManager()->getRepository(MenuSociety::class)->findBy([
             'menu' => $id
         ]);

         $idMs = [];

         foreach ($ms as $s) {
             array_push($idMs, $s->getSociety()->getId());
         }

         $idMs = implode(',', $idMs);

         return new JsonResponse($idMs);
     }
}
