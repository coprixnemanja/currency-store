@props(['currencies_paginator'])

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Currency Store</title>
    <link href="{{ asset('assets/app.css') }}" rel="stylesheet" type="text/css" >
    <script src="https://unpkg.com/htmx.org@1.9.4" integrity="sha384-zUfuhFKKZCbHTY6aRR46gxiqszMk5tcHjsVFxnUo8VMus4kHGVdIYVbOYYNlKmHV" crossorigin="anonymous" defer></script>
</head>

<body>
    
    <x-currency-table :target="'buy_currency_placeholder'" :data="$currencies_paginator"/>
    <div id="buy_currency_placeholder" class="modal-carier">
    
</body>

</html>