<?php

class History extends Controller
{
    public function index(){
        $this->view('template/header');
        $dataSup = $this->model('SupplierModel')->getSuppliers();
        // $this->view('history/index', $dataSup);
        $this->view('history/index',$dataSup);



        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['filter2'])) {
            $month = $_POST['bulan'];
            $years = $_POST['tahun'];
        
            if ($month != 13 && $years != 1) {
                $historyArray = $this->model('HistoryModel')->searchHistoryByMonthYear($month, $years);
            } elseif ($month < 13 && $years == 1) {
                $historyArray = $this->model('HistoryModel')->searchHistoryByMonth($month);
            } elseif ($month == 13 && $years != 1) {
                $historyArray = $this->model('HistoryModel')->searchHistoryByYear($years);
            } else {
              $historyArray = $this->model('HistoryModel')->getHistory();
            }
          }         
          
          else if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['filter1'])) {
            $id = $_POST['supplier'];
            $date = $_POST['date'];

            if ($date != null  && $id != "") {
              $historyArray = $this->model('HistoryModel')->getHistoryBySupplierDate($date, $id);
            } elseif ($id != "") { 
              $historyArray = $this->model('HistoryModel')->getHistoryBySupplier($id);
            } elseif ($date != null){
              $historyArray = $this->model('HistoryModel')->getHistoryByDate($date);
            } else {
              $historyArray = $this->model('HistoryModel')->getHistory();
            } 
          } else {
            $historyArray = $this->model('HistoryModel')->getHistory();
          }


        $this->view('history/data', $historyArray);
        $this->view('template/footer');
    }
}