@extends('admin.layouts.app')
@section('admin')
    @include('admin.components.ProductSlider.silder-list')
    @include('admin.components.ProductSlider.silder-delete')
    @include('admin.components.ProductSlider.silder-create')
    @include('admin.components.ProductSlider.silder-update')
@endsection
