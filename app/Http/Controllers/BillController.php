<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cookie;
use DB;

use App\Http\Repos;
use App\Http\Models\Bill;

class BillController extends Controller {
    public function __construct() {
        $this->middleware('auth');

        //API STUFF
        $this->sortBy = 'number';
        $this->maxCount = env('DEFAULT_BILL_COUNT', $this->maxCount);
        $this->itemAge = env('DEFAULT_BILL_AGE', '6 month');
        $this->class = new \App\Bill;
    }

    public function index() {
        $billModelFactory = new Bill\BillModelFactory();
        $driverRepo = new Repos\DriverRepo();
        $model = $billModelFactory->GetBillAdvancedFiltersModel();
        $drivers = $driverRepo->ListAllWithEmployeeAndContact();

        return view('bills.bills', compact('model', 'drivers'));
    }

    public function buildTable(Request $req) {
        $billRepo = new Repos\BillRepo();
        return $billRepo->ListAll($req->filter);
    }

    public function create(Request $req) {
        // Check permissions
        $bill_model_factory = new Bill\BillModelFactory();
        $model = $bill_model_factory->GetCreateModel($req);
        return view('bills.bill', compact('model'));
    }

    public function edit(Request $req, $id) {
        $billRepo = new Repos\BillRepo();
        $factory = new Bill\BillModelFactory();
        $model = $factory->GetEditModel($id, $req);
        return view('bills.bill', compact('model'));
    }

    public function delete(Request $req, $id) {
        $billRepo = new Repos\BillRepo();

        if ($billRepo->CheckIfInvoiced($id) || $billRepo->CheckIfManifested($id)) {
            return ('Unable to delete. Bill has already been invoiced');
        } else {
            $billRepo->Delete($id);
            return redirect()->action('BillController@index');
        }
    }

    private function setPersistenceCookies(Request $req) {
        $persistenceFields = array('keep_date' => 'date',
            'keep_charge_selection' => 'charge_selection',
            'keep_charge_account' => 'charge_account_id',
            'keep_pickup_account' => 'pickup_account_id',
            'keep_delivery_account' => 'delivery_account_id',
            'keep_pickup_driver' => 'pickup_driver_id',
            'keep_delivery_driver' => 'delivery_driver_id');

        foreach($persistenceFields as $checkbox => $fieldName) {
            if(isset($req->$checkbox))
                $test = Cookie::queue('bill_' . $checkbox, $req->$fieldName, 43200);
            else
                Cookie::queue(Cookie::forget('bill_' . $checkbox));
        }
    }

    public function store(Request $req) {
        DB::beginTransaction();
        try {
            $billValidation = new \App\Http\Validation\BillValidationRules();
            $temp = $billValidation->GetValidationRules($req);

            $validationRules = $temp['rules'];
            $validationMessages = $temp['messages'];

            $this->validate($req, $validationRules, $validationMessages);

            $acctRepo = new Repos\AccountRepo();
            $billRepo = new Repos\BillRepo();
            $addrRepo = new Repos\AddressRepo();
            $packageRepo = new Repos\PackageRepo();
            $addrCollector = new \App\Http\Collectors\AddressCollector();
            $billCollector = new \App\Http\Collectors\BillCollector();
            $packageCollector = new \App\Http\Collectors\PackageCollector();

            switch ($req->payment_type) {
                //TODO
            }

            $pickupAddress = $addrCollector->CollectForAccount($req, 'pickup', false);
            $deliveryAddress = $addrCollector->CollectForAccount($req, 'delivery', false);

            if ($req->bill_id) {
                $pickupAddressId = $addrRepo->Update($pickupAddress)->address_id;
                $deliveryAddressId = $addrRepo->Update($deliveryAddress)->address_id;
            }
            else {
                $pickupAddressId = $addrRepo->Insert($pickupAddress)->address_id;
                $deliveryAddressId = $addrRepo->Insert($deliveryAddress)->address_id;
            }

            $bill = $billCollector->Collect($req, $pickupAddressId, $deliveryAddressId);

            if($req->bill_id)
                $bill = $billRepo->Update($bill);
            else
                $bill = $billRepo->Insert($bill);

            $packages = $packageCollector->Collect($req, $bill->bill_id);

            if($bill->bill_id) {
                $old_packages = $packageRepo->GetByBillId($bill->bill_id);
                $old_package_ids = [];
                $new_package_ids = [];
                foreach($old_packages as $old_package)
                    array_push($old_package_ids, $old_package->package_id);
                foreach($packages as $package)
                    array_push($new_package_ids, $package['package_id']);
                $delete_package_ids = array_diff($old_package_ids, $new_package_ids);
                foreach($delete_package_ids as $delete_id)
                    $packageRepo->Delete($delete_id);
            }

            foreach($packages as $package) {
                if ($package['package_id'] == 'null')
                    $packageRepo->Insert($package);
                else
                    $packageRepo->Update($package);
            }

            DB::commit();
            $this->setPersistenceCookies($req);

            if ($req->bill_id)
                return redirect()->action('BillController@index');
            else 
                return redirect()->action('BillController@create');
            
        } catch(Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }
}
