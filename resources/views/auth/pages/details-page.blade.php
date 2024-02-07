@extends('auth.layouts.app')
@section('content')
    @include('auth.components.MenuBar')
    @include('auth.components.ProductDetails')
    @include('auth.components.ProductSpecification')
    @include('auth.components.TopBrands')
    @include('auth.components.Footer')
    <script>
        (async () => {
            await productDetails();
            await productReview();
            $(".preloader").delay(90).fadeOut(100).addClass('loaded');
        })()
    </script>
@endsection
