@extends('layouts.dore.app')

@section('content')
<div class="page-header">
	<div class="row">
		<div class="col-lg-12">
			<h1>Employee Timesheet</h1>
			<hr/>
		</div>
	</div>

    <div class="white_bg_main">
        <div class="week-picker"></div>
        <br /><br />
        
    <div class="d-none d-lg-block">
        <div class="row">
            <div class="col-lg-4 text-left">
                <a href="{{ $previousWeek }}" class="btn btnbg btnbg mrb20">Previous Week</a><br/>
            </div>
            <div class="col-lg-4 text-center">
                <h4>Week of {{ $week[0]->format('d M') }} - {{ $week[count($week)-1]->format('d M, Y') }}</h4>
                <br/>                
            </div>
            <div class="col-lg-4 text-right">
                <a href="{{ $nextWeek }}" class="btn btnbg btnbg mrb20">Next Week</a><br/>
            </div>
        </div>
    </div>

    <div class="d-lg-none table-responsive">
        <table class="table">
            <tr>
                <td class="text-left">
                    <a href="{{ $previousWeek }}" class="btn btnbg btnbg">Previous Week</a><br/>
                </td>
                <td class="text-right">
                    <a href="{{ $nextWeek }}" class="btn btnbg btnbg">Next Week</a><br/>
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

                <div class="table-responsive mytable">
                    <table class="table table-hover table-bordered sortable_table">
                        <thead class="thead-dark">
                            <tr scope="col">
                                <th class="text-center" width="10%">Date</th>
                                <th class="text-center" width="15%">Start</th>
                                <th class="text-center" width="15%">End</th>
                                <th class="text-center" width="5%">Break</th>
                                <th class="text-center" width="15%">Status</th>
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
                                    <input type="hidden" name="start[]" value="{{ $rows[$i]->start }}"/>  
                                    @else
                                    <b>N/A</b>
                                    @endif                                  
                                </td>
                                <td class="text-center">
                                    @if(isset($rows[$i]))
                                    {{ date("H:i:s", strtotime($rows[$i]->end)) }}
                                    <input type="hidden" name="end[]" value="{{ $rows[$i]->end }}"/>
                                    @else
                                    <b>N/A</b>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if(isset($rows[$i]))
                                    <input type="hidden" name="break[]" value="{{ $rows[$i]->break }}"/>
                                    <b>{{ $rows[$i]->break }} minute(s).</b>
                                    @else
                                    <b>N/A</b>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if(isset($rows[$i]) AND $rows[$i]->status == 1)
                                    <i class="fas fa-check"></i>
                                    @elseif(isset($rows[$i]) AND $rows[$i]->status == 2)
                                    <i class="fas fa-times"></i>
                                    @else
                                    <i class="fas fa-times"></i>
                                    @endif
                                    <input type="hidden" name="status[]" value="@if(isset($rows[$i])) {{ $rows[$i]->status }} @else 0 @endif"/>
                                </td>
                            </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
		</div>
	</div>
</div>
</div>



<style>
.red-invert-btn {
    background-color: #f6f6f6;
    color: red;
    border-radius: 0;
    font-size: 24px;
    padding: 8px 20px;
}
.red-btn{
    background-color:red;
    color:#f6f6f6;
    border-radius: 0;
    font-size: 24px;
    padding: 8px 20px;
}
.green-invert-btn{
    background-color:#f6f6f6;
    color:#469408;
    border-radius: 0;
    font-size: 24px;
    padding: 8px 20px;
}
.green-btn{
    background-color:#469408;
    color:#f6f6f6;  
    border-radius: 0;
    font-size: 24px;
    padding: 8px 20px;  
}
.btn.btn-selected{
    border-radius: 0;
    font-size: 24px;
    padding: 8px 20px;  
}
</style>


@endsection

@section('script')
<link rel="stylesheet" href="{{ asset('dore/css/vendor/jquery-ui.min.css') }}" />
<script src="{{ asset('dore/js/vendor/jquery-ui.min.js') }}"></script>

<script type="text/javascript">
function setBreak(me, idName){
    if($(me).prop('checked') == true)
    {
        $('#'+idName).val(1);
    }else{
        $('#'+idName).val(0);
    }
}

$(function() {

    var startDate;
    var endDate;
    var url = "{{ url('/timesheets/employee').'/'.$jobsite_id.'/'.$employee_id }}";
    
    var selectCurrentWeek = function() {
        window.setTimeout(function () {
            $('.week-picker').find('.ui-datepicker-current-day a').addClass('ui-state-active')
        }, 1);
    }
    
    $('.week-picker').datepicker({

        dateFormat: 'yy-mm-dd',
        defaultDate: "{{ $week[0]->format('Y-m-d') }}",
        showOtherMonths: true,
        firstDay: 1,
        selectOtherMonths: true,
        onSelect: function(dateText, inst) { 
            
            var date = $(this).datepicker('getDate');
            startDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay()+1);
            endDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay() + 7);
            var dateFormat = inst.settings.dateFormat || $.datepicker._defaults.dateFormat;
            url = url+"?date="+$.datepicker.formatDate( dateFormat, startDate, inst.settings );
            document.location = url;
            selectCurrentWeek();
        },
        beforeShowDay: function(date) {
            var cssClass = '';
            var startDate = $(this).datepicker('getDate');
            var endDate = new Date(startDate.getFullYear(), startDate.getMonth(), startDate.getDate() - startDate.getDay() + 7);
            if(date >= startDate && date <= endDate){
                cssClass = 'ui-datepicker-current-day';
            }
            return [true, cssClass];
        },
        onChangeMonthYear: function(year, month, inst) {
            selectCurrentWeek();
        }
    });
    
    $('.week-picker .ui-datepicker-calendar tr').on('mousemove', function() { $(this).find('td a').addClass('ui-state-hover'); });
    $('.week-picker .ui-datepicker-calendar tr').on('mouseleave', function() { $(this).find('td a').removeClass('ui-state-hover'); });
});
</script>

@endsection