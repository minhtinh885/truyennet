<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Book;
use App\Http\Requests\Admin\BookCreateRequest;
use App\Http\Requests\Admin\BookUpdateRequest;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::orderBy('updated_at', 'DESC')->paginate(15);
        return view('admin.books.index')->withBooks($books);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['name'] = old('name', '');
        $data['description'] = old('description', '');
        $data['image_url'] = old('image_url', 'http://truyennet.dev/uploads/Home/client.png');
        $data['source_from'] = old('source_from', 'truyennet.dev');
        $data['status'] = old('status', 'Đang tiến hành');
        return view('admin.books.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookCreateRequest $request)
    {
        $book = new Book();
        $book->name = $request->get('name');
        $book->description = $request->get('description');
        $book->image_url = $request->get('image_url');
        $book->source_from = $request->get('source_from');
        $book->status = $request->get('status');
        $book->review = 1;
        $book->save();
        return redirect('admin/book')->withSuccess("Quyển sách '$book->name' đã được tạo thành công !");
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
        $book = Book::findOrFail($id);
        $data['id'] = $id;
        $data['name'] = old('name', $book->name);
        $data['description'] = old('description', $book->description);
        $data['image_url'] = old('image_url', $book->image_url);
        $data['source_from'] = old('source_from', $book->source_from);
        $data['status'] = old('status', $book->status);
        return view('admin.books.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BookUpdateRequest $request, $id)
    {
        $book = Book::findOrFail($id);
        if($book->name !== $request->get('name')){
            $book->name = $request->get('name');
        }
        $book->description = $request->get('description');
        $book->image_url = $request->get('image_url');
        $book->source_from = $request->get('source_from');
        $book->status = $request->get('status');
//        $book->review = 1;
        $book->save();
        return redirect("admin/book/$id/edit")->withSuccess("Đã lưu thay đổi.");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();
        return redirect('admin/book')->withSuccess("Thể loại '$book->name' đã được xóa.");
    }
}
