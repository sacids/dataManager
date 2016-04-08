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
							$('.list_wrp').addClass('min_list_wrp', 1000,
									"easeOutQuart");
							$('.list_wrp .icon_wrp').html('[+]');
							$('#detail_wrp').show();
						} else {
							$('.list_wrp').show();
							$('.list_wrp').removeClass('min_list_wrp', 1000,
									"easeOutQuart");
							$('.list_wrp .icon_wrp').html('[-]');
						}

						// put loader
						//$('#'+target).html('<img src="http://127.0.0.1/dataManager/assets/images/loader.gif">');
						
						$.post(action, args, function(data) {
							$('#' + target).html(data);
						});

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
					'.list_wrp .icon_wrp',
					function(event) {

						if ($('.list_wrp').hasClass('min_list_wrp')) {
							$('#list_wrp').show()
							$('.list_wrp').removeClass('min_list_wrp', 1000,
									"easeOutQuart");
							$('.list_wrp .icon_wrp').html('[-]');
						} else {
							$('#list_wrp').hide()
							$('.list_wrp').addClass('min_list_wrp', 1000,
									"easeOutQuart");
							$('.list_wrp .icon_wrp').html('[+]');
						}
					});

			$(document).on(
					'click',
					'.label',
					function(event) {
						$(this).next().slideToggle();
					});
			$(document).on(
					'click',
					'.option_wrp .icon_wrp',
					function(event) {

						if ($('.option_wrp').hasClass('min_list_wrp')) {
							$('#option_wrp').show();
							$('.option_wrp').removeClass('min_list_wrp', 1000,
									"easeOutQuart");
							$('.option_wrp .icon_wrp').html('[-]');
						} else {
							$('#option_wrp').hide();
							$('.option_wrp').addClass('min_list_wrp', 1000,
									"easeOutQuart");
							$('.option_wrp .icon_wrp').html('[+]');
						}
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
			$(document).on('click', 'input[type=submit]', function(event) {

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

		});