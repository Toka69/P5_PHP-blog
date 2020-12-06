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
        $errors =[];
        $message = "";
        $success = "";
        $value = [];

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $secureRequestMethod = $this->secureRequestMethod($_POST);
            $checkCredentials = $this->usersManager->checkCredentials($secureRequestMethod['email']);
            $checkPseudo = $this->usersManager->checkPseudo($secureRequestMethod["pseudo"]);

            if (!filter_var($secureRequestMethod['email'], FILTER_VALIDATE_EMAIL)) {
                $errors["email"] = "Le format de l'email est incorrect! Veuillez réessayer.";
            }
            if ($checkCredentials) {
                $errors["accountExist"] = "Ce compte utilisateur existe déjà! Veuillez réessayer.";
            }
            if (!preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$#", $secureRequestMethod['password'])) {
                $errors["emailFormat"] = "Le mot de passe doit contenir entre 8 et 20 caractères, au moins 1 nombre, au moins une lettre, au moins une majuscule!";
            }
            if ($secureRequestMethod["password"] !== $secureRequestMethod["repeatPassword"]) {
                $errors["passwords"] = "Les mots de passe ne correspondent pas!";
            }
            if ($checkPseudo){
                $errors["pseudo"] = "Pseudo déjà prit! Veuillez en saisir un autre.";
            }

            if (count($errors) === 0) {
                $user = new User([
                    'firstName' => $secureRequestMethod['firstName'],
                    'lastName' => $secureRequestMethod['lastName'],
                    'pseudo' => $secureRequestMethod['pseudo'],
                    'email' => $secureRequestMethod['email'],
                    'password' => password_hash($secureRequestMethod['password'], PASSWORD_BCRYPT, ["cost" => 12]),
                    'genderId' => $secureRequestMethod['genderId']
                ]);
                $this->usersManager->add($user);
                $message = "Le compte a bien été créé. Vous pouvez vous connecter.";
                $success = true;
            }
            $value = [
                "firstName" => $secureRequestMethod["firstName"],
                "lastName" => $secureRequestMethod["lastName"],
                "pseudo" => $secureRequestMethod["pseudo"],
                "genderId" => $secureRequestMethod["genderId"],
                "email" => $secureRequestMethod["email"],
                "password" => $secureRequestMethod["password"],
                "repeatPassword" => $secureRequestMethod["repeatPassword"]
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
        if(isset($_SESSION['user'])) {
            return $this->redirect('backoffice');
        }
        if($_SERVER["REQUEST_METHOD"] === "POST")
        {
            $manager = new UsersManager();
            $secureRequestMethod = $this->secureRequestMethod($_POST);
            $request = $manager->checkCredentials($secureRequestMethod['email']);
            if ($request) {
                $password = $this->generatePwd();
                $this->sendEmail($secureRequestMethod['email'],'Nouveau mot de passe', 'Veuillez trouver ci-joint votre nouveau mot de passe '.$password.'');
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

    public function generatePwd()
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
}