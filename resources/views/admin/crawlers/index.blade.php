@extends('admin.layout')

@section('content')
<div class="container-fluid">
	<div class="row page-title-row">
		<div class="col-md-6">
			<h3>Lấy truyện tự động<small>&raquo; Danh sách</small></h3>
		</div>
		<div class="col-md-6 text-right">
			<a href="/admin/auto-crawl/create" class="btn btn-success btn-md"><i class="fa fa-plus-circle"></i> Tạo mới một link</a>
			
		</div>
	</div>

	<div class="row">
		<div class="col-sm-12">
			@include('admin.partials.errors')
			@include('admin.partials.success')

			<table class="table table-striped table-bordered">
				<caption><h5>Trang {{$crawlerTitles->currentPage() }} trên {{ $crawlerTitles->lastPage()}}</h5></caption>
				<thead>
					<tr>
						<th>Link</th>
						<th>Được chạy rồi</th>
						<th>Số chương</th>
						<th>Hành động</th>
					</tr>
				</thead>
				<tbody>
					@foreach($crawlerTitles as $crawlerTitle)
						<tr>
							<td>{{$crawlerTitle->slug}}</td>
							<td>{{$crawlerTitle->using}}</td>
							<td>{{$crawlerTitle->limit}}</td>
							<td>
								<a href="/admin/auto-crawl/{{$crawlerTitle->id}}/edit" class="btn btn-xs btn-info"><i class="fa fa-edit"></i> Edit</a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
			{!! $crawlerTitles->links() !!}

		</div>
		
	</div>
</div>
	
@stop