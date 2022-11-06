@extends('layouts.dore.app')

@section('content')
<div class="page-header">
	<div class="row">
		<div class="col-lg-12">
			@if(!isset($row))
			<h1>Create An Employee</h1>
			@else
			<h1>Update Employee</h1>
			@endif
			<hr/>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-8 offset-lg-2">
			<div class="">
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

			<form role="form" method="post" action="{{ route('employees.save') }}" class="" enctype="multipart/form-data">
				{{ csrf_field() }}
				<input type="hidden" name="id" value="{{ old('id', (isset($row)) ? $row->id : null) }}"/>

			<div class="card padall30 mrb30">
				<h4>General Details<hr class="hralignleft"/></h4>

				<div class="form-group row">
					<div class="col-lg-6">
						<label for="first_name">First Name</label>
						<input type="text" class="form-control" name="first_name" aria-describedby="first_name" placeholder="First Name" value="{{ old('first_name', (isset($row)) ? $row->first_name : '') }}" />
					</div>
					<div class="col-lg-6">
						<label for="last_name">Last Name</label>
						<input type="text" class="form-control" name="last_name" aria-describedby="last_name" placeholder="Last Name" value="{{ old('last_name', (isset($row)) ? $row->last_name : '') }}"/>
					</div>
				</div>

				<div class="form-group row">
					<div class="col-lg-6">
						<label for="phone">Phone</label>
						<input type="text" class="form-control" name="phone" aria-describedby="phone" placeholder="Phone" value="{{ old('phone', (isset($row)) ? $row->phone : '') }}" />
					</div>
					<div class="col-lg-6">
						<label for="email">Email</label>
						<input type="text" class="form-control" name="email" aria-describedby="email" placeholder="Email" value="{{ old('email', (isset($row)) ? $row->email : '') }}"/>
					</div>
				</div>
			</div>

			{{-- <div class="card padall30 mrb30">
				<h4>Login Details<hr class="hralignleft"/></h4>
				<div class="form-group row">
					<div class="col-lg-6">
						<label for="username">Username</label>
						<input type="text" class="form-control" name="username" aria-describedby="username" placeholder="Username" value="{{ old('username', (isset($user)) ? $user->username : '') }}" />
					</div>
					<div class="col-lg-6"></div>
				</div>

				<div class="form-group row">
					<div class="col-lg-6">
						<label for="password">Password</label>
						<input type="password" class="form-control" name="password" aria-describedby="password" placeholder="Password" value=""/>
					</div>
					<div class="col-lg-6">
						<label for="password_confirmation">Retype Password</label>
						<input type="password" class="form-control" name="password_confirmation" aria-describedby="password_confirmation" placeholder="Retype Password" value=""/>
					</div>
				</div>
			</div> --}}

			<div class="card padall30 mrb30">
				<h4>Location<hr class="hralignleft"/></h4>

				@if (\Request::is('employees/create'))
				<div class="form-group row">
					<div class="col-lg-6">
						<label for="client_id">Company</label>

						<select name="client_id" class="form-control">
							<option value="">Select Company</option>
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
				@else
					<input type="hidden" value="0" name="client_id"/>
					<input type="hidden" value="0" name="jobsite_id"/>
				@endif

				<div class="form-group row">
					<div class="col-lg-6">
						<label for="position">Position</label>

						<select name="position_id" class="form-control">
							<option value="">Select Position</option>
							@foreach ($positions as $position)
							<option value="{{ $position->id }}" @if(isset($row) && $row->position_id == $position->id) selected="selected" @endif>
								{{ $position->title }}
							</option>
							@endforeach
						</select>
					</div>
					<div class="col-lg-6">
					</div>
				</div>
			</div>

			<div class="card padall30 mrb30">
				<h4>Financial information<hr class="hralignleft"/></h4>

                <div class="accordion" id="accordionExample">
                    <div class="card">
                        <div class="card-header" id="headingOne">
                            <h4 class="accordian-title" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Bank Details
                                <span class="fa align-right fa-minus"></span>
                            </h4>
                        </div>
                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label for="account_name">Account Name</label>
                                        <input type="text" class="form-control" name="account_name" aria-describedby="account_name" placeholder="Account Name" value="{{ old('account_name', (isset($row)) ? $row->account_name : '') }}"/>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="account_bsb">BSB Number</label>
                                        <input type="text" class="form-control bsb" name="account_bsb" aria-describedby="account_bsb" placeholder="BSB Number" value="{{ old('account_bsb', (isset($row)) ? $row->account_bsb : '') }}" maxlength="7"/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label for="account_number">Account Number</label>
                                        <input type="text" class="form-control" name="account_number" aria-describedby="account_number" placeholder="Account Number" value="{{ old('account_number', (isset($row)) ? $row->account_number : '') }}"/>
                                    </div>
                                    <div class="col-lg-6">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingTwo">

                            <h4 class="accordian-title" class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Tax File Number
                                <span class="fa align-right fa-plus"></span>
                            </h4>
                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label for="file_number">Tax File Number</label>
                                        <input type="text" class="form-control tax" name="file_number" aria-describedby="file_number" placeholder="Tax File Number" value="{{ old('file_number', (isset($row)) ? $row->file_number : '') }}"/>
                                    </div>
                                    <div class="col-lg-6">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingThree">
                            <h5 class="mb-0">
                                <h4 class="accordian-title" class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Superannuation
                                    <span class="fa align-right fa-plus"></span>
                                </h4>
                            </h5>
                        </div>
                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label for="superannuation">Superannuation Company</label>
                                        <input type="text" class="form-control" name="superannuation" aria-describedby="superannuation" placeholder="Superannuation Company" value="{{ old('superannuation', (isset($row)) ? $row->superannuation : '') }}"/>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="member_number">Member Number</label>
                                        <input type="text" class="form-control" name="member_number" aria-describedby="member_number" placeholder="Member Number" value="{{ old('member_number', (isset($row)) ? $row->member_number : '') }}"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingThree">
                                <h4 class="accordian-title" class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    Subcontractor - if applicable
                                    <span class="fa align-right fa-plus"></span>
                                </h4>
                        </div>
                            <div id="collapseFour" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <div class="col-lg-6">
                                            <label for="abn">ABN</label>
                                            <input type="text" class="form-control" name="abn" aria-describedby="abn" placeholder="ABN" value="{{ old('abn', (isset($row)) ? $row->abn : '') }}"/>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-12">
                                            <label>Insurances</label><br>
                                            <label class="checkbox-inline">
                                                <input type="checkbox" name="insurance[]" aria-describedby="insurance" value="Public Liability"
                                                @if(isset($row) && in_array('Public Liability',explode(',', $row->insurance)))
                                                {{'checked'}}
                                                @endif />
                                                <span class="check_label">Public Liability</span>
                                            </label>

                                            <label class="checkbox-inline">
                                                <input type="checkbox" name="insurance[]" aria-describedby="insurance" value="Workers Compensation" @if(isset($row) && in_array('Workers Compensation',explode(',', $row->insurance)))
                                                {{'checked'}}
                                                @endif /><span class="check_label">Workers Compensation</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

				</div>

                <div class="card padall30 mrb30">
                    <h4>Licenses / Tickets<hr class="hralignleft"/></h4>

                    <div class="audience-tab-content">
                     @if(isset($licence) && count($licence) > 0)
                            @foreach($licence as $key => $lic)
                              <div class="licence_row">
                                    <input type="hidden" name="license_id[]" value="{{ $lic->id }}">
                                    @if($key == 0)
                                    <div class="form-group row">
                                       <div class="col-lg-12 text-right">
                                           <button type="button" class="btn btnbg remove_product_first btn-sm"><i class="fas fa-times"></i> REMOVE</button>
                                       </div>
                                    </div>
                                    @else
                                    <div class="form-group row">
                                       <div class="col-lg-12 text-right">
                                           <button type="button" class="btn btnbg remove_product btn-sm"><i class="fas fa-times"></i> REMOVE</button>
                                       </div>
                                    </div>
                                    @endif
                                   <div class="form-group row">
                                        <div class="col-lg-6">
                                            <label for="type">Type</label>
                                             <select name="license_type[]" class="form-control license_type" value="{{ $lic->license_type }}">
                                               <option value="">-- Select Type --</option>
                                               <option value="Drivers Licence" {{ $lic->license_type=="Drivers Licence" ? "selected" : ""}}>Drivers Licence</option>
                                               <option value="Passport" {{ $lic->license_type=="Passport" ? "selected" : ""}}>Passport</option>
                                               <option value="Visa" {{ $lic->license_type=="Visa" ? "selected" : ""}}>Visa</option>
                                               <option value="High Risk Work Licence" {{ $lic->license_type=="High Risk Work Licence" ? "selected" : ""}}>High Risk Work Licence</option>
                                               <option value="White Card" {{ $lic->license_type=="White Card" ? "selected" : ""}}>White Card</option>
                                               <option value="Other" {{ $lic->license_type=="Other" ? "selected" : ""}}>Other</option>
                                           </select>
                                        </div>
                                        <div class="col-lg-6 other_col">
                                            <label for="type" class="head">Please Specify</label>
                                            <input type="text" class="form-control" name="type_other[]" id="type_other" value="{{ $lic->other_type }}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                       <div class="col-lg-6">
                                           <label for="date">Expiration Date</label>
                                           <input type="date" class="form-control" name="license_date[]" aria-describedby="license_date" placeholder="Expiration Date" value="{{ $lic->license_date }}"/>
                                       </div>
                                       <div class="col-lg-6">
                                           <label for="lic_number">Licence Number</label>
                                           <input type="text" class="form-control" name="license_number[]" aria-describedby="license_number" placeholder="Licence Number" value="{{ $lic->license_number }}" required>
                                       </div>
                                   </div>
                                   <div class="form-group row">
                                       <div class="col-lg-6">
                                           <label for="image">Upload Photo Front</label>
                                           <input type="File" class="form-control" name="license_image_front[]" aria-describedby="image" placeholder="Image" value=""/>
                                           @if($lic->license_image_front != '')
                                           <button type="button" class="btn btnbg image-preview" data-src="{{ $lic->license_image_front }}"><i class="fa fa-eye"></i></button>
                                           @endif
                                       </div>
                                       <div class="col-lg-6">
                                           <label for="image">Upload Photo End</label>
                                           <input type="File" class="form-control" name="license_image_back[]" aria-describedby="image" placeholder="Image" value=""/>
                                           @if($lic->license_image_back != '')
                                           <button type="button" class="btn btnbg image-preview" data-src="{{ $lic->license_image_back }}"><i class="fa fa-eye"></i></button>

                                            @endif
                                       </div>
                                   </div>
                                </div>
                            @endforeach
                            @else

                                <div class="licence_row">
                                    <div class="form-group row">
                                        <div class="col-lg-6">
                                            <label for="type">Type</label>
                                             <select name="license_type[]" id="license_type" class="form-control license_type" value="">
                                               <option value="">-- Select Type --</option>
                                               <option value="Drivers Licence">Drivers Licence</option>
                                               <option value="Passport">Passport</option>
                                               <option value="Visa">Visa</option>
                                               <option value="High Risk Work Licence">High Risk Work Licence</option>
                                               <option value="White Card">White Card</option>
                                               <option value="Other">Other</option>
                                           </select>
                                        </div>
                                        <div class="col-lg-6 other_col">
                                            <label for="type" class="head">Please Specify</label>
                                            <input type="text" class="form-control" name="type_other[]" id="type_other">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                       <div class="col-lg-6">
                                           <label for="date">Expiration Date</label>
                                           <input type="date" class="form-control" name="license_date[]" aria-describedby="license_date" placeholder="Expiration Date" value=""/>
                                       </div>
                                       <div class="col-lg-6">
                                           <label for="lic_number">Licence Number</label>
                                           <input type="text" class="form-control" name="license_number[]" aria-describedby="license_number" placeholder="Licence Number" value="">
                                       </div>
                                   </div>
                                   <div class="form-group row">
                                       <div class="col-lg-6">
                                           <label for="image">Upload Photo Front</label>
                                           <input type="File" class="form-control" name="license_image_front[]" aria-describedby="image" placeholder="Image" value=""/>

                                       </div>
                                       <div class="col-lg-6">
                                           <label for="image">Upload Photo End</label>
                                           <input type="File" class="form-control" name="license_image_back[]" aria-describedby="image" placeholder="Image" value=""/>

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
                        <!--start status-->
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label for="status">Status</label>
                                <div class="">
                                    <button type="button" onClick="setStatus(this, 'status', 0);"  class="btn @if(isset($row) && $row->status == 0) red-btn btn-selected @else red-invert-btn @endif"><i class="fas fa-times"></i></button>
                                    <button type="button" onClick="setStatus(this, 'status', 1);"  class="btn @if(isset($row) && $row->status == 1) green-btn btn-selected @else green-invert-btn @endif"><i class="fas fa-check"></i></button>
                                    <input type="hidden" id="status" name="status" value="@if(isset($row)) {{ $row->status }} @else 0 @endif"/>
                                </div>
                            </div>
                            <div class="col-lg-6"></div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-12 text-right">
                                <button type="submit" class="btn btnbg btn-success">Save</button>
                            </div>
                        </div>
                        <!-- End status-->
                </div>

			</form>
		</div>
		</div>
	</div>
</div>


<div style="display: none;">
   <div class="clone_licence licence_row">
       <div class="form-group row">
           <div class="col-lg-12 text-right">
               <button type="button" class="btn btnbg remove_product btn-sm"><i class="fas fa-times"></i> REMOVE</button>
           </div>
       </div>
       <div class="form-group row">
           <div class="col-lg-6">
               <label for="type">Licence Type</label>
               <select name="license_type[]" class="form-control license_type" value="">
                   <option value="">-- Select Type --</option>
                   <option value="Drivers Licence">Drivers Licence</option>
                   <option value="Passport">Passport</option>
                   <option value="Visa">Visa</option>
                   <option value="High Risk Work Licence">High Risk Work Licence</option>
                   <option value="White Card">White Card</option>
                   <option value="Other">Other</option>
               </select>
           </div>
           <div class="col-lg-6 other_col">
               <label for="type" class="head_new">Please Specify</label>
               <input type="text" class="form-control" name="type_other[]" id="type_other_new">
           </div>
       </div>
       <div class="form-group row">
           <div class="col-lg-6">
               <label for="date">Expiration Date</label>
               <input type="date" class="form-control" name="license_date[]" aria-describedby="license_date" placeholder="Expiration Date" value=""/>
           </div>
           <div class="col-lg-6">
               <label for="lic_number">Licence Number</label>
               <input type="text" class="form-control" name="license_number[]" aria-describedby="license_number" placeholder="Licence Number" value=""/>
           </div>
       </div>
       <div class="form-group row">
           <div class="col-lg-6">
               <label for="image">Upload Photo Front</label>
               <input type="File" class="form-control" name="license_image[]" aria-describedby="image" placeholder="Image" value=""/>
           </div>
           <div class="col-lg-6">
               <label for="image">Upload Photo Back</label>
               <input type="File" class="form-control" name="license_image[]" aria-describedby="image" placeholder="Image" value=""/>
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
.accordian-title{
    padding: 10px 0px;
    margin: 0;
    cursor: pointer;
}
.check_label{
    margin-left: 10px;
    margin-right: 10px;
}
.align-right{
    float: right;
}
.close
{
    background-color: #f6f6f6;
    color: red;
    border-radius: 0;
    font-size: 20px;
    padding: 8px 20px;
}
.licence_row{
    border: 1px solid #d7d7d7;
    padding: 10px;
    margin: 10px;
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
</script>
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
$('.bsb').on('keyup', function() {
  var bsb = $(this).val().split("-").join("");
  if (bsb.length > 0) {
    bsb = bsb.match(new RegExp('.{1,3}', 'g')).join("-");
  }
  $(this).val(bsb);
});
$('.tax').on('keyup', function() {
  var tax = $(this).val().split(" ").join("");
  if (tax.length > 0) {
    tax = tax.match(new RegExp('.{1,3}', 'g')).join(" ");
  }
  $(this).val(tax);
});
$(document).ready(function(){
   $(".collapse").on('show.bs.collapse', function(){
       $(this).parent().find(".fa").removeClass("fa-plus").addClass("fa-minus");
   }).on('hide.bs.collapse', function(){
       $(this).parent().find(".fa").removeClass("fa-minus").addClass("fa-plus");
   });
    $('.license_type').each(function(){
        $(this).trigger('change');
    });
});
</script>
<script>
function remove(elem){
    var result=confirm("Are you sure you want to delete Image ?");
    if(result==true)
    {
        var id = $(elem).data("id");
        $.ajax({
                type:'GET',
                url:'/remove/'+id,
                success:function(result){
                location.reload();
            }
        });
    }
}

$('.add-more-audience').click(function(){
    var clone = $('.clone_licence').clone();
    $(clone).removeClass('clone_licence');
    $(clone).removeClass('active');
    $('.audience-tab-content').append(clone);

});
$('body').on('click', '.remove_product', function() {
    var tabpane = $(this).closest('.licence_row').remove();
});
$('body').on('click', '.remove_product_first', function() {
    var tabpane = $(this).closest('.licence_row').remove();
    var clone = $('.clone_licence').clone();
    $(clone).removeClass('clone_licence');
    $(clone).removeClass('active');
    $(clone).find('.remove_product').remove();
    $('.audience-tab-content').append(clone);
});
$('body').on('click', '.image-preview', function() {
    var src = $(this).attr('data-src');
    var url = "http://timesheets.firstchoicelabour.com.au/dore/employee/";
    $('#modal-image').attr('src',url+src);
    $('#m_modal_6').modal('toggle');
});
$('body').on('change', '.license_type', function() {
    var val = $(this).val();
    if(val == 'Other'){
        $(this).closest('.form-group').find('.other_col').show();
    }else{
        $(this).closest('.form-group').find('.other_col').hide();
    }
});

</script>
@endsection
