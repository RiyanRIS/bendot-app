<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
    	if (!session()->islogin)
	    {
            return redirect()->to(site_url())->with('msg', [0, "Sesi anda telah kadaluarsa, silahkan login kembali."]);
	    }

        if(!in_array(session()->get('user_role'), $arguments)){
            return redirect()->back()->with('msg', [0, "Anda tidak berhak mengakses halaman tersebut."]);
        }
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}