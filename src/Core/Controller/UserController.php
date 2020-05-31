<?php

namespace App\Core\Controller;

use App\Core\Entity\User;
use App\Core\Form\RegistrationFormType;
use App\Core\Controller\MainController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
* @IsGranted("ROLE_ADMIN")
*/
class UserController extends MainController
{
    /**
     * @Route("/user", name="user")
     */
    public function index()
    {
        $users = $this->getManager()->getRepository(User::class)->findAll();

        return $this->render('@Core/user/index.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @Route("/user/{id}/show", name="user_show")
     */
    public function show(User $user)
    {
        $form = $this->createForm(RegistrationFormType::class, $user);

        return $this->render('@Core/user/show.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }

    /**
     * @Route("/user/{id}/delete", name="user_delete")
     */
    public function delete(Request $request, User $user)
    {
        $this->getManager()->remove($user);
        $this->getManager()->flush();

        return $this->redirectToRoute('user');
    }

    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $this->getManager()->persist($user);
            $this->getManager()->flush();

            return $this->redirectToRoute('user');
        }

        return $this->render('@Core/user/register.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
