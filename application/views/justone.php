<div class="row">

    <h3> {filename} for {customer} ({type}) </h3>
    
    <p>Order Notes: <em>{special}</em> </p>
    
    {burgers}
    <br>
    <h4><strong> * * * * * * * * * &nbsp;&nbsp; Burger # {count} &nbsp;&nbsp; * * * * * * * * * </strong></h4>

    <table>
        <tr>
            <td width="4%"> Base: </td>
            <td width="30%"> {patty} </td>
        </tr>
        <tr>
            <td> Cheeses: </td>
            <td> {top-cheese} {bottom-cheese} </td>
        </tr>
        <tr>
            <td> Toppings: </td>
            <td> {toppings} </td>
        </tr>
        <tr>
            <td> Sauces: </td>
            <td> {sauces}
        <tr>
            <td> Instructions: </td>
            <td> {instructions} </td>
        </tr>
        <tr>
            <td> &nbsp;</td>
        </tr>
        <tr>
            <td> Burger total: </td>
            <td> $ {total} </td>
        </tr>
    </table>
    {/burgers}
    
    <br>
    <h4><strong> 
        * * * * * * * * * * * * * * * * * * * * * * * * * * * * <br>
        Order TOTAL:  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $ {total} <br>
        * * * * * * * * * * * * * * * * * * * * * * * * * * * * <br>
    </strong></h4>
    
    <p><a href="/welcome"> Back to List of Orders </a></p>
    
</div>