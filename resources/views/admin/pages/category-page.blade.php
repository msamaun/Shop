@extends('admin.layouts.app')
@section('admin')
    @include('admin.components.category.category-list')
    @include('admin.components.category.category-delete')
    @include('admin.components.category.category-create')
    @include('admin.components.category.category-update')
@endsection
