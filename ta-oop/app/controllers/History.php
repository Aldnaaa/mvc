<?php

class History extends Controller
{
    public function index(){
        $this->view('template/header');

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['filter2'])) {
            $month = $_POST['bulan'];
            $years = $_POST['tahun'];
        
            if ($month != 13 && $years != 1) {
                $data['history'] = $this->model('HistoryModel')->searchHistoryByMonthYear($month, $years);
            } elseif ($month < 13 && $years == 1) {
                $data['history'] = $this->model('HistoryModel')->searchHistoryByMonth($month);
            } elseif ($month == 13 && $years != 1) {
                $data['history'] = $this->model('HistoryModel')->searchHistoryByYear($years);
            } else {
              $data['history'] = $this->model('HistoryModel')->getHistory();
            }
        }         
          else if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['filter1'])) {
            $id = $_POST['supplier'];
            $date = $_POST['date'];

            if ($date != null  && $id != "") {
              $data['history'] = $this->model('HistoryModel')->getHistoryBySupplierDate($date, $id);
            } elseif ($id != "") { 
              $data['history'] = $this->model('HistoryModel')->getHistoryBySupplier($id);
            } elseif ($date != null){
              $data['history'] = $this->model('HistoryModel')->getHistoryByDate($date);
            } else {
              $data['history'] = $this->model('HistoryModel')->getHistory();
            } 
          } else {
            $data['history'] = $this->model('HistoryModel')->getHistory();
          }

        $data['suppliers'] = $this->model('SupplierModel')->getSuppliers();
        $this->view('history/index',$data);
        $this->view('template/footer');
    }
}