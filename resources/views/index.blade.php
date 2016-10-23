@extends ('layouts.main')

@section ('main')
    <div class="main-area">
        <img src="{{ asset('img/logo.png') }}" class="logo" alt="Discountify">
        {{ link_to_route('discounts', 'Register discount codes', [], [ 'class' => 'btn btn-success btn-block' ]) }}
        {{ link_to_route('customize', 'Customize app theme', [], [ 'class' => 'btn btn-success btn-block' ]) }}
    </div>
@endsection

@section ('shopify-bar')
    <script type="text/javascript">
        ShopifyApp.ready(function(){
            ShopifyApp.Bar.initialize({
                icon: '{!! asset('img/logo_s.png') !!}'
            });
        });
    </script>
@endsection
