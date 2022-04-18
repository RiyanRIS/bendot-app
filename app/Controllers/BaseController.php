<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use Mpdf\Mpdf;
use Mpdf\Output\Destination;

use \App\Models\AnggotaModel;
use \App\Models\HimpunanModel;
use \App\Models\BulananModel;


/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];

    protected $session;
    protected $cache;

    protected $anggota;
    protected $himpunan;
    protected $bulanan;

    protected $botman;

    protected $nama_bulan;

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.
        helper(['form', 'url', 'cookie' ,'ini_helper']);

        $this->session = \Config\Services::session();
        $this->cache = \Config\Services::cache();

        $this->anggota = new AnggotaModel();
        $this->himpunan = new HimpunanModel();
        $this->bulanan = new BulananModel();

        DriverManager::loadDriver(\BotMan\Drivers\Telegram\TelegramDriver::class);
    
        $config = [
            "telegram" => [
            "token" => $_ENV['API_TELE']
            ]
        ];

        $this->botman = BotManFactory::create($config);

        $this->nama_bulan = ["Januari", "Februari", "Maret", 
                            "April", "Mei", "Juni", 
                            "Juli", "Agustus", "September", 
                            "Oktober", "November", "Desember"];
    }

    protected function sendMsgTele($chatid, $msg)
    {
        return $this->botman->say($msg, $chatid, \BotMan\Drivers\Telegram\TelegramDriver::class);
    }

    protected function toExcel($name)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', "NO");
        $sheet->setCellValue('B1', "TIPE");
        $sheet->setCellValue('C1', "NAMA");
        $sheet->setCellValue('D1', "WAKTU");
        $sheet->setCellValue('E1', "JUMLAH");
        $sheet->setCellValue('F1', "TOTAL");

        $himpunans = $this->himpunan->find();
        $no = 1; $saldo = 0;
        foreach($himpunans as $himpunan){
            if($himpunan['tipe'] == "Pemasukan"){
                $saldo += $himpunan['jumlah'];
            } else {
                $saldo -= $himpunan['jumlah'];
            }
            $sheet->setCellValue('A'.($no + 1), $no);
            $sheet->setCellValue('B'.($no + 1), $himpunan['tipe']);
            $sheet->setCellValue('C'.($no + 1), $himpunan['nama']);
            $sheet->setCellValue('D'.($no + 1), date("Y-m-d H:i", strtotime($himpunan['waktu'])));
            $sheet->setCellValue('E'.($no + 1), "Rp " . number_format($himpunan['jumlah'], 0, ",", ".") . ",-");
            $sheet->setCellValue('F'.($no + 1), "Rp " . number_format($saldo, 0, ",", ".") . ",-");
            $no++;
        }
        
        $writer = new Xlsx($spreadsheet);
        $writer->save($name);
        return $name;
    }

    protected function toPdf($name)
    {
        $mpdf = new Mpdf();
        $himpunans = $this->himpunan->find();

        $datas = [
            "himpunans" => $himpunans
        ];

        $html = view('to_pdf', $datas);

        $mpdf->WriteHTML($html);
        $mpdf->Output(__DIR__ . '/../../public/' . $name, Destination::FILE);
    }
}
