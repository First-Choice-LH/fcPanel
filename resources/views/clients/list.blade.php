@extends('layouts.dore.app')

@section('content')
<div class="page-header">
    <div class="row">
        <div class="col-lg-12">
            <h1>Company List</h1>
            <hr/>
        </div>
    </div>
    <div class="white_bg_main">
        <div class="row">
            <div class="col-lg-8"></div>
            <div class="col-lg-4 text-right">
                <a href="{{ url('clients/create') }}" class="btn btnbg btn-success">Create New</a>
                <br/><br/>
            </div>
        </div>
        <?php $i = 1; ?>
        <div class="mytable">
            <div class="row">
                <div class="col-lg-12 table-responsive">
                    <table class="table table-hover table-bordered sortable_table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col" class="" >#</th>
                                <th scope="col" class="" data-col="company_name">Company</th>
                                <th scope="col" class="" data-col="office_address">Address</th>
                                <th scope="col" class="" data-col="office_phone">Phone</th>
                                <th scope="col" class="" data-col="status">Status</th>
                                <th scope="col" class="" >&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rows as $row)
                            <tr>
                                <td class="">{{ $i++ }}
                                    <button class="btn btnbg btn-sm btn-info ml-2" onclick="viewClientDetails({{ $row->id }})" title="View"><i class="fa fa-eye"></i></button>
                                </td>
                                <td class="">{{ $row->company_name }}</td>
                                <td class="">{{ $row->office_address }}</td>
                                <td class="">{{ $row->office_phone }}</td>
                                <td class="">
                                    <?php if($row->status==0){
                                            echo "&#10006;";
                                    }
                                    else{
                                            echo "Active";
                                    }?>
                                </td>
                                <td class="text-center">
                                    <a class="btn btnbg btn-sm btn-info" href="{{ url('/clients/update/'.$row->id) }}" title="Edit"><i class="fa fa-edit"></i></a>
                                    <a class="btn btnbg btn-sm btn-info text-white" onclick="showDeletionConfirmation({{ $row->id }})" title="Delete"><i class="fa fa-trash"></i></a>
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                      </table>
                        {{ $rows->appends(request()->except('page'))->links() }}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="companyDeletionConfirmation" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fa fa-warning"></i> Deletion Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this company record?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btnbg btn-sm" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btnbg btn-sm" onclick="deleteCompanyRecord()">Confirm</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="clientDetailsModal" tabindex="-1" role="dialog" aria-labelledby="clientDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="clientDetailsModalLabel">Company Details</h4>
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
                        <a class="nav-link" id="summary-tab" data-toggle="tab" href="#summaryTab" role="tab" aria-controls="summary" aria-selected="false">Summary</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="notes-tab" data-toggle="tab" href="#notesTab" role="tab" aria-controls="notes" aria-selected="false">Notes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="docs-tab" data-toggle="tab" href="#docsTab" role="tab" aria-controls="docs" aria-selected="false">Documents</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="rates-tab" data-toggle="tab" href="#ratesTab" role="tab" aria-controls="rates" aria-selected="false">Charge Rates</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active py-2" id="detailsTab" role="tabpanel" aria-labelledby="details-tab">
                        <table class="table mt-2">
                            <tbody>
                                <tr>
                                    <td class="border-0">Status</td>
                                    <td class="border-0" id="companyStatus"></td>
                                </tr>
                                <tr>
                                    <td class="border-0">Last Updated</td>
                                    <td class="border-0" id="lastUpdated"></td>
                                </tr>
                                <tr>
                                    <td class="border-0" colspan="2"><h3>Company Details</h3></td>
                                </tr>
                                <tr>
                                    <td class="border-0">Address</td>
                                    <td class="border-0">
                                        <i class="fa fa-map-marker" aria-hidden="true"></i> <span id="companyAddress"></span><br/>
                                        <span id="companySuburb"></span> <span id="companyPostalCode"></span><br/>
                                        <span id="companyState"></span> <span id="companyCountry"></span><br/>
                                        <i class="fa fa-phone" aria-hidden="true"></i> <span id="companyPhone"></span><br/>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade pt-4 pb-2" id="summaryTab" role="tabpanel" aria-labelledby="summary-tab">
                        <h5 class="card-title">Tab Card Two</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                    <div class="tab-pane fade pt-4 pb-2" id="notesTab" role="tabpanel" aria-labelledby="notes-tab">
                        <table class="table" id="notesTable"></table>
                    </div>
                    <div class="tab-pane fade pt-4 pb-2" id="docsTab" role="tabpanel" aria-labelledby="docs-tab">
                    </div>
                    <div class="tab-pane fade pt-4 pb-2" id="ratesTab" role="tabpanel" aria-labelledby="rates-tab">
                        <table id="ratesTable" class="table table-bordered">
                        </table>
                    </div>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btnbg btn-sm" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('script')
<script type="text/javascript">

    var focusedCompany = null;
    function viewClientDetails(clientId) {
        focusedCompany = clientId;
        $.get(`${BASE_URL}/api/client`,{id: clientId}, function(data, status) {
            if(data.status == 1) {
                $('#companyStatus').text('Active').addClass('text-success');
            } else {
                $('#companyStatus').text('Inactive').addClass('text-warning');
            }

            $('#lastUpdated').text( data.last_updated );
            $('#companyAddress').text( data.office_address);
            $('#companySuburb').text( data.suburb);
            $('#companyPostalCode').text( data.postcode);
            $('#companyState').text( data.state);
            $('#companyCountry').text( data.country);
            $('#companyPhone').text( data.office_phone);
            $('#companyNotes').val( data.notes);

            // Populate Charge Rates
            let chargeRateRows = '';
            if( data.position_rates ) {
                for(let rate of data.position_rates) {
                    chargeRateRows += `<tr>
                        <td>${rate.position.title}</td>
                        <td>$${rate.rate}</td>
                    </tr>`;
                }
            }

            $('#ratesTable').html(chargeRateRows);

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

        });
        $('#clientDetailsModal').modal('show');
    }

    var recordToDel;
    function showDeletionConfirmation(clientId) {
        recordToDel = clientId;
        $('#companyDeletionConfirmation').modal('show');
    }

    function saveCompanyNotes() {
        $.post(`${BASE_URL}api/client/notes`, { clientId: focusedCompany, notes: $('#companyNotes').val() }, function(response) {
            if(Array.isArray(response)) {
                response.reverse();
                for(let err of response) {
                    $.notify(err);
                }
            } else {
                $.notify(response, "success");
            }
        });
    }

    function deleteCompanyRecord() {
        $.ajax({
            url: `${BASE_URL}/api/client`,
            type: 'DELETE',
            success: function(response) {
                $.notify(response, "success");
                $('#companyDeletionConfirmation').modal('hide');
                setTimeout(function() {
                    window.location.href = window.location.href;
                }, 1000);
            },
            data: {clientId: recordToDel}
        });
    }
</script>
@endsection
