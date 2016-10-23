<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Discountify</title>

    <script src="https://cdn.shopify.com/s/assets/external/app.js"></script>
    <script type="text/javascript">
        ShopifyApp.init({
            apiKey: '{{ env('SHOPIFY_API_KEY') }}',
            shopOrigin: 'https://{{ $shop_info->shop->myshopify_domain }}'
        });
    </script>
</head>
<body>
<h1>Discountify</h1>

<script type="text/javascript">
    ShopifyApp.ready(function(){
        ShopifyApp.Bar.initialize({
            icon: '{!! asset('img/logo_s.png') !!}',
            title: 'Discountify'
        });
    });
</script>
</body>
</html>
