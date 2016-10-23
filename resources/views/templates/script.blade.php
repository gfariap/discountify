<div class="discountify_tag" title="Discounts"><i class="fa fa-tag"></i></div>
<div class="discountify_bar form-inline">
    <div class="include-discount">
        Insert your discount code:
        <div class="input-group">
            <input type="text" class="form-control" name="discount_code" id="discount_code">
            <span class="input-group-btn">
                <button class="btn btn-success apply-discount" type="button">APPLY</button>
            </span>
        </div>
        <span class="help">
            <i class="fa fa-question-circle"></i> The discount will be applied to all the eligible products of the store.
        </span>
    </div>
    <div class="remove-discount">
        Your discount code is:
        <span class="discount-code"></span>
        <a href="#" class="remove"><i class="fa fa-times"></i> Remove</a>
    </div>
    <i class="fa fa-times-circle close-btn" title="Close"></i>
</div>
<script>
    function writeCookie(name, value, days) {
        var date, expires;
        if (days) {
            date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toGMTString();
        } else {
            expires = "";
        }
        document.cookie = name + "=" + value + expires + "; path=/";
    }

    function readCookie(name) {
        var i, c, ca, nameEQ = name + "=";
        ca = document.cookie.split(';');
        for (i = 0; i < ca.length; i++) {
            c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1, c.length);
            }
            if (c.indexOf(nameEQ) == 0) {
                return c.substring(nameEQ.length, c.length);
            }
        }
        return '';
    }

    $(document).ready(function () {
        var cookie = readCookie('discountify');
        if (cookie != '') {
            var discountify = JSON.parse(cookie);
            $('.discount-code').text(discountify.code);
            $('.discountify_bar').addClass('with-discount');
            $('.discountify_preview').each(function () {
                var product_price = $(this).find('.discountify_product_price')[0];
                var value = parseFloat($(product_price).val())/100;
                var discounted_value = 0;
                if (discountify.type == 'Percentage') {
                    discounted_value = value - (value * (parseFloat(discountify.value) / 100));
                } else {
                    discounted_value = value - parseFloat(discountify.value);
                }
                var discounted_price = $(this).find('.discountify_price')[0];
                $(discounted_price).html('$ '+discounted_value.toFixed(2));
            });
        }
        $('.discountify_tag').click(function () {
            $('.discountify_bar').toggleClass('open');
        });
        $('.discountify_bar .close-btn').click(function () {
            $('.discountify_bar').toggleClass('open');
        });
        $('.apply-discount').click(function (e) {
            e.preventDefault();
            var array = [ {!! $discounts !!} ];
            var discount = '';
            var found = false;
            for (var i = 0; i < array.length; i++) {
                discount = JSON.parse(array[i]);
                if (discount.code.toUpperCase() == $('#discount_code').val().toUpperCase()) {
                    writeCookie('discountify', array[i], 1);
                    found = true;
                }
            }
            $('#discount_code').val('');
            if (found) {
                window.location.reload();
            }
        });
        $('.remove-discount').click(function (e) {
            e.preventDefault();
            if (readCookie('discountify') != '') {
                document.cookie = 'discountify=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
            }
            $('.discount-code').text('');
            $('#discount_code').val('');
            $('.discountify_bar').removeClass('with-discount');
        })
    });
</script>