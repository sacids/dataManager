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
 * Date: 15-May-17
 * Time: 11:18
 */
?>
<section class="bg-light-grey">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div id="header-title">
                    <h3 class="title"><?= $form->title ?></h3>
                    <p><small><?= $form->description ?></small></p>
                </div>
            </div>
            <div class="col-sm-12 col-md-9 col-lg-9">
                <div class="panel panel-default">
                    <div class="panel-heading"><b>Map of Recent Submissions</b></div>
                    <div class="panel-body">
                        Map coming soon here
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading"><b><h3>Recent data Submissions</h3></b></div>
                    <div class="panel-body">

                        <div class="" style="overflow-x: scroll; width: 100%;">
                            <table class="table table_list table-bordered table-striped table-hover table-condensed">
                                <tr>
                                    <?php
                                    if (isset($selected_columns)) {
                                        foreach ($selected_columns as $column) {
                                            echo "<th>" . $column . "</th>";
                                        }
                                    } else {

                                        foreach ($table_fields as $key => $column) {
                                            if (array_key_exists($column, $field_maps)) {
                                                echo "<th>" . $field_maps[$column] . "</th>";
                                            } else {
                                                echo "<th>" . $column . "</th>";
                                            }
                                        }
                                    }
                                    ?>
                                </tr>
                                <?php
                                foreach ($form_data as $data) {
                                    echo "<tr>";
                                    foreach ($data as $key => $entry) {
                                        /* if ($key == "id") {
											 echo "<td class='text-center'>" . form_checkbox("entry_id[]", $entry) . "</td>";
										 }*/

                                        if (preg_match('/(\.jpg|\.png|\.bmp)$/', $entry)) {
                                            echo "<td><img src=' " . base_url() . "assets/forms/data/images/" . $entry . "' style='max-width:100px;' /></td>";
                                        } else {
                                            echo "<td>" . $entry . "</td>";
                                        }
                                    }
                                    echo "</tr>";
                                }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="">
                    <div class="panel panel-default">
                        <div class="panel-heading"><h3>Recent user chats</h3></div>
                        <div class="panel-body">
                            <table class="table table-responsive table-bordered table-striped">
                                <tr>
                                    <td>Sender Name</td>
                                    <td>Message</td>
                                    <td>Date sent</td>
                                    <td>Sender</td>
                                    <td>Status</td>
                                    <td>ViewedBy</td>
                                </tr>

                                <?php foreach ($recent_feedback as $feedback): ?>
                                    <tr>
                                        <td><?= $feedback->first_name . " " . $feedback->last_name ?></td>
                                        <td><?= $feedback->message ?></td>
                                        <td><?= $feedback->date_created ?></td>
                                        <td><?= $feedback->sender ?></td>
                                        <td><?= $feedback->status ?></td>
                                        <td><?= $feedback->viewed_by ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-xs-12 col-md-3 col-lg-3">
                Chats coming soon
            </div>
        </div>
    </div>
</section>