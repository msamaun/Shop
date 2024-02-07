@extends('auth.layouts.app')
@section('content')
    @include('auth.components.MenuBar')
    @include('auth.components.ByCategoryList')
    @include('auth.components.TopBrands')
    @include('auth.components.Footer')
    <script>
        (async () => {
            await Category();
            await ByCategory();
            $(".preloader").delay(90).fadeOut(100).addClass('loaded');


        })()
    </script>
@endsection
