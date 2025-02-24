<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @foreach ($theme->assets->css as $item)
        <link href="{{ asset($item) }}" rel="stylesheet" type="text/css" />
    @endforeach

    @foreach ($theme->assets->js as $item)
        <script src="{{ asset($item) }}"></script>
    @endforeach
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

</head>

<body>
    {!! $slot !!}
</body>

</html>
