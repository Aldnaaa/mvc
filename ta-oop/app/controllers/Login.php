<?php
class Login extends Controller{
    public function index(){
        $this->view('template/header');
        $this->view('login/index');

    }
    public function signIn()
    {
        $result = $this->model('UserModel')->getUser($_POST);
            if ($result) {
                $_SESSION['user_session'] = $result['id_user'];
                $_SESSION['level'] = $result['level'];

                echo '<script>alert("Login Sukses");</script>';
                $this->switch();
            } else {
                // Handle the case where no rows were returned (login failed)
                echo '<script>alert("Login Gagal");history.go(-1);</script>';
//                header("Location: login.php");
            }exit;
    }
    private function switch(){
        if(!empty($_SESSION['level'])){

            if(!empty($_GET['page'])){
                include '../app/template/header.php';
                include 'admin/template/'.$_GET['page']. '.php';
                include '../app/template/footer.php';
            }else{
//                echo"asaaaaaaaaaaaaaa";
                echo '<script>window.location="../Dashboard";</script>';
            }

        } else {
            header("Location: Login.php");
        }
    }
}

