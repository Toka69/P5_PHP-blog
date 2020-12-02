<?php


namespace App\Controller;


use App\Entity\User;
use App\Manager\UsersManager;
use Lib\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class SecurityController
 * @package App\Controller
 */
class SecurityController extends AbstractController
{
    /**
     * @return Response
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function login(): Response
    {
        if(isset($_SESSION['user'])) {
            return $this->redirect('backoffice');
        }
        if($_SERVER["REQUEST_METHOD"] === "POST")
        {
            $manager = new UsersManager();
            $secureRequestMethod = $this->secureRequestMethod($_POST);
            $request = $manager->checkCredentials($secureRequestMethod['email']);
            if ($request && password_verify($secureRequestMethod['password'], $request['password'])) {
                    $_SESSION['user'] = $manager->getUser($request['id']);
                    return $this->redirect('backoffice');
            }
            return $this->render("login.html.twig", [
                "message" => "Erreur d'identifiants. Veuillez réessayer!"
            ]);
        }

        return $this->render("login.html.twig");
    }

    /**
     * @return Response
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function register(): Response
    {
        if (isset($_SESSION['user'])) {
            return $this->redirect('backoffice');
        }
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $manager = new UsersManager();
            $secureRequestMethod = $this->secureRequestMethod($_POST);
            $checkCredentials = $manager->checkCredentials($secureRequestMethod['email']);
            $errors =[];

            if (!filter_var($secureRequestMethod['email'], FILTER_VALIDATE_EMAIL)) {
                $errors["email"] = "Le format de l'email est incorrect! Veuillez réessayer.";
            }

            if ($checkCredentials) {
                $errors["accountExist"] = "Ce compte utilisateur existe déjà! Veuillez réessayer.";
            }

            if (!preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$#", $secureRequestMethod['password'])) {
                $errors["emailFormat"] = "Le mot de passe doit contenir entre 8 et 20 caractères, au moins 1 nombre, au moins une lettre, au moins une majuscule!";
            }

            if ($secureRequestMethod['password'] !== $secureRequestMethod['repeatPassword']) {
                $errors["passwords"] = "Les mots de passe ne correspondent pas!";
            }

            if (count($errors) === 0) {
                $user = new User([
                    'firstName' => $secureRequestMethod['firstName'],
                    'lastName' => $secureRequestMethod['lastName'],
                    'email' => $secureRequestMethod['email'],
                    'password' => password_hash($secureRequestMethod['password'], PASSWORD_BCRYPT, ["cost" => 12]),
                    'genderId' => $secureRequestMethod['genderId']
                ]);
                $manager->add($user);

                return $this->render("register.html.twig", [
                    "message" => "Le compte a bien été créé. Vous pouvez vous connecter.",
                    "success" => true
                ]);
            }

            return $this->render("register.html.twig", [
                "errors" => $errors,
                "genders" => $this->usersManager->getGenders()
            ]);
        }

        return $this->render("register.html.twig", [
            "genders" => $this->usersManager->getGenders()
        ]);
    }

    /**
     * @return Response
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function forgotPassword(): Response
    {
        if(isset($_SESSION['user'])) {
            return $this->redirect('backoffice');
        }
        if($_SERVER["REQUEST_METHOD"] === "POST")
        {
            $manager = new UsersManager();
            $secureRequestMethod = $this->secureRequestMethod($_POST);
            $request = $manager->checkCredentials($secureRequestMethod['email']);
            if (!$request){
                return $this->render("forgot-password.html.twig", [
                    "message" => 'Ce compte email n\'existe pas! Veuillez réesayer.'
                ]);
            }
            else
            {
                //send an email
                return $this->render("forgot-password.html.twig", [
                    "message" => "Le mot de passe vient de vous être envoyé par email!",
                    "success" => true
                ]);
            }
        }
        return $this->render("forgot-password.html.twig");
    }

    /**
     * @return Response
     */
    public function logout(): Response
    {
        session_unset();
        return $this->redirect("login");
    }
}