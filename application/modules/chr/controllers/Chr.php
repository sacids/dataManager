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
 * @copyright    Copyright (c) 2017. Southen African Center for Infectious disease Surveillance (SACIDS
 *     http://sacids.org)
 * @license        http://opensource.org/licenses/MIT	MIT License
 * @link        https://afyadata.sacids.org
 * @since        Version 1.0.0
 */

/**
 * Created by PhpStorm.
 * User: Godluck Akyoo
 * Date: 28-Jun-17
 * Time: 09:11
 */
class Chr extends MX_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model("Chr_model");
	}


	public function index()
	{
		$this->chr_overview();
	}

	public function chr_overview()
	{
		$this->list_chr();
	}

	public function new_chr()
	{
		if ($this->form_validation->run() === FALSE) {
			$this->load->view('header');
			$this->load->view("add_new_chr");
			$this->load->view('footer');
		} else {

			$chr_info = [
				"first_name" => $this->input->post("first_name"),
				"last_name"  => $this->input->post("last_name"),
				"email"      => $this->input->post("email"),
				"phone"      => $this->input->post("phone"),
			];


			$chr_id = 0;

			$education = [
				"chr_id"      => $chr_id,
				"school"      => $this->input->post("school"),
				"field_study" => $this->input->post("field_of_study"),
				"grade"       => $this->input->post("grade"),
				"activities"  => $this->input->post("activities"),
				"from_year"   => $this->input->post("from_year"),
				"to_year"     => $this->input->post("to_year"),
				"description" => $this->input->post("description"),
			];


			//todo capture academic qualifications and experience here

			$this->db->trans_start();
			//do db insert here.
			$this->db->trans_complete();

			if ($this->db->trans_status()) {

			} else {

			}
		}
	}

	public function list_chr()
	{
		$data['chrs'] = $this->Chr_model->find_all();
		$this->load->view("chrs_list", $data);
	}
}