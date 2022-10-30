@extends('layouts.dore.app')
@section('content')
<div class="page-header">
	<div class="row">
		<div class="col-lg-12">
			<h1>REQUEST A JOBSITE</h1>
			<hr/>
		</div>
	</div>
	<div class="white_bg_main">
		<div class="row">
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
		</div>
		<div class="row">
			<form role="form" method="post" action="{{ url('supervisors/addRequest') }}" class="">
				{{ csrf_field() }}
				<div class="form-group row">
					<div class="col-md-3">
						<select name="company" class="form-control">
							<option value="">Select Company</option>
							@foreach ($clients as $client)
							<option value="{{ $client->id }}">
								{{ $client->company_name }}
							</option>
							@endforeach
						</select>
					</div>

					<div class="col-md-3">
						<select name="jobsite" class="form-control">
							<option value="">Select Jobsite</option>
						</select>
					</div>

					<div class="col-md-3">
						<button class="btn btnbg btn-primary">{{ __('SUBMIT') }}</button>
					</div>
					<input type="hidden" name="status" value="0">
				</div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
document.addEventListener("DOMContentLoaded", function(event) {
    
    $("select[name=company]").on('change', function(){
        $("select[name=jobsite").attr('disabled','disabled');
        var company = $("select[name=company]").val();
        var ajax_get_jobsites_url = "{{ url('/api/client_jobsites/') }}/"+company;
        
        $.get(ajax_get_jobsites_url, function(response){
            var jsondata = $.parseJSON(response);
            var html = '<option value="">Select Jobsite</option>';
            for(var i=0; i<jsondata.length; i++)
            {
                html += '<option value="'+jsondata[i].id+'">'+jsondata[i].title+'</option>';
            }

            $("select[name=jobsite").html(html);
            $("select[name=jobsite").removeAttr('disabled');
        });
	})
});
</script>
@endsection