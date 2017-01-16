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

    public function test_find_disease_by_id()
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
            "description" => "Tropical disease",
            "date_created" => date("Y-m-d H:i:s")
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
                "description" => "Tropical disease",
                "date_created" => date("Y-m-d H:i:s")
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
            "description" => "Tropical disease",
            "date_created" => date("Y-m-d H:i:s")
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
}