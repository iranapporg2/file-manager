document.addEventListener("DOMContentLoaded", function () {
    let form_ajax = false;

    document.addEventListener("submit", function (e) {
        const form = e.target;

        if (form.matches("form[data-ajax]")) {
            e.preventDefault();

            if (form_ajax) return;
            form_ajax = true;

            if (typeof onStartEvent === "function") {
                onStartEvent();
            }

            const formData = new FormData(form);
            const xhr = new XMLHttpRequest();
            xhr.open("POST", form.getAttribute("action"), true);

            // پیشرفت آپلود
            xhr.upload.addEventListener("progress", function (evt) {
                if (evt.lengthComputable) {
                    const percentComplete = Math.round((evt.loaded / evt.total) * 100);
                    if (typeof onProgressEvent === "function") {
                        onProgressEvent(percentComplete);
                    }
                }
            });

            // موفقیت
            xhr.onload = function () {
                form_ajax = false;
                if (xhr.status >= 200 && xhr.status < 300) {
                    if (typeof onSuccessEvent === "function") {
                        onSuccessEvent(JSON.parse(xhr.responseText));
                    }
                } else {
                    if (typeof onFailedEvent === "function") {
                        onFailedEvent(xhr.statusText || "Error");
                    }
                }
            };

            // خطا
            xhr.onerror = function () {
                form_ajax = false;
                if (typeof onFailedEvent === "function") {
                    onFailedEvent(xhr.statusText || "Network Error");
                }
            };

            xhr.send(formData);
        }
    });
});
