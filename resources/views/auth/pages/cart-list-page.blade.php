@extends('auth.layouts.app')
@section('content')
    @include('auth.components.MenuBar')
    @include('auth.components.PaymentMethodList')
    @include('auth.components.CartList')
    @include('auth.components.TopBrands')
    @include('auth.components.Footer')
    <script>
        (async () => {
            await CartList();
            $(".preloader").delay(90).fadeOut(100).addClass('loaded');
        })()
    </script>
@endsection
