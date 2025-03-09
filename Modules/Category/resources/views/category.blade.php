@extends('adminlte::page')
@section('title', 'Tạo chuyên mục')
@section('plugins.Select2', true)
@section('content')
<x-adminlte-alert>
    <div class="row">
        <div class="col-md-4">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <form  action="{{ route('category.submit') }}" method="POST">
                @csrf
                <x-adminlte-input name="term_id" label="ID" placeholder="placeholder"  disable-feedback />
                <x-adminlte-input name="name" label="Tên" placeholder="placeholder"  disable-feedback>
                    <x-slot name="bottomSlot">
                        <span class="text-sm text-gray">
                            Tên là cách nó xuất hiện trên trang web của bạn.
                        </span>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input name="slug" label="Đường dẫn" placeholder="placeholder"  disable-feedback>
                    <x-slot name="bottomSlot">
                        <span class="text-sm text-gray">
                            “slug” là đường dẫn thân thiện của tên. Nó thường chỉ bao gồm kí tự viết thường, số và dấu gạch ngang, không dùng tiếng Việt.
                        </span>
                    </x-slot>
                </x-adminlte-input>
                <span class="text-sm text-gray">Danh mục cha</span>
                <x-adminlte-select name="parent">
                    <x-adminlte-options :options="$parentCategories" empty-option="Trống"/>
                </x-adminlte-select>
                <span class="text-sm text-gray">Mô tả</span>
                <x-adminlte-textarea name="description" placeholder="Insert description..."/>
                <span class="text-sm text-gray">Thông thường mô tả này không được sử dụng trong các giao diện, tuy nhiên có vài giao diện có thể hiển thị mô tả này.</span>
                <x-adminlte-button type="submit" label="Thêm danh mục" theme="primary" icon="fas fa-key"/>
                <x-adminlte-button type="submit" label="Cập nhật" theme="primary" icon="fas fa-key" name="update" value="true" id="update" />
            </form>
        </div>
        <div class="col-md-8">
            {{-- Hiển thị selectbox -> khi chọn xóa thì nó sẻ xóa hàng loạt --}}
            <form action="{{ route('category.bulkDelete') }}" method="POST" id="bulk-delete-form">
                @csrf
                @method('DELETE') <!-- Gửi yêu cầu DELETE -->

                {{-- Nút áp dụng để xóa hàng loạt --}}
                <div class="d-flex mb-2">
                    <select name="bulk-action" id="bulk-action" class="form-control w-25 mr-2">
                        <option value="">-- Hành động --</option>
                        <option value="delete">Xóa</option>
                    </select>
                    <button type="submit" class="btn btn-danger" id="apply-action">Áp dụng</button>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th> <input type="checkbox" id="select-all"></th>
                            <th>Tên</th>
                            <th>Slug</th>
                            <th>Mô tả</th>
                            <th>Danh mục cha</th>
                            <th>Số lượng bài viết</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                        <tr class="category-row"
                            data-term-id="{{ $category->term_id }}"
                            data-name="{{ $category->name }}"
                            data-slug="{{ $category->slug }}"
                            data-description="{{ $category->description }}"
                            data-parent="{{ $category->parent }}">
                            <td>
                                <input type="checkbox" name="categories[]" value="{{ $category->term_id }}">
                            </td>
                            <td>
                                @if($category->parent != 0)
                                {!! str_repeat('&nbsp;', 4) !!}
                            @endif
                                {{-- có thêm hàng động click chọn danh mục sẻ chuyển nội dung qua <div class="col-md-4">, để chỉnh sửa danh mục --}}
                                {{ $category->name }}
                            </td>
                            <td>{{ $category->slug }}</td>
                            <td>{{ $category->description }}</td>
                            <td>{{ $category->parent_name }}</td>
                            <td>{{ $category->count }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </form>
        </div>

    </div>
</x-adminlte-alert>
<script>
    document.addEventListener('DOMContentLoaded', function(event) {
             // Bắt sự kiện chọn tất cả
    document.getElementById('select-all').addEventListener('click', function() {
        const checkboxes = document.querySelectorAll('input[name="categories[]"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    // Bắt sự kiện click vào hàng danh mục để hiện thông tin
    document.querySelectorAll('.category-row').forEach(row => {
        row.addEventListener('click', function() {
            // Lấy thông tin từ thuộc tính data-*
            const term_id = this.getAttribute('data-term-id');
            const name = this.getAttribute('data-name');
            const slug = this.getAttribute('data-slug');
            const description = this.getAttribute('data-description');
            const parent = this.getAttribute('data-parent');
            console.log('term_id: ',term_id);
            // Hiển thị thông tin vào div
            document.getElementById('term_id').value = term_id;
            document.getElementById('update').value = term_id;
            document.getElementById('name').value = name;
            document.getElementById('slug').value = slug;
            document.getElementById('description').value = description;
            document.getElementById('parent').value = parent;
        });
    });

      // Xử lý khi nhấn vào nút áp dụng
      document.getElementById('apply-action').addEventListener('click', function(event) {
        const action = document.getElementById('bulk-action').value;
        if (action === 'delete') {
            if (!confirm('Bạn có chắc chắn muốn xóa các danh mục đã chọn không?')) {
                event.preventDefault();
            }
        } else {
            event.preventDefault();
            alert('Vui lòng chọn hành động.');
        }
    });



    });
</script>
@stop

