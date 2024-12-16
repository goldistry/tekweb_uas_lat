<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    protected $deliveryTransactionController;
    protected $deliveryLogController;
    protected $adminController;

    public function __construct(DeliveryTransactionController $deliveryTransactionController, DelIveryLogController $deliveryLogController, AdminController $adminController)
    {
        $this->deliveryTransactionController = $deliveryTransactionController;
        $this->deliveryLogController = $deliveryLogController;
        $this->adminController = $adminController;
    }
    public function login()
    {
        $data['title'] = "Login";
        return view("login", $data);
    }

    public function loginAdmin()
    {
        $data['title'] = "Admin | Login";
        return view("loginAdmin", $data);
    }
    public function dashboardAdmin()
    {
        $data['title'] = "Admin | Dashboard";
        $response = $this->deliveryTransactionController->index();
        $deliveryTransactions = $response->getData(true);  // Get data as an array
        $data['deliveryTransactions'] = $deliveryTransactions['data'];
        // dd($data['deliveryTransactions']); // Remove or comment this when done debugging

        return view("adminDashboard", $data);
    }
    public function entryLog($nomor_resi)
    {
        $entryLog = $this->deliveryLogController->getByNomorResi($nomor_resi);
        $entryLog = $entryLog->getData(true);  // Get data as an array
        $data['entry_log'] = $entryLog['data'];
        $data['nomor_resi'] = $nomor_resi;
        $data['title'] = "Admin | Entry Log";
    //    dd($data);
        return view("entryLog", $data);
    }

    public function userAdmin(){
        $data['title'] = "Admin | User";
        $admins = $this->adminController->index();
        $admins = $admins->getData(true);
        $data['admin'] = $admins['data'];
        // dd($data);
        return view("userAdmin", $data);
    }

    public function editUserAdmin($id){
        $data['admin_id']  = $id;
        $admin = $this->adminController->show($id);
        $data['title'] = "Admin | Edit User";
        $data['admin'] = $admin->getData(true)['data'];
        // dd($data);
        return view("editUserAdmin", $data);
    }

    public function welcome(){
        $data['title'] = "Welcome";
        // $entryLog = $this->deliveryLogController->getByNomorResi($nomor_resi);
        // $entryLog = $entryLog->getData(true);  // Get data as an array
        // $data['entry_log'] = $entryLog['data'];
        // dd($data);
        return view("WelcomeUser", $data);
    }
}
