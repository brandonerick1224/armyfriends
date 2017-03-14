<?php

namespace App\Models;

/**
 * App\Models\Media
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserTag[] $user_tags
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $model
 * @property-read mixed $type
 * @property-read mixed $type_from_extension
 * @property-read mixed $type_from_mime
 * @property-read mixed $extension
 * @property-read mixed $human_readable_size
 * @method static \Illuminate\Database\Query\Builder|\Spatie\MediaLibrary\Media ordered()
 * @mixin \Eloquent
 * @property integer $id
 * @property integer $model_id
 * @property string $model_type
 * @property string $collection_name
 * @property string $name
 * @property string $file_name
 * @property string $disk
 * @property integer $size
 * @property string $manipulations
 * @property string $custom_properties
 * @property integer $order_column
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Media whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Media whereModelId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Media whereModelType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Media whereCollectionName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Media whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Media whereFileName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Media whereDisk($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Media whereSize($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Media whereManipulations($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Media whereCustomProperties($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Media whereOrderColumn($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Media whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Media whereUpdatedAt($value)
 */
class Media extends \Spatie\MediaLibrary\Media
{
    /* ========================================================================= *\
     * Relations
    \* ========================================================================= */

    /**
     * Has many user tags
     */
    public function user_tags()
    {
        return $this->hasMany(UserTag::class);
    }


    /* ========================================================================= *\
     * Other
    \* ========================================================================= */


}
