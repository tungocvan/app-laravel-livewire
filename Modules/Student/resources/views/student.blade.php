@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)
@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    <style>
        .alert a{
            color: black;
            text-decoration:none
        }
    </style>
@stop
@php
    $heads = [
        'Môn học',
        'Khối lớp',
        'Tổng số câu hỏi',
        'Thời gian làm bài',
        ['label' => 'Actions', 'no-export' => true, 'width' => 15],
    ];

    $config = [
        'data' => $data['questionSet'],
        'order' => [[0, 'desc']],
        'columns' => [
            ['data' => 'category_topic_id'],
            ['data' => 'category_class_id'],
            ['data' => 'total_questions'],
            ['data' => 'timeRemaining'],
            ['orderable' => false, 'data' => 'action'],
        ],
        'fixedHeader' => true,
    ];
   // dd($config['data']);
@endphp
@section('content')
<div class="container pt-3">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif
            {{-- <form  action="{{ route('quiz.question-set', ['id' => 1]) }}" method="GET">
                @csrf
                <x-adminlte-button type="submit" label="Luyện tập" theme="primary" icon="fas fa-key"/>
            </form> --}}
            <form  action="{{ route('quiz.submit-topic-set-list') }}" method="POST">
                @csrf
                <x-adminlte-datatable id="table7" :heads="$heads" theme="info" class="bg-teal" :config="$config"
                striped beautify hoverable bordered  />
            </form>
        </div>
    </div>
</div>
@endsection
