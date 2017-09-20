<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Repos;
use App\Http\Models\Invoice;

class InvoiceController extends Controller {
    public function __construct() {
        $this->middleware('auth');

        //API STUFF
        $this->sortBy = 'number';
        $this->maxCount = env('DEFAULT_INVOICE_COUNT', $this->maxCount);
        $this->itemAge = env('DEFAULT_INVOICE_AGE', '6 month');
        $this->class = new \App\Invoice;
    }

    public function index() {
        $invoiceModelFactory = new Invoice\InvoiceModelFactory();
        $contents = $invoiceModelFactory->ListAll();
        return view('invoices.invoices', compact('contents'));
    }

    public function generate(Request $req) {
        // Check permissions
        $invoice_model_factory = new Invoice\InvoiceModelFactory();
        $model = $invoice_model_factory->GetCreateModel($req);
        return view('invoices.invoice-generate', compact('model'));
    }

    public function layouts(Request $req, $id) {
        $invoice_model_factory = new Invoice\InvoiceModelFactory();
        $model = $invoice_model_factory->GetLayoutModel($req, $id);
        return view('invoices.layouts', compact('model'));
    }

    public function getAccountsToInvoice(Request $req) {
        $acctRepo = new Repos\AccountRepo();
        $start_date = (new \DateTime($req->start_date))->format('Y-m-d');
        $end_date = (new \DateTime($req->end_date))->format('Y-m-d');
        $accounts = $acctRepo->ListAllWithUninvoicedBillsByInvoiceInterval($req->invoice_interval, $start_date, $end_date);
        return $accounts;
    }

    public function store(Request $req) {
        $invoiceRepo = new Repos\InvoiceRepo();

        $start_date = (new \DateTime($req->start_date))->format('Y-m-d');
        $end_date = (new \DateTime($req->end_date))->format('Y-m-d');

        $accounts = array();
        foreach($req->checkboxes as $account)
            array_push($accounts, $account);

        $invoiceRepo->create($accounts, $start_date, $end_date);

        return redirect()->action('InvoiceController@index');
    }
}
