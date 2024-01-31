"use strict";

$(document).ready(function() {
    var id = '#file_uploader';

    var uppyDrag = Uppy.Core({
        autoProceed: true,
        restrictions: {
            maxFileSize: 20000000, // 20mb
            maxNumberOfFiles: 5,
            minNumberOfFiles: 1,
            allowedFileTypes: ['image/*', 'video/*', 'application/*']
        },
        meta: {
            'scheme_id' : ''
        }
    });

    uppyDrag.use(Uppy.DragDrop, {
        target: id + ' .uppy-drag',
        locale: {
            strings: {
                dropHereOr: 'Drop files here or %{browse}',
                browse: 'choose files',
            },
        }
    });
    // uppyDrag.use(Uppy.ProgressBar, {
    //     target: id + ' .uppy-progress',
    //     hideUploadButton: false,
    //     hideAfterFinish: true,
    // });
    
    uppyDrag.use(Uppy.XHRUpload, { 
        endpoint: $('#uppy_endpoint').val(),
        method: 'post',
        timeout: 0,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        getResponseData (responseText, response) {
            return response;
        }
    });

    uppyDrag.use(Uppy.StatusBar, {
        target: id + ' .uppy-status',
        hideAfterFinish: true,
        showProgressDetails: true,
        hideUploadButton: true,
        hideRetryButton: true,
        hidePauseResumeButton: true,
        hideCancelButton: true,
        doneButtonHandler: null,
        locale: {},
    });

    uppyDrag.on('file-added', (file) => {
        var allowed_extensions = ['png', 'jpg', 'jpeg', 'gif', 'svg', 'mp4', 'flv', 'webp', 'pdf', 'doc', 'docx', 'xls', 'xlsx'];
        if($.inArray(file.extension, allowed_extensions) == -1) {
            console.log("File Removed : ", file);
            uppyDrag.removeFile(file.id);
            return;
        }
        var imagePreview = "";
        var thumbnail_inner = "";
        if ((/image/).test(file.type)){
            thumbnail_inner = '<img src="" style="width:30px;" />';
            // thumbnail_inner = '<i class="fa fa-image" style="font-size: 20px;"></i>';
        }
        else if ((/video/).test(file.type)) {
            thumbnail_inner = '<i class="fa fa-video" style="font-size: 20px;"></i>';
        }
        else if ((/application/).test(file.type)) {
            thumbnail_inner = '<i class="fa fa-file" style="font-size: 20px;"></i>';
        }
        var thumbnail = '<div class="uppy-thumbnail col-sm-2">'+thumbnail_inner+'</div>';

        var sizeLabel = "bytes";
        var filesize = file.size;
        if (filesize > 1024){
            filesize = filesize / 1024;
            sizeLabel = "kb";
            if(filesize > 1024){
                filesize = filesize / 1024;
                sizeLabel = "MB";
            }
        }
        imagePreview += '<div class="uppy-thumbnail-container p-3 row col-md-12 alert alert-warning" data-id="'+file.id+'">'+thumbnail+' <span class="uppy-thumbnail-label col-sm-8">'+file.name+' ('+ Math.round(filesize, 2) +' '+sizeLabel+')</span><span data-id="'+file.id+'" class="uppy-remove-thumbnail col-sm-2 text-right"><i class="fas fa-circle-notch fa-spin"></i></span></div>';

        // append to view
        $(id + ' .uppy-thumbnails').append(imagePreview);
    });

    uppyDrag.on('upload-success', (file, response) => {
        console.log(response);
        var response = JSON.parse(response.body.response);
        $('.uppy-thumbnail-container[data-id="'+file.id+'"').removeClass('alert-warning');
        $('.uppy-thumbnail-container[data-id="'+file.id+'"').addClass('alert-success');
        $($('.uppy-thumbnail-container[data-id="'+file.id+'"').find('.uppy-remove-thumbnail')[0]).html('<i class="fa fa-check-circle"></i>');
        if(typeof response.url !== 'undefinfed' && typeof response.url !== '') {
            $($($('.uppy-thumbnail-container[data-id="'+file.id+'"').find('.uppy-thumbnail')[0]).find('img')[0]).attr('src', response.url);
        }
    });

    uppyDrag.on('upload-error', (file, error, response) => {
        console.log(error);
        console.log(response);
        $('.uppy-thumbnail-container[data-id="'+file.id+'"').removeClass('alert-warning');
        $('.uppy-thumbnail-container[data-id="'+file.id+'"').addClass('alert-danger');
        $($('.uppy-thumbnail-container[data-id="'+file.id+'"').find('.uppy-remove-thumbnail')[0]).html('<i class="fa fa-times-circle"></i>');
    });

    // $(document).on('click', id + ' .uppy-thumbnails .uppy-remove-thumbnail', function(){
    //     var imageId = $(this).attr('data-id');
    //     uppyDrag.removeFile(imageId);
    //     $(id + ' .uppy-thumbnail-container[data-id="'+imageId+'"').remove();
    // });

    $(document).on('change', '#upload_schema', function() {
        var value = $(this).val();
        uppyDrag.setMeta({'scheme_id' : value});
    });
    // init tooltips
    var initTooltip = function(el) {
        var theme = el.data('theme') ? 'tooltip-' + el.data('theme') : '';
        var width = el.data('width') == 'auto' ? 'tooltop-auto-width' : '';
        var trigger = el.data('trigger') ? el.data('trigger') : 'hover';

        $(el).tooltip({
            trigger: trigger,
            template: '<div class="tooltip ' + theme + ' ' + width + '" role="tooltip">\
                <div class="arrow"></div>\
                <div class="tooltip-inner"></div>\
            </div>'
        });
    }
    $('[data-toggle="tooltip"]').each(function() {
        initTooltip($(this));
    });

});