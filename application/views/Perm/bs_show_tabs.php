

<ul class='nav nav-tabs'>
	<?php
	
	echo 	'	<li class="min_tab">'
					.'<i class="material-icons md-light" style="font-size:15px;">keyboard_arrow_up</i>'.
			'	</li>';
	
	$active	= 'active';
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
		echo 	'	<li class="tab '.$active.'" action="'.site_url($link).'" args="'.$args.'">'
						.'<a data-toggle="tab" href="#tab_target">'
						.'<i class="material-icons md-light" style="font-size:10px;">'.$icon.'</i>&nbsp;'
						.$val['title']
						.'</a>'.
				'	</li>';
		$active = '';
	}
	?>
</ul>
<div id="tab_target" class="perm_target_divs tab_target tab-content tab-pane fade">

empty
</div>