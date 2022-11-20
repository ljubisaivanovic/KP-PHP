<?php

namespace App\Controllers;

use App\Core\Http\Controller;
use App\Core\RawSQL;
use App\Core\Utilities\EmailHelpers;
use App\Core\Validator;
use App\Models\User;
use App\Models\UserLog;

class AuthController extends Controller
{
    /**
     * @return void
     */
    public function register()
    {
        $form = $this->request->all();

        $model = new User();

        $users = $model->get('email', $form['email']);

        //check if user exists
        if (count($users) > 0) {
            echo json_encode([
                'success' => false,
                'error' => 'User with this email already exists!'
            ]);
            exit();
        }

        //validate email format
        if (!Validator::validateEmail($form['email'])) {
            echo json_encode([
                'success' => false,
                'error' => 'Wrong email format!'
            ]);
            exit();
        }

        //check suspicious emails and ip addresses
        if (!Validator::validateRiskScore(['email' => $form['email'], 'ip_address' => $_SERVER['REMOTE_ADDR']])) {
            echo json_encode([
                'success' => false,
                'error' => 'Your email or IP address is suspicious!'
            ]);
            exit();
        }

        //validate password
        if (!Validator::validatePassword($form['password']) && !Validator::validatePassword($form['password2'])) {
            echo json_encode([
                'success' => false,
                'error' => 'Password needs to be minimum 8 characters!'
            ]);
            exit();
        }

        //check if passwords match
        if ($form['password'] != $form['password2']) {
            echo json_encode([
                'success' => false,
                'error' => 'Passwords don\'t match!'
            ]);
            exit();
        }

        $model->email = $form['email'];
        $model->password = password_hash($form['password'], PASSWORD_BCRYPT);
        $model->posted = new RawSQL('NOW()');
        $model->insert();

        EmailHelpers::sendWelcomeEmail($model->email);

        $userLog = new UserLog();
        $userLog->user_id = $model->id;
        $userLog->action = 'register';
        $userLog->log_time = new RawSQL('NOW()');
        $userLog->insert();

        $this->auth->login($model);

        echo json_encode([
            'success' => true,
            'message' => 'Successfully registered the account!'
        ]);
        exit();
    }
}