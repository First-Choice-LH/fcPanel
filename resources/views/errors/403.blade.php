@extends('layouts.dore.app')

@section('content')
<div class="row">
	<div class="col-lg-12 text-center">
		<div class="jumbotron">
			<h3>Access Forbidden!</h3>
			<p>You do not have permission to access this section of the website.</p>
			<a class="btn btnbg btn-info" href="{{ url('/') }}">Return</a>
		</div>            
	</div>
</div>