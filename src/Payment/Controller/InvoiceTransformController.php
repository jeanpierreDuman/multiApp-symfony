<?php

namespace App\Payment\Controller;

use App\Core\Controller\MainController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Core\Service\DatatableService;
use App\Payment\Entity\Invoice;
use App\Payment\Form\InvoiceType;
use Dompdf\Dompdf;
use Dompdf\Options;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Core\Form\CustomerType;

class InvoiceTransformController extends MainController
{
    /**
     * @Route("invoice/transform/{id}/show", name="invoice_transform_show")
     */
    public function show(Request $request, Invoice $invoice)
    {
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($pdfOptions);

        $path = $this->getParameter('logos_directory') . '/' . 'max.jpg';
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

        $html = $this->renderView('@Payment/invoice_transform/show.html.twig', [
            'invoice' => $invoice,
            'baseImg' => $base64
        ]);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        $dompdf->stream("invoice_#" . $invoice->getNum() . ".pdf", [
            "Attachment" => false
        ]);
    }

    /**
     * @Route("/invoice/transform", name="invoice_transform")
     */
    public function index()
    {
        return $this->render('@Payment/invoice_transform/index.html.twig');
    }

    /**
     * @Route("/invoice/tranform/datatable", name="datatable_invoice_transform")
     */
    public function datatableInvoiceTransform(Request $request, DatatableService $datatableService)
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
            'isTransform' => true
        ]);

        $invoices = $datatableService->getParams('data');

        $array = [];

        foreach($invoices as $invoice) {

            $date = $invoice->getDate() !== null ? $invoice->getDate()->format('d/m/Y') : '';
            $link = $this->generateUrl('invoice_transform_show', ['id' => $invoice->getId()]);

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
}
