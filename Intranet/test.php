<?php 
require "data/class_sql_manager.php";
$sql_manager = new SqlManager();
if($sql_manager->is_conected()){

 $sql_manager->query = "select * from TA_NOTICIA ;" ;
 $sql_manager->ejecutar();
 echo "Conectado";
    
}
else
    echo "error";



?>