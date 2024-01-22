@props(['data','target'])

<table id="currency_table">
    <tr>
        <th>Name</th>
        <th>Signature</th>
        <th>Excange rate</th>
        <th>Surcharge</th>
    </tr>
    @foreach ($data->items() as $item)
        <tr>
            <td>{{$item->name}}</td>
            <td>{{$item->signature}}</td>
            <td>{{$item->rate}}</td>
            <td>{{$item->surcharge}}</td>
            <td><button 
                hx-get="api/currency/{{$item->id}}"
                hx-trigger='click'
                hx-target='#{{$target}}'
                hx-swap="innerHTML">
                SELECT</button></td>
        </tr>
    @endforeach
</table>