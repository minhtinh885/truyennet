<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @if(Request::is('home') || Request::is('/'))
        <title>Đọc truyện online - TruyenNet</title>
        <meta name="description" content="TruyenNet online,Đọc truyện online, đọc truyện chữ, truyện hay, truyện net. Truyện NET luôn tổng hợp và cập nhật các chương truyện một cách nhanh nhất.">
        <meta name="keywords" content="truyen-net, truyennet.xyz, truyennet,doc truyen, doc truyen online, truyen hay, truyen chu">
        <link rel="canonical" href="http://truyennet.xyz/">
    @else
        @yield('description')
    @endif
    <link rel="alternate" type="application/rss+xml" href="{{url('rss')}}" title="RSS Feed TruyenNet, Đọc truyện online - TruyenNet">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}
    <link rel="stylesheet" href="/css/custom.css">
    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>
</head>
<body id="body-id">
<nav class="navbar navbar-default">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Danh sách</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/home"><span id="logo-truyennet"><strong>Truyen</strong>net</span></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Danh sách<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="/danh-sach/truyen-moi">Truyện mới cập nhật</a></li>
                        <li><a href="/danh-sach/truyen-hot">Truyện hot</a></li>
                        <li><a href="/danh-sach/truyen-hoan-thanh">Truyện đã hoàn thành</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Thể loại<span class="caret"></span></a>
                    <ul class="dropdown-menu dropdown-large">
                        @foreach($categories as $category)
                            <li><a href="/the-loai/{{$category->slug}}">{{$category->name}}</a></li>
                        @endforeach
                    </ul>
                </li>
            </ul>
            <form action="/tim-kiem/" class="navbar-form navbar-left" role="search" method="GET">
                <div class="form-group">
                    {{--<input type="hidden" name="_token" value="{{csrf_token()}}">--}}
                    {{--<input type="hidden" name="_method" value="GET">--}}
                    <input type="text" id="search-box" placeholder="Tìm kiếm truyện" name="tu-khoa">
                </div>
                <button id="search-submit" type="submit"><span class="glyphicon glyphicon-search"></span></button>
            </form>

            @yield('navbar-extends')
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            <i class="glyphicon glyphicon-user"></i> <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('/login') }}"><i class="glyphicon glyphicon-log-in"></i> Đăng nhập</a></li>
                            <li><a href="{{ url('/register') }}"><i class="glyphicon glyphicon-user"></i> Đăng ký</a></li>
                        </ul>
                    </li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Thoát</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
<hr id="header-line">

<section id="section-breadcrumb">
    <div class="container">
        <ol class="breadcrumb">
            @if(Request::is('home') || Request::is('/'))
                <span>Đọc truyện online, đọc truyện chữ, truyện full, truyện hay. Tổng hợp đầy đủ và cập nhật liên tục.</span>
            @else
                <li><a href="/">Truyện Net</a></li>
                @if(isset($breadScrumbs))
                    @for($i = 0; $i < count($breadScrumbs); $i++)
                        @if($i < count($breadScrumbs)-1)
                                <li><a href="/{{$breadScrumbs[$i][0]}}">{{$breadScrumbs[$i][1]}}</a></li>
                        @else <li>{{$breadScrumbs[$i][1]}}</li>
                        @endif
                    @endfor
                @endif
            @endif
            <span id="social" class="pull-right"><iframe src="https://www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fdoctruyennet%2F&width=121&layout=button_count&action=like&size=small&show_faces=false&share=true&height=46&appId" width="121" height="20" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe></span>
        </ol>
    </div>
</section>
<section>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
</section>
@yield('content')

        <!-- JavaScripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
{{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
@yield('script-extends')
</body>
</html>
