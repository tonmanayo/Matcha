<?php
/**
 * Created by PhpStorm.
 * User: tmack
 * Date: 2016/11/12
 * Time: 3:49 PM
 */

namespace App\Controllers\Auth;

use App\Controllers\Controller;
use App\Models\User;
use Respect\Validation\Validator as v;

class ChatController extends Controller
{
    public function getChat($request, $response)
    {
        return $this->view->render($response, 'auth/chat.twig');

    }

    public function postChat($request, $response)
    {
        return $this->view->render($response, 'auth/chat.twig');

    }
}