<div>

  

  <div class="row" x-data="formData">
    <div class="col-md-6">
        <div class="card card-primary"> 
            <div class="card-header">
              <h3 class="card-title">Quick Example</h3>
            </div>
            <!-- form start -->
            <form @submit.prevent="getDataForm">
              <div class="card-body">              
                <div class="form-group">
                  <label for="exampleInputEmail1" class="active">Email address</label>
                  <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email" x-model="email">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1" class="active">Password</label>
                  <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" x-model="password">
                </div>
                <div class="form-group">
                  
                  <div class="input-group">
                    <div :class="file ? 'col-10' : 'col-12'">
                      <label for="exampleInputFile">File input</label>
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="exampleInputFile" @change="handleFile">
                        <label class="custom-file-label" for="exampleInputFile" x-text="fileName">Choose file</label>
                      </div> 
                    </div>
                    <div class="col-2 " style="align-items:center" x-show="file">
                      <div class="text-center">
                        <img  class="profile-user-img img-fluid img-circle" src="https://adminlte.io/themes/v3/dist/img/user4-128x128.jpg" alt="User profile picture" style="height: 100px">
                      </div>
                    </div>
                                       
                    
                  </div>
                </div>
                <div class="form-group">
                 <label>Select an option</label>
                 <select class="js-example-responsive" style="width: 100%"  x-model="selectedOption">
                     <template x-for="option in options" :key="option">
                         <option x-text="option" :value="option"></option>
                     </template>
                 </select>
                </div>
                
                <div class="form-group">
                  <label>Select multiple options</label>
                  <select class="js-example-basic-multiple form-control" multiple x-model="selectedOptions">
                      <template x-for="option in options" :key="option">
                          <option x-text="option" :value="option"></option>
                      </template>
                  </select>
                </div> 
  
                <div class="form-group">
                  <label>Date:</label>
                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                        <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate" x-model="selectedDate" >
                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>
  
                <div class="form-group d-flex flex-row">
                  <div class="custom-control custom-radio">
                    <input class="custom-control-input" type="radio" id="customRadio1" name="gender" value="Nam" x-model="gender">
                    <label for="customRadio1" class="custom-control-label">Nam</label>
                  </div>
                  <div class="custom-control custom-radio mx-2">
                    <input class="custom-control-input" type="radio" id="customRadio2" name="gender" value="Nữ" x-model="gender">
                    <label for="customRadio2" class="custom-control-label">Nữ</label>
                  </div>
                </div>
  
                <div class="form-check">
                  <input type="checkbox" class="form-check-input" id="exampleCheck1" x-model="checked">
                  <label class="form-check-label" for="exampleCheck1">Check me out</label>
                </div>
                
              </div>
              <!-- /.card-body -->
  
              <div class="card-footer">
                 <button type="submit" class="btn btn-primary">Get Data</button>
              </div>
            </form>
          </div>
    </div>
  </div>
 
</div>

 @script
 <script>
  
  Alpine.data("formData", () => ({          
            email: "",
            password: "",
            fileName: "Choose file",
            file:null,
            selectedOption: "",
            selectedOptions: [],
            options: ["Alabama", "Wyoming", "Texas", "California"],
            selectedDate:"",
            checked: false,
            gender: "Nam",

            init(){
              console.log('init');              
              $('.js-example-responsive').select2({ theme: "classic" }).on('change', function (e) {
                 this.selectedOption = $(this).val();                                 
              });
              $('.js-example-basic-multiple').select2({ theme: "classic" }).on('change', function (e) {
                  this.selectedOptions = $(this).val();                  
              });
              $('#reservationdate').daterangepicker({
                  singleDatePicker: true,
                  showDropdowns: true,
                  autoUpdateInput: false,
                  locale: {
                      format: 'DD/MM/YYYY'
                  }
              }).on('apply.daterangepicker', function (ev, picker) {     
                  $("#reservationdate").find('input').val(picker.startDate.format('DD/MM/YYYY'));    
              });
            },

            handleFile(event) {
              this.file = event.target.files[0];
              this.fileName = this.file ? this.file.name : "Choose file";
              if(this.file){
                $('.profile-user-img').attr("src",URL.createObjectURL(this.file));                
              }
              // console.log('file:',URL.createObjectURL(this.file));
            },

            getDataForm() {
              //console.log({email: this.emai,password: this.password,fileName: this.fileName});
              this.selectedOption = $('.js-example-responsive').val();
              this.selectedOptions = $('.js-example-basic-multiple').val();
              this.selectedDate = $("#reservationdate").find('input').val();
              console.log({
                  email: this.email,
                  password: this.password,
                  file: this.file,
                  checked: this.checked,
                  gender: this.gender,
                  selectedDate: this.selectedDate,
                  selectedOption: this.selectedOption,
                  selectedOptions: this.selectedOptions
              });
           }
      }))  
     

  </script>
 
  @endscript
  