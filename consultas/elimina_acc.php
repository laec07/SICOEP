<?php
include("../conexion.php");

$eq=$_GET['ID'];
$elimi=mysqli_query($conexion, "DELETE FROM accesorios where ID='$eq'    ");

if(!$elimi)
{
	print "<SCRIPT languaje='javascript'> 
            alert('No es posible eliminar registro');
            history.go(-1); 
            </SCRIPT> 
            ";
}
else
{
print "<SCRIPT languaje='javascript'> 
            history.go(-1);
            </SCRIPT> 
 ";           
}

?>
