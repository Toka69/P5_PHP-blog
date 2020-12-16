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
        $id = $_SESSION["user"]->getId();
        $user = $this->usersManager->getUser($id);
        $errors = [];

        if($_SERVER ["REQUEST_METHOD"] == "POST")
        {
            if (!isset($_POST["email"]) || $_POST["email"] == "")
            {
                $errors["email"]= "Veuillez saisir votre email";
            }
            if (!isset($_POST["pseudo"]) || $_POST["pseudo"] == "")
            {
                $errors["pseudo"]= "Veuillez saisir votre pseudo";
            }
            if ($_POST["password"] !== $_POST["repeatPassword"]) {
                $errors["passwords"] = "Les mots de passe ne correspondent pas!";
            }
            if (count($errors) === 0)
            {
                $user->setFirstName($_POST["firstName"]);
                $user->setLastName($_POST["lastName"]);
                $user->setEmail($_POST["email"]);
                $user->setPseudo($_POST["pseudo"]);
                $user->setGenderId($_POST["genderId"]);
                if ($_POST["password"] != ""){$user->setPassword(password_hash($_POST['password'], PASSWORD_BCRYPT, ["cost" => 12]));}
                $this->usersManager->update($user);
                $_SESSION['user'] = $this->usersManager->getUser($id);

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
            "user" => $_SESSION["user"],
            "genders" => $this->usersManager->getGenders(),
            "disabled" => "disabled"
        ]);
    }

    /**
     * @return Response
     */
    public function selectAdmin(): Response
    {
        if (isset($_GET["id"]) && preg_match("#^[0-9]+$#", $_GET["id"]) && $this->usersManager->getUser($_GET["id"]))
        {
            $user = $this->usersManager->getUser($_GET["id"]);
            $user->setAdmin(0);
            if (isset($_GET["setAdmin"]))
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
        if (isset($_GET["id"]) && preg_match("#^[0-9]+$#", $_GET["id"]) && $this->usersManager->getUser($_GET["id"]))
        {
            $user = $this->usersManager->getUser($_GET["id"]);
            $user->setValid(0);
            if (isset($_GET["valid"])) {
                $user->setValid(1);
            }
            $this->usersManager->update($user);
        }

        return $this->redirect("backofficeAdminUsers");
    }
}