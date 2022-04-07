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
}
