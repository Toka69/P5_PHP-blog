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
    public function backofficeUsers(): Response
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
        $secureRequestMethod = $this->secureRequestMethod($_POST);
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
                $user->setFirstName($secureRequestMethod["firstName"]);
                $user->setLastName($secureRequestMethod["lastName"]);
                $user->setEmail($secureRequestMethod["email"]);
                $user->setPseudo($secureRequestMethod["pseudo"]);
                $user->setGenderId($secureRequestMethod["genderId"]);
                if ($_POST["password"] != ""){$user->setPassword(password_hash($secureRequestMethod['password'], PASSWORD_BCRYPT, ["cost" => 12]),);}
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

        return $this->redirect("backofficeUsers");
    }

    /**
     * @return Response
     */
    public function validUser(): Response
    {
        if (isset($_GET["id"]) && preg_match("#^[0-9]+$#", $_GET["id"]) && $this->usersManager->getUser($_GET["id"]))
        {
            $secureRequestMethod = $this->secureRequestMethod($_GET);
            $user = $this->usersManager->getUser($secureRequestMethod["id"]);
            $user->setValid(0);
            if (isset($secureRequestMethod["valid"])) {
                $user->setValid(1);
            }
            $this->usersManager->update($user);
        }

        return $this->redirect("backofficeUsers");
    }
}