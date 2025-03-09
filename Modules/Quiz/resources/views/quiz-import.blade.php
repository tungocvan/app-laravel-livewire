@extends('adminlte::page')
{{-- @section('plugins.Select2', true) --}}
{{-- @section('plugins.Summernote', true) --}}
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
@section('title', 'QUẢN TRỊ CÂU HỎI')


@section('content_header')
<x-adminlte-alert>
    <form  action="{{ route('quiz.quiz-import-set') }}" method="POST">
        @csrf

    @if(session('question'))
                <div class="alert alert-success">
                    {{ session('question') }}
                </div>
    @endif

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
        <div class="col" style="display: none">
            <x-adminlte-select name="capdo">
                <x-adminlte-options :options="$data['capdo']"  :selected="old('capdo') ?? 0"  igroup-size="md" label-class="text-lightblue"  placeholder="Chọn Cấp độ..." />
            </x-adminlte-select>
        </div>
        <div class="col" style="display: none">
            <x-adminlte-select name="loaicau">
                <x-adminlte-options :options="$data['loaicau']" :selected="old('loaicau') ?? 0"  igroup-size="md" label-class="text-lightblue"  placeholder="Loại đáp án..." />
            </x-adminlte-select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">

            <table class="table table-bordered">
                <thead>
                <tr>
                <th style="width: 10px">#</th>
                <th>Nội dung Câu hỏi</th>
                <th>Đáp án 1</th>
                <th>Đáp án 2</th>
                <th>Đáp án 3</th>
                <th>Đáp án 4</th>
                <th>Câu trả lời</th>
                <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($data['dataQuestion'] as $key => $item)
                @if ($key !=0)
                    <tr>
                    <td>{{$key}}</td>
                    <td>{{$item[1]}}</td>
                    <td>{{$item[2]}}</td>
                    <td>{{$item[3]}}</td>
                    <td>{{$item[4]}}</td>
                    <td>{{$item[5]}}</td>
                    <td>{{$item[6]}}</td>
                    <td>
                        <button class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
                            <i class="fa fa-lg fa-fw fa-trash"></i>
                        </button>
                    </td>
                    </tr>
                @endif

                @endforeach


                </tbody>
                </table>

        </div>
    </div>
    <x-adminlte-alert>
        <div class="row">
            <div class="col-md-4">
                <input type="hidden" name="user_id" value="{{$data['user_id']}}"  />
                <input type="hidden" name="question_details" value="{{$data['question_details']}}"  />
                <button type="submit" class="btn  btn-outline-primary">Lưu danh sách Câu hỏi</buton>
            </div>
        </div>
    </x-adminlte-alert>
    </form>
</x-adminlte-alert>
@stop




@section('content')

<script>
    document.addEventListener('DOMContentLoaded', function(event) {
             // Bắt sự kiện chọn tất cả

    });
</script>
@stop

