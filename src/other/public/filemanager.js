// function onStartEvent() {}
// function onSuccessEvent(data) {}
// function onFailedEvent(status) {}
// function onProgressEvent(progress) {}

document.addEventListener("DOMContentLoaded", function () {

    var form_ajax;

    $(document).on('submit', 'form[data-ajax]', function (e) {
        e.preventDefault();

        if (form_ajax) return;

        form_ajax = true;

        if (typeof onStartEvent === 'function') {
            onStartEvent();
        }

        // Create a new FormData object to handle both files and other input fields
        let formData = new FormData($(this)[0]);

        $.ajax({
            type: 'post',
            url: $(this).attr('action'),
            data: formData, // No need to JSON.stringify formData, it's already the right format
            processData: false, // Prevent jQuery from automatically transforming the data into a query string
            contentType: false, // Let the browser set the content type, including boundaries for file uploads
            success: function (msg) {
                form_ajax = false;
                if (typeof onSuccessEvent === 'function') {
                    onSuccessEvent(msg);
                }
            },
            xhr: function () {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function (evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = Math.round((evt.loaded / evt.total) * 100);
                        if (typeof onProgressEvent === 'function') {
                            onProgressEvent(percentComplete);
                        }
                    }
                }, false);

                return xhr;
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                form_ajax = false;
                if (typeof onFailedEvent === 'function') {
                    onFailedEvent(textStatus);
                }
            }
        }).always(function () {
            form_ajax = false;
        });
    });
});
