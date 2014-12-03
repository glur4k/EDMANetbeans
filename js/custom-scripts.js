$(function () {
    $('[data-toggle="popover"]').popover();
});

// Upload-Funktionalitaet
var app = app || {};

(function (o) {
    "use strict";

    // private methods
    var ajax, getFormData, setProgress;

    ajax = function (data) {
        var xmlhttp = new XMLHttpRequest(), uploaded;

        xmlhttp.addEventListener('readystatechange', function () {
            if (this.readyState === 4) {
                if (this.status === 200) {
                    uploaded = JSON.parse(this.response);

                    if (typeof o.options.finished === 'function') {
                        o.options.finished(uploaded);
                    }
                } else {
                    if (typeof o.options.error === 'function') {
                        o.options.error(uploaded);
                    }
                }
            }
        });
        
        xmlhttp.upload.addEventListener('progess', function(event) {
            var percent;
            
            if (event.lenghtComputable === true) {
                percent = Math.round((event.loaded / event.total) * 100);
                setProgress(percent);
            }
        });

        xmlhttp.open('post', o.options.processor);
        xmlhttp.send(data);
    };

    getFormData = function(source) {        
        var data = new FormData(), i;

        for (i = 0; i < source.length; i++) {
            data.append('file[]', source[i]);
        }

        data.append('ajax', true);

        return data;
    };

    setProgress = function (value) {
        var $ppc = $('.progress-pie-chart'),
                percent = parseInt($ppc.data('percent')),
                value = 360 * percent / 100;

        if (percent > 50) {
            $ppc.addClass('gt-50');
        }

        $('.ppc-progress-fill').css('transform', 'rotate(' + value + 'deg)');
        $('.ppc-percents span').html(percent + '%');
    };

    o.uploader = function (options) {
        o.options = options;

        if (o.options.files !== undefined) {
            ajax(getFormData(o.options.files.files));
        }
    };
}(app));

