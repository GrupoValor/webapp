<?php 
//CLASS SQL MANAGER
	class SqlManager 
	{
    //ATRIBUTOS

		public $query;     // String : Cosulta
		private $conected;  // Bool : estado conexion
		private $conection; // mysqli : MySQl Conexion 
		public $result;    // mysqliresult : Resultado consulta
		private $registros; // Array : Registros
		private $code_error;
	//COSTRUCTOR
		function __construct()
		{
			$this->query="";
			// Prueba conexion
			$this->conected = $this->conection_test(); 
		}
	//METODOS
		// CONEXION PRINCIPAL
		public function conection_test()
		{
			require 'db_user.php';
			/* 
			'db_user.php';
			$db_server;  <servidor>
			$db_database; <nombre base datos>
			$db_user; <usuario>
			$db_password; <password>
			*/
			$this->conection =  new mysqli($db_server,
											$db_user,
											$db_password,
											$db_database);
			// Prueba conexion
			if (mysqli_connect_errno())
				return False; // Error de conexion
			return True; // Conexion exitosa
		}
		// ESTADO CONEXION
		public function is_conected()
		{
			return $this->conected;
		}

	//CONSULTAS 

		// SELECT 
		public function select_from($atrib,$table,$where = "")
		{
			$this->query = "SELECT ".$atrib." FROM ". $table; 
			// SELECT * FROM <TABLA> ...
			if($where != "")
				$this->query .= " WHERE ". $where;
				// SELECT * FROM <TABLA> WHERE <SENTENCIA WHERE>
			//Ejecutar la consulta 
			$this->result = $this->conection->query($this->query);
			//Verificar Estado resultado
			if($this->result)
				// Obtener campos : Array 
				$this->registros = $this->result->fetch_array(MYSQL_NUM);
		}
		// UPDATE 
		public function update($table,$column,$data,$where)
		{
			$this->query = "UPDATE ". $table ." SET ". $column ."='".$data."'"; 
			// UPDATE <TABLA> SET <COLUMN> = <DATA> ...
			$this->query .= " WHERE ". $where;
				// UPDATE <TABLA> SET <COLUMN> = <DATA>  <SENTENCIA WHERE>
			//Ejecutar la consulta 
			$this->result = $this->conection->query($this->query);
			//Verificar Estado resultado
		}
		// obtener dato : columna 
		public function get_value_at($column_name)
		{
			// VALUE = REGISTROS [ <NOMBRE COLUMNA>]
			return $this->registros[$column_name];
		}
		public function next_row(){
			$this->registros = $this->result->fetch_array(MYSQL_NUM);
		}
		// INSERT
		public function insert_into($table)
		{
			// INSERT INTO <TABLA> VALUES (...
			$this->query = "INSERT INTO ". $table . " VALUES (";
		}
		//Agregar VALUE text
		public function value($value, $fin = False){
			// INSERT INTO <TABLA> VALUES ( '<VALUE>',...
			// Limpiar dato consulta
			$value = $this->flush_value($value);
			$this->query .= "'".$value."'";
			// End Of Query $fin = True
			$this->e_o_q($fin);
			// INSERT INTO <TABLA> VALUES ( '<VALUE>',..'<VALUE>'');
		}
		//Agregar VALUE int
		public function value_int($value, $fin = False)
		{
			// INSERT INTO <TABLA> VALUES ( <VALUE_INT>,...
			$this->query .= $value;
			// End Of Query $fin = True
			$this->e_o_q($fin);
		}

		// Fin de consulta 
		public function e_o_q($fin){
			if(!$fin) // False ->  '<VALUE>',
				$this->query .= ",";
			else      // False ->  '<VALUE>);,
			{
				$this->query .= ");";
				// Ejecutar Consulta
				$this->result = $this->conection->query($this->query); 
			}
		}
        public function ejecutar(){
			 $this->result = $this->conection->query($this->query);
            
			if(isset($this->result->num_rows))
				$this->registros = $this->result->fetch_array(MYSQL_NUM);
			
		}
        
		
		public function CALL($_query){
			 $this->query = $_query;
			 $this->result = $this->conection->query($this->query);
			//if($this->result)
				// Obtener campos : Array 

			
		}
		
		// Limpiar dato consulta
		public function flush_value($value)
		{
			return mysqli_real_escape_string($this->conection,$value);
		}

	// DELETE 
		public function delete_from($table,$where = "")
		{
			$this->query = "DELETE FROM ". $table; 
			// SELECT * FROM <TABLA> ...
			if($where != "")
				$this->query .= " WHERE ". $where;
				// SELECT * FROM <TABLA> WHERE <SENTENCIA WHERE>
			//Ejecutar la consulta 
			$this->conection->query($this->query);
		}

		public function EXECUTE_PROCEDURE($NAME_PROCEDURE,$PARAMETERS){
				$length = count($PARAMETERS);

				$this->query = "CALL ". $NAME_PROCEDURE ."(";
				if($length == 0)
					$this->query .= ")";
				// Parametros (...)
				for ($i = 0 ; $i < $length ; $i++) 
				{
    				$this->query .= "'".$PARAMETERS[$i]."'" ;
    				if($i == $length -1 )
    					$this->query .= ")";
					else
						$this->query .= ",";
				}

				//Ejecutar el procedimiento
				$this-> ejecutar();
				if ( $this->result )
					return "EXECUTE_OK";
				$this->code_error = mysqli_errno($this->conection);
				return " EXECUTE_FAIL : ". mysqli_error($this->conection);

		}

	//	GETTERS
		// Ver consulta
		public function show_query()
		{
			return $this->query;
		}
		public function show_code_error()
		{
			return $this->code_error;
		}
		// Ver resultado consulta
		public function get_result(){
			if(!$this->result )
			{ 
				
				// Error consulta 
				return False;
			}

			return True; // Consulta correcta
		}
		public function get_result_rows(){
			if($this->result->num_rows == 0)
				return False;
			return True;
		}

		public function get_num_rows(){
			
			return $this->result->num_rows;
		}
		public function my_query($_query){
			$this->query = $_query;
		}
		public function get_num_cols(){
			
			return count($this->registros);
		}
		public function get_value_at_pos($pos){
			
			return $this->registros[$pos];
		}

		public function Get_array(){

			return $this->registros;
		}
        
        public function Close(){

			mysqli_close($this->conection);
		}
	
	}
?>