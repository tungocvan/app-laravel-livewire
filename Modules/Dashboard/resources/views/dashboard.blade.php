@extends('components.layouts.app') 
{{-- @section('title', 'Dashboard') --}}

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">          
            @livewire('user')
        </div>
    </div>
</div>
@endsection
    