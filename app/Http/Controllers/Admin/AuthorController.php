<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Author;
use App\Http\Requests\AuthorCreateRequest;
use App\Http\Requests\AuthorUpdateRequest;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $authors = Author::orderBy('updated_at', 'DESC')->paginate(15);
        return view('admin.authors.index')->withAuthors($authors);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $name = old('name', '');
        $description = old('description', '');
        return view('admin.authors.create', ['name' => $name, 'description' => $description]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AuthorCreateRequest $request)
    {
        $author = new Author();
        $author->name = $request->get('name');
        $author->description = $request->get('description');
        $author->save();
        return redirect('admin/author')->withSuccess("Tác giả '$author->name' đã được tạo thành công !");
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
        $author = Author::findOrFail($id);
        $data = ['id' => $id];
        $data['name'] = old('name', $author->name);
        $data['description'] = old('description', $author->description);
        return view('admin.authors.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AuthorUpdateRequest $request, $id)
    {
        $author = Author::findOrFail($id);
        $author->name = $request->get('name');
        $author->description = $request->get('description');
        // $category->slug = str_slug($request->get('name'));
        $author->save();
        return redirect("/admin/author/$id/edit")->withSuccess("Đã lưu thay đổi.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $author = Author::findOrFail($id);
        $author->delete();

        return redirect('/admin/author')->withSuccess("Tác giả '$author->name' đã được xóa.");
    }
}
