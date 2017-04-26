<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Chapter;
use App\Book;
use Carbon\Carbon;
use App\Http\Requests\Admin\ChapterCreateRequest;
use App\Http\Requests\Admin\ChapterUpdateRequest;
use Illuminate\Support\Facades\Auth;


class ChapterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    public function getChapterList($book_slug)
    {
        $book = Book::whereSlug($book_slug)->first();
        $chapters = Chapter::where('book_id', $book->id)->select('id', 'slug_chapter','title', 'ordinal', 'book_id', 'published_at')->orderBy('ordinal', 'ASC')->paginate(50);
        return view('admin.chapters.index', ['book' => $book, 'chapters' => $chapters]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($book_slug)
    {
        $book = Book::whereSlug($book_slug)->first();
        $data['book'] = $book;
        $data['title'] = old('title', '');
        $data['ordinal'] = old('ordinal', '');
        $data['content'] = old('content', '');
        $data['published_at'] = old('published_at', Carbon::now()->toDateTimeString());
        if(Chapter::where('book_id', $book->id)->count()){
            $current_ordinal = Chapter::where('book_id', $book->id)->max('ordinal') + 1;
        }else{
            $current_ordinal = 1;
        }

        $data['ordinal'] = old('ordinal', $current_ordinal);

        return view('admin.chapters.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ChapterCreateRequest $request)
    {
        $chapter = new Chapter();
        $chapter->title = $request->get('title');
        $chapter->ordinal = $request->get('ordinal');
        $chapter->content = $request->get('content');
        $chapter->book_id = $request->get('book_id');
        $chapter->published_at = $request->get('published_at');
        $chapter->user_id = Auth::user()->id;
        $chapter->save();
        $book_slug = Book::findOrFail($chapter->book_id)->slug;
        return redirect("admin/$book_slug/chapter-all")->withSuccess("Chương '$chapter->title' đã được tạo thành công !");

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $chapter = Chapter::findOrFail($id);
        $data['id'] = $id;
        $data['title'] = old('title', $chapter->title);
        $data['ordinal'] = old('ordinal', $chapter->ordinal);
        $data['content'] = old('content', $chapter->content);
        $data['published_at'] = old('published_at', $chapter->published_at);
        return view('admin.chapters.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ChapterUpdateRequest $request, $id)
    {
        $chapter = Chapter::findOrFail($id);
        if($chapter->title !== $request->get('title')){
            $chapter->title = $request->get('title');
        }
        $chapter->ordinal = $request->get('ordinal');
        $chapter->content = $request->get('content');
        $chapter->published_at = $request->get('published_at');
        $chapter->save();
        return redirect("admin/chapter/$chapter->id/edit")->withSuccess("Đã lưu thay đổi.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $chapter = Chapter::findOrFail($id);
        $chapter->delete();
        $book = Book::findOrFail($chapter->book_id);
        return redirect("admin/$book->slug/chapter-all")->withSuccess("Chương '$chapter->title' đã được xóa.");
    }
}
