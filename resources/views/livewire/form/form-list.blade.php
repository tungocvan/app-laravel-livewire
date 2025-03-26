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

            </div>
            <!-- /.card-body -->

            <div class="card-footer">
               <button type="submit" class="btn btn-primary">Get Data</button>
            </div>
          </form>
        </div>
  </div>
 </div>
 @script
 <script>
  
 Alpine.data("formData", () => ({          
          selectedOption: "",
          selectedOptions: [],
          options: ["Alabama", "Wyoming", "Texas", "California"],
          selectedDate:"",
          gender: "Nam",
          
          getDataForm() {
              console.log({gender:this.gender, selectedOption:this.selectedOption});
             // alert(`Email: ${this.email}\nPassword: ${this.password}\nFile: ${this.fileName}\nChecked: ${this.checked}\nGender: ${this.gender}\nOption: ${this.selectedOption}\nMultiple Options: ${this.selectedOptions.join(", ")}`);
          }
      }));
  
  document.addEventListener('livewire:initialized', () => {   
     

    $('.js-example-responsive').select2({ theme: "classic" }).on('change', function (e) {
       this.selectedOption = $(this).val();
       console.log($(this).val());
    });
    $('.js-example-basic-multiple').select2({ theme: "classic" }).on('change', function (e) {
        this.selectedOptions = $(this).val();
        console.log($(this).val());
    });

    $('#reservationdate').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        autoUpdateInput: false,
        locale: {
            format: 'DD/MM/YYYY'
        }
    }).on('apply.daterangepicker', function (ev, picker) {
        this.date = picker.startDate.format('DD/MM/YYYY');
        $(this).find('input').val(this.date);
        console.log(this.date);
    });

  })  
 
 
  </script>
  
  @endscript