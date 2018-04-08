<?php
/**
 * Created by PhpStorm.
 * User: Playe
 * Date: 04/04/2018
 * Time: 19:49
 */

namespace appliencheres\controlers;


use appliencheres\models\Utilisateur;

class ControleurSimplePage
{

    public function inscription()
    {
        $slim = \Slim\Slim::getInstance();
        include 'src/appliencheres/views/simplePage/inscription.php';
    }

    public function connexion()
    {
        $slim = \Slim\Slim::getInstance();
        include 'src/appliencheres/views/simplePage/connexion.php';
    }

    public function inscrireUtilisateur(){
        $slim = \Slim\Slim::getInstance();
        $pseudo = "";
        $mdp = "";
        $nom = "";
        $prenom = "";
        $mail = "";
        $adresse = "";
        $errors = [];

        if ($_POST['pseudo'] != '') {
            if ($_POST['pseudo'] == filter_var($_POST['pseudo'], FILTER_SANITIZE_STRING)) {
                $user = Utilisateur::where('pseudo', '=', $_POST['pseudo'])->first();
                if ($user != null) {
                    array_push($errors, "Le pseudo indiqué est déjà utilisé, veuillez en choisir un autre.");
                } else {
                    $pseudo = filter_var($_POST['pseudo'], FILTER_SANITIZE_STRING);
                }
            } else {
                array_push($errors, "Le pseudo indiqué est invalide, veuillez le modifier.");
            }
        } else {
            array_push($errors, "Veuillez indiquer votre pseudo.");
        }

        if ($_POST['mdp1'] != '' && $_POST['mdp2'] != '') {
            if ($_POST['mdp1'] === $_POST['mdp2']) {
                if ($_POST['mdp1'] == filter_var($_POST['mdp1'], FILTER_SANITIZE_STRING)) {
                    $mdp = filter_var($_POST['mdp1'], FILTER_SANITIZE_STRING);
                } else {
                    array_push($errors, "Le mot de passe indiqué est invalide, veuillez le changer.");
                }
            } else {
                array_push($errors, "Les mots de passe indiqués sont différents, veuillez les modifier.");
            }
        } else {
            array_push($errors, "Veuillez entrer un mot de passe.");
        }

        if ($_POST['nom'] != '') {
            if ($_POST['nom'] == filter_var($_POST['nom'], FILTER_SANITIZE_STRING)) {
                $nom = filter_var($_POST['nom'], FILTER_SANITIZE_STRING);
            } else {
                array_push($errors, "Le nom indiqué est invalide, veuillez le modifier.");
            }
        } else {
            array_push($errors, "Veuillez indiquer votre nom.");
        }

        if ($_POST['prenom'] != '') {
            if ($_POST['prenom'] == filter_var($_POST['prenom'], FILTER_SANITIZE_STRING)) {
                $prenom = filter_var($_POST['prenom'], FILTER_SANITIZE_STRING);
            } else {
                array_push($errors, "Le prénom indiqué est invalide, veuillez le modifier.");
            }
        } else {
            array_push($errors, "Veuillez indiquer votre prénom.");
        }

        if ($_POST['mail'] != '') {
            if (filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
                $mail = filter_var($_POST['mail'], FILTER_SANITIZE_EMAIL);
            } else {
                array_push($errors, "Le mail indiqué est invalide, veuillez le changer.");
            }
        } else {
            array_push($errors, "Veuillez entrer une adresse mail.");
        }

        if ($_POST['adresse'] != '') {
            if ($_POST['adresse'] == filter_var($_POST['adresse'], FILTER_SANITIZE_STRING)) {
                $adresse = filter_var($_POST['adresse'], FILTER_SANITIZE_STRING);
            } else {
                array_push($errors, "L'adresse indiquée est invalide, veuillez la modifier.");
            }
        } else {
            array_push($errors, "Veuillez indiquez votre adresse postale.");
        }

        if (sizeof($errors) == 0) {
            $mdp = password_hash($mdp, PASSWORD_DEFAULT, Array('cost' => 12));
            $u = new Utilisateur();
            $u->pseudo = $pseudo;
            $u->mdp = $mdp;
            $u->nom = $nom;
            $u->prenom = $prenom;
            $u->mail = $mail;
            $u->adresse = $adresse;
            $u->save();
            header('Location: ' . \Slim\Slim::getInstance()->urlFor('/'));
            $_SESSION['userConnected'] = $u;
            exit;
        } else {
            $_SESSION['errors'] = $errors;
            header('Location: ' . \Slim\Slim::getInstance()->urlFor('/simplePage/inscription'));
            exit;
        }
    }

    public function connecterUtilisateur(){
        $slim = \Slim\Slim::getInstance();

        $pseudo = "";
        $mdp = "";

        $errors = [];
        if ($_POST['pseudo'] != "") {
            if ($_POST['mdp'] != "") {
                if ($_POST['pseudo'] ==  filter_var($_POST['pseudo'], FILTER_SANITIZE_STRING)) {
                    if ($_POST['mdp'] == filter_var($_POST['mdp'], FILTER_SANITIZE_STRING)) {
                        $pseudo = filter_var($_POST['pseudo'], FILTER_SANITIZE_STRING);
                        $mdp = filter_var($_POST['mdp'], FILTER_SANITIZE_STRING);
                        $user = Utilisateur::where("pseudo", "=", $pseudo)->first();
                        if ($user != null) {
                            if (password_verify($mdp, $user->mdp)) {
                                $_SESSION['userConnected'] = $user;
                                header('Location: ' . \Slim\Slim::getInstance()->urlFor('/'));
                                exit;
                            } else {
                                array_push($errors, "Votre mot de passe est incorrect, veuillez réessayer.");
                            }
                        } else {
                            array_push($errors, "Votre compte n'existe pas, veuillez vous inscrire ou vérifier vos informations de connexion.");
                        }
                    } else {
                        array_push($errors, "Le mot de passe indiqué est invalide, veuillez le vérifier.");
                    }
                } else {
                    array_push($errors, "Le pseudo indiqué est invalide, veuillez le véfifier.");
                }
            } else {
                array_push($errors, "Veuillez indiquez votre mot de passe.");
            }
        } else {
            array_push($errors, "Veuillez indiquez votre pseudo.");
        }

        if (sizeof($errors) != 0) {
            $_SESSION['errors'] = $errors;
            header('Location: ' . \Slim\Slim::getInstance()->urlFor('/simplePage/connexion'));
            exit;
        }
    }

}