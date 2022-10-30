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
			<h4>Your request has been put forward – our staff members will approve this request as soon as the client confirms your employment.</h4>
		</div>
	</div>
</div>
@endsection
@section('script')
<script type="text/javascript">
 $(document).ready(function(){
   setTimeout(function(){ 
   	window.location.href="/supervisors/dashboard"; }, 10000);
});
</script>
@endsection