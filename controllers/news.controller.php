<?php
class NewsController extends Controller
{
    public function __construct(array $data = [])
    {
        parent::__construct($data);
        
    }

    public function index()
    {
        $news = News::all(['order' => 'id desc']);
        $categories = Categories::find('all');

        // return array = [article_id, tag_name]
        $tagCombine = Tag_Combine::allTagNamed();
        foreach ($categories as $key => $category) {
            $categoriesArr[$category->id] = $category->name;
        }

        $this->data['news'] = $news;

        $this->data['categories'] = $categoriesArr;
        $this->data['tag_combine'] = $tagCombine;

        $this->data['images'] = Images::all(['limit' => 5, 'order' => 'id desc']);
        $this->data['image_count'] = count($this->data['images']);

        // add analytic_news data
        $this->read_analytic();

    }

    public function read_analytic()
    {
        $analytic_news = News::find_all_by_is_analytic('1');
        $this->data['analytic_news'] = $analytic_news;
    }

    public function read_article()
    {


        $params = App::getRouter()->getParams();
        if (!isset($params[0]) or (int)$params[0] != $params[0]) {
            Router::redirect('news/index');
        }

        $id = (int)$params[0];
        $news = News::find_by_id($id);
        if (isset($news->is_analytic) && $news->is_analytic == 1) {
            // FOR Authorized users ONLY
            if (Auth::checkLoginActive() == false) {
                Session::setFlash('<a class="text-center" href="'.REL_URL. '/auth/index/' . '">Зарегестрируйтесь пожалуйста </a>');
                $this->index();
                return 'news/index';
                exit;
                //Router::redirect('auth/index');
            }
        }
        $category = Categories::find_by_id($news->category_id);
        $images = Images::find_by_news_id($id); // Get only 1 image

        $this->data['news'] = $news;
        $this->data['category'] = $category;
        $this->data['images'] = (isset($images)) ? $images->path : null;
    }

    public function read_category()
    {

        $params = App::getRouter()->getParams();
        if (!isset($params[0]) or (int)$params[0] != $params[0]) {
            Router::redirect('news/index');
        }

        $id = (int)$params[0];
        $category = Categories::find_by_id($id);
        $news = News::find_all_by_category_id($category->id);
//        $images = Images::find_by_news_id($id); // Get only 1 image

        $this->data['news'] = $news;

        $this->data['category'] = $category->name;
//        $this->data['images'] = (isset($images)) ? $images->path : null;
    }

    public function search_by_tag_id()
    {
        $params = App::getRouter()->getParams();
        if (!isset($params[0]) or (int)$params[0] != $params[0]) {
            Router::redirect('news/index');
        }

        $tag_id = (int)$params[0];

        $tag_combine = Tag_Combine::find_all_by_tag_id($tag_id);
        $this->data['article'] = [];
        foreach ($tag_combine as $article_tag) {
            $this->data['news'][] = News::find_by_id($article_tag->article_id);
        }
        $this->data['tag_name'] = Tags::find_by_id($tag_id)->tag_name;

        $this->data['images'] = Images::all(['limit' => 5, 'order' => 'id desc']);
        $this->data['image_count'] = count($this->data['images']);
    }


}