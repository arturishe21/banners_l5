"use strict";

var Banners =
{
    init: function () {
        Banners.handleStartLoad();
        Banners.handlePopupLoad();
    },

    handleStartLoad: function () {
        var idPage = Core.urlParam('id_banner');
        if ($.isNumeric(idPage)) {
            Banners.doEdit(idPage);
        }
    }, // end handleStartLoad

    handlePopupLoad: function () {
        $('.datepicker').datepicker({dateFormat: 'yy-mm-dd'});
        $('.clockpicker').clockpicker({
            placement: 'top',
            donetext: 'Done'
        });

        var $checkoutForm = $('#form_page').validate({
            rules: {
                title: {
                    required: true
                },
                banners_area_id: {
                    required: true
                },
                link: {
                    required: true
                },
            },
            messages: {
                title: {
                    required: 'Нужно заполнить название'
                },
                banners_area_id: {
                    required: 'Нужно выбрать баннерную площадку'
                },
                link: {
                    required: 'Нужно заполнить'
                },
            },
            errorPlacement: function (error, element) {
                error.insertAfter(element.parent());
            },
            submitHandler: function (form) {
                Banners.doSaveBanner();
            }
        });
    }, // end handlePopupLoad

    getCreateForm: function () {
        $("#modal_form").modal('show');
        Banners.preloadPage();
        $.post("/admin/banners/banner/create_pop", {},
            function (data) {
                $("#modal_form .modal-content").html(data);
                Banners.handlePopupLoad();
            });
    }, // end getCreateForm

    showList: function () {
        doAjaxLoadContent(window.location.href);
        $(".modal-backdrop").remove();
        /*var  urlPage = '';
         $.ajax({
         url : urlPage,
         dataType: 'html'
         }).done(function (data) {
         $('.table_center').html(data);
         }).fail(function () {

         TableBuilder.showErrorNotification("Что-то пошло не так, попробуйте позже");

         });*/
    }, //end showList

    doSaveBanner: function () {
        var file_data = $("#modal_form [name=file]").prop("files")[0];
        var form_data = new FormData();
        form_data.append("file", file_data)
        form_data.append("data", $('#form_page').serialize());
        $(".picture_main_show").html("<p>Загрузка..</p>");

        $.ajax({
            url: "/admin/banners/banner/add_record",
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function (response) {
                if (response.status == "ok") {

                    TableBuilder.showSuccessNotification(response.ok_messages);
                    Banners.showList(1);

                    if ($('#form_page [name=id]').val() == 0) {
                        $("#modal_form").modal('hide');
                    }

                } else {

                    var mess_error = ""
                    $.each(response.errors_messages, function (key, value) {
                        mess_error += value + "<br>";
                    });
                    TableBuilder.showErrorNotification(mess_error);

                }
            }
        });
    }, // end doSaveBanner

    doEdit: function (idPages) {
        $("#modal_form").modal('show');
        Banners.preloadPage();

        var urlPage = "?id_banner=" + idPages;
        window.history.pushState(urlPage, '', urlPage);

        $.post("/admin/banners/banner/edit_record", {id: idPages},
            function (data) {
                $("#modal_form .modal-content").html(data);
                Banners.handlePopupLoad();
            });
    }, // end doEdit

    preloadPage: function () {
        var preloadHtml = '<div id="table-preloader" class="text-align-center"><i class="fa fa-gear fa-4x fa-spin"></i></div>';
        $("#modal_form .modal-content").html(preloadHtml);
    }, // end preloadPage

    doDeleteBanner: function (id, context) {
        jQuery.SmartMessageBox({
            title: "Удалить?",
            content: "Эту операцию нельзя будет отменить.",
            buttons: '[Нет][Да]'
        }, function (ButtonPressed) {
            if (ButtonPressed === "Да") {
                jQuery.ajax({
                    type: "POST",
                    url: "banner/delete",
                    data: {id: id},
                    dataType: 'json',
                    success: function (response) {
                        if (response.status) {

                            TableBuilder.showSuccessNotification("Запись удалена успешно");

                            $(".tr_" + id).remove();
                        } else {

                            TableBuilder.showErrorNotification("Что-то пошло не так, попробуйте позже");

                        }
                    }
                });

            }

        });
    } // end doDeleteBan
};

jQuery(document).ready(function () {
    Banners.init();
    $(document).on('click', '#modal_form .close, .modal-footer button', function (e) {
        var url = Core.delPrm("id_banner");
        window.history.pushState(url, '', url);
    });
});
