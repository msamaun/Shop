@extends('auth.layouts.app')
@section('content')
    @include('auth.components.MenuBar')
    @include('auth.components.HeroSlider')
    @include('auth.components.TopCategories')
    @include('auth.components.ExclusiveProducts')
    @include('auth.components.TopBrands')
    @include('auth.components.Footer')
    <script>
        (async () => {
            await Category();
            await Hero();

            $(".preloader").delay(90).fadeOut(100).addClass('loaded');
            await Popular();
            await New();
            await Top();
            await Special();
            await Trending();
            await TopBrand();

        })()
    </script>
@endsection
