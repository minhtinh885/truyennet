@extends('layouts.master-app')
@section('description')
    @if(isset($title))
        <title>{{$title}}</title>
        <meta name="description" content="Đọc truyện {{$book->name}} của tác giả @foreach($book->authors as $author){{$author->name}}@endforeach, {{$book->status}}. Hỗ trợ xem trên di động, máy tính bảng. ">
        <meta name="keywords" content="{{$book->name}}, {{str_replace('-', ' ', str_slug($book->name))}}, doc truyen {{str_replace('-', ' ', str_slug($book->name))}}@if($book->status == 'Đã hoàn thành'), {{str_replace('-', ' ', str_slug($book->name))}} full @endif">
        <link rel="canonical" href="{{url()->full()}}">
    @endif
    <meta property="og:site_name" content="TruyenNet">
    <meta property="og:type" content="book">
    <meta property="og:title" content="{{$book->name}}" />
    <meta property="og:image" content="{{url('/')}}{{$book->image_url}}" />
    <meta property="og:description" content="{{ $book->description }}" />
    <meta property="og:url"content="{{url()->current()}}" />
@endsection
@section('content')

    <div id="fb-root"></div>
    <script>(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.6";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>

    <div class="container">
        <section class="book-info">
            <article>
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <h3>{{$book->name}}</h3>
                        @foreach($book->authors as $author)
                            <p>Tác giả: {{$author->name}}</p>
                        @endforeach
                    </div>
                    <div class="col-sm-3">
                        <img class="img-responsive" src="{{$book->image_url}}" alt="{{$book->name}}">
                    </div>
                    <div class="col-sm-9">
                        <p>{!! $book->description !!}</p>
                    </div>
                </div>

            </article>
        </section>
        <br>
        <section class="chapters">
            <h4>Danh sách chương:</h4>
            <div class="row">
                @foreach($chapters as $chapter)
                    <div class="col-sm-6">
                        <a href="/{{$book->slug}}/{{$chapter->slug_chapter}}">{{$chapter->title}}</a>
                    </div>

                @endforeach
            </div>
            <div class="row text-center">
                {{$chapters->render()}}
            </div>
        </section>
        <br>
        <section>
            <div class="row">
                <div class="col-md-6">
                    <div class="fb-comments" data-href="http://truyennet.dev/{{$book->slug}}" data data-numposts="10"></div>
                </div>
                <div class="col-md-6">
                    <b>Truyện cùng tác giả</b>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <tr>
                                <th>Tên truyện</th>
                                <th>Thể loại</th>
                                <th>Số chương</th>
                            </tr>
                            @foreach($authors as $author)
                                @foreach($author->books as $book)
                                    <tr>
                                        <td><a href="/{{$book->slug}}">{{$book->name}}</a></td>
                                        <td>
                                            @foreach($book->categories as $category)
                                                <a href="/the-loai/{{$category->slug}}">{{$category->name}}</a>
                                                {{semi_value($book->categories->last()->name, $category->name)}}
                                            @endforeach
                                        </td>
                                        <td><a href="/{{$book->slug}}/chuong-{{$book->chapters()->max('ordinal')}}">Chương {{$book->chapters()->max('ordinal')}}</a></td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </table>
                    </div>

                </div>
            </div>
        </section>

    </div>
@endsection