@extends('layouts.dore.app')

@section('content')
<div class="page-header">
	<div class="row">
		<div class="col-lg-12">
			<h1>Timesheet List</h1>
			<hr/>
		</div>
	</div>
    <div class="white_bg_main">
	<div class="row">
		<div class="col-lg-12">
            <form class="row" method="get" action="{{ url('timesheets') }}">             
                <div class="col-lg-3 form-group">       
                    <label class="">Company</label>             
                    <select name="client_id" class="select2-single">
                        <option value="">Select Company</option>
                        @foreach ($clients as $client)
                        <option value="{{ $client->id }}" @if(isset($_GET['client_id']) AND $_GET['client_id'] == $client->id ) selected="selected" @endif>
                            {{ $client->company_name }}
                        </option>
                        @endforeach
                    </select>
                </div>          
                <div class="col-lg-3 form-group">             
                    <label class="">Job Site</label>            
                    <select name="id" class="select2-single">
                        <option value="">Select Jobsite</option>
                        @if(isset($jobsites))
                            @foreach ($jobsites as $jobsite)
                            <option value="{{ $jobsite->id }}" @if(isset($_GET['id']) AND $_GET['id'] == $jobsite->id ) selected="selected" @endif>
                            {{ $jobsite->title }}
                            </option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-lg-3 form-group">        
                    <label class="">Date</label> 
                    <input type="text" name="date" pattern="{2}\/{2}\/{4}" value="{{ \Request::get('date') }}" class="datepicker form-control"/>
                </div>
                <div class="col-lg-1 form-group text-center">
                    <label style="color:transparent;">Action</label> 
                    <a href="" class="btn btnbg btnbig">Fetch</a>
                </div>
                @if(sizeof($rows) > 0)
                <div class="col-lg-6 text-left">
                <a class="btn btnbg" href="{{ route('timesheets.dump', ['id'=>\Request::get('id') , 'date'=>\Request::get('date')] ) }}">Download CSV</a>
                </div>
                @else
                <div class="col-lg-6 text-left"></div>
                @endif
            </form>
		</div>
		<div class="col-lg-6"></div>
	</div>
    <div class="mytable">
	<div class="row">
		<div class="col-lg-12">
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col" class="d-none d-md-table-cell" width="10%">#</th>
                            <th scope="col" class="">Employee</th>
                            <th scope="col" class="">Date</th>
                            <th scope="col" class="d-none d-md-table-cell">Start</th>
                            <th scope="col" class="d-none d-md-table-cell">End</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rows as $row)
                        <tr>
                            <td scope="row" class="d-none d-md-table-cell">{{ $row->id }}</td>
                            <td scope="row" class="">{{ $row->employee->first_name.' '.$row->employee->last_name }}</td>
                            <td scope="row" class="">{{ $row->date }}</td>
                            <td scope="row" class="d-none d-md-table-cell">{{ date("h:i A", strtotime($row->start)) }}</td>
                            <td scope="row" class="d-none d-md-table-cell">{{ date("h:i A", strtotime($row->end)) }}</td>                            
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @if(\Request::get('id') > 0)
                {{ $rows->appends($_GET)->links() }}
                @else
                {{ $rows->links() }}
                @endif
            </div>
		</div>
	</div>
</div>
</div>
</div>
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function(event) {
        $("select[name=client_id]").on('change', function(){
            var client_id = $("select[name=client_id]").val();
            var ajax_get_jobsites_url = "{{ url('/api/client_jobsites/') }}/"+client_id;
            
            $.get(ajax_get_jobsites_url, function(response){
                var jsondata = $.parseJSON(response);
                var html = '<option value="">Select Jobsite</option>';
                for(var i=0; i<jsondata.length; i++)
                {
                    html += '<option value="'+jsondata[i].id+'">'+jsondata[i].title+'</option>';
                }

                $("select[name=id]").html(html);
            });
        })
    });
</script>
@endsection

@section('script')
<script type="text/javascript">
    
</script>
@endsection