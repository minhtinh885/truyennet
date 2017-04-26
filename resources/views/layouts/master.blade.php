<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Đọc Truyện Trực Tuyến</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/main.css">
	
	<!-- Google Font -->
	<link href='css/lato.css' rel='stylesheet' type='text/css'>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.min.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
</head>
<body>
	<header id="header-top">
		<div class="container text-center vertical-align">
			<h1 id="logo"><strong>Truyen</strong>net</h1>
			<div id="search-area">
				<form action="/tim-kiem/" class="form-inline">
					<div class="input-group search-box">
						<input type="hidden" name="_token" value="">
						<input type="hidden" name="_method" value="POST">
						<input id="search" type="search" name="search" value="" placeholder="Tìm Kiếm Truyện">
							<button id="submit" type="submit"><span class="glyphicon glyphicon-search"></span></button>
							
					</div>
				</form>
			</div>
			<button id="list-category"><span class="glyphicon glyphicon-book"></span> Danh Mục</button>
			<button id="user"><span class="glyphicon glyphicon-user"></span></button>
		</div>
	</header>
	<nav id="user-area" role="user">
		<ul class="user-dropdown">
			<li><a href="#">Đăng Nhập</a></li>
			<li><a href="#">Đăng Ký</a></li>
		</ul>
	</nav>
	<nav id="breadcrumb" role="breadcrumb">
		<div class="container vertical-align">
	 		<ul class="breadcrumb-normal">
			  <li><a href="#">Home</a></li>
			  <li><a href="#">Pictures</a></li>
			  <li><a href="#">Summer 15</a></li>
			  <li>Italy</li>
			</ul>
		</div>
	</nav>

	@yield('content')
	
	
	
	<footer id="footer">
		<div class="container">
			<div class="row">
				<div class="col-md-4">
					<p>Truyện Full - Đọc truyện online, đọc truyện chữ, truyện hay. Website luôn cập nhật những bộ truyện mới thuộc các thể loại đặc sắc như truyện tiên hiệp, kiếm hiệp, hay truyện ngôn tình một cách nhanh nhất. Hỗ trợ mọi thiết bị như di động và máy tính bảng.</p>
				</div>
				<div class="col-md-4">
					<p>vo dao dan ton ac ba quan bang quan sach quan bang chap chuong than quyen thien vu vu cuc thien ha ta thieu duoc vuong tao than yeu than ky hoa bao thien vuong than ma thien ton bi thu trung sinh canh lo quan do</p>
				</div>
				<div class="col-md-4">
					<p>Contact - ToS - Sitemap</p>
				</div>
			</div>
		</div>

	</footer>

	<script src="js/main.js"></script>
</body>
</html>