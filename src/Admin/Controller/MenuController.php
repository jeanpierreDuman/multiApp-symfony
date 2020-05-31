<?php

namespace App\Admin\Controller;

use App\Admin\Entity\Menu;
use App\Admin\Entity\MenuSociety;
use App\Admin\Entity\Society;
use App\Core\Controller\MainController;
use App\Admin\Form\MenuType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
* @IsGranted("ROLE_ADMIN")
*/
class MenuController extends MainController
{
    /**
     * @Route("/menu", name="menu")
     */
    public function index()
    {
        return $this->render('@Admin/menu/index.html.twig');
    }

    /**
     * @Route("/menu/{id}/update", name="menu_update")
     */
    public function update(Request $request, Menu $entity)
    {
        return $this->createOrUpdateMenu($entity, $request);
    }

    /**
     * @Route("/menu/add", name="menu_add")
     */
    public function add(Request $request)
    {
        $entity = new Menu();
        return $this->createOrUpdateMenu($entity, $request);
    }

    /**
     * @Route("/menu/{id}/delete", name="menu_delete")
     */
    public function delete(Request $request, Menu $entity)
    {
        $this->removeAndAddMenuSociety($entity, $request);
        $this->getManager()->remove($entity);
        $this->getManager()->flush();

        return $this->redirectToRoute('menu');
    }

    private function createOrUpdateMenu(Menu $entity, Request $request)
    {
        $form = $this->createForm(MenuType::class, $entity);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->removeAndAddMenuSociety($entity, $request);
            $this->getManager()->persist($entity);
            $this->getManager()->flush();

            return $this->redirectToRoute('menu');
        }

        return $this->render('@Admin/menu/createOrUpdate.html.twig', [
            'form' => $form->createView(),
            'menu' => $entity
        ]);
    }

    private function removeAndAddMenuSociety(Menu $menu, Request $request)
    {
        foreach($menu->getMenuSocieties() as $sm) {
            $this->getManager()->remove($sm);
        }

        $societies = isset($request->request->get('menu')['society']) === true ? $request->request->get('menu')['society'] : [];

        foreach($societies as $idSociety) {
            $society = $this->getManager()->getRepository(Society::class)->findOneById($idSociety);
            $ms = new MenuSociety();
            $ms->setMenu($menu);
            $ms->setSociety($society);

            $this->getManager()->persist($ms);
            $menu->addMenuSociety($ms);
        }
    }
}
