@extends('adminlte::page')
@section('plugins.Select2', true)
@section('plugins.Summernote', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.Toastr', true)
@section('plugins.BsCustomFileInput', true)
{{-- @section('plugins.Datatables', true) --}}
{{-- @section('plugins.DatatablesPlugins', true) --}}
@section('title', 'Settings')

@section('content_header')
    <h1>COMPONENTS</h1>
@stop

@section('content')
    {{-- @livewire('components.form') --}}
    @livewire('image-uploader')
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bs-stepper/dist/css/bs-stepper.min.css"> --}}

@stop

@section('js')
     {{-- https://www.daterangepicker.com/#examples  --}}
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>

    {{-- <script src="https://cdn.jsdelivr.net/npm/bs-stepper/dist/js/bs-stepper.min.js"></script> --}}

@stop
