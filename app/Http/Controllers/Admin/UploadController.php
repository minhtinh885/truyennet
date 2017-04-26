<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\UploadsManager;
use App\Http\Requests\UploadNewFolderRequest;
use App\Http\Requests\UploadFileRequest;
use Illuminate\Support\Facades\File;

class UploadController extends Controller
{
    protected $manager;

    public function __construct(UploadsManager $manager)
    {
        // $this->middleware('auth');
    	$this->manager = $manager;
    }
    public function index(Request $request)
    {
    	$folder = $request->get('folder');
    	$data = $this->manager->folderInfo($folder);
    	return view('admin.upload.index', $data);
    }
    /**
     * [createFolder description] Create new folder
     * @param  UploadNewFolderRequest $request [description]
     * @return [type]                          [description]
     */
    public function createFolder(UploadNewFolderRequest $request)
    {
    	$new_folder = $request->get('new_folder');
    	$folder = $request->get('folder').'/'.$new_folder;

    	$result = $this->manager->createDirectory($folder);

    	if($result === true){
    		return redirect()->back()->withSuccess("Thư mục '$new_folder' đã được tạo.");
    	}

    	$error = $result ? : "Có lỗi đã xảy ra khi tạo thư mục.";
    	return redirect()->back()->withErrors([$error]);
    }
    /**
     * [deleteFile description] Delete a file
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function deleteFile(Request $request)
    {
    	$del_file = $request->get('del_file');
    	$path = $request->get('folder').'/'.$del_file;

    	$result = $this->manager->deleteFile($path);

    	if ($result === true) {
    		return redirect()->back()->withSuccess("Tập tin '$del_file' đã được xóa.");
    	}

    	$error = $result ? : "Có lỗi đã xảy ra khi đang xóa tập tin.";
    	return redirect()->back()->withErrors([$error]);
    }
    /**
     * [deleteFolder description]Delete a folder
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function deleteFolder(Request $request)
    {
    	$del_folder = $request->get('del_folder');
    	$folder = $request->get('folder').'/'.$del_folder;

    	$result = $this->manager->deleteDirectory($folder);
    	if ($result === true) {
    		return redirect()->back()->withSuccess("Thư mục '$del_folder' được xóa.");
    	}

    	$error = $result ? : "Có lỗi đã xảy ra khi đang xóa thư mục.";
    	return redirect()->back()->withErrors([$error]);
    }

    public function uploadFile(UploadFileRequest $request)
    {
    	$file = $_FILES['file'];
    	$fileName = $request->get('file_name');
    	$fileName = $fileName?:$file['name'];
    	$path = str_finish($request->get('folder'), '/') . $fileName;
    	$content = File::get($file['tmp_name']);

    	$result = $this->manager->saveFile($path, $content);

    	if ($result === true) {
    		return redirect()->back()->withSuccess("Tập tin '$fileName' đã tải lên.");
    	}

    	$error = $result ? : "Có lỗi đã xảy ra khi đang tải tập tin lên.";
    	return redirect()->back()->withErrors([$error]);
    }
}
