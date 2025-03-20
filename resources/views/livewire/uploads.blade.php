<?php

use Livewire\Volt\Component;
//use Livewire\WithFileUploads;
//use Livewire\Attributes\Validate;

new class extends Component {
    ////use WithFileUploads;
    
     public $dataUrl=null;
     public $filename='';
     public $filesize=null;
     public $successMessage;

     public function save($file)
    {
        
        //dd($file[0]);
        // Kiểm tra xem có dữ liệu trong file không
        if (isset($file[0]['dataURL'])) {
            // Tạo một tên tệp và lưu trữ tệp từ base64
            $this->dataUrl = $file[0]['dataURL'];
            $data = $file[0]['dataURL'];
            $this->filename = $file[0]['upload']['filename'];
            $this->filesize = $file[0]['upload']['total'];

            // Tách base64 và loại bỏ phần không cần thiết
            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $data = base64_decode($data);

            // Lưu tệp vào thư mục 'photos'
            file_put_contents(public_path('photos/' . $this->filename), $data);
            
            // Thiết lập thông báo thành công
            $this->successMessage = 'Ảnh đã được tải lên thành công!';
        } else {
            // Xử lý lỗi nếu không có dữ liệu
            $this->addError('photo', 'Không có tệp nào được chọn!');
        }
    }
}; ?>

<div class="row">
    <div class="col-md-12">
      <div class="card card-default">
        <div class="card-header">
          <h3 class="card-title">Dropzone.js <small><em>jQuery File Upload</em> like look</small></h3>
        </div>
        <div class="card-body">
          <div id="actions" class="row">
            <div class="col-lg-6">
              <div class="btn-group w-100">
                <span class="btn btn-success col fileinput-button">
                  <i class="fas fa-plus"></i>
                  <span>Add files</span>
                </span>
                <button type="submit" class="btn btn-primary col start">
                  <i class="fas fa-upload"></i>
                  <span>Start upload</span>
                </button>
                <button type="reset" class="btn btn-warning col cancel">
                  <i class="fas fa-times-circle"></i>
                  <span>Cancel upload</span>
                </button>
              </div>
            </div>
            <div class="col-lg-6 d-flex align-items-center">
              <div class="fileupload-process w-100">
                <div id="total-progress" class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                  <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                </div>
              </div>
            </div>
          </div>
          <div class="table table-striped files" id="previews">
            <div id="template" class="row mt-2">
              
              <div class="col-auto">
                  <span class="preview">             
                      @if ($dataUrl)
                      <img src="{{ $dataUrl }}" alt="" width="80px" height="80px" />  
                      @else
                        <img src="{{ asset('/') }}" alt="" data-dz-thumbnail />   
                      @endif                                          
                                                                                   
                 </span>
              </div>
              <div class="col d-flex align-items-center">
                  @if($filesize)
                  <p class="mb-0">
                    <span class="lead">{{$filename}}</span>
                    (<span>{{ $filesize }}</span>)
                  </p>
                  @endif
                  <strong class="error text-danger" data-dz-errormessage></strong>
              </div>
              <div class="col-4 d-flex align-items-center" >
                  <div class="progress progress-striped active w-100" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                    <div  wire:loading class="progress-bar progress-bar-success" style="width:100%;" data-dz-uploadprogress></div>

                  </div>
              </div>
              <div class="col-auto d-flex align-items-center">
                <div class="btn-group">
                  <button class="btn btn-primary start">
                    <i class="fas fa-upload"></i>
                    <span>Start</span>
                  </button>
                  <button data-dz-remove class="btn btn-warning cancel">
                    <i class="fas fa-times-circle"></i>
                    <span>Cancel</span>
                  </button>
                  <button data-dz-remove class="btn btn-danger delete">
                    <i class="fas fa-trash"></i>
                    <span>Delete</span>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /.card-body -->
        @if ($successMessage)
        <div class="card-footer success">
          {{ $successMessage }}
        </div>
        @endif
      </div>
    </div>
    
    @script
    <script>
         
        document.addEventListener('livewire:initialized', () => {
          
        // DropzoneJS Demo Code Start
      Dropzone.autoDiscover = false
     
        
      
    // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
    var previewNode = document.querySelector("#template")
    previewNode.id = ""
    var previewTemplate = previewNode.parentNode.innerHTML
    previewNode.parentNode.removeChild(previewNode)
    
    var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
      url: "#", // Set the url
      thumbnailWidth: 80,
      thumbnailHeight: 80,
      parallelUploads: 20,
      previewTemplate: previewTemplate,
      autoQueue: false, // Make sure the files aren't queued until manually added
      previewsContainer: "#previews", // Define the container to display the previews
      clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
    })
    
    
    myDropzone.on("addedfile", function(file) {
      // Hookup the start button
      file.previewElement.querySelector(".start").onclick = function() {
        console.log('start'); 
        //myDropzone.enqueueFile(file) 
        $wire.save([file])    
        
    }
    })
    
    // Update the total progress bar
    myDropzone.on("totaluploadprogress", function(progress) {
      document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
    })
    
    myDropzone.on("sending", function(file) {
      // Show the total progress bar when upload starts
      document.querySelector("#total-progress").style.opacity = "1"
      // And disable the start button
      file.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
    })
    
    // Hide the total progress bar when nothing's uploading anymore
    myDropzone.on("queuecomplete", function(progress) {
      document.querySelector("#total-progress").style.opacity = "0"
    })
    
    // Setup the buttons for all transfers
    // The "add files" button doesn't need to be setup because the config
    // `clickable` has already been specified.
    document.querySelector("#actions .start").onclick = function() {
        console.log('start upload');
        //myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
        //$wire.save(myDropzone.getFilesWithStatus(Dropzone.ADDED))
        files = myDropzone.getFilesWithStatus(Dropzone.ADDED)
        files.forEach(file => {
          $wire.save([file]);
        });
    }
    document.querySelector("#actions .cancel").onclick = function() {
      myDropzone.removeAllFiles(true)
    }
    // DropzoneJS Demo Code End
    })
    </script>
    @endscript

</div>
