<?php

/**
 * Created by PhpStorm.
 * User: Renfrid-Sacids
 * Date: 3/20/2017
 * Time: 11:31 AM
 */
class Ussd extends CI_Controller
{
    const MOBILE_SERVICE_ID = 93;
    private $sms_sender_id;
    private $data;

    private $objPHPExcel;

    function __construct()
    {
        parent::__construct();
        $this->sms_sender_id = '15200';
        $this->load->model("Ussd_model");

        $this->objPHPExcel = new PHPExcel();
    }

    //verify password
    function verify_password()
    {
        //receive as json
        $post_data = file_get_contents("php://input");

        $value = json_decode($post_data, TRUE);

        log_message("debug", 'password  ' . $value['data']);

        //verify here
        $this->model->set_table('vhw_users');
        $user = $this->model->get_by(array('password' => $value['data']));

        if (count($user) == 1) {
            $response = array(
                'success' => TRUE,
                'password' => $value['data']
            );
        } else {
            $response = array(
                'success' => FALSE,
                'password' => $value['data']
            );
        }
        echo json_encode($response);
    }

    //verify password
    function verify_age()
    {
        //receive as json
        $post_data = file_get_contents("php://input");

        $value = json_decode($post_data, TRUE);

        log_message("debug", 'age  ' . $value['data']);

        if ($value['data'] >= 0 && $value['data'] <= 120) {
            $response = array(
                'success' => TRUE,
                'age' => $value['data']
            );
        } else {
            $response = array(
                'success' => FALSE,
                'age' => $value['data']
            );
        }
        echo json_encode($response);
    }

    //verify password
    function verify_severity()
    {
        //receive as json
        $post_data = file_get_contents("php://input");

        $value = json_decode($post_data, TRUE);

        log_message("debug", 'severity  ' . $value['data']);

        if ($value['data'] >= 1 && $value['data'] <= 7) {
            $response = array(
                'success' => TRUE,
                'severity' => $value['data']
            );
        } else {
            $response = array(
                'success' => FALSE,
                'severity' => $value['data']
            );
        }
        echo json_encode($response);
    }

    //fao data
    function fao_data()
    {
        //receive as json
        $post_data = file_get_contents("php://input");
        log_message("debug", 'fao_data  ' . $post_data);

        $value = json_decode($post_data, TRUE);

        //post data to server
        $data = array(
            'district' => $value['fao_wilaya'],
            'ward_ng' => $value['fao_kata_ng'],
            'ward_kls' => $value['fao_kata_kls'],
            'ward_wt' => $value['fao_kata_wt'],
            'animal' => $value['fao_mnyama'],
            'age' => $value['fao_umri'],
            'problem' => $this->clean($value['fao_tatizo']),
            'created_at' => date('Y-m-d H:i:s')
        );

        //insert a data bunch
        $this->model->set_table('ad_build_fao_data');
        $result = $this->model->insert($data);

        if ($result) {
            //response
            $response = array(
                'status' => TRUE,
                'sms_reply' => FALSE,
                'sms_text' => 'Taarifa zako zimetufikia'
            );
        } else {
            $response = array('success' => FALSE);
        }
        echo json_encode($response);
    }

    function clean($string)
    {
        $string = str_replace(' ', '', $string); // Replaces all spaces with hyphens.

        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }




    //receive data
    function receive_data()
    {
        //receive as json
        $post_data = file_get_contents("php://input");
        log_message("debug", 'received_data  ' . $post_data);

        $value = json_decode($post_data, TRUE);

        //post data to server
        $data = array(
            'password' => $value['password'],
            'caseId' => $value['caseId'],
            'gender' => $value['patient_gender'],
            'age' => $value['patient_age'],
            'condition' => $value['patient_cond'],
            'severity' => $value['patient_sev'],
            'mobile' => $value['msisdn']
        );

        //insert a data bunch
        $this->model->set_table('vhw_cases');
        $result = $this->model->insert($data);

        if ($result) {
            //response
            $response = array(
                'status' => TRUE,
                'sms_reply' => FALSE,
                'sms_text' => 'Taarifa zako zimetufikia'
            );
        } else {
            $response = array('success' => FALSE);
        }
        echo json_encode($response);
    }

    //export data
    function export_tiba_data()
    {
        //flag
        $flag = $_GET['flag'];

        //title
        $this->data['title'] = "Export XLS SMS Study data";
        $today = date('Y-m-d');

        //query
        $this->model->set_table('vhw_cases');
        $data_list = $this->model->get_many_by(['flag' => $flag]);

        //variable html1
        $html1 = '';

        // Set some content to print
        $html1 .= "NATIONAL INSTITUTE OF MEDICAL RESEARCH (NIMR)\r";
        $html1 .= "TIBA PROJECT DATA\r";
        $html1 .= "DATE: " . date('jS F, Y', strtotime($today)) . " \r";

        // Set document properties
        $this->objPHPExcel->getProperties()->setCreator("Renfrid Ngolongolo")
            ->setLastModifiedBy("Renfrid Ngolongolo")
            ->setTitle("National Institute of Medical Research(NIMR)")
            ->setSubject("Export study data")
            ->setDescription("Export study data")
            ->setKeywords("Export study data")
            ->setCategory("Export study data");

        //activate worksheet number 1
        $this->objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $html1);
        $this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:H1');
        $this->objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(70);

        $this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray(
            array('font' => array("bold" => true))
        );
        $this->objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setWrapText(true);

        // Add some data
        $this->objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A2', 'S/n')
            ->setCellValue('B2', 'Neno siri')
            ->setCellValue('C2', 'Namba ya Utambulisho')
            ->setCellValue('D2', 'Umri')
            ->setCellValue('E2', 'Jinsia')
            ->setCellValue('F2', 'Hali ya Mgonjwa')
            ->setCellValue('G2', 'Ukubwa wa Tatizo')
            ->setCellValue('H2', 'Namba ya mtumaji')
            ->setCellValue('I2', 'Muda wa kutuma');

        //set column dimensions
        //$this->objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $this->objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $this->objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $this->objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $this->objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $this->objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $this->objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $this->objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $this->objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);

        // set headers
        $header = 'A2:H2';
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
        $this->objPHPExcel->getActiveSheet()->getStyle($header)->applyFromArray($header_style);

        $serial = 1;
        $inc = 3;
        foreach ($data_list as $value) {
            //gender
            $gender = '';
            if ($value->gender == 1) $gender = "Mwanaume";
            else if ($value->gender == 2) $gender = "Mwanamke";

            //patient condition
            $cond = '';
            if ($value->condition == 1) $cond = "Tende";
            else if ($value->condition == 2) $cond = "Busha";
            else if ($value->condition == 3) $cond = "Tende na Busha";

            //ukubwa wa tatizo
            $severity = '';
            if ($value->severity == 1) $severity = "Dogo";
            else if ($value->severity == 2) $severity = "La kati";
            else if ($value->severity == 3) $severity = "Kubwa";

            //print data
            $this->objPHPExcel->getActiveSheet()->setCellValue('A' . $inc, $serial);
            $this->objPHPExcel->getActiveSheet()->setCellValue('B' . $inc, $value->password);
            $this->objPHPExcel->getActiveSheet()->setCellValue('C' . $inc, $value->caseId);
            $this->objPHPExcel->getActiveSheet()->setCellValue('D' . $inc, $value->age);
            $this->objPHPExcel->getActiveSheet()->setCellValue('E' . $inc, $gender);
            $this->objPHPExcel->getActiveSheet()->setCellValue('F' . $inc, $cond);
            $this->objPHPExcel->getActiveSheet()->setCellValue('G' . $inc, $severity);
            $this->objPHPExcel->getActiveSheet()->setCellValue('H' . $inc, $value->mobile);
            $this->objPHPExcel->getActiveSheet()->setCellValue('I' . $inc, date('d-m-Y H:i:s', strtotime($value->created_at)));

            $inc++;
            $serial++;
        }

        // Rename worksheet
        $this->objPHPExcel->getActiveSheet()->setTitle('TIBA REPORT');
        $filename = "Exported_tiba_data_" . date("Y-m-d") . ".xlsx";

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $this->objPHPExcel->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }

    //export fao data
    function export_fao_data()
    {
        $this->data['title'] = "Export XLS FAO data";
        $today = date('Y-m-d');

        $this->model->set_table('ad_build_fao_data');
        //$data_list = $this->model->get_many_by(array('DATE(created_at)' => $today)); //todo: query data in current data
        $data_list = $this->model->get_all();

        //variable html1
        $html1 = '';

        // Set some content to print
        $html1 .= "AFYADATA - FAO REPORT DATA";

        // Set document properties
        $this->objPHPExcel->getProperties()->setCreator("Renfrid Ngolongolo")
            ->setLastModifiedBy("Renfrid Ngolongolo")
            ->setTitle("SACIDS")
            ->setSubject("Export study data")
            ->setDescription("Export FAO data")
            ->setKeywords("Export FAO data")
            ->setCategory("Export FAO data");

        //activate worksheet number 1
        $this->objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $html1);
        $this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:G1');
        //$this->objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(70);

        $this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray(
            array('font' => array("bold" => true))
        );
        $this->objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setWrapText(true);

        // Add some data
        $this->objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A2', 'S/n')
            ->setCellValue('B2', 'Wilaya')
            ->setCellValue('C2', 'Kata')
            ->setCellValue('D2', 'Aina ya Mnyama')
            ->setCellValue('E2', 'Umri')
            ->setCellValue('F2', 'Tatizo')
            ->setCellValue('G2', 'Muda wa kutuma');

        //set column dimensions
        //$this->objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $this->objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $this->objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $this->objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $this->objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $this->objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $this->objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);

        // set headers
        $header = 'A2:g2';
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
        $this->objPHPExcel->getActiveSheet()->getStyle($header)->applyFromArray($header_style);

        $serial = 1;
        $inc = 3;
        foreach ($data_list as $value) {
            $ward_ng_array = ['1' => 'Kasulo', '2' => 'Kabanga'];
            $ward_kls_array = ['1' => 'Madoto', '2' => 'Parakuyo'];
            $ward_wt_array = ['1' => 'Kisiwani', '2' => 'Kinyasini'];

            //district
            $district = '';
            $ward = '';
            if ($value->district == 1) {
                $district = "Ngara";
                $ward = $ward_ng_array[$value->ward_ng];
            } else if ($value->district == 2) {
                $district = "Kilosa";
                $ward = $ward_kls_array[$value->ward_kls];
            } else if ($value->district == 3) {
                $district = "Wete";
                $ward = $ward_wt_array[$value->ward_wt];
            }

            //animal
            $animal_array = ['1' => 'Ng\'ombe', '2' => 'Mbuzi', '3' => 'Kondoo', '4' => 'Nguruwe', '5' => 'Kuku', '6' => 'Mbwa'];
            $animal = $animal_array[$value->animal];

            //age
            $age_array = ['1' => 'Chini ya Mwaka', '2' => 'Mwaka na zaidi'];
            $age = $age_array[$value->age];

            //problems
            $problems = str_split($value->problem);

            $problems_array = [
                '1' => 'Kuharisha', '2' => 'Kukohoa', '3' => 'Kutoka Damu', '4' => 'Kutupa mimba',
                '5' => 'Kuhema kwa shida', '6' => 'Kutetemeka', '7' => 'Vidonda miguu na midomo', '8' => 'Kutokula', '9' => 'Amekufa'
            ];

            $push = [];
            foreach ($problems as $v) {
                array_push($push, $problems_array[$v]);
            }

            $problems_data = implode(",", $push);

            //print data
            $this->objPHPExcel->getActiveSheet()->setCellValue('A' . $inc, $serial);
            $this->objPHPExcel->getActiveSheet()->setCellValue('B' . $inc, $district);
            $this->objPHPExcel->getActiveSheet()->setCellValue('C' . $inc, $ward);
            $this->objPHPExcel->getActiveSheet()->setCellValue('D' . $inc, $animal);
            $this->objPHPExcel->getActiveSheet()->setCellValue('E' . $inc, $age);
            $this->objPHPExcel->getActiveSheet()->setCellValue('F' . $inc, $problems_data);
            $this->objPHPExcel->getActiveSheet()->setCellValue('G' . $inc, date('d-m-Y H:i:s', strtotime($value->created_at)));

            $inc++;
            $serial++;
        }

        // Rename worksheet
        $this->objPHPExcel->getActiveSheet()->setTitle('FAO DATA REPORT');
        $filename = "Exported_fao_data_" . date("Y-m-d") . ".xlsx";


        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $this->objPHPExcel->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }

    //send email
    function send_email_data()
    {
        //message
        $message = "Please find attached document for " . date('jS F, Y') . " SMS Study data";

        //load email config
        $this->load->library('email');
        $this->email->set_newline("\r\n");

        $this->email->from("renfrid.ngolongolo@sacids.org", 'SMS Study');
        $this->email->subject('SMS Study data:' . date('d-m-Y'));
        $this->email->to('renfridfrancis@gmail.com');
        $this->email->message($message);
        //$this->email->attach($this->export_sms_study_data());
        if ($this->email->send())
            echo "Email sent";
        else
            echo "Email not sent";
    }

    //push message
    function sms_push()
    {
        $date_time = date('Y-m-d H:i:s');
        $message = array(
            'recipients' => '255717705746,255753437856,255712404118',
            'message' => 'Testing message from AfyaData API ' . $date_time,
            'datetime' => $date_time,
            'sender_id' => $this->sms_sender_id,
            'mobile_service_id' => self::MOBILE_SERVICE_ID
        );
        $post_data = array('data' => json_encode($message), 'datetime' => $date_time);
        $response = $this->Ussd_model->send_push_sms($post_data);
        echo $response;
    }

    //receive menu from EGA
    function verify()
    {
        //receive as json
        $post_data = file_get_contents("php://input");

        $value = json_decode($post_data, TRUE);

        if ($value['data'] == 123456) {
            $response = array(
                'success' => TRUE,
                'name' => 'Renfrid Ngolongolo',
                'gender' => 'Male'
            );

            log_message("debug", 'search key  ' . $value['data']);
        } else {
            $response = array(
                'success' => FALSE
            );
        }
        echo json_encode($response);
    }

    //receive menu from EGA
    function received_packet()
    {
        //receive as json
        $post_data = file_get_contents("php://input");

        $value = json_decode($post_data, TRUE);

        log_message("debug", 'ussd_message  ' . $post_data);

        //response
        $response = array(
            'status' => TRUE,
            'sms_reply' => TRUE,
            'sms_text' => 'Ombi lako limepokelewa kwa nambari ya kumbukumbu AFYADATA'
        );

        echo json_encode($response);
    }

    //pull message
    function sms_pull()
    {
        //receive as json
        $post_data = file_get_contents("php://input");

        $value = json_decode($post_data, TRUE);

        //variables
        $message = $value['message'];
        $msisdn = $value['msisdn'];
        $transaction_id = $value['transaction_id'];
        $sent_time = $value['sent_time'];

        log_message("debug", 'pull_message ' . $post_data);

        //response
        $response = array(
            'transaction_id' => $transaction_id,
            'message' => 'Request Received Successfully.',
            'reply' => 1
        );

        echo json_encode($response);
    }



    /*=================================================
    TIBA USSD SETIINGS
    =================================================*/
    //verify password
    function tb_verify_password()
    {
        //receive as json
        $post_data = file_get_contents("php://input");

        $value = json_decode($post_data, TRUE);

        log_message("debug", 'password  ' . $value['data']);

        //verify here
        // $this->model->set_table('vhw_users');
        // $user = $this->model->get_by(array('password' => $value['data']));

        if (strlen($value['data']) == 4) {
            $response = array(
                'success' => TRUE,
                'password' => $value['data']
            );
        } else {
            $response = array(
                'success' => FALSE,
                'password' => $value['data']
            );
        }
        echo json_encode($response);
    }

    //verify age
    function tb_verify_age()
    {
        //receive as json
        $post_data = file_get_contents("php://input");

        $value = json_decode($post_data, TRUE);

        log_message("debug", 'age  ' . $value['data']);

        if ($value['data'] >= 0 && $value['data'] <= 120) {
            $response = array(
                'success' => TRUE,
                'age' => $value['data']
            );
        } else {
            $response = array(
                'success' => FALSE,
                'age' => $value['data']
            );
        }
        echo json_encode($response);
    }

    //insert tb data
    function tb_save_data()
    {
        //receive as json
        $post_data = file_get_contents("php://input");
        log_message("debug", 'tiba data  =>' . $post_data);

        $value = json_decode($post_data, TRUE);

        //post data to server
        $data = array(
            'password' => $value['tiba_passw'],
            'caseId' => $value['tiba_number'],
            'gender' => $value['tiba_gender'],
            'age' => $value['tiba_age'],
            'condition' => $value['tiba_condition'],
            'severity' => $value['tiba_proble'],
            'mobile' => $value['msisdn'],
            'flag' => 'tiba'
        );

        //insert a data bunch
        $this->model->set_table('vhw_cases');
        $result = $this->model->insert($data);

        if ($result) {
            //response
            $response = array(
                'status' => TRUE,
                'sms_reply' => FALSE,
                'sms_text' => 'Taarifa zako zimetufikia'
            );
        } else {
            $response = array('success' => FALSE);
        }
        echo json_encode($response);
    }

    /*=================================================
    TRAKOMA USSD SETIINGS
    =================================================*/
    //process trakoma mda data
    function trakoma_mda_data()
    {
        //receive as json
        $post_data = file_get_contents("php://input");
        log_message("debug", 'TRAKOMA DATA  =>' . $post_data);
        $value = json_decode($post_data, TRUE);

        //save data from menu session
        $this->model->set_table('vhw_rti_mda');
        $result = $this->model->insert(['json' => $post_data]);

        //post data to server
        $data = [
            'password' => $value['ntdcp_password'],
            'mday' => $value['ntdcp_days'],
            'womenzith_tablets' => $value['womenzith_table'],
            'menzith_tablets' => $value['menzith_tablets'],
            'womenzith_pos' => $value['womenzith_pos'],
            'menzith_pos' => $value['menzith_pos'],
            'phone'       => $value['msisdn']

        ];

        // API URL
        $url = 'http://mda.ntdcp.go.tz/api/trachoma_survey_responses/';

        // Create a new cURL resource
        $ch = curl_init($url);

        // Setup request to send json via POST
        $payload = json_encode($data);

        // Attach encoded JSON string to the POST fields
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $http_response_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_response_code == 200 || $http_response_code == 300) {
            //response
            $response = array(
                'status' => TRUE,
                'sms_reply' => FALSE,
                'sms_text' => 'Taarifa zako zimetufikia'
            );
        } else {
            $response = array('success' => FALSE);
        }

        //log response
        log_message("debug", 'response  =>' . json_encode($response));

        //return response
        echo json_encode($response);
    }

    /*=================================================
    ONE HEALTH DETECT USSD SETIINGS
    =================================================*/
    //process one health detect data
    function ohd_data()
    {
        //receive as json
        $post_data = file_get_contents("php://input");
        log_message("debug", 'OHD DATA  =>' . $post_data);
        $value = json_decode($post_data, TRUE);

        //post data to server
        $arr_data = [
            'text' => $value['menu_tukio'],
            'village' => $value['tukio_kijiji'],
            'ward' => $value['tukio_kata']
        ];

        //check the data
        if (strtoupper($value['tukio_tarehe']) == 'LEO') {
            $arr_data['date'] = date('d/m/Y');
        } else {
            $arr_data['date'] = $value['tukio_tarehe'];
        }

        //reporter name
        if (isset($value['tukio_name']) && $value['tukio_name'] != '')
            $arr_data['name_of_reporter'] = $value['tukio_name'];

        //human affected
        if (isset($value['tukio_human']) && $value['tukio_human'] != '')
            $arr_data['no_of_human_affected'] = $value['tukio_human'];

        //animal affected
        if (isset($value['tukio_animal']) && $value['tukio_animal'] != '')
            $arr_data['no_of_animal_affected'] = $value['tukio_animal'];

        // API URL
        $url = 'https://dev.sacids.org/ems/api/signal/';

        // Create a new cURL resource
        $ch = curl_init($url);

        // Setup request to send json via POST
        $data = [
            'contents' => $arr_data,
            'channel' => 'SMS',
            'contact' => $value['msisdn']
        ];
        $payload = json_encode($data);

        // Attach encoded JSON string to the POST fields
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $http_response_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_response_code == 200 || $http_response_code == 201) {
            //response
            $response = array(
                'status' => TRUE,
                'sms_reply' => FALSE,
                'sms_text' => 'Taarifa zako zimetufikia'
            );
        } else {
            $response = array('success' => FALSE);
        }

        //log response
        log_message("debug", 'response  =>' . json_encode($response));

        //return response
        echo json_encode($response);
    }

    //pull message
    function ohd_sms_pull()
    {
        //receive as json
        $post_data = file_get_contents("php://input");

        $value = json_decode($post_data, TRUE);

        //variables
        $message = $value['message'];
        $msisdn = $value['msisdn'];
        $transaction_id = $value['transaction_id'];
        $sent_time = $value['sent_time'];

        //post data to server
        $arr_data = [
            'text' => $message,
            'date' => $sent_time
        ];

        // API URL
        $url = 'http://dev.sacids.org/ems/api/signal/';

        // Create a new cURL resource
        $ch = curl_init($url);

        // Setup request to send json via POST
        $data = [
            'contents' => $arr_data,
            'channel' => 'SMS',
            'contact' => $msisdn
        ];
        $payload = json_encode($data);

        // Attach encoded JSON string to the POST fields
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $http_response_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_response_code == 200 || $http_response_code == 300) {
            //response
            $response = array(
                'transaction_id' => $transaction_id,
                'message'        => 'Request Received Successfully.',
                'reply'          => 1
            );
        } else {
            $response = array('success' => FALSE);
        }

        //log response
        log_message("debug", 'response  =>' . json_encode($response));

        //response
        echo json_encode($response);
    }
}
