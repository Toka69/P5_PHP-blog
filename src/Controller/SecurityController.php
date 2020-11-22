<?php


namespace App\Controller;


use App\Entity\User;
use App\Manager\UsersManager;
use Lib\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

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
            $manager = new UsersManager($this->PDOConnection());
            $securPost = $this->securPost($_POST);
            $request = $manager->checkCredentials($securPost['email']);
            if ($request && password_verify($securPost['password'], $request['password'])) {
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
        if(isset($_SESSION['user'])) {
            return $this->redirect('backoffice');
        }
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $manager = new UsersManager($this->PDOConnection());
            $securPost = $this->securPost($_POST);
            if (filter_var($securPost['email'], FILTER_VALIDATE_EMAIL)) {
                $request = $manager->checkCredentials($securPost['email']);
                if (!$request) {
                    if (preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$#", $securPost['password'])) {
                        if ($securPost['password'] === $securPost['repeatPassword']) {
                            $user = new User([
                                'firstName' => $securPost['firstName'],
                                'lastName' => $securPost['lastName'],
                                'email' => $securPost['email'],
                                'password' => password_hash($securPost['password'], PASSWORD_BCRYPT, ["cost" => 12]),
                                'genderId' => 4
                            ]);
                            $manager->add($user);

                            return $this->render("register.html.twig", [
                                "message" => "Le compte a bien été créé. Vous pouvez vous connecter.",
                                "success" => true
                            ]);
                        }

                        return $this->render("register.html.twig", [
                            "message" => "Les mots de passe ne correspondent pas!",
                        ]);
                    }

                    return $this->render("register.html.twig", [
                        "message" => "Le mot de passe doit contenir entre 8 et 20 caractères, au moins 1 nombre, au moins une lettre, au moins une majuscule!"
                    ]);
                }

                return $this->render("register.html.twig", [
                    "message" => "Ce compte utilisateur existe déjà! Veuillez réessayer."
                ]);
            }

            return $this->render("register.html.twig", [
                "message" => "Le format de l'email est incorrect! Veuillez réessayer."
            ]);
        }

        return $this->render("register.html.twig");
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
            $manager = new UsersManager($this->PDOConnection());
            $securPost = $this->securPost($_POST);
            $request = $manager->checkCredentials($securPost['email']);
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

    public function logout(): Response
    {
        session_unset();
        return $this->redirect("login");
    }
}