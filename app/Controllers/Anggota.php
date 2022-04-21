<?php

namespace App\Controllers;

class Anggota extends BaseController
{
    public function index()
    {
        $anggotas = $this->anggota->find();
        $data = [
            "title" => "Anggota",
            "nav_apa" => "anggota",
            "anggotas" => $anggotas
        ];
        return view('Anggota/index', $data);
    }

    public function add()
    {
        $data = [
            "title" => "Tambah Anggota",
            "nav_apa" => "anggota",
            "input" => session()->get("input"),
            "errors" => session()->get("errors"),
        ];
        return view('Anggota/add', $data);
    }

    public function insert()
    {
        if(!$this->request->getPost()){
            return redirect()->to(site_url("anggota/add"))->with("msg", [0, "Maaf, data yang kamu masukkan belum lengkap."]);
        }

        if($this->request->getPost('username') != ""){
            if(!$this->anggota->validUsername($this->request->getPost('username'))){
                $errors = [
                    "username" => "Username telah digunakan, harap gunakan yang lainya."
                ];
                $this->session->setFlashdata('input', $this->request->getPost());
                $this->session->setFlashdata('errors', $errors);
                return redirect()->to(site_url("anggota/add"));
            }
        }

        $add_data = [
            "nama" => $this->request->getPost('nama'),
            "role" => $this->request->getPost('role'),
            "id_tele" => $this->request->getPost('id_tele'),
            "username" => $this->request->getPost('username'),
            "password" => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        ];

        $insert = $this->anggota->simpan($add_data);

        $this->sendMsgTele($this->request->getPost('id_tele'), "Pendaftaran kamu telah disetuji oleh admin.");

        if($insert){
            return redirect()->to(site_url("anggota"))->with("msg", [1, "Data berhasil dimasukkan, silahkan cek data terbaru."]);
        } else {
            $this->session->setFlashdata('input', $this->request->getPost());
            return redirect()->to(site_url("anggota/add"))->with("msg", [0, "Terjadi kesalahan saat memasukkan data, ulangi beberapa saat lagi."]);
        }
    }

    public function update($id)
    {
        $input = session()->has('input') ? session()->get('input') : $this->anggota->find($id);
        $data = [
            "title" => "Ubah Anggota",
            "nav_apa" => "anggota",
            "input" => $input,
            "errors" => session()->get("errors"),
        ];
        return view('Anggota/update', $data);
    }

    public function updateAction()
    {
        if(!$this->request->getPost()){
            return redirect()->to(site_url("anggota"))->with("msg", [0, "Maaf, kamu tidak berhak mengakses halaman tersebut."]);
        }

        $id = $this->request->getPost('id');

        $anggota = $this->anggota->find($id);
        $password = $anggota['password'];

        if($this->request->getPost('username') != ""){
            if(!$this->anggota->validUsername($this->request->getPost('username'), $id)){
                $errors = [
                    "username" => "Username telah digunakan, harap gunakan yang lainya."
                ];
                $this->session->setFlashdata('input', $this->request->getPost());
                $this->session->setFlashdata('errors', $errors);
                return redirect()->to(site_url("anggota/update/".$id));
            }
        }

        if($this->request->getPost('password') != ""){
            $password = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $update_data = [
            "nama" => $this->request->getPost('nama'),
            "role" => $this->request->getPost('role'),
            "id_tele" => $this->request->getPost('id_tele'),
            "username" => $this->request->getPost('username'),
            "password" => $password
        ];

        $update = $this->anggota->update($id, $update_data);

        if($update){
            return redirect()->to(site_url("anggota"))->with("msg", [1, "Data berhasil dirubah, silahkan cek data terbaru."]);
        } else {
            $this->session->setFlashdata('input', $this->request->getPost());
            return redirect()->to(site_url("anggota"))->with("msg", [0, "Terjadi kesalahan saat mengubah data, ulangi beberapa saat lagi."]);
        }
    }

    public function delete($id){
        $delete = $this->anggota->delete($id);
        if($delete){
            return redirect()->to(site_url("anggota"))->with("msg", [1, "Data berhasil dihapus, silahkan cek data terbaru."]);
        } else {
            return redirect()->to(site_url("anggota"))->with("msg", [0, "Terjadi kesalahan saat menghapus data, ulangi beberapa saat lagi."]);
        }
    }
}
