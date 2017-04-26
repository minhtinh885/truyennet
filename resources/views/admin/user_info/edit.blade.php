@extends('admin.layout')

@section('content')
	<div class="container-fluid">
		<div class="row page-title-row">
			<div class="col-md-12">
				<h3>Người dùng <small>&raquo; Sửa thông tin</small></h3>
			</div>
		</div>

		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Biểu mẫu sửa thông tin</h3>
					</div>
					<div class="panel-body">
						@include('admin.partials.errors')
						@include('admin.partials.success')

						<form class="form-horizontal" action="/admin/user-info/{{$id}}" method="POST" accept-charset="utf-8" role="form">
							<input type="hidden" name="_token" value="{{csrf_token()}}">
							<input type="hidden" name="_method" value="PUT">
							<input type="hidden" name="id" value="{{$id}}">
							<div class="form-group">
								<label for="name" class="col-md-2 control-label">Tên đầy đủ</label>
								<div class="col-md-8">
									<input type="text" class="form-control" name="fullname" value="{{$fullname}}" autofocus>
								</div>
							</div>
							<div class="form-group">
								<label for="stage_name" class="col-md-2 control-label">Nghệ danh</label>
								<div class="col-md-8">
									<input type="text" class="form-control" name="stage_name" value="{{$stage_name}}">
								</div>
							</div>
							<div class="form-group">
								<label for="description" class="col-md-2 control-label">Mô tả</label>
								<div class="col-md-10">
									<textarea name="description" cols="50" rows="10">{{$description}}</textarea>
								</div>
							</div>
							<div class="form-group">
								<label for="image_url" class="col-md-2 control-label">URL Ảnh</label>
								<div class="col-md-8">
									<input type="text" class="form-control" name="image_url" value="{{$image_url}}" id="image_url" onchange="preview_image()">
								</div>
								<div class="col-md-2">
									<img src="#" id="preview-image-url" class="img-responsive">
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-7 col-md-offset-3">
									<button type="submit" class="btn btn-primary btn-md">
										<i class="fa fa-save"></i> &nbsp; Lưu thay đổi
									</button>
									<button type="button" class="btn btn-danger btn-md" data-toggle="modal" data-target="#modal-delete">
										<i class="fa fa-times-circle"></i> Xóa
									</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	{{-- Confirm Delete --}}
	<div class="modal fade" id="modal-delete" tabIndex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Hãy xác nhận lại</h4>
				</div>
				<div class="modal-body">
					<p class="lead">
						<i class="fa fa-question-circle fa-lg"></i> &nbsp; Bạn có chắc là muốn xóa không?
					</p>
				</div>
				<div class="modal-footer">
					<form action="/admin/user-info/{{$id}}" method="POST" accept-charset="utf-8">
						<input type="hidden" name="_token" value="{{csrf_token()}}">
						<input type="hidden" name="_method" value="DELETE">
						<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
						<button type="submit" class="btn btn-danger"><i class="fa fa-times-circle"></i> Đồng ý</button>
					</form>
				</div>
			</div>
		</div>
	</div>
@stop

@section('scripts')
	<script type="text/javascript">
		var url = $("#image_url").val();
		$("#preview-image-url").attr('src', url);
		
		function preview_image()
		{
			var url = $("#image_url").val();
			$("#preview-image-url").attr('src', url);
			console.log('preview');
		}
	</script>
@stop