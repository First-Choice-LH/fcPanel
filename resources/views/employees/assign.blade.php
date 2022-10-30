@extends('layouts.dore.app')

@section('content')
<div class="page-header">
	<div class="row">
		<div class="col-lg-12">
			<h1>Assign Employee</h1>
			<hr/>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-8 offset-lg-2">			
			<div class="card padall30"> 
			@if($errors->any())
			    <div class="alert alert-danger">
			        <ul>
			            @foreach ($errors->all() as $error)
			                <li>{{ $error }}</li>
			            @endforeach
			        </ul>
			    </div>
			@endif

			<form role="form" method="post" action="{{ route('employees.assign.save') }}">
				{{ csrf_field() }}
				<input type="hidden" name="employee_id" value="{{ old('employee_id', $employee_id) }}"/>

				<div class="form-group row">
					<div class="col-lg-6">
						<label for="client_id">Client</label>

						<select name="client_id" class="form-control">
							<option value="">Select Client</option>
							@foreach ($clients as $client)
							<option value="{{ $client->id }}">
								{{ $client->company_name }}
							</option>
							@endforeach
						</select>
					</div>
					<div class="col-lg-6">
						<label for="jobsite_id">Jobsite</label>

						<select name="jobsite_id" class="form-control">
							<option value="">Select Jobsite</option>
						</select>
					</div>
				</div>

                <div class="form-group row">
                    <div class="col-lg-12 text-right">
                        <button type="submit" class="btn btnbg">Assign</button>
                    </div>
                </div>
			</form>
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

            $("select[name=jobsite_id]").html(html);
        });
	})
});
</script>
@endsection