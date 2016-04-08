<div id="content">

	<div class='option_wrp'>
		<br>
		<!--  <div class='icon_wrp'>[-]</div> --!>
		<div id='option_wrp'>
		<?php
		// check if is admin
		if ($this->session->userdata ( "user_id" ) == 1) {
			
			?>
				<div class="label_sec">
					<div 	class="link group" 
							target="list_wrp" 
							label="Manage Permission"
							args="table_id=12"
							action="<?php echo site_url("perm/manage_table") ?>">
								<div class="left">
									<i class="material-icons md-dark">domain</i>
								</div>
					</div>
					<div 	class="link group" 
							target="list_wrp" 
							label="List Permissions"
							action="<?php echo site_url("perm/list_perms") ?>">
								<div class="left">
									<i class="material-icons md-light">library_books</i>
								</div>
					</div>
					<div 	class="link group" 
							target="list_wrp" 
							label="Manage Tables"
							args="table_id=13"
							action="<?php echo site_url("perm/manage_table") ?>">
								<div class="left">
									<i class="material-icons md-light">dns</i>
								</div>
					</div>
					<div class="link" target="detail_wrp" label="New Table"
						action="<?php echo site_url("perm/new_table") ?>">NT</div>
					<div class="link" target="list_wrp" label="List Table"
						action="<?php echo site_url("perm/list_tables") ?>">LT</div>
				</div>
				
			<?php
}
			
			$label 	= $this->Perm_model->get_perm_tree ();
			$parts	= array();
			
			//print_r($label);
			foreach ( $label as $key => $val ) {
				echo '<div class="label_sep"><i class="material-icons md-light">more_horiz</i></div>';
				echo '<div class="label_sec">';
				$rows = $this->Perm_model->get_perm_tree ( $key );
				
				foreach ( $rows as $k => $v ) {
					
					$type	= $v['perm_type'];
					$title	= $v['title'];
					$icon	= $v['icon_font'];
					
					//print_r($v);
					if(empty($icon)) $icon = 'open_in_new';
					
					$args	= $v['perm_data'];
					
					parse_str($args,$parts);					
					$url	= @$parts['controller'];
					echo '	<div 	class="link group" 
									target="' . $v ['perm_target'] . '" 
									action="' . site_url ( $url ) . '" 
									args=\''.$args.'\' label="'.$title.'">
										<div class="left"><i class="material-icons md-light">'.$icon.'</i></div>
							</div>';					
				}
				echo '</div>';
			}
			
			?>
			</ul>
				<?php
		
		echo $this->session->userdata ( "user_id" );
		?>
		</div>
	</div>

	<div class='list_wrp'>
		<br>
		<div class='icon_wrp'>[-]</div>
		<div id='list_wrp' class='perm_target_divs'></div>
	</div>

	<div class="detail_wrp">
		<div id='detail_wrp' class='perm_target_divs'></div>
	</div>

</div>
