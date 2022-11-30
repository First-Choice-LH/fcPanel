@extends('layouts.dore.app')

@section('content')
<style>
    #viewDocImgFront, #viewDocImgBack {
        max-width: 100%;
    }
    #clientDetailsModal {
        z-index: 1999;
    }
    #viewDocModal {
        z-index: 2000;
    }

    #viewDocModal .modal-body {
        position: relative;
    }

    #viewDocModal .modal-body img {
        width: 100%;
        height: auto;
        max-width: 90vh;
        max-height: 80vh;
    }
</style>
<div class="page-header">
	<div class="row">
		<div class="col-lg-12">
			<h1>Employee List</h1>
			<hr/>
		</div>
	</div>
    <div class="white_bg_main">

    	<div class="row">
    		<div class="col-lg-4 form-group">
                <input class="form-control" type="text" id="employee" value="{{ app('request')->input('employee') }}">
            </div>
            <div class="col-lg-2 form-group text-center">
                <button type="button" class="btn btnbg search">Search</button>
            </div>
            <div class="col-lg-3"></div>
    		<div class="col-lg-3 form-group text-center">
    			<a href="{{ url('/employees/create') }}" class="btn btnbg">Create New</a>
    		</div>
    	</div>

	<?php $i = 1; ?>
	<div class="mytable">
	<div class="row">
		<div class="col-lg-12 table-responsive">
			<table class="table table-hover table-bordered sortable_table">
				<thead class="thead-dark">
					<tr>
						<th scope="col" class="d-none d-md-table-cell d-lg-table-cell text-center" width="10%">Quick</th>
						<th scope="col" class="d-none d-md-table-cell d-lg-table-cell" data-col="first_name">First Name</th>
						<th scope="col" class="" data-col="last_name">Last Name</th>
						<th scope="col" class="" data-col="phone">Phone</th>
						<th scope="col" class="text-center">Actions</th>
					</tr>
				</thead>
			  	<tbody>
			  		@foreach($rows as $row)
			  		<tr>
			  			<td class="d-none d-md-table-cell d-lg-table-cell text-center">
							<button class="btn btnbg btn-sm btn-info ml-2 " onclick="viewEmployeeDetails({{ $row->id }})" data-toggle="tooltip" title="View"><i class="fa fa-search-plus"></i></button>
                               </td>
			  			<td class="d-none d-md-table-cell d-lg-table-cell">{{ $row->first_name }}</td>
			  			<td class="">{{ $row->last_name }}</td>
			  			<td class="">{{ $row->phone }}</td>
			  			<td class="text-center">

						<a class="btn btnbg btn-sm btn-info" href="{{ url('/employees/update/'.$row->id) }}" title="Edit"><i class="fa fa-edit"></i></a>
						<a class="btn btnbg btn-sm btn-info" href="{{ url('/employees/jobsite/'.$row->id) }}" title="Sites"><i class="fa fa-building"></i></a>
						<a class="btn btnbg btn-sm btn-info text-white" onclick="showDeletionConfirmation({{ $row->id }})" title="Delete"><i class="fa fa-trash"></i></a>

							<!-- <div class="dropdown d-block">
                            <a class="btn btn-sm btnbg" href="{{ url('/employees/update/'.$row->id) }}">Edit</a>
							<div class="dropdown d-block">
								<button type="button" class="btn btnbg btn-sm dropdown-toggle" data-toggle="dropdown">
								Options
								</button>
								<div class="dropdown-menu">
									<a class="dropdown-item" href="{{ url('/employees/update/'.$row->id) }}">Edit</a>
									<a class="dropdown-item" href="{{ url('/employees/jobsite/'.$row->id) }}">Sites</a>
								</div>
							</div> -->
						</td>
		  			</tr>
		  			@endforeach
			  	</tbody>
		  	</table>
		  	{{ $rows->appends(request()->except('page'))->links() }}
		</div>
	</div>

    <div class="modal fade" id="viewDocModal" tabindex="2" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fa fa-warning"></i> View License</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img src="" alt="" id="viewDocImgFront" />
                    <img src="" alt="" id="viewDocImgBack" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btnbg btn-sm" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="employeeDetailsModal" tabindex="-1" role="dialog" aria-labelledby="employeeDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="employeeDetailsModalLabel">Employee Details</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="mx-4">

                <ul class="nav nav-tabs card-header-tabs ml-1" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active show" id="details-tab" data-toggle="tab" href="#detailsTab" role="tab" aria-controls="details" aria-selected="true">Details</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="positions-tab" data-toggle="tab" href="#positionsTab" role="tab" aria-controls="positions" aria-selected="false">Positions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="jobsites-tab" data-toggle="tab" href="#jobsitesTab" role="tab" aria-controls="jobsites" aria-selected="false">Jobsites</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="notes-tab" data-toggle="tab" href="#notesTab" role="tab" aria-controls="notes" aria-selected="false">Notes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="docs-tab" data-toggle="tab" href="#docsTab" role="tab" aria-controls="docs" aria-selected="false">Documents</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active py-2" id="detailsTab" role="tabpanel" aria-labelledby="details-tab">
                        <table class="table mt-2">
                            <tbody>
                                <tr>
                                    <td class="border-0">Name</td>
                                    <td class="border-0" id="employeeName"></td>
                                </tr>
                                <tr>
                                    <td class="border-0">Phone</td>
                                    <td class="border-0" id="employeePhone"></td>
                                </tr>
                                {{-- <tr>
                                    <td class="border-0">Address</td>
                                </tr> --}}
                                <tr>
                                    <td class="border-0">Email</td>
                                    <td class="border-0" id="employeeEmail"></td>
                                </tr>
                                <tr>
                                    <td class="border-0">Status</td>
                                    <td class="border-0" id="employeeStatus"></td>
                                </tr>
                                <tr>
                                    <td class="border-0">Last Updated</td>
                                    <td class="border-0" id="lastUpdated"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade pt-4 pb-2" id="positionsTab" role="tabpanel" aria-labelledby="positions-tab">
                        <table class="table mt-2">
                            <tbody>
                                <thead>
                                    <th>Position Title</th>
                                </thead>
                                <tbody id="employeePositionsTableBody"></tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade pt-4 pb-2" id="jobsitesTab" role="tabpanel" aria-labelledby="jobsites-tab">
                        <table class="table mt-2">
                            <tbody>
                                <thead>
                                    <th>Project Name</th>
                                    <th>Address</th>
                                    <th>Active</th>
                                    <th>Actions</th>
                                </thead>
                                <tbody id="employeeJobsitesTableBody"></tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade pt-4 pb-2" id="notesTab" role="tabpanel" aria-labelledby="notes-tab">
                        <table class="table" id="notesTable"></table>
                    </div>
                    <div class="tab-pane fade pt-4 pb-2" id="docsTab" role="tabpanel" aria-labelledby="docs-tab">
                        <table class="table" id="docsTable"></table>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>

	</div>
	</div>
</div>
@endsection

@section('script')
<script type="text/javascript">


    $('.search').click(function(){
        var employee = $('#employee').val();
        var url = "{{ url('/employees/') }}";
        url = url+"?employee="+employee;
        document.location = url;
    });

    var focusedEmployee = null;
    function viewEmployeeDetails(employeeId) {
        focusedEmployee = employeeId;
        $.get(`${BASE_URL}/api/employee`,{id: employeeId}, function(data, status) {
            if(data.status == 1) {
                $('#employeeStatus').text('Active').addClass('text-success');
            } else {
                $('#employeeStatus').text('Inactive').addClass('text-warning');
            }

            $('#lastUpdated').text( data.last_updated );
            $('#employeeName').text( data.first_name + ' ' + data.last_name);
            $('#employeeEmail').text( data.email);
            $('#employeePhone').text( data.phone);

            // Populate Jobsites

            let jobsiteRows = '';
            if( data.jobsites ) {
                for(let site of data.jobsites) {
                    jobsiteRows += `<tr>
                        <td>${site.title}</td>
                        <td>${site.address}</td>
                        <td>${site.status == '1' ? 'Active' : 'Inactive'}</td>
                        <td>
                            <a href="${BASE_URL}/jobsites/update/${site.id}" class="text-info" target="new">View Details</a>
                        </td>
                    </tr>`;
                }
            }

            $('#employeeJobsitesTableBody').html(jobsiteRows);

            // Populate Charge Positions
            let positionRows = '';
            if( data.employee_positions ) {
                for(let employeePosition of data.employee_positions) {
                    positionRows += `<tr>
                        <td>${employeePosition.position.title}</td>
                    </tr>`;
                }
            }

            $('#employeePositionsTableBody').html(positionRows);

            // Populate Notes
            let notes = '';
            if( data.notes ) {
                for(let note of data.notes) {
                    notes += `<tr>
                            <td>${note.user}</td>
                            <td>${note.created_at}</td>
                        </tr>
                        <tr>
                            <td colspan="2">&quot;${note.note}&quot;</td>
                        </tr>`;
                }
            }

            $('#notesTable').html(notes);

            // Populate Documents
            let documents = '';
            if( data.documents ) {
                for(let doc of data.documents) {
                    documents += `<tr>
                        <td>${doc.license_type}</td>
                        <td><button class="btn btnbg btn-sm" onclick="viewDocument('${doc.license_image_front}', '${doc.license_image_back}')"><i class="fa fa-search-plus"></i> View </button></td>
                        <td><a class="btn btnbg btn-sm" href="${BASE_URL}/download?path=dore/employee/${doc.license_image_front}"><i class="fa fa-download"></i> Download Front</a></td>
                        <td><a class="btn btnbg btn-sm" href="${BASE_URL}/download?path=dore/employee/${doc.license_image_back}"><i class="fa fa-download"></i> Download Back</a></td>
                    </tr>`;
                }
            }

            $('#docsTable').html(documents);

        });
        $('#employeeDetailsModal').modal('show');
    }

    function viewDocument(frontDocName, backDocName) {
        $('#viewDocImgFront').attr('src', `${BASE_URL}/dore/employee/${frontDocName}`);
        $('#viewDocImgBack').attr('src', `${BASE_URL}/dore/employee/${backDocName}`);
        $('#viewDocModal').modal('show');
    }

</script>
@endsection
