<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Dashboard Sistemaweb21</title>

		<meta name="description" content="overview &amp; stats" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
		<link href="{{ asset('assets_sistema/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">

		<link href="{{ asset('assets_sistema/css/colorbox.min.css') }}" rel="stylesheet" type="text/css">

		<link href="{{ asset('assets_sistema/font-awesome/4.5.0/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="{{ asset('assets_sistema/css/ui.jqgrid.min.css') }}" />

		<link rel="stylesheet" href="{{ asset('assets_sistema/css/chosen.min.css') }}" />

		<!-- page specific plugin styles -->

		<!-- text fonts -->
		<link href="{{ asset('assets_sistema/css/fonts.googleapis.com.css') }}" rel="stylesheet" type="text/css">

		<!-- ace styles -->
		<link href="{{ asset('assets_sistema/css/ace.min.css') }}" rel="stylesheet" type="text/css">

		<!--[if lte IE 9]>
			<link rel="stylesheet" href="asset/css/ace-part2.min.css" class="ace-main-stylesheet" />
		<![endif]-->

		<link href="{{ asset('assets_sistema/css/ace-skins.min.css') }}" rel="stylesheet" type="text/css">

		<link href="{{ asset('assets_sistema/css/ace-rtl.min.css') }}" rel="stylesheet" type="text/css">
		
		<link href="{{ asset('assets_sistema/css/animated.css') }}" rel="stylesheet" type="text/css">

		<link href="{{ asset('assets_sistema/css/bootstrap-datepicker3.css') }}" rel="stylesheet" type="text/css">
		<link href="{{ asset('assets_sistema/css/toastr.min.css') }}" rel="stylesheet" type="text/css">

		<link href="{{ asset('assets_sistema/css/styles.css') }}" rel="stylesheet" type="text/css">
    @yield('signature_css')
	</head>
	<body class="no-skin">
		@include('partials.menu')
					
					@yield('content')

				</div>			
			</div><!-- /.main-content -->

			<div class="footer">
				<div class="footer-inner">
					<div class="footer-content">
						<span class="bigger-120">
							<span class="blue bolder">Sistemaweb21</span>
							Sistema &copy; 2018-2019
						</span>

						&nbsp; &nbsp;
						<span class="action-buttons">
							<a href="#">
								<i class="ace-icon fa fa-twitter-square light-blue bigger-150"></i>
							</a>

							<a href="#">
								<i class="ace-icon fa fa-facebook-square text-primary bigger-150"></i>
							</a>

							<a href="#">
								<i class="ace-icon fa fa-rss-square orange bigger-150"></i>
							</a>
						</span>
					</div>
				</div>
			</div>

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->

		<script src="{{ asset('assets_sistema/js/jquery-2.1.4.min.js')  }}"></script>
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) 
				document.write("<script src='{{ asset('assets_sistema/js/jquery.mobile.custom.min.js') }}'>"+"<"+"/script>");
		</script>
		

		<script src="{{ asset('assets_sistema/js/bootstrap.min.js')  }}"></script>

		<script src="{{ asset('assets_sistema/js/chosen.jquery.min.js')  }}"></script>

		<!-- page specific plugin scripts -->
		  <script src="{{ asset('assets_sistema/js/jquery.colorbox.min.js')  }}"></script>

		<!-- ace scripts -->
		<script src="{{ asset('assets_sistema/js/ace-elements.min.js')  }}"></script>
		<script src="{{ asset('assets_sistema/js/ace.min.js')  }}"></script>
		<script src="{{ asset('assets_sistema/js/bootstrap-datepicker.min.js')  }}"></script>
		<!-- ace settings handler -->
		<script src=" {{ asset('assets_sistema/js/ace-extra.min.js') }}"></script>
		<script src=" {{ asset('assets_sistema/js/jquery.dataTables.min.js') }}"></script>
		<script src=" {{ asset('assets_sistema/js/jquery.dataTables.bootstrap.min.js') }}"></script>
		<script src="{{ asset('assets_sistema/js/jquery.maskedinput.min.js') }}"></script>
		<script src="{{ asset('assets_sistema/js/toastr.min.js') }}"></script>
    @yield('signature_js')

		<!-- inline scripts related to this page -->

<!-- page specific plugin scripts -->
      
	
		<!-- inline scripts related to this page -->
		<script type="text/javascript">
			jQuery(function($) {

			// ======================= | FUNCIONES PARA TODO EL SISTEMA | ============================== //

				$.mask.definitions['~']='[+-]';
				$('.input-mask-date').mask('99/99/9999');
				$('.input-mask-phone').mask('(999) 999-9999');

				$('#tabla').dataTable({
					"order": [],
					"language": {url: "{{ asset('assets_sistema/json/esp.json') }}"}
				})

    			$('[data-tool="tooltip"]').tooltip()

    			$('.fecha').datepicker({
    				format: 'dd-mm-yyyy',
    				autoClose: true,
    				language: 'es'
    			})

    			let type = "{{ Session::get('type') }}"

    			if(type)
    			{
    				let message = "{{ Session::get('message') }}"
    				
    				switch (type) {
    					case 'success':
    						toastr.success(message, 'Éxito!')
    					break;
    					case 'alert':
    						toastr.warning(message, 'Alerta!')
    					break;
    					case 'danger':
    						toastr.error(message, 'Error!')
    					break;
    				}
    				
    			}

    			$('.eliminar').click(function(e){
    				let agree = confirm('Esta seguro que desea eliminar este registro?')

    				if(!agree)
    				{
    					return false;
    				}
    			})

    			$('#btn_form_helper_back').click(function(e){

            // btn mostrar tabla
    				$('#div_form_helper').addClass('hidden')
    				$('#form_registro')[0].reset()
    				$('#div_table_helper').removeClass('hidden').addClass('animated slideInRight')
    			})

    			$('#btn_table_helper_new').click(function(e){

            // btn mostrar formulario

    				$('#div_table_helper').addClass('hidden')
    				$('#div_form_helper').removeClass('hidden').addClass('animated slideInRight')	

    				let data = e.target.dataset.ruta

    				$('#form_registro').attr('action',data)

            $('#_method_input').remove()
    			})

    			$('.modificar_btn_helper').click(function(e){
            
            let data = e.target.parentElement.dataset

            Object.keys(data).forEach(function(element, index) {
              
              if(element !== 'tool' && element !== 'originalTitle' && element !== 'ruta_formulario')
              {
                if(element.indexOf('_check_radio') !== -1)
                {
                  if(element.indexOf('_multiple') !== -1){
                    let element_limpio = element.replace('_check_radio_multiple', '')
                    let array_values = data[element].split(',')
                    
                    array_values.forEach(function(ele,i){
                      $('input[name="'+element_limpio+'[]"][value="'+ele+'"]').prop('checked',true)
                    })
                  }else{
                    let element_limpio = element.replace('_check_radio', '')
                    data[element] = !data[element] ? 0 : data[element];

                    $('input[name="'+element_limpio+'"][value="'+data[element]+'"]').prop('checked',true)
                  } 
                }
                else if(element.indexOf('_select') !== -1)
                {
                  let element_limpio = element.replace('_select', '') 

                  data[element] = !data[element] ? 0 : data[element];

                  $('select[name="'+element_limpio+'"]').val(data[element]).prop('selected',true).change()
                }
                else if(element.indexOf('_image') !== -1)
                {
                  $('input[type="file"]').prop('required',false)
                  if(document.querySelector('[name="'+element+'"]').type !== "file"){
                    document.querySelector('[name="'+element+'"]').value = data[element]
                  }
                }
                else
                {
                  data[element] = !data[element] ? 0 : data[element]

                  $("[name='"+element+"']").val(data[element])
                  //document.querySelector('[name="'+element+'"]').value = data[element]
                }
              }
            });

    				$('#form_registro').attr('action',data.ruta)
            $('#form_registro').append('<input type="hidden" id="_method_input" name="_method" value="PATCH" />')

    				$('#div_table_helper').addClass('hidden')
    				$('#div_form_helper').removeClass('hidden').addClass('animated slideInRight')

    			})

          $('.eliminar_btn_helper').click(function(e){


              var ruta = e.currentTarget.dataset.ruta,
                  agree= confirm('Esta seguro de querer eliminar este registro?')

              if(agree)
              {
                $('#form_eliminar_helper').attr('action',ruta)
                $('#form_eliminar_helper').submit()
              }
                
          })

    			// ======================= | FUNCIONES PARA PLANTILLA SISTEMA | ============================== //

    			$('.remove_img_plantilla_img').click(function(e) {
    				
    				const agree = confirm('Esta seguro de querer eliminar esta imagen?')

    				if(agree)
    				{
    					$('#div_image').show()
						$('body').css('opacity',0.5);

    					let id_remove = e.target.dataset.id,
	    					ref       = e.target.dataset.ref,
	    					img       = e.target.dataset.img

	    				$.ajax({
	    					url: 'admin_remover_imagen ?>',
	    					type: 'POST',
	    					data: {id : id_remove, ref, img},
	    				})
	    				.done(function(data) {
	    					
	    					$('#ref_'+ref).attr('href','')
	    					$('#imagen_'+ref).attr('src','')
	    					$('#div_image').hide()
							$('body').css('opacity',1);	

	    					toastr.success('Imagen removida con éxito','Éxito!')

	    					e.target.style.display = 'none'
	    				})
    				}
    				
    			});

				var $overflow = '';
				var colorbox_params = {
					rel: 'colorbox',
					reposition:true,
					scalePhotos:true,
					scrolling:false,
					previous:'<i class="ace-icon fa fa-arrow-left"></i>',
					next:'<i class="ace-icon fa fa-arrow-right"></i>',
					close:'&times;',
					current:'{current} of {total}',
					maxWidth:'100%',
					maxHeight:'100%',
					onOpen:function(){
						$overflow = document.body.style.overflow;
						document.body.style.overflow = 'hidden';
					},
					onClosed:function(){
						document.body.style.overflow = $overflow;
					},
					onComplete:function(){
						$.colorbox.resize();
					}
				};

				$('.ace-thumbnails [data-rel="colorbox"]').colorbox(colorbox_params);
				$("#cboxLoadingGraphic").html("<i class='ace-icon fa fa-spinner orange fa-spin'></i>");//let's add a custom loading icon
	
	
				$(document).one('ajaxloadstart.page', function(e) {
					$('#colorbox, #cboxOverlay').remove();
			   });

    				if(!ace.vars['touch']) {
					$('.chosen-select').chosen({allow_single_deselect:true}); 
					//resize the chosen on window resize
			
					$(window)
					.off('resize.chosen')
					.on('resize.chosen', function() {
						$('.chosen-select').each(function() {
							 var $this = $(this);
							 $this.next().css({'width': $this.parent().width()});
						})
					}).trigger('resize.chosen');
					//resize chosen on sidebar collapse/expand
					$(document).on('settings.ace.chosen', function(e, event_name, event_val) {
						if(event_name != 'sidebar_collapsed') return;
						$('.chosen-select').each(function() {
							 var $this = $(this);
							 $this.next().css({'width': $this.parent().width()});
						})
					});
				}
			})
		</script>
	</body>
</html>
@yield('scripts')

	
