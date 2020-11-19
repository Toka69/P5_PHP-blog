<?php


namespace App\Controller;


use App\Entity\User;
use App\Manager\UsersManager;
use Lib\AbstractController;
use Lib\PDOSingleton;
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
        if($_SERVER["REQUEST_METHOD"] === "POST")
        {
            $db = PDOSingleton::getInstance()->getPDO();
            $manager = new UsersManager($db);

            $request = $manager->checkCredentials($_POST['email']);
            if(password_verify($_POST['password'], $request['password']))
            {
                $_SESSION['id'] = $request['id'];
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
        if($_SERVER["REQUEST_METHOD"] === "POST")
        {
            $manager = new UsersManager(self::PDOConnection());

            $request = $manager->checkCredentials($_POST['email']);
            if (!$request){
                if($_POST['password'] === $_POST['repeatPassword'])
                {
                    $user = new User([
                        'firstName' => $_POST['firstName'],
                        'lastName' => $_POST['lastName'],
                        'email' => $_POST['email'],
                        'password' => $password = password_hash($_POST['password'], PASSWORD_BCRYPT, ["cost" => 12]),
                        ]);
                    $manager->add($user);

                    return $this->redirect('backoffice');
                }
                return $this->render("register.html.twig", [
                    "message" => "Les mots de passe ne correspondent pas!"
                ]);
            }

            return $this->render("register.html.twig", [
                "message" => "Ce compte utilisateur existe déjà! Veuillez réessayer."
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
        return $this->render("forgot-password.html.twig");
    }
}