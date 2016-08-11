"use strict";

var BannersArea =
{

    init: function () {
        BannersArea.handleSaveBannersArea();
        BannersArea.handleStartLoad();
    },

    preloadPage: function () {
        var preloadHtml = '<div id="table-preloader" class="text-align-center"><i class="fa fa-gear fa-4x fa-spin"></i></div>';
        $("#modal_form .modal-content").html(preloadHtml);
    }, // end preloadPage

    handleSaveBannersArea: function () {

        var $checkoutForm = $('#form_page').validate({

            rules: {
                title: {
                    required: true
                },
                width: {
                    required: true
                },
                height: {
                    required: true
                }
            },

            // Messages for form validation
            messages: {
                title: {
                    required: 'Нужно заполнить название'
                },
                width: {
                    required: 'Нужно заполнить длину '
                },
                height: {
                    required: 'Нужно заполнить высоту '
                }


            },
            // Do not change code below
            errorPlacement: function (error, element) {
                error.insertAfter(element.parent());
            },
            submitHandler: function (form) {
                BannersArea.doSaveBannersArea();
            }
        });
    }, //handleSaveBannersArea


    handleStartLoad: function () {
        var idPage = Core.urlParam('id');
        if ($.isNumeric(idPage)) {
            BannersArea.doEdit(idPage);
        }
    }, // end handleStartLoad

    //показать форму добавления
    getCreateForm: function () {
        $("#modal_form").modal('show');
        BannersArea.preloadPage();
        $.post("/admin/banners/area/create_pop", {},
            function (data) {
                $("#modal_form .modal-content").html(data);
                BannersArea.handleSaveBannersArea();
            });
    }, //end getCreateForm

    //редактирование
    doEdit: function (idPages) {
        $("#modal_form").modal('show');
        BannersArea.preloadPage();

        var urlPage = "?id=" + idPages;
        window.history.pushState(urlPage, '', urlPage);

        $.post("/admin/banners/area/edit_record", {id: idPages},
            function (data) {
                $("#modal_form .modal-content").html(data);
                BannersArea.handleSaveBannersArea();
            });
    }, //end doEdit

    //сохранение площадки
    doSaveBannersArea: function () {
        $.post("/admin/banners/area/add_record", {data: $('#form_page').serialize()},
            function (data) {
                if (data.status == "ok") {

                    jQuery.smallBox({
                        title: data.ok_messages,
                        content: "",
                        color: "#659265",
                        iconSmall: "fa fa-check fa-2x fadeInRight animated",
                        timeout: 4000
                    });

                    $("#modal_form").modal('hide');
                    BannersArea.showlist(1);
                } else {

                    var mess_error = ""
                    $.each(data.errors_messages, function (key, value) {
                        mess_error += value + "<br>";
                    });

                    jQuery.smallBox({
                        title: mess_error,
                        content: "",
                        color: "#C46A69",
                        iconSmall: "fa fa-times fa-2x fadeInRight animated",
                        timeout: 4000
                    });
                }
            }, "json");


    }, // end doSaveBannersArea

    showlist: function () {
        doAjaxLoadContent(window.location.href);
        $(".modal-backdrop").remove();
    }, //end showlist

    doDeleteArea: function (id) {
        jQuery.SmartMessageBox({
            title: "Удалить?",
            content: "Эту операцию нельзя будет отменить.",
            buttons: '[Нет][Да]'
        }, function (ButtonPressed) {
            if (ButtonPressed === "Да") {
                jQuery.ajax({
                    type: "POST",
                    url: "area/delete",
                    data: {id: id},
                    dataType: 'json',
                    success: function (response) {
                        if (response.status) {
                            jQuery.smallBox({
                                title: "Запись удалена успешно",
                                content: "",
                                color: "#659265",
                                iconSmall: "fa fa-check fa-2x fadeInRight animated",
                                timeout: 4000
                            });

                            $(".tr_" + id).remove();
                        } else {
                            jQuery.smallBox({
                                title: "Что-то пошло не так, попробуйте позже",
                                content: "",
                                color: "#C46A69",
                                iconSmall: "fa fa-times fa-2x fadeInRight animated",
                                timeout: 4000
                            });
                        }
                    }
                });

            }

        });
    }
};

jQuery(document).ready(function () {
    BannersArea.init();
});

