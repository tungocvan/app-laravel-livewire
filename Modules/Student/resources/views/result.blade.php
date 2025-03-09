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
        'ID',
        'Đường dẫn File',
        'Thời gian',
        ['label' => 'Actions', 'no-export' => true, 'width' => 20],
    ];

    $config = [
        'data' => $files,
        'order' => [[0, 'desc']],
        'columns' => [
            ['data' => 'id'],
            ['data' => 'file_path'],
            ['data' => 'created_at'],
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
            <div class="container mt-5">
                <h1>Danh sách đã luyện tập</h1>
                <form  action="{{ route('quiz.submit-topic-set-list') }}" method="POST">
                    @csrf
                    <x-adminlte-datatable id="table7" :heads="$heads" theme="info" class="bg-teal" :config="$config"
                    striped beautify hoverable bordered  />
                </form>
                {{-- <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Đường dẫn file</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($files as $file)
                            <tr>
                                <td>{{ $file->id }}</td>
                                <td>{{ $file->file_path }}</td>
                                <td>
                                    <a href="{{ route('student.view-file', $file->id) }}" class="btn btn-primary" target="_blank">Xem</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table> --}}
            </div>
            {{-- <form  action="{{ route('quiz.question-set', ['id' => 1]) }}" method="GET">
                @csrf
                <x-adminlte-button type="submit" label="Luyện tập" theme="primary" icon="fas fa-key"/>
            </form> --}}
            {{-- <form  action="{{ route('quiz.submit-topic-set-list') }}" method="POST">
                @csrf
                <x-adminlte-datatable id="table7" :heads="$heads" theme="info" class="bg-teal" :config="$config"
                striped beautify hoverable bordered  />
            </form> --}}
        </div>
    </div>
</div>
@endsection
