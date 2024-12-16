<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;

class AdminController extends BaseController
{
    public function __construct(Admin $admin)
    {
        parent::__construct($admin);
    }
    public function index()
    {
        return $this->success('Successfully retrieved data', $this->model->get());
    }
    public function show(string $id)
    {
        return $this->success('Successfully retrieved data', $this->model->findOrFail($id));
     
    }
}
