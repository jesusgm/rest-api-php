<?php
    require_once __DIR__.'/../Models/StatusModel.php';
    require_once __DIR__.'/../core/Controller.php';
    /**
    * The home page controller
    */
    class StatusController extends Controller
    {
        // private $model;

        function __construct() {
            $this->model = new StatusModel();
        }

        public function index($params) {
            header('Content-Type: application/json');
            echo json_encode($this->model->getAll());
        }
        
        public function get($param) {
            header('Content-Type: application/json');
            if($param){
                echo json_encode($this->model->getById($param));
            } else {
                echo json_encode($this->model->getAll());
            }
        }

    }
