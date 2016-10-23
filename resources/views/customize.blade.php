@extends ('layouts.main')

@section ('main')
    {!! Form::open([ 'route' => [ 'customize.update', $store ], 'method' => 'PUT' ]) !!}
    <div class="row">
        <div class="col-sm-4">
            <div class="card card--aside form-inline">
                <div class="card-section">
                    Background color
                    <div class="pull-right">
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon">#</span>
                            <input type="text" class="form-control input-sm change-style" id="background_color" name="background_color" value="{{ $theme->background_color }}">
                        </div>
                    </div>
                </div>
                <div class="card-section">
                    Border
                    <div class="pull-right">
                        @if ($theme->border)
                            <i class="fa fa-toggle-on change-border"></i>
                        @else
                            <i class="fa fa-toggle-off change-border"></i>
                        @endif
                        <input type="hidden" id="border" name="border" value="{{ $theme->border ? '1' : '0' }}">
                    </div>
                </div>
                <div class="border-color card-section{{ $theme->border ? '' : ' hidden' }}">
                    Border color
                    <div class="pull-right">
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon">#</span>
                            <input type="text" class="form-control input-sm change-style" id="border_color" name="border_color" value="{{ $theme->border_color }}">
                        </div>
                    </div>
                </div>
                <div class="card-section">
                    Text color
                    <div class="pull-right">
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon">#</span>
                            <input type="text" class="form-control input-sm change-style" id="text_color" name="text_color" value="{{ $theme->text_color }}">
                        </div>
                    </div>
                </div>
                <div class="card-section">
                    Success color
                    <div class="pull-right">
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon">#</span>
                            <input type="text" class="form-control input-sm change-style" id="success_color" name="success_color" value="{{ $theme->success_color }}">
                        </div>
                    </div>
                </div>
                <div class="card-section">
                    Danger color
                    <div class="pull-right">
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon">#</span>
                            <input type="text" class="form-control input-sm change-style" id="danger_color" name="danger_color" value="{{ $theme->danger_color }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="card preview">
                <div class="card-section">
                    <div class="discountify_bar form-inline open" style="border-bottom: {{ $theme->border ? '1px solid' : '0' }} !important;">
                        <div class="discountify_tag" title="Discounts"><i class="fa fa-tag"></i></div>
                        <div class="include-discount">
                            Insert your discount code:
                            <div class="input-group">
                                <input type="text" class="form-control" name="discount_code" id="discount_code">
                                <span class="input-group-btn">
                                    <button class="btn btn-success apply-discount" type="button">APPLY</button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="discountify_bar form-inline open with-discount" style="border-bottom: {{ $theme->border ? '1px solid' : '0' }} !important;">
                        <div class="discountify_tag" title="Discounts"><i class="fa fa-tag"></i></div>
                        <div class="remove-discount">
                            Your discount code is:
                            <span class="discount-code">DISCOUNT CODE</span>
                            <span class="remove"><i class="fa fa-times"></i> Remove</span>
                        </div>
                    </div>
                    <br>
                    <div class="discountify_preview" style="border: {{ $theme->border ? '1px solid' : '0' }} !important;">
                        <i class="fa fa-tag"></i>
                        <div class="pull-right">C$ 100.00</div>
                    </div>
                </div>
            </div>
            <hr/>
            <div class="pull-right">
                {{ link_to_route('index', 'Cancel', [], [ 'class' => 'btn btn-default' ]) }}
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
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

@section ('scripts')
    <script>
        function rebuild_styles() {
            var border = false;
            if ($('.change-border').hasClass('fa-toggle-on')) {
                border = true;
            }
            var border_color = '#' + $('#border_color').val();
            var background_color = '#' + $('#background_color').val();
            var text_color = '#' + $('#text_color').val();
            var success_color = '#' + $('#success_color').val();
            var danger_color = '#' + $('#danger_color').val();
            var bar = 'border-bottom: ' + (border ? '1px solid '+border_color : '0') + ' !important;';
            var preview = 'border: ' + (border ? '1px solid '+border_color : '0') + ' !important;';
            var button = 'background-color: ' + success_color + ' !important;';
            var discount = 'color: ' + success_color + ' !important;';
            var remove = 'color: ' + text_color + ' !important;';
            var remove_icon = 'color: ' + danger_color + ' !important;';
            bar += 'color: ' + text_color + ' !important;';
            preview += 'color: ' + text_color + ' !important;';
            bar += 'background-color: ' + background_color + ' !important;';
            preview += 'background-color: ' + background_color + ' !important;';
            $('.discountify_bar').attr('style', bar);
            $('.discountify_preview').attr('style', preview);
            $('.apply-discount').attr('style', button);
            $('.discount-code').attr('style', discount);
            $('.remove').attr('style', remove);
            $('.remove i.fa').attr('style', remove_icon);
            $('#border').val(border ? '1' : '0');
        }

        $(document).ready(function() {
            rebuild_styles();

            $('.change-border').click(function() {
                $('.border-color').toggleClass('hidden');
                $('.change-border').toggleClass('fa-toggle-on');
                $('.change-border').toggleClass('fa-toggle-off');
                rebuild_styles();
            })

            $('.change-style').blur(function() {
                rebuild_styles();
            });
        });
    </script>
@endsection