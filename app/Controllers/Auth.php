<?php

namespace App\Controllers;

class Auth extends BaseController
{
    public function login()
    {
        $data = [
            "input" => session()->get("input")
        ];
        return view('Auth/login', $data);
    }

    public function loginAction()
    {
        if(!$this->request->getPost()){
            return redirect()->to(site_url("login"))->with("msg", [0, "Maaf, kamu tidak berhak mengakses halaman tersebut."]);
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        if($this->anggota->validLogin($username, $password)){
            $anggota = $this->anggota->findByUsername($username);
            $anggota = $anggota[0];
            $session_data = [
                "islogin" => true,
                "user_username" => $anggota['username'],
                "user_nama" => $anggota['nama'],
                "user_role" => $anggota['role'],
                "user_idTele" => $anggota['id_tele'],
            ];
            session()->set($session_data);

            $pesan_selamatdatang = "Selamat datang kembali ".$anggota['nama'].", kamu masuk sebagai ".$anggota['role'];
            if($anggota['role'] == "Admin"){
                return redirect()->to(site_url("anggota"))->with("msg", [1, $pesan_selamatdatang]);
            } else if($anggota['role'] == "Bendahara"){
                return redirect()->to(site_url("himpunan"))->with("msg", [1, $pesan_selamatdatang]);
            } else if($anggota['role'] == "Anggota"){
                $this->session->setFlashdata('input', $this->request->getPost());
                return redirect()->to(site_url("login"))->with("msg", [0, "Mohon maaf, role Anggota belum memiliki akses apapun dalam website ini."]);
            }
        } else {
            $this->session->setFlashdata('input', $this->request->getPost());
            return redirect()->to(site_url("login"))->with("msg", [0, "Kombinasi username atau password belum tepat."]);
        }
    }

    public function logout()
    {
        $session_data = [
            "islogin" => false,
            "user_username" => null,
            "user_nama" => null,
            "user_role" => null,
            "user_idTele" => null,
        ];
        session()->set($session_data);
        $date = date("d F Y");
        return redirect()->to(site_url("login"))->with("msg", [1, "Proses logout berhasil pada {$date}, sampai jumpa lagi."]);
    }

}
