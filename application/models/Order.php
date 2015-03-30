<?php

/**
 * This is a model for data displayed on a restaurant's receipt.
 *
 * @author maecst
 */
class Order extends CI_Model {

    protected $xml = null;

    // Constructor
    public function __construct() 
    {
        parent::__construct();
    }

    // retrieve burger info from corresponding xml file
    function getBurgers($file) 
    {    
        $this->xml = simplexml_load_file(DATAPATH . $file . '.xml');
        
        $count = 0;                 // number of burgers in order
        $burger_price = 0.0;        // cumulated price of each burger

        $order = array();
        $burgers = $this->xml->burger;
        
        foreach ($burgers as $b)
        {
            $toppings_price = 0.0;
            
            $burger = array();
            $patty = $this->menu->getPatty((string)$b->patty['type']);
            $t_cheese = $this->menu->getCheese((string)$b->cheeses['top']);
            $b_cheese = $this->menu->getCheese((string)$b->cheeses['bottom']);
            $toppings = "";
            $sauces = "";
            $instructions = $b->instructions;            
            
            // populate lists for toppings and sauces
            foreach ($b->topping as $topping) 
            {             
                $a_topping = $this->menu->getTopping((string)$b->topping['type']);
                $toppings .= $topping['type'] . ', ';
                
                if (isset($a_topping))
                   $toppings_price += $a_topping->price;
            }
            foreach ($b->sauce as $sauce) 
                $sauces .= $sauce['type'] . ', ';

            // get prices and update burger price
            $burger_price += (float) $patty->price;
            if (isset($t_cheese)) 
                $burger_price += (float) $t_cheese->price;
            if (isset($b_cheese))
                $burger_price += (float) $b_cheese->price;                
            $burger_price += (float) $toppings_price;

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

        return $order;
    }
}
