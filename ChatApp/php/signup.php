<?php
    session_start();
    include_once "config.php";
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if(!empty($fname) && !empty($lname) && !empty($email) && !empty($password)){ //check email is valid or not
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){ //if email is valid
            $sql = mysqli_query($conn, "SELECT email FROM users WHERE email = '{$email}'"); 
            if(mysqli_num_rows($sql) > 0){ //if email is exist
                echo "$email - This email is already exists!!"; 
            } else { //if email is not exist
                if(isset($_FILES['image'])){ //check file
                    $img_name = $_FILES['image']['name']; //getting user uploaded image name
                    $img_type = $_FILES['image']['type']; //getting user uploaded image type
                    $tmp_name = $_FILES['image']['tmp_name']; //temporary image name to save in folder

                    //let's explode img and get the jpg or png file only
                    $img_expolode = explode('.', $img_name);
                    $img_ext = end($img_expolode); //got the extension

                    $extensions = ['png', 'jpg', 'jpeg']; 
                    if(in_array($img_ext, $extensions) === true){ //if match
                        $time = time(); //return current time
                        $new_img_name = $time.$img_name;
                        
                        if(move_uploaded_file($tmp_name, "images/".$new_img_name)){ //if user upload img move to folder 
                            $status = "Active now"; // once signed up then return active status
                            $random_id = rand(time(), 10000000); //create random id for user

                            $sql2 = mysqli_query($conn, "INSERT INTO users (unique_id, fname, lname, email, password, img, status)
                                                VALUES ({$random_id}, '{$fname}', '{$lname}', '{$email}', '{$password}', '{$new_img_name}', '{$status}')");
                        
                            if($sql2){ //if these data inserted
                                $sql3 = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
                                if(mysqli_num_rows($sql3) > 0){
                                    $row = mysqli_fetch_assoc($sql3);
                                    $_SESSION['unique_id'] = $row['unique_id']; //using this session we used in php file
                                    echo "success";
                                }
                            } else {
                                echo "Something went wrong";
                            }
                        }
                        
                    } else {
                        echo "Please select an image file - jpg, jpeg or png";
                    }

                } else {
                    echo "Please select an image file";

                }
            }
        } else {
            echo "$email - This is not a valid email!";
        }
    } else {
        echo "All input fields are required";
    }
?>