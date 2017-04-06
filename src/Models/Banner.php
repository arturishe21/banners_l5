<?php namespace Vis\Banners;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class Banner extends Eloquent
{

    use \Venturecraft\Revisionable\RevisionableTrait;

    protected $revisionEnabled = true;
    protected $revisionCleanup = true;
    protected $historyLimit = 500;


    protected $table = 'banners';

    public static $rules
        = array (
            'file' => 'required|mimes:jpg,jpeg,gif,png,swf|max:5000',
            'link' => 'required',
            'id' => 'required|numeric',
            'title' => 'required',
            'banners_area_id' => 'required|numeric',
        );

    protected $fillable
        = array (
            'title',
            'link',
            'id_banners_platform',
            'is_show',
            'is_target_blank',
            'is_show_all',
            'show_start',
            'show_finish',
            'path_file'
        );

    public static function boot ()
    {
        parent::boot ();
    }

    /* show banner on site
    * @param string $slug
    *
    * @return html
    */
    public static function show ($slug)
    {
        if ($slug) {
            $area = Cache::tags (array ('banners'))
                ->remember ('bannerArea' . $slug, 10, function () use ($slug) {
                    $area = BannerArea::where ("slug", $slug)->first ();

                    return $area;
                });
            $banners = $area->banners ();

            if ($banners !== false) {
                $banners = (array) $banners;

                $banner = Cache::tags (array ('banners'))
                    ->remember ('banner_this' . $banners['id'], 10, function () use ($banners) {
                        $banner = Banner::find ($banners['id']);

                        return $banner;
                    });

                $banner->increment ("hit_count");
                $target = $banners['is_target_blank'] ? "target='_blank'" : "";

                return View::make ('banners::show',
                    compact ("target", "banners", "area"));
            }
        }
    }

    /*
     * get date with datetime
     * @param array $data
     *
     * @return string
     */
    public static function fetchData ($data)
    {
        if ($data) {
            $arr_data = explode (" ", $data);

            return $arr_data[0];
        }
    } //end fetchData

    /*
     * get time with datetime
     * @param array $data
     *
     * @return string
     */
    public static function fetchTime ($data)
    {
        if ($data) {
            $arr_data = explode (" ", $data);

            return $arr_data[1];
        }
    } //end fetchData

    /*
     * get this area
     *
     * @return object BannerArea
     */
    public function area ()
    {
        return BannerArea::find ($this->id_banners_platform);
    } // end area

    /*
     * validation param for save
     *
     * @param array $data
     *
     * @return boolen|json
     */
    public static function isNotValid (array $data)
    {
        $bannerFile = Input::file ('file');

        if ($bannerFile) {
            $data['file'] = $bannerFile;
        } else {
            Banner::$rules['file'] = "";
        }

        $validator = Validator::make ($data, Banner::$rules);

        if ($validator->fails ()) {
            return Response::json (
                array (
                    "status" => "error",
                    "errors_messages" => $validator->messages ()
                )
            );
        } else {
            return false;
        }
    }

    /*
     * upload file if exists
     *
     * @return boolen|string
     */
    public static function uploadFile ()
    {
        $bannerFile = Input::file ('file');

        if ($bannerFile) {
            $destinationPath = "storage/banner";
            $ext = $bannerFile->getClientOriginalExtension ();
            $hashName = md5 (time ()) . '.' . $ext;
            $fullPathImg = "/" . $destinationPath . '/' . $hashName;
            $bannerFile->move ($destinationPath, $hashName);

            return $fullPathImg;
        } else {
            return false;
        }
    }

    /*
     * replace params before saving
     * @param array $data
     *
     * @return array
     */
    public static function replaceParams (array $data)
    {
        $data['id_banners_platform'] = $data['banners_area_id'];
        $data['is_show'] = $data['status'];
        $data['is_target_blank'] = $data['target_blank'];
        $data['show_start'] = str_replace (".", ":", $data['show_start_data'])
            . " " . $data['show_start_time'];
        $data['show_finish'] = str_replace (".", ":", $data['show_finish_data'])
            . " " . $data['show_finish_time'];

        return $data;
    }

    /*
     * clear cache tag banner
     *
     * @return void
     */
    public static function flush ()
    {
        Cache::tags ('banners')->flush ();
    }
}
