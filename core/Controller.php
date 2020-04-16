<?php
    /**
    * The core controller
    */
    class Controller {
        public function index($params) {
            return "index method";
        }

        public function add($params) {
            echo "add method";
        }

        public function update($params) {
            echo "update method";
        }

        public function delete($params) {
            echo "delete method";
        }

        public function get($params) {
            echo "get method";
        }
    }
