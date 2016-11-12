<?php
/**
 * Created by PhpStorm.
 * User: tmack
 * Date: 2016/11/11
 * Time: 9:40 AM
 */

namespace App\Controllers\Auth;

use App\Controllers\Controller;
use App\Models\User;
use Respect\Validation\Validator as v;

class ProfileController extends Controller
{
    public function getChangeProfile($request, $response)
    {
        return $this->view->render($response, 'auth/profile/change.twig');
    }

    public function postChangeProfile($request, $response)
    {
        $validation = $this->validator->validate($request, [
            'address' => v::notEmpty(),
            'age' => v::notEmpty()->age(18),
            'birthday' => v::date(),
            'country' => v::notEmpty(),
            'gender' => v::noWhitespace()->notEmpty(),
            'interests' => v::notEmpty(),
            'name' => v::noWhitespace()->notEmpty()->alpha(),
            'phone_number' => v::notEmpty()->phone(),
            'surname' => v::noWhitespace()->notEmpty()->alpha(),
            'work_education' => v::notEmpty()->alpha()
        ]);

        if ($validation->failed()) {
            $this->flash->addMessage('error', 'Profile Failed To Update!');
            return $response->withRedirect($this->router->pathFor('auth.profile.change'));
        }
        $this->auth->user()->updateProfile(
            $request->getParam('address'),
            $request->getParam('age'),
            $request->getParam('birthday'),
            $request->getParam('country'),
            $request->getParam('gender'),
            $request->getParam('interests'),
            $request->getParam('name'),
            $request->getParam('phone_number'),
            $request->getParam('surname'),
            $request->getParam('work_education')
        );
        $this->flash->addMessage('info', 'You have Succesfully updated your Profile');
        return $response->withRedirect($this->router->pathFor('home'));
    }
}