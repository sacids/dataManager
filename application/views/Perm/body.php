<div id="content">

	<div class='option_wrp'>
		<div id='option_wrp'>
		<?php
		// check if is admin
		
		if ($this->session->userdata ( "user_id" ) == 1) {
			
			?>
				<div class="label_sec">
					<div 	class="link group" 
							target="list_wrp" 
							label="Manage Permission"
							args="table_id=1&perm_id=1"
							action="<?php echo site_url("perm/manage_table") ?>">
								<div class="left">
									<i class="material-icons md-dark">domain</i>
								</div>
					</div>
					<div 	class="link group" 
							target="list_wrp" 
							label="Manage Filters"
							args="table_id=7&perm_id=1"
							action="<?php echo site_url("perm/manage_table") ?>">
								<div class="left">
									<i class="material-icons md-dark">filter_list</i>
								</div>
					</div>
					<div 	class="link group" 
							target="list_wrp" 
							label="Manage Tables"
							args="table_id=3&perm_id=1"
							action="<?php echo site_url("perm/manage_table") ?>">
								<div class="left">
									<i class="material-icons md-light">view_list</i>
								</div>
					</div>
					<div 	class="link group" 
							target="list_wrp" 
							label="Manage Users"
							args="table_id=5&perm_id=1"
							action="<?php echo site_url("perm/manage_table") ?>">
								<div class="left">
									<i class="material-icons md-light">account_circle</i>
								</div>
					</div>
					<div 	class="link group" 
							target="list_wrp" 
							label="Manage Groups"
							args="table_id=6&perm_id=1"
							action="<?php echo site_url("perm/manage_table") ?>">
								<div class="left">
									<i class="material-icons md-light">group</i>
								</div>
					</div>
					<div 	class="link group" 
							target="list_wrp" 
							label="Manage Modules"
							args="table_id=4&perm_id=1"
							action="<?php echo site_url("perm/manage_table") ?>">
								<div class="left">
									<i class="material-icons md-light">dashboard</i>
								</div>
					</div>
				</div>
				
			<?php
}
			
			$label 	= $this->Perm_model->get_tasks ();
			$parts	= array();
			
			
			
			//print_r($label);
			echo '<div class="label_sec">';
			foreach ( $label as $k => $v ) {
					
				
					$type	= $v['perm_type'];
					$title	= $v['title'];
					$icon	= $v['icon_font'];
					
					//print_r($v);
					if(empty($icon)) $icon = 'open_in_new';
					
					$args	= $v['perm_data'];
					
					$json	= json_decode($v['perm_data'],true);
					$json['perm_id']	= $v['id'];
					
					//parse_str($args,$parts);
					
					//print_r($parts);
					//echo http_build_query($parts);
					
					
					$post_args	= http_build_query($json);
					if($type == 'table'){
						$url 	= 'perm/manage_table';
						$post_args	= http_build_query($json);
					}else{	
						//echo 'chocho';
						//print_r($v);
						parse_str($post_args,$parts);
						$url	= $v['perm_data'];
					}
					
					echo '	<div 	class="link group" 
									target="' . $v ['perm_target'] . '" 
									action="' . site_url ( $url ) . '" 
									args=\''.$post_args.'\' label="'.$title.'">
										<div class="left"><i class="material-icons md-light">'.$icon.'</i></div>
							</div>';					
				
				
			}
			echo '</div>';
			
			?>
				<?php
		
		echo $this->session->userdata ( "user_id" );
		?>
		</div>
	</div>

	<div class='list_wrp'>
		<div class='icon_wrp'>[-]</div>
		<div id='list_wrp' class='perm_target_divs'></div>
	</div>

	<div class="detail_wrp">
		<div id='detail_wrp' class='perm_target_divs'></div>
	</div>

</div>
