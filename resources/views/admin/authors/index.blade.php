@extends('admin.layout')

@section('content')
<div class="container-fluid">
	<div class="row page-title-row">
		<div class="col-md-6">
			<h3>Tác giả<small>&raquo; Danh sách</small></h3>
		</div>
		<div class="col-md-6 text-right">
			<a href="/admin/author/create" class="btn btn-success btn-md"><i class="fa fa-plus-circle"></i> Tạo mới một tác giả</a>
			
		</div>
	</div>

	<div class="row">
		<div class="col-sm-12">
			@include('admin.partials.errors')
			@include('admin.partials.success')

			<table class="table table-striped table-bordered">
				<caption><h5>Trang {{$authors->currentPage() }} trên {{ $authors->lastPage()}}</h5></caption>
				<thead>
					<tr>
						<th>Tên</th>
						<th>Slug</th>
						<th>Mô tả</th>
						<th>Hành động</th>
					</tr>
				</thead>
				<tbody>
					@foreach($authors as $author)
						<tr>
							<td>{{$author->name}}</td>
							<td>{{$author->slug}}</td>
							<td>{{$author->description}}</td>
							<td>
								<a href="/admin/author/{{$author->id}}/edit" class="btn btn-xs btn-info"><i class="fa fa-edit"></i> Edit</a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
			{!! $authors->links() !!}

		</div>
		
	</div>
</div>
	
@stop