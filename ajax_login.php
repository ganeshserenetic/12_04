<?php
// Start or resume a session
session_start();

// include_once '/includes/connect.php'; 

include_once('include/connect.php');
// include_once('includes/config.php');


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data


    $email = $_POST['email'];
    $password  = $_POST['password'];
    

    $validate = new Validation();
   
    $validate->email(array('required' => true, 'field' => 'email', 'min' => '3', 'max' => '30', 'value' => $email), array('required' => 'email is required'));
    $validate->string(array('required' => true, 'field' => 'password', 'min' => '6', 'max' => '255', 'value' => $password), array('required' => 'Password is required', 'min' => 'Password should be at least 6 characters long'));
   
    if($validate->isValid()) {
   
        //login logic
        $encriptedPassword = md5($_POST['password']);

        $sqlQry="SELECT * FROM users where email =:email AND password = :password";
        $resQry= $pdo->selectOne($sqlQry,array(":email"=>$email,":password"=>$encriptedPassword));


        if($resQry) {
            $_SESSION['user'] = $email;

            header('Content-Type: application/json');
            echo json_encode( array(
                'statusCode' => 200,
                'message' => 'User login successful'));
            exit();

        }
        else{

            header('Content-Type: application/json');
            echo json_encode( array(
                'statusCode' => 400,
                'message' => 'please enter right credentials'));
            exit();

        }

        
     }
     else{
        $errors = $validate->getErrors();
        header('Content-Type: application/json');
        echo json_encode($errors); // Return only the error message for firstName
  
     }


}

?>
