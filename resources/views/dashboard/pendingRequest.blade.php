@extends('layouts.dore.app')

@section('content')
<div class="page-header">
  <div class="row">
    <div class="col-lg-12">
      <h1>Jobsite List</h1>
      <hr/>
    </div>
  </div>
  
    <div class="white_bg_main">
  <div class="mytable">
  <div class="row">
    <div class="col-lg-12">
      <div class="table-responsive">
      <table class="table table-hover table-bordered sortable_table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col" class="" width="10%">#</th>
                        <th scope="col" class="" data-col="username">Username</th>
                        <th scope="col" class="" data-col="project_name">Project Name</th>
                        <th scope="col" class="" data-col="title">Position</th>
                        <th scope="col" class="" data-col="address">Address</th>
                        <th scope="col" class="" data-col="suburb">Suburb</th>
                        <th scope="col" class="" data-col="state">state</th>
                        <th scope="col" class="" data-col="postcode">Postcode</th>
                        <th scope="col" class="" data-col="status">Status</th>
                       <th scope="col" class="text-center" width="15%">Delete</th>
                    </tr>
                </thead>
                  <tbody>
                  <?php $i=1; ?>
                      @foreach($rows as $row)
                      <tr>
                          <td class="">{{ $i++ }}</td>
                          <td class="">{{ $row->username }}</td>
                          <td class="">{{ $row->project_name }}</td>
                          <td class="">{{ $row->title }}</td>
                          <td class="">{{ $row->address }}</td>
                          <td class="">{{ $row->suburb }}</td>
                          <td class="">{{ $row->state }}</td>
                          <td class="">{{ $row->postcode }}</td>
                          
                          <td class="">
                                  <?php if($row->status==0){
                                          echo "&#10006;";
                                  }
                                  else{
                                          echo "Approved";
                                  }?>
                                  </td>
                          <!-- <td class="text-center">

                           @if($row->status==0)
                                 <form method="POST" action="{{ url('/requests/') }}">
                                     {{ csrf_field() }}
                                     <input type="hidden" name="id" value="{{$row->id}}">
                                   <input type="hidden" name="action" value="1">
                                     <button type="submit" class="btn btnbg">approve</button>
                                 </form>
                           @endif
                            
                        </td> -->
                       <td class="text-center">
                           <form method="POST" action="{{ url('/requests/') }}">
                               {{ csrf_field() }}
                               <input type="hidden" name="id" value="{{$row->id}}">
                               <input type="hidden" name="action" value="2">
                               <button type="submit" class="btn btnbg">delete</button>
                           </form>
                       </td>
                      </tr>
                      @endforeach
                  </tbody>
              </table>
                 {{ $rows->appends(request()->except('page'))->links() }}
      </div>
    </div>
  </div>
</div>
  
  
</div>
</div>
@endsection