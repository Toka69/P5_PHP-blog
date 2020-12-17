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
        if(isset($this->superGlobalObject->session['user'])) {return $this->redirect('backoffice');}

        $message = "";
        $alert = "";
        if(isset($this->superGlobalObject->session["message"]))
        {
            $message = $this->superGlobalObject->session["message"];
            $alert = $this->superGlobalObject->session["alert"];
            unset($this->superGlobalObject->session["message"]);
            unset($this->superGlobalObject->session["alert"]);
        }

        if($_SERVER["REQUEST_METHOD"] === "POST")
        {
            $errors = [];
            $user = null;
            $request = $this->usersManager->checkCredentials($this->superGlobalObject->post['email']);
            if ($request){$user = $this->usersManager->getUser($request['id']);}
            $authorize = $request && password_verify($this->superGlobalObject->post['password'], $request['password']);

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
                    $this->superGlobalObject->session["user"] = $user;
                    $router = new Router();
                    $this->superGlobalObject->session['ip'] = $router->ip();

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
        if (isset($this->superGlobalObject->session['user'])) {return $this->redirect('backoffice');}

        $errors =[];
        $message = "";
        $success = "";
        $value = [];

        if ($_SERVER["REQUEST_METHOD"] === "POST")
        {
            $checkCredentials = $this->usersManager->checkCredentials($this->superGlobalObject->post['email']);
            $checkPseudo = $this->usersManager->checkPseudo($this->superGlobalObject->post["pseudo"]);

            if (!filter_var($this->superGlobalObject->post['email'], FILTER_VALIDATE_EMAIL)) {
                $errors["email"] = "Le format de l'email est incorrect! Veuillez réessayer.";
            }
            if ($checkCredentials) {
                $errors["accountExist"] = "Ce compte utilisateur existe déjà! Veuillez réessayer.";
            }
            if (!preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$#", $this->superGlobalObject->post['password'])) {
                $errors["emailFormat"] = "Le mot de passe doit contenir entre 8 et 20 caractères, au moins 1 nombre, au moins une lettre, au moins une majuscule!";
            }
            if ($this->superGlobalObject->post["password"] !== $this->superGlobalObject->post["repeatPassword"]) {
                $errors["passwords"] = "Les mots de passe ne correspondent pas!";
            }
            if ($checkPseudo){
                $errors["pseudo"] = "Pseudo déjà prit! Veuillez en saisir un autre.";
            }

            if (count($errors) === 0) {
                $user = new User([
                    'firstName' => $this->superGlobalObject->post['firstName'],
                    'lastName' => $this->superGlobalObject->post['lastName'],
                    'pseudo' => $this->superGlobalObject->post['pseudo'],
                    'email' => $this->superGlobalObject->post['email'],
                    'password' => password_hash($this->superGlobalObject->post['password'], PASSWORD_BCRYPT, ["cost" => 12]),
                    'genderId' => $this->superGlobalObject->post['genderId']
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
                "firstName" => $this->superGlobalObject->post["firstName"],
                "lastName" => $this->superGlobalObject->post["lastName"],
                "pseudo" => $this->superGlobalObject->post["pseudo"],
                "genderId" => $this->superGlobalObject->post["genderId"],
                "email" => $this->superGlobalObject->post["email"],
                "password" => $this->superGlobalObject->post["password"],
                "repeatPassword" => $this->superGlobalObject->post["repeatPassword"]
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
        if(isset($this->superGlobalObject->session['user'])) {return $this->redirect('backoffice');}

        if($_SERVER["REQUEST_METHOD"] === "POST")
        {
            $manager = new UsersManager();
            $request = $manager->checkCredentials($this->superGlobalObject->post['email']);
            if ($request) {
                $password = $this->generatePwd();
                $this->sendEmail($this->superGlobalObject->post['email'],'Nouveau mot de passe', 'Veuillez trouver ci-joint votre nouveau mot de passe '.$password.'');
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

    /**
     * @return string
     *
     * @throws \Exception
     */
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

    /**
     * @return Response
     */
    public function validAccount(): Response
    {
        if (isset($this->superGlobalObject->get['email']) && $user = $this->usersManager->checkCredentials($this->superGlobalObject->get['email']))
        {
            $user = $this->usersManager->getUser($user['id']);
            if ($user->getValidByMail() == 0)
            {
                $user->setValidByMail(1);
                $user->setValid(1);
                $this->usersManager->update($user);
                $this->superGlobalObject->session['message'] = "Compte validé! Vous pouvez vous connecter.";
                $this->superGlobalObject->session['alert'] = "success";
            }
            else{
                $this->superGlobalObject->session['message'] = "Ce lien n'est plus valable.";
                $this->superGlobalObject->session['alert'] = "danger";
            }

            return $this->redirect("login");
        }

        return $this->errorResponse(400);
    }
}