@extends('layouts.dore.app')

@section('content')
<div class="page-header">
	<div class="row">
		<div class="col-lg-12">
			<h1>Assign Supervisor</h1>
			<hr/>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-6 offset-lg-3">			
			
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

			<form role="form" method="post" action="{{ route('supervisors.assign.save') }}">
				{{ csrf_field() }}
				<input type="hidden" name="supervisor_id" value="{{ old('supervisor_id', $supervisor_id) }}"/>

				<div class="form-group row">
					<div class="col-lg-12">
							<label class="" for="jobsite_id">Jobsites:</label>
						<select name="jobsite_id" class="custom-select form-control">
							<option value="">Select Jobsite</option>
							@foreach ($jobsites as $jobsite)
							<option value="{{ $jobsite->id }}">
								{{ $jobsite->title }}
							</option>
							@endforeach
						</select>
					</div>
				</div>

						<div class="text-right">
							<button class="btn btnbg" type="submit">Assign</button>
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