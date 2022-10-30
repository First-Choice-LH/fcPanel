@extends('layouts.dore.app')
@section('content')

<style>
.input-danger{
	border: 1px solid red;
}
</style>
<div class="page-header">
	<div class="row">
		<div class="col-lg-12">
			<h1>REQUEST A JOBSITE</h1>
			<hr/>
		</div>
	</div>
	
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
		
			<form role="form" method="post" action="{{ url('addRequest') }}" class="" id="myform">
				{{ csrf_field() }}
				<div class="card padall30 mrb30 form_section">
					<h4>JOBSITE DETAILS<hr class="hralignleft"/></h4>

					<div class="form-group row">
						<div class="col-lg-6">
							<label for="project_name">Project Name</label>
							<input type="text" class="form-control" id="project_name" name="project_name" aria-describedby="project_name" placeholder="Project Name" value="{{ old('project_name', (isset($row)) ? $row->project_name : '') }}" />
						</div>
						<div class="col-lg-6">
						<label for="position">Position</label>
						<select name="position" id="position" class="form-control">
								<option value="">Select Position</option>
								@foreach ($positions as $position)
								<option value="{{ $position->id }}">
									{{ $position->title }}
								</option>
								@endforeach
							</select>
						</div>
					</div>

					<div class="form-group row">
						<div class="col-lg-6">
							<label for="address">Address</label>
							<textarea class="form-control" name="address" id="address" aria-describedby="address" placeholder="Address" row="4" col="6" value="">{{ old('address', (isset($row)) ? $row->address : '') }}</textarea>
						</div>
						<div class="col-lg-6">
							<label for="suburb">Suburb</label>
							<input type="text" class="form-control" name="suburb" id="suburb" aria-describedby="suburb" placeholder="Suburb" value="{{ old('suburb', (isset($row)) ? $row->suburb : '') }}"/>
						</div>
					</div>

					<div class="form-group row">
						<div class="col-lg-6">
							<label for="state">State</label>
							<input type="text" class="form-control" name="state" id="state" aria-describedby="state" placeholder="State" value="{{ old('state', (isset($row)) ? $row->state : '') }}"/>
						</div>
						<div class="col-lg-6">
							<label for="postcode">Postcode</label>
							<input type="text" class="form-control" name="postcode" id="postcode" aria-describedby="postcode" placeholder="Postcode" value="{{ old('postcode', (isset($row)) ? $row->postcode : '') }}"/>
						</div>
					</div>
				
					<div class="col-md-3">
						<button type="button" class="btn btnbg btn-primary show_details">Submit</button>
						<input type="hidden" id="id" name="id">
					</div>
				</div>

				<div class="card padall30 mrb30 detail_section">
					<h4>Details<hr class="hralignleft"/></h4>

					<div class="form-group row">
						<div class="col-lg-12 detail_para">
							<input type="text" >
						</div>
					</div>

					<div class="col-md-3">
						<div class="form-group row">
                        	<div class="col-md-8 text-left">
								<button type="submit" class="btn btnbg btn-primary submit_form">Confirm</button> <br>
							</div>
                        
                        	<div class="col-md-4 text-right">
								<button type="button" class="btn btnbg btn-primary back">Back</button>
								<input type="hidden" id="id" name="id">
							</div>
						</div>
					</div>

				</div>
				
		</form>
	
@endsection

@section('script')
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

$(document).ready(function(){
	$('.detail_section').hide();
});
$(".show_details").on('click', function(){

	//validations
	var error = false;
	$("#myform").find('.form-control').each(function(){
       if($(this).val() == ''){
			$(this).addClass('input-danger');
			error = true;
       }else{
           $(this).removeClass('input-danger');
       }
   });

	if(error !== true){
		$('.detail_para').html('');
		var project_name = $('#project_name').val();
		var position = $('#position').val();
		var address = $('#address').val();
		var suburb = $('#suburb').val();
		var state = $('#state').val();
		var postcode = $('#postcode').val();
		$('.detail_para').append('Project name : '+project_name+'<br><br>', 
								'Position : '+position+'<br><br>', 
								'Address : '+address+'<br><br>', 
								'Suburb : '+suburb+'<br><br>', 
								'State : '+state+'<br><br>', 
								'Postcode : '+postcode
							);

		$('.form_section').hide();
		$('.detail_section').show();
	}
});
$(".back").on('click', function(){
	$('.form_section').show();
	$('.detail_section').hide();
});
</script>
@endsection