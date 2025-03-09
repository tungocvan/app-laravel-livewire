@extends('adminlte::page')
@section('title', 'CẤU HÌNH CHUNG')
@section('content_header')
    <h1>CẤU HÌNH CHUNG</h1>
@stop
@section('plugins.Select2', true)
@section('content')

<x-adminlte-alert>
    <div class="row">
        <div class="col-md-12">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Môn học</h3>
                  <div class="card-tools">
                    <!-- Collapse Button -->
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                  </div>
                  <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form  action="{{ route('quiz.submit-add') }}" method="POST">
                        @csrf
                    <x-adminlte-input name="input-add-topic" label="Thêm môn học" placeholder="Thêm môn học..." igroup-size="md">
                        <x-slot name="appendSlot">
                            <x-adminlte-button type="submit" theme="outline-danger" label="Thêm" name="btn-add-topic" value="add-topic"/>
                        </x-slot>
                    </x-adminlte-input>
                    </form>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">STT</th>
                                <th>Môn học</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                    @foreach ($topic as $key => $item)
                        <tr>
                            <form  action="{{ route('quiz.submit-topic') }}" method="POST">
                                @csrf
                                <td>{{$key}}</td>
                                <td>{{$item}}</td>
                                <td>
                                    <x-adminlte-button label="Sửa" data-toggle="modal" data-target="#edit-{{ $key }}" class="bg-purple"/>
                                    <x-adminlte-button label="Xóa" data-toggle="modal" data-target="#delete-{{ $key }}" class="bg-purple"/>
                                </td>
                                <x-adminlte-modal id="edit-{{ $key }}" type="submit" title="Sửa môn học" theme="purple" icon="fas fa-bolt" size='md' disable-animations>
                                    <x-adminlte-input name="input-edit-topic" igroup-size="md" value="{{$item}}" />
                                    <x-slot name="footerSlot">
                                        <x-adminlte-button type="submit" class="mr-auto" theme="success" label="Accept" name="edit" value="{{$key}}" />
                                        <x-adminlte-button theme="danger" label="Cancel" data-dismiss="modal"/>
                                    </x-slot>
                                </x-adminlte-modal>
                                <x-adminlte-modal id="delete-{{ $key }}" type="submit" title="Xóa môn học" theme="purple" icon="fas fa-bolt" size='md' disable-animations>

                                        <span>Bạn có chắc chắn là xóa môn học <strong>{{$item}}</strong> không ? </span>
                                    <x-slot name="footerSlot">
                                        <x-adminlte-button type="submit" class="mr-auto" theme="success" label="Accept" name="delete" value="{{$key}}" />
                                        <x-adminlte-button theme="danger" label="Cancel" data-dismiss="modal"/>
                                    </x-slot>
                                </x-adminlte-modal>
                            </form>
                        </tr>

                    @endforeach
                    </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Khối lớp</h3>
                  <div class="card-tools">
                    <!-- Collapse Button -->
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                  </div>
                  <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form  action="{{ route('quiz.submit-add') }}" method="POST">
                        @csrf
                    <x-adminlte-input name="input-add-class" label="Thêm khối lớp" placeholder="Thêm khối lớp..." igroup-size="md">
                        <x-slot name="appendSlot">
                            <x-adminlte-button type="submit" theme="outline-danger" label="Thêm" name="btn-add-class" value="add-class"/>
                        </x-slot>
                    </x-adminlte-input>
                    </form>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">STT</th>
                                <th>Khối lớp</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                    @foreach ($class as $key => $item)

                    <tr>
                        <form  action="{{ route('quiz.submit-topic') }}" method="POST">
                            @csrf
                            <td>{{$key}}</td>
                            <td>{{$item}}</td>
                            <td>
                                <x-adminlte-button label="Sửa" data-toggle="modal" data-target="#edit-class-{{ $key }}" class="bg-purple"/>
                                <x-adminlte-button label="Xóa" data-toggle="modal" data-target="#delete-class-{{ $key }}" class="bg-purple"/>
                            </td>
                            <x-adminlte-modal id="edit-class-{{ $key }}" type="submit" title="Sửa khối lớp" theme="purple" icon="fas fa-bolt" size='md' disable-animations>
                                <x-adminlte-input name="input-edit-class" igroup-size="md" value="{{$item}}" />
                                <x-slot name="footerSlot">
                                    <x-adminlte-button type="submit" class="mr-auto" theme="success" label="Accept" name="edit" value="{{$key}}" />
                                    <x-adminlte-button theme="danger" label="Cancel" data-dismiss="modal"/>
                                </x-slot>
                            </x-adminlte-modal>
                            <x-adminlte-modal id="delete-class-{{ $key }}" type="submit" title="Xóa môn học" theme="purple" icon="fas fa-bolt" size='md' disable-animations>

                                <span>Bạn có chắc chắn là xóa môn học <strong>{{$item}}</strong> không ? </span>
                                <x-slot name="footerSlot">
                                    <x-adminlte-button type="submit" class="mr-auto" theme="success" label="Accept" name="delete" value="{{$key}}" />
                                    <x-adminlte-button theme="danger" label="Cancel" data-dismiss="modal"/>
                                </x-slot>
                            </x-adminlte-modal>
                        </form>
                    </tr>

                    @endforeach
                    </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Cấp độ</h3>
                  <div class="card-tools">
                    <!-- Collapse Button -->
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                  </div>
                  <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form  action="{{ route('quiz.submit-add') }}" method="POST">
                        @csrf
                        <x-adminlte-input name="input-add-level" label="Thêm cấp độ" placeholder="Thêm cấp độ..." igroup-size="md">
                            <x-slot name="appendSlot">
                                <x-adminlte-button type="submit" theme="outline-danger" label="Thêm" name="btn-add-level" value="add-level"/>
                            </x-slot>
                        </x-adminlte-input>
                    </form>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">STT</th>
                                <th>Cấp độ</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                    @foreach ($capdo as $key => $item)

                    <tr>
                        <form  action="{{ route('quiz.submit-topic') }}" method="POST">
                            @csrf
                            <td>{{$key}}</td>
                            <td>{{$item}}</td>
                            <td>
                                <x-adminlte-button label="Sửa" data-toggle="modal" data-target="#edit-class-{{ $key }}" class="bg-purple"/>
                                <x-adminlte-button label="Xóa" data-toggle="modal" data-target="#delete-class-{{ $key }}" class="bg-purple"/>
                            </td>
                            <x-adminlte-modal id="edit-class-{{ $key }}" type="submit" title="Sửa cấp độ" theme="purple" icon="fas fa-bolt" size='md' disable-animations>
                                <x-adminlte-input name="input-edit-class" igroup-size="md" value="{{$item}}" />
                                <x-slot name="footerSlot">
                                    <x-adminlte-button type="submit" class="mr-auto" theme="success" label="Accept" name="edit" value="{{$key}}" />
                                    <x-adminlte-button theme="danger" label="Cancel" data-dismiss="modal"/>
                                </x-slot>
                            </x-adminlte-modal>
                            <x-adminlte-modal id="delete-class-{{ $key }}" type="submit" title="Xóa cấp độ" theme="purple" icon="fas fa-bolt" size='md' disable-animations>

                                <span>Bạn có chắc chắn là xóa cấp độ <strong>{{$item}}</strong> không ? </span>
                                <x-slot name="footerSlot">
                                    <x-adminlte-button type="submit" class="mr-auto" theme="success" label="Accept" name="delete" value="{{$key}}" />
                                    <x-adminlte-button theme="danger" label="Cancel" data-dismiss="modal"/>
                                </x-slot>
                            </x-adminlte-modal>
                        </form>
                    </tr>

                    @endforeach
                    </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
</x-adminlte-alert>
<script>
    document.addEventListener('DOMContentLoaded', function(event) {
             // Bắt sự kiện chọn tất cả

    });
</script>
@stop

