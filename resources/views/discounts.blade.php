@extends ('layouts.main')

@section ('main')
    <div class="card">
        <div class="card-section">
            <p class="help-block">Register all the discount counts that you want to be available to use at our toolbar on your store. After filling the list of codes, click the button "Update snippet on store" to make them available.</p>
        </div>
        @if (count($discounts) > 0)
            <div class="card-section">
                <h4>List of valid codes</h4>
                <table class="table">
                    <tr>
                        <th>Code</th>
                        <th>Type</th>
                        <th>Value</th>
                        <th></th>
                    </tr>
                    @foreach ($discounts as $discount)
                        <tr>
                            <td>{{ $discount->code }}</td>
                            <td>{{ $discount->type }}</td>
                            <td>{{ $discount->value }}</td>
                            <td style="text-wrap: none; width: 1%;">
                                {!! Form::model($discount, [ 'route' => [ 'discounts.delete', $store, $discount->id ], 'method' => 'DELETE', 'class' => 'form-inline' ]) !!}
                                    {!! Form::submit('Remove', [ 'class' => 'btn btn-danger btn-xs' ]) !!}
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        @endif
        <div class="card-section">
            <h4>Register a new discount code</h4>
            {!! Form::open([ 'route' => [ 'discounts.store', $store ], 'class' => 'form-inline discount-form' ]) !!}
                <div class="form-group">
                    {!! Form::label('code', 'Code') !!}
                    {!! Form::text('code', null, [ 'class' => 'form-control' ]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('type', 'Type') !!}
                    {!! Form::select('type', [ 'Percentage' => 'Percentage', 'Value' => 'Fixed value' ], null, [ 'class' => 'form-control' ]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('value', 'Value') !!}
                    {!! Form::text('value', null, [ 'class' => 'form-control' ]) !!}
                </div>
                <div class="form-group">
                    {!! Form::submit('Save', [ 'class' => 'btn btn-primary' ]) !!}
                </div>
            {!! Form::close() !!}
        </div>
    </div>
    <hr/>
    {!! Form::open([ 'route' => [ 'discounts.generate', $store ], 'class' => 'form-inline' ]) !!}
        <div class="pull-right">
            {{ link_to_route('index', 'Cancel', [], [ 'class' => 'btn btn-default' ]) }}
            {!! Form::submit('Update snippet on store', [ 'class' => 'btn btn-primary' ]) !!}
        </div>
    {!! Form::close() !!}
@endsection

@section ('shopify-bar')
    <script type="text/javascript">
        ShopifyApp.ready(function(){
            ShopifyApp.Bar.initialize({
                icon: '{!! asset('img/logo_s.png') !!}',
                title: 'Discount codes'
            });
        });
    </script>
@endsection
