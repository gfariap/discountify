<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Discountify</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
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

<div class="container main">
    @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            {{ session('success') }}
        </div>
    @endif
    {{--<div class="discountify_tag" title="Discounts"><i class="fa fa-tag"></i></div>--}}
    {{--<div class="discountify_bar form-inline">--}}
        {{--<div class="include-discount">--}}
            {{--Insert your discount code:--}}
            {{--<div class="input-group">--}}
                {{--<input type="text" class="form-control" name="discount_code" id="discount_code">--}}
                {{--<span class="input-group-btn">--}}
                    {{--<button class="btn btn-success apply-discount" type="button">APPLY</button>--}}
                {{--</span>--}}
            {{--</div>--}}
            {{--<span class="help">--}}
                {{--<i class="fa fa-question-circle"></i> The discount will be applied to all the eligible products of the store.--}}
            {{--</span>--}}
        {{--</div>--}}
        {{--<div class="remove-discount">--}}
            {{--Your discount code is:--}}
            {{--<span class="discount-code"></span>--}}
            {{--<a href="#" class="remove"><i class="fa fa-times"></i> Remove</a>--}}
        {{--</div>--}}
        {{--<i class="fa fa-times-circle close-btn" title="Close"></i>--}}
    {{--</div>--}}
    @yield ('main')
</div>

<script src="{{ asset('js/app.js') }}"></script>
@yield ('shopify-bar')
@yield ('scripts')
{{--<script>--}}
    {{--$(document).ready(function() {--}}
        {{--$('.discountify_tag').click(function() {--}}
            {{--$('.discountify_bar').toggleClass('open');--}}
        {{--});--}}
        {{--$('.discountify_bar .close-btn').click(function() {--}}
            {{--$('.discountify_bar').toggleClass('open');--}}
        {{--});--}}
        {{--$('.apply-discount').click(function(e) {--}}
            {{--e.preventDefault();--}}
            {{--$('.discount-code').text($('#discount_code').val());--}}
            {{--$('#discount_code').val('');--}}
            {{--$('.discountify_bar').addClass('with-discount');--}}
        {{--});--}}
        {{--$('.remove-discount').click(function(e) {--}}
            {{--e.preventDefault();--}}
            {{--$('.discount-code').text('');--}}
            {{--$('#discount_code').val('');--}}
            {{--$('.discountify_bar').removeClass('with-discount');--}}
        {{--})--}}
    {{--});--}}
{{--</script>--}}
</body>
</html>
