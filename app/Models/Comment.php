<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="Comment",
 *      required={""},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="commenter_id",
 *          description="commenter_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="restaurant_id",
 *          description="restaurant_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="title",
 *          description="title",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="content",
 *          description="content",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="created_at",
 *          description="created_at",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @SWG\Property(
 *          property="updated_at",
 *          description="updated_at",
 *          type="string",
 *          format="date-time"
 *      )
 * )
 */
class Comment extends Model
{
    use SoftDeletes;

    public $table = 'comments';

    protected $hidden = array('created_at', 'updated_at', 'deleted_at');
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'commenter_id',
        'restaurant_id',
        'title',
        'content'
    ];


    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'commenter_id' => 'integer',
        'restaurant_id' => 'integer',
        'title' => 'string',
        'content' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'commenter_id' => 'required|exists:users,id',
        'restaurant_id' => 'required|exists:restaurants,id',
        'title' => 'required|max:100',
        'content' => 'required'
    ];

    public function commenter() {
        return $this->belongsTo('App\User', 'commenter_id');
    }

}
