@extends('adminlte::page')
@section('title', 'QUẢN TRỊ BỘ ĐỀ')
@section('content_header')
    <h1>DANH SÁCH BỘ ĐỀ</h1>
@stop
@section('plugins.Select2', true)
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
        'ID',
        'Người tạo đề',
        'Bộ đề',
        'Môn học',
        'Khối lớp',
        'Tổng số câu hỏi',
        'Thời gian làm bài',
        ['label' => 'Actions', 'no-export' => true, 'width' => 15],
    ];

    $config = [
        'data' => $questionSet,
        'order' => [[0, 'desc']],
        'columns' => [
            ['data' => 'id','name' => 'id'],
            ['data' => 'user_id','name' => 'user_id'],
            ['data' => 'category_topic_id'],
            ['data' => 'category_class_id'],
            ['data' => 'total_questions'],
            ['data' => 'timeRemaining'],
            ['orderable' => false, 'data' => 'action'],
        ],
        'fixedHeader' => true,
    ];
   dd($config['data']);
@endphp

@section('content')
<x-adminlte-alert>
    <div class="row">
        <div class="col-md-12">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <form  action="{{ route('quiz.submit-list') }}" method="POST">
                @csrf
                <x-adminlte-datatable id="table7" :heads="$heads" theme="info" class="bg-teal" :config="$config"
                striped beautify hoverable bordered  with-buttons />
            </form>
        </div>
    </div>
</x-adminlte-alert>

<script>
    document.addEventListener('DOMContentLoaded', function(event) {
             // Bắt sự kiện chọn tất cả

    });
</script>
@stop

