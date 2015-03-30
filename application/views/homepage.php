<div class="row">
    <h3> List of Orders </h3>
       
    <ul>
        {orders}
        <li><a href="/welcome/order/{order}"> {order} for {customer}  </a></li>
        {/orders}
    </ul>
    
    <p> Select an order from the list above to see its receipt. </p>
</div>