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
 * @package     AfyaData
 * @author      AfyaData Dev Team
 * @copyright   Copyright (c) 2017. Southen African Center for Infectious disease Surveillance (SACIDS
 *     http://sacids.org)
 * @license     http://opensource.org/licenses/MIT MIT License
 * @link        https://afyadata.sacids.org
 * @since       Version 1.0.0
 */

/**
 * Created by PhpStorm.
 * User: Godluck Akyoo
 * Date: 28-Jun-17
 * Time: 16:05
 */
?>

<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div id="header-title">
                <h3 class="title">Add CHR</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>">CHR</a></li>
                <li class="active">Add New CHR</li>
            </ol>

            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <?php if (validation_errors() != "") {
                        echo '<div class="alert alert-danger fade in">' . validation_errors() . '</div>';
                    } else if ($this->session->flashdata('message') != "") {
                        echo $this->session->flashdata('message');
                    } ?>

                    <?php echo form_open('chr/new_chr/', 'role="form"'); ?>

                    <div>
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#basicInfo" aria-controls="basicInfo" role="tab"
                                   data-toggle="tab">BasicInfo</a></li>
                            <li role="presentation">
                                <a href="#education" aria-controls="education" role="tab"
                                   data-toggle="tab">Education</a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active " id="basicInfo" style="padding: 20px;">

                                <div class="form-group">
                                    <label><?php echo $this->lang->line("label_chr_first_name") ?>
                                        <span>*</span></label>
                                    <input type="text" name="first_name" placeholder="Enter first name"
                                           class="form-control"
                                           value="<?php echo set_value("first_name") ?>">
                                </div>
                                <div class="error" style="color: red"><?php echo form_error('first_name'); ?></div>

                                <div class="form-group">
                                    <label><?php echo $this->lang->line("label_chr_last_name") ?>
                                        <span>*</span></label>
                                    <input type="text" name="first_name" placeholder="Enter last name"
                                           class="form-control"
                                           value="<?php echo set_value("last_name") ?>">
                                </div>
                                <div class="error" style="color: red"><?php echo form_error('last_name'); ?></div>

                                <div class="form-group">
                                    <label><?php echo $this->lang->line("label_chr_email") ?>
                                        <span>*</span></label>
                                    <input type="text" name="email" placeholder="Enter email address"
                                           class="form-control"
                                           value="<?php echo set_value("email") ?>">
                                </div>
                                <div class="error" style="color: red"><?php echo form_error('email'); ?></div>


                                <div class="form-group">
                                    <label><?php echo $this->lang->line("label_chr_phone") ?>
                                        <span>*</span></label>
                                    <input type="text" name="first_name" placeholder="Enter phone number"
                                           class="form-control"
                                           value="<?php echo set_value("phone") ?>">
                                </div>
                                <div class="error" style="color: red"><?php echo form_error('phone'); ?></div>


                                <div class="form-group">
                                    <label><?php echo $this->lang->line("label_description") ?> :</label>
                                    <textarea class="form-control" name="description" rows="4" id="description">
                                        <?php echo set_value("description"); ?></textarea>
                                </div>
                                <div class="error" style="color: red"><?php echo form_error('description'); ?></div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="education" style="padding: 20px;">
                                <?php echo anchor("chr/new_experience/", '<button type="button" class="btn btn-link">Add Qualification</button>', "class='pull-right' style='margin-bottom:20px;'"); ?>
                                <div class="well well-lg">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line("label_chr_school_college") ?>
                                            <span>*</span></label>
                                        <input type="text" name="school_college"
                                               placeholder="Enter school or college name"
                                               class="form-control"
                                               value="<?php echo set_value("school_college") ?>">
                                    </div>
                                    <div class="error"
                                         style="color: red"><?php echo form_error('school_college'); ?></div>

                                    <div class="form-group">
                                        <label><?php echo $this->lang->line("label_chr_field_study") ?>
                                            <span>*</span></label>
                                        <input type="text" name="field_of_study" placeholder="Enter field of study"
                                               class="form-control"
                                               value="<?php echo set_value("field_of_study") ?>">
                                    </div>
                                    <div class="error"
                                         style="color: red"><?php echo form_error('field_of_study'); ?></div>

                                    <div class="form-group">
                                        <label><?php echo $this->lang->line("label_chr_grade") ?>
                                            <span>*</span></label>
                                        <input type="text" name="grade" placeholder="Enter grade"
                                               class="form-control"
                                               value="<?php echo set_value("grade") ?>">
                                    </div>
                                    <div class="error" style="color: red"><?php echo form_error('grade'); ?></div>

                                    <div class="form-group">
                                        <label><?php echo $this->lang->line("label_chr_activities") ?> :</label>
                                    <textarea class="form-control" name="activities" rows="4" id="description">
                                        <?php echo set_value("activities"); ?></textarea>
                                    </div>
                                    <div class="error" style="color: red"><?php echo form_error('activities'); ?></div>

                                    <div class="row">
                                        <div class="col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line("label_chr_from_year") ?>
                                                    <span>*</span></label>
                                                <input type="text" name="from_year" placeholder="Enter from year"
                                                       class="form-control"
                                                       value="<?php echo set_value("from_year") ?>">
                                                <div class="error"
                                                     style="color: red"><?php echo form_error('from_year'); ?></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line("label_chr_to_year") ?>
                                                    <span>*</span></label>
                                                <input type="text" name="to_year" placeholder="Enter to year"
                                                       class="form-control"
                                                       value="<?php echo set_value("from_year") ?>">
                                                <div class="error"
                                                     style="color: red"><?php echo form_error('to_year'); ?></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label><?php echo $this->lang->line("label_description") ?> :</label>
                                    <textarea class="form-control" name="description" rows="4" id="description">
                                        <?php echo set_value("description"); ?></textarea>
                                    </div>
                                    <div class="error" style="color: red"><?php echo form_error('description'); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                    <button type="submit" class="btn btn-primary btn-lg"><?php echo $this->lang->line("btn_add_chr") ?></button>
                </div>

                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
</div>