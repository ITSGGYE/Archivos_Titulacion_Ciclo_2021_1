<?php
require_once '../../conexion.php';
require_once '../../vendor/autoload.php';
//require_once __DIR__ . '/../vendor/autoload.php';
// Comprueba si existe una variable de un tipo concreto existe
if (filter_has_var(INPUT_POST, "infoestudiante")) {
    $estudiante = Conexion::buscarRegistro("select * from estudiantes where id=?", [filter_input(INPUT_POST, "infoestudiante")]);
    ?>
    <div class="alert alert-primary" role="alert">
        <b>Año actual del estudiante: <?php echo $estudiante['anio_actual']; ?></b> 
    </div>
    <?php
}

if (filter_has_var(INPUT_POST, "matricular")) {
    $validar = Conexion::buscarRegistro("select * from matriculas where idestudiante=? and anio=?", [
                filter_input(INPUT_POST, "estudiante"),
                date('Y')
    ]);
    if ($validar) {
        $respuesta['status'] = "error";
        $respuesta['mensaje'] = "Este estudiante ya se encuentra matriculado para el año en curso";
    } else {
        if (Conexion::ejecutar("insert into matriculas (idestudiante,anio_curso,curso,doc_completo,fotos,anio)"
                        . " values (?,?,?,?,?,?)",
                        [
                            filter_input(INPUT_POST, "estudiante"),
                            filter_input(INPUT_POST, "anio"),
                            filter_input(INPUT_POST, "curso"),
                            filter_input(INPUT_POST, "documento"),
                            filter_input(INPUT_POST, "foto"),
//                          filter_input(INPUT_POST, "lectivo"),
                            date('Y')
                ])) {
            Conexion::ejecutar("update estudiantes set anio_actual=?, curso=? where id=?", [
                filter_input(INPUT_POST, "anio"),
                filter_input(INPUT_POST, "curso"),
                filter_input(INPUT_POST, "estudiante"),
            ]);
            $respuesta['status'] = "correcto";
            $respuesta['mensaje'] = "Se matriculo estudiante correctamente";
        } else {
            $respuesta['status'] = "error";
            $respuesta['mensaje'] = "Error al matricular intentelo mas tarde";
        }
    }
    echo json_encode($respuesta);
}

if (filter_has_var(INPUT_POST, "completar")) {
    $respuesta;
    $id = filter_input(INPUT_POST, "completar");
    if (Conexion::ejecutar("update matriculas set doc_completo='1', fotos='1' where id=? ", [$id])) {
        $respuesta['status'] = "correcto";
        $respuesta['mensaje'] = "Se completo documentos";
    } else {
        $respuesta['status'] = "error";
        $respuesta['mensaje'] = "Error al completar documentos";
    }

    echo json_encode($respuesta);
}

if (filter_has_var(INPUT_POST, "preciopension")) {
    $matricula = Conexion::buscarRegistro("select * from matriculas m "
                    . " inner join precios p on m.anio_curso=p.anio "
                    . " where m.anio=? and idestudiante=?", [date('Y'), filter_input(INPUT_POST, "preciopension")]);
    if ($matricula) {
        echo '<div class="alert alert-primary" role="alert">
 El precio de la pensión para el año  <b>' . $matricula['anio_curso']. $matricula['curso'].'</b> es de : <b>$' . $matricula['precio'] . '</b>
</div>';
        echo "<input type='hidden' id='valor' value='{$matricula['precio']}'>";
    } else {
        echo '<div class="alert alert-warning" role="alert">
  No se encontro información de matricula del estudiante.
</div>';
    }
}


if (filter_has_var(INPUT_POST, "cobrarpension")) {

    $respuesta;
    $validar = Conexion::buscarRegistro("select * from cobros"
                    . " where estado='1' and anio=? and mes=? and idestudiante=?", [
                date('Y'),
                filter_input(INPUT_POST, "mes"),
                filter_input(INPUT_POST, "cobrarpension")
    ]);
    if ($validar) {
        $respuesta['status'] = "error";
        $respuesta['mensaje'] = "La pensión de este mes ya ha sido cancelada.";
    } else {
        Conexion::ejecutar("insert into cobros (idestudiante,anio,mes,valor) values (?,?,?,?)", [
            filter_input(INPUT_POST, "cobrarpension"),
            date('Y'),
            filter_input(INPUT_POST, "mes"),
            filter_input(INPUT_POST, "valor")
        ]);
        $respuesta['status'] = "correcto";
        $respuesta['mensaje'] = "Se ha registrado el pago de la pensión.";
    }
    echo json_encode($respuesta);
}

if (filter_has_var(INPUT_POST, "pdfmatricula")) {
    $idmatricula = filter_input(INPUT_POST, "pdfmatricula");
    $matricula = Conexion::buscarRegistro("select m.id,e.nombres"
                    . ",e.apellidos,m.fecha,m.anio_curso,m.curso,e.identificador"
                    . " from matriculas m inner join estudiantes e on e.id=m.idestudiante"
                    . " where m.id=?", [$idmatricula]);
    $mpdf = new \Mpdf\Mpdf();
    $mpdf->WriteHTML('<img src="/sistema_matricula/dist/img/encabezado.png" alt="" height="150px">'.'<div style="text-align:center"><h2>Certificado de Matricula</h2></div>'
            
            . '<table style="autosize:2.4;">'
            . '<tr>'
            . '<th>Fecha Matricula: </th>'
            . '<td>' . $matricula['fecha'] . '</td>'
            . '</tr>'
            . '<tr>'
            . '<th style="border-top:1px;">Curso Matricula: </th>'
            . '<td>' . $matricula['anio_curso'] . ' / ' . $matricula['curso'] . '</td>'
            . '</tr>'
            . '</table><br>'
            . '<div><h3>Información del Estudiante</h3></div>'
            . '<table style="autosize:2.4;">'
            . '<tr>'
            . '<th style="text-align:left">Nombres: </th>'
            . '<td>' . $matricula['nombres'] . '</td>'
            . '</tr>'
            . '<tr>'
            . '<th style="border-top:1px;text-align:left">Apellidos: </th>'
            . '<td>' . $matricula['apellidos'] . '</td>'
            . '</tr>'
            . '<tr>'
            . '<th style="border-top:1px;">Identificador: </th>'
            . '<td>' . $matricula['identificador'] . '</td>'
            . '</tr>'
            . '</table><br>'
            . '<div><b>información: </b>Este documento certifica que usted se encuentra matriculado en la institución educativa "Escuela Particular Maximo Agustin Rodriguez".</div>'
            .'<img src="/sistema_matricula/dist/img/pie_de_pagina.png" alt="" height="150px">');
    $mpdf->Output();
//    $mpdf->Output('matricula.pdf', 'D');
}



//ver matricula

