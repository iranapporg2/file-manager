@php use itsunn\Filemanager\Enums\FileDriverEnum; @endphp
        <!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        td {
            text-align: right;
        }
    </style>
</head>
<body dir="rtl">

<div class="container" style="margin-top: 20px">
    <h5 dir="rtl" style="text-align: right">مدیریت فایل آی تی سان
        <a href="" data-toggle="modal" data-target="#modal-add" class="btn btn-info" style="float:left">آپلود فایل</a>
        <a href="" data-toggle="modal" data-target="#modal-add-folder" class="btn btn-info" style="float:left;margin-left: 10px">ایجاد پوشه</a>
    </h5>
    @if (session('message') || $errors->any())
        <div class="alert alert-info" style="margin-top: 25px;text-align: right;">
            @if (session('message'))
                <div>{{ session('message') }}</div>
            @endif

            @if ($errors->any())
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    @endif
    <table class="table" style="margin-top: 30px">
        <thead>
        <tr dir="rtl">
            <th style="text-align: right" scope="col">عنوان</th>
            <th style="text-align: right" scope="col">نوع</th>
            <th style="text-align: right" scope="col">حالت آپلود</th>
            <th style="text-align: right" scope="col">حجم/کیلوبایت</th>
            <th style="text-align: right" scope="col">تاریخ آپلود</th>
            <th style="text-align: right" scope="col">دانلود/نمایش</th>
            <th style="text-align: right" scope="col">عملیات</th>
        </tr>
        </thead>
        <tbody>
        @if (request()->filled('folder_id'))
            <tr>
                <td colspan="7">
                    <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 25 25" width="25" height="25"><defs><image  width="23" height="17" id="img1" href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABcAAAARCAMAAAABrcePAAAAAXNSR0IB2cksfwAAAJxQTFRF4K0x4K0x4K0x4K0x4K0xAAAA4K0x4K0x4K0x4K0x4K0x4K0x4K0x4K0x4K0x4K0x4K0x67c4/cZC/sdD/8hD/8hD98E//8hD/8hD4a0x/sdD/8hD/8hD6bU2/8hD8748+8VB/8hD/8hD5LAz/8hD77o6/8hD+MI//8hD4a4y/sdC/8hD/8hD4K0x67c4/8hD/8hD/8hD/8hD/8hD9+oEFQAAADR0Uk5TOczQjwQAkP+ikcNxcGgGXWT///TtT///Mf//8AT/m////BH/wf9r/yT//+MBUc3Nzs/QVmuGhQ4AAACRSURBVHicY2RgZGQAAUYoDQWMbDAu4x9kCUbOfzAmM0QHI+N3VHEY4PiGXZzzKyFxLlSnMIIwSJyfEV0PWFyI8S+aMAtYXOwXunL25yBxiR/o4v8+gMQlv6MJczE+BorLfEFXzvsQ5E65T+ji/PdB4gof0MUF7wLFFRjfogmLMN5kYNQFhyIkJCFe+s90iYEBAO6WJKErx0EKAAAAAElFTkSuQmCC"/></defs><style></style><use  href="#img1" x="1" y="4"/></svg>
                    <a href="{{route('files.index')}}?folder_id={{$back_folder}}&back">...</a>
                </td>
            </tr>
        @endif
        @foreach($folders as $folder)
            <tr>
                <td colspan="6">
                    <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 25 25" width="25" height="25"><defs><image  width="23" height="17" id="img1" href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABcAAAARCAMAAAABrcePAAAAAXNSR0IB2cksfwAAAJxQTFRF4K0x4K0x4K0x4K0x4K0xAAAA4K0x4K0x4K0x4K0x4K0x4K0x4K0x4K0x4K0x4K0x4K0x67c4/cZC/sdD/8hD/8hD98E//8hD/8hD4a0x/sdD/8hD/8hD6bU2/8hD8748+8VB/8hD/8hD5LAz/8hD77o6/8hD+MI//8hD4a4y/sdC/8hD/8hD4K0x67c4/8hD/8hD/8hD/8hD/8hD9+oEFQAAADR0Uk5TOczQjwQAkP+ikcNxcGgGXWT///TtT///Mf//8AT/m////BH/wf9r/yT//+MBUc3Nzs/QVmuGhQ4AAACRSURBVHicY2RgZGQAAUYoDQWMbDAu4x9kCUbOfzAmM0QHI+N3VHEY4PiGXZzzKyFxLlSnMIIwSJyfEV0PWFyI8S+aMAtYXOwXunL25yBxiR/o4v8+gMQlv6MJczE+BorLfEFXzvsQ5E65T+ji/PdB4gof0MUF7wLFFRjfogmLMN5kYNQFhyIkJCFe+s90iYEBAO6WJKErx0EKAAAAAElFTkSuQmCC"/></defs><style></style><use  href="#img1" x="1" y="4"/></svg>
                    <a href="{{route('files.index')}}?folder_id={{$folder->id}}">{{$folder->name}}</a>
                </td>
                <td>
                    <form action="{{route('folders.destroy',$folder)}}" method="post">
                        <button type="submit" class="btn btn-danger btn-sm" data-ajax-delete="true">
                            حذف
                        </button>
                        @csrf
                        @method('DELETE')
                    </form>

                </td>
            </tr>
        @endforeach
        @foreach($files as $file)
            <tr>
                <td>{{$file->title}}</td>
                <td>{{$file->type?->title()}}</td>
                <td>{{$file->driver?->title()}}</td>
                <td>{{number_format($file->filesize / 1024,0)}} کیلوبایت</td>
                <td>{{verta($file->created_at)->format('d F Y')}}</td>
                <td>{{$file->views_count}}</td>
                <td>
                    <form action="{{route('files.destroy',$file)}}" method="post" >
                        <button type="submit" class="btn btn-danger btn-sm" data-ajax-delete="true">
                            حذف
                        </button>
                        @csrf
                        @method('DELETE')
                    </form>

                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<div class="modal" tabindex="-1" role="dialog" id="modal-add">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" style="text-align: right">آپلود فایل جدید</h5>
            </div>
            <div class="modal-body">
                <form action="{{route('files.store')}}" data-ajax="true" method="post" data-token="{{csrf_token()}}" enctype="multipart/form-data">
                    <div class="form-group" style="text-align: right">
                        <label for="email">عنوان فایل:</label>
                        <input type="text" class="form-control" placeholder="" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="email" style="text-align: right;width: 100%">محل ذخیره سازی:</label>
                        <select class="form-control" name="driver" required>
                            <option></option>
                            @foreach(FileDriverEnum::cases() as $driver)
                                <option value="{{$driver->value}}">{{$driver->title()}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="email" style="text-align: right;width: 100%">فایل مورد نظر:</label>
                        <input type="file" class="form-control" placeholder="" name="files">
                    </div>
                    <div class="form-group">
                        <label for="email" style="text-align: right;width: 100%">آپلود فایل از لینک:</label>
                        <input type="text" class="form-control" name="file_url">
                    </div>
                    <div class="form-group" style="text-align: right;width: 100%">
                        <input type="checkbox" placeholder="" name="original_name" value="1">
                        <label for="email">استفاده از نام اصلی فایل:</label>
                    </div>
                    <div class="form-group" style="text-align: right;width: 100%">
                        <input type="checkbox" placeholder="" name="auto_extract_zip" value="1">
                        <label for="email">استخراج خودکار فایل زیپ</label>
                    </div>
                    <hr>
                    <input type="hidden" class="form-control" value="{{request()->folder_id ?? '/'}}" name="folder_id">
                    <button type="submit" id="submit" class="btn btn-success">اپلود فایل</button>
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="modal-add-folder">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" style="text-align: right">ایجاد پوشه</h5>
            </div>
            <div class="modal-body">
                <form action="{{route('folders.store')}}" data-ajax="true" method="post">
                    <div class="form-group" style="text-align: right">
                        <label for="email">نام پوشه:</label>
                        <input type="text" class="form-control" placeholder="" name="name" required>
                    </div>
                    <hr>
                    <input type="hidden" class="form-control" value="{{request()->folder_id ?? ''}}" name="folder_id">
                    <button type="submit" class="btn btn-success">ایجاد پوشه</button>
                    @method('POST')
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>

</body>
<script src="{{asset('assets/filemanager.js')}}?v={{filemtime('assets/filemanager.js')}}"></script>
<script>

    function onStartEvent() {

    }

    function onSuccessEvent(data) {
        console.log(data)
        if (data.status) {
            $("#submit").text(`آپلود شد!`);
            window.location.reload();
        }
        else
            alert(data.message);
    }

    function onFailedEvent(status) {

    }

    function onProgressEvent(progress) {
        $("#submit").text(`در حال آپلود (${progress}%)`);
    }
</script>
</html>
