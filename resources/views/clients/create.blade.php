@extends('layouts.dore.app')

@section('content')
<div class="page-header">
	<div class="row">
		<div class="col-lg-12">
			@if(!isset($row))
			<h1>Create New Company</h1>
			@else
			<h1>Update Company</h1>
			@endif
			<hr/>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-8 offset-lg-2">
	<div class="card">
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

			<form role="form" method="post" action="{{ route('clients.save') }}" class="card-body" enctype="multipart/form-data">
				{{ csrf_field() }}
				<input type="hidden" name="id" value="{{ old('id', (isset($row)) ? $row->id : null) }}"/>

				<div class="form-group row">
					<div class="col-lg-8">
						<label for="company_name">Company Name</label>
						<input type="text" class="form-control" name="company_name" aria-describedby="company_name" placeholder="Company Name" value="{{ old('company_name', (isset($row)) ? $row->company_name : '') }}" />
					</div>
					<div class="col-lg-4">
						<label for="company_abn">Company ABN</label>
						<input type="text" class="form-control" name="company_abn" aria-describedby="company_abn" placeholder="Company ABN" value="{{ old('company_abn', (isset($row)) ? $row->company_abn : '') }}"/>
					</div>
				</div>

				<div class="form-group row">
					<div class="col-lg-8">
						<label for="office_address">Office Address</label>
						<input type="text" class="form-control" name="office_address" aria-describedby="office_address" placeholder="Office Address" value="{{ old('office_address', (isset($row)) ? $row->office_address : '') }}"/>
					</div>
					<div class="col-lg-4">
						<label for="suburb">Suburb</label>
						<input type="text" class="form-control" name="suburb" aria-describedby="suburb" placeholder="Suburb" value="{{ old('suburb', (isset($row)) ? $row->suburb : '') }}"/>
					</div>
				</div>

				<div class="form-group row">
					<div class="col-lg-4">
						<label for="state">State</label>
						<input type="text" class="form-control" name="state" aria-describedby="state" placeholder="State" value="{{ old('state', (isset($row)) ? $row->state : '') }}"/>
					</div>
					<div class="col-lg-4">
						<label for="office_phone">Post Code</label>
						<input type="text" class="form-control" name="postcode" aria-describedby="postcode" placeholder="Post Code" value="{{ old('postcode', (isset($row)) ? $row->postcode : '') }}"/>
					</div>
					<div class="col-lg-4">
						<label for="country">Country</label>
						<input type="text" class="form-control" name="country" aria-describedby="country" placeholder="Country" value="{{ old('country', (isset($row)) ? $row->country : '') }}"/>
					</div>
				</div>

			<div class="form-group row">
				<div class="col-lg-4">
					<label for="office_phone">Phone</label>
					<input type="text" class="form-control" name="office_phone" aria-describedby="office_phone" placeholder="Office Phone" value="{{ old('office_phone', (isset($row)) ? $row->office_phone : '') }}"/>
				</div>
				<div class="col-lg-4">
					<label for="email">Email</label>
					<input type="text" class="form-control" name="email" aria-describedby="email" placeholder="Email" value="{{ old('email', (isset($row)) ? $row->email : '') }}"/>
				</div>
            </div>
            <div class="form-group row">
				<div class="col-lg-8">
					<label for="notes">Notes</label>
					<input type="text" class="form-control" name="notes" aria-describedby="notes" placeholder="Enter notes" value="{{ old('notes', (isset($row)) ? $row->notes : '') }}"/>
				</div>
            </div>

            <div class="card padall30 mrb30">
                <h4>Documents<hr class="hralignleft"/></h4>
                <div class="audience-tab-content">
                 @if(!empty($documents))
                        @foreach($documents as $key => $doc)
                          <div class="document_row">
                                <input type="hidden" name="document_id[]" value="{{ $doc->id }}">
                                @if($key == 0)
                                <div class="form-group row">
                                   <div class="col-lg-12 text-right">
                                       <button type="button" class="btn btnbg remove_doc first_document btn-sm"><i class="fas fa-times"></i> REMOVE</button>
                                   </div>
                                </div>
                                @else
                                <div class="form-group row">
                                   <div class="col-lg-12 text-right">
                                       <button type="button" class="btn btnbg remove_doc btn-sm"><i class="fas fa-times"></i> REMOVE</button>
                                   </div>
                                </div>
                                @endif
                               <div class="form-group row">
                                    @if($doc->doc_name != '')
                                    <div class="col-lg-5">
                                    @else
                                    <div class="col-lg-6">
                                    @endif
                                        <label for="type">Document Type</label>
                                         <select name="doc_type_id[]" class="form-control document_type" value="{{ $doc->doc_type_id }}">
                                           <option value="">-- Select Type --</option>
                                           @foreach ($documentTypes as $docType)
                                            <option value="{{ $docType->id }}" {{ $doc->doc_type_id == $docType->id ? 'selected' : '' }}>{{ $docType->type }}</option>
                                           @endforeach
                                       </select>
                                    </div>
                                    @if($doc->doc_name != '')
                                    <div class="col-lg-1 pl-0 mt-4">
                                         <button type="button" class="btn btnbg file-preview" data-src="{{ $doc->doc_name }}"><i class="fa fa-eye"></i></button>
                                    </div>
                                    @endif
                                    <div class="col-lg-6 other_col">
                                        <label for="type" class="head">Please Specify</label>
                                        <input type="text" class="form-control" name="type_other[]" id="type_other" value="{{ $doc->other_type }}">
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="image">Upload Document</label>
                                        <input type="File" class="form-control" name="document_file[]" aria-describedby="file" placeholder="file" value=""/>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @else

                            <div class="document_row">
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label for="type">Document Type</label>
                                         <select name="doc_type_id[]" id="document_type" class="form-control document_type" value="">
                                           <option value="">-- Select Type --</option>
                                           @foreach ($documentTypes as $docType)
                                           <option value="{{ $docType->id }}">{{ $docType->type }}</option>
                                           @endforeach
                                       </select>
                                    </div>
                                    <div class="col-lg-6 other_col">
                                        <label for="type" class="head">Please Specify</label>
                                        <input type="text" class="form-control" name="type_other[]" id="type_other">
                                    </div>
                                   <div class="col-lg-6">
                                       <label for="image">Upload Document</label>
                                       <input type="File" class="form-control" name="document_file[]" aria-describedby="image" placeholder="Image" value=""/>
                                   </div>
                               </div>
                            </div>

                        @endif
                 </div>

                <div class="form-group row">
                    <div class="col-lg-12 text-center">
                        <button type="button" class="btn btnbg add-more-audience" ><i class="fa fa-plus"></i> ADD</button>
                    </div>
                </div>
            </div>
            <div class="form-group-row">
				<div class="col-lg-4">
					<label for="status">Status</label>
					<div class="">
						<button type="button" onClick="setStatus(this, 'status', 0);"  class="btn @if(isset($row) && $row->status == 0) red-btn btn-selected @else red-invert-btn @endif"><i class="fas fa-times"></i></button>
						<button type="button" onClick="setStatus(this, 'status', 1);"  class="btn @if(isset($row) && $row->status == 1) green-btn btn-selected @else green-invert-btn @endif"><i class="fas fa-check"></i></button>
						<input type="hidden" id="status" name="status" value="@if(isset($row)) {{ $row->status }} @else 0 @endif"/>
					</div>
				</div>
			</div>

			<div class="form-group row">
				<div class="col-lg-12 text-right">
					<button type="submit" class="btn btnbg btn-success">Save</button>
				</div>
			</div>
			</form>
		</div>
		</div>
	</div>


    <div style="display: none;">
        <div class="clone_document document_row">
            <div class="form-group row">
                <div class="col-lg-12 text-right">
                    <button type="button" class="btn btnbg remove_doc btn-sm"><i class="fas fa-times"></i> REMOVE</button>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-6">
                    <label for="type">Document Type</label>
                    <select name="doc_type_id[]" class="form-control document_type" value="">
                        <option value="">-- Select Type --</option>
                        @foreach ($documentTypes as $docType)
                            <option value="{{ $docType->id }}">{{ $docType->type }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-6 other_col">
                    <label for="type" class="head_new">Please Specify</label>
                    <input type="text" class="form-control" name="type_other[]" id="type_other_new">
                </div>
                <div class="col-lg-6">
                    <label for="image">Upload Document</label>
                    <input type="File" class="form-control" name="document_file[]" aria-describedby="image" placeholder="Image" value=""/>
                </div>
            </div>
        </div>
     </div>


     <div class="modal fade" id="m_modal_6" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-hidden="true">
         <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
             <div class="modal-content">
                 <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">
                     Image Preview
                 </h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">
                             ×
                         </span>
                     </button>
                 </div>
                 <div class="modal-body">
                     <img src="" id="modal-image" width="100%">
                 </div>
             </div>
         </div>
     </div>

</div>
<style>
.red-invert-btn {
	background-color: #f6f6f6;
	color: red;
	border-radius: 0;
	font-size: 24px;
	padding: 8px 20px;
}
.red-btn{
    background-color:red;
    color:#f6f6f6;
	border-radius: 0;
	font-size: 24px;
	padding: 8px 20px;
}
.green-invert-btn{
    background-color:#f6f6f6;
    color:#469408;
	border-radius: 0;
	font-size: 24px;
	padding: 8px 20px;
}
.green-btn{
    background-color:#469408;
    color:#f6f6f6;
	border-radius: 0;
	font-size: 24px;
	padding: 8px 20px;
}
</style>

@endsection

@section('script')

<script type="text/javascript">
function setStatus(me, idName, value){
	if(value == 0){
		$(me).parent().find('button:eq(0)').removeClass('red-invert-btn');
		$(me).parent().find('button:eq(0)').addClass('red-btn');

		$(me).parent().find('button:eq(1)').removeClass('green-btn');
		$(me).parent().find('button:eq(1)').addClass('green-invert-btn');
	}
	if(value == 1){
		$(me).parent().find('button:eq(1)').removeClass('green-invert-btn');
		$(me).parent().find('button:eq(1)').addClass('green-btn');

		$(me).parent().find('button:eq(0)').removeClass('red-btn');
		$(me).parent().find('button:eq(0)').addClass('red-invert-btn');
	}
	$(me).parent().find('button').removeClass('btn-selected');
	$(me).addClass('btn-selected');
	$("#"+idName).val(value);
}

function remove(docId, $elem) {
    if(confirm("Are you sure you want to delete file ?")){
        $.ajax({
            type:'DELETE',
            url:'/api/client/document?' + $.param({
                "clientId"      : $('input[name="id"]').val(),
                "docId"         : docId
            }),
            success:function(response) {
                if(response) {
                    if( $elem.hasClass('first-document') ) {
                        var clone = $('.clone_document').clone();
                        $(clone).removeClass('clone_document');
                        $(clone).removeClass('active');
                        $(clone).find('.remove_doc').remove();
                        $('.audience-tab-content').append(clone);
                    }

                    $elem.closest('.document_row').remove();
                }
            }
        });
    }
}

$(document).ready(function(){
    $('.document_type').each(function(){
        $(this).trigger('change');
    });
});

$('.add-more-audience').click(function(){
    var clone = $('.clone_document').clone();
    $(clone).removeClass('clone_document');
    $(clone).removeClass('active');
    $('.audience-tab-content').append(clone);
});

$('body').on('click', '.remove_doc', function() {
    let docId   = $(this).parents('.form-group').prev('input').val();
    remove(docId, $(this));
});

$('body').on('click', '.file-preview', function() {
    var src = $(this).attr('data-src');
    var url = "{{url("/dore/client/")}}/" + src;
    window.open(url);
});
$('body').on('change', '.document_type', function() {
    var val = $(this).val();
    if(val == 4){
        $(this).closest('.form-group').find('.other_col').show();
    }else{
        $(this).closest('.form-group').find('.other_col').hide();
    }
});
</script>

@endsection
