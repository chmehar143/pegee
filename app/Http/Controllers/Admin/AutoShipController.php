<?php

namespace App\Http\Controllers\Admin;

use App\AutoShip;
use App\Product;
use App\ModelFilters\AdminFilters\AutoShipFilter;
use Illuminate\Http\Request;
use App\Http\Requests\AutoShipRequest;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\Controller;

class AutoShipController extends Controller {

    public function __construct() {
        $this->middleware('admin.auth')->except('logout');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $status = NULL;
        if ($request->get('status') != "") {
            $status = array($request->get('status'));
        } else {
            $status = array(1, 3);
        }
        $autoShips = AutoShip::whereIn('autoship_status', $status)
                ->filter($request->all(), AutoShipFilter::class)
                ->paginateFilter(10);
        $products = Product::where('product_status', 1)->get();
        $statuses = Config::get('constants.STATUS');
        return view('admin.autoship.index', [
            'autoShips' => $autoShips,
            'products' => $products,
            'statuses' => $statuses,
            'page' => 'index-autoShip'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $products = Product::where('product_status', 1)->get();
        return view('admin.autoship.create', [
            'products' => $products,
            'page' => 'create-autoShip'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AutoShipRequest $request) {
        $autoShip = AutoShip::create([
                    'autoship_percentage' => $request->input('autoship_percentage'),
                    'product_id' => $request->input('product')
        ]);
        $autoShip->save();

        return redirect()->route('autoship.index')->with('success', 'Auto ship successfully created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AutoShip  $autoShip
     * @return \Illuminate\Http\Response
     */
    public function show(AutoShip $autoShip) {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AutoShip  $autoShip
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $autoShip = AutoShip::findOrFail($id);
        $products = Product::where('product_status', 1)->get();
        return view('admin.autoship.edit', [
            'autoShip' => $autoShip,
            'products' => $products,
            'page' => 'create-autoShip'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AutoShip  $autoShip
     * @return \Illuminate\Http\Response
     */
    public function update(AutoShipRequest $request, $id) {
        $autoShip = AutoShip::findOrFail($id);
        $autoShip->autoship_percentage = $request->input('autoship_percentage');
        $autoShip->product_id = $request->input('product');
        if ($autoShip->save()) {
            return redirect()->route('autoship.index')->with('success', 'Auto ship was successfully updated!');
        } else {
            return redirect()->route('autoship.index')->with('error', 'Some error occour!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AutoShip  $autoShip
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $autoShip = AutoShip::findOrFail($id);
        $autoShip->autoship_status = 2;
        if ($autoShip->save()) {
            return redirect()->route('autoship.index')->with('success', 'Auto ship was successfully removed!');
        } else {
            return redirect()->route('autoship.index')->with('error', 'Some error occour!');
        }
    }

    public function getActivate($id) {
        if ($id != "") {
            $autoShip = AutoShip::findOrFail($id);
            $autoShip->autoship_status = 1;
            $autoShip->save();
            return redirect()->route('autoship.index')->with('success', 'Auto ship was successfully activated!');
        } else {
            return redirect()->route('autoship.index')->with('error', 'Some error occour!');
        }
    }

    public function getDeactivate($id) {
        if ($id != "") {
            $autoShip = AutoShip::findOrFail($id);
            $autoShip->autoship_status = 3;
            $autoShip->save();
            return redirect()->route('autoship.index')->with('success', 'Auto ship was successfully deactivated!');
        } else {
            return redirect()->route('autoship.index')->with('error', 'Some error occour!');
        }
    }

}
