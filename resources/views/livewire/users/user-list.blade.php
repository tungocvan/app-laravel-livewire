<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-sm-12 col-md-10" style="display:inline-flex">
                <button type="button" style="width: 100px;" class="btn btn-outline-success btn-sm"><i class="fa fa-plus"></i> Add</button> 
                <button type="button" style="width: 100px;" class="btn btn-outline-danger btn-sm mx-2"><i class="fa fa-trash"></i> Delete All</button>             
                <form wire:submit="importFile">
                    <div class="btn btn-outline-success btn-sm btn-file" x-data="{ uploading: false }">
                        <!-- Hiển thị trạng thái chờ -->
                        <i class="fas fa-paperclip"></i> Import Excel
                        <input type="file" wire:model="file"  wire:disabled="isImporting"> 
                        <span class="help-block">Max 32MB</span> 
                        @error('file') <span class="error">{{ $message }}</span> @enderror                                        
                    </div>
                   
                    <button x-show="uploading" type="submit" style="width: 100px;" class="btn btn-outline-success btn-sm">Upload File</button> 
                    <div wire:loading wire:target="file">Uploading...</div>   
                </form>
                
            </div>            
        </div>
        <div class="row mt-2">
            <div class="col-sm-12 col-md-10 d-flex">               
                <div class="form-group mr-2" style="width:150px">                    
                    <select class="form-control custom-select">                      
                      <option>Show 10 rows</option>
                      <option>Show 25 rows</option>
                      <option>Show 50 rows</option>
                      <option>Show 100 rows</option>                      
                    </select>
                </div>
                <div>
                    <button class="btn buttons-print btn-default" tabindex="0" aria-controls="table7" type="button" title="Print"><span><i class="fas fa-fw fa-lg fa-print"></i></span></button> 
                    <button class="btn buttons-csv buttons-html5 btn-default" tabindex="0" aria-controls="table7" type="button" title="Export to CSV"><span><i class="fas fa-fw fa-lg fa-file-csv text-primary"></i></span></button> 
                    <button class="btn buttons-excel buttons-html5 btn-default" tabindex="0" aria-controls="table7" type="button" title="Export to Excel"><span><i class="fas fa-fw fa-lg fa-file-excel text-success"></i></span></button> 
                    <button class="btn buttons-pdf buttons-html5 btn-default" tabindex="0" aria-controls="table7" type="button" title="Export to PDF"><span><i class="fas fa-fw fa-lg fa-file-pdf text-danger"></i></span></button> 
                </div>               
            </div>
            <div class="col-sm-12 col-md-2">
                <div class="input-group input-group-sm float-right">
                    <input type="text" name="table_search" class="form-control" placeholder="Search">
                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default">
                        <i class="fas fa-search"></i>
                      </button>
                    </div>
                  </div>
            </div>
        </div>
        
    </div>
    <!-- /.card-header -->
    <div class="card-body table-responsive p-0">
      <table class="table table-hover text-nowrap">
        <thead>
          <tr>
            <th>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input form-check-label">
                    <label class="form-check-label" for="exampleCheck1"></label>
                </div>
            </th>            
            <th>ID</th>
            <th><a href="#" wire:click.prevent="sortBy('name')">Name</a></th>
            <th><a href="#" wire:click.prevent="sortBy('email')">Email</a></th>
            <th>Roles</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
            @foreach($this->users as $user)
                <tr>
                    <td> 
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input">                
                        </div>
                    </td>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if(!empty($user->getRoleNames()))
                          @foreach($user->getRoleNames() as $v)
                             <label class="badge bg-success">{{ $v }}</label>
                          @endforeach
                        @endif
                    </td>
                    <td>
                        <div class="btn-group flex-wrap d-flex">
                            <button wire:click="edit({{ $user->id }})" class="btn btn-outline-primary btn-sm mr-1"><i class="fa fa-edit"></i> Edit</button>
                            <button wire:click="delete({{ $user->id }})" class="btn btn-outline-danger btn-sm"><i class="fa fa-trash"></i> Delete</button>
                        </div>
                    </td>
                </tr>
            @endforeach    
       
        </tbody>
      </table>
    </div>
    <!-- /.card-body -->
    <div class="card-footer clearfix">
        <div class="row"><div class="col-sm-12 col-md-5"><div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Showing 1 to 10 of 57 entries</div></div><div class="col-sm-12 col-md-7"><div class="dataTables_paginate paging_simple_numbers" id="example2_paginate"><ul class="pagination"><li class="paginate_button page-item previous disabled" id="example2_previous"><a href="#" aria-controls="example2" data-dt-idx="0" tabindex="0" class="page-link">Previous</a></li><li class="paginate_button page-item active"><a href="#" aria-controls="example2" data-dt-idx="1" tabindex="0" class="page-link">1</a></li><li class="paginate_button page-item "><a href="#" aria-controls="example2" data-dt-idx="2" tabindex="0" class="page-link">2</a></li><li class="paginate_button page-item "><a href="#" aria-controls="example2" data-dt-idx="3" tabindex="0" class="page-link">3</a></li><li class="paginate_button page-item "><a href="#" aria-controls="example2" data-dt-idx="4" tabindex="0" class="page-link">4</a></li><li class="paginate_button page-item "><a href="#" aria-controls="example2" data-dt-idx="5" tabindex="0" class="page-link">5</a></li><li class="paginate_button page-item "><a href="#" aria-controls="example2" data-dt-idx="6" tabindex="0" class="page-link">6</a></li><li class="paginate_button page-item next" id="example2_next"><a href="#" aria-controls="example2" data-dt-idx="7" tabindex="0" class="page-link">Next</a></li></ul></div></div></div>
      </div>
</div>
