<?php

/**
 * This is a model for data displayed on a restaurant's receipt.
 *
 * @author maecst
 */
class Order extends CI_Model {

    protected $xml = null;
    protected $order_total = 0.0;

    // Constructor
    public function __construct() {
        parent::__construct();
    }

    // retrieve burger info from corresponding xml file
    function getBurgers($file) {
        
        $this->xml = simplexml_load_file(DATAPATH . $file . '.xml');
        $count = 0;
        
        $burger_price = 0.0;

        $order = array();
        $burgers = $this->xml->burger;
        
        foreach ($burgers as $b)
        {
            $burger = array();
            $patty = $this->menu->getPatty((string)$b->patty['type']);
            $t_cheese = $this->menu->getCheese((string)$b->cheeses['top']);
            $b_cheese = $this->menu->getCheese((string)$b->cheeses['bottom']);
            $toppings = "";
            $sauces = "";
            $instructions = $b->instructions;
            
            $burger_price += (float)$patty->price;
            $burger_price += (float) $t_cheese->price;
            $burger_price += (float) $t_cheese->price;
            
            // populate lists for toppings and sauces
            foreach ($b->topping as $topping) {               
                $toppings .= $topping['type'] . ', ';
                $burger_price += $topping['price'];
            }
                
            foreach ($b->sauce as $sauce) {
                $sauces .= $sauce['type'] . ', ';
                $burger_price += $sauce['price'];
            }
            

            
            // remove the last comma and space
            $toppings = substr($toppings, 0, -2);
            $sauces = substr($sauces, 0, -2);
            
            // if these values are empty, display them as "none"
            if ($toppings == "")
                    $toppings = "(none)";
            if ($sauces == "")
                    $sauces = "(none)";
            if ($instructions == "")
                    $instructions = "(none)";
            
            $this->order_total += $burger_price;
            
            $burger['count'] = ++$count;
            $burger['patty'] = $b->patty['type'];
            $burger['top-cheese'] = $b->cheeses['top'];
            $burger['bottom-cheese'] = $b->cheeses['bottom'];
            $burger['toppings'] = $toppings;         
            $burger['sauces'] = $sauces;
            $burger['instructions'] = $instructions;
            $burger['name'] = $b->name;
            $burger['total'] = $burger_price;
            
            $order[] = $burger;
        }
        
        return $order;
    }
    
    // retrieve order from corresponding xml file
    function getOrder($file)
    {
        $order = array();
        
        $this->xml = simplexml_load_file(DATAPATH . $file . '.xml');
        
        $order['customer'] = $this->xml->customer;
        $order['filename'] = $file;
        $order['type'] = $this->xml['type'];
        $order['special'] = $this->xml->special;
        $order['total'] = $this->order_total;

        return $order;
    }
}
