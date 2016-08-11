<?php namespace Vis\Banners;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class BannerArea extends Eloquent
{

    use \Venturecraft\Revisionable\RevisionableTrait;

    protected $table = 'banners_platforms';

    public static $rules
        = array (
            'slug' => 'required|unique:banners_platforms,slug,',
            'title' => 'required',
            'width' => 'required|numeric|max:2000',
            'height' => 'required|numeric|max:2000',
        );
    protected $fillable = array ('title', 'slug', 'width', 'height');

    //get banner
    public function banners ()
    {

        $results = Cache::tags (array ('banners'))
            ->remember ('banners', 10, function () {

                $this_time = date ("Y-m-d G:i:00");
                $results = DB::select (
                    DB::raw ("SELECT banners.* FROM
                      banners

                       WHERE
                      id_banners_platform = '" . $this->id . "' and
                      path_file != '' and
                      is_show = 1 and
                        ((show_start < '$this_time' or show_finish> '$this_time') or show_finish = '0000-00-00 00:00:00' or is_show_all='1') ")
                );

                return $results;
            });

        shuffle ($results);

        if (isset($results[0])) {
            return $results[0];
        }

        return false;
    }

    /*
     * validation param for save
     *
     * @param array $data
     * @param integer $id
     *
     * @return boolen|json
     */
    public static function isNotValid (array $data, $id)
    {
        BannerArea::$rules['slug'] .= $id;

        $validator = Validator::make ($data, BannerArea::$rules);

        if ($validator->fails ()) {
            return Response::json (
                array (
                    'status' => 'error',
                    "errors_messages" => $validator->messages ()
                )
            );
        } else {
            return false;
        }
    }

}