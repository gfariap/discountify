@extends ('layouts.main')

@section ('main')
    <h1>Customize</h1>
    <pre>
    {{ var_dump($themes) }}
    </pre>
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
