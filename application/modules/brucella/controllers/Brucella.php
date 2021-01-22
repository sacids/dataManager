<?php

/**
 * AfyaData
 *
 * An open source data collection and analysis tool.
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2017. Southern African Center for Infectious disease Surveillance (SACIDS)
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 *
 * @package        AfyaData
 * @author        AfyaData Dev Team
 * @copyright    Copyright (c) 2017. Southen African Center for Infectious disease Surveillance (SACIDS http://sacids.org)
 * @license        http://opensource.org/licenses/MIT	MIT License
 * @link        https://afyadata.sacids.org
 * @since        Version 1.0.0
 */

class Brucella extends MX_Controller
{
    private $data;
    private $spreadsheet;

    public function __construct()
    {
        parent::__construct();
        $this->spreadsheet = new PHPExcel();


        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
    }

    //lists
    public function lists()
    {
        $this->data['title'] = "Laboratory Results";

        //form
        $form = $this->Xform_model->find_by_id($form_id = 287);

        if (!$form)
            show_error('Form does not exist');

        $this->data['title'] = $form->title . " form";
        $this->data['form'] = $form;

        //data lists
        $this->model->set_table('ad_build_clinician_1283331234529180520');
        $this->data['data_lists'] = $this->model->order_by('submitted_at', 'DESC')->get_all();

        foreach ($this->data['data_lists'] as $k => $v) {
            //rose bengal results
            $this->model->set_table('ad_build_Rose_Bengal_Results_158980803030');
            $this->data['data_lists'][$k]->rose_bengal = $this->model->get_by('_xf_1081331606aa34175e574c53a764ebf0', $v->_xf_97ec8c6f99c8dfe34679782c060b528d);

            //sua results
            $this->model->set_table('ad_build_Sample_results_form_1589715082020');
            $this->data['data_lists'][$k]->sua_result = $this->model->get_by('_xf_271560175ee2e3a0fc421a63cb30724a', $v->_xf_97ec8c6f99c8dfe34679782c060b528d);
        }


        //render view
        $this->load->view("header", $this->data);
        $this->load->view("lists");
        $this->load->view("footer");
    }

    //export xls
    function export_xls($form_id)
    {
        //form
        $form = $this->Xform_model->find_by_id($form_id);

        if (!$form)
            show_error('Form does not exist');

        //variable html1
        $html1 = '';

        // Set some content to print
        $html1 .= "AFYADATA: LABORATORY RESULTS\r";

        // Set document properties
        $this->spreadsheet->getProperties()->setCreator("Renfrid Ngolongolo")
            ->setLastModifiedBy("Renfrid Ngolongolo")
            ->setTitle("SACIDS")
            ->setSubject("Afyadata")
            ->setDescription("Laboratory Results")
            ->setKeywords("Laboratory Results")
            ->setCategory("Laboratory Results");

        //activate worksheet number 1
        $this->spreadsheet->setActiveSheetIndex(0)->setCellValue('A1', $html1);
        $this->spreadsheet->setActiveSheetIndex(0)->mergeCells('A1:I1');
        $this->spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(20);

        $this->spreadsheet->getActiveSheet()->getStyle('A1')->applyFromArray(
            array('font' => array("bold" => true))
        );
        $this->spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setWrapText(true);

        // Add some data
        $this->spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A2', 'S/N')
            ->setCellValue('B2', 'PATIENT NAME')
            ->setCellValue('C2', 'AGE')
            ->setCellValue('D2', 'GENDER')
            ->setCellValue('E2', 'BARCODE')
            ->setCellValue('F2', 'HEALTH CENTER')
            ->setCellValue('G2', 'SUBMITTED ON')
            ->setCellValue('H2', 'ROSE BENGAL RESULTS')
            ->setCellValue('I2', 'SUA RESULTS');

        //        //set column dimensions
        //        $this->objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $this->spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $this->spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $this->spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $this->spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $this->spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $this->spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $this->spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $this->spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);

        // set headers
        $header = 'A2:i2';
        $header_style = array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '83C9FC')

            ),
            'font' => array(
                'bold' => false,
                'size' => '12',
                'color' => array('rgb' => '000000')
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );
        $this->spreadsheet->getActiveSheet()->getStyle($header)->applyFromArray($header_style);

        //data lists
        $this->model->set_table('ad_build_clinician_1283331234529180520');
        $data_lists = $this->model->order_by('submitted_at', 'DESC')->get_all();

        $serial = 1;
        $inc = 3;
        foreach ($data_lists as $val) {
            //rose bengal results
            $this->model->set_table('ad_build_Rose_Bengal_Results_158980803030');
            $rose_bengal = $this->model->get_by('_xf_1081331606aa34175e574c53a764ebf0', $val->_xf_97ec8c6f99c8dfe34679782c060b528d);

            //sua results
            $this->model->set_table('ad_build_Sample_results_form_1589715082020');
            $sua_result = $this->model->get_by('_xf_271560175ee2e3a0fc421a63cb30724a', $val->_xf_97ec8c6f99c8dfe34679782c060b528d);

            //data
            $this->spreadsheet->getActiveSheet()->setCellValue('A' . $inc, $serial);
            $this->spreadsheet->getActiveSheet()->setCellValue('B' . $inc, $val->_xf_650ad80ca14caa5f0e0dde5742811587);
            $this->spreadsheet->getActiveSheet()->setCellValue('C' . $inc, $val->_xf_ec0c9332aa8e8195404c7d072b8dc0e8);
            $this->spreadsheet->getActiveSheet()->setCellValue('D' . $inc, $val->_xf_27e177f79abab493a9294c8f22a2f9da);
            $this->spreadsheet->getActiveSheet()->setCellValue('E' . $inc, $val->_xf_97ec8c6f99c8dfe34679782c060b528d);
            $this->spreadsheet->getActiveSheet()->setCellValue('F' . $inc, $val->_xf_b27aa6e86824bbcecc38414cb75e06ef);
            $this->spreadsheet->getActiveSheet()->setCellValue('G' . $inc, date('d-m-Y', strtotime($val->submitted_at)));
            $this->spreadsheet->getActiveSheet()->setCellValue('H' . $inc, ($rose_bengal) ? strtoupper($rose_bengal->_xf_d9e56ce2bd10d1c7faa554d2b1826910) : "NO RESULTS");
            $this->spreadsheet->getActiveSheet()->setCellValue('I' . $inc, ($sua_result) ? strtoupper($sua_result->_xf_24c67cb06cc2cb8c50ad41b2c5d8be6f) : "");
            $inc++;
            $serial++;
        }

        // Rename worksheet
        $this->spreadsheet->getActiveSheet()->setTitle('LABOTORY RESULTS');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $this->spreadsheet->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="laboratory-results.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $objWriter = PHPExcel_IOFactory::createWriter($this->spreadsheet, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }
}
