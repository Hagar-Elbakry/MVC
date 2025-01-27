<?php

trait Model {
    use Database;

    public function findAll() {
        $query = "SELECT * FROM $this->table";
        return $this->query($query);
    }

    public function where($data , $data_not = []) {
        $keys = array_keys($data);
        $keys_not = array_keys($data_not);
        $query = "SELECT * FROM $this->table WHERE ";
        foreach($keys as $key) {
            $query .= $key . " = :" . $key . '&&';
        }

        foreach($keys_not as $key) {
            $query .= $key . " != :" . $key . '&&';
        }

         $query = trim($query, '&&');

        $data = array_merge($data, $data_not);
        return $this->query($query, $data);
    }

    public function first($data, $data_not = []) {
        $keys = array_keys($data);
        $keys_not = array_keys($data_not);
        $query = "SELECT * FROM $this->table WHERE ";
        foreach($keys as $key) {
            $query .= $key . " = :" . $key . '&&';
        }

        foreach($keys_not as $key) {
            $query .= $key . " != :" . $key . '&&';
        }

         $query = trim($query, '&&');

        $data = array_merge($data, $data_not);
        $reslult = $this->query($query, $data);
        if($reslult) {
            return $reslult[0];
        }

        return false;
    }

    public function insert($data) {
        if(!empty($this->allowedColumns)) {
            foreach($data as $key) {
                if(!in_array($key, $this->allowedColumns)) {
                    unset($data[$key]);
                }
            }
        }
        $keys = array_keys($data);

        $query = "INSERT INTO $this->table (" . implode(',', $keys) . ") VALUES (:" . implode(',:', $keys) . ")";
        $this->query($query, $data);
        return false;
    }

    public function update($id, $data, $id_column = 'id') {
        
        if(!empty($this->allowedColumns)) {
            foreach($data as $key) {
                if(!in_array($key, $this->allowedColumns)) {
                    unset($data[$key]);
                }
            }
        }
        $keys = array_keys($data);

        $query = "UPDATE $this->table SET ";
        foreach($keys as $key) {
            $query .= $keys . " = :" . $key . ", ";
        }

        $query = trim($query, ',');
        $query .= "WHERE $id_column = :$id_column";
        $data[$id_column] = $id; 
        $this->query($query, $data);
        
        return false;
    }

    public function delete($id, $id_column = 'id') {
		$data[$id_column] = $id;
		$query = "DELETE FROM $this->table WHERE $id_column = :$id_column";

        $this->query($query, $data);

        return false;
	}


}