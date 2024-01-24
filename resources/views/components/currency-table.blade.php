<table id="currency_table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Signature</th>
            <th>Excange rate</th>
            <th>Surcharge</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data->items() as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>{{ $item->signature }}</td>
                <td>{{ $item->rate }}</td>
                <td>{{ $item->surcharge }}</td>
                <td><button hx-get="api/currencies/{{ $item->id }}" hx-trigger='click'
                        hx-target='#buy_currency_placeholder' hx-swap="innerHTML">
                        SELECT</button></td>
            </tr>
        @endforeach
    </tbody>
</table>
<div id="pagination">
    @if ($data->previousPageUrl())
        <button hx-get="{{ $data->previousPageUrl() }}" hx-trigger="click" hx-target='#table-placeholder'>
            << </button>
    @endif

    <div>Page: {{ $data->currentPage() }}</div>
    @if ($data->nextPageUrl())
        <button hx-get="{{ $data->nextPageUrl() }}" hx-trigger="click" hx-target='#table-placeholder'>>></button>
    @endif
</div>
