<div class="container-fluid">
	<div class="row">
		<div class="col-sm-3 col-md-2 sidebar">
			<ul class="nav nav-sidebar">
				<li class="active"><a href="#">Overview <span class="sr-only">(current)</span></a>

					<ul>
						<?php foreach ($xforms as $form) { ?>
							<li>
								<?php echo anchor("form_visualization/chart/" . $form->form_id, $form->title); ?>
							</li>
						<?php } ?>
					</ul>

				</li>
			</ul>
			<!--			<ul class="nav nav-sidebar">-->
			<!--				<li><a href="">Nav item</a></li>-->
			<!--				<li><a href="">Nav item again</a></li>-->
			<!--				<li><a href="">One more nav</a></li>-->
			<!--				<li><a href="">Another nav item</a></li>-->
			<!--				<li><a href="">More navigation</a></li>-->
			<!--			</ul>-->

		</div>
		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<h1 class="page-header" id="xform-title"><?php echo $form_details->title ?></h1>
			<div class="" style="margin-bottom: 10px;">
				<?php echo form_open("form_visualization/chart/" . $form_details->form_id, 'class="form-inline" role="form"'); ?>
				<?php
				$options = array("" => "Select column to plot");
				foreach ($table_fields as $key => $value) {
					$options[$value] = ucfirst(str_replace("_", " ", $value));
				}
				?>

				<div class="form-group">
					<label for="Axis Column"></label>
					<?php echo form_dropdown("axis", $options, $table_fields[mt_rand(1, (count($table_fields) - 1))], 'class="form-control"'); ?>
				</div>
				<div class="form-group">
					<label for="Group by"></label>
					<?php $options[""] = "Select column to Group by";
					echo form_dropdown("group_by", $options, $table_fields[mt_rand(1, (count($table_fields) - 1))], 'class="form-control"'); ?>
				</div>

				<div class="form-group">
					<label for="Operation"></label>
					<?php echo form_dropdown("function", array("COUNT" => "Count all", "SUM" => "Find summation"), "COUNT", 'class="form-control"'); ?>
				</div>

				<!-- Todo Uncomment and implement date
				<div class="form-group">
					<div class="input-group date startdate" data-link-field="dtp_input1">
						<input type="text" size="10" id="startdate" name="startdate" placeholder="Start date"
						       value="" readonly class="form-control">
						<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
					</div>
				</div>
				<div class="form-group">
					<div class="input-group date enddate" data-link-field="dtp_input1">
						<input type="text" size="10" id="startdate" name="startdate" placeholder="End date"
						       value="" readonly class="form-control">
						<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
					</div>
				</div>
				-->


				<div class="form-group">
					<div class="input-group">
						<?php echo form_submit("submit", "Submit", 'class="btn btn-primary"'); ?>
					</div>
				</div>
				<?php echo form_close(); ?>

				<?php echo validation_errors(); ?>
			</div>

			<div id="graph-content">
				<!--TODO Insert graph code here -->

				<?php if (empty($categories)) {
					$message = "<p class='text-center'>Select <strong>columns</strong> you want to plot against a group column and function you want to use, to see a chart here</p>";
					echo display_message($message, "info");
				}
				?>

			</div>
		</div>
	</div>
</div>