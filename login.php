<html lang="es">
    <head>
        <meta>
        <title>Unidad Educativa Particular Trece de Abril</title>
        <link rel="shortcut icon" href="../dist/img/trece_escudo.jpg">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script type="text/javascript" src="dist/jquery-3.4.1.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    </head>
    <style>
        body{
            background: #faffb2;
            /*            background: url('dist/img/bg.jpg');
                        background-repeat: no-repeat;
                        background-position: center;
                        background-size: cover;*/
            
        }
        .card{
            /*background: wheat;*/
            background: #c7d7ff;
            color: white;
            border-radius: 6px;
        }
        h3{
            text-align: center;
            font-family: times new roman;
            color: black;
        }
        form{
            font-family: Times New Roman;
            color: black;
        }
        .input-icono {
            background-image: url('dist/img/acceso.png');
            background-repeat: no-repeat;
            background-position: 4px center;
            background-size: 20px;
            display: flex;
            align-items: center;
            width: 89px;
            padding-left: 28px;
            height: 30px;
            border: blue;
            border-radius: 5px;
        }
    </style>
    <body>
        <div class="container">
            
            <div class="row">
                <div class="col-md-3 col-lg-4"></div>
                <div class="col-md-3 col-lg-4"></div>

                <div class="col-md-6 col-lg-4">
                    <div  style="margin-top: 20%" class="card w-100">
                        <div class="card-body">
                            <div class="text-center"><img class="" width="130px" src="dist/img/trece_escudo2.jpg"></div><br>
                            <div class="card-title text-center"><h3><strong>Iniciar Sesión</strong></h3></div>
                            <form method="POST">
                                <div class="form-group">
                                    <label class=""><strong>Usuario:</strong></label>
                                    <input class="form-control" type="text" name="txtusuario" id="txtusuario">
                                </div>
                                <div class="form-group">
                                    <label><strong>Contraseña:</strong></label>
                                    <input  class="form-control"type="password" name="txtclave" id="txtclave">
                                </div>
                                <center><button type="button" onclick="acceder();" class="input-icono">Acceder</button></center>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <script>
            function acceder() {
                if ($("#txtusuario").val() && $("#txtclave").val()) {
                    $.ajax({
                        url: "dist/ajax/a_usuario.php",
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            usuario: $("#txtusuario").val(),
                            clave: $("#txtclave").val()
                        },
                        success: function (data, textStatus, jqXHR) {
                            if (data.status === "correcto") {
                                window.location.href = "index.php";
                            } else {
                                swal("Inicio de sessión", data.mensaje, "error");
                            }
                        }
                    });
                } else {
                    swal("Aviso", "... por favor ingrese usuario y contraseña !");
                }
            }
        </script>
    </body>
    <script>
    </script>
</html>

