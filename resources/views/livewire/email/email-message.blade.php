<div x-data="emailEditor">
    <div class="form-group">
        <input class="form-control" placeholder="To:" wire:model="to">
    </div>
    <div class="form-group">
        <input class="form-control" placeholder="Subject:" wire:model="subject">
    </div>
    @livewire('files.file-manager', ['name' => 'email', 'label' => 'Nhập nội dung', 'height' => '300'])
    {{-- <div class="form-group">
        <div class="btn btn-default btn-file">
          <i class="fas fa-paperclip"></i> <span x-text="attachmentName">Attachment</span> 
          <input type="file" id="photoInput"  x-on:change="uploadFile">          
        </div>
        <p class="help-block">Max. 32MB</p>
    </div> --}}
    <div class="form-group">
        <div class="btn btn-default btn-file">      
           <i class="fas fa-paperclip"></i> <span>Attachment</span> 
          <input type="file" id="photoInput"  x-on:change="uploadFiles" multiple>          
        </div>
                  
        <template x-if="attachmentNames.length > 0">
            <template x-for="item in attachmentNames">    
                <div class="mx-2">
                    <i class="fas fa-paperclip" x-text="item"></i>
                    <button class="btn-sm btn-outline-danger">X</button>
                </div>
            </template>
        </template> 
        <p class="help-block">Max. 32MB</p>
    </div>

    <button type="button" class="btn btn-primary" x-on:click="save">Send Mail</button>
</div>
@script
<script>
    Alpine.data('emailEditor', () => ({
            attachmentName: 'Attachment', // Biến lưu tên file
            attachmentNames: [], // Biến lưu tên file
            save() {
                let data = document.querySelector('#email-content').value;      
                $wire.call('SendMail', data).then((res) => {
                    console.log('res:',res);
                });
            },
            // uploadFile(){
            //     let fileInput = document.querySelector('#photoInput');
            //     if (!fileInput || !fileInput.files[0]) {
            //         alert('Vui lòng chọn file!');
            //         return;
            //     }

            //     let file = fileInput.files[0];
            //     this.attachmentName = file.name;
            //     console.log('file:',file.name);
            //     // Kiểm tra Livewire có tồn tại trước khi gọi upload
            //     if (typeof $wire !== "undefined") {
            //         $wire.upload('photo', file, (uploadedFilename) => {
            //             console.log('Upload thành công:', uploadedFilename);
            //         }, (error) => {
            //             console.error('Lỗi upload:', error);
            //         });
            //     } else {
            //         console.error('Lỗi: $wire chưa được khởi tạo!');
            //     }

            // },
            uploadFiles() {
                let fileInput = document.querySelector('#photoInput');
                if (!fileInput || fileInput.files.length === 0) {
                    alert('Vui lòng chọn file!');
                    return;
                }

                let files = Array.from(fileInput.files); // Chuyển NodeList thành mảng

                files.forEach(file => {
                    
                    $wire.upload('photos', file, (uploadedFilename) => {
                        console.log('Upload thành công:', uploadedFilename);
                       this.attachmentNames.push(file.name)
                    }, (error) => {
                        console.error('Lỗi upload:', error);
                    });
                });
            }


        })
        );
    
 
</script>
@endscript