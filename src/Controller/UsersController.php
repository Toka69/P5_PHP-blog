<?php


namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class UsersController
 * @package App\Controller
 */
class UsersController extends BackofficeController
{
    /**
     * @return Response
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function backofficeAdminUsers(): Response
    {
        return $this->render("backofficeUsers.html.twig", [
            "usersList" => $this->usersManager->getList()
        ]);
    }

    /**
     * @return Response
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function editProfile(): Response
    {
        $id = $this->superGlobalObject->session["user"]->getId();
        $user = $this->usersManager->getUser($id);
        $errors = [];

        if($_SERVER ["REQUEST_METHOD"] == "POST")
        {
            if (!isset($this->superGlobalObject->post["email"]) || $this->superGlobalObject->post["email"] == "")
            {
                $errors["email"]= "Veuillez saisir votre email";
            }
            if (!isset($this->superGlobalObject->post["pseudo"]) || $this->superGlobalObject->post["pseudo"] == "")
            {
                $errors["pseudo"]= "Veuillez saisir votre pseudo";
            }
            if ($this->superGlobalObject->post["password"] !== $this->superGlobalObject->post["repeatPassword"]) {
                $errors["passwords"] = "Les mots de passe ne correspondent pas!";
            }
            if (count($errors) === 0)
            {
                $user->setFirstName($this->superGlobalObject->post["firstName"]);
                $user->setLastName($this->superGlobalObject->post["lastName"]);
                $user->setEmail($this->superGlobalObject->post["email"]);
                $user->setPseudo($this->superGlobalObject->post["pseudo"]);
                $user->setGenderId($this->superGlobalObject->post["genderId"]);
                if ($this->superGlobalObject->post["password"] != ""){$user->setPassword(password_hash($this->superGlobalObject->post['password'], PASSWORD_BCRYPT, ["cost" => 12]));}
                $this->usersManager->update($user);
                $this->superGlobalObject->session['user'] = $this->usersManager->getUser($id);

                return $this->redirect("backofficeProfile");
            }
        }

        return $this->render("profile.html.twig", [
            "user" => $user,
            "errors" => $errors,
            "genders" => $this->usersManager->getGenders(),
            "disabled" => null
        ]);
        }

    /**
     * @return Response
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function readProfile(): Response
    {
        return $this->render("profile.html.twig", [
            "user" => $this->superGlobalObject->session["user"],
            "genders" => $this->usersManager->getGenders(),
            "disabled" => "disabled"
        ]);
    }

    /**
     * @return Response
     */
    public function selectAdmin(): Response
    {
        if (isset($this->superGlobalObject->get["id"]) && preg_match("#^[0-9]+$#", $this->superGlobalObject->get["id"]) && $this->usersManager->getUser($this->superGlobalObject->get["id"]))
        {
            $user = $this->usersManager->getUser($this->superGlobalObject->get["id"]);
            $user->setAdmin(0);
            if (isset($this->superGlobalObject->get["setAdmin"]))
            {
                $user->setAdmin(1);
            }
            $this->usersManager->update($user);
        }

        return $this->redirect("backofficeAdminUsers");
    }

    /**
     * @return Response
     */
    public function validUser(): Response
    {
        if (isset($this->superGlobalObject->get["id"]) && preg_match("#^[0-9]+$#", $this->superGlobalObject->get["id"]) && $this->usersManager->getUser($this->superGlobalObject->get["id"]))
        {
            $user = $this->usersManager->getUser($this->superGlobalObject->get["id"]);
            $user->setValid(0);
            if (isset($this->superGlobalObject->get["valid"])) {
                $user->setValid(1);
            }
            $this->usersManager->update($user);
        }

        return $this->redirect("backofficeAdminUsers");
    }
}