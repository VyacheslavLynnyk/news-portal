<?php
class Tags extends Model
{
    public static function getAllTags()
    {
        $tags_res = [];
        $all_tags = self::find('all');
        foreach ($all_tags as $tag) {
            $tags_res[$tag->id] = [$tag->tag_name];
        }
        return $tags_res;
    }
}