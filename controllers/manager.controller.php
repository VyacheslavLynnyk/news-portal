<?php

class ManagerController extends Controller
{
    public function __construct(array $data = [])
    {
        parent::__construct($data);

        // FOR ADMINs ONLY
        if (Auth::checkLoginActive() == false) {
            Router::redirect('auth/index');
        }
        if (Auth::getRole() != 'admin') {
            throw new Exception('Error 404! Page not found.');
        }
        
        $this->data['super_data'] = ''; 
    }

    // Get data from DB to left panel

    public function index()
    {
        Router::redirect('manager/add-category');
    }

    // Add category and Article
    public function add_category()
    {
        // Save from POST to DB Category
        if (isset($_POST['save_article']) && $_POST['save_article'] == 'save') {

            if (($_POST['set_category'] == null && $_POST['add_category'] == null)) {
                Session::setFlash('Нужно заполнить поля');
                return 'manager/add_category';
                exit;
            }

            if ($_POST['add_category'] != null) {
                // Save into categorys
                $categoryModel = new Categories();
                $categoryModel->name = htmlspecialchars_decode(trim($_POST['add_category']));

                if ($categoryModel->save() == false) {
                    Session::setFlash('Ошибка при создании категории теста!');
                    return 'manager/add_category';
                    exit;
                }
            }

            // Save into News
            if (isset($_POST['article_name']) && $_POST['article_name'] != null) {
                $newsModel = new News();
                $newsModel->article = htmlspecialchars_decode(trim($_POST['article_name']));
                $newsModel->category_id = isset($categoryModel->id) ? $categoryModel->id : (int)$_POST['set_category'];
                $newsModel->tag_name = isset($_POST['tags']) ? htmlspecialchars_decode(trim($_POST['tags'])) : 'none';
                $newsModel->text = isset($_POST['text']) ? htmlspecialchars_decode(trim($_POST['text'])) : 'none';
                $newsModel->create = date('Y-M-D H:i:s');


                if ($newsModel->save() == false) {
                    Session::setFlash('Ошибка при создании теста!');
                } else {
                    // Get, crop and save out image
                    $save_path = ROOT . '/webroot/images/articles/'.md5($newsModel->category_id);
                    if ($avatar = Images::catchFile('article-images', $save_path)) {
                        $avatar_ext = pathinfo($avatar, PATHINFO_EXTENSION);
                        $save_path .= '.' . $avatar_ext;
                        $save_url =  str_replace(ROOT . '/webroot', '', $save_path);
                        Images::crop_to_fit($avatar, $save_path, 960, 600);
                        $image = new Images;

                        $image->path = $save_url;
                        $image->news_id = $newsModel->id;
                        $image->save();
                    }
                    Session::setFlash('Статья сохранена успешно!');
                }
            }
        }

        $this->data['categories'] = Categories::find('all');

    }


    public function edit_category()
    {
        $params = App::getRouter()->getParams();

        if (sizeof($params) > 0) {
            $this->data['params'] = implode('/', $params);

            $id = (int) $params[0];
            $languageModel = Categories::find_by_id($id);

            if (isset($_POST['language_name']) && $_POST['language_name'] != null) {
                $languageModel->language = htmlspecialchars_decode(trim($_POST['language_name']));
                $languageModel->save();
            }
            $this->data['language_name'] = $languageModel->language;
        }else {
        Router::redirect('manager/index');
    }

        $this->app_test_menu();
    }
}