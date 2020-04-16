<?php
require_once __DIR__ . '/../core/Model.php';
require_once __DIR__ . '/../core/query.class.php';
/**
 * The home page model
 */
class StatusModel extends Model
{
    private $table = "";
    private $dbcon;

    function __construct()
    {
        $this->table = "states";
        $this->dbcon = parent::__construct($this->table);
    }

    public function getAll()
    {
        $query = new Query();
        $query->table($this->table);
        $query->select();

        $sql = $query->build();

        if (!$this->dbcon) {
            die("No se pudo ejecutar con exito la consulta ($sql) en la BD");
        }

        $result = $this->dbcon->query($sql);

        // print_r($result);
        // die();

        if (!$result) {
            echo "No se pudo ejecutar con exito la consulta ($sql) en la BD: " . mysqli_error($this->dbcon);
            exit;
        }

        if (mysqli_num_rows($result) == 0) {
            echo "No se han encontrado filas, nada a imprimir, asi que voy a detenerme.";
            exit;
        }

        $data = array();
        while ($fila = mysqli_fetch_assoc($result)) {
            $data[] = $fila;
        }

        mysqli_free_result($result);

        return $data;
    }
    
    public function getById($id)
    {
        $query = new Query();
        $query->table($this->table);
        $query->select();
        $query->where(["id = " . $id]);

        $sql = $query->build();

        if (!$this->dbcon) {
            die("No se pudo ejecutar con exito la consulta ($sql) en la BD");
        }

        $result = $this->dbcon->query($sql);
        
        if (mysqli_num_rows($result) == 0) {
            return [];
        }

        $data = array();
        while ($fila = mysqli_fetch_assoc($result)) {
            $data[] = $fila;
        }

        mysqli_free_result($result);
        
        return $data[0];
    }
    
}
