<?php
    /**
     * Example of a simple controller
     * It will call the model to get the data
     * and then decide which view to display (login form or welcome page)
     *
     * @author: w.delamare
     * @date: Dec. 2023jdjdjd
     */
 
   
    // do all necessary includes first
    // __DIR__ allows you to use relative paths explicitly
    require_once(__DIR__."./model/php/UserModel.php");
 
 
 
    // Check if the user comes from the form...
    if (isset($_POST['login']) && isset($_POST['mot_de_passe'])) {
 
        // check if all fields have an input
        if (strlen($_POST['login']) > 0 && strlen($_POST['mot_de_passe']) > 0) {
            $userModel = new UserModel();
            // Call the model to check if the user exists
            // How is the information stored? In a database? In a file? In a cloud? In a cookie?
            // The controller does not care about that. It just calls the model.
            $result = $userModel->check_login($_POST['login'], $_POST['mot_de_passe']);
            // If the search (in the db here) is successful
            if (isset($result['prenom'])) {
                // the controller can now redirect to the correct welcome webpage
                // making sure the firstname and lastname are registered throughout the **session**
                session_start();
                $_SESSION['prenom'] = $result['prenom'];
                $_SESSION['nom'] = $result['nom'];
                $_SESSION['id'] = $result['id'];
            }
            else {
                // set the error message to be displayed in the view
                $something_to_say = "login et/ou mot de passe invalide.";  
            }
        }
        else {
            // set the error message to be displayed in the view
            $something_to_say = "login and/or mot de passe oublié.";
        }
    }
 
    // If the user wants to logout, simply destroy the session
    // (and hence redirect to the login form)
    if (isset($_POST['logout'])) {
        session_start();
        session_destroy();
    }
 
 
    // Now, let's call the view.
    // If something to say, the view will display it
    // Otherwise, the view will simply display the login form
    // the form if not logged in, the welcome page if logged in
    if (isset($_SESSION['prenom'])) {
        require_once(__DIR__."/view/php/logInOut.php");
    }
    else {
        require_once(__DIR__."/view/php/index.php");
    }
 
 