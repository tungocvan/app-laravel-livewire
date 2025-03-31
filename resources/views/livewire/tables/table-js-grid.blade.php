<div x-data="tablesData">

    <div class="row">      
      <div class="col-md-12 mb-2">
            <button x-on:click="hanlderShow" class="btn btn-primary">Add</button>
            
      </div>
      <div class="col-md-12"><div id="jsGrid"></div></div>
    </div>

    <div x-transition class="modal fade show" :class="show ? '' :'d-block' " id="myModal">
        <!-- Overlay backdrop -->
        <div class="modal-backdrop fade show"></div>
      
        <!-- Modal chính -->
        <div class="modal-dialog modal-dialog-centered" style="z-index:1050">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Default Modal</h4>
              <button x-on:click="show=true" type="button" class="close">
                <span>&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>One fine body…</p>
            </div>
            <div class="modal-footer">
              <button x-on:click="show=true" type="button" class="btn btn-default">Close</button>
              <button x-on:click="show=true" type="button" class="btn btn-primary">Save changes</button>
            </div>
          </div>
        </div>
      </div>
      
         
    
</div>
   
   @script
   <script>
    Alpine.data("tablesData", () => ({
        show:true,
        init(){   
            var selectedItems = [];
            var filter = false; 
            var idCountry = 1;
            var selectItem = function(item) {
                selectedItems.push(item);
            };

        

            var unselectItem = function(item) {
                selectedItems = $.grep(selectedItems, function(i) {
                    return i !== item;
                });
            };

            var deleteSelectedItems = function() {
                if(!selectedItems.length || !confirm("Are you sure?"))
                    return;

                deleteClientsFromDb(selectedItems);

                var $grid = $("#jsGrid");
                $grid.jsGrid("option", "pageIndex", 1);
                $grid.jsGrid("loadData");

                selectedItems = [];
            };

            var deleteClientsFromDb = function(deletingClients) {          
                console.log('gọi lên server xóa:',deletingClients);
            };

            function openEditModal(item) {
                // Điền dữ liệu vào modal
                //hanlderShow()
              console.log(this.show);
            }
                
        
            

            $("#jsGrid").jsGrid({
                width: "100%",
                height: "100%",
                
                readOnly: false,
                filtering: true,               
                inserting: true,
                editing: true,
                sorting: true,
                confirmDeleting: true,
                paging: true,
                autoload: true,        
                pageSize: 10,
                pageButtonCount: 5,
                
                
            
                deleteConfirm: function(item) {
                    return "The client \"" + item.name + "\" will be removed. Are you sure?";
                },

                rowDoubleClick: function(args) {
                    // showDetailsDialog("Edit", args.item);
                    console.log('cập nhật rowDoubleClick:',args.item);
                    $("#jsGrid").jsGrid("editItem", args.item);
                    
                },
                rowClick: function(args) {
                    // showDetailsDialog("Edit", args.item);
                // console.log('cập nhật data:',this.data);
                    console.log('cập nhật rowClick:',args.item);
                // $("#jsGrid").jsGrid("editItem", args.item);
                    
                },
                onDataLoading: function(args) {                  
                    console.log('onDataLoading');            
                },
        
                onItemInserted: function(args) {
                // cancel insertion of the item with empty 'name' field
                    console.log('onItemInserted:',args.item);
                    if(args.item.name === "") {
                        args.cancel = true;
                        alert("Specify the name of the item!");
                    }
                },
                onItemUpdated: function(args) {
                // cancel insertion of the item with empty 'name' field
                    console.log('onItemUpdated:');
                    if(args.item.name === "") {
                        args.cancel = true;
                        alert("Specify the name of the item!");
                    }
                },

                onItemDeleted: function(args) {      
                    console.log('onItemDeleted:',args.item);           
                
                },
                
                // Thêm sự kiện khi hàng được chỉnh sửa
                onItemEditing: function(args) {
                    // Ngăn hành động chỉnh sửa mặc định
                    args.cancel = true; // Ngăn không cho jsGrid mở form chỉnh sửa tự động

                    console.log('open modal here');
                    //hanlderShow()
                openEditModal(args.item);
                    // Mở modal với dữ liệu của item được nhấn
                // openEditModal(args.item);
                },
                

                //controller: db,
                //data:clients,
                data: @json($db),     
                
                controller: {
                    loadData: function(filter) {
                        // Lọc dữ liệu theo các tiêu chí tìm kiếm
                        console.log('loadData');
                        filteredData =null
                        if(filter.name !=="" || filter.age!==undefined || filter.address !=="" || filter.country_id !==0 ){
                            //console.log(@json($db));
                            console.log('filteredData');
                                filteredData = @json($db).filter(item => {
                                return (!filter.name || item.name.includes(filter.name)) && (!filter.age || item.age === filter.age) && (!filter.address || item.address.includes(filter.address)) && (!filter.country_id || item.country_id === filter.country_id)
                            });
                        }

                        return filteredData ?? @json($db);
                        
                    },
                    insertItem: function(item) {
                        @this.addData(item);
                    },
                    updateItem: function(item) {
                        @this.updateData(item);
                    },
                    deleteItem: function(item) {
                        @this.deleteData(item.id);
                    }
                },

                fields: [
                    {
                        headerTemplate: function() {
                            return $("<button>").attr("type", "button").text("Delete")
                                    .on("click", function () {
                                        deleteSelectedItems();
                                    });
                        },
                        itemTemplate: function(_, item) {
                            return $("<input>").attr("type", "checkbox")
                                    .prop("checked", $.inArray(item, selectedItems) > -1)
                                    .on("change", function () {
                                        $(this).is(":checked") ? selectItem(item) : unselectItem(item);
                                    });
                        },
                        filterValue: function() { 
                            console.log('filterValue:',filter);
            
                        },
                    
                        align: "center",
                        width: 50,
                    },
                    { name: "name", type: "text", title:"Name" , width: 150, validate: "required", filtering: true  },
                    { 
                        name: "age", type: "number", width: 50, filtering: true,
                        validate: {
                            validator: "range",
                            message: function(value, item) {
                                return "The client age should be between 18 and 99. Entered age is \"" + value + "\" is out of specified range.";
                            },
                            param: [18, 99]
                        }
                    },
                    { name: "address", type: "text", width: 200 ,  filtering: true},
                    { name: "country_id", type: "select", title:"Country" , items: @json($country), valueField: "id", textField: "name" , filtering: true},
                    { name: "married", type: "checkbox", title: "Is Married", sorting: false },          
                    {
                        type: "control",     
                        modeSwitchButton: true,     
                        searchButton: true,     
                        editButton: true,     
                        autosearch: true,    
                        filtering: true,  
                        searchModeButtonTooltip: "Switch to searching", 
                        searchButtonTooltip: "Search",
                        width: 150,
                    }

                ]
            });                                 
        },
        hanlderShow(){
            console.log('hanlderShow');
            this.show = !this.show
        }    
    }))  
    
    document.addEventListener('livewire:initialized', () => {        
  
 
   });

   </script>
   
    @endscript
    