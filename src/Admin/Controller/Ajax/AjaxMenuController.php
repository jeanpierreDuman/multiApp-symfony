<?php

namespace App\Admin\Controller\Ajax;

use App\Admin\Entity\Menu;
use App\Core\Controller\MainController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Core\Service\DatatableService;

/**
* @IsGranted("ROLE_USER")
*/
class AjaxMenuController extends MainController
{
    /**
     * @Route("/ajax/menu/check/route/exist", name="ajax_menu_check_route")
     */
     public function ajaxMenuCheckRouteExist(Request $request)
     {
         $route = $request->request->get('route');

         $menu = $this->getManager()->getRepository(Menu::class)->findOneByRoute($route);

         if($menu) {
             return new JsonResponse(['status' => 'nok']);
         }

         return new JsonResponse(['status' => 'ok']);
     }

     /**
      * @Route("/ajax/menu/datatable", name="ajax_menu_datatable")
      */
     public function datatableSalary(Request $request, DatatableService $datatableService)
     {
         $datatableService->initDatatable($request->request, [
             'id',
             'structure',
             'name',
             'route',
             'utilisation',
             'enable',
         ], Menu::class);

         $menus = $datatableService->getParams('data');

         $array = [];

         foreach($menus as $menu) {

             $enable = $menu->getEnable() === true ? 'Oui' : 'Non';
             $link = $this->generateUrl('menu_update', ['id' => $menu->getId()]);

             $array[] = [
                 'id' => $menu->getId(),
                 'structure' => $menu->getStructure(),
                 'name' => $menu->getName(),
                 'route' => $menu->getRoute(),
                 'utilisation' => $menu->getCountMenuSociety(),
                 'enable' => $enable,
                 'link_detail' => $link
             ];
         }

         $jsonData = $datatableService->getJsonData($array);

         return new JsonResponse($jsonData);
     }
}
