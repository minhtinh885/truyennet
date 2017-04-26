@extends('admin.layout')

@section('content')
<div class="container-fluid">
	<div class="row page-title-row">
		<div class="col-md-6">
			<h3>Sách<small>&raquo; Danh sách</small></h3>
		</div>
		<div class="col-md-6 text-right">
			<a href="/admin/book/create" class="btn btn-success btn-md"><i class="fa fa-plus-circle"></i> Tạo mới một quyển truyện</a>
			
		</div>
	</div>

	<div class="row">
		<div class="col-sm-12">
			@include('admin.partials.errors')
			@include('admin.partials.success')

			<table class="table table-striped table-bordered">
				<caption><h5>Trang {{$books->currentPage() }} trên {{ $books->lastPage()}}</h5></caption>
				<thead>
					<tr>
						<th>Tên</th>
						<th>Slug</th>
						<th>Mô tả</th>
						<th>Hình ảnh</th>
						<th>Nguồn</th>
						<th>Trạng thái</th>
						<th>Đánh giá</th>
						<th>Hành động</th>
					</tr>
				</thead>
				<tbody>
					@foreach($books as $book)
						<tr>
							<td>{{$book->name}}</td>
							<td>{{$book->slug}}</td>
							<td>@if(strlen($book->description) > 30){{substr($book->description, 0, 30)}}... @else {{$book->description}} @endif</td>
							<td>{{$book->image_url}}</td>
							<td>{{$book->source_from}}</td>
							<td>{{$book->status}}</td>
							<td>{{$book->review}}</td>
							<td>
								<a href="/admin/book/{{$book->id}}/edit" class="btn btn-xs btn-info"><i class="fa fa-edit"></i> Sửa</a>
								<a href="/admin/{{$book->slug}}/chapter-all" class="btn btn-xs btn-success"><i class="fa fa-book"></i> Xem ds</a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
			{!! $books->links() !!}

		</div>
		
	</div>
</div>
	
@stop