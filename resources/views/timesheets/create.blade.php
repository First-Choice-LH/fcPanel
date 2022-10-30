@extends('layouts.dore.app')

@section('content')
<div class="page-header">
	<div class="row">
		<div class="col-lg-12">
			<h1>Timesheet</h1>
			<hr/>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12 card">			
			
            @if($errors->any())
                <br/>
			    <div class="alert alert-danger">
			        <ul>
			            @foreach ($errors->all() as $error)
			                <li>{{ $error }}</li>
			            @endforeach
			        </ul>
			    </div>
			@endif

			<form role="form" method="post" action="{{ route('timesheets.save') }}" class="card-body">
				{{ csrf_field() }}
                <input type="hidden" name="jobsite_id" value="{{ $jobsite_id }}"/>
                <input type="hidden" name="employee_id" value="{{ $employee_id }}"/>
                <div class="table-responsive">
                    @if(isset($jobsite) AND isset($employee))
                    <table class="table">
                        <tr scope="col">
                            <th>Jobsite:</th>
                            <th style="font-weight:normal;">{{ $jobsite->title }}</th>
                            <th>Employee:</th>
                            <th style="font-weight:normal;">{{ $employee->first_name.' '.$employee->last_name }}</th>
                        </tr>
                    </table>
                    @endif
                    <table class="table">
                        <thead>
                            <tr scope="col">
                                <th class="text-center">Date</th>
                                <th class="text-center">Start</th>
                                <th class="text-center">End</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for($i=0; $i < sizeof($week); $i++)
                            <tr scope="row">
                                <td>
                                    <input type="hidden" name="id[]" value="{{ (isset($rows[$i])) ? $rows[$i]->id : null }}"/>                                    
                                    <input type="hidden" name="date[]" value="{{ $week[$i]->format('Y-m-d') }}"/>
                                    {{ $week[$i]->format("d M, Y") }}
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="start[]" aria-describedby="start" placeholder="Start" value="{{ (!isset($rows[$i])) ? '09:00 AM' : date('h:i A', strtotime($rows[$i]->start)) }}" />
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="end[]" aria-describedby="end" placeholder="End" value="{{ (!isset($rows[$i])) ? '05:00 PM' : date('h:i A', strtotime($rows[$i]->end)) }}" />
                                </td>
                                <td>
                                    <select name="status[]" class="form-control">
                                        <option value="1" @if( old('status', (isset($rows[$i])) ? $rows[$i]->status : 1) == true ) selected="selected" @endif>Active</option>
                                        <option value="0" @if( old('status', (isset($rows[$i])) ? $rows[$i]->status : 1) == false )  selected="selected" @endif>Inactive</option>
                                    </select>
                                </td>
                            </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
				<div class="form-group row">
					<div class="col-lg-12 text-center">
						<button type="submit" class="btn btnbg btn-success">Save</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection