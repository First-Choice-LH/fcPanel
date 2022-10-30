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
    <div class="row">
    <div class="col-lg-8">
      
    </div>
     @if((isset($approve['rows']) && count($approve['rows'])>0) || (isset($notapprove['rows']) && count($notapprove['rows'])>0))
    <div class="col-lg-4 text-right">
      <a href="/employee/jobsites/request" class="btn btnbg btn-primary">{{ __('REQUEST JOBSITE') }}</a>
      <br/><br/>
    </div>
  </div>
    
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
               
                <table class="table table-hover table-bordered sortable_table">
                    <thead class="thead-dark">
                        <tr>
                            <div class="col-lg-12">
                                <h1>Approved Jobsites</h1>
                                <hr/>
                            </div>
                            <th scope="col" class="text-center" width="10%">#</th>
                            <th scope="col" class="text-center" data-col="company_name">Company</th>
                            <th scope="col" class="text-center" data-col="address">Jobsite Address</th>
                            <th scope="col" class="text-center">Status</th>    
                            <th scope="col" class="text-center" width="15%">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php $i=1; ?>
                        @foreach($approve['rows'] as $row)
                            @if($row->status==0)
                            @continue
                            @endif 
                         <tr>
                             <td class="text-center">{{ $i++ }}</td>
                             <td class="text-center">{{ $row->company_name }}</td>
                             <td class="text-center">{{ $row->address }}</td>
                             <td class="text-center">{{ "Approved" }}</td>
                             <td class="text-center">
                               <a class="btn btnbg" href="{{ url('/employee/jobsites/timesheet/'.$row->client_id.'/'.$row->id.'/'.$row->employee_id) }}">Timesheet</a>
                           </td>
                         </tr>
                               
                        @endforeach 
                     </tbody>
                </table>
                    {{ $approve['rows']->appends(request()->except($approve['rows']->currentPage()))->links() }}    
                <table class="table table-hover table-bordered sortable_table">
                    <thead class="thead-dark">
                        <tr>
                            <div class="col-lg-12">
                                <h1>Pending Jobsite Request</h1>
                                <hr/>
                            </div>
                            <th scope="col" class="text-center" width="10%">#</th>
                            <th scope="col" class="text-center" data-col="project_name">Project Name</th>
                            <th scope="col" class="text-center" data-col="title">Position</th>
                            <th scope="col" class="text-center" data-col="address">Address</th>
                            <th scope="col" class="text-center" >Status</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                      <?php $i=1; ?>
                        @foreach($notapprove['rows'] as $row)
                            @if($row->status==1)
                                @continue
                            @endif
                         <tr>
                             <td class="text-center">{{ $i++ }}</td>
                             <td class="text-center">{{ $row->project_name }}</td>
                             <td class="text-center">{{ $row->title }}</td>
                             <td class="text-center">{{ $row->address }}</td>
                           
                             <td class="text-center">{{ "Not Approved" }}</td>
                         </tr>
                        @endforeach 
                     </tbody>
                </table>
                {{ $notapprove['rows']->appends(request()->except($notapprove['rows']->currentPage()))->links() }}
                @else
                <div class="row">
                    <div class="col-md-12">
                        <h3>{{'There are no jobsites or companies assigned to your account yet.'}}</h3>
                         <div class="col-lg-4 text-right">
                          <a href="/employee/jobsites/request" class="btn btnbg btn-primary">{{ __('REQUEST JOBSITE') }}</a>
                          <br/><br/>
                        </div>
                    </div>
                </div>
                @endif 
                    
                 
              </div>
            </div>
        </div>
    </div>
</div>

</div>
@endsection

@section('script')
<script type="text/javascript">
    
</script>
@endsection