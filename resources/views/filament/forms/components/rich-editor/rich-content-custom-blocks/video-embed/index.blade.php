@if ($url)
    <div class="video-embed-block my-8 rounded-2xl overflow-hidden shadow-lg ring-1 ring-gray-900/5">
        <div class="video-placeholder" data-video-url="{{ e($url) }}"
            style="position: relative; width: 100%; padding-bottom: 56.25%; height: 0; overflow: hidden; background-color: #f3f4f6;">
        </div>
    </div>
    <script>
        (function () {
            function loadVideoIframe() {
                var placeholders = document.querySelectorAll('.video-placeholder[data-video-url]');
                placeholders.forEach(function (placeholder) {
                    var url = placeholder.getAttribute('data-video-url');
                    if (url && !placeholder.querySelector('iframe')) {
                        var iframe = document.createElement('iframe');
                        iframe.src = url;
                        iframe.style.position = 'absolute';
                        iframe.style.top = '0';
                        iframe.style.left = '0';
                        iframe.style.width = '100%';
                        iframe.style.height = '100%';
                        iframe.title = 'Video player';
                        iframe.frameBorder = '0';
                        iframe.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share';
                        iframe.referrerPolicy = 'strict-origin-when-cross-origin';
                        iframe.allowFullscreen = true;
                        placeholder.appendChild(iframe);
                    }
                });
            }

            // Execute immediately if page is already loaded, otherwise wait for load event
            if (document.readyState === 'complete') {
                loadVideoIframe();
            } else {
                window.addEventListener('load', loadVideoIframe);
            }
        })();
    </script>
@endif