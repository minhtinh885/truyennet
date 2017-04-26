@extends('admin.layout')

@section('content')
	<div class="container-fluid">
		<div class="row page-title-row">
			<div class="col-md-12">
				<h3>Sách <small>&raquo; Tạo mới một chương trong truyện - {{$book->name}}</small></h3>
			</div>
		</div>

		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default">
					<div class="panel panel-heading">
						<h3 class="panel-title">Biểu mẫu tạo mới chương</h3>
					</div>
					<div class="panel-body">
						@include('admin.partials.errors')
						<form class="form-horizontal" role="form" method="POST" action="/admin/chapter">
							<input type="hidden" name="_token" value="{{csrf_token()}}">
							<input type="hidden" name="book_id" value="{{$book->id}}">

							@include('admin.chapters._form')

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
