@extends('adminlte::page')
{{-- @section('plugins.Select2', true) --}}
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
@section('title', 'QUẢN TRỊ CÂU HỎI')
@section('content_header')
<x-adminlte-alert>
    <h5>DANH SÁCH CÂU HỎI</h5>
    <div class="row">
        <div class="col-3">
            <form  action="{{ route('quiz.quiz-delete') }}" method="POST">
                @csrf
                <a href="{{ route('quiz.quiz-add') }}" class="btn  btn-outline-primary ">Thêm mới</a>
                <button type="submit" id="deleteAll" name="deleteAll" class="btn  btn-outline-danger" disabled>Xóa tất cả</button>
                <input type="hidden" id="data_bo_de" name="bo_de" />
            </form>
        </div>
        <div class="col-4 d-flex">
            <form id="importForm"  action="{{ route('quiz.quiz-import') }}" method="POST" enctype="multipart/form-data" class="d-flex">
                @csrf
                <x-adminlte-input-file name="file" igroup-size="sm" placeholder="Import File...">
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-lightblue">
                            <i class="fas fa-upload"></i>
                        </div>
                    </x-slot>

                </x-adminlte-input-file>
                {{-- <button type="submit" class="btn  btn-outline-danger ml-2">Import Danh sách Câu hỏi</button> --}}
            </form>
        </div>
    </div>
</x-adminlte-alert>
@stop


@php
    $heads = [
        ['label' => '<input type="checkbox" onclick="toggleSelectAll(this)">', 'no-export' => true, 'width' => 2],
        'ID',
        'Nội dung câu hỏi',
        'Môn học',
        'Khối lớp',
        'Cấp độ',
        'Loại câu hỏi',
        ['label' => 'Actions', 'no-export' => true, 'width' => 15],
    ];

    $config = [
        'data' => $questions,
        'order' => [[1, 'desc']],
        'columns' => [
            ['orderable' => false,'data' => 'checkbox'],
            ['data' => 'id','name' => 'id'],
            ['data' => 'content','name' => 'content'],
            ['data' => 'name_topic'],
            ['data' => 'name_class'],
            ['data' => 'question_level'],
            ['data' => 'question_type'],
            ['orderable' => false,'data' => 'action'],
        ],
        'fixedHeader' => true,
    ];
  // dd($config['data']);
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
    var bode = [];
    //var socau = document.getElementById('socau');
    var dataBode = document.getElementById('data_bo_de');
    var deleteAll = document.getElementById('deleteAll');
    document.addEventListener('DOMContentLoaded', function(event) {
             // Bắt sự kiện chọn tất cả
             document.getElementById('file').addEventListener('change', function() {
                    document.getElementById('importForm').submit();
             });

    });
    function toggleSelectAll(source) {
                const checkboxes = document.querySelectorAll('#table7 tbody input[type="checkbox"]');
                bode=[];
                checkboxes.forEach((checkbox) => {
                    checkbox.checked = source.checked
                    if(checkbox.checked == true){
                        //console.log(checkbox.value);
                        bode.push(parseInt(checkbox.value))
                    }else{
                        bode=[];
                    }

                });
                //console.log('bode:',bode);
                dataBode.value = JSON.stringify(bode)
              //  socau.innerText = bode.length;
              if(parseInt(bode.length) === 0){
                deleteAll.disabled = true;
              }else{
                    deleteAll.disabled = false;
              }
            }
     function HanlderCheck(cb,id) {
                // console.log('Clicked:',cb.checked);
                // console.log('id:',id);
                toggleElement(bode,id);
             //   console.log('bode:',bode);
                //socau.innerText = bode.length;
                dataBode.value = JSON.stringify(bode)
                if(parseInt(bode.length) === 0){
                deleteAll.disabled = true;
              }else{
                    deleteAll.disabled = false;
              }
            }
    function toggleElement(array, id) {
                const index = array.indexOf(id);
                if (index === -1) {
                    // Nếu không tìm thấy phần tử, thêm vào mảng
                    array.push(id);
                } else {
                    // Nếu tìm thấy phần tử, xóa khỏi mảng
                    array.splice(index, 1);
                }
                return array;
            }
</script>
@stop

