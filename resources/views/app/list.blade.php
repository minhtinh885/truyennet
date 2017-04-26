@extends('layouts.master-app')
@section('description')
    @if(isset($title))
        <title>{{$title}}</title>
        <meta name="description" content="{{$description}}">
        <meta name="keywords" content="{{$keyword}}">
        <link rel="canonical" href="{{url()->full()}}">
    @endif
@endsection
@section('content')
    <div class="container">
        <section>
            <div class="row">
                <div class="col-xs-12 text-center">
                    <h2>{{$caption}}</h2>
                    <br>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
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
            </div>
            <div class="row text-center">
                {{$books->render()}}
            </div>
        </section>
    </div>
@endsection