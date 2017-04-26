<?php 
namespace App\Services;

use Carbon\Carbon;
use Dflydev\ApacheMimeTypes\PhpRepository;
use Illuminate\Support\Facades\Storage;

class UploadsManager
{
	protected $disk;
	protected $mimeDetect;

	public function __construct(PhpRepository $mimeDetect)
	{
		$this->disk = Storage::disk(config('truyennet.uploads.storage'));
		$this->mimeDetect = $mimeDetect;
	}

	/**
	 * [folderInfo description] Return files and directories withing a folder
	 * @param  [type] $folder [description] String
	 * @return [type]         [description] array of{
	 *                                      'folder' => 'path to current folder',
	 *                                      'folderName' => 'name of just current folder',
	 *                                      'breadCrumbs' => breadcrumb array of {$path => $foldername}
	 *                                      'folders' => array of {$path => $foldername} of each subfolder
	 *                                      'files' => array of file details on each file in folder
	 * }
	 */
	public function folderInfo($folder)
	{
		$folder = $this->cleanFolder($folder);

		$breadcrumbs = $this->breadcrumbs($folder);
		$slice = array_slice($breadcrumbs, -1);
		$folderName = current($slice);
		$breadcrumbs = array_slice($breadcrumbs, 0, -1);

		$subfolders = [];
		foreach (array_unique($this->disk->directories($folder)) as $subfolder) {
			$subfolders["/$subfolder"] = basename($subfolder);
		}

		$files = [];
		foreach ($this->disk->files($folder) as $path) {
			$files[] = $this->fileDetails($path);
		}

		return compact('folder', 'folderName', 'breadcrumbs', 'subfolders', 'files');
	}

	/**
	 * [cleanFolder description] Sanitize the folder name
	 * @param  [type] $folder [description]
	 * @return [type]         [description]
	 */
	protected function cleanFolder($folder)
	{
		return '/'.trim(str_replace('..', '', $folder), '/');
	}

	protected function breadcrumbs($folder)
	{
		$folder = trim($folder, '/');
		$crumbs = ['/' => 'root'];

		if(empty($folder)){
			return $crumbs;
		}

		$folders = explode('/', $folder);
		$build = '';
		foreach ($folders as $folder) {
			$build .= '/'.$folder;
			$crumbs[$build] = $folder;
		}

		return $crumbs;
	}
	/**
	 * [fileDetails description]Return an array of the file details for a file
	 * @param  [type] $path [description]
	 * @return [type]       [description]
	 */
	protected function fileDetails($path)
	{
		$path = '/'.ltrim($path, '/');

		return [
			'name' => basename($path),
			'fullPath' => $path,
			'webPath' => $this->fileWebpath($path),
			'mimeType' => $this->fileMimeType($path),
			'size' => $this->fileSize($path),
			'modified' => $this->fileModified($path),
		];
	}

	/**
	 * [fileWebpath description] Return the full web path to a file
	 * @param  [type] $path [description]
	 * @return [type]       [description]
	 */
	public function fileWebpath($path)
	{
		$path = rtrim(config('truyennet.uploads.webpath'), '/').'/'.ltrim($path, '/');
		return url($path);
	}


	/**
	 * [fileMimeType description] return the mime type
	 * @param  [type] $path [description]
	 * @return [type]       [description]
	 */
	public function fileMimeType($path)
	{
		return $this->mimeDetect->findType(pathinfo($path, PATHINFO_EXTENSION));
	}

	/**
	 * [fileSize description] Return the file size
	 * @param  [type] $path [description]
	 * @return [type]       [description]
	 */
	public function fileSize($path)
	{
		return $this->disk->size($path);
	}

	/**
	 * [fileModified description] return the last modified time
	 * @param  [type] $path [description]
	 * @return [type]       [description]
	 */
	public function fileModified($path)
	{
		return Carbon::createFromTimestamp($this->disk->lastModified($path));
	}

	/**
	 * [createDirectory description]Create a new directory
	 * @param  [type] $folder [description]
	 * @return [type]         [description]
	 */
	public function createDirectory($folder)
	{
		$folder = $this->cleanFolder($folder);

		if($this->disk->exists($folder)){
			return "Thư mục '$folder' đã tồn tại.";
		}

		return $this->disk->makeDirectory($folder);
	}
	/**
	 * [deleteDirectory description]Delete a directory
	 * @param  [type] $folder [description]
	 * @return [type]         [description]
	 */
	public function deleteDirectory($folder)
	{
		$folder = $this->cleanFolder($folder);
		$filesFolders = array_merge(
			$this->disk->directories($folder),
			$this->disk->files($folder)
		);

		if(!empty($filesFolders)){
			return "Thư mục phải trống mới có thể xóa.";
		}

		return $this->disk->deleteDirectory($folder);
	}
	/**
	 * [deleteFile description]Delete a file
	 * @param  [type] $path [description]
	 * @return [type]       [description]
	 */
	public function deleteFile($path){
		$path = $this->cleanFolder($path);
		if(! $this->disk->exists($path)){
			return "Tập tin không tồn tại.";
		}
		return $this->disk->delete($path);
	}
	/**
	 * [saveFile description]Save a file
	 * @param  [type] $path    [description]
	 * @param  [type] $content [description]
	 * @return [type]          [description]
	 */
	public function saveFile($path, $content){
		$path = $this->cleanFolder($path);

		if($this->disk->exists($path)){
			return "Tập tin đã tồn tại.";
		}
		return $this->disk->put($path, $content);
	}

}