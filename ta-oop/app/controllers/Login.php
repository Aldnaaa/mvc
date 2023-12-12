<?php

//namespace controllers;

//class Login extends Controller{
//    public function index(){
//        $this->view('login/index');
//
//    }
//    public function signIn(){
//        var_dump($_POST);
////        private $userModel;
//
////        public function __construct($db) {
////            $this->userModel = new UserModel($db);
////        }
//
////        $hashedPassword = md5($password);
//        $result = $this->model('UserModel')->getUser($_POST);
//        echo "hasil adalah" . $result;
//        if ($result->num_rows > 0) {
//            $row = $result->fetch_assoc();
//            $_SESSION['user_session'] = $row['id_user'];
//            $_SESSION['level'] = $row['level']; // Tambahkan baris ini untuk menyimpan level pengguna
//
//            echo '<script>alert("Login Sukses");window.location="index.php"</script>';
//            // Langsung arahkan ke index.php setelah login
//            // header("Location: index.php");
//            exit;
//        } else {
////            echo '<script>alert("Login Gagal");history.go(-1);</script>';
//        }
//    }
//}
class Login extends Controller{
    public function index(){
        $this->view('login/index');

    }
    public function signIn()
    {
//        var_dump($_POST);

        $result = $this->model('UserModel')->getUser($_POST);


            if ($result) {
                $_SESSION['user_session'] = $result['id_user'];
                $_SESSION['level'] = $result['level'];

                echo '<script>alert("Login Sukses");</script>';
                $this->switch();

//                if(!empty($_GET['page'])){
//                    include '../app/template/header.php';
//                    include 'admin/template/'.$_GET['page']. '.php';
//                    include '../app/template/footer.php';
//                }else{
////                        include 'admin/template/dashboard.php';
//                    header("Location: ../app/controllers/Dashboard.php");
//                    var_dump($_SESSION['level']);
//                }
//                var_dump($_SESSION('level'));
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

