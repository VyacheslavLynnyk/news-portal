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
                    $save_path = ROOT . '/webroot/images/articles/'.md5($newsModel->id);
                    if ($avatar = Images::catchFile('article-images', $save_path)) {
                        $avatar_ext = pathinfo($avatar, PATHINFO_EXTENSION);
                        $save_path .= '.' . $avatar_ext;
                        $save_url =  str_replace(ROOT.'/webroot', '', $save_path);
                        Images::setWidth(960);
                        Images::setHeight(480);
                        Images::crop_to_fit($avatar, $save_path);
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





    public function admin_save_test()
    {
        


    }

    public function admin_edit_test()
    {
        $params = App::getRouter()->getParams();
        if (sizeof($params) > 0) {
            $this->data['params'] = implode('/', $params);

            $testModel = Tests::find_by_id($params[0]);

            if (isset($_POST['test_name']) && $_POST['test_name'] != null) {
                $testModel->test = htmlspecialchars_decode(trim($_POST['test_name']));
                $testModel->save();
            }
            $this->data['test_name'] = $testModel->test;
            // Get all questions
            if (!isset($params[1])) {
                $this->data['questions'] = Questions::find_all_by_test_id($testModel->id);
            }
            if (isset($params[1]) && (int) $params[1] !== null) {
                if (isset($_POST['question']) && $_POST['question'] != null && $_POST['answer'][0] != null) {
                    $test_id = $params[0];
                    $question = htmlspecialchars_decode(trim($_POST['question']));
                    $question_id = $params[1];
                    $answers_true = (array) $_POST['answer_true'];
                    $answers = (array) $_POST['answer'];

                    $this->app_save_test($test_id, $answers, $answers_true, $question, $question_id);
                }

                $this->data['current_question'] = Questions::find_by_id($params[1]);
                $this->data['answers'] = Answers::find_all_by_question_id($params[1]);
            }
        } else {
            Router::redirect('manager/index');
        }

    }

    public function admin_delete_test()
    {
        $params = App::getRouter()->getParams();
        if (sizeof($params) == 1 ) {
            if (isset($params[0]) && is_numeric($params[0])) {
                $test = Tests::find_by_id($params[0]);
                $test->delete();
            }
        } elseif (sizeof($params) >= 2 ) {
            if (isset($params[0]) && is_numeric($params[0]) &&
                isset($params[1]) && is_numeric($params[1])) {
                //remove answers
                $answerModelArr = Answers::find_all_by_question_id($params[1]);
                foreach ($answerModelArr as $answerModel) {
                    $answerModel->delete();
                }
                //remove questions
                $question = Questions::find_by_id($params[1]);
                $question->delete();
            }
        }
        Router::redirect('manager/index');
    }

    public function admin_delete_language()
    {
        $params = App::getRouter()->getParams();
        if (sizeof($params) >= 1 ) {
            if (isset($params[0]) && is_numeric($params[0])
                && is_numeric($params[0]) && is_numeric($params[0])) {
                $language = Languages::find_by_id($params[0]);
                $language->delete();
            }
        }
        Router::redirect('manager/index');
    }


    /**
     * @param $test_id
     * @param $answers
     * @param $answers_true
     * @param $question
     * @param null $question_id
     * @return bool
     */
    protected function app_save_test($test_id, $answers, $answers_true, $question, $question_id = null)
    {
        if ($question_id != null) {
            $questionModel = Questions::find_by_id($question_id);
            //remove old answers
            $answerModelArr = Answers::find_all_by_question_id($question_id);
            foreach ($answerModelArr as $answerModel) {
                $answerModel->delete();
            }
        } else {
            $questionModel = new Questions();
        }

        $questionModel->question = $question;
        $questionModel->test_id = $test_id;
        $questionModel->save();

        foreach ( $answers as $key => $answer) {
            if ($answer == null) {
                continue;
            }
            $answerModel = new Answers();
            $answerModel->answer = htmlspecialchars_decode(trim($answer));
            $answerModel->is_true = (in_array($key, $answers_true)) ? $key : null;
            $answerModel->question_id = $questionModel->id;
            $answerModel->save();
        }
    }


    public function admin_edit_language()
    {
        $params = App::getRouter()->getParams();

        if (sizeof($params) > 0) {
            $this->data['params'] = implode('/', $params);

            $languageModel = Languages::find_by_id($params[0]);

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