<?php


namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class UsersController extends BackofficeController
{
    /**
     * @return Response
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function backofficeUsers(): Response
    {
        if (!isset($_SESSION["user"])){return $this->redirect("login");}

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
    public function editUser(): Response
    {
        if (!isset($_SESSION["user"])){return $this->redirect("login");}
        $id = $_SESSION["user"]->getId();

        if($_SERVER ["REQUEST_METHOD"] == "POST")
        {
            $user = $this->usersManager->getUser($id);
            $errors = [];
            if (!isset($_POST["firstName"]) || $_POST["firstName"] == null)
            {
                $errors["firstName"]= "Veuillez saisir votre prénom";
            }
            if (!isset($_POST["lastName"]) || $_POST["lastName"] == null)
            {
                $errors["lastName"]= "Veuillez saisir votre nom";
            }
            if (!isset($_POST["email"]) || $_POST["email"] == null)
            {
                $errors["email"]= "Veuillez saisir votre email";
            }
            if (count($errors) === 0)
            {
                $user->setFirstName($_POST["firstName"]);
                $user->setLastName($_POST["lastName"]);
                $user->setEmail($_POST["email"]);
                $user->setPseudo($_POST["pseudo"]);
                $user->setGenderId($_POST["genderId"]);
                $this->usersManager->update($user);
                $_SESSION['user'] = $this->usersManager->getUser($id);

                return $this->redirect("profile");
            }

            return $this->render("profile.html.twig", [
                "user" => $user,
                "errors" => $errors,
                "genders" => $this->usersManager->getGenders(),
                "disabled" => null
            ]);
        }

        if (isset($_GET["edit"]))
        {
            return $this->render("profile.html.twig", [
                "user" => $this->usersManager->getUser($id),
                "genders" => $this->usersManager->getGenders(),
                "disabled" => null
            ]);
        }

        return $this->redirect("backofficeUsers");
    }

    /**
     * @return Response
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function readUser(): Response
    {
        if (!isset($_SESSION["user"])){return $this->redirect("login");}

        if (isset($_SESSION["user"]) && ($_SESSION["user"]) != null)
        {
            return $this->render("profile.html.twig", [
                "user" => $_SESSION["user"],
                "genders" => $this->usersManager->getGenders(),
                "disabled" => "disabled"
            ]);
        }

        return $this->redirect("backofficeUsers");
    }
}