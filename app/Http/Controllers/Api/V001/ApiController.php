<?php

namespace App\Http\Controllers\Api\V001;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\JsonResponseTrait;

class ApiController extends Controller
{
    use AuthorizesRequests, ValidatesRequests, JsonResponseTrait;

    /**
     * perPage value
     * @var integer
     */
    public $perPage;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->perPage = env('PAGINATION',10) ;
    }
    protected function perPage($request){
        return isset($request->per_page) && $request->per_page ? $request->per_page : $this->perPage ;
    }

    /**
     * Search in tables for index page
     * @param  object $query table's query
     * @param  array  $arr   search roles
     * @return query after search
     */
    public function searchIndex($query, array $arr)
    {
        foreach ($arr as $key => $value) {
            if (!empty($value[0]) || $value[0] == '0') {
                if ($value[1] == 'like') {
                    $query->where($key, $value[1], '%'. trim($value[0]) . '%');
                } elseif ($value[1] == 'date') {
                    $query->whereDate($key, '=', $value[0]);
                } elseif ($value[1] == 'between') {
                    if (!empty($value[0][0]) && !empty($value[0][1])) {
                        $query->whereBetween($key, [$value[0][0], $value[0][1]]);
                    }
                } elseif ($value[1] == 'in') {
                    $query->whereIn($key, $value[0]);
                } else {
                    $query->where($key, $value[1], $value[0]);
                }
            }
        }

        return $query;
    }

    /**
     * Validate Data and send errors messages as array
     * @param  Order $order
     * @return [type]           [description]
     */
    public function validateData($data, $rules)
    {
        $messages = null;
        //check the validator true or not
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            // Get Messages
            $messages = $validator->messages()->all();
        }

        return $messages;
    }

}
