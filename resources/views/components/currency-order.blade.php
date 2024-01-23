<div class='success'>
    <p>Order Success:</p>
    <ul>
        <li>Currency: {{$order->currency->name}}</li>
        <li>Amount of {{$order->currency->name}} purchased: {{$order->amount_purchased}}</li>
        <li>Amount in usd paid: ${{round($order->amount_usd, 4)}}</li>
        <li>Excange rate: {{$order->rate}}</li>
        <li>Surcharge percentage: {{$order->surcharge_percentage}}%</li>
        <li>Surcharge amount: ${{round($order->surcharge_amount,4)}}</li>
        <li>Discount percentage: {{$order->discount_percentage}}%</li>
        <li>Discount amount: ${{round($order->discount_amount,4)}}</li>
    </ul>
</div>