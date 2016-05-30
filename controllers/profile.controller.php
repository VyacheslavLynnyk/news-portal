<?php

class ProfileController extends Controller
{
    public function index()
    {
        $this->data['languages'] = Languages::find('all');
        $this->data['tests'] = Tests::find('all');

        $login = Auth::getLogin();
        $user = Users::find_by_login_mail($login);

        if (!isset($user)) {
            Router::redirect('auth/index');
            exit;
        }

        // Gets Post profile data
        if (isset($_POST['profile-save'])) {

            $user->full_name = htmlentities($_POST['full-name']);
            $user->phone = htmlentities($_POST['phone']);


            $id = $user->id;
            // Get crop and save our avatar image
            $save_path = ROOT . '/webroot/images/avatars/'.$id.str_replace('@','_', $login);
            if ($avatar = Image::catch('avatar', $save_path)) {
                $avatar_ext = pathinfo($avatar, PATHINFO_EXTENSION);
                $save_path .= rand(10, 50) . '.' . $avatar_ext;
                $save_url = REL_URL . str_replace(ROOT, '', $save_path);
                Image::crop_to_fit($avatar, $save_path, 400, 400);
                $user->photo_path = $save_url;
            }
            $user->save();
        }
        
        $this->data['full-name'] = $user->full_name;
        $this->data['phone'] = $user->phone;
        $this->data['avatar'] = $user->photo_path;
        $this->data['role'] = $user->role;

    }

    public function admin_index()
    {
        $this->index();
        return 'profile/index';
    }
    
}