.discountify_tag {
z-index: 2;
color: #fff;
background: #22B573;
background: -webkit-linear-gradient(left, #00BF8F , #22B573);
background: -o-linear-gradient(right, #00BF8F, #22B573);
background: -moz-linear-gradient(right, #00BF8F, #22B573);
background: linear-gradient(to right, #00BF8F , #22B573);
width: 40px;
height: 40px;
text-align: center;
position: fixed;
top: 0;
left: 0;
cursor: pointer;
padding: 8px;

i.fa {
font-size: 25px;
}
}

.discountify_bar {
background: #{{ $background_color }};
color: #{{ $text_color }};
font-size: 16px;
position: fixed;
top: 0;
left: 0;
right: 0;
height: 40px;
display: none;
padding: 5px 5px 0 60px;
line-height: 28px;
@if ($border)
    border-bottom: 1px solid #{{ $border_color }};
@endif

&.open {
display: block;
}

.include-discount {
display: inline-block;
}

.remove-discount {
display: none;
}

&.with-discount {
.remove-discount {
display: inline-block;
}

.include-discount {
display: none;
}
}

.discount-code {
margin: 0 15px 0 5px;
color: #{{ $success_color }};
}

.remove {
color: #{{ $text_color }};
text-decoration: none !important;
font-size: 12px;

i.fa {
color: #{{ $danger_color }};
font-size: 14px;
}
}

.input-group {
margin: 0 15px 0 10px;

.form-control {
border-top-left-radius: 18px;
border-bottom-left-radius: 18px;
height: 30px;
}

.input-group-btn {
.btn {
border-top-right-radius: 18px;
border-bottom-right-radius: 18px;
font-size: 12px;
height: 30px;
line-height: 1;
border: 0;
}
}
}

span.help {
font-size: 12px;
color: #dedede;
}

.close-btn {
float: right;
font-size: 20px;
margin: 5px;
cursor: pointer;
}

.discountify_tag {
position: absolute;
left: 0;
top: 0;
}
}

.discountify_preview {
background: #{{ $background_color }};
color: #{{ $text_color }};
font-size: 16px;
padding: 5px 10px;
@if ($border)
    border: 1px solid #{{ $border_color }};
@endif
}