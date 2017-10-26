<?php
                session_start();
                // define variables and set to empty values
                $username = $password = "";

                //if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $username = test_input($_POST["username"]);
                    $password = test_input($_POST["password"]);
                    //comprueba que existe el usuario
                    if(is_dir("../../usuarios/$username")==FALSE){
                        $_SESSION["ERR"]="no existe el usuario";
                        fclose($userfile);
                        header("Location: login.php");
                    }else{
                        $userfile=fopen("../../usuarios/$username/datos.dat", "r");
                        //nos saltamos los campos hasta llegar a password
                        fgets($userfile);
                        fgets($userfile);
                        $hash=fgets($userfile);
                        //añado \n para que coincidan passwords
                        if(strcmp($hash, md5($password)."\n") !=0){
                            $_SESSION["ERR"] = "contraseña incorrecta";
                            fclose($userfile);
                            header("Location: login.php");
                        }else{
                            $_SESSION["username"] = $username;
                            //echo "Variable sesion: ".$_SESSION["username"];
                            //expira en 1 dia
                            setcookie("username", $username, time() + 86400, "/");
                            //echo "     Cookie: ".$_COOKIE["username"];
                            fclose($userfile);
                            header("Location: index.php");
                        }
                        
                    }
                    
                    //TODO javascript to go to another url (index but being logged)
                    
                //}

                function test_input($data) {
                  $data = trim($data);
                  $data = stripslashes($data);
                  $data = htmlspecialchars($data);
                  return $data;
                }
    ?>
