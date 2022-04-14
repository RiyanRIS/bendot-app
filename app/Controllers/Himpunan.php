<?php

namespace App\Controllers;

use Exception;

class Himpunan extends BaseController
{
    public function index()
    {
        $himpunans = $this->himpunan->find();
        $data = [
            "title" => "Kas Himpunan",
            "nav_apa" => "himpunan",
            "himpunans" => $himpunans
        ];
        return view('Himpunan/index', $data);
    }

    public function add()
    {
        $data = [
            "title" => "Tambah Kas Himpunan",
            "nav_apa" => "himpunan",
            "input" => session()->get("input"),
            "errors" => session()->get("errors"),
        ];
        return view('Himpunan/add', $data);
    }

    public function insert()
    {
        if(!$this->request->getPost()){
            return redirect()->to(site_url("himpunan/add"))->with("msg", [0, "Maaf, data yang kamu masukkan belum lengkap."]);
        }

        $add_data = [
            "tipe" => $this->request->getPost('tipe'),
            "nama" => $this->request->getPost('nama'),
            "waktu" => date("Y-m-d H:i:s", strtotime($this->request->getPost('waktu'))),
            "jumlah" => str_replace(",", "", $this->request->getPost('jumlah')),
            "total" => str_replace(",", "", $this->request->getPost('total')),
        ];

        $insert = $this->himpunan->simpan($add_data);

        $anggotas = $this->anggota->find();

        $waktu_terbilang = date("d F Y H:i", strtotime($this->request->getPost('waktu')));
        $jumlah_terbilang = "Rp " . number_format(str_replace(",", "", $this->request->getPost('jumlah')));
        $total_terbilang = "Rp " . number_format(str_replace(",", "", $this->request->getPost('total')));

        $msg = "Terjadi {$this->request->getPost('tipe')} dengan detail: \n\n";
        $msg .= "Nama: {$this->request->getPost('nama')}\n";
        $msg .= "Waktu: {$waktu_terbilang}\n";
        $msg .= "Jumlah: {$jumlah_terbilang}\n";
        $msg .= "Total Saldo: {$total_terbilang}";

        foreach($anggotas as $anggota){
            try{
                $this->sendMsgTele($anggota['id_tele'], $msg);
            } catch(Exception $e){

            }
        }

        if($insert){
            return redirect()->to(site_url("himpunan"))->with("msg", [1, "Data berhasil dimasukkan, silahkan cek data terbaru."]);
        } else {
            $this->session->setFlashdata('input', $this->request->getPost());
            return redirect()->to(site_url("himpunan/add"))->with("msg", [0, "Terjadi kesalahan saat memasukkan data, ulangi beberapa saat lagi."]);
        }
    }

    public function update($id)
    {
        $input = session()->has('input') ? session()->get('input') : $this->himpunan->find($id);
        $data = [
            "title" => "Ubah Kas Himpunan",
            "nav_apa" => "himpunan",
            "input" => $input,
            "errors" => session()->get("errors"),
        ];
        return view('Himpunan/update', $data);
    }

    public function updateAction()
    {
        if(!$this->request->getPost()){
            return redirect()->to(site_url("anggota"))->with("msg", [0, "Maaf, kamu tidak berhak mengakses halaman tersebut."]);
        }

        $id = $this->request->getPost('id');

        $update_data = [
            "tipe" => $this->request->getPost('tipe'),
            "nama" => $this->request->getPost('nama'),
            "waktu" => date("Y-m-d H:i:s",strtotime($this->request->getPost('waktu'))),
            "jumlah" => str_replace(",", "", $this->request->getPost('jumlah')),
            "total" => str_replace(",", "", $this->request->getPost('total')),
        ];

        $update = $this->himpunan->update($id, $update_data);

        if($update){
            return redirect()->to(site_url("himpunan"))->with("msg", [1, "Data berhasil dirubah, silahkan cek data terbaru."]);
        } else {
            $this->session->setFlashdata('input', $this->request->getPost());
            return redirect()->to(site_url("himpunan"))->with("msg", [0, "Terjadi kesalahan saat mengubah data, ulangi beberapa saat lagi."]);
        }
    }

    public function delete($id){
        $delete = $this->himpunan->delete($id);
        if($delete){
            return redirect()->to(site_url("himpunan"))->with("msg", [1, "Data berhasil dihapus, silahkan cek data terbaru."]);
        } else {
            return redirect()->to(site_url("himpunan"))->with("msg", [0, "Terjadi kesalahan saat menghapus data, ulangi beberapa saat lagi."]);
        }
    }
}
