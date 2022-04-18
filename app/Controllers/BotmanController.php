<?php

namespace App\Controllers;

use BotMan\BotMan\BotMan;

use BotMan\BotMan\Messages\Attachments\File;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use Mpdf\Mpdf;
use Mpdf\Output\Destination;

class BotmanController extends BaseController
{
    public function handle(){
        $this->botman->hears('/start', function (BotMan $bot) {
            $user = $bot->getUser();
            $msg = 'Halo '.$user->getFirstName().' '.$user->getLastName() . "\nTerima kasih telah melakukan registrasi pada @" . $_ENV['USERNAME_TELE'] . ".\n\nBerikut adalah kode unik yang dapat kamu serahkan kepada Admin sebagai bukti telah melakukan registrasi.\n\n". $user->getId();
            return $bot->reply($msg);
        });

        $this->botman->hears('/show_himpunan', function (BotMan $bot) {
            $user = $bot->getUser();

            $anggota = $this->anggota->findByChatid($user->getId());

            if(count($anggota) == 0){
                return;
            }

            $bot->reply("Memproses... Tunggu sebentar.");

            $name = date("YmdHis");
            $nama_pdf =  $name . ".pdf";
            // $nama_xlsx = $name . ".xlsx";

            $this->toPdf($nama_pdf);

            /** 
             * API Telegram hanya support gif, zip, and pdf. 
             * https://github.com/botman/botman/issues/967
             **/
            // $this->toExcel($nama_xlsx);

            // sleep(10);
            // $bot->reply(site_url($nama_pdf));
            sleep(2);
            // $bot->reply(site_url($nama_xlsx));
            // sleep(2);

            $attachment = new File(site_url($nama_pdf), [
                'custom_payload' => true,
            ]);

            $msg = OutgoingMessage::create()
            ->withAttachment($attachment);

            return $bot->reply($msg);
        });

        $this->botman->hears('/show_bulanan', function (BotMan $bot) {
            $user = $bot->getUser();
    
            $anggota = $this->anggota->findByChatid($user->getId());
    
            if(count($anggota) == 0){
                return;
            }
            $anggota = $anggota[0];
            $tahun = date('Y');
            $msg = '';

            $bulanans = $this->bulanan->findByAnggotaTahun($anggota['id'], $tahun);

            if(count($bulanans) == 0){
                $msg .= "{$anggota['nama']} belum melakukan pembayaran apapun untuk tahun {$tahun}";
            } else {
                $msg .= "List pembayaran {$anggota['nama']} untuk tahun {$tahun}:\n\n";
                $bulan_ke = 1;
                foreach($this->nama_bulan as $nama_bulan){
                    $stt = false;
                    foreach($bulanans as $bulanan){
                        if($bulanan['month'] == $bulan_ke){
                          $stt = true;
                        }
                    }
                    $bulan_ke++;
                    $msg .= "{$nama_bulan}: ". ($stt?'Sudah Bayar':'Belum Bayar'). "\n";
                }
            }

            return $bot->reply($msg);
        });

        $this->botman->listen();
    }

    public function notifBelumBayar()
    {
        $berapa_kali = 5; // max 12

        $bulanans = $this->bulanan->findAll();
        $anggotas = $this->anggota->findAll();

        foreach($anggotas as $anggota){
            $month = date('n');
            $year = date("Y");
            
            for ($i=0; $i < $berapa_kali; $i++) {
                $stt = true;

                foreach ($bulanans as $bulanan) {
                    if($bulanan['id_anggota'] == $anggota['id'] && $bulanan['month'] == $month && $bulanan['year'] == $year){
                        $stt = false;   
                    }
                }

                if($stt){
                    $nama = strtoupper($anggota['nama']);
                    $panggil_bulan = strtoupper($this->nama_bulan[$month - 1]);
                    $msg = "[PENGINGAT] {$nama} harap segera melakukan pembayaran kas Bulanan untuk {$panggil_bulan} {$year}";
                    return $this->sendMsgTele($anggota['id_tele'], $msg);
                }

                $month = $month - 1;
                if($month == 0){
                    $month = 12;
                    $year -= 1;
                }
            }
        }

        $res = [
            'status' => "Ok"
        ];
        
        return $this->response->setJSON($res);
    }

    public function setWebhook()
    {
        $url = "https://api.telegram.org/bot{$_ENV['API_TELE']}/setWebhook?url={$_ENV['BASE_URL']}/bot";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL,$url);
        $result=curl_exec($ch);
        curl_close($ch);

        $res = [
            'status' => "Ok",
            'result' => json_decode($result, true),
            'url' => $url,
        ];
        
        return $this->response->setJSON($res);
    }
}