<?php

namespace App\Payment\Controller;

use App\Core\Controller\MainController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Core\Service\DatatableService;
use App\Payment\Entity\Invoice;
use App\Payment\Form\InvoiceType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Core\Form\CustomerType;

/**
* @IsGranted("ROLE_USER")
*/
class InvoiceController extends MainController
{
    const LOCAL_ROUTE = 'invoice';

    /**
     * @Route("/invoice", name="invoice")
     */
    public function index()
    {
        return $this->render('@Payment/invoice/index.html.twig');
    }

    /**
     * @Route("/invoice/create", name="invoice_create")
     */
    public function createInvoice(Request $request)
    {
        $invoice = new Invoice();
        return $this->createOrUpdateInvoice($request, $invoice, true);
    }

    /**
     * @Route("invoice/{id}/update", name="invoice_update")
     */
    public function update(Request $request, Invoice $invoice)
    {
        return $this->createOrUpdateInvoice($request, $invoice);
    }

    /**
     * @Route("invoice/{id}/detail", name="invoice_detail")
     */
    public function detail(Request $request, Invoice $invoice)
    {
        return $this->createOrUpdateInvoice($request, $invoice);
    }

    /**
     * @Route("/invoice/datatable", name="datatable_invoice")
     */
    public function datatableInvoice(Request $request, DatatableService $datatableService)
    {
        $datatableService->initDatatable($request->request, [
            'num',
            'customer',
            'date',
            'amountHT',
            'tva',
            'amountTTC'
        ], Invoice::class, [
            'user' => $this->getUser(),
            'isTransform' => false
        ]);

        $invoices = $datatableService->getParams('data');

        $array = [];

        foreach($invoices as $invoice) {

            $date = $invoice->getDate() !== null ? $invoice->getDate()->format('d/m/Y') : '';
            $link = $this->generateUrl('invoice_update', ['id' => $invoice->getId()]);

            $array[] = [
                'num' => $invoice->getNum(),
                'customer' => $invoice->getCustomer()->getName(),
                'date' => $date,
                'amountHt' => $invoice->getAmountHt() . ' €',
                'tva' => $invoice->getTva() . ' %',
                'amountTtc' => $invoice->getAmountTtc() . ' €',
                'link' => $link
            ];
        }

        $jsonData = $datatableService->getJsonData($array);

        return new JsonResponse($jsonData);
    }

    private function createOrUpdateInvoice($request, Invoice $invoice, $update = false)
    {
        $form = $this->createForm(InvoiceType::class, $invoice, [
            'userId' => $this->getUser()->getId()
        ]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();

            if($update) {
                $lastInvoice = $em->getRepository(Invoice::class)->findOneBy(
                    ['user' => $this->getUser()],
                    ['id' => 'DESC']
                );

                if($lastInvoice === null) {
                    $lastNumFacture = 1;
                } else {
                    $lastNumFacture = $lastInvoice->getNum() + 1;
                }

                $invoice->setNum($lastNumFacture);
            }

            $invoice->setUser($this->getUser());

            $em->persist($invoice);
            $em->flush();

            return $this->redirectToRoute('invoice');
        }

        return $this->render('@Payment/invoice/createOrUpdate.html.twig', [
            'form' => $form->createView(),
            'invoice' => $invoice
        ]);
    }
}
