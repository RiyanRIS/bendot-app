<?php

namespace App\Controllers;

class Bulanan extends BaseController
{
    public function index()
    {
        $year = $this->request->getGet("year") ?: date('Y');
        $month = $this->request->getGet("month") ?: date('n');

        $anggotas = $this->anggota->find();
        $bulanans = $this->bulanan->findYearMonth($year, $month);

        $data = [
            "title" => "Bulanan",
            "nav_apa" => "bulanan",
            "anggotas" => $anggotas,
            "bulanans" => $bulanans,
            "year" => $year,
            "month" => $month,
        ];

        return view('Bulanan/index', $data);
    }

    public function bayar($id, $year, $month)
    {
        $anggota = $this->anggota->find($id);

        $msg = "Pembayaran bulan {$this->nama_bulan[$month - 1]} periode tahun {$year} berhasil!";
        $this->sendMsgTele($anggota['id_tele'], $msg);

        $add_data = [
            'id_anggota' => $id,
            'month' => $month,
            'year' => $year,
        ];

        $insert = $this->bulanan->simpan($add_data);

        if($insert){
            return redirect()->to(site_url("bulanan")."?month=".$month."&year=".$year)->with("msg", [1, "Data berhasil diperbarui, silahkan cek data terbaru."]);
        } else {
            return redirect()->to(site_url("bulanan")."?month=".$month."&year=".$year)->with("msg", [0, "Terjadi kesalahan saat mengubah data, ulangi beberapa saat lagi."]);
        }
    }
}
