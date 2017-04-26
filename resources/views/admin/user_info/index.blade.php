@extends('admin.layout')

@section('content')
<div class="container-fluid">
	<div class="row page-title-row">
		<div class="col-md-6">
			<h3>Thông tin người dùng<small>&raquo; Danh sách</small></h3>
		</div>
		{{--<div class="col-md-6 text-right">
			<a href="/admin/user-info/create" class="btn btn-success btn-md"><i class="fa fa-plus-circle"></i> Tạo thông tin</a>

		</div>--}}
	</div>

	<div class="row">
		<div class="col-sm-12">
			@include('admin.partials.errors')
			@include('admin.partials.success')

			<table class="table table-striped table-bordered">
				<caption><h5>Trang {{$users->currentPage() }} trên {{ $users->lastPage()}}</h5></caption>
				<thead>
					<tr>
						<th>Tên</th>
						<th>Email</th>
						<th>Tên đầy đủ</th>
						<th>Nghệ danh</th>
						<th>Hình ảnh</th>
						<th>Hành động</th>
					</tr>
				</thead>
				<tbody>
					@foreach($users as $user)
						<tr>
							<td>{{$user->name}}</td>
							<td>{{$user->email}}</td>
							<td>@if($user->user_info){{$user->user_info->fullname}}@endif</td>
							<td>@if($user->user_info){{$user->user_info->stage_name}}@endif</td>
							<td>@if($user->user_info){{$user->user_info->image_url}}@endif</td>
							<td>
								@if($user->user_info)
									<a href="/admin/user-info/{{$user->user_info->id}}/edit" class="btn btn-xs btn-info"><i class="fa fa-edit"></i> Sửa</a>
								@else
									<button type="button" class="btn btn-success btn-xs" onclick="create_user_info('{{$user->name}}', '{{$user->id}}')">
										<i class="fa fa-plus-circle"></i> Tạo thông tin
									</button>
								@endif
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
			{!! $users->links() !!}

		</div>
		
	</div>
</div>

{{-- Create User Info --}}
<div class="modal fade" id="modal-create" tabIndex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Tạo thông tin cho người dùng <kbd><span id="create-user-name"></span></kbd> </h4>
			</div>
			<form class="form-horizontal" role="form" method="POST" action="/admin/user-info">
				<div class="modal-body">
					<input type="hidden" name="_token" value="{{csrf_token()}}">
					<input type="hidden" name="user_id" id="create-user-id">

					<div class="form-group">
						<label for="name" class="col-md-2 control-label">Tên đầy đủ</label>
						<div class="col-md-8">
							<input type="text" class="form-control" name="fullname" autofocus>
						</div>
					</div>
					<div class="form-group">
						<label for="stage_name" class="col-md-2 control-label">Nghệ danh</label>
						<div class="col-md-8">
							<input type="text" class="form-control" name="stage_name">
						</div>
					</div>
					<div class="form-group">
						<label for="description" class="col-md-2 control-label">Mô tả</label>
						<div class="col-md-10">
							<textarea name="description" cols="50" rows="10"></textarea>
						</div>
					</div>
					<div class="form-group">
						<label for="image_url" class="col-md-2 control-label">URL Ảnh</label>
						<div class="col-md-8">
							<input type="text" class="form-control" name="image_url" id="image_url" onchange="preview_image()">
						</div>
						<div class="col-md-2">
							<img src="#" id="preview-image-url" class="img-responsive">
						</div>
					</div>
				</div>

				<div class="modal-footer">
					<button type="submit" class="btn btn-primary btn-md">
						<i class="fa fa-plus-circle"></i> &nbsp; Thêm mới
					</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
				</div>
			</form>
		</div>
	</div>
</div>
	
@stop
@section('scripts')
	<script type="text/javascript">
		// Confirm file delete
		function create_user_info(name, id)
		{
			$("#create-user-name").html(name);
			$("#create-user-id").val(id);
			$("#modal-create").modal("show");
		}
		function preview_image()
		{
			var url = $("#image_url").val();
			$("#preview-image-url").attr('src', url);
		}
	</script>
@stop