<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Videojuegos | Neon Gamer</title>
    <?php require_once "dependencias.php"; ?>


    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <div class="bg-game">GAME</div>

    <div class="crud-neon">
        <h1>CRUD VIDEOJUEGOS</h1>
        <hr>

        <div class="text-center mb-4">
            <button type="button" class="btn btn-lg btn-primary" data-toggle="modal" data-target="#addmodal" id="btnAdd">
                + AGREGAR NUEVO JUEGO
            </button>
        </div>

        <div id="tablastores"></div>
    </div>

    <div class="modal fade" id="addmodal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar nuevo juego</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body">
                    <form id="frmAgrega">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" class="form-control" name="nombrej" id="nombrej" required>
                        </div>
                        <div class="form-group">
                            <label>Año</label>
                            <input type="text" class="form-control" name="anioj" id="anioj" required>
                        </div>
                        <div class="form-group">
                            <label>Empresa</label>
                            <input type="text" class="form-control" name="empresaj" id="empresaj" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="btnAgregarJuego">Agregar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="updatemodal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Actualizar Juego</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body">
                    <form id="frmactualiza">
                        <input type="hidden" name="id_juego" id="id_juego">
                        <div class="form-group"><label>Nombre</label><input type="text" class="form-control" name="nombrejU" id="nombrejU" required></div>
                        <div class="form-group"><label>Año</label><input type="text" class="form-control" name="aniojU" id="aniojU" required></div>
                        <div class="form-group"><label>Empresa</label><input type="text" class="form-control" name="empresajU" id="empresajU" required></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-warning" id="btnactualizar">Actualizar</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<script type="text/javascript">
        $(document).ready(function(){
            $('#tablastores').load('tabla.php');

            $('#btnAgregarJuego').click(function(){
                if(validarFormVacio('frmAgrega') > 0){
                    alertify.alert("¡Debes llenar todos los campos!");
                    return false;
                }
                datos=$('#frmAgrega').serialize();
                $.ajax({
                    type:"POST", data:datos, url:"php/insertar.php",
                    success:function(r){
                        if(r==1){
                            $('#frmAgrega')[0].reset();
                            $('#tablastores').load('tabla.php');
                            $('#addmodal').modal('hide');
                            alertify.success("Juego agregado con éxito");
                        }else{
                            alertify.error("Error al agregar");
                        }
                    }
                });
            });

            $('#btnactualizar').click(function(){
                datos=$('#frmactualiza').serialize();
                $.ajax({
                    type:"POST", data:datos, url:"php/actualizar.php",
                    success:function(r){
                        if(r==1){
                            $('#tablastores').load('tabla.php');
                            $('#updatemodal').modal('hide');
                            alertify.success("Actualizado con éxito");
                        }else{
                            alertify.error("Error al actualizar");
                        }
                    }
                });
            });
        });
</script>

<script type="text/javascript">

  function obtenDatos(idjuego){
    $.ajax({
      type:"POST",
      data:"idjuego=" + idjuego,
      url:"php/obtenerRegistro.php",
      success:function(r){
        datos=jQuery.parseJSON(r);

        $('#id_juego').val(datos['id_juego']);
        $('#nombrejU').val(datos['nombrejU']);
        $('#aniojU').val(datos['aniojU']);
        $('#empresajU').val(datos['empresajU']);
      }
    });
  }

  
  function validarFormVacio(formulario){
    datos=$('#' + formulario).serialize();
    d=datos.split('&');
    vacios=0;
    for(i=0;i< d.length;i++){
      controles=d[i].split("=");
      if(controles[1]=="A" || controles[1]==""){
        vacios++;
      }
    }
    return vacios;
  }

  function elimina(idjuego){
      alertify.confirm('Eliminar juego', '¿Desea eliminar este registro?', 
              function(){ 
                  $.ajax({
                     type:"POST",
                      data:"idjuego=" + idjuego,
                      url:"php/eliminar.php",
                      success:function(r){
                          if(r==1){     
                              $('#tablastores').load('tabla.php');
                              alertify.success("Eliminado con exito :)");
                          }else{
                               alertify.error("No se pudo eliminar :(");
                          }
                      }
                  });
              }
              ,function(){ 
                alertify.error('Cancelo')
              });
  }

</script>
