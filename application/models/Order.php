<?php
class Order extends CI_Model {

        // constructor
        function __construct() {
            parent::__construct();
            $this->number = 0;
            $this->datetime = null;
            $this->items = array();
        }
}