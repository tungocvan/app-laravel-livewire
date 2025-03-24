<div>
    <div>
       <div wire:ignore> 
               @php
               if(!$name) {
                $name = "editor-" . rand(1,9);
               }
               
               $config = [
                   "height" => "100",
                   "toolbar" => [
                       // [groupName, [list of button]]
                       ['style', ['style']],
                       ['style', ['bold', 'italic', 'underline', 'clear']],
                       ['font', ['strikethrough', 'superscript', 'subscript']],
                       ['fontsize', ['fontsize']],
                       ['fontname', ['fontname']],
                       ['color', ['color']],
                       ['para', ['ul', 'ol', 'paragraph']],
                       ['height', ['height']],
                       ['table', ['table']],
                       ['insert', ['link', 'picture', 'video','lfm']],
                       ['view', ['fullscreen', 'codeview', 'help']],
                   ],
               ]
               @endphp

               <x-adminlte-text-editor name="{{ $name }}" label="{{ $label }}" label-class="text-danger"
                   igroup-size="sm" placeholder="Write some text..." :config="$config"/>
               <input id="{{$name}}-content" type="text" >
       </div> 
     </div>


     @script
       <script>        
          
           document.addEventListener('livewire:initialized', () => {
                console.log('name:',$wire.name);
                var id = "#"+$wire.name
                function editorSummerNote(id) {
                       let data = ''; // Biến lưu nội dung của trình soạn thảo
                       let editor = $(id);
                       editor.on('summernote.change', function(_, contents) {
                           data = contents; // Cập nhật nội dung vào biến                           
                           
                           // $('#editorContainer input:text').val(data); // Hiển thị nội dung đã nhập
                           
                           

                       });   
                       // Khi blur khỏi trình soạn thảo, cập nhật vào Livewire
                       editor.on('summernote.blur.prevent', function() {            
                           $wire.content=data
                           if ($(`${id}-content`).length) {
                                $(`${id}-content`).val(data);
                            } // Hiển thị nội dung đã nhập
                           // có thể lưu data lên database ở đây
                       });
                   }
                   $.extend($.summernote.options, {
                   buttons: {
                       lfm: function(context) {
                           let ui = $.summernote.ui;
                           let button = ui.button({
                               contents: '<i class="fa fa-image"></i> LFM', // Icon Font Awesome
                               tooltip: "Chèn ảnh từ LFM",
                               click: function() {
                                   let route_prefix = "/laravel-filemanager";
                                   window.open(route_prefix + "?type=image", "FileManager", "width=900,height=600");
                                   window.SetUrl = function(items) {
                                       let url = items.map(item => item.url).join(",");
                                       $(id).summernote('insertImage', url);
                                   };
                               }
                           });
                           return button.render();
                       }
                   }
               });
                editorSummerNote(id)
               
           })

           
       </script>
     @endscript
</div>
