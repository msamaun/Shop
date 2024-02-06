@extends('auth.layouts.app')
@section('content')
    @include('auth/components.MenuBar')
    @include('auth/components.Verify')
    @include('auth/components.TopBrands')
    @include('auth/components.Footer')
    <script>
        (async () => {
            $(".preloader").delay(90).fadeOut(100).addClass('loaded');
        })()
    </script>
@endsection
