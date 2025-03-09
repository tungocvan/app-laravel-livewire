@extends('adminlte::page')
@section('title', 'QUẢN TRỊ BỘ ĐỀ')
@section('content_header')
    <h1>DANH SÁCH BỘ ĐỀ</h1>
@stop
@section('plugins.Select2', true)
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
        'data' => $data['questionSet'],
        'order' => [[0, 'desc']],
        'columns' => [
            ['data' => 'id','name' => 'id'],
            ['data' => 'user_id','name' => 'user_id'],
            ['data' => 'name'],
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
{{-- <x-adminlte-alert>

    <div class="row gx-4">
        <div class="col">
            <x-adminlte-select name="monhoc">
                <x-adminlte-options :options="$data['monhoc']"  :selected="old('monhoc')"  igroup-size="md" label-class="text-lightblue"  placeholder="Chọn Môn học..." />
            </x-adminlte-select>
        </div>
        <div class="col">
            <x-adminlte-select name="khoilop">
                <x-adminlte-options :options="$data['khoilop']"  :selected="old('khoilop')"  igroup-size="md" label-class="text-lightblue"  placeholder="Chọn Khối lớp..." />
            </x-adminlte-select>
        </div>
        <div class="col">
            <x-adminlte-select name="capdo">
                <x-adminlte-options :options="$data['capdo']"  :selected="old('capdo')"  igroup-size="md" label-class="text-lightblue"  placeholder="Chọn Cấp độ..." />
            </x-adminlte-select>
        </div>
        <div class="col">
            <x-adminlte-select name="loaicau">
                <x-adminlte-options :options="$data['loaicau']" :selected="old('loaicau') ?? 0"  igroup-size="md" label-class="text-lightblue"  placeholder="Loại đáp án..." />
            </x-adminlte-select>
        </div>
    </div>
</x-adminlte-alert> --}}
<x-adminlte-alert>
    <div class="row">
        <div class="col-md-12">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <form  action="{{ route('quiz.submit-topic-set-list') }}" method="POST">
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

