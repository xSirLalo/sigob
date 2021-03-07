<?php

declare(strict_types=1);

namespace Catastro\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Laminas\View\Model\JsonModel;
use Laminas\Paginator\Paginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;

class CatastroController extends AbstractActionController
{
    /**
     * Entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;
    /**
     * Contribuyente Model.
     * @var Catastro\Service\ContribuyenteManager
     */
    private $contribuyenteManager;

    public function __construct($entityManager, $contribuyenteManager)
    {
        $this->entityManager = $entityManager;
        $this->contribuyenteManager = $contribuyenteManager;
    }

    public function indexAction()
    {
    }

    public function addAction()
    {
    }

    public function viewAction()
    {
    }

    public function editAction()
    {
    }

    public function deleteAction()
    {
    }

    public function pdfAction()
    {
        $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('SIGOB');
        $pdf->SetTitle('Listado');
        $pdf->SetSubject('Listado');
        $pdf->SetKeywords('TCPDF, PDF');

        $PDF_HEADER_LOGO = "./public/logo.jpg";
        $PDF_HEADER_LOGO_WIDTH = 14;
        $PDF_HEADER_TITLE = "Sistemas de Gobierno.";
        $PDF_HEADER_STRING = "Lista de Contribuyentes \nGenerado con fecha: " . date('d-m-Y');

        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' del '.date('d-m-Y'), PDF_HEADER_STRING);

        // set header and footer fonts
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__) . '/lang/spa.php')) {
            require_once(dirname(__FILE__) . '/lang/spa.php');
            $pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------

        // Set font
        // dejavusans is a UTF-8 Unicode font, if you only need to
        // print standard ASCII chars, you can use core fonts like
        // helvetica or times to reduce file size.
        $pdf->SetFont('helvetica', 'B', 20);

        // Add a page
        // This method has several options, check the source code documentation for more information.
        $pdf->AddPage();

        $pdf->Write(20, 'Listado de Computadoras', '', 0, 'C', true, 0, false, false, 0);

        $pdf->SetFont('helvetica', '', 10);

        // -----------------------------------------------------------------------------

        $tbl = '<table  cellspacing="0" cellpadding="1" border="1" style="border-color:gray; width:100%;">';
        $tbl .= '<tr style="background-color:#47A7AC;color:black;">
                    <th>Nombre</th>
                    <th>Apellido Paterno</th>
                    <th>Apellido Materno</th>
                    <th>R.F.C.</th>
                    <th>C.U.R.P</th>
                </tr>';
        // foreach item in your array...
        // $computadorasInfo = $this->Computadora_model->getRows();
        $contribuyentes = $this->entityManager->getRepository(Contribuyente::class)->createQueryBuilder('c')->getQuery()->getResult();
        foreach ($contribuyentes as $contribuyente) :
        $tbl .=   '<tr>
                    <td>' . $contribuyente->getNombre() . '</td>
                    <td>' . $contribuyente->getApellidoPaterno() . '</td>
                    <td>' . $contribuyente->getApellidoMaterno() . '</td>
                    <td>' . $contribuyente->getRfc() . '</td>
                    <td>' . $contribuyente->getCurp() . '</td>
                </tr>';
        endforeach;
        $tbl = $tbl . '</table>';

        $pdf->writeHTML($tbl, true, 0, true, 0, 'C');

        // move pointer to last page
        $pdf->lastPage();

        // ---------------------------------------------------------

        // Close and output PDF document
        if (ob_get_contents()) {
            ob_end_clean();
        }

        // This method has several options, check the source code documentation for more information.
        $pdf->Output('listadoPdf_' . date('dmY') . '.pdf', 'D');
        //============================================================+
        // END OF FILE
        //============================================================+
    }

    public function excelAction()
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        //Set sheet meta data
        $spreadsheet->getProperties()
                    ->setCreator("Eduardo Cauich Herrera")
                    ->setLastModifiedBy("Contribuyentes")
                    ->setTitle("Lista Contribuyentes")
                    ->setSubject("Estos son datos de Contribuyente exportados desde SIGOB")
                    ->setDescription(
                        "Sistema de Gobierno"
                    )
                    ->setKeywords("datos")
                    ->setCategory("contribuyentes");
        // Set title
        $styleArray = [
            'font' => [
                'bold' => true,
                'size' => 18,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                'rotation' => 90,
                'startColor' => [
                    'rgb' => '47A7AC',
                ],
                'endColor' => [
                    'rgb' => 'FFFFFF',
                ],
            ],
        ];
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Contribuyentes')
            ->mergeCells("A1:F1")
            ->getStyle('A1:F1')->applyFromArray($styleArray);

        //Set tittle columns
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A2', 'ID')
            ->setCellValue('B2', 'Nombre')
            ->setCellValue('C2', 'Apellido Paterno')
            ->setCellValue('D2', 'Apellido Materno')
            ->setCellValue('E2', 'R.F.C.')
            ->setCellValue('F2', 'C.U.R.P')
            ->setTitle('Libro Contribuyente');
        //Get data
        $contribuyentes = $this->entityManager->getRepository(Contribuyente::class)->createQueryBuilder('c')->getQuery()->getResult();

        $rows = 3;
        $dataCount = 2;
        foreach ($contribuyentes as $contribuyente):
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $rows, $contribuyente->getIdContribuyente())
                ->setCellValue('B' . $rows, $contribuyente->getNombre())
                ->setCellValue('C' . $rows, $contribuyente->getApellidoPaterno())
                ->setCellValue('D' . $rows, $contribuyente->getApellidoMaterno())
                ->setCellValueExplicit('E' . $rows, $contribuyente->getRfc(), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('F' . $rows, $contribuyente->getCurp(), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $rows++;
        $dataCount++;

        $sheet = $spreadsheet->getActiveSheet();

        //Set column width to auto
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);

        //Set table outer borders
        $styleArray = [
                'font' => [
                    'bold' => false,
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                ],
                'borders' => [
                    'top' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                    'right' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                    'bottom' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                    'left' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ];
        //Get number of rows
        $sheet->getStyle('A2:F' . $dataCount . '')->applyFromArray($styleArray);
        endforeach;
        //Set header outer borders
        $styleArray = [
            'font' => [
                'bold' => true,
                'size' => 12,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            ],
            'borders' => [
                'top' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'right' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'bottom' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'left' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $sheet->getStyle('A2:F2')->applyFromArray($styleArray);

        // File name
        $filename = 'listadoExcel_' . date('dmY');

        // Redirect output to a client's web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        // Write and save
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');

        // Free Memory
        $spreadsheet->disconnectWorksheets();
        unset($spreadsheet);
        exit;
    }
}
