<div x-data="tablesData">

    <div class="row">      
      <div class="col-md-12">
            <button x-on:click="show=false" class="btn btn-primary">Add</button>
            
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
    }     
    }))  
    
    document.addEventListener('livewire:initialized',async () => {   
        
        var clients = await $wire.getClients().then(res => res.original)        
        var country = await $wire.getCountry().then((res) => {
            res.original.unshift({
                id:0,
                name:'All'
            })
            return res.original
        })      
      //  console.log(clients);  
        
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
            // db.clients = $.map(db.clients, function(client) {
            //     return ($.inArray(client, deletingClients) > -1) ? null : client;
            // });
            //alert('xóa thàng công')
            console.log('gọi lên server xóa:',deletingClients);
        };

    
       
    
        

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
            //console.log('cập nhật row:',args.item);
            $("#jsGrid").jsGrid("editItem", args.item);
            
        },
        rowClick: function(args) {
            // showDetailsDialog("Edit", args.item);
            // console.log('cập nhật data:',this.data);
            console.log('cập nhật row:',args.item);
           // $("#jsGrid").jsGrid("editItem", args.item);
            
        },
        onDataLoading: function(args) {
            
            console.log('onDataLoading country_id:',country);
            console.log('onDataLoading filter:',args.filter);
            console.log(args.filter.country_id);

            // if(args.filter.country_id === 0 && filter === true){
            //     $("#jsGrid").jsGrid("option", "data", clients);
            //     return 0;
            // }

            if(args.filter.name==="" && args.filter.age===undefined && args.filter.address==="" && filter === true && args.filter.country_id === 0 ){
                console.log('reset');
                $("#jsGrid").jsGrid("option", "data", clients);
            }

            if(args.filter.name==="" && args.filter.age===undefined && args.filter.address==="" && args.filter.country_id === 0 && filter !== true ){
                args.cancel = true;  
                filter = true;
                console.log('init');
            }else{
               // console.log('filter:',args.filter);
                // // Lọc dữ liệu dựa trên filter
                idCountry = args.filter.country_id
                let filteredClients = clients.filter(client => {
                    let matchesName = args.filter.name ? client.name.toLowerCase().includes(args.filter.name.toLowerCase()) : true;
                    let matchesAge = args.filter.age ? client.age == args.filter.age : true;
                    let matchesAddress = args.filter.address ? client.address.toLowerCase().includes(args.filter.address.toLowerCase()) : true;
                    let matchesCountry = args.filter.country_id ? client.country_id == args.filter.country_id : true;

                    return matchesName && matchesAge && matchesAddress && matchesCountry;
                    //return matchesName && matchesAge;
                });
                //console.log('age:',args.filter.age);
                $("#jsGrid").jsGrid("option", "data", filteredClients);
            }

            // if (filter === true && args.filter.name === "") {
            //     args.cancel = true;
            // } else {
            //     console.log('onDataLoading:', args.filter);
            //     // console.log('Trước khi lọc:', clients);

                

            //     // console.log('Sau khi lọc:', filteredClients);

                // // Cập nhật dữ liệu trong jsGrid
                // if(args.filter.name === ""){
                //     $("#jsGrid").jsGrid("option", "data", clients);
                // }else{
                //     $("#jsGrid").jsGrid("option", "data", filteredClients);
                // }
                 
            
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
        // cancel insertion of the item with empty 'name' field
            console.log('onItemDeleted');
           
            // if(args.item.name === "") {
            //     args.cancel = true;
            //     alert("Specify the name of the item!");
            // }
        },
        

        

        //controller: db,
        data:clients,
             
 
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
            { name: "name", type: "text", title:"Name" , width: 150, validate: "required" },
            { 
                name: "age", type: "number", width: 50,
                validate: {
                    validator: "range",
                    message: function(value, item) {
                        return "The client age should be between 18 and 99. Entered age is \"" + value + "\" is out of specified range.";
                    },
                    param: [18, 99]
                }
            },
            { name: "address", type: "text", width: 200 },
            { name: "country_id", type: "select", title:"Country" , items: country, valueField: "id", textField: "name" },
            { name: "married", type: "checkbox", title: "Is Married", sorting: false },
            {
                type: "control",     
                modeSwitchButton: true,     
                searchButton: true,     
                editButton: true,     
                autosearch: false,    
                filtering: true,  
                searchModeButtonTooltip: "Switch to searching", 
                searchButtonTooltip: "Search",
                width: 150,
            }
            // {
            //     type: "control",
            //     modeSwitchButton: false,
            //     editButton: false,
            //     headerTemplate: function() {
            //         return $("<button>").attr("type", "button").text("Add")
            //                 .on("click", function () {
            //                     showDetailsDialog("Add", {});
            //                 });
            //     }
            // }
        ]
    });  
 
   });

   </script>
   
    @endscript
    