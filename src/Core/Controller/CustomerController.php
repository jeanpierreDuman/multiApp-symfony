<?php

namespace App\Core\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Core\Service\DatatableService;
use App\Core\Entity\Customer;
use App\Core\Form\CustomerType;

class CustomerController extends AbstractController
{
    /**
     * @Route("/customer", name="customer")
     */
    public function index()
    {
        return $this->render('@Core/customer/index.html.twig', [
            'controller_name' => 'CustomerController',
        ]);
    }

    /**
     * @Route("/customer/create", name="customer_create")
     */
    public function createCustomer(Request $request)
    {
        $customer = new Customer();
        $form = $this->createForm(CustomerType::class, $customer);
        $form->handleRequest($request);

        if($form->isSubmitted() and $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $customer->setUser($this->getUser());
            $em->persist($customer);
            $em->flush();

            return $this->redirectToRoute('customer');
        }

        return $this->render('@Core/customer/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/customer/datatable", name="datatable_customer")
     */
    public function datatableCustomer(Request $request, DatatableService $datatableService)
    {
        $datatableService->initDatatable($request->request, [
            'name',
            'street',
            'zipCode',
            'city',
        ], Customer::class, [
            'user' => $this->getUser()
        ]);

        $customers = $datatableService->getParams('data');

        $array = [];

        foreach($customers as $customer) {

            $array[] = [
                'name' => $customer->getName(),
                'street' => $customer->getStreet(),
                'zipCode' => $customer->getZipCode(),
                'city' => $customer->getCity()
            ];
        }

        $jsonData = $datatableService->getJsonData($array);

        return new JsonResponse($jsonData);
    }
}
