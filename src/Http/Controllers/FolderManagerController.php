<?php

    namespace itsunn\Filemanager\Http\Controllers;

    use itsunn\Filemanager\Enums\FileTypeEnum;
    use itsunn\Filemanager\Http\Requests\FolderRequest;
    use itsunn\Filemanager\Http\Requests\StoreFileRequest;
    use itsunn\Filemanager\Models\File;
    use itsunn\Filemanager\Models\Folder;
    use itsunn\Filemanager\Services\FileService;
    use Illuminate\Http\Request;
    use Illuminate\Routing\Controller;
    use Illuminate\Support\Facades\Storage;

    class FolderManagerController extends Controller {

        /**
         * Display a listing of the resource.
         */
        public function index() {

        }

        /**
         * Show the form for creating a new resource.
         */
        public function create() {

        }

        /**
         * Store a newly created resource in storage.
         */
        public function store(FolderRequest $request) {

            Folder::create($request->validated());

            return $this->response(true, 'پوشه جدید با موفقیت ذخیره شد');

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
        public function update() {

        }

        public function destroy(Folder $folder) {

            $folder->delete();

            return $this->response(true,'پوشه مورد نظر حذف شد');

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

    }
