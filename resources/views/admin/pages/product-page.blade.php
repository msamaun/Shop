@extends('admin.layouts.app')
@section('admin')
    @include('admin.components.product.product-list')
    @include('admin.components.product.product-delete')
    @include('admin.components.product.product-create')
    @include('admin.components.product.product-update')
@endsection
