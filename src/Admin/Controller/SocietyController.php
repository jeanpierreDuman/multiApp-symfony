<?php

namespace App\Admin\Controller;

use App\Admin\Entity\Society;
use App\Admin\Form\SocietyType;
use App\Core\Controller\MainController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
* @IsGranted("ROLE_ADMIN")
*/
class SocietyController extends MainController
{
    /**
     * @Route("/society", name="society")
     */
    public function index()
    {
        $societies = $this->getManager()->getRepository(Society::class)->findAll();

        return $this->render('@Admin/society/index.html.twig', [
            'societies' => $societies
        ]);
    }

    /**
     * @Route("/society/add", name="society_add")
     */
    public function add(Request $request)
    {
        $society = new Society();
        return $this->createOrUpdateSociety($society, $request, true);
    }

    /**
     * @Route("/society/{id}/update", name="society_update")
     */
    public function update(Society $society, Request $request)
    {
        return $this->createOrUpdateSociety($society, $request);
    }

    private function createOrUpdateSociety(Society $society, Request $request, $add = false)
    {
        $oldLogo = $society->getLogo();
        $form = $this->createForm(SocietyType::class, $society);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->getManager()->persist($society);
            $this->getManager()->flush();

            return $this->redirectToRoute('society');
        }

        return $this->render('@Admin/society/createOrUpdate.html.twig', [
            'form' => $form->createView(),
            'society' => $society
        ]);
    }
}
