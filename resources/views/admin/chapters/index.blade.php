@extends('admin.layout')

@section('content')
<div class="container-fluid">
	<div class="row page-title-row">
		<div class="col-md-6">
			<h3>Sách ({{$book->name}})<small>&raquo; Danh sách</small></h3>
		</div>
		<div class="col-md-6 text-right">
			<a href="/admin/{{$book->slug}}/create" class="btn btn-success btn-md"><i class="fa fa-plus-circle"></i> Tạo mới một chương</a>
			
		</div>
	</div>

	<div class="row">
		<div class="col-sm-12">
			@include('admin.partials.errors')
			@include('admin.partials.success')

			<table class="table table-striped table-bordered">
				<caption><h5>Trang {{$chapters->currentPage() }} trên {{ $chapters->lastPage()}}</h5></caption>
				<thead>
					<tr>
						<th>Thứ tự</th>
						<th>Tiêu đề</th>
						<th>Slug</th>
						<th>Ngày đăng</th>
						<th>Hành động</th>
					</tr>
				</thead>
				<tbody>
					@foreach($chapters as $chapter)
						<tr>
							<td>{{$chapter->ordinal}}</td>
							<td>{{$chapter->title}}</td>
							<td>{{$chapter->slug_chapter}}</td>
							<td>{{$chapter->published_at}}</td>
							<td>
								<a href="/admin/chapter/{{$chapter->id}}/edit" class="btn btn-xs btn-info"><i class="fa fa-edit"></i> Sửa</a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
			{!! $chapters->links() !!}

		</div>
		
	</div>
</div>
	
@stop