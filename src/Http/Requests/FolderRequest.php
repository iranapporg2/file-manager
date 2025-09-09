<?php

	namespace itsunn\Filemanager\Http\Requests;

	use Illuminate\Foundation\Http\FormRequest;

	class FolderRequest extends FormRequest {

		public function rules(): array {

			return [
				'name' => ['required'],
				'folder_id' => ['nullable', 'exists:folders,id'],
			];
		}

		public function authorize(): bool {

			return true;
		}

	}
