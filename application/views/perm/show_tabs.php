

<div class='tab_wrp'>
	<?php
	foreach($this->data['tabs'] as $val){
		
		if(array_key_exists('link', $val)){
			$link	= $val['link'];
		}else{
			$link	= 'perm/page_not_found';
		}
		$icon	= $val['icon'];
		if(empty($icon)){
			$icon	= 'view_module';
		}
		
		$args	= http_build_query($val);
		echo 	'	<div class="tab" action="'.site_url($link).'" args="'.$args.'">'
						.'<i class="material-icons md-light" style="font-size:10px;">'.$icon.'</i>&nbsp;'
						.$val['title'].
				'	</div>';
	}
	?>
</div>
<div id="tab_target" class="perm_target_divs">

empty
</div>