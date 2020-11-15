<?php


namespace App\Controller;


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
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $db = PDOSingleton::getInstance()->getPDO();
            $manager = new UsersManager($db);

            $request = $manager->checkCredentials($_POST['email']);

            if($request['password'] === $_POST['password'])
            {
                $_SESSION['id'] = $request['id'];
                //$manager = new UsersManager();
                //$user = $manager->getUser($userId);
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