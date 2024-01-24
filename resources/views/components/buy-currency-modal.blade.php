@props(['currency'])

<div class="modal-window">
    
    <ul>
        <li>Name: {{ $currency->name }}</li>
        <li>Signature: {{ $currency->signature }}</li>
        <li>Excange rate: {{ $currency->rate }}</li>
        <li>Surcharge:{{ $currency->surcharge }}%</li>
    </ul>
    <p>Enter amount</p>
    <input min="1" max="100000" hx-get="api/currencies/{{ $currency->id }}/calculate-price" hx-trigger='input' hx-target='#price-display' hx-target-4*='#notification_placeholder'
        hx-swap="innerHTML" hx-include="#amount" class='centered' name="amount" type="number" id="amount"
        placeholder="Amount"
        />
    <br>
    <p>Price: $</p><p id="price-display">0</p>
    <br>
    <button
        class='centered'
        hx-post="api/currencies/{{$currency->id}}/buy"
        hx-include="#amount"
        hx-target='#notification_placeholder'
        hx-confirm="Are you sure you want to buy the entered amount of {{$currency->name}}?">BUY</button>

    <div id="notification_placeholder"></div>
</div>
