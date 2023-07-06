@extends('admin.layout.base')

@section('title', 'Storage Request History ')

@section('content')

<div class="card">
    <div class="card-body">
        <div >
            <h5 class="mb-1">Storage Request History</h5>
            @if(count($requests) != 0)
            <table class="table table-striped table-bordered dataTable" id="table-2">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>@lang('admin.request.Booking_ID')</th>
                        <th>@lang('admin.request.User_Name')</th>
                        <th>@lang('admin.request.Total_Items')</th>
                        <th>@lang('admin.status')</th>
                        <th>@lang('admin.action')</th>
                        <th>Send Message To User</th>
                        <th>Send Email To User</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($requests as $index => $request)
                    <tr>
                        <td>{{ $index+1 }}</td>
                        <td>{{ $request->id }}</td>
                        <td>{{ $request->user->first_name. ' '. $request->user->last_name }}</td>
                        <td>{{ $request->userMovingRequestItems->count() }}</td>
                        <td>{{ $request->status }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-primary waves-effect dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    Action
                                </button>
                                <div class="dropdown-menu">
                                    <a href="{{ route('admin.user_storage_request.show', $request->id) }}" class="dropdown-item">
                                        <i class="fa fa-search"></i> More Details
                                    </a>
                                    @if($request->status != 'SAVE' && $request->status != 'COMPLETED')
                                        <a href="{{ route('admin.user_storage_request.edit', $request->id) }}" class="dropdown-item">
                                            <i class="fa fa-edit"></i> Update
                                        </a>
                                    @endif
                                    @if($request->status != 'COMPLETED')
                                        <a href="{{ route('admin.user_storage_request.editOrder', $request->id) }}" class="dropdown-item">
                                            <i class="fa fa-edit"></i> Edit Order
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            <button class="btn btn-info" onclick="showModal('{{ $request->user->mobile }}')">Send Message</button>
                        </td>
                        <td>
                            <button class="btn btn-info" onclick="showEmailModal('{{ $request->user->email }}')">Send Email</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>@lang('admin.request.Booking_ID')</th>
                        <th>@lang('admin.request.User_Name')</th>
                        <th>@lang('admin.request.Total_Items')</th>
                        <th>@lang('admin.status')</th>
                        <th>@lang('admin.action')</th>
                        <th>Send Message To User</th>
                        <th>Send Email To User</th>
                    </tr>
                </tfoot>
            </table>
            @else
            <h6 class="no-result">No results found</h6>
            @endif
        </div>
    </div>
</div>
<!-- The Modal -->
<div class="modal" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Modal Heading</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="mobile">Mobile</label>
                    <input type="tel" class="form-control" value="" name="mobile" id="mobile" disabled>
                </div>
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea name="message" id="message" class="form-control" rows="8" style="resize: none;" placeholder="Message"></textarea>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-info" onclick="sendMessage()" data-dismiss="modal">Send</button>
            </div>

        </div>
    </div>
</div>

<!-- The Modal -->
<div class="modal" id="myEmailModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Modal Heading</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" value="" name="mobile" id="email" disabled>
                </div>
                <div class="form-group">
                    <label for="emailMessage">Message</label>
                    <textarea name="message" id="emailMessage" class="form-control" rows="8" style="resize: none;" placeholder="Message"></textarea>
                </div>
                <div class="form-group">
                    <label for="file">Attachments</label>
                    <input type="file" name="file[]" multiple id="file">
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-info" onclick="sendEmail()" data-dismiss="modal">Send</button>
            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        function showModal(mobile){
            if (mobile === ''){
            	return alert('This User Has No Mobile Number!');
            }
            $("#myModal").modal();
            $("#mobile").val(mobile);
            $("#message").val(null);
        }
        function showEmailModal(email){
	        if (email === ''){
            	return alert('This User Has No Mobile Number!');
            }
            $("#myEmailModal").modal();
            $("#email").val(email);
            $("#emailMessage").val(null);
        }
        function sendMessage() {
	        let token = document.querySelector('input[name="_token"]');
	        window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.value;
	        let mobile = $("#mobile").val();
	        let message = $("#message").val();
	        let data = {"mobile": mobile, "message": message};
	        axios.post('/admin/user_storage_request/send_message', data).then( (response) => {
		        alert("Message Send Successfully");
	        }).catch( (error) => {
		        console.log(error)
	        });
        }
        function sendEmail() {
	        let token = document.querySelector('input[name="_token"]');
	        window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.value;
	        let data = new FormData();
	        let email = $("#email").val();
	        data.set('email', email);
	        let message = $("#emailMessage").val();
	        data.set('message', message);
	        let uploader = $('#file[type="file"]');
	        $.each(uploader[0].files, function() {
		        data.append('image[]', this);
	        });
	        uploader.val(null);
	        let url = '/admin/user_storage_request/send_email';
	        axios.post(url, data, { headers: { 'Content-Type' :'multipart/form-data'} })
                .then( (response) => {
                    alert("Email Send Successfully");
                }).catch( (error) => {
                    console.log(error)
                });
        }
    </script>
@endsection
