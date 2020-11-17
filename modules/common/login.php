<?php
    $db = new Database();
    $error['error'] = "";
    $info = array();
    if(isset($_POST['sign-in'])){
        $username = trim($_POST['txtUsername']);
        $password = trim($_POST['txtPassword']);
        $remember = isset($_POST['remember']) ? $_POST['remember'] : "0";
        $patternUsername = '/^[a-zA-Z0-9\.\_]{8,}$/';
        $patternPassword = '/^[a-zA-Z0-9\-\_\@\#]{6,}$/'; 
        if(preg_match($patternUsername, $username)){
            if(preg_match($patternPassword, $password)){
                $sql = "select * from user where username='$username' and password='$password'";
                $info = $db->select($sql);
                if(!empty($info)){
                    if($username == $info[0]['username'] && $password == $info[0]['password']){
                        $db->s->setSession('user-token', $username);
                        $db->s->setSession('fullname', $info[0]['fullname']);
                        if($remember == 1){
                            $db->c->setCookie('user-token', $username, time() + 2592000);
                            $db->c->setCookie('fullname', $info[0]['fullname'], time() + 2592000);
                        }
                        $db->r->redirects($db->r->getUrl('qlthuexe'));
                    }
                }else{
                    $error['error'] = "Username or Password incorrect.";
                }
            }else{
                $error['error'] = "Password invalid.";
            }
        }else{
            $error['error'] = "Username invalid.";
        }
        
    }
?>
<div class="container">
    <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card card-signin my-5">
            <div class="card-body">
                <h4 class="card-title text-center text-danger"><b><i class="fas fa-motorcycle"></i> Motobike-RMS</b></h4>
                <form class="form-signin" action="" method="post">
                    <div class="form-label-group">
                        <label for="" class="mt-1">Username</label>
                        <input type="text" id="" class="form-control" name="txtUsername" placeholder="" required autofocus>
                    </div>

                    <div class="form-label-group">
                        <label for="" class="mt-1">Password</label>
                        <input type="password" id="" class="form-control" name="txtPassword" placeholder="" required>
                    </div>

                    <div class="custom-control custom-checkbox mb-2">
                        <input type="checkbox" class="custom-control-input" id="customCheck" name="remember" value="1">
                        <label class="custom-control-label mt-2" for="customCheck">Remember me</label>
                    </div>
                    <div class="form-label-group mb-2 text-center">
                        <span class="text-danger"><?php echo $error['error'];?></span>
                    </div>
                    <input type="submit" class="btn btn-lg btn-primary btn-block text-uppercase" value="Sign in" name="sign-in">
                    <hr>
                    <div class="text-center">
                        <a class="fs-18" href="#">Forgot Password ?</a>
                    </div>
                    <div class="text-center">
                        <a class="fs-18" href="#">Create an Account!</a>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>
  </div>