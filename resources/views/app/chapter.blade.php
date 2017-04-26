@extends('layouts.master-app')
@section('description')
    @if(isset($title))
        <title>{{$title}}</title>
        <meta name="description" content="Truyện {{$title}}">
        <meta name="keywords" content="{{$book->name}}, {{str_replace('-', ' ', str_slug($book->name))}}, {{str_replace('-', ' ', str_slug($book->name))}} {{str_replace('-', ' ', str_slug($chapter->slug_chapter))}}">
        <link rel="canonical" href="{{url()->full()}}">
    @endif
@endsection
@section('navbar-extends')
    <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="visible-xs">Tùy chỉnh<span class="caret"></span></span> <span class="hidden-xs"><i class="glyphicon glyphicon-cog"></i></span> </a>
            <ul class="dropdown-menu dropdown-medium">
                <li>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Màu nền</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="bg-id" onchange="customize();">
                                <option value="#FFFFFF">Màu trắng</option>
                                <option value="#ebebeb">Xám nhạt</option>
                                <option value="#eae4d3">Màu sepia</option>
                                <option value="#232323">Màu tối</option>
                            </select>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Font chữ</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="font-id" onchange="customize();">
                                <option value="'Lato', sans-serif">Lato</option>
                                <option value="'Palatino Linotype', sans-serif">Palatino Linotype</option>
                                <option value="'Segoe UI', sans-serif">Segoe UI</option>
                                <option value="Roboto, sans-serif" >Roboto</option>
                                <option value="'Patrick Hand', sans-serif">Patrick Hand</option>
                                <option value="'Noticia Text', sans-serif">Noticia Text</option>
                                <option value="'Times New Roman', sans-serif">Times New Roman</option>
                                <option value="Verdana, sans-serif">Verdana</option>
                                <option value="Tahoma, sans-serif">Tahoma</option>
                                <option value="Arial, sans-serif">Arial</option>
                            </select>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Size</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="size-id" onchange="customize();">
                                <option value="12px">12</option>
                                <option value="14px">14</option>
                                <option value="16px">16</option>
                                <option value="18px">18</option>
                                <option value="20px">20</option>
                                <option value="22px">22</option>
                                <option value="24px">24</option>
                                <option value="26px">26</option>
                                <option value="28px">28</option>
                                <option value="30px">30</option>
                            </select>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Chiều cao dòng</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="height-id" onchange="customize();">
                                <option value="140%">140%</option>
                                <option value="100%">100%</option>
                                <option value="120%">120%</option>

                                <option value="160%">160%</option>
                                <option value="180%">180%</option>
                                <option value="200%">200%</option>
                            </select>
                        </div>
                    </div>
                </li>

                <li>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Full khung</label>
                        <div class="col-sm-8">
                            <label class="radio-inline">
                                <input type="radio" name="fluid-switch" id="fluid-bg" value="fluid" onchange="customize();"> Có
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="fluid-switch" id="no-fluid-bg" value="no-fluid" onchange="customize();"> Không
                            </label>
                        </div>
                    </div>
                </li>

                <li>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Chạy tự động</label>
                        <div class="col-sm-8">
                            <label class="radio-inline">
                                <input type="radio" name="auto-scroll" id="auto-scroll-id" value="auto-scroll" onchange="customize();"> Có
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="auto-scroll" id="no-scroll-id" value="no-scroll" onchange="customize();"> Không
                            </label>
                        </div>
                    </div>
                </li>

                <li>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Thời gian chờ</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="time-delay-id" onchange="customize();">
                                <option value="10000">10000</option>
                                <option value="15000">15000</option>
                                <option value="20000">20000</option>
                                <option value="25000">25000</option>
                                <option value="30000">30000</option>
                                <option value="40000">40000</option>
                                <option value="60000">60000</option>
                                <option value="90000">60000</option>
                                <option value="120000">60000</option>
                            </select>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Chiều cao đọc</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="height-scroll-id" onchange="customize();">
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="120">120</option>
                                <option value="160">160</option>
                                <option value="180">180</option>
                                <option value="200">200</option>
                                <option value="250">250</option>
                                <option value="300">300</option>
                            </select>
                        </div>
                    </div>
                </li>

            </ul>
        </li>
    </ul>
@endsection


@section('content')
    <div class="container" id="container-chapter">
        <div class="hidden">
            <p id="book-name">{{$book->name}}</p>
            <p id="book-slug">{{$book->slug}}</p>
            <p id="chap-name">{{$chapter->title}}</p>
            <p id="chap-slug">{{$chapter->slug_chapter}}</p>
        </div>
        <section class="chapter-info">
            <article>
                <div class="row text-center">
                    <h3>{{$chapter->title}}</h3>
                </div>

                <div class="row text-center">
                    <a class="btn btn-info" @if($prev == null) disabled @else href="/{{Request::segment(count(Request::segments())-1)}}/{{$prev}}"@endif><span>«</span> Chương trước</a>
                    <a class="btn btn-info" @if($next == null) disabled @else href="/{{Request::segment(count(Request::segments())-1)}}/{{$next}}"@endif>Chương sau <span>»</span></a>
                </div>
                <br>
                <div id="chapter-content">
                    <p>{!! $chapter->content !!}</p>
                </div>
                <br>
            </article>
        </section>
        <section>
            <div class="row text-center">
                <a id="prev-id" class="btn btn-info" @if($prev == null) disabled @else href="/{{Request::segment(count(Request::segments())-1)}}/{{$prev}}"@endif><span>«</span> Chương trước</a>
                <a id="next-id" class="btn btn-info" @if($next == null) disabled @else href="/{{Request::segment(count(Request::segments())-1)}}/{{$next}}"@endif>Chương sau <span>»</span></a>
            </div>
            <br>
        </section>
    </div>
@endsection

@section('script-extends')
    <script src="/js/custom.js"></script>

@endsection