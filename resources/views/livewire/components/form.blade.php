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
    <div class="col-2">
        <button type="button" @click="toastr.success('Have fun storming the castle!', 'Miracle Max Says')" class="btn btn-default toastsDefaultDefault" fdprocessedid="zzzhkl">
            Launch Default Toast
          </button>
    </div>  
</div>
<div>
    <button x-on:click="$wire.showModal = !$wire.showModal">New Post</button> 
    <div wire:show="showModal">
        <form wire:submit="save">
            <div class="modal fade show" id="modal-default" style="display: block; padding-right: 15px;" aria-modal="true" role="dialog">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Default Modal</h4>
                      <button type="button" class="close"  x-on:click="$wire.showModal = false" aria-label="Close">
                        <span aria-hidden="true">×</span>
                      </button>
                    </div>
                    <div class="modal-body">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            </div>
                            <input type="email" class="form-control" placeholder="Email" wire:model="email">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="text" class="form-control" placeholder="Username" wire:model="password">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-default"  x-on:click="$wire.showModal = false">Close</button>
                      <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>             
        </form>
    </div>

</div>
<hr>
<div x-data="{ openTab: 'home' }" class="row">
    <div class="col-6">
        <div x-data="{ openTab: 'home' }" class="row">
            <div class="col-5 col-sm-3">
                <div class="nav flex-column nav-tabs h-100" role="tablist" aria-orientation="vertical">
                    <a 
                        class="nav-link" 
                        :class="{ 'active': openTab === 'home' }" 
                        @click.prevent="openTab = 'home'">Home</a>
                    <a 
                        class="nav-link" 
                        :class="{ 'active': openTab === 'profile' }" 
                        @click.prevent="openTab = 'profile'">Profile</a>
                    <a 
                        class="nav-link" 
                        :class="{ 'active': openTab === 'messages' }" 
                        @click.prevent="openTab = 'messages'">Messages</a>
                    <a 
                        class="nav-link" 
                        :class="{ 'active': openTab === 'settings' }" 
                        @click.prevent="openTab = 'settings'">Settings</a>
                </div>
            </div>
            <div class="col-7 col-sm-9">
                <div class="tab-content">
                    <div x-show="openTab === 'home'" role="tabpanel">
                        Home Content
                    </div>
                    <div x-show="openTab === 'profile'" role="tabpanel">
                        Profile Content
                    </div>
                    <div x-show="openTab === 'messages'" role="tabpanel">
                        messages Content
                    </div>
                    <div x-show="openTab === 'settings'" role="tabpanel">
                        settings Content
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a 
                            class="nav-link" 
                            :class="{ 'active': openTab === 'home' }" 
                            @click.prevent="openTab = 'home'">Home</a>
                    </li>
                    <li class="nav-item">
                        <a 
                            class="nav-link" 
                            :class="{ 'active': openTab === 'profile' }" 
                            @click.prevent="openTab = 'profile'">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a 
                            class="nav-link" 
                            :class="{ 'active': openTab === 'messages' }" 
                            @click.prevent="openTab = 'messages'">Messages</a>
                    </li>
                    <li class="nav-item">
                        <a 
                            class="nav-link" 
                            :class="{ 'active': openTab === 'settings' }" 
                            @click.prevent="openTab = 'settings'">Settings</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div x-show="openTab === 'home'" role="tabpanel">
                    Home Content
                </div>
                <div x-show="openTab === 'profile'" role="tabpanel">
                    Profile Content
                </div>
                <div x-show="openTab === 'messages'" role="tabpanel">
                    Messages Content
                </div>
                <div x-show="openTab === 'settings'" role="tabpanel">
                    Settings Content
                </div>
            </div>
        </div>
        <!-- /.card -->
    </div>
</div>

<div x-data="{ currentStep: 1 }" class="row">
    <div class="col-md-6">
        <div class="card p-2">
            <div class="card-header">
                <h3 class="card-title">Stepper</h3>
            </div>
            <div class="card-body p-0">
                <div class="d-flex justify-content-between" role="tablist">
                    <div class="step" :class="{ 'active': currentStep === 1 }" @click="currentStep = 1">
                        <button type="button" class="btn btn-link" aria-selected="currentStep === 1">
                            <span class="badge badge-secondary">1</span>
                            Logins
                        </button>
                    </div>
                    <div class="step" :class="{ 'active': currentStep === 2 }" @click="currentStep = 2">
                        <button type="button" class="btn btn-link" aria-selected="currentStep === 2" :disabled="currentStep < 2">
                            <span class="badge badge-secondary">2</span>
                            Various information
                        </button>
                    </div>
                </div>
                <div class="mt-3">
                    <div x-show="currentStep === 1" role="tabpanel">
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="active">Email address</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1" class="active">Password</label>
                            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                        </div>
                        <button class="btn btn-primary" @click="currentStep++">Next</button>
                    </div>
                    <div x-show="currentStep === 2" role="tabpanel">
                        <div class="form-group">
                            <label for="exampleInputFile">File input</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="exampleInputFile">
                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">Upload</span>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary" @click="currentStep--">Previous</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                Visit <a href="{{ asset('https://github.com/Johann-S/bs-stepper/#how-to-use-it') }}">documentation</a> for more examples and information about the plugin.
            </div>
        </div>
        <!-- /.card -->
    </div>
</div>

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
                  <span class="preview"><img src="{{ asset('data:,') }}" alt="" data-dz-thumbnail /></span>
              </div>
              <div class="col d-flex align-items-center">
                  <p class="mb-0">
                    <span class="lead" data-dz-name></span>
                    (<span data-dz-size></span>)
                  </p>
                  <strong class="error text-danger" data-dz-errormessage></strong>
              </div>
              <div class="col-4 d-flex align-items-center">
                  <div class="progress progress-striped active w-100" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                    <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
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
        <div class="card-footer">
          Visit <a href="{{ asset('https://www.dropzonejs.com') }}">dropzone.js documentation</a> for more examples and information about the plugin.
        </div>
      </div>
      <!-- /.card -->
    </div>
  </div>
  <!-- /.row -->
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
  url: "/upload", // Set the url
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
  file.previewElement.querySelector(".start").onclick = function() {console.log('start'); myDropzone.enqueueFile(file) }
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
}
document.querySelector("#actions .cancel").onclick = function() {
  myDropzone.removeAllFiles(true)
}
// DropzoneJS Demo Code End
})
</script>
@endscript

</div>
