<div>

    <div class="row">
      <div class="col-md-12"><div id="jsGrid"></div></div>
    </div>
  
   
  </div>
  
   @script
   <script>
    Alpine.data("tablesData", () => ({
        init(){
            
            $("#detailsDialog").dialog({
            autoOpen: false,
            width: 400,
            close: function() {
                $("#detailsForm").validate().resetForm();
                $("#detailsForm").find(".error").removeClass("error");
            }
            });
        
            $("#detailsForm").validate({
                rules: {
                    name: "required",
                    age: { required: true, range: [18, 150] },
                    address: { required: true, minlength: 10 },
                    country: "required"
                },
                messages: {
                    name: "Please enter name",
                    age: "Please enter valid age",
                    address: "Please enter address (more than 10 chars)",
                    country: "Please select country"
                },
                submitHandler: function() {
                    formSubmitHandler();
                }
            });
        }
    }))  
    
    document.addEventListener('livewire:initialized', async () => {   

        var clients = await $wire.getClients().then(res => res.original)        
        var country = await $wire.getCountry().then(res => res.original)      
        console.log(clients);  
        
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

    
        var formSubmitHandler = $.noop;
        
        var showDetailsDialog = function(dialogType, client) {
            $("#name").val(client.Name);
            $("#age").val(client.Age);
            $("#address").val(client.Address);
            $("#country").val(client.Country);
            $("#married").prop("checked", client.Married);

            formSubmitHandler = function() {
                saveClient(client, dialogType === "Add");
            };

            $("#detailsDialog").dialog("option", "title", dialogType + " Client")
                    .dialog("open");
        };

        var saveClient = function(client, isNew) {
            $.extend(client, {
                Name: $("#name").val(),
                Age: parseInt($("#age").val(), 10),
                Address: $("#address").val(),
                Country: parseInt($("#country").val(), 10),
                Married: $("#married").is(":checked")
            });

            $("#jsGrid").jsGrid(isNew ? "insertItem" : "updateItem", client);

            $("#detailsDialog").dialog("close");
        };
 
    $("#jsGrid").jsGrid({
        width: "100%",
        height: "100%",
        
        filtering: true,
        inserting: true,
        editing: true,
        sorting: true,
        confirmDeleting: false,
        paging: true,
        autoload: true,        
        pageSize: 10,
        pageButtonCount: 5,
 
        deleteConfirm: function(item) {
            return "The client \"" + item.Name + "\" will be removed. Are you sure?";
        },
        rowClick: function(args) {
            showDetailsDialog("Edit", args.item);
            console.log('cập nhật row:',args.item);
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
            { name: "name", type: "text", title:"Name" , width: 150, validate: "required" },
            { name: "age", type: "number", width: 50 },
            { name: "address", type: "text", width: 200 },
            { name: "country_id", type: "select", title:"Country" , items: country, valueField: "id", textField: "name" },
            { name: "married", type: "checkbox", title: "Is Married", sorting: false },
            {
                type: "control"          
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
    