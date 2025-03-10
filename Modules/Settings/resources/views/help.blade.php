@extends('adminlte::page')

@section('title', 'Settings')

@section('content_header')

@stop

@section('content')

<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-sm-12 col-md-10 ">
                <button type="button" style="width: 100px;" class="btn btn-outline-success btn-sm mr-2 "><i class="fa fa-plus"></i> Add</button> 
                <button type="button" style="width: 100px;" class="btn btn-outline-danger btn-sm"><i class="fa fa-trash"></i> Delete All</button>             
                <div class="btn btn-outline-success btn-sm btn-file">
                    <i class="fas fa-paperclip"></i> Attachment
                    <input type="file" name="attachment">
                  </div>
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
            <th>User</th>
            <th>Date</th>
            <th>Status</th>
            <th>Reason</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td> 
                <div class="form-check">
                    <input type="checkbox" class="form-check-input">                
                </div>
            </td>
            <td>183</td>
            <td>John Doe</td>
            <td>11-7-2014</td>
            <td><span class="tag tag-success">Approved</span></td>
            <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
            <td>
                <div class="btn-group flex-wrap d-flex">
                    <button type="button" class="btn btn-outline-primary btn-sm mr-1"><i class="fa fa-edit"></i> Edit</button>
                    <button type="button" class="btn btn-outline-danger btn-sm"><i class="fa fa-trash"></i> Delete</button>
                </div>
            </td>
          </tr>
          <tr>
            <td> 
                <div class="form-check">
                    <input type="checkbox" class="form-check-input">                
                </div>
            </td>
            <td>183</td>
            <td>John Doe</td>
            <td>11-7-2014</td>
            <td><span class="tag tag-success">Approved</span></td>
            <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
            <td>
                <div class="btn-group flex-wrap d-flex">
                    <button type="button" class="btn btn-outline-primary btn-sm mr-1"><i class="fa fa-edit"></i> Edit</button>
                    <button type="button" class="btn btn-outline-danger btn-sm"><i class="fa fa-trash"></i> Delete</button>
                </div>
            </td>
          </tr>
       
        </tbody>
      </table>
    </div>
    <!-- /.card-body -->
    <div class="card-footer clearfix">
        <div class="row"><div class="col-sm-12 col-md-5"><div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Showing 1 to 10 of 57 entries</div></div><div class="col-sm-12 col-md-7"><div class="dataTables_paginate paging_simple_numbers" id="example2_paginate"><ul class="pagination"><li class="paginate_button page-item previous disabled" id="example2_previous"><a href="#" aria-controls="example2" data-dt-idx="0" tabindex="0" class="page-link">Previous</a></li><li class="paginate_button page-item active"><a href="#" aria-controls="example2" data-dt-idx="1" tabindex="0" class="page-link">1</a></li><li class="paginate_button page-item "><a href="#" aria-controls="example2" data-dt-idx="2" tabindex="0" class="page-link">2</a></li><li class="paginate_button page-item "><a href="#" aria-controls="example2" data-dt-idx="3" tabindex="0" class="page-link">3</a></li><li class="paginate_button page-item "><a href="#" aria-controls="example2" data-dt-idx="4" tabindex="0" class="page-link">4</a></li><li class="paginate_button page-item "><a href="#" aria-controls="example2" data-dt-idx="5" tabindex="0" class="page-link">5</a></li><li class="paginate_button page-item "><a href="#" aria-controls="example2" data-dt-idx="6" tabindex="0" class="page-link">6</a></li><li class="paginate_button page-item next" id="example2_next"><a href="#" aria-controls="example2" data-dt-idx="7" tabindex="0" class="page-link">Next</a></li></ul></div></div></div>
      </div>
  </div>

@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}

@stop

@section('js')
     {{-- https://www.daterangepicker.com/#examples  --}}
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>

@stop
