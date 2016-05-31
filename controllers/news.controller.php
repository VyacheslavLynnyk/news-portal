<?php
class NewsController extends Controller
{
    public function __construct(array $data = [])
    {
        parent::__construct($data);
        
    }

    public function index()
    {
        $news = News::find('all', ['limit' => 5]);
        $categories = Categories::find('all');
        foreach ($categories as $key => $category) {
            $categoriesArr[$category->id] = $category->name;
        }

        $this->data['news'] = $news;
        $this->data['categories'] = $categoriesArr;
        $this->data['images'] = Images::all(['limit' => 5, 'order' => 'id desc']);
        $this->data['image_count'] = count($this->data['images']);


    }

    public function read_article()
    {
        $params = App::getRouter()->getParams();
        if (!isset($params[0]) or (int)$params[0] != $params[0]) {
            Router::redirect('news/index');
        }

        $id = (int)$params[0];
        $news = News::find_by_id($id);
        $category = Categories::find_by_id($news->category_id);
        $images = Images::find_by_news_id($id); // Get only 1 image

        $this->data['news'] = $news;
        $this->data['category'] = $category;
        $this->data['images'] = (isset($images)) ? $images->path : null;
    }

    public function read_category()
    {

        // FOR ADMINs ONLY
        if (Auth::checkLoginActive() == false) {
            Session::setFlash('<a class="text-center" href="'.REL_URL. '/auth/index/' . '">Зарегестрируйтесь пожалуйста </a>');
            $this->index();
            return 'news/index';
            exit;
            //Router::redirect('auth/index');
        }

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


    //1




}