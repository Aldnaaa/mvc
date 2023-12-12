<?php

class Dashboard extends Controller
{
    public function index(){
//        $barang->getJenisBarang();
        $data = $this->model('BarangModel')->getJenisBarang();
//        include "..app/views/template/sidebar.php";
        $this->view('template/header');
//        $this->view('template/sidebar');

        $this->view('dashboard/index',$data);
        $this->view('template/footer');

    }
}