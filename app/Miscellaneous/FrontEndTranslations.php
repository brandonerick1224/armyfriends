<?php

namespace App\Miscellaneous;

class FrontEndTranslations
{
    protected static $keys = [
        'comments.add-comment',
        'comments.load-more-comments',
        'common.edit',
        'comments.cancel-edit',
        'common.delete',
    ];

    /**
     * Get all needed translations for frontend
     *
     * @return string
     */
    public static function json()
    {
        $data = [];
        foreach (self::$keys as $key) {
            $data[$key] = trans($key);
        }

        return json_encode($data);
    }
}
