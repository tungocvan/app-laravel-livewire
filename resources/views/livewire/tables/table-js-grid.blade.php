<div x-data="tablesData">

    <div class="row">
      <div class="col-md-12"><div id="jsGrid"></div></div>
    </div>
  
   
  </div>
  
   @script
   <script>
    Alpine.data("tablesData", () => ({
        init(){                                  
        }     
    }))  
    
    document.addEventListener('livewire:initialized',async () => {   
        
        var clients = await $wire.getClients().then(res => res.original)        
        var country = await $wire.getCountry().then(res => res.original)      
      //  console.log(clients);  
        
        var selectedItems = [];
 
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
        autosearch: true,
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
                align: "center",
                width: 50
            },
            { name: "name", type: "text", title:"Name" , width: 150, validate: "required"  },
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
    