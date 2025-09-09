<?php

    namespace itsunn\Filemanager\Http\Controllers;

    use itsunn\Filemanager\Enums\FileTypeEnum;
    use itsunn\Filemanager\Http\Requests\StoreFileRequest;
    use itsunn\Filemanager\Models\File;
    use itsunn\Filemanager\Services\FileService;
    use Illuminate\Http\Request;
    use Illuminate\Routing\Controller;
    use Illuminate\Support\Facades\Storage;

    class FileManagerController extends Controller {

        /**
         * Display a listing of the resource.
         */
        public function index(Request $request) {

            $files = File::query()->where(function($query) use ($request) {
				if ($request->filled('search')) $query->where('title','%'.$request->get('search').'%');
				if ($request->filled('folder')) $query->where('folder',$request->get('folder'));
			})->get();

            return $this->response(true, $files);

        }

        /**
         * Show the form for creating a new resource.
         */
        public function create() {

        }

        /**
         * Store a newly created resource in storage.
         */
        public function store(StoreFileRequest $request) {

            set_time_limit(0);

            $userData = $request->except(['original_name','file_url']);

            $files = $this->resolveFiles($request);

            if (count($files) == 0)
                return $this->response(false, 'امکان اپلود وجود ندارد.');

            $path = $request->path;

            foreach ($files as $file) {

                $created_file = File::query()->create($userData);

                $config = [
                    'disk' => $request->driver,
                    'channel_id' => $request->channel_id,
                    'title' => $request->title,
                ];

                if ($request->original_name == 1) {

                    $filename = $file->getClientOriginalName();

                    if (Storage::disk($request->driver)->exists("$path/$filename")) {
                        return $this->response(false, 'چنین فایلی قبلا آپلود شده است.');
                    }

                } else
                    $filename = $file->hashName();

                $result = $file->storeAs($path, $filename, $config);

                if (!$result) {
                    return $this->response(false, 'متاسفانه آپلود با شکست مواجه شد.');
                }

                $userData = $this->buildMetaTags($filename, $userData, $file);

                $created_file->update($userData);

            }

            return $this->response(true, 'فایل جدید با موفقیت ذخیره شد');

        }

        /**
         * Display the specified resource.
         */
        public function show() {

        }

        /**
         * Show the form for editing the specified resource.
         */
        public function edit() {
        }

        /**
         * Update the specified resource in storage.
         */
        public function update(StoreFileRequest $request, File $file) {

            $file->update($request->validated());

            return $this->response(true, 'تغییرات با موفقیت اعمال شد.');

        }

        public function destroy(File $file) {

            $file->delete();
            Storage::disk($file->driver)->delete($file->path.'/'.$file->filename);

            return $this->response(true,'فایل مورد نظر حذف شد');

        }

        private function response($status, $message = '', $data = null, $statusCode = 200) {

            $message = [
                'status' => $status,
                'message' => $message
            ];

            if (!is_null($data))
                $message['data'] = $data;

            return response()->json($message, $statusCode, [], JSON_UNESCAPED_UNICODE);

        }

        /**
         * @param StoreFileRequest $request
         * @return array|\Illuminate\Http\UploadedFile[]|\Illuminate\Http\UploadedFile[][]
         */
        private function resolveFiles(StoreFileRequest $request): array {

            if (count($request->allFiles()) == 0 && $request->filled('file_url')) {
                $files[] = FileService::getUrlAsUploadedFile($request->get('file_url'));
            } else {
                if ($request->auto_extract_zip) {
                    $files = FileService::extractZipFile($request->file('files')->path());
                } else
                    $files = $request->allFiles();
            }

            return $files;
        }

        /**
         * @param string $filename
         * @param array $userData
         * @param array|\Illuminate\Http\UploadedFile $file
         * @param FileTypeEnum $file_type
         * @return array
         */
        private function buildMetaTags(string $filename, array $userData, array|\Illuminate\Http\UploadedFile $file): array {

            $file_type = FileService::getFileType($file->getClientOriginalExtension());

            $userData['filename'] = $filename;
            $userData['filesize'] = $file->getSize();
            $userData['type'] = $file_type;
            $userData['content_type'] = $file->getClientMimeType();
            $userData['properties'] = FileService::getFileProperties($file_type, $file->path());

            if (\request()->driver == 'arvan') {
                $userData['properties'] = Storage::disk('arvan')->getAdapter()->properties();
            }

            return $userData;

        }

    }
