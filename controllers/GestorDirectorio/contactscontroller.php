<?php 
require "../data_access/class_sql_manager.php";

function registrar_contacto(){
      
      
    $sql_manager = new SqlManager();
    if($sql_manager->is_conected()){

         $sql_manager->query = "insert into TA_CONTACTO ".
             "values(".
             "NULL,1,1,'image.jpg','persona',".
             "'".$_POST['name']."  ".$_POST['apel']."',".
             "'".$_POST['ema']."',".
             "'".$_POST['tel']."',".
             "'".$_POST['dir']."'".
             ");" ;
         //echo $sql_manager->query ;
         $sql_manager->ejecutar();

        if($sql_manager->get_result()){
            echo "Ingresado";
        }
            else 
                echo "Hubo un error";
        
        $sql_manager->Close();
    }
    else
        echo "No conectado";
    
    
}
function mostrar_contactos(){
      
    $sql_manager = new SqlManager();
    if($sql_manager->is_conected()){

         $sql_manager->query = "select * from TA_CONTACTO;";
        
         //echo $sql_manager->query ;
         $sql_manager->ejecutar();

         $array = array();
         if($sql_manager->get_num_rows()>0)
         {
             for($i = 0; $i< $sql_manager->get_num_rows();$i++){
                 $change = array('name' => $sql_manager->get_value_at_pos(5), 
                                 'email' => $sql_manager->get_value_at_pos(6), 
                                 'tel' => $sql_manager->get_value_at_pos(7),
                                'dir' => $sql_manager->get_value_at_pos(8));
                $sql_manager->next_row();
                array_push($array,$change);
             }
            $sql_manager->Close();
            echo json_encode($array);
         }
         else{
             $sql_manager->Close();
             echo "0";   // no registros
         }
             

        
    }
    else
        echo "-1"; // no conectado
    
    
}


if (isset($_GET['fname'])){
    
    if($_GET['fname'] == "registrar"){
       registrar_contacto();
    }
    if($_GET['fname'] == "buscar"){
       mostrar_contactos();
    }
    
    
    
    
    
    
}
else
    return 0;



?>