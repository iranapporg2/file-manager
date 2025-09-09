<?php

    namespace itsunn\Filemanager\Http\Requests;

    use Illuminate\Foundation\Http\FormRequest;
    use Illuminate\Http\Exceptions\HttpResponseException;
    use Illuminate\Validation\Rule;
    use itsunn\Filemanager\Enums\FileDriverEnum;
    use Illuminate\Contracts\Validation\Validator;

    class StoreFileRequest extends FormRequest {

        public function authorize(): bool {
            return true;
        }

        protected function prepareForValidation() {
            request()->request->add(['is_create' => request()->isMethod('POST')]);
        }

        public function rules(): array {

            $rules = [
                'title' => ['required', 'string', 'max:255'],
                'description' => ['nullable', 'string', 'max:1000'],
                'properties' => ['nullable', 'array'],
            ];

            if (request()->isMethod('POST')) {
                $rules['folder_id'] = ['nullable', 'exists:folders,id'];
                $rules['driver'] = ['required', Rule::in(FileDriverEnum::values())];
                $rules['channel_id'] = ['nullable','string'];
                $rules['original_name'] = ['nullable', 'boolean'];
                $rules['auto_extract_zip'] = ['nullable', 'boolean'];
                $rules['file_url'] = ['nullable','string', 'max:255', 'url'];
                $rules['files'] = ['nullable', 'file'];
            }

            return $rules;

        }

        public function messages(): array {

            return [
                'title' => 'عنوان فایل الزامی است.',
                'path' => 'عنوان فایل الزامی است.',
                'driver' => 'درایور انتخاب شده معتبر نیست.',
                'type' => 'نوع فایل انتخاب شده معتبر نیست.',
                'file_url' => 'لینک فایل اشتباه است.',
                'file' => 'فایل جهت آپلود را ارسال کنید.'
            ];
        }

        public function failedValidation(Validator $validator) {
            throw new HttpResponseException(response()->json([
                'status' => false,
                'message' => implode("\n", $validator->errors()->all())
            ]));
        }

    }
