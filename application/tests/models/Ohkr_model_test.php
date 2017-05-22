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

/**
 * Created by PhpStorm.
 * User: Godluck Akyoo
 * Date: 16-Jan-17
 * Time: 08:48
 */
class Ohkr_model_test extends TestCase
{
    public function setUp()
    {
        $this->resetInstance();
        $this->CI->load->model('Ohkr_model');
        $this->obj = $this->CI->Ohkr_model;
    }

    public function test_add_specie()
    {
        $this->assertEquals(0, count($this->obj->find_all_species(30, 0)));
        $specie = array(
            "id" => 1,
            "title" => "Binadamu"
        );
        $this->obj->add_specie($specie);
        $this->assertEquals(1, count($this->obj->find_all_species(30, 0)));
    }

    public function test_find_specie_by_id()
    {
        $expected_specie = array(
            "id" => 1,
            "title" => "Binadamu"
        );
        $specie = $this->obj->get_specie_by_id(1);

        $this->assertEquals($expected_specie["id"], $specie->id);
        $this->assertEquals($expected_specie["title"], $specie->title);
    }

    public function test_find_all_species()
    {
        $expected_specie = array(
            array(
                "id" => 1,
                "title" => "Binadamu"
            )
        );
        $specie = $this->obj->find_all_species(30, 0);

        $i = 0;
        foreach ($specie as $item) {
            $this->assertEquals($expected_specie[$i]["id"], $item->id);
            $this->assertEquals($expected_specie[$i]["title"], $item->title);
            $i++;
        }
    }

    public function test_add_disease()
    {
        $this->assertEquals(0, count($this->obj->get_diseases(100, 0)));
        $disease_info = array(
            "id" => 1,
            "title" => "Malaria",
            "specie_id" => 1,
            "description" => "Tropical disease"
        );
        $this->obj->add_disease($disease_info);
        $this->assertEquals(1, count($this->obj->get_diseases(100, 0)));
    }

    public function test_find_all_disease()
    {
        $expected_diseases = array(
            array(
                "id" => 1,
                "title" => "Malaria",
                "specie_id" => 1,
                "description" => "Tropical disease"
            )
        );
        $diseases = $this->obj->get_diseases(30, 0);

        $i = 0;
        foreach ($diseases as $item) {
            $this->assertEquals($expected_diseases[$i]["id"], $item->id);
            $this->assertEquals($expected_diseases[$i]["title"], $item->title);
            $this->assertEquals($expected_diseases[$i]["specie_id"], $item->specie_id);
            $this->assertEquals($expected_diseases[$i]["description"], $item->description);
            $i++;
        }
    }

    public function test_get_disease_by_id()
    {
        $expected_disease = array(
            "id" => 1,
            "title" => "Malaria",
            "specie_id" => 1,
            "description" => "Tropical disease"
        );

        $disease = $this->obj->get_disease_by_id($expected_disease['id']);

        $this->assertEquals($expected_disease["id"], $disease->id);
        $this->assertEquals($expected_disease["title"], $disease->d_title);
        $this->assertEquals($expected_disease["specie_id"], $disease->specie_id);
        $this->assertEquals($expected_disease["description"], $disease->description);
    }

    public function test_count_disease()
    {
        $this->assertEquals(1, $this->obj->count_disease());
    }


    public function test_count_specie()
    {
        $this->assertEquals(1, $this->obj->count_species());
    }

    public function test_update_disease()
    {
        $expected_disease = array(
            "id" => 1,
            "description" => "Tropical disease, Updated"
        );

        $this->obj->update_disease($expected_disease['id'], $expected_disease);
        $updated_disease = $this->obj->get_disease_by_id($expected_disease['id']);

        $this->assertEquals($expected_disease["id"], $updated_disease->id);
        $this->assertEquals($expected_disease["description"], $updated_disease->description);
        //$this->assertEquals($expected_disease["date_created"], $updated_disease->date_created);
    }


    public function test_update_specie()
    {
        $expected_specie = array(
            "id" => 1,
            "title" => "Binadamu Updated"
        );

        $this->obj->update_specie($expected_specie['id'], $expected_specie);
        $updated_specie = $this->obj->get_specie_by_id($expected_specie['id']);

        $this->assertEquals($expected_specie["id"], $updated_specie->id);
        $this->assertEquals($expected_specie["title"], $updated_specie->title);
        //$this->assertEquals($expected_specie["date_created"], $updated_specie->date_created);
    }


    public function test_add_symptom()
    {

        $this->assertEquals(0, $this->obj->count_symptoms());

        $symptom = array(
            "id" => 1,
            "title" => "Kuhara Damu",
            "code" => "A01",
            "description" => "Kuharisha damu mfululizo"
        );
        $this->obj->add_symptom($symptom);
        $this->assertEquals(1, $this->obj->count_symptoms());
    }

    public function test_find_all_symptoms()
    {
        $symptom_expected = array(
            array(
                "id" => 1,
                "title" => "Kuhara Damu",
                "code" => "A01",
                "description" => "Kuharisha damu mfululizo"
            )
        );

        $symptoms = $this->obj->find_all_symptoms();

        $i = 0;
        foreach ($symptoms as $dalili) {
            $this->assertEquals($symptom_expected[$i]['id'], $dalili->id);
            $this->assertEquals($symptom_expected[$i]['title'], $dalili->title);
            $this->assertEquals($symptom_expected[$i]['code'], $dalili->code);
            $this->assertEquals($symptom_expected[$i]['description'], $dalili->description);
            $i++;
        }
    }

    public function test_get_symptom_by_id()
    {

        $symptom_expected = array(
            "id" => 1,
            "title" => "Kuhara Damu",
            "code" => "A01",
            "description" => "Kuharisha damu mfululizo"
        );

        $symptom = $this->obj->get_symptom_by_id(1);

        $this->assertEquals($symptom_expected['id'], $symptom->id);
        $this->assertEquals($symptom_expected['title'], $symptom->title);
        $this->assertEquals($symptom_expected['code'], $symptom->code);
        $this->assertEquals($symptom_expected['description'], $symptom->description);
    }

    public function test_count_symptoms()
    {
        $this->assertEquals(1, $this->obj->count_symptoms());
    }

    public function test_update_symptom()
    {
        $symptom_expected = array(
            "id" => 1,
            "title" => "Kuhara Damu Updated",
            "code" => "A01",
            "description" => "Kuharisha damu mfululizo Uliyofanyiwa marekebisho"
        );

        $this->obj->update_symptom($symptom_expected['id'], $symptom_expected);

        $updated_symptom = $this->obj->get_symptom_by_id(1);

        $this->assertEquals($symptom_expected['id'], $updated_symptom->id);
        $this->assertEquals($symptom_expected['title'], $updated_symptom->title);
        $this->assertEquals($symptom_expected['code'], $updated_symptom->code);
        $this->assertEquals($symptom_expected['description'], $updated_symptom->description);
    }

    public function test_add_disease_symptom()
    {
        $this->assertEquals(0, count($this->obj->get_all_symptoms()));

        $disease_symptom = array(
            "id" => 1,
            "disease_id" => 1,
            "symptom_id" => 1,
            "importance" => 50
        );
        $this->obj->add_disease_symptom($disease_symptom);
        $this->assertEquals(1, count($this->obj->get_all_symptoms()));
    }

    public function test_find_disease_symptoms()
    {
        $expectedDiseaseSymptoms = array(
            array(
                "id" => 1,
                "disease_id" => 1,
                "symptom_id" => 1,
                "importance" => 50
            )
        );

        $disease_symptoms = $this->obj->find_disease_symptoms(1);//disease id argument

        $count = 0;
        foreach ($disease_symptoms as $symptom) {
            $this->assertEquals($expectedDiseaseSymptoms[$count]['id'], $symptom->id);
            $this->assertEquals($expectedDiseaseSymptoms[$count]['disease_id'], $symptom->disease_id);
            $this->assertEquals($expectedDiseaseSymptoms[$count]['symptom_id'], $symptom->symptom_id);
            $this->assertEquals($expectedDiseaseSymptoms[$count]['importance'], $symptom->importance);
            $count++;
        }
    }

    public function test_get_disease_symptom_by_id()
    {
        $expected_disease = array(
            "id" => 1,
            "disease_id" => 1,
            "symptom_id" => 1,
            "importance" => 50
        );

        $disease_symptom = $this->obj->get_disease_symptom_by_id(1);

        $this->assertEquals($expected_disease['id'], $disease_symptom->id);
        $this->assertEquals($expected_disease['disease_id'], $disease_symptom->disease_id);
        $this->assertEquals($expected_disease['symptom_id'], $disease_symptom->symptom_id);
        $this->assertEquals($expected_disease['importance'], $disease_symptom->importance);
    }

    public function test_get_all_symptoms()
    {
        $expectedDiseaseSymptoms = array(
            array(
                "id" => 1,
                "disease_id" => 1,
                "symptom_id" => 1,
                "importance" => 50
            )
        );

        $disease_symptoms = $this->obj->get_all_symptoms();


        $count = 0;
        foreach ($disease_symptoms as $symptom) {
            $this->assertEquals($expectedDiseaseSymptoms[$count]['id'], $symptom['id']);
            $this->assertEquals($expectedDiseaseSymptoms[$count]['disease_id'], $symptom['disease_id']);
            $this->assertEquals($expectedDiseaseSymptoms[$count]['symptom_id'], $symptom['symptom_id']);
            $this->assertEquals($expectedDiseaseSymptoms[$count]['importance'], $symptom['importance']);
            $count++;
        }
    }

    public function test_update_disease_symptom()
    {
        $expected_disease = array(
            "id" => 1,
            "disease_id" => 1,
            "symptom_id" => 1,
            "importance" => 60
        );

        $this->obj->update_disease_symptom(1, $expected_disease);
        $updated_disease_symptom = $this->obj->get_disease_symptom_by_id(1);

        $this->assertEquals($expected_disease['id'], $updated_disease_symptom->id);
        $this->assertEquals($expected_disease['disease_id'], $updated_disease_symptom->disease_id);
        $this->assertEquals($expected_disease['symptom_id'], $updated_disease_symptom->symptom_id);
        $this->assertEquals($expected_disease['importance'], $updated_disease_symptom->importance);
    }


    public function test_get_submitted_symptoms()
    {

    }

    public function test_find_disease_faq()
    {
        $disease_faq = array(
            array(
                "id" => 1,
                "disease_id" => 1,
                "question" => "What are the necessary steps to take for a Malaria patient?",
                "answer" => "Rush the patient immediately to the nearest health facility"
            )
        );

        $faqs = $this->obj->find_disease_faq(1);
        $i = 0;

        foreach ($faqs as $faq) {
            $this->assertEquals($disease_faq[$i]['id'], $faq->id);
            $this->assertEquals($disease_faq[$i]['disease_id'], $faq->disease_id);
            $this->assertEquals($disease_faq[$i]['question'], $faq->question);
            $this->assertEquals($disease_faq[$i]['answer'], $faq->answer);
            $i++;
        }
    }

    public function test_add_disease_faq()
    {
        $this->assertEquals(0, count($this->obj->find_disease_faq(1)));
        $disease_faq = array(
            "id" => 1,
            "disease_id" => 1,
            "question" => "What are the necessary steps to take for a Malaria patient?",
            "answer" => "Rush the patient immediately to the nearest health facility"
        );

        $this->obj->add_disease_faq($disease_faq);
        $this->assertEquals(1, count($this->obj->find_disease_faq(1)));
    }

    public function test_get_disease_faq_by_id()
    {

        $expected_faq = array(
            "id" => 1,
            "disease_id" => 1,
            "question" => "What are the necessary steps to take for a Malaria patient?",
            "answer" => "Rush the patient immediately to the nearest health facility"
        );

        $found_faq = $this->obj->get_disease_faq_by_id(1);

        $this->assertEquals($expected_faq['id'], $found_faq->id);
        $this->assertEquals($expected_faq['disease_id'], $found_faq->disease_id);
        $this->assertEquals($expected_faq['question'], $found_faq->question);
        $this->assertEquals($expected_faq['answer'], $found_faq->answer);
    }

    public function test_update_disease_faq()
    {

    }

    public function test_create_response_sms()
    {
        $this->assertEquals(0, $this->obj->count_response_sms());
        $message = array(
            "id" => 1,
            "disease_id" => 1,
            "group_id" => 1,
            "message" => "Doctors are advised to take all necessary steps to stop the spread of this disease",
            "type" => "TEXT",
            "status" => "Enabled",
            "date_created" => date("Y-m-d H:i:s")
        );
        $this->obj->create_response_sms($message);
        $this->assertEquals(1, $this->obj->count_response_sms());
    }

    public function test_find_response_sms_by_id()
    {
        $expected_message = array(
            "id" => 1,
            "disease_id" => 1,
            "group_id" => 1,
            "message" => "Doctors are advised to take all necessary steps to stop the spread of this disease",
            "type" => "TEXT",
            "status" => "Enabled",
            "date_created" => date("Y-m-d H:i:s")
        );
        $sms = $this->obj->find_response_sms_by_id($expected_message['id']);
        $this->assertEquals($expected_message['message'], $sms->message);
        $this->assertEquals($expected_message['type'], $sms->type);
        $this->assertEquals($expected_message['status'], $sms->status);
        $this->assertEquals($expected_message['group_id'], $sms->group_id);
        $this->assertEquals($expected_message['disease_id'], $sms->disease_id);
    }

    public function test_find_response_sms_by_disease_id()
    {
        $expected_message = array(
            array(
                "id" => 1,
                "disease_id" => 1,
                "group_id" => 1,
                "message" => "Doctors are advised to take all necessary steps to stop the spread of this disease",
                "type" => "TEXT",
                "status" => "Enabled",
                "date_created" => date("Y-m-d H:i:s")
            )
        );
        $responses = $this->obj->find_response_sms_by_disease_id($expected_message[0]['disease_id']);

        $i = 0;
        foreach ($responses as $sms) {
            $this->assertEquals($expected_message[$i]['message'], $sms->message);
            $this->assertEquals($expected_message[$i]['type'], $sms->type);
            $this->assertEquals($expected_message[$i]['status'], $sms->status);
            $this->assertEquals($expected_message[$i]['group_id'], $sms->group_id);
            $this->assertEquals($expected_message[$i]['disease_id'], $sms->disease_id);
            $i++;
        }
    }

    public function test_update_response_sms()
    {
        $expected_message = array(
            "id" => 1,
            "disease_id" => 1,
            "group_id" => 1,
            "message" => "Doctors are advised to take all necessary steps to stop the spread of this disease",
            "type" => "TEXT",
            "status" => "Disabled",
            "date_modified" => date("Y-m-d H:i:s")
        );
        $this->obj->update_response_sms(1, $expected_message);
        $updated_sms = $this->obj->find_response_sms_by_id($expected_message['id']);

        $this->assertEquals($expected_message['disease_id'], $updated_sms->disease_id);
        $this->assertEquals($expected_message['group_id'], $updated_sms->group_id);
        $this->assertEquals($expected_message['message'], $updated_sms->message);
        $this->assertEquals($expected_message['type'], $updated_sms->type);
        $this->assertEquals($expected_message['status'], $updated_sms->status);
        $this->assertEquals($expected_message['date_modified'], $updated_sms->date_modified);
    }

    public function test_create_send_sms()
    {

        $this->assertEquals(0, $this->obj->count_send_sms());

        $sms_to_send = array(
            "id" => 1,
            "response_msg_id" => 1,
            "phone_number" => 255712123456,
            "status" => "PENDING"
        );

        $this->obj->create_send_sms($sms_to_send);
        $this->assertEquals(1, $this->obj->count_send_sms());
    }

    public function test_update_sms_status()
    {
        $sms_updates = array(
            "status" => "SENT",
            "date_sent" => date("Y-m-d h:i:s"),
            "infobip_msg_id" => "c050e1aa-5f1e-462c-b8a7-7e126e86f60b"
        );
        $this->obj->update_sms_status(1, $sms_updates);

        $updated_send_sms = $this->obj->find_sent_sms_by_id(1);

        $this->assertEquals($sms_updates['status'], $updated_send_sms->status);
        $this->assertEquals($sms_updates['date_sent'], $updated_send_sms->date_sent);
        $this->assertEquals($sms_updates['infobip_msg_id'], $updated_send_sms->infobip_msg_id);
    }

    public function test_find_diseases_by_symptoms_code()
    {

    }

    public function test_count_response_sms()
    {
        $this->assertEquals(1, $this->obj->count_response_sms());
    }

    public function test_find_response_messages_and_groups()
    {

    }

    public function test_find_sender_response_message()
    {

    }

    public function test_save_detected_diseases()
    {

    }

    public function test_delete_disease_symptom()
    {
        $this->obj->delete_disease_symptom(1);
        $this->assertEquals(0, count($this->obj->get_all_symptoms(1)));
    }

    public function test_delete_disease_faq()
    {
        $this->obj->delete_disease_faq(1);
        $this->assertEquals(0, count($this->obj->find_disease_faq(1)));
    }

    public function test_delete_response_sms()
    {
        $this->obj->delete_response_sms(1);
        $this->assertEquals(0, $this->obj->count_response_sms());
    }

    public function test_delete_symptom()
    {
        $this->obj->delete_symptom(1);
        $this->assertEquals(0, $this->obj->count_symptoms());
    }

    public function test_delete_disease()
    {
        $this->obj->delete_disease(1);
        $this->assertEquals(0, count($this->obj->get_diseases()));
    }

    public function test_delete_specie()
    {
        $this->obj->delete_specie(1);
        $this->assertEquals(0, count($this->obj->find_all_species()));
    }
}