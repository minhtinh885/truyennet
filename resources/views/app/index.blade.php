@extends('layouts.master-app')
@section('content')

    <section>
        <div class="container">
            @include('app.partials.errors')
        </div>
    </section>


    <section id="hot-book">
        <div class="container">
            <div class="section-heading">
                <h3>Truyện Hot</h3>
            </div>
            <hr>
            <div class="row">
                <div class="col-xs-12 col-sm-3 img-thumb hidden-xs hidden-sm">
                    <article class="item">
                        @foreach($top as $t)
                            <a href="/{{$t->slug}}" title="{{$t->name}}">
                                <section>
                                    <img src="{{$t->image_url}}" class="img-responsive top-img">
                                </section>
                                <footer class="caption-book-number-one">
                                    <h4>{{$t->name}}</h4>
                                    <small class="btn-xs label-primary">{{$t->status}}</small>
                                </footer>
                            </a>
                        @endforeach
                    </article>
                </div>
                <div class="col-sm-9">
                    <div class="row">
                        @foreach($top as $t)
                            <div class="col-xs-6 col-sm-3 col-lg-2 img-thumb hidden-md hidden-lg">
                                <article class="item">
                                    <a href="/{{$t->slug}}" title="{{$t->name}}">
                                        <section>
                                            <img src="{{$t->image_url}}" alt="{{$t->name}}" class="img-responsive">
                                        </section>
                                        <footer class="caption-book">
                                            <h4>{{str_limit($t->name, 18)}}</h4>
                                            <small class="btn-xs label-primary">{{$t->status}}</small>
                                        </footer>
                                    </a>
                                </article>
                            </div>
                        @endforeach
                        @foreach($topBooks as $tbook)
                            <div class="col-xs-6 col-sm-3 col-lg-2 img-thumb">
                                <article class="item">
                                    <a href="/{{$tbook->slug}}" title="{{$tbook->name}}">
                                        <section>
                                            <img src="{{$tbook->image_url}}" alt="{{$tbook->name}}" class="img-responsive">
                                        </section>
                                        <footer class="caption-book">
                                            <h4>{{str_limit($tbook->name, 18)}}</h4>
                                            <small class="btn-xs label-primary">{{$tbook->status}}</small>
                                        </footer>
                                    </a>
                                </article>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <br>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-9">
                    <h3>Danh sách truyện</h3>
                    <br>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <tr>
                                <th>Tên truyện</th>
                                <th>Thể loại</th>
                                <th>Số chương</th>
                            </tr>
                            @foreach($books as $book)
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
                        </table>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                    <h3>Truyện bạn đã đọc</h3>
                    <hr>
                    <div id="recent">
                    </div>

                </div>
            </div>
        </div>
    </section>
    <br>
    <hr>
    <footer>
        <div class="container">
            <div class="col-sm-5">
                <strong>Truyennet</strong> - <a href="http://truyennet.dev/" title="Đọc truyện online">Đọc truyện</a> online, <a href="http://truyennet.dev/" title="Đọc truyện chữ">đọc truyện</a> chữ, <a href="http://truyennet.dev/" title="Truyện hay">truyện hay</a>. Website luôn cập nhật những bộ <a href="http://truyennet.dev/danh-sach/truyen-moi/" title="Truyện mới">truyện mới</a> thuộc các thể loại đặc sắc như <a href="http://truyennet.dev/the-loai/tien-hiep/" title="Truyện tiên hiệp">truyện tiên hiệp</a>, <a href="http://truyennet.dev/the-loai/kiem-hiep/" title="Truyện kiếm hiệp">kiếm hiệp</a>, hay <a href="http://truyennet.dev/the-loai/ngon-tinh/" title="Truyện ngôn tình">truyện ngôn tình</a> một cách nhanh nhất. Hỗ trợ mọi thiết bị như di động và máy tính bảng.
            </div>
            <div class="col-sm-7">
                <strong>Liên kết</strong> - <a href="http://truyennet.dev/" title="app android">Android</a>
            </div>
        </div>
    </footer>
@endsection
@section('script-extends')
    <script src="/js/home.js"></script>
@endsection