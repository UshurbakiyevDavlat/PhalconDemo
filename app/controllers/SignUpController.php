<?php
declare(strict_types=1);

use Phalcon\Html\Escaper;
use Phalcon\Html\Helper\Form;
use Phalcon\Html\Helper\Input\Submit;

class SignUpController extends \Phalcon\Mvc\Controller
{

    public function indexAction()
    {
        $escaper = new Escaper();

        $formHelper = new Form($escaper);
        $submitHelper = new Submit($escaper);

        $formOptions = [
            'class' => 'signUp',
            'name' => 'signup',
            'id' => 'signUp',
            'action' => 'signup/register',
            'method' => 'post',
            'enctype' => 'multipart/form-data'
        ];

        $submitOptions = [
            'class' => 'submit',
            'name' => 'submit',
            'id' => 'submit',
        ];

        $this->view->setVar('form', $formHelper($formOptions));
        $this->view->setVar('submit', $submitHelper('register', 'register', $submitOptions));
    }

    public function registerAction()
    {
        $user = new Users();

        $data = $this->request->getPost();

        $user->name = $data['name'];
        $user->email = $data['email'];

        $success = $user->save();

        if (!$success) {
            echo 'Sorry, the following problems were generated:';
            foreach ($user->getMessages() as $message) {
                echo "<br/>" . $message->getMessage();
            }
            die();
        }

        echo 'Thanks for registration!';
        $this->view->disable();
    }

}

