<div>

<x-adminlte-modal id="modalMin" title="Minimal">
    <h2>ABC</h2>
    <x-slot name="footerSlot">
        <x-adminlte-button class="mr-auto" theme="success" label="Accept"/>
        <x-adminlte-button theme="danger" label="Dismiss" data-dismiss="modal"/>
    </x-slot>
</x-adminlte-modal>    
<x-adminlte-button label="Open Modal" data-toggle="modal" data-target="#modalMin"/>
<hr>
@php
    $config = [
        "placeholder" => "Select multiple options...",
        "allowClear" => true,
    ];
@endphp

<div x-data="{ category: '' }" x-init="
    $('#selBasic').on('change', function() {
        category = this.value;
    });
">
    <x-adminlte-select2 name="selBasic" id="selBasic">
        <option value="">Chọn một tùy chọn</option>
        <option value="Option 1">Option 1</option>
        <option value="Option 2">Option 2</option>
        <option value="Option 3">Option 3</option>
    </x-adminlte-select2>

    <span x-text="category"></span>
</div>



 <div x-data="{ categories: [] }" x-init="
 $('#sel2Category').on('change', function() {
     categories = Array.from(this.selectedOptions).map(option => option.value);
 });
">
 <x-adminlte-select2 id="sel2Category" name="sel2Category[]" label="Categories"
     label-class="text-danger" igroup-size="sm" :config="$config" multiple>
     
     <x-slot name="prependSlot">
         <div class="input-group-text bg-gradient-red">
             <i class="fas fa-tag"></i>
         </div>
     </x-slot>
     
     <x-slot name="appendSlot">
         <x-adminlte-button theme="outline-dark" label="Clear" icon="fas fa-lg fa-ban text-danger"/>
     </x-slot>

     <option>Sports</option>
     <option>News</option>
     <option>Games</option>
     <option>Science</option>
     <option>Maths</option>
 </x-adminlte-select2>

 <p>Chọn: <span x-text="categories.join(', ')"></span></p>
</div>
<div x-data="{ age:0 }">
    <input type="text" x-model.number="age">
    <span x-text="typeof age"></span>
</div>
<hr>
<div x-data="{ data: '' }" x-init="
    $nextTick(() => {
        let editor = $('#teBasic'); // Lấy trình soạn thảo
        editor.on('summernote.change', function(_, contents) {
            data = contents; // Cập nhật nội dung vào biến Alpine
        });
    });
">
    <x-adminlte-text-editor name="teBasic" id="teBasic"></x-adminlte-text-editor>

    <p class="mt-2">📌 <strong>Nội dung đã nhập:</strong></p>
    <div class="border p-2 mt-2 bg-light" x-html="data"></div>
</div>

<div class="row">
    <div class="col-4">
        @php
        $config = ['format' => 'DD/MM/YYYY HH:mm'];
        @endphp
        <x-adminlte-input-date name="idLabel" :config="$config" placeholder="Choose a date..."
            label="Datetime" label-class="text-primary">
            <x-slot name="appendSlot">
                <x-adminlte-button theme="outline-primary" icon="fas fa-lg fa-birthday-cake"
                    title="Set to Birthday"/>
            </x-slot>
        </x-adminlte-input-date>
    </div>
    <div class="col-4">
       
    </div>
</div>
</div>
