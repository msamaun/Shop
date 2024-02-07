@extends('auth.layouts.app')
@section('content')
    @include('auth.components.MenuBar')
    @include('auth.components.ByBrandList')
    @include('auth.components.TopBrands')
    @include('auth.components.Footer')
    <script>
        (async () => {
            await Category();
            await ByBrand();
            $(".preloader").delay(90).fadeOut(100).addClass('loaded');
            await TopBrands();
        })()
    </script>
@endsection
