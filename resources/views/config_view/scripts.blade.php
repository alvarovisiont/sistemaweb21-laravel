<script>
  $(function(e){

// ======================================= | DATA TABLE | ======================================================

    $('#btn_add_dt').click(function(e){
      
      $('#div_table_dt').addClass('hidden').removeClass('animated slideInUp')
      $('#div_form_dt').removeClass('hidden').addClass('animated slideInUp')
      $('#form_dt').attr('action',e.target.dataset.ruta)
      $('#form_dt').find('#orden').prop('readonly',true)
      $('#_method_form_dt').remove()
    })

    $('#btn_form_list').click(function(e) {
      
      $('#div_table_dt').removeClass('hidden').addClass('animated slideInUp')
      $('#div_form_dt').addClass('hidden').removeClass('animated slideInUp')
      $('#form_dt')[0].reset()

    });

    $('#form_dt').submit(function(e) {
      /* Act on the event */

      e.preventDefault()

      $('#div_image').show()
      $('body').css('opacity',0.5)

      $.ajax({
        url: e.target.getAttribute('action'),
        type: 'POST',
        dataType: 'JSON',
        data: $(this).serialize(),
      })
      .done(function(data) {
        
        if(data.r)
        {

          if(data.edit === undefined)
          {
            let datos = data.datos[0]

            let fila =  `<tr>
                    <td>
                      <a data-tool="tooltip" title="modificar" href="#"             
                        data-id ="${datos.id}"
                        data-th ="${datos.nombre}"
                        data-activo ="${datos.activo}"
                        data-key ="${datos.key}"
                        data-resaltar ="${datos.resaltar}"
                        data-format_number ="${datos.format_number}"
                        data-orden ="${datos.orden}"
                      >
                                <img src="{{ asset('assets_sistema/images/acciones/modificar.png') }}" width="20px" class="modificar"/>
                            </a>
                            <a data-tool="tooltip" title="Eliminar" href="{{ url('crear_vista/delete_td') }}/${datos.id}">
                                  <img src="{{ asset('assets_sistema/images/acciones/remover.jpg') }}" width="20px" class="eliminar_td"/>
                              </a>
                    </td>
                    <td>${datos.nombre}</td>
                    <td>Activo</td>
                    <td>${datos.key}</td>
                    <td>${datos.resaltar ? 'Si' : 'No'}</td>
                    <td><span class="label label-lg label-yellow arrowed-in arrowed-in-right">${datos.orden}</span></td>
                  </tr>`

            $('#tabla_dt').children('tbody').append(fila)

            $('#div_image').hide()
            $('body').css('opacity',1)

            toastr.success('Registro Agregado con Éxito','Éxito!')

            $('#btn_form_list').click()         
          }
          else
          {
            window.location.reload()
          } 
        }
        else
        {
          $('#div_image').hide()
          $('body').css('opacity',1)

          toastr.warning('Ha ocurrido un error','Alerta!')
        }
          
      })
      .fail(function() {
        console.log("error");
      })
      .always(function() {
        console.log("complete");
      }); // fin ajax
      
    }); // fin submit

    $('#tabla_dt').children('tbody').on('click','tr > td > a .modificar', function(e){

      dataset = e.target.parentElement.dataset

      $('#form_dt').find('#nombre').val(dataset.th)
      $('#form_dt').find('#activo').val(dataset.activo)
      $('#form_dt').find('#key').val(dataset.key)
      $('#form_dt').find('#orden').val(dataset.orden)
      $('#form_dt').find('#format_number').val(dataset.format_number)
      $('#form_dt').find('#resaltar').val(dataset.resaltar)

      $('#form_dt').find('#orden').prop('readonly',false)
      $('#form_dt').attr('action', '{{ url("crear_vista/update_dt") }}/'+dataset.id)
      $('#form_dt').append('<input type="hidden" name="_method" id="_method_form_dt" value="PATCH" />')

      $('#div_table_dt').addClass('hidden').removeClass('animated slideInUp')
      $('#div_form_dt').removeClass('hidden').addClass('animated slideInUp')
    })

    $('#tabla_dt').children('tbody').on('click','tr > td > a .eliminar_td', function(e){
      let agree = confirm('Esta seguro de querer eliminar este registro'),
          ruta  = e.currentTarget.parentElement.dataset.ruta

      if(agree)
      {
        $('#form_delete').attr('action',ruta)
        $('#form_delete').submit()
      }
    });

// ======================================= | FORMULARIO | ======================================================

    $('#btn_add_form').click(function(e){
      
      $('#div_table_form').addClass('hidden').removeClass('animated slideInUp')
      $('#div_form_form').removeClass('hidden').addClass('animated slideInUp')
      $('#form_form').attr('action',e.target.dataset.ruta)
      $('#form_form').find('#orden').prop('readonly',true)

      $('#form_form').find('#option').prop('disabled',true)
      $('#form_form').find('#selected').prop('disabled',true)   
      $('#form_form').find('#check_table').prop('disabled',true)    
      $('#form_form').find('#check_field').prop('disabled',true)    
      $('#_method_form_form').remove();

    })

    $('#btn_form_form').click(function(e) {
      
      $('#div_table_form').removeClass('hidden').addClass('animated slideInUp')
      $('#div_form_form').addClass('hidden').removeClass('animated slideInUp')
      $('#form_form')[0].reset()



    });

    $('#tipo').change(function(e) {
      let type = parseInt(e.target.value,10)

      if(type === 3 || type === 4)
      {
        $('#option').prop('disabled',false)
        $('#selected').prop('disabled',false)
        $('#check_table').prop('disabled',true) 
        $('#check_field').prop('disabled',true) 
      }
      else if(type === 5 || type === 6)
      {
        $('#option').prop('disabled',true)
        $('#selected').prop('disabled',false) 

        $('#check_table').prop('disabled',false)  
        $('#check_field').prop('disabled',false)  
      }
      else
      {
        $('#option').prop('disabled',true)
        $('#selected').prop('disabled',true)    
        $('#check_table').prop('disabled',true) 
        $('#check_field').prop('disabled',true) 
      }
    });

    $('#form_form').submit(function(e) {
      /* Act on the event */

      e.preventDefault()

      $('#div_image').show()
      $('body').css('opacity',0.5)

      $.ajax({
        url: e.target.getAttribute('action'),
        type: 'POST',
        dataType: 'JSON',
        data: $(this).serialize(),
      })
      .done(function(data) {
        
        if(data.r)
        {

          if(data.edit === undefined)
          {
            let datos = data.datos[0]

            let type = '';

            switch (datos.tipo.toString()) {
              case '1':
                type = 'Text';
              break;

              case '2':
                type = 'Number';
              break;

              case '3':
                type = 'Select A. Object';
              break;

              case '4':
                type = 'Select A.';
              break;

              case '5':
                type = 'Radio';
              break;

              case '6':
                type = 'Checkbox';
              break;

              case '7':
                type = 'Textarea';
              break;

              case '8':
                type = 'Date';
              break;

              case '9':
                type = 'Number';
              break;

              case '10':
                type = 'Hidden';
              break;

              case '11':
                type = 'File';
              break;

              case '12':
                type = 'Color';
              break;

              case '13':
                type = 'Email';
              break;
            }

            let fila =  `<tr>
                    <td>
                      <a data-tool="tooltip" title="modificar" href="#"             
                        data-id ="${datos.id}"
                        data-label ="${datos.label}"
                        data-tipo ="${datos.tipo}"
                        data-required ="${datos.required}"
                        data-name_id ="${datos.name_id}"
                        data-placeholder ="${datos.placeholder}"
                        data-value ="${datos.value}"
                        data-option ="${datos.option}"
                        data-selected ="${datos.selected}"
                        data-orden ="${datos.orden}"
                        data-multiple ="${datos.multiple ? 1 : 0}"
                        data-check_table ="${datos.check_table}"
                        data-check_field ="${datos.check_field}"
                        data-cols ="${datos.cols}"
                      >
                                <img src="{{ asset('assets_sistema/images/acciones/modificar.png') }}" width="20px" class="modificar"/>
                            </a>
                            <a data-tool="tooltip" title="Eliminar" href="#" data-ruta="{{ url('crear_vista/delete_form') }}/${datos.id}">
                                  <img src="{{ asset('assets_sistema/images/acciones/remover.jpg') }}" width="20px" class="eliminar_form"/>
                              </a>
                    </td>
                    <td>${datos.label}</td>
                    <td>
                      <span class="label label-lg label-purple arrowed-in arrowed-in-right">
                      ${type}</span> <br/> <b>Requerido:</b> ${datos.required ? 'Si' : 'No' }
                    </td>
                    <td>${datos.name_id }</td>
                    <td>${datos.check_table } <br/> ${datos.check_field}</td>
                    <td>${datos.value }</td>
                    <td>${datos.option }</td>
                    <td>${datos.cols}</td>
                    <td>
                      
                      <span class="label label-lg label-yellow arrowed-in arrowed-in-right">${datos.orden}</span>
                        
                    </td>
                  </tr>`

            $('#tabla_form').children('tbody').append(fila)

            $('#div_image').hide()
            $('body').css('opacity',1)

            toastr.success('Registro Agregado con Éxito','Éxito!')

            $('#btn_form_form').click()         
          }
          else
          {
            window.location.reload()
          } 
        }
        else
        {
          $('#div_image').hide()
          $('body').css('opacity',1)

          toastr.warning('Ha ocurrido un error','Alerta!')
        }
          
      })
      .fail(function() {
        console.log("error");
      })
      .always(function() {
        console.log("complete");
      }); // fin ajax
      
    }); // fin submit

    $('#tabla_form').children('tbody').on('click','tr > td > a .modificar', function(e){

      dataset = e.target.parentElement.dataset

      let multi = dataset.multiple == 0 ? 0 : 1,
          requi= dataset.required ? 1 : 0

      $('#form_form').find('#label').val(dataset.label)
      $('#form_form').find('#tipo').val(dataset.tipo)
      $('#form_form').find('#required').val(requi)
      $('#form_form').find('#name_id').val(dataset.name_id)
      $('#form_form').find('#placeholder').val(dataset.placeholder)
      $('#form_form').find('#name_id').val(dataset.name_id)
      $('#form_form').find('#value').val(dataset.value)
      $('#form_form').find('#option').val(dataset.option)
      $('#form_form').find('#selected').val(dataset.selected)
      $('#form_form').find('#orden').val(dataset.orden)
      $('#form_form').find('#multiple').val(multi)
      $('#form_form').find('#check_table').val(dataset.check_table)
      $('#form_form').find('#check_field').val(dataset.check_field)
      $('#form_form').find('#cols').val(dataset.cols)

      $('#form_form').find('#orden').prop('readonly',false)
      $('#form_form').attr('action', '{{ url("crear_vista/update_form") }}/'+dataset.id)
      $('#form_form').append('<input type="hidden" name="_method" id="_method_form_form" value="PATCH" />')

      if(dataset.tipo === '3' || dataset.tipo === '4')
      {
        $('#form_form').find('#option').prop('disabled',false)
        $('#form_form').find('#selected').prop('disabled',false)
        $('#form_form').find('#check_table').prop('disabled',true)  
        $('#form_form').find('#check_field').prop('disabled',true)  

      }
      else if (dataset.tipo === '5' || dataset.tipo === '6')
      {
        $('#form_form').find('#option').prop('disabled',true)
        $('#form_form').find('#selected').prop('disabled',false)  
        $('#form_form').find('#check_table').prop('disabled',false) 
        $('#form_form').find('#check_field').prop('disabled',false) 
      }
      else
      {
        $('#form_form').find('#option').prop('disabled',true)
        $('#form_form').find('#selected').prop('disabled',true)   
        $('#form_form').find('#check_table').prop('disabled',true)  
        $('#form_form').find('#check_field').prop('disabled',true)  
      }

      $('#div_table_form').addClass('hidden').removeClass('animated slideInUp')
      $('#div_form_form').removeClass('hidden').addClass('animated slideInUp')
    })

    $('#tabla_form').children('tbody').on('click','tr > td > a .eliminar_form', function(e){
      let agree = confirm('Esta seguro de querer eliminar este registro'),
          ruta  = e.currentTarget.parentElement.dataset.ruta

      if(agree)
      {
        $('#form_delete').attr('action',ruta)
        $('#form_delete').submit()
      }

    });

// ====================================== GENERAR VISTAS ;) ======================================================
  
    $('#form_txt').submit(function(e) {
      /* Act on the event */
      e.preventDefault()

      $('#div_image').show()
      $('body').css('opacity',0.5)

      $.ajax({
        url: '{{ url('crear_vista/make_view') }}',
        type: 'POST',
        dataType: 'JSON',
        data: $(this).serialize(),
      })
      .done(function(data) {
        let html = ''

        $.grep(data, function(i,e){
        
          if(i.vista !== undefined)
          {
            html+= 'Vista: '+i.vista+"<br/>"
          }
          else if(i.controlador !== undefined)
          {
            html+= 'Controlador: '+i.controlador+"<br/>"  
          }
          else if(i.ruta !== undefined){
           html+= 'Ruta: '+i.ruta+"<br/>"   
          }

          if(i.modelo !== undefined)
          {
            html+= 'Modelo: '+i.modelo+"<br/>"    
          }
        })

        $('#div_image').hide()
        $('body').css('opacity',1)

        toastr.warning(html,'Notificación')

      })
    });
  })
</script>