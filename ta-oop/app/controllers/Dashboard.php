<?php

class Dashboard extends Controller
{
    public function index(){
        $this->view('template/header');
        
        $data['barang'] = $this->model('BarangModel')->getJenisBarang();
        $data['pembelian'] = $this->model('TransaksiModel')->getTotalTransaksi();
        $data['pemasukan'] = $this->model('TransaksiModel')->getTotalPemasukan();


        $this->view('dashboard/index',$data);
        $this->view('template/footer');

    }
}