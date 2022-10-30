<!DOCTYPE html>
<html>
<head>
	<title>Timesheet</title>
	<link rel="stylesheet" type="text/css" media="all" href="{{ public_path('vendor/bootstrap/css/bootstrap.min.css') }}">
</head>
<body>
<div class="container">
    <div class="text-center">
        <img src="{{ public_path('images/logo.jpg') }}" alt=""/><br/><hr/>
    </div>
	<table class="table table-bordered">
		<thead>
            <tr>
                <th>Date</th>
                <th>Start</th>
                <th>End</th>
                <th>Break</th>
                <th>Status</th>
            </tr>
		</thead>
		<tbody>
			@foreach ($rows as $row)
			<tr>
				<td>{{ $row[0] }}</td>
				<td>{{ $row[1] }}</td>
				<td>{{ $row[2] }}</td>
				<td>{{ $row[3] }}</td>
				<td>{{ $row[4] }}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
</body>
</html>