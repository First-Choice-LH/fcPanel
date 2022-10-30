@extends('layouts.dore.app')

@section('content')
<script src="{{ asset('vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" defer></script>
<link href="{{ asset('vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css"/>
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
                <a href="{{ $previousWeek }}" class="btn btnbg"><</a><br/>
            </div>
            <div class="col-lg-4 text-center">
                <h4>Week of {{ $week[0]->format('d M') }} - <button class="btn btnbg datepicker"><img src="{{ asset('images/calendar.png') }}" width="24" alt=""/></button> - {{ $week[count($week)-1]->format('d M, Y') }}</h4>
                <br/>                
            </div>
            <div class="col-lg-4 text-left">
                <a href="{{ $nextWeek }}" class="btn btnbg">></a><br/>
            </div>
        </div>
    </div>

    <div class="d-lg-none table-responsive">
        <table class="table">
            <tr>
                <td class="text-left">
                    <a href="{{ $previousWeek }}" class="btn btn-info"><</a><br/>
                </td>
                <td class="text-right">
                    <a href="{{ $nextWeek }}" class="btn btn-info">></a><br/>
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

            <form role="form" method="post" action="{{ route('employees.jobsites.timesheet.save') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="jobsite_id" value="{{ $jobsite_id }}"/>
                <input type="hidden" name="client_id" value="{{ $client_id }}"/>
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
                                    @if(isset($rows[$i]) AND $rows[$i]->status == 1)
                                    {{ date("H:i:s", strtotime($rows[$i]->start)) }}
                                    <input type="hidden" name="start[]" value="{{ $rows[$i]->start }}"/>
                                    @else
                                    <select name="start[]" class="form-control">
                                        @foreach($times as $time)
                                        <option value="{{ $time['value'] }}" 
                                        @if(isset($rows[$i]) && date("H:i:s", strtotime($rows[$i]->start)) == $time['value']) selected="selected" @elseif($time['value'] == $default_start) selected="selected" @else @endif
                                        >
                                            {{ $time['key'] }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if(isset($rows[$i]) AND $rows[$i]->status == 1)
                                    {{ date("H:i:s", strtotime($rows[$i]->start)) }}
                                    <input type="hidden" name="end[]" value="{{ $rows[$i]->end }}"/>
                                    @else                                    
                                    <select name="end[]" class="form-control">
                                        @foreach($times as $time)
                                        <option value="{{ $time['value'] }}" @if(isset($rows[$i]) && date("H:i:s", strtotime($rows[$i]->end)) == $time['value']) selected="selected" @elseif($time['value'] == $default_end) selected="selected" @else @endif>
                                            {{ $time['key'] }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if(isset($rows[$i]) AND $rows[$i]->status == 1)
                                        <input type="hidden" name="break[]" value="{{ $rows[$i]->break }}"/>                                        
                                        <b>{{ $rows[$i]->break }} minute(s).</b>
                                    @else
                                        <select class="form-control" name="break[]">
                                        @for($min=5;$min<60;$min+=5)
                                        <option value="{{ $min }}" @if(isset($rows[$i]) && ($rows[$i]->break == $min))selected="selected"@endif>{{ $min }} minute(s).</option>                                        
                                        @endfor
                                        </select>                                        
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if(isset($rows[$i]) AND $rows[$i]->status == 1)
                                    <button type="button" class="btn green-btn btn-selected">&#10003;</button>
                                    @elseif(isset($rows[$i]) AND $rows[$i]->status == 2)
                                    <button type="button" class="btn red-btn btn-selected">&#10007;</button>
                                    @else
                                    <button disabled="true" type="button" class="btn btn-selected">&#10007;</button>
                                    @endif
                                    <input type="hidden" name="status[]" value="@if(isset($rows[$i])) {{ $rows[$i]->status }} @else 0 @endif"/>
                                </td>
                            </tr>
                            @endfor
                        </tbody>
                    </table>
                    <div class="form-group text-center">
                        <label class="control-label" style="font-weight:bolder;">Upload file:
                            <input type="file" name="timesheetfile" />                            
                            <br/><br/>
                            <ul class="list-group">
                            @foreach($images as $image)
                            <li class="list-group-item"><a href="{{ Storage::url($image->imagename) }}">Download file</a></li>
                            @endforeach
                            </ul>
                        </label>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-12 text-center">
                        <input type="hidden" id="export_pdf" name="export_pdf" value="0"/>
                        <input type="hidden" id="download_mode" name="download_mode" value="pdf"/>
                        <button type="submit" class="btn btnbg btn-success">Save</button>
                        <button type="button" class="btn btnbg btn-info" onClick="export_timesheet();">Export PDF Timesheet</button>
                        <button type="button" class="btn btnbg btn-info" onClick="export_csv_timesheet();">Export CSV Timesheet</button>
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
.red-invert-btn{
    background-color:#f6f6f6;
    color:red;
}
.red-btn{
    background-color:red;
    color:#f6f6f6;
}
.green-invert-btn{
    background-color:#f6f6f6;
    color:#469408;
}
.green-btn{
    background-color:#469408;
    color:#f6f6f6;    
}
</style>
<script type="text/javascript">
function export_timesheet()
{
    $('#export_pdf').val(1);
    $('#download_mode').val('pdf');
    $('form').submit();
}

function export_csv_timesheet()
{
    $('#export_pdf').val(1);
    $('#download_mode').val('csv');
    $('form').submit();
}

function setBreak(me, idName){
    if($(me).prop('checked') == true)
    {
        $('#'+idName).val(1);
    }else{
        $('#'+idName).val(0);
    }
}

document.addEventListener("DOMContentLoaded", function(event) {
    $('.datepicker').datepicker({format:'mm/dd/yy'}).on('changeDate', function(e){
        var sel_date = e.date.getFullYear()+'-'+parseInt(e.date.getMonth()+1)+'-'+e.date.getDate();

        var jobsite_id = '{{ $jobsite_id }}';
        var client_id = '{{ $client_id }}';

        window.location = '{{ url("/employees/jobsites/timesheet/") }}/'+jobsite_id+'/'+client_id+'/?date='+sel_date;
    });
});
</script>
@endsection