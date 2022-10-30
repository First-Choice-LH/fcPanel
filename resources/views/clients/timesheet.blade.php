@extends('layouts.dore.app')

@section('content')
<div class="page-header">
	<div class="row">
		<div class="col-lg-12">
			<h1>Employee Timesheet</h1>
			<hr/>
		</div>
	</div>

    <div class="d-none d-lg-block">
        <div class="row">
            <div class="col-lg-4 text-right">
                <a href="{{ $previousWeek }}" class="btn btnbg btn-info"><</a><br/>
            </div>
            <div class="col-lg-4 text-center">
                <h4>Week of {{ $week[0]->format('d M') }} - {{ $week[count($week)-1]->format('d M, Y') }}</h4>
                <br/>                
            </div>
            <div class="col-lg-4 text-left">
                <a href="{{ $nextWeek }}" class="btn btnbg btn-info">></a><br/>
            </div>
        </div>
    </div>

    <div class="d-lg-none table-responsive">
        <table class="table">
            <tr>
                <td class="text-left">
                    <a href="{{ $previousWeek }}" class="btn btnbg btn-info"><</a><br/>
                </td>
                <td class="text-right">
                    <a href="{{ $nextWeek }}" class="btn btnbg btn-info">></a><br/>
                </td>
            </tr>
            <tr>
                <td class="text-center" colspan="2">
                    <b>Week of {{ $week[0]->format('d M') }} - {{ $week[count($week)-1]->format('d M, Y') }}</b>
                </td>
            </tr>
        </table>
    </div>

	<div class="row">
		<div class="col-lg-12">			
			
			@if($errors->any())
			    <div class="alert alert-danger">
			        <ul>
			            @foreach ($errors->all() as $error)
			                <li>{{ $error }}</li>
			            @endforeach
			        </ul>
			    </div>
			@endif

			<form role="form" method="post" action="{{ route('clients.jobsites.employees.timesheet.save') }}">
				{{ csrf_field() }}
                <input type="hidden" name="jobsite_id" value="{{ $jobsite_id }}"/>
                <input type="hidden" name="employee_id" value="{{ $employee_id }}"/>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr scope="col">
                                <th class="text-center" width="10%">Date</th>
                                <th class="text-center" width="15%">Start</th>
                                <th class="text-center" width="15%">End</th>
                                <th class="text-center" width="5%">Break</th>
                                <th class="text-center" width="5%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for($i=0; $i < sizeof($week); $i++)
                            <tr scope="row">
                                <td class="text-center">
                                    <input type="hidden" name="id[]" value="{{ (isset($rows[$i])) ? $rows[$i]->id : null }}"/>                                    
                                    <input type="hidden" name="date[]" value="{{ $week[$i]->format('Y-m-d') }}"/>
                                    <b>{{ $week[$i]->format("D") }}</b><br>
                                    <small>{{ $week[$i]->format("d/m/Y") }}</small>
                                </td>
                                <td class="text-center">
                                    @if(isset($rows[$i]))
                                        {{ date("H:i:s", strtotime($rows[$i]->start)) }}
                                        <input type="hidden" name="start[]" value="{{ date('H:i:s', strtotime($rows[$i]->start)) }}"/>
                                    @else
                                        <b>N/A</b>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if(isset($rows[$i]))
                                        {{ date("H:i:s", strtotime($rows[$i]->end)) }}
                                        <input type="hidden" name="end[]" value="{{ date('H:i:s', strtotime($rows[$i]->end)) }}"/>
                                    @else
                                        <b>N/A</b>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if(isset($rows[$i]))
                                        <input type="hidden" id="break_{{ $i }}" name="break[]" value="{{ $rows[$i]->break }}"/>
                                        <b>{{ $row[$i]->break }} minute(s).</b>
                                    @else
                                        <select class="form-control" name="break[]">
                                            @for($min=5;$min<60;$min+=5)
                                            <option value="{{ $min }}" @if(isset($rows[$i]) && ($rows[$i]->break == $min))selected="selected"@endif>{{ $min }} minute(s).</option>                                        
                                            @endfor
                                        </select>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <button type="button" onClick="setStatus(this, 'status_{{ $i }}', 2);" class="btn btnbg @if(isset($rows[$i]) && $rows[$i]->status == 2) btn-selected @endif" style="background-color:red;color:white;">&#10007;</button>
                                    <button type="button" onClick="setStatus(this, 'status_{{ $i }}', 1);" class="btn btnbg btn-success @if(isset($rows[$i]) && $rows[$i]->status == 1) btn-selected @endif">&#10003;</button>
                                    <input type="hidden" name="status[]" id="status_{{ $i }}" value="@if(isset($rows[$i])) {{ $rows[$i]->status }} @else 0 @endif"/>
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
<style>
.btn-selected{
    border: 3px solid #333;
}
</style>
<script type="text/javascript">

    function setBreak(me, idName){
        if($(me).prop('checked') == true)
        {
            $('#'+idName).val(1);
        }else{
            $('#'+idName).val(0);
        }
    }

    function setStatus(me, idName, value){
        $(me).parent().find('button').removeClass('btn-selected');
        $(me).addClass('btn-selected');
        $("#"+idName).val(value);
    }

</script>
@endsection