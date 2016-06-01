<?php
class Tag_Combine extends Model
{
    static $table_name = 'tag_combine';

    public static function allTagNamed()
    {
        // Get all tags from table Tags (id, tag_name)
        $tags = Tags::getAlltags();
        $tagsArray = [];
        $tagCombine = self::find('all');
        foreach ($tagCombine as $tag) {
            $tagsArray[$tag->article_id][$tag->tag_id] = $tags[$tag->tag_id][0];
        }

        return $tagsArray;
    }

}