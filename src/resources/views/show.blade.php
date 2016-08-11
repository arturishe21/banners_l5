{{--if image--}}
@if(strpos($banners['path_file'],".jpg") || strpos($banners['path_file'],".jpeg") || strpos($banners['path_file'],".png") || strpos($banners['path_file'],".gif"))
    <a onclick="$.post('/banner_stat', {id:{{$banners['id']}} });" {{$target}} href='{{$banners['link']}}'
    ><img
                src='{{glide($banners['path_file'],['w'=>$area['width'], 'h'=>$area['height'], 'fit'=>'crop'])}}'
                width='{{$area['width']}}'
                height='{{$area['height']}}'
        ></a>
@else
    <a onclick="$.post('/banner_stat', {id:{{$banners['id']}} });" {{$target}} href='{{$banners['link']}}'
    ><img src='{{$banners['path_file']}}' width='{{$area['width']}}' height='{{$area['height']}}'
        ></a>
@endif
