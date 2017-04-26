<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\UserInfo;
use App\Http\Requests\Admin\CreateUserInfoRequest;
use App\Http\Requests\Admin\UpdateUserInfoRequest;


class UserInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('user_info')->orderBy('updated_at', 'DESC')->paginate(15);
        return view('admin.user_info.index')->withUsers($users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserInfoRequest $request)
    {
        $user_info = new UserInfo();
        $user_info->fullname = $request->get('fullname');
        $user_info->stage_name = $request->get('stage_name');
        $user_info->description = $request->get('description');
        $user_info->image_url = $request->get('image_url');
        $user_info->user_id = $request->get('user_id');
        $user_info->save();
        return redirect('admin/user-info')->withSuccess("Thông tin '$user_info->fullname' đã được tạo thành công !");
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
        $user_info = UserInfo::findOrFail($id);
        $data = ['id' => $id];
        $data['fullname'] = old('fullname', $user_info->fullname);
        $data['stage_name'] = old('stage_name', $user_info->stage_name);
        $data['description'] = old('description', $user_info->description);
        $data['image_url'] = old('image_url', $user_info->image_url);
        return view('admin.user_info.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserInfoRequest $request, $id)
    {
        $user_info = UserInfo::findOrFail($id);
        $user_info->fullname = $request->get('fullname');
        $user_info->stage_name = $request->get('stage_name');
        $user_info->description = $request->get('description');
        $user_info->image_url = $request->get('image_url');
        $user_info->save();
        return redirect("/admin/user-info/$id/edit")->withSuccess("Đã lưu thay đổi.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user_info = UserInfo::findOrFail($id);
        $user_info->delete();

        return redirect('/admin/user-info')->withSuccess("Thông tin '$user_info->fullname' đã được xóa.");
    }
}
