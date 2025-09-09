<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
    <h2>Upload new file</h2>
    <form action="http://127.0.0.1:8000/files" data-ajax="true" method="post" data-token="{{csrf_token()}}" enctype="multipart/form-data">
        <div class="form-group">
            <label for="email">Title</label>
            <input type="text" class="form-control" placeholder="" name="title">
        </div>
        <div class="form-group">
            <label for="email">Folder</label>
            <input type="text" class="form-control" value="/" name="path">
        </div>
        <div class="form-group">
            <label for="email">Driver</label>
            <input type="text" class="form-control" value="public" name="driver">
        </div>
        <div class="form-group">
            <label for="email">File</label>
            <input type="file" class="form-control" placeholder="" name="files">
        </div>
        <div class="form-group">
            <label for="email">Download from url (without file)</label>
            <input type="text" class="form-control" name="file_url">
        </div>
        <div class="form-group">
            <input type="checkbox" placeholder="" name="original_name" value="1">
            <label for="email">Force to use original name</label>
        </div>
        <div class="form-group">
            <input type="checkbox" placeholder="" name="auto_extract_zip" value="1">
            <label for="email">Auto extract zip file</label>
        </div>
        <button type="submit" id="submit" class="btn btn-default">Upload</button>
        @csrf
    </form>
</div>

</body>
<script src="{{asset('assets/filemanager.js')}}?v={{filemtime('assets/filemanager.js')}}"></script>
<script>

    function onStartEvent() {

    }

    function onSuccessEvent(data) {
        if (data.status)
            $("#submit").text(`Uploaded!`);
        else
            alert(data.message);
    }

    function onFailedEvent(status) {

    }

    function onProgressEvent(progress) {
        $("#submit").text(`Uploading(${progress}%)`);
    }
</script>
</html>
