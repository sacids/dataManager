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
 * @package	    AfyaData
 * @author	    AfyaData Dev Team
 * @copyright	Copyright (c) 2017. Southen African Center for Infectious disease Surveillance (SACIDS http://sacids.org)
 * @license	    http://opensource.org/licenses/MIT	MIT License
 * @link	    https://afyadata.sacids.org
 * @since	    Version 1.0.0
 */

/**
 * Created by PhpStorm.
 * User: Godluck Akyoo
 * Date: 11-Apr-17
 * Time: 09:54
 */
?>

<div class="container">
	<div class="row">
		<div class="col-sm-12 col-md-12 col-lg-12 main">
			<h3>Send to dhis2</h3>
			<?php
			if ($this->session->flashdata('msg') != '') {
				echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
			} ?>

			<div class="col-sm-6">

				<?php echo form_open('dhis2/dhis2_data', 'class="form-horizontal" role="form"'); ?>


				<div class="form-group">
					<label>HIV Cases</label>
					<input type="text" name="hiv" placeholder="Cases reported" class="form-control"
					       value="<?php echo set_value('hiv'); ?>">
				</div>
				<div class="error" style="color: red"> <?php echo form_error('hiv'); ?></div>

				<div class="form-group">
					<label>HIV Cases</label>
					<input type="text" name="malaria" placeholder="Malaria cases reported" class="form-control"
					       value="<?php echo set_value('malaria'); ?>">
				</div>
				<div class="error" style="color: red"> <?php echo form_error('malaria'); ?></div>

				<div class="form-group">
					<label>HIV Cases</label>
					<input type="text" name="hiv" placeholder="Typhoid Cases reported" class="form-control"
					       value="<?php echo set_value('typhoid'); ?>">
				</div>
				<div class="error" style="color: red"> <?php echo form_error('typhoid'); ?></div>

				<div class="form-group">
					<button type="submit" class="btn btn-primary">Send</button>
				</div>
				
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>

