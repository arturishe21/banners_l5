<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times; </button>
    @if(isset($info->id))
        <h4 class="modal-title" id="modal_form_label">{{__cms("Редактирование")}}</h4>
    @else
        <h4 class="modal-title" id="modal_form_label">{{__cms("Создание")}}</h4>
    @endif
</div>
<div class="modal-body">

    <form id="form_page" class="smart-form" enctype="multipart/form-data" method="post" novalidate="novalidate" >
        <fieldset style="padding:0">
            <div class="row">
                <section class="col col-6">
                    <label class="label">{{__cms("Название")}}</label>
                    <div>
                        <label class="input">
                            <input type="text" value="{{{ $info->title or "" }}}"  name="title"
                                   class="dblclick-edit-input form-control input-sm unselectable">
                            </input>
                        </label>
                    </div>
                </section>
                <section class="col col-6">
                    <label class="label">{{__cms("Баннерная площадка")}}</label>
                    <div>
                        <label class="select">
                            <select name="banners_area_id">
                                <option value="">{{__cms("Выбрать")}}</option>
                                @foreach($bannerarea as $k=>$el)
                                    <option value="{{$el->id}}" {{isset($info->id_banners_platform) && $info->id_banners_platform==$el->id?"selected":"" }}>{{$el->title}}</option>
                                @endforeach
                            </select>
                            <i></i>
                        </label>
                    </div>
                </section>
            </div>
            <div class="row">
                <section class="col" style="float: none">
                    <label class="label">{{__cms("Ссылка")}}</label>
                    <label class="input">
                        <input type="text" value="{{{ $info->link or "" }}}"  name="link"
                               class="dblclick-edit-input form-control input-sm unselectable">
                        </input>
                    </label>
                </section>
            </div>
            <div class="row">
                <section class="col" style="float: none">
                    <label class="label">{{__cms("Файл для показа")}}</label>
                    <div class="input input-file">
                        <span class="button"><input type="file" id="file" name="file" onchange="this.parentNode.nextSibling.value = this.value">{{__cms("Выбрать")}}</span>
                        <input type="text" placeholder="{{__cms("Выбрать файл (jpg, gif, png или swf)")}}" readonly="">
                    </div>
                    {{isset($info->path_file)?"<p class='banner_preview'><a href='".$info->path_file."' target='_blank'><img src='".$info->path_file."'></a></p>":""}}
                </section>
            </div>
            <div class="row">
                <section class="col" style="float: none">
                    <label class="toggle">
                        <input type="hidden" name="is_show_all" value="0">
                        <input type="checkbox" name="is_show_all" value="1" {{ isset($info->is_show_all) && $info->is_show_all==1?"checked":"" }}>
                        <i data-swchon-text="{{__cms("ДА")}}" data-swchoff-text="{{__cms("НЕТ")}}"></i>{{__cms("Показывать всегда")}}
                    </label>
                </section>
            </div>
            <div class="row" id="date_time_show" {{ isset($info->is_show_all) && $info->is_show_all==1?"style='display:none'":"" }}>
                <section class="col col-6">
                    <label class="label">{{__cms("Дата и время начала показа")}}</label>
                    <div class="col-sm-6 margin-right-5">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" name="show_start_data" style="padding-left: 5px" value="{{ isset($info->show_start)?$info->fetchData($info->show_start):"" }}" class="form-control datepicker" >
                                <span class="input-group-addon" style="margin-right: 20px"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <div class="input-group">
                                <input class="form-control clockpicker" name="show_start_time" style=" padding-left: 5px" type="text" value="{{ isset($info->show_start)?$info->fetchTime($info->show_start):"" }}" data-autoclose="true">
                                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="col col-6">
                    <label class="label">{{__cms("Дата и время окончания показа")}}</label>
                    <div class="col-sm-6 margin-right-5">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" name="show_finish_data" style="padding-left: 5px" value="{{ isset($info->show_finish)?$info->fetchData($info->show_finish):"" }}" class="form-control datepicker" >
                                <span class="input-group-addon" style="margin-right: 20px"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <div class="input-group">
                                <input class="form-control clockpicker"  name="show_finish_time" style=" padding-left: 5px" type="text" value="{{ isset($info->show_finish)?$info->fetchTime($info->show_finish):"" }}" data-autoclose="true">
                                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <div class="row">
                <section class="col col-6">
                    <label class="toggle">
                        <input type="hidden" name="status" value="0">
                        <input type="checkbox" name="status" value="1" {{ isset($info->is_show) && $info->is_show==1?"checked":"" }}>
                        <i data-swchon-text="{{__cms("ДА")}}" data-swchoff-text="{{__cms("НЕТ")}}"></i>{{__cms("Активный")}}
                    </label>
                </section>
            </div>
            <div class="row">
                <section class="col col-6">
                    <label class="toggle">
                        <input type="hidden" name="target_blank" value="0">
                        <input type="checkbox" name="target_blank" value="1" {{ isset($info->is_target_blank) && $info->is_target_blank==1?"checked":"" }}>
                        <i data-swchon-text="{{__cms("ДА")}}" data-swchoff-text="{{__cms("НЕТ")}}"></i>{{__cms("Открывать в новом окне")}}
                    </label>
                </section>
            </div>
        </fieldset>
        <div class="modal-footer">
            <button  type="submit" class="btn btn-success btn-sm"> <span class="glyphicon glyphicon-floppy-disk"></span> {{__cms("Сохранить")}} </button>
            <button type="button" class="btn btn-default" data-dismiss="modal"> {{__cms("Отмена")}} </button>
        </div>

        <input type="hidden" name="id" value="{{$info->id or "0"}}">
    </form>
</div>

<script>
    $("[name=is_show_all]").change(function(){
        if($(this).is(':checked')){
            $("#date_time_show").hide();
        }else{
            $("#date_time_show").show();
        }
    });

</script>
