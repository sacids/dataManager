/**
 * 
 */
/**
 * Created by Eric Beda on 2/24/2016.
 */

$(document).ready(
		function() {

			$('.list_wrp').hide();
			$('.hidden').hide();
			$('.list_wrp').resizable({
		        handles: "e",
		        minWidth: 20,
		        maxWidth: 620,
		        create: function( event, ui ) {
		            // Prefers an another cursor with two arrows
		            $(".ui-resizable-e").css("cursor","ew-resize");
		        }
		    });
			
			
			$(".link").on({
			    mouseenter: function () {
			        //stuff to do on mouse enter
			    	label	= $(this).attr("label");
			    	$( this ).append( $( "<div class='link_label'> "+label+" </div>" ) );
			    },
			    mouseleave: function () {
			        //stuff to do on mouse leave
			    	$( this ).find( "div:last" ).remove();
			    }
			});
	
			$(document).on(
					'click',
					'#adv_search_link',
					function(event){
						
						$('#adv_search').slideToggle();
					});
			$(document).on(
					'click',
					'.link, .m_link',
					function(event) {

						var target = $(this).attr('target');
						var action = $(this).attr('action');
						var args = $(this).attr('args');

						// clear both targets contents
						$('#list_wrp').html('');
						$('#detail_wrp').html('');
						
						// set 
						$('.link').removeClass('link_sel');
						$(this).addClass('link_sel');

						if (target == 'detail_wrp') {
							$('.icon_wrp .bt').html('fast_forward');
							$('.list_wrp').hide('slide', { direction: 'left', easing: 'easeOutQuart' },800);
							$('#detail_wrp').show();
						} else {
							$('.icon_wrp .bt').html('fast_rewind');
							$('.list_wrp').show('slide', { direction: 'left', easing: 'easeOutQuart' },800);
						}

						// put loader
						//$('#'+target).html('<img src="http://127.0.0.1/dataManager/assets/images/loader.gif">');
						
						$.post(action, args, function(data) {
							$('#' + target).html(data);
						});

					});
			
			$(document).on(
					'click',
					'.table_res_row .cell_del',
					function(event){
						
						var tbl_id = $(this).attr('tbl_id');
						var tbl_name = $(this).attr('tbl_name');
						var action	= $(this).attr('action');
						
						if(confirm('Please confirm deletion of id `'+tbl_id+'` in table `'+tbl_name+'`') == true){
							// do delete
							$.post(action,{table: tbl_name, id: tbl_id}, function(data){
								if(data == 'Delete Success!'){
									alert('Delete successful');
									$('.row_'+tbl_id).slideUp();
								}else{
									alert('Delete failed');
								}
							});
						}
						
						event.preventDefault();
						return false;
						
					});
			$(document).on(
					'click',
					'.table_res_row',
					function(event){
						
						var id	= $(this).attr('id');
						var tb	= $(this).closest('.table_wrp').attr('table_id');
						var tn	= $(this).closest('.table_wrp').attr('table_name');
						var action = $(this).closest('.table_wrp').attr('action');
						
						$('.table_res_row').removeClass('table_res_row_sel');
						$(this).addClass('table_res_row_sel');
						
						//alert('sema');
						$.post(action,{ id: id, table_name: tn, table_id: tb}, function(data) {
							
							$('#detail_wrp').html(data);
						});
						
					});

			$(document).on(
					'click',
					'.icon_wrp .bt',
					function(event) {
						
						if ($('.list_wrp').hasClass('list_min')) {	
						//if($('.list_wrp').is(":visible")){
						
							
							$('.list_wrp').show('slide', { direction: 'left', easing: 'easeOutQuart' },800);
							$('.list_wrp').removeClass('list_min');
							$(this).html('fast_rewind');
						} else {
							
							$('.list_wrp').hide('slide', { direction: 'left', easing: 'easeOutQuart' },800);
							$('.list_wrp').addClass('list_min');
							$(this).html('fast_forward');
						}
					});

			$(document).on(
					'click',
					'.label',
					function(event) {
						$(this).next().slideToggle();
					});

			$(document).on('click', '.perm_list_link', function(event) {

				var target = $(this).attr('target');
				var action = $(this).attr('action');
				var args = $(this).attr('args');
				
				if (target === undefined) {
					// auto detect target id
					target = $(this).closest('.perm_target_divs').attr('id');
				}

				// clear both targets contents
				$('#detail_wrp').html('');

				if (target == 'detail_wrp') {
					$('#detail_wrp').show();
				}

				// alert(action);

				//alert(target+' '+action+' '+args);

				$.post(action, args, function(data) {
					
					$('#' + target).html(data);
				});
			});
			
			$(document).on('click', '.perm_detail_link', function(event) {

				var target = $(this).attr('target');
				var action = $(this).attr('action');
				var args = $(this).attr('args');
				
				if (target === undefined) {
					// auto detect target id
					target = $(this).closest('.perm_target_divs').attr('id');
				}

				$.post(action, args, function(data) {
					
					$('#' + target).html(data);
				});
			});

			// capture all submit elements
			$(document).on('click', 'input[type=submit], button[type=submit]', function(event) {

				//alert('submit');
				// get the form
				var form = $(this).closest("form");
				var action = form.attr('action');
				var target = form.attr('target');

				if (target === undefined) {
					// auto detect target id
					target = $(this).closest('.perm_target_divs').attr('id');
				}

				var values = form.serialize();

				$.post(action, values, function(data) {
					$('#' + target).html(data);
				});

				// Avoid submit event to continue normal execution
				event.preventDefault();
				return false;
			});

			$(document).on('click', '.tab', function(event) {

				var action 	= $(this).attr('action');
				var args 	= $(this).attr('args');	
				
				// add remove class active then add class to clicked one
				$('.tab').removeClass('active_tab');
				$(this).addClass('active_tab');

				$.post(action, args, function(data) {
					$('#tab_target').html(data);
				});

			});
			
			$(document).on('click', '.min_tab', function(event) {

				var parent_id = $(this).parent().parent().attr('id');
				$('#'+parent_id+' form').slideToggle();

			});
			
			$('#manage_table_search_results tbody tr').addClass('visible');
			   
			$(document).on('keyup','#filter', function(event){
				
				 if (event.keyCode == 27 || $(this).val() == '') {
				      //if esc is pressed we want to clear the value of search box
				      $(this).val('');			             
				      //we want each row to be visible because if nothing
				      //is entered then all rows are matched.
				      $('tbody tr').removeClass('visible').show().addClass('visible');
				 }else{
					 filter('tbody tr', $(this).val());
				 }				
			});
			
			function filter(selector, query) {
				  query =   $.trim(query); //trim white space
				  query = query.replace(/ /gi, '|'); //add OR for regex query
				 
				  $(selector).each(function() {
				    ($(this).text().search(new RegExp(query, "i")) < 0) ? $(this).hide().removeClass('visible') : $(this).show().addClass('visible');
				  });
				}

		});