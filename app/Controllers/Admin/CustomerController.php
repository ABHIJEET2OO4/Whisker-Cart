<?php
namespace App\Controllers\Admin;
use Core\{Request, View, Database, Response};

class CustomerController
{
    public function index(Request $request, array $params = []): void
    {
        $customers = Database::fetchAll("SELECT * FROM wk_customers ORDER BY created_at DESC");
        View::render('admin/customers/index', ['pageTitle'=>'Customers','customers'=>$customers], 'admin/layouts/main');
    }

    public function show(Request $request, array $params = []): void
    {
        $customer = Database::fetch("SELECT * FROM wk_customers WHERE id=?", [$params['id']]);
        if (!$customer) { Response::notFound(); return; }
        $orders = Database::fetchAll("SELECT * FROM wk_orders WHERE customer_id=? ORDER BY created_at DESC", [$params['id']]);
        View::render('admin/customers/show', [
            'pageTitle'=>$customer['first_name'].' '.$customer['last_name'], 'customer'=>$customer, 'orders'=>$orders
        ], 'admin/layouts/main');
    }
}
