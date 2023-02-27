<?php

namespace Api\V1_0_0\Services\File;


use Api\V1_0_0\Models\File;
use Api\V1_0_0\Repositories\Rest\RestRepository;
use Illuminate\Support\Facades\Storage;

class FileService {

	/**
	 * @var RestRepository
	 */
	private RestRepository $rest;
	/**
	 * @var Storage
	 */
	private Storage $storage;

	public function __construct(File $model, Storage $storage) {

		$this->rest = new RestRepository($model);
		$this->storage = $storage;
	}

	/**
	 * @param array $data
	 * @return array|null
	 */
	public function store(array $data) {

		return $this->rest->create($data);
	}

	/**
	 * @param int $id
	 * @param array $data
	 * @return array
	 */
	public function update(array $data, int $id){

		if ($response = $this->rest->getModel()->find($id)) {
			$response->fill($data)->save();

			return $this->show($id);
		}

	}

	/**
	 * @param int $id
	 * @return array
	 */
	public function show(int $id) {
		return $this->rest->show($id);
	}


	/**
	 * @param int $id
	 * @return array
	 */
	public function delete(int $id) {

		return $this->rest->delete($id);
	}

	/**
	 * @param array $data
	 * @return array
	 */
	public function list(array $data) {
		if ($data['paginate']) {
			return $this->rest->paginate($data['per_page']);
		}

		return $this->rest->all();
	}

	/**
	 * @param array $data
	 * @return array
	 */
	public function upload(array $data) {
		//get filename with extension
		$originalName = $data['file']->getClientOriginalName();
		//get filename without extension
		$filename = pathinfo($originalName, PATHINFO_FILENAME);
		//get file extension
		$extension = $data['file']->getClientOriginalExtension();
		//filename to store
		$fileNameToStore = $filename . '_' . time() . '.' . $extension;

		$fileNameToStore = preg_replace('/\s+/', '', $fileNameToStore);

        // We can get following parameters that can be stored for future use as per your requirement
        // $originalFileName = $data['file']->getClientOriginalName();
        // $originalFileExtension = $data['file']->getClientOriginalExtension();
        // $fileMime = $data['file']->getMimeType();
        // $fileContent = $data['file']->getContent(); // File binary data
        // $filenameForS3 = $data['directory'] . '/' . $originalFileName;

        // $response = Storage::disk('s3')->put($filenameForS3, $fileContent, []);

        $this->storage::disk('s3')->put($data['directory'] . "/". $fileNameToStore, fopen($data['file'], 'r+'), 's3');

		return [
			"full_url"  => $this->getFileFullUrl($data['directory'], $fileNameToStore),
			"path"      => $data['directory'],
			"file_name" => $fileNameToStore,
		];
	}

	/**
	 * @param string $path
	 * @param string $fileName
	 * @return string
	 */
	public function getFileFullUrl(string $path, string $fileName) {
		return $this->storage::disk("s3")->url($path . "/" . $fileName);
	}
}