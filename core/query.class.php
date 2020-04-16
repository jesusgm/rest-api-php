<?php
    define("SELECT", "SELECT");
    define("UPDATE", "UPDATE");
    define("DELETE", "DELETE");
    define("INSERT", "INSERT");
    

    class Query {
        var $type = "";
        var $table = "";
        var $tableAlias = "";
        var $columns = [];
        var $rawColumns = "";
        var $values = [];
        var $where = [];
        var $orWhere = [];
        var $order = "";
        var $limit = "";
        var $joins = [];
        var $groups = [];
        
		function select() {
			$this->type = SELECT;
        }

        function update($values) {
            $this->type = UPDATE;
            $this->values = $values;
        }
        function insert($values) {
            $this->type = INSERT;
            $this->values = $values;
        }

        function delete() {
            $this->type = DELETE;
        }
        
        function table($table, $alias = "") {
            $this->table = $table;
            $this->tableAlias = $alias;
        }

        function columns($columns) {
            $this->columns = $columns;
        }
        
        function rawColumns($rawColumns) {
            $this->rawColumns = $rawColumns;
        }

        function where($where) {
            $this->where = $where;
        }

        function orWhere($orWhere) {
            $this->orWhere = $orWhere;
        }

        function order($order) {
            $this->order = $order;
        }

        function groupBy($groups) {
            $this->groups = $groups;
        }

        function limit($limit) {
            $this->limit = $limit;
        }

        function leftJoin($table, $alias = "", $on){
            $this->joins[] = array(
                                    "type" => "LEFT JOIN", 
                                    "table" => "`".$table."`",
                                    "alias" => $alias,
                                    "on" => $on
                                );
        }

        function rightJoin($table, $alias, $on){
            $this->joins[] = array(
                                    "type" => "RIGHT JOIN", 
                                    "table" => "`".$table."`",
                                    "alias" => $alias,
                                    "on" => $on
                                );
        }


        function build() {
            $queryString = "";
            switch($this->type) {
                case SELECT:
                    $queryString = "SELECT ";
                    if(count($this->columns)) {
                        foreach($this->columns as $alias => $column){
                            $columns_arr[]= $alias . ".".$column;
                        }
                        $queryString .= implode($columns_arr, ", ");                            
                        
                    } else {
                        if($this->rawColumns != ""){
                            $queryString .= $this->rawColumns;
                        }else{
                            $queryString .= "*";
                        }
                    }

                    $queryString .= " FROM `".$this->table."`";
                    if($this->tableAlias){
                        $queryString .= " AS ".$this->tableAlias." ";
                    }

                    if(count($this->joins)){
                        foreach($this->joins as $join){
                            $queryString .= $join['type'] . " " . $join['table'] . " AS ".$join['alias']." ON " . $join['on'] ." ";
                        }
                    }
                    break;
                case INSERT:
                    $queryString = "INSERT INTO `".$this->table."` (`".implode($this->columns, "`, `")."`)";
                    $queryString .= " VALUES (".implode($this->values, ",").") ";
                    break;
                case UPDATE:
                    $queryString = "UPDATE `".$this->table."`";
                    $queryString .= " SET ";
                    
                    $map = array();
                    for($i = 0; $i < count($this->columns); $i++){
                        $map[] = "`".$this->columns[$i] . "`=" . $this->values[$i];
                    }

                    $queryString .= implode($map, ", ");
                    break;
                case DELETE:
                    $queryString = "DELETE FROM `".$this->table."`";
                    break;
            }

            if(count($this->where) || count($this->orWhere)){
                $queryString .= " WHERE ";
            }

            if(count($this->where)){
                $queryString .= "(" . implode($this->where, " AND ") .")";
            }

            if(count($this->orWhere)){
                if(count($this->where)){
                    $queryString .= " AND ";
                }
                $queryString .= "(" . implode($this->orWhere, " OR ") . ")";
            }

            if(count($this->groups)){
                $queryString .= "GROUP BY " . implode($this->groups, ",");
            }

            if($this->order != ""){
                $queryString .= " ORDER BY " . $this->order;
            }

            if($this->limit != ""){
                $queryString .= " LIMIT " . $this->limit;
            }


            return $queryString . ";";
        }
        
	}
?>