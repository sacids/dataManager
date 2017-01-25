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
 * Date: 18-Jan-17
 * Time: 08:54
 */
class Feedback_model_test extends TestCase
{
    public function setUp()
    {
        $this->resetInstance();
        $this->CI->load->model('Feedback_model');
        $this->obj = $this->CI->Feedback_model;
    }

    public function test_count_new_feedback()
    {
        $this->assertEquals(0, $this->obj->count_new_feedback());
    }

    public function test_create_feedback()
    {
        $this->assertEquals(0, $this->obj->count_new_feedback());

        $feedback = array(
            "user_id" => 1,
            "instance_id" => uniqid("instanced."),
            "form_id" => uniqid('form_id.'),
            "message" => "Message here",
            'sender' => "PHPUnit",
            "date_created" => date('Y-m-d H:i:s'),
            "status" => "pending",
            "reply_by" => 0
        );

        print_r($feedback);

        $this->obj->create_feedback($feedback);
        $this->assertEquals(1, $this->obj->count_new_feedback());
    }

    public function test_count_feedback()
    {
        $this->assertEquals(1, $this->obj->count_new_feedback());
    }

    public function test_find_all()
    {
        $expected_fb = array(
            array(
                "user_id" => 1,
                "instance_id" => uniqid("instanced."),
                "form_id" => uniqid('form_id.'),
                "message" => "Message here",
                'sender' => "PHPUnit",
                "date_created" => date('Y-m-d H:i:s'),
                "status" => "pending",
                "reply_by" => 0
            )
        );

        print_r($expected_fb[0]);

        $found_feedback = $this->obj->find_all();

        $i = 0;
        foreach ($found_feedback as $fb) {
            $this->assertEquals($expected_fb[$i]['user_id'], $fb->user_id);
            $this->assertSame($expected_fb[$i]['instance_id'], $fb->instance_id);
            $this->assertEquals($expected_fb[$i]['form_id'], $fb->form_id);
            $this->assertEquals($expected_fb[$i]['message'], $fb->message);
            $this->assertEquals($expected_fb[$i]['sender'], $fb->sender);
            $this->assertEquals($expected_fb[$i]['status'], $fb->status);
            $this->assertEquals($expected_fb[$i]['date_created'], $fb->date_created);
            $this->assertEquals($expected_fb[$i]['reply_by'], $fb->reply_by);
            $i++;
        }
    }

    public function test_search_feedback()
    {

    }

    public function test_get_feedback_details_by_instance()
    {
    }

    public function test_get_feedback_by_instance()
    {
    }

    public function test_update_user_feedback()
    {
    }

    public function test_get_reply_user()
    {
    }

    public function test_get_feedback_mapping()
    {
    }

    public function test_get_feedback_list()
    {
    }

    public function test_get_feedback_notification()
    {
    }

    public function test_get_feedback_form_details()
    {
    }

    public function test_get_form_details()
    {
    }
}