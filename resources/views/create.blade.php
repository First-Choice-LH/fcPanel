<html>
    <head>
        <title>App Name</title>
    </head>
    <body>
    	<h1>Demo</h1>
    	@if($errors->any())
		    <div class="alert alert-danger">
		        <ul>
		            @foreach ($errors->all() as $error)
		                <li>{{ $error }}</li>
		            @endforeach
		        </ul>
		    </div>
		@endif
    	<form method="post" action="{{route('client.save')}}">
    		
    		{{ csrf_field() }}

    		<input type="text" name="user_id" placeholder="user_id" value="{{old('user_id')}}"/>
    		<input type="text" name="company_name" placeholder="company_name" value="{{old('company_name')}}"/>
    		<input type="text" name="company_abn" placeholder="company_abn" value="{{old('company_abn')}}"/>
    		<input type="text" name="office_address" placeholder="office_address" value="{{old('office_address')}}"/>
    		<input type="text" name="office_phone" placeholder="office_phone" value="{{old('office_phone')}}"/>
    		<input type="text" name="admin_email" placeholder="admin_email" value="{{old('admin_email')}}"/>
    		<input type="text" name="accounts_email" placeholder="accounts_email" value="{{old('accounts_email')}}"/>
    		<input type="text" name="status" value="1">
    		<button type="submit">Save</button>
    	</form>
    </body>
</html>