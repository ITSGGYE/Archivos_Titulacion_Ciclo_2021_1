<?php
require './conexion.php';
require_once './constantes.php';
if (!isset($_SESSION['u']['usuario'])) {
    session_start();
}
if (!isset($_SESSION['u']['usuario'])) {
    header("Location: login.php");
}
iniciarPagina();
$objConexion = new Conexion();
$conexion = $objConexion::obtenerConexion();
$query = "SELECT MAX(cod_lectivo)AS lectivo FROM lectivo";
$stmt = $conexion->prepare($query);
$stmt->execute();
$periodo_lectivo = $stmt->fetch();
$mensaje = "Periodo lectivo en curso"." ".$periodo_lectivo['lectivo'];

//$query2="SELECT MAX(institucion)AS registro FROM registro_general";
$query2="SELECT registro_general.institucion AS registro FROM registro_general ORDER BY id DESC";
$stmt2=$conexion->prepare($query2);
$stmt2->execute();
$nombre=$stmt2->fetch();
$escuela="Unidad Educativa Particular"." ".$nombre['registro'];
?>
<style>
    h1{
       border-radius: 8px;
       height: 50px;
       font-family: times new roman;
       display: flex;
       justify-content: center;
       flex-direction: column;
       size: 18px;
       color:white;
       background: #8da1dd;
    }
h2{
    height: 50px;
    font-family: times new roman;
}
img{
    border-radius: 6px;
}
</style>
<div class="container" >
    <br>
    <div class="text-center">
        <h1><strong>Sistema de Matriculación</strong> </h1><hr>
        <br>
        <h2><?php echo $escuela;?></h2>
        <h2> <?php echo $mensaje; ?></h2>
        <div class="text-center">
            <img width="600px" src="./dist/img/trece_uno.jpg" class="img-fluid" alt="Responsive image">
            <br><br> 
            <p> ꧁꧁"𝔏𝔞 𝔪𝔬𝔱𝔦𝔳𝔞𝔠𝔦ó𝔫 𝔢𝔰 𝔩𝔬 𝔮𝔲𝔢 𝔱𝔢 𝔭𝔬𝔫𝔢 𝔢𝔫 𝔪𝔞𝔯𝔠𝔥𝔞, 𝔢𝔩 𝔥á𝔟𝔦𝔱𝔬 𝔢𝔰 𝔩𝔬 𝔮𝔲𝔢 𝔥𝔞𝔠𝔢 𝔮𝔲𝔢 𝔰𝔦𝔤𝔞s"꧂꧂</p>
        </div>
    </div>
</div>
