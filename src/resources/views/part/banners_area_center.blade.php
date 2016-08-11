<script>
    $(".breadcrumb").html("<li><a href='/admin'>{{__cms('Главная')}}</a></li> <li>{{__cms($title)}}</li>");
    $("title").text("{{__cms($title)}} - {{{ __cms(Config::get('builder::admin.caption')) }}}");
</script>

<div>
    <div class="row" style="margin-left:0; margin-right:0">
        <div class="jarviswidget jarviswidget-color-blue " id="wid-id-4" data-widget-editbutton="false" data-widget-colorbutton="false">
            <header>
                <span class="widget-icon"> <i class="fa  fa-file-text"></i> </span>
                <h2> {{__cms($title)}} </h2>
            </header>
            <div class="table_center no-padding">

                <table class="table  table-hover table-bordered">
                    <thead>
                    <tr>
                        <th style="width: 25%">{{__cms('Название')}}</th>
                        <th style="width: 25%">{{__cms('Код для вставки')}}</th>
                        <th>{{__cms('Длина, px')}}</th>
                        <th>{{__cms('Высота, px')}}</th>
                        <th>{{__cms('Дата создания')}}</th>
                        <th style="width: 50px">
                            <a class="btn btn-sm btn-success" categor="0" onclick="BannersArea.getCreateForm(this);">
                                {{__cms('Создать')}}
                            </a>
                        </th>
                    </tr>
                    </thead>
                    <tbody >

                    @forelse($data as $k=>$el )
                        <tr class="tr_{{$el->id}} " id_page="{{$el->id}}">

                            <td style="text-align: left;">
                                <a onclick="BannersArea.doEdit({{$el->id}})">{{$el->title}}</a>
                            </td>
                            <td>Banner::show("{{$el->slug}}")</td>
                            <td>{{$el->width}}</td>
                            <td>{{$el->height}}</td>
                            <td>{{$el->created_at}}</td>
                            <td>
                                <div class="btn-group hidden-phone pull-right">
                                    <a class="btn dropdown-toggle btn-xs btn-default"  data-toggle="dropdown"><i class="fa fa-cog"></i> <i class="fa fa-caret-down"></i></a>
                                    <ul class="dropdown-menu pull-right" id_rec ="{{$el->id}}">
                                        <li>
                                            <a class="edit_record" onclick="BannersArea.doEdit({{$el->id}})"><i class="fa fa-pencil"></i> {{__cms('Редактировать')}}</a>
                                        </li>
                                        <li>
                                            <a onclick="BannersArea.doDeleteArea({{$el->id}});"><i class="fa red fa-times"></i> {{__cms("Удалить")}}</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5"  class="text-align-center">
                                {{__cms('Пусто')}}
                            </td>
                        </tr>
                    @endforelse


                    </tbody>
                </table>
                <div class="dt-toolbar-footer">
                    <div class="col-sm-4 col-xs-12 hidden-xs ">
                        <div id="dt_basic_info" class="dataTables_info" role="status" aria-live="polite">
                            {{__cms('Показано')}}
                            <span class="txt-color-darken listing_from">{{$data->firstItem()}}</span>
                            -
                            <span class="txt-color-darken listing_to">{{$data->lastItem()}}</span>
                            {{__cms('из')}}
                            <span class="text-primary listing_total">{{$data->total()}}</span>
                            {{__cms('записей')}}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-8">
                        <div id="dt_basic_paginate" class="dataTables_paginate paging_simple_numbers">
                            {{$data->links()}}
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

<div id="modal_wrapper">
    @include("banners::part.pop_area_add")
</div>

<script src="{{asset('packages/vis/banners/js/banners_area.js')}}"></script>