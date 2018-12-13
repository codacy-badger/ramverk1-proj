<?php

namespace Anax\User\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Anax\Index\User;

/**
 * Form to create an item.
 */
class EdditForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di, $currUser)
    {
        parent::__construct($di);
        $this->form->create(
            [
                "id" => __CLASS__,
            ],
            [
                "username" => [
                    "type" => "text",
                    "class" => "form-control w-50",
                    "validation" => ["not_empty"],
                    "value" => $currUser->username,
                ],

                "email" => [
                    "type" => "email",
                    "class" => "form-control w-50",
                    "validation" => ["not_empty"],
                    "value" => $currUser->email,
                ],

                "id" => [
                    "type" => "hidden",
                    "validation" => ["not_empty"],
                    "readonly" => true,
                    "value" => $currUser->id,
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Ändra",
                    "callback" => [$this, "callbackSubmit"]
                ],
                "reset" => [
                    "type"      => "reset",
                ],
            ]
        );
    }



    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return bool true if okey, false if something went wrong.
     */
    public function callbackSubmit() : bool
    {
        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $user->find("id", $this->form->value("id"));

        $user->username = $this->form->value("username");
        $user->email = $this->form->value("email");

        try {
            $user->save();
            $db = $this->di->get("db");
            $db->connect();
            $currUser = $db->executeFetch("SELECT * FROM Users where username = ?", [$this->form->value("username")]);
            $this->di->get("session")->set("user", $currUser);

        return true;
        } catch (\Anax\Database\Exception\Exception $e) {
            return false;
        }
    }



    /**
     * Callback what to do if the form was successfully submitted, this
     * happen when the submit callback method returns true. This method
     * can/should be implemented by the subclass for a different behaviour.
     */
    public function callbackSuccess()
    {
        $this->di->get("response")->redirect("profile")->send();
    }



    // /**
    //  * Callback what to do if the form was unsuccessfully submitted, this
    //  * happen when the submit callback method returns false or if validation
    //  * fails. This method can/should be implemented by the subclass for a
    //  * different behaviour.
    //  */
    public function callbackFail()
    {
        //$this->form->rememberValues();
        $this->form->addOutput("Uppgifter har ej sparats, användarnamn eller email är redan taget.");
        $this->di->get("response")->redirectSelf()->send();
    }
}