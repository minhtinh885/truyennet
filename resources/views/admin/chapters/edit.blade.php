@extends('admin.layout')

@section('content')
	<div class="container-fluid">
		<div class="row page-title-row">
			<div class="col-md-12">
				<h3>Tác giả <small>&raquo; Sửa một chương</small></h3>
			</div>
		</div>

		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Biểu mẫu sửa chương</h3>
					</div>
					<div class="panel-body">
						@include('admin.partials.errors')
						@include('admin.partials.success')

						<form class="form-horizontal" action="/admin/chapter/{{$id}}" method="POST" accept-charset="utf-8" role="form">
							<input type="hidden" name="_token" value="{{csrf_token()}}">
							<input type="hidden" name="_method" value="PUT">
							<input type="hidden" name="id" value="{{$id}}">

							@include('admin.chapters._form')

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
					<form action="/admin/chapter/{{$id}}" method="POST" accept-charset="utf-8">
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
