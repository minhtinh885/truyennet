@extends('admin.layout')

@section('content')
<div class="container-fluid">
	<div class="row page-title-row">
		<div class="col-md-6">
			<h3>Thể loại truyện<small>&raquo; Danh sách</small></h3>
		</div>
		<div class="col-md-6 text-right">
			<a href="/admin/category/create" class="btn btn-success btn-md"><i class="fa fa-plus-circle"></i> Tạo mới một thể loại</a>
			
		</div>
	</div>

	<div class="row">
		<div class="col-sm-12">
			@include('admin.partials.errors')
			@include('admin.partials.success')

			<table class="table table-striped table-bordered">
				<caption><h5>Trang {{$categories->currentPage() }} trên {{ $categories->lastPage()}}</h5></caption>
				<thead>
					<tr>
						<th>Tên</th>
						<th>Slug</th>
						<th>Hành động</th>
					</tr>
				</thead>
				<tbody>
					@foreach($categories as $category)
						<tr>
							<td>{{$category->name}}</td>
							<td>{{$category->slug}}</td>
							<td>
								<a href="/admin/category/{{$category->id}}/edit" class="btn btn-xs btn-info"><i class="fa fa-edit"></i> Edit</a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
			{!! $categories->links() !!}

		</div>
		
	</div>
</div>
	
@stop