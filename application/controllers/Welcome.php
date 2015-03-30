<?php

/**
 * Our homepage. Show a list of orders for Barker Bob's Burger Bar.
 * 
 * @author jim
 * @author maecst
 * 
 * controllers/Welcome.php
 *
 * ------------------------------------------------------------------------
 */
class Welcome extends Application {

    function __construct()
    {
	parent::__construct();
    }

    //-------------------------------------------------------------
    //  Homepage: show a list of the orders on file
    //-------------------------------------------------------------
    function index()
    {
        // Build a list of orders
        $this->load->helper('directory');
        $files = directory_map('./data/');
        $xml_orders = array();
        
        foreach ($files as $file)
        {
            $path_parts = pathinfo($file);
            $file_name = $path_parts['filename'];
            
            $matching = preg_match("/^[a-zA-Z]+\d+$/", $file_name);
            
            if ($path_parts['extension'] == strtolower('xml') && $matching)
            {
                $customer = $this->order->getOrder($file_name)['customer'];
                $xml_orders[] = array(
                    'order' => ucfirst($file_name),
                    'customer' => $customer
                 );
            }    
        }
        
        // Present the list to choose from
        $this->data['pagebody'] = 'homepage';        
        $this->data['orders'] = $xml_orders;
        $this->render();
    }
    
    //-------------------------------------------------------------
    //  Show the "receipt" for a specific order
    //-------------------------------------------------------------
    function order($filename)
    {
        $order_total = 0.0;
        
        // Build a receipt for the chosen order
        $order = $this->order->getOrder($filename);
        $burgers = $this->order->getBurgers($filename);
        
        // calculate order total
        foreach ($burgers as $burger)
         $order_total += $burger['total']; 
        
        // Present the list to choose from
        $this->data['pagebody'] = 'justone';
        
        $this->data['filename'] = $filename;
        $this->data['customer'] = $order['customer'];
        $this->data['special'] = $order['special'];
        $this->data['type'] = $order['type'];
        $this->data['burgers'] = $burgers;
        $this->data['total'] = $order_total;

        $this->render();
    }
}
