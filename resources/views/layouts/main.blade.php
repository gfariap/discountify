<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Discountify</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <script src="https://cdn.shopify.com/s/assets/external/app.js"></script>
    <script type="text/javascript">
        ShopifyApp.init({
            apiKey: '{{ env('SHOPIFY_API_KEY') }}',
            shopOrigin: 'https://{{ session('shop') }}'
        });
    </script>
</head>
<body>
<div class="container">
    @yield ('main')
</div>

<script src="{{ asset('js/app.js') }}"></script>
@yield ('shopify-bar')
</body>
</html>
