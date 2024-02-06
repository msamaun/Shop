@extends('admin.layouts.app')
@section('admin')
    @include('admin.components.brand.brand-list')
    @include('admin.components.brand.brand-delete')
    @include('admin.components.brand.brand-create')
    @include('admin.components.brand.brand-update')
@endsection
