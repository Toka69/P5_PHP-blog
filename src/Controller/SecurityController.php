<?php


namespace App\Controller;


use App\Entity\User;
use Lib\Router\Router;
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
        if(isset($_SESSION['user'])) {return $this->redirect('backoffice');}

        $message = "";
        $alert = "";
        if(isset($_SESSION["message"]))
        {
            $message = $_SESSION["message"];
            $alert = $_SESSION["alert"];
            unset($_SESSION["message"]);
            unset($_SESSION["alert"]);
        }

        if($_SERVER["REQUEST_METHOD"] === "POST")
        {
            $errors = [];
            $user = null;
            $request = $this->usersManager->checkCredentials($_POST['email']);
            if ($request){$user = $this->usersManager->getUser($request['id']);}
            $authorize = $request && password_verify($_POST['password'], $request['password']);

            if (!$authorize)
            {
                $errors["message"]= "Erreur d'identifiants. Veuillez réessayer!";
                $errors["alert"] = "danger";
            }
            if ($user && $user->getValid() == 0)
            {
                $errors["message"]= "Votre compte a été désactivé. Veuillez contacter l'administrateur à l'adresse : ".$_ENV["MAIL_NOTIFICATION"]."";
                $errors["alert"] = "danger";
            }

            if (count($errors) === 0)
            {
                    $_SESSION["user"] = $user;
                    $router = new Router();
                    $_SESSION['ip'] = $router->ip();

                    return $this->redirect('backoffice');
            }

            $message = $errors["message"];
            $alert = $errors["alert"];
        }

        return $this->render("login.html.twig", [
            "message" => $message,
            "alert" => $alert
        ]);
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
        if (isset($_SESSION['user'])) {return $this->redirect('backoffice');}

        $errors =[];
        $message = "";
        $success = "";
        $value = [];

        if ($_SERVER["REQUEST_METHOD"] === "POST")
        {
            $checkCredentials = $this->usersManager->checkCredentials($_POST['email']);
            $checkPseudo = $this->usersManager->checkPseudo($_POST["pseudo"]);

            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $errors["email"] = "Le format de l'email est incorrect! Veuillez réessayer.";
            }
            if ($checkCredentials) {
                $errors["accountExist"] = "Ce compte utilisateur existe déjà! Veuillez réessayer.";
            }
            if (!preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$#", $_POST['password'])) {
                $errors["emailFormat"] = "Le mot de passe doit contenir entre 8 et 20 caractères, au moins 1 nombre, au moins une lettre, au moins une majuscule!";
            }
            if ($_POST["password"] !== $_POST["repeatPassword"]) {
                $errors["passwords"] = "Les mots de passe ne correspondent pas!";
            }
            if ($checkPseudo){
                $errors["pseudo"] = "Pseudo déjà prit! Veuillez en saisir un autre.";
            }

            if (count($errors) === 0) {
                $user = new User([
                    'firstName' => $_POST['firstName'],
                    'lastName' => $_POST['lastName'],
                    'pseudo' => $_POST['pseudo'],
                    'email' => $_POST['email'],
                    'password' => password_hash($_POST['password'], PASSWORD_BCRYPT, ["cost" => 12]),
                    'genderId' => $_POST['genderId']
                ]);
                $this->usersManager->add($user);
                $this->sendEmail($user->getEmail(), "Validez votre compte",
                    "Merci de vous être inscrit! Cliquez sur ce lien pour activer votre compte:
                    http://".$_SERVER['HTTP_HOST']."/valid-account?email=".$user->getEmail()."                 
                ");
                $message = "Le compte a bien été créé. Vous allez recevoir un email pour valider votre compte.";
                $success = true;
            }
            $value = [
                "firstName" => $_POST["firstName"],
                "lastName" => $_POST["lastName"],
                "pseudo" => $_POST["pseudo"],
                "genderId" => $_POST["genderId"],
                "email" => $_POST["email"],
                "password" => $_POST["password"],
                "repeatPassword" => $_POST["repeatPassword"]
            ];
        }

        return $this->render("register.html.twig", [
            "message" => $message,
            "success" => $success,
            "value" => $value,
            "errors" => $errors,
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
        if(isset($_SESSION['user'])) {return $this->redirect('backoffice');}

        if($_SERVER["REQUEST_METHOD"] === "POST")
        {
            $manager = new UsersManager();
            $request = $manager->checkCredentials($_POST['email']);
            if ($request) {
                $password = $this->generatePwd();
                $this->sendEmail($_POST['email'],'Nouveau mot de passe', 'Veuillez trouver ci-joint votre nouveau mot de passe '.$password.'');
                $password = password_hash($password, PASSWORD_BCRYPT, ["cost" => 12]);
                $user = $this->usersManager->getUser($request['id']);
                $user->setPassword($password);
                $this->usersManager->update($user);
            }

            return $this->render("forgot-password.html.twig", [
                "message" => "Vous allez recevoir un email!",
                "success" => true
            ]);
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

    public function generatePwd(): string
    {
        $charList1 = '0123456789';
        $charList2 = 'abcdefghijklmnopqrstuvwxyz';
        $charList3 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $password = '';

        $max1 = mb_strlen($charList1, '8bit') - 1;
        $max2 = mb_strlen($charList2, '8bit') - 1;
        $max3 = mb_strlen($charList3, '8bit') - 1;
        for ($i = 0; $i < 3; $i++)
        {
            $password .= $charList1[random_int(0, $max1)].$charList2[random_int(0, $max2)].$charList3[random_int(0, $max3)];
        }

        return $password;
    }

    public function validAccount(): Response
    {
        if (isset($_GET['email']) && $user = $this->usersManager->checkCredentials($_GET['email']))
        {
            $user = $this->usersManager->getUser($user['id']);
            if ($user->getValidByMail() == 0)
            {
                $user->setValidByMail(1);
                $user->setValid(1);
                $this->usersManager->update($user);
                $_SESSION['message'] = "Compte validé! Vous pouvez vous connecter.";
                $_SESSION['alert'] = "success";
            }
            else{
                $_SESSION['message'] = "Ce lien n'est plus valable.";
                $_SESSION['alert'] = "danger";
            }

            return $this->redirect("login");
        }

        return $this->errorResponse(400);
    }
}