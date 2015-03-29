<?php

/**
 * This is a model for data displayed on a restaurant's receipt.
 *
 * @author maecst
 */
class Order extends CI_Model {

    protected $xml = null;

    // Constructor
    public function __construct() {
        parent::__construct();
    }

    // retrieve an order
    function getBurgers($file) {
        
        $this->xml = simplexml_load_file(DATAPATH . 'order' . $file . '.xml');
        $count = 0;

        $order = array();
        $burgers = $this->xml->burger;
        
        foreach ($burgers as $b)
        {
            $burger = array();
            $toppings = "";
            $sauces = "";
            $instructions = $b->instructions;
                        
            foreach ($b->topping as $topping) {               
                $toppings .= $topping['type'] . ', ';
            }

            foreach ($b->sauce as $sauce) {
                $sauces .= $sauce['type'] . ', '; 
            }
            
            $toppings = substr($toppings, 0, -2);
            $sauces = substr($sauces, 0, -2);
            
            if ($toppings == "")
                    $toppings = "(none)";
            if ($sauces == "")
                    $sauces = "(none)";
            if ($instructions == "")
                    $instructions = "(none)";
            
            
            $burger['count'] = ++$count;
            $burger['patty'] = $b->patty['type'];
            $burger['top-cheese'] = $b->cheeses['top'];
            $burger['bottom-cheese'] = $b->cheeses['bottom'];
            $burger['toppings'] = $toppings;         
            $burger['sauces'] = $sauces;
            $burger['instructions'] = $instructions;
            $burger['name'] = $b->name;
            
            $order[] = $burger;
        }
        
        return $order;
    }
    
    function getOrder($file)
    {
        $order = array();
        
        $this->xml = simplexml_load_file(DATAPATH . 'order' . $file . '.xml');
        
        $order['customer'] = $this->xml->customer;
        $order['filename'] = $file;
        $order['type'] = $this->xml['type'];
        $order['special'] = $this->xml->special;

        return $order;
    }
    
    
}
