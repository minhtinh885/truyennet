@extends('admin.layout')

@section('content')
	<div class="container-fluid">
		<div class="row page-title-row">
			<div class="col-md-12">
				<h3>Tác giả <small>&raquo; Tạo mới một quyển sách</small></h3>
			</div>
		</div>

		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default">
					<div class="panel panel-heading">
						<h3 class="panel-title">Biểu mẫu tạo mới quyển sách</h3>
					</div>
					<div class="panel-body">
						@include('admin.partials.errors')
						<form class="form-horizontal" role="form" method="POST" action="/admin/book">
							<input type="hidden" name="_token" value="{{csrf_token()}}">
							@include('admin.books._form')

							<div class="form-group">
								<div class="col-md-7 col-md-offset-3">
									<button type="submit" class="btn btn-primary btn-md">
										<i class="fa fa-plus-circle"></i> &nbsp; Thêm mới
									</button>
								</div>
							</div>
						</form>
					</div>
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