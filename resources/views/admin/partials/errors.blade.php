@if(count($errors)>0)
	<div class="alert alert-danger">
		<strong>Whoops!</strong>
		Có một vài lỗi đã xảy ra.<br><hr>
		<ul>
			@foreach($errors->all() as $error)
				<li>{{$error}}</li>
			@endforeach
		</ul>
	</div>
@endif