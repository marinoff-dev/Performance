<?php
// this file help to manage the logic under our database actions
class model
{
	// Database object class

	private function conn()
	{
		// Create and return a database connection stream
		require(__DIR__ . '/../config.php');

		$data_base_connector = new PDO('mysql:host=' . $DB_HOST . ';dbname=' . $DB_NAME, $DB_USER, $DB_PASS);
		return $data_base_connector;
	}

	public function getChain()
	{
		// create and save a database object
		$db = $this->conn();
		return $db;
	}

	public function create($table, $field, $values, $data, $separator=',')
	{
		// create and save a database object
		$db = $this->conn();
		$create_request = $db->prepare('INSERT INTO ' . $table . '(' . $field . ') VALUES(' . $values . ')');
		$create_request->execute(explode($separator, $data));
	}
	public function read($table, $field, $limit = 0, $order_by='', $desc='')
	{
		// get and return a database object
		if ($limit == 0) {
			$db = $this->conn();
			$read_request = $db->query('SELECT ' . $field . ' FROM ' . $table . '');
			return $read_request;
		}
		
		else if($limit !=0 AND $order_by!='' AND $desc=='true'){

			$db = $this->conn();
			$read_request = $db->query('SELECT ' . $field . ' FROM ' . $table . ' ORDER BY '.$order_by.' DESC LIMIT '.$limit);
			return $read_request;

		}

		else if($order_by!=''){

			$db = $this->conn();
			$read_request = $db->query('SELECT ' . $field . ' FROM ' . $table . ' ORDER BY '.$order_by.' ASC');
			return $read_request;

		}

		else {
			$db = $this->conn();
			$read_request = $db->query('SELECT ' . $field . ' FROM ' . $table . ' LIMIT '.$limit);
			return $read_request;
		}
	}

	public function read_filter_once($table, $field, $sfield, $value)
	{
		// get and return a database object
		$db = $this->conn();
		$read_request = $db->prepare('SELECT ' . $field . ' FROM ' . $table . ' WHERE ' . $sfield . '=?');
		$read_request->execute(array($value));
		return $read_request;
	}

	public function read_filter_or($table, $field, $sfield1, $sfield2, $values)
	{
		// get and return a database object
		$db = $this->conn();
		$read_request = $db->prepare('SELECT ' . $field . ' FROM ' . $table . ' WHERE ' . $sfield1 . '=? OR ' . $sfield2 . '=?');
		$read_request->execute(explode(',', $values));
		return $read_request;
	}

	public function countAll($table, $field="", $sfield="", $value="")
	{
		if($field!="" AND  $field!="" AND $value!=""){

			$paylod=$this->read_filter_once($table, $field, $sfield, $value);
			return $paylod->rowCount();

		}

		else{
			$paylod = $this->read($table, '*');

		return $paylod->rowCount();
		}
	}
}
// author @Tech Solution Pro
?>