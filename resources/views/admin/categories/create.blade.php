@extends('admin.layout')

@section('content')
	<div class="container-fluid">
		<div class="row page-title-row">
			<div class="col-md-12">
				<h3>Thể loại truyện <small>&raquo; Tạo mới một thể loại</small></h3>
			</div>
		</div>

		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default">
					<div class="panel panel-heading">
						<h3 class="panel-title">Biểu mẫu tạo mới thể loại</h3>
					</div>
					<div class="panel-body">
						@include('admin.partials.errors')
						<form class="form-horizontal" role="form" method="POST" action="/admin/category">
							<input type="hidden" name="_token" value="{{csrf_token()}}">
							<div class="form-group">
								<label for="name" class="col-md-3 control-label">Tên</label>
								<div class="col-md-3">
									<input type="text" class="form-control" name="name" value="{{$name}}" autofocus>
								</div>
							</div>

							@include('admin.categories._form')

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