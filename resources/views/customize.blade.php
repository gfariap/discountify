@extends ('layouts.main')

@section ('main')
    <h1>Customize</h1>
@endsection

@section ('shopify-bar')
    <script type="text/javascript">
        ShopifyApp.ready(function(){
            ShopifyApp.Bar.initialize({
                icon: '{!! asset('img/logo_s.png') !!}',
                title: 'Customize app theme'
            });
        });
    </script>
@endsection
