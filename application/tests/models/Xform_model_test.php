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
 * Date: 13-Jan-17
 * Time: 13:15
 */
class Xform_model_test extends TestCase
{
    public function setUp()
    {
        $this->resetInstance();
        $this->CI->load->model('Xform_model');
        $this->obj = $this->CI->Xform_model;
    }

    public function test_new_items_are_published()
    {
        $this->assertEquals(0, count($this->obj->get_form_list(null, 100, 0, "published")));
        $xform_details = array(
            "id" => 1,
            "user_id" => 1,
            "form_id" => "build_id_272829292",
            "jr_form_id" => "129",
            "title" => "Test form",
            "description" => "Test form description",
            "filename" => "test.xml",
            "date_created" => date("c"),
            "status" => "published",
            "access" => "public",
            "perms" => "U1U,G12G"
        );
        $this->obj->create_xform($xform_details);
        $this->assertEquals(1, count($this->obj->get_form_list(null, 100, 0, "published")));
    }

    public function test_get_form_list()
    {
        $expected = array(
            array(
                "id" => 1,
                "user_id" => 1,
                "form_id" => "build_id_272829292",
                "jr_form_id" => "129",
                "title" => "Test form",
                "description" => "Test form description",
                "filename" => "test.xml",
                "date_created" => date("c"),
                "status" => "published",
                "access" => "public",
                "perms" => "U1U,G12G"
            )
        );

        $form_list = $this->obj->get_form_list(null, 100, 0, "published");
        $i = 0;
        foreach ($form_list as $item) {
            $this->assertEquals($expected[$i]["user_id"], $item->user_id);
            $this->assertEquals($expected[$i]["title"], $item->title);
            $this->assertEquals($expected[$i]["status"], $item->status);
            $this->assertEquals($expected[$i]["access"], $item->access);
            $i++;
        }
    }

    public function test_find_by_id()
    {
        $form = $this->obj->find_by_id(1);
        $this->assertEquals(1, $form->id);
    }
}