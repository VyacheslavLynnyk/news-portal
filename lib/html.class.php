<?php
class Html
{
    public static function a_is_active($link, $link_name, $classes_array = [])
    {
        //Get relative link
        $link = trim(strtolower($link), '/');
        // Get last link name
        $menu_name = (explode('/', $link));
        $menu_name = (sizeof($menu_name) > 0) ? array_pop($menu_name) : $link;
        if (App::getRouter()->getController() == $menu_name) {
            $classes_array[] = 'active';
        }
        $classes = (isset($classes_array)) ? 'class="'.implode(' ', $classes_array).'"' : '';
        $html_a = '<a ' . $classes . ' href="' . REL_URL . '/' . $link . '/'.'" >' . $link_name . '</a>';
        return $html_a;
    }
}