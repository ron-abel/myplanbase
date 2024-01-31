$(function () {
    "use strict";

    $(".preloader").fadeOut();
    // this is for close icon when navigation open in mobile view
    $(".nav-toggler").on("click", function () {
        $("#main-wrapper").toggleClass("show-sidebar");
        $(".nav-toggler i").toggleClass("ti-menu");
    });
    $(".search-box a, .search-box .app-search .srh-btn").on(
        "click",
        function () {
            $(".app-search").toggle(200);
            $(".app-search input").focus();
        }
    );

    // ==============================================================
    // Resize all elements
    // ==============================================================
    $("body, .page-wrapper").trigger("resize");
    $(".page-wrapper").delay(20).show();

    //****************************
    /* This is for the mini-sidebar if width is less then 1170*/
    //****************************
    var setsidebartype = function () {
        var width =
            window.innerWidth > 0 ? window.innerWidth : this.screen.width;
        if (width < 1170) {
            $("#main-wrapper").attr("data-sidebartype", "mini-sidebar");
        } else {
            $("#main-wrapper").attr("data-sidebartype", "full");
        }
    };
    $(window).ready(setsidebartype);
    $(window).on("resize", setsidebartype);

    $("#tenant_name").keypress(function () {
        var value = String.fromCharCode(event.which);
        var pattern = new RegExp(/^[a-z]+$/);
        return pattern.test(value);
    });

    $("body").on("click", "#delete_tenant", function () {
        if (confirm("Are you sure want to delete?")) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
            var route_url = $(this).attr("data-url");

            $.ajax({
                url: route_url,
                type: "POST",
                data: { _token: CSRF_TOKEN },
                dataType: "JSON",
                success: function (data) {
                    window.location.href = data.tenants_url;
                },
            });
        }
    });

    $("body").on("click", "#delete_template", function () {
        if (confirm("Are you sure want to delete?")) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
            var route_url = $(this).attr("data-url");

            $.ajax({
                url: route_url,
                type: "POST",
                data: { _token: CSRF_TOKEN },
                dataType: "JSON",
                success: function (data) {
                    window.location.href = data.template_url;
                },
            });
        }
    });

    $("body").on("click", "#delete_template_category", function () {
        if (confirm("Are you sure want to delete?")) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
            var route_url = $(this).attr("data-url");

            $.ajax({
                url: route_url,
                type: "POST",
                data: { _token: CSRF_TOKEN },
                dataType: "JSON",
                success: function (data) {
                    window.location.href = data.template_category_url;
                },
            });
        }
    });

    $(document).on("click", ".db-file-delete", function () {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
        var file_id = $(this).attr("data-target");
        Swal.fire({
            title: "Are you sure want to delete?",
            showDenyButton: true,
            confirmButtonText: "Yes",
            denyButtonText: "No",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "db_backup_delete",
                    type: "POST",
                    data: { _token: CSRF_TOKEN, file_id: file_id },
                    dataType: "JSON",
                    success: function (data) {
                        location.reload();
                    },
                });
            }
        });
    });

    $(document).on("click", ".db-file-create", function () {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
        Swal.fire({
            title: "Are you sure want to create a new backup?",
            showDenyButton: true,
            confirmButtonText: "Yes",
            denyButtonText: "No",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "db_backup_create",
                    type: "POST",
                    data: { _token: CSRF_TOKEN },
                    dataType: "JSON",
                    success: function (data) {
                        Swal.fire({
                            text: data.message,
                            icon: "success",
                        });
                    },
                });
            }
        });
    });

    $(document).on("change", "select[name='plan_type']", function () {
        let plan_type = $(this).val();
        if (plan_type == "default") {
            $(".tenant-div").addClass("d-none");
        } else {
            $(".tenant-div").removeClass("d-none");
        }
    });

    $("body").on("change", "select[name='primary_trigger']", async function () {
        let primary_trigger = $(this).val();
        let trigger_event_options =
            '<option value="">Select Trigger Event</option>';
        if (primary_trigger == "Project") {
            trigger_event_options +=
                '<option value="Created">Created</option>' +
                '<option value="PhaseChanged">Phase Changed</option>' +
                '<option value="AddedHashtag">Project Hashtag Added</option>' +
                '<option value="Created-PhaseChanged-AddedHashtag">Select All</option>';
        } else if (primary_trigger == "Contact") {
            trigger_event_options +=
                '<option value="Created">Created</option>' +
                '<option value="Updated">Updated</option>' +
                '<option value="Created-Updated">Select All</option>';
        } else if (primary_trigger == "Note") {
            trigger_event_options +=
                '<option value="Created">Created</option>' +
                '<option value="Completed">Completed</option>' +
                '<option value="TaskflowButtonTrigger">Taskflow Button Trigger</option>' +
                '<option value="Created-Completed-TaskflowButtonTrigger">Select All</option>';
        } else if (primary_trigger == "CollectionItem") {
            trigger_event_options =
                '<option value="Created">Created</option>' +
                '<option value="Deleted">Deleted</option>' +
                '<option value="Created-Deleted">Select All</option>';
        } else if (primary_trigger == "Appointment") {
            trigger_event_options +=
                '<option value="Created">Created</option>' +
                '<option value="Updated">Updated</option>' +
                '<option value="Deleted">Deleted</option>' +
                '<option value="Created-Updated-Deleted">Select All</option>';
        } else if (primary_trigger == "Section") {
            trigger_event_options +=
                '<option value="Visible">Visible</option>' +
                '<option value="Hidden">Hidden</option>' +
                '<option value="Visible-Hidden">Select All</option>';
        } else if (primary_trigger == "ProjectRelation") {
            trigger_event_options +=
                '<option value="Related">Related</option>' +
                '<option value="Unrelated">Unrelated</option>' +
                '<option value="Related-Unrelated">Select All</option>';
        } else if (
            primary_trigger == "TeamMessageReply" ||
            primary_trigger == "DocumentUploaded" ||
            primary_trigger == "FormSubmitted" ||
            primary_trigger == "SMSReceived"
        ) {
            trigger_event_options =
                '<option value="N/A">Trigger Event</option>';
        } else if (primary_trigger == "CalendarFeedback") {
            trigger_event_options =
                '<option value="Received">Received</option>';
        } else {
            trigger_event_options = '<option value="">Trigger Event</option>';
        }
        $("select[name='trigger_event']").html(trigger_event_options);
    });

    $(document).on("click", "a.remove-mapping-rule", function () {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
        var rule_id = $(this).attr("data-id");
        Swal.fire({
            title: "Are you sure want to delete?",
            showDenyButton: true,
            confirmButtonText: "Yes",
            denyButtonText: "No",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "automation_workflow_mapping_delete",
                    type: "POST",
                    data: { _token: CSRF_TOKEN, rule_id: rule_id },
                    dataType: "JSON",
                    success: function (data) {
                        location.reload();
                    },
                });
            }
        });
    });

    $("body").on("click", "a.edit-mapping-rule", async function () {
        let json_details = $(this).data("json");
        let mapping_ids = json_details.ids;
        let primary_trigger = json_details.primary_trigger;
        let trigger_event = json_details.trigger_event;
        let action_name = json_details.action_name;
        let action_short_code = json_details.action_short_code;

        $("input[name='mapping_ids']").val(mapping_ids);
        $("select[name='primary_trigger']").val(primary_trigger).change();
        $("select[name='trigger_event']").val(trigger_event);

        let action_short_codes = action_short_code.split(",");
        let action_names = action_name.split(",");

        let option_values = [];
        $.each(action_short_codes, function (i) {
            let option_value = action_short_codes[i] + "-" + action_names[i];
            option_values.push(option_value);
        });
        $("#kt_select2_3").select2().val(option_values).trigger("change");
    });

    $("body").on("click", "button.add-mapping-rule", async function () {
        $("input[name='mapping_ids']").val("");
        $("select[name='primary_trigger']").val("").change();
        $("select[name='trigger_event']").val("");
        $("#kt_select2_3").select2().val([]).trigger("change");
    });

    var BasicDatatablesDataSourceHtml = (function () {
        var superadminBasicDatatable = function () {
            var table = $("#superadmin_basic_datatable");
            table.DataTable({
                responsive: true,
                order: [[3, "desc"]],
                columnDefs: [{ width: 150, targets: 3 }],
            });
        };
        return {
            init: function () {
                superadminBasicDatatable();
            },
        };
    })();

    jQuery(document).ready(function () {
        BasicDatatablesDataSourceHtml.init();
    });
});

$(document).ready(function () {
    $(document).on("change", ".custom-file-input", function () {
        var fd = new FormData();
        var input = $(this);
        var files = input[0].files[0];
        fd.append("file", files);
        var div = input.parents(".custom-file");
       

        $.ajax({
            url: "/file",
            type: "post",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: fd,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response != 0) {
                    input.siblings("[type='hidden']").val(response);
                    input
                        .siblings(".custom-file-label")
                        .addClass("selected")
                        .html("File attached");
                    if (div.next("div[class='preview-image']").length)
                        div.siblings("div[class='preview-image']")
                            .find("img")
                            .attr("src", response);
                    else
                        div.after(
                            $(
                                `<div class="preview-image">
                                    <img class="img-thumbnail" src=${response}>
                                </div>
                                `
                            )
                        );
                    if (div.hasClass("logo-file")) {
                        var formGroup = div.parent();
                        formGroup.removeClass("col-12");
                        formGroup.addClass("col-11");
                        formGroup.after(`<div class='col-1'>
                            <button type='button' class='btn btn-sm btn-clean btn-icon logo-delete'><i class='icon-xl la la-trash-o'></i></button>
                        </div>`);
                    }
                } else {
                    alert("file not uploaded");
                }
            },
        });
    });
    $(document).on("change", ".custom-file-input-video", function () {
        var fd = new FormData();
        var input = $(this);
        var files = input[0].files[0];
        fd.append("file", files);
        var div = input.parents(".custom-file");
        
        $.ajax({
            url: "/file",
            type: "post",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: fd,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response != 0) {
                    input.siblings("[type='hidden']").val(response);
                    input
                        .siblings(".custom-file-label")
                        .addClass("selected")
                        .html("File attached");
                    if (div.next("div[class='preview-video']").length)
                            div.siblings("div[class='preview-video']")
                                .find("video")
                                .attr("src", response);
                    else
                        div.after(
                            $(
                                `<div class="preview-video" >
                                <video class="video-thumbnail" style="width:200px" controls>
                                        <source src=${response} type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                            </div>
                                `
                            )
                        );
                    if (div.hasClass("logo-file")) {
                        var formGroup = div.parent();
                        formGroup.removeClass("col-12");
                        formGroup.addClass("col-11");
                        formGroup.after(`<div class='col-1'>
                            <button type='button' class='btn btn-sm btn-clean btn-icon logo-delete'><i class='icon-xl la la-trash-o'></i></button>
                        </div>`);
                    }
                } else {
                    alert("file not uploaded");
                }
            },
        });
    });


    
    $("body").on("click", ".delete", function (event) {
        event.preventDefault();
        event.stopPropagation();

        var button = $(this);

        if (confirm("Are you sure?")) {
            var deleteForm = $("#delete-form");
            deleteForm.attr("action", button.attr("href"));
            deleteForm.submit();
        }
    });

    $("body").on("click", ".logout-btn", function (event) {
        event.preventDefault();
        event.stopPropagation();

        var button = $(this);
        var logoutForm = $("#logout-form");

        logoutForm.attr("action", button.attr("href"));

        logoutForm.submit();
    });

    $("body").on("click", ".open-more-modal", function (event) {
        var button = $(this);

        var name = button.data("name");
        var title = button.data("title");
        var description = button.data("description");

        var moreModal = $("#more-modal");

        moreModal.find(".modal-title").text(name);

        var content = `<h6>${title}</h6><br><p>${description}</p>`;
        moreModal.find(".modal-body").html(content);

        moreModal.modal();
    });

    
        
    
    $("body").on("click", ".select-item", function (event) {
        event.preventDefault();
        event.stopPropagation();

        var button = $(this);
        var form = $("#select-item-form");
        var statusInput = form.find("input[name='status']");

        form.attr("action", button.data("url"));

        statusInput.val(button.data("status"));

        form.submit();
    });
    $("body").on("click", ".add-more-image", function () {
        var button = $(this);
        var imageCnt = button.siblings("input[name='image_cnt']");
        var newImageNumber = parseInt(imageCnt.val()) + 1;

        imageCnt.val(newImageNumber);

        button.parent().before(
            $(`<div class="row align-items-start image-row" tabindex="${newImageNumber}">
        <div class="form-group col-md-6 col-sm-12">
            <label for="pic_name${newImageNumber}">Pic ${newImageNumber} Name :</label>
            <input id="pic_name${newImageNumber}" name="images[${newImageNumber}][pic_name]" class="form-control form-control-solid" placeholder="Enter picture ${newImageNumber} name">
        </div>
        <div class="form-group col-md-5 col-11">
            <label for="">&nbsp;</label>
            <div class="custom-file">
                <input type="hidden" name="images[${newImageNumber}][pic_url]">
                <input type="file" class="custom-file-input" id="customFile">
                <label class="custom-file-label" for="customFile">Drag picture here</label>
            </div>
        </div>
        <div class="form-group col-1">
            <button type="button" class="btn btn-sm btn-clean btn-icon image-delete"><i class="icon-xl la la-trash-o"></i></button>
        </div>
    </div>`)
        );
    });
    $("body").on("click", ".image-delete", function () {
        var button = $(this);
        var row = button.parents(".image-row");
        var form = button.parents("form");
        var afterSiblings = row.nextAll().filter(".image-row");

        row.remove();

        afterSiblings.each(function () {
            var afterEachRow = $(this);
            var rowCurrentIndex = parseInt(afterEachRow.attr("tabindex"));
            var picNameLabel = afterEachRow.find("label[for^='pic_name']");
            var picNameInput = afterEachRow.find("input[id^='pic_name']");
            var picUrlInput = afterEachRow.find("input[type='hidden']");

            afterEachRow.attr("tabindex", rowCurrentIndex - 1);
            picNameLabel.attr("for", `pic_name${rowCurrentIndex - 1}`);
            picNameLabel.text(`Pic ${rowCurrentIndex - 1} Name :`);
            picNameInput.attr("id", `pic_name${rowCurrentIndex - 1}`);
            picNameInput.attr(
                "name",
                `images[${rowCurrentIndex - 1}][pic_name]`
            );
            picNameInput.attr(
                "placeholder",
                `Enter picture ${rowCurrentIndex - 1} name`
            );
            picUrlInput.attr("name", `images[${rowCurrentIndex - 1}][pic_url]`);
        });

        var imageCnt = form.find("input[name='image_cnt']");
        imageCnt.val(imageCnt.val() - 1);
    });
    $("body").on("click", ".add-more-video", function () {
        var button = $(this);
        var videoCnt = button.siblings("input[name='video_cnt']");
        var newVideoNumber = parseInt(videoCnt.val()) + 1;
    
        videoCnt.val(newVideoNumber);
    
        button.parent().before(
            $(`<div class="row align-items-start video-row" tabindex="${newVideoNumber}">
                <div class="form-group col-md-6 col-sm-12">
                    <label for="vid_name${newVideoNumber}">${newVideoNumber == 1 ? "Key Video Name" : "Video" + newVideoNumber + " Name"} :</label>
                    <input id="vid_name${newVideoNumber}" name="media[${newVideoNumber}][vid_name]" class="form-control form-control-solid" placeholder="${newVideoNumber == 1 ? 'Enter key video name' : 'Enter video' + newVideoNumber + ' name'}">
                </div>
                <div class="form-group col-md-5 col-11">
                    <label for="">&nbsp;</label>
                    <div class="custom-file">
                        <input type="hidden" name="media[${newVideoNumber}][vid_url]">
                        <input type="file" accept="image/*,video/*" class="custom-file-input-video" id="customMedia${newVideoNumber}" name="customMedia${newVideoNumber}">
                        <label class="custom-file-label" for="customMedia${newVideoNumber}">Drag media here</label>
                    </div>
                    <div class="preview-media"></div>
                </div>
                ${newVideoNumber > 1 ? `<div class="form-group col-1">
                    <button type="button" class="btn btn-sm btn-clean btn-icon media-delete"><i class="icon-xl la la-trash-o"></i></button>
                </div>` : ''}
            </div>`)
        );
    });
    
    $("body").on("click", ".media-delete", function () {
        var button = $(this);
        var row = button.parents(".video-row");
        var form = button.parents("form");
        var afterSiblings = row.nextAll().filter(".video-row");
        row.remove();
    
        afterSiblings.each(function () {
            var afterEachRow = $(this);
            var rowCurrentIndex = parseInt(afterEachRow.attr("tabindex"));
            var mediaNameLabel = afterEachRow.find("label[for^='vid_name']");
            var mediaNameInput = afterEachRow.find("input[id^='vid_name']");
            var mediaUrlInput = afterEachRow.find("input[type='hidden']");
    
            afterEachRow.attr("tabindex", rowCurrentIndex - 1);
            mediaNameLabel.attr("for", `vid_name${rowCurrentIndex - 1}`);
            mediaNameLabel.text(`Media ${rowCurrentIndex - 1} Name :`);
            mediaNameInput.attr("id", `vid_name${rowCurrentIndex - 1}`);
            mediaNameInput.attr(
                "name",
                `media[${rowCurrentIndex - 1}][vid_name]`
            );
            mediaNameInput.attr(
                "placeholder",
                `Enter media ${rowCurrentIndex - 1} name`
            );
            mediaUrlInput.attr("name", `media[${rowCurrentIndex - 1}][vid_url]`);
        });
    
        var mediaCnt = form.find("input[name='media_cnt']");
        mediaCnt.val(mediaCnt.val() - 1);
    
        // Check if there are no more media rows, then hide the "Add Media" button
        if (mediaCnt.val() === "0") {
            form.find(".add-more-media").hide();
        }
    });
    
    

    $("body").on("click", ".logo-delete", function () {
        var button = $(this);
        var formGroup = button.parent().prev();

        formGroup.find("input[name='logo']").val("");
        formGroup.find("label").text("Drag Picture Here");
        formGroup.find(".preview-image").remove();
        button.remove();
        formGroup.removeClass("col-11");
        formGroup.addClass("col-12");
    });

    $("body").on("click", ".open-select-modal", function () {
        var button = $(this);
        var modal = $("#floor-plan-select-setting-modal");
        var form = modal.find("form");

        form.attr("action", button.data("url"));

        if (button.data("keepname") == "1")
            form.find("input[name='is_keep_same_name']:first").prop(
                "checked",
                true
            );
        if (button.data("keepname") == "0")
            form.find("input[name='is_keep_same_name']:eq(1)").prop(
                "checked",
                true
            );

        form.find("input[name='floor_plan_rename']").val(button.data("rename"));

        if (button.data("notdisplayprice") == "1")
            form.find("input[name='is_not_display_price']").prop(
                "checked",
                true
            );

        form.find("input[name='floor_plan_price']").val(button.data("price"));

        if (button.data("price") !== "")
            form.find("input[name='enter_price']").prop("checked", true);

        modal.find(".modal-title").text(button.data("title"));

        modal.modal();
    });

    $("#floor-plan-select-setting-modal").on("hidden.bs.modal", function (e) {
        var modal = $(this);

        var keepnameOn = modal.find("input[name='is_keep_same_name']:first");
        var keepnameOff = modal.find("input[name='is_keep_same_name']:eq(1)");
        var rename = modal.find("input[name='floor_plan_rename']");
        var notdisplayprice = modal.find("input[name='is_not_display_price']");
        var price = modal.find("input[name='floor_plan_price']");
        var enterprice = modal.find("input[name='enter_price']");

        keepnameOff.prop("checked", false);
        keepnameOff.removeClass("is-invalid");
        keepnameOn.prop("checked", false);
        keepnameOn.removeClass("is-invalid");
        rename.val("");
        rename.removeClass("is-invalid");
        notdisplayprice.prop("checked", false);
        notdisplayprice.removeClass("is-invalid");
        price.val("");
        price.removeClass("is-invalid");
        enterprice.prop("checked", false);
        enterprice.removeClass("is-invalid");
    });

    $("body").on("click", ".open-select-product-modal", function () {
        var button = $(this);
        var modal = $("#product-select-setting-modal");
        var form = modal.find("form");

        form.attr("action", button.data("url"));

        if (button.data("notdisplayprice") == "1")
            form.find("input[name='is_not_display_price']").prop(
                "checked",
                true
            );

        form.find("input[name='product_price']").val(button.data("price"));

        if (button.data("isenterprice") == "1")
            form.find("input[name='is_enter_price']").prop("checked", true);

        modal.find(".modal-title").text(button.data("title"));

        modal.modal();
    });

    $("#product-select-setting-modal").on("hidden.bs.modal", function (e) {
        var modal = $(this);

        var notdisplayprice = modal.find("input[name='is_not_display_price']");
        var price = modal.find("input[name='product_price']");
        var isEnterprice = modal.find("input[name='is_enter_price']");

        notdisplayprice.prop("checked", false);
        notdisplayprice.removeClass("is-invalid");
        price.val("");
        price.removeClass("is-invalid");
        isEnterprice.prop("checked", false);
        isEnterprice.removeClass("is-invalid");
    });

    $("body").on("click", ".select-product", function () {
        var button = $(this);
        var form = $("#product-form");
        form.find("input[name='product_id']").val(button.data("product-id"));

        form.submit();
    });

    $("body").on("keypress", ".customer-comment", function (event) {
        var input = $(this);

        if (event.keyCode != "13") return;

        var form = $("#product-form");

        var productId = form.find("input[name='product_id']");
        var color = form.find("input[name='color']");
        var comment = form.find("input[name='comment']");

        productId.val(input.data("product-id"));
        color.val(input.data("color"));
        comment.val(input.val());

        form.submit();
    });

    $("body").on("click", ".floorplan-image", function (event) {
        var image = $(this);
        var zoomModal = $("#floorplan-zoom-modal");

        zoomModal.find(".modal-title").text(image.data("alt"));
        zoomModal.find(".modal-body").html(
            `
            <div class="">
                <img src="${image.data("src")}" alt="${image.data("alt")}" style="width: 100% !important; height: auto !important; object-fit: cover;">
            </div>
            `
        );

        zoomModal.modal();
    });
    $("body").on("click", ".floorplan-video", function (event) {
        var image = $(this);
        var zoomModal = $("#floorplan-zoom-modal");

        zoomModal.find(".modal-title").text(image.data("alt"));
        zoomModal.find(".modal-body").html(
            `
            <div class="">
            <video style="width:100% !important; height: auto !important; object-fit: cover;"controls>
            <source src="${image.data("src")}">
            </video>
            </div>
            `
        );

        zoomModal.modal();
    });

    $("body").on("click", ".product-image", function (event) {
        var image = $(this);
        var imageTag = image.find("img");
        imageList = image.data('image-list');

        var singleImage = '';
        for(var i = 0; i < imageList.length; i++ ){
            singleImage += `<div class="swiper-slide"><img src="${image.data("image-list")[i]["pic_url"]}" alt="${image.data("alt")}"></div>`;
        }
        var zoomModal = $("#product-zoom-modal");

        zoomModal.find(".modal-title").text(image.data("name"));
        zoomModal.find(".modal-body").html(
            `<div class="item-large-image">
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    ${singleImage}
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
            </div>
                <p class="my-5">${image.data("description")}</p>
                <p class="opacity-75 hover-opacity-100">${image.data(
                    "additional-text"
                )}</p>`
        );
        var swiperModal = new Swiper(".mySwiper", {
            slidesPerView: 2,
            spaceBetween: 30,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
              },
        });

        zoomModal.modal();
    });

    // $("#color-modal").on("hidden.bs.modal", function (e) {
    //     var modal = $(this);

    //     var color = modal.find("input[name='color']");
    //     var productId = modal.find("input[name='product_id']");

    //     color.val("");
    //     productId.val("");
    // });

    $("body").on("click", ".paint-color-btn", function () {
        var modal = $("#color-list-modal");

        modal.modal();
    });
});

$(window).on("load", function () {
    var swiper = new Swiper(".mySwiper", {
        slidesPerView: 2,
        spaceBetween: 30,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
          },
    });
    if (window.showModal) {
        var floorplanSettingModal = $("#floor-plan-select-setting-modal");
        var productSettingModal = $("#product-select-setting-modal");

        if (floorplanSettingModal.length) floorplanSettingModal.modal("show");

        if (productSettingModal.length) productSettingModal.modal("show");
    }

    // if (window.showColorModal) {
    //     var colorModal = $("#color-modal");
    //     colorModal.modal("show");
    // }

    if (window.showColorListModal) {
        var colorModal = $("#color-list-modal");
        colorModal.modal("show");
    }
});


