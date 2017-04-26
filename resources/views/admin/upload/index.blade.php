@extends('admin.layout')
@section('styles')
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css">
@stop
@section('content')
	<div class="container-fluid">
		<div class="row page-title-row">
			<div class="col-md-6">
				<h3 class="pull-left">Quản lý tập tin&nbsp;&nbsp;</h3>
				<div class="pull-left">
					<ul class="breadcrumb">
						@foreach($breadcrumbs as $path => $disp)
							<li><a href="/admin/upload?folder={{$path}}">{{$disp}}</a></li>
						@endforeach
						<li class="active">{{$folderName}}</li>
					</ul>
				</div>
			</div>
			<div class="col-md-6 text-right">
				<button type="button" class="btn btn-success btn-md" data-toggle="modal" data-target="#modal-folder-create">
					<i class="fa fa-plus-circle"></i> Tạo Mới Thư Mục
				</button>
				<button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#modal-file-upload">
					<i class="fa fa-upload"></i> Tải Lên
				</button>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				@include('admin.partials.errors')
				@include('admin.partials.success')
				<table id="uploads-table" class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>Tên</th>
							<th>Loại</th>
							<th>Ngày</th>
							<th>Kích cỡ</th>
							<th data-sortable="false">Chức năng</th>
						</tr>
					</thead>
					<tbody>
						@foreach($subfolders as $path => $name)
							<tr>
								<td><a href="/admin/upload?folder={{$path}}">
									<i class="fa fa-folder fa-lg fa-lw"></i>
										{{$name}}
									</a>
								</td>
								<td>Thư mục</td>
								<td>-</td>
								<td>-</td>
								<td>
									<button type="button" class="btn btn-xs btn-danger" onclick="delete_folder('{{$name}}')">
										<i class="fa fa-times-circle fa-lg"></i>Xóa
									</button>
								</td>
							</tr>
						@endforeach

						@foreach($files as $file)
							<tr>
								<td>
									<a href="{{$file['webPath']}}">
										@if(is_image($file['mimeType']))
											<i class="fa fa-file-image-o fa-lg fa-fw"></i>
										@else
											<i class="fa fa-file-o fa-lg fa-fw"></i>
										@endif
										{{$file['name']}}
									</a>
								</td>
								<td>{{$file['mimeType'] or 'Unknown'}}</td>
								<td>{{$file['modified']->format('j-M-Y g:ia')}}</td>
								<td>{{human_filesize($file['size'])}}</td>
								<td>
									<button type="button" class="btn btn-xs btn-danger" onclick="delete_file('{{$file['name']}}')">
										<i class="fa fa-times-circle fa-lg"></i> Xóa
									</button>
									@if(is_image($file['mimeType']))
										<button type="button" class="btn btn-xs btn-success" onclick="preview_image('{{$file['webPath']}}')">
											<i class="fa fa-eye fa-lg"></i> Xem
										</button>
									@endif
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
	@include('admin.upload._modals')
@stop
@section('scripts')
	<script src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js" type="text/javascript"></script>
	<script type="text/javascript">
		// Confirm file delete
		function delete_file(name)
		{
			$("#delete-file-name1").html(name);
			$("#delete-file-name2").val(name);
			$("#modal-file-delete").modal("show");
		}

		// Confirm folder delete
		function delete_folder(name)
		{
			$("#delete-folder-name1").html(name);
			$("#delete-folder-name2").val(name);
			$("#modal-folder-delete").modal("show");
		}

		// Preview image
		function preview_image(path)
		{
			$("#preview-image").attr("src", path);
			$("#modal-image-view").modal("show");
		}

		// Startup code

		$(document).ready(function(){
	    	$('#uploads-table').DataTable();
		});

	</script>
@stop