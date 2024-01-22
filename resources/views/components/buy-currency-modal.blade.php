@props(['currency'])

<div class="modal-window">
    <ul>
        <li>Name: {{ $currency->name }}</li>
        <li>Signature: {{ $currency->signature }}</li>
        <li>Excange rate: {{ $currency->rate }}</li>
        <li>Surcharge:{{ $currency->surcharge }}%</li>
    </ul>
    <p>Enter amount</p>
    <input hx-get="api/currency/{{ $currency->id }}/calculate-price" hx-trigger='input' hx-target='#price-display'
        hx-swap="innerHTML" hx-include="#amount" class='centered' name="amount" type="number" id="amount"
        placeholder="Amount"
        />
    <br>
    <div id="price-display"></div>
    <br>
    <button
        class='centered'
        hx-post="api/currency/{{$currency->id}}/buy"
        hx-include="#amount"
        hx-confirm="Are you sure you want to buy the entered amount of {{$currency->name}}?">BUY</button>
</div>
