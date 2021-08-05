<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <link rel="stylesheet" href="css/estilos.css">

    <title>CRUD Con Php, PDO, Ajax y DataTables.js</title>
</head>

<body>

    <div class="container fondo">

        <h1 class="text-center">CRUD Con Php, PDO, Ajax y DataTables.js</h1>
        <h1 class="text-center">By Cristian Martinez</h1>

        <div class="row">
            <div class="col-2 offset-10">
                <div class="text-center">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#modalUsuario" id="botonCrear">
                        <i class="bi bi-plus-circle-fill"></i>Crear
                    </button>
                </div>
            </div>
        </div>

        <br>
        <br>
        <div class="table-responsive">
            <table id="datos_usuario" class="table table-bordered table-stripered">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Telefono</th>
                        <th>Email</th>
                        <th>Imagen</th>
                        <th>Fecha Creacion</th>
                        <th>Editar</th>
                        <th>Borrar</th>
                    </tr>
                </thead>
            </table>

        </div>

    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalUsuario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Crear Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="POST" id="formulario" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-body">
                            <label for="nombre">Ingrese el Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control">
                            <br>

                            <label for="apellido">Ingrese los apellidos</label>
                            <input type="text" name="apellidos" id="apellidos" class="form-control">
                            <br>

                            <label for="telefono">Ingrese el telefono</label>
                            <input type="text" name="telefono" id="telefono" class="form-control">
                            <br>

                            <label for="email">Ingrese el Email</label>
                            <input type="email" name="email" id="email" class="form-control">
                            <br>

                            <label for="imagen">Selecione una Imagen</label>
                            <input type="file" name="imagen_usuario" id="imagen_usuario" class="form-control">
                            <span id="imagen_subida"></span>
                            <br>

                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="id_usuario" id="id_usuario">
                            <input type="hidden" name="operacion" id="operacion">
                            <input type="submit" name="action" id="action" class="btn btn-success" value="Crear">
                        </div>
                    </div>

                </form>
            </div>

        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>




    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#botonCrear").click(function() {
                $("#formulario")[0].reset();
                $(".modal-title").text("Crear Usuario");
                $("#action").val("Crear");
                $("#operacion").val("Crear");
                $("#imagen_subida").html("");
            })

            var dataTable = $('#datos_usuario').DataTable({
                "processing":true,
                "serverSide":true,
                "order":[],
                "ajax": {
                    url: "obtener_registros.php",
                    type: "POST"
                },
                "columnsDefs": [
                    {
                    "targets": [0, 3, 4],
                    "ordertable": false,
                    },
                ]
            });

            $(document).on('submit', '#formulario', function(event){
                event.preventDefault();
                var nombres = $("#nombre").val();
                var apellidos = $("#apellidos").val();
                var telefono = $("#telefono").val();
                var email = $("#email").val();
                var extension = $('#imagen_usuario').val().split('.').pop().toLowerCase();

                if (extension != '') 
                {
                    if (jQuery.inArray(extension, ['gif', 'png', 'jpg', 'jpeg']) == -1) 
                    {
                        alert("FORMATO DE IMAGEN NO VALIDO");
                        $('#imagen_usuario').val('');
                        return false;
                    }
                }

                if (nombres != '' && apellidos != '' && email != '') 
                {
                    $.ajax
                    ({
                        url: "crear.php",
                        method: "POST",
                        data: new FormData(this),
                        contentType: false,
                        processData: false,
                        success: function(data) 
                        {
                            alert(data);
                            $('#formulario')[0].reset();
                            $('#modalUsuario').modal('hide');
                            dataTable.ajax.reload();
                        }
                    });
                } else {
                    alert("ALGUNOS CAMPOS SON OBLIGATORIOS");
                }
            });

        });
    </script>

</body>

</html>