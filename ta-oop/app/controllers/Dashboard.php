<?php

class Dashboard extends Controller
{
    public function __construct () {

		// Jika belum login maka jangan biarkan user masuk
		if ( !isset($_SESSION["level"]) && !isset($_SESSION["user_session"])) {
			header("location: http://localhost/perpus/masuk");
			exit;
		}
	}

    public function index(){
        $this->view('template/header');
        
        $data['barang'] = $this->model('BarangModel')->getJenisBarang();
        $data['pembelian'] = $this->model('TransaksiModel')->getTotalTransaksi();
        $data['pemasukan'] = $this->model('TransaksiModel')->getTotalPemasukan();


        $this->view('dashboard/index',$data);
        $this->view('template/footer');

    }
}