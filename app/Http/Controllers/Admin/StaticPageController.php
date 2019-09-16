<?php

namespace App\Http\Controllers\Admin;

use App\StaticPage;
use App\ModelFilters\AdminFilters\StaticPageFilter;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\Http\Requests\StaticPageRequest;
use App\Http\Controllers\Controller;

class StaticPageController extends Controller {

//    Authorize the admin

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
        $static_pages_select = StaticPage::where('page_status', 1)->get();
        $static_pages = StaticPage::whereIn('page_status', $status)->filter($request->all(), StaticPageFilter::class)->paginateFilter(10);
        $statuses = Config::get('constants.STATUS');
        $show_pages = Config::get('constants.STATICPAGES');
        return view('admin.static_page.index', [
            'static_pages' => $static_pages,
            'static_pages_select' => $static_pages_select,
            'statuses' => $statuses,
            'show_pages' => $show_pages,
            'page' => 'index-static-page'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $show_pages = Config::get('constants.STATICPAGES');
        return view('admin.static_page.create', [
            'show_pages' => $show_pages,
            'page' => 'create-static-page'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StaticPageRequest $request) {
        $static_page = StaticPage::create([
                    'page_name' => $request->input('page_name'),
                    'page_show' => $request->input('page_show'),
                    'page_description' => trim($request->input('page_description'))
        ]);
        $static_page->save();
        return redirect()->route('static_page.index')->with('success', 'Static page was successfully added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\StaticPage  $staticPage
     * @return \Illuminate\Http\Response
     */
    public function show(StaticPage $staticPage) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StaticPage  $staticPage
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $show_pages = Config::get('constants.STATICPAGES');
        $static_page = StaticPage::findorfail($id);
        return view('admin.static_page.edit', [
            'static_page' => $static_page,
            'show_pages' => $show_pages
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StaticPage  $staticPage
     * @return \Illuminate\Http\Response
     */
    public function update(StaticPageRequest $request, $id) {
        $static_page = StaticPage::findorfail($id);
        $static_page->page_name = $request->input('page_name');
        $static_page->page_show = $request->input('page_show');
        $static_page->slug = NULL;
        $static_page->page_description = trim($request->input('page_description'));
        if ($static_page->save()) {
            return redirect()->route('static_page.index')->with('success', 'Static page was successfully updated!');
        } else {
            return redirect()->route('static_page.index')->with('error', 'Some error occour!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StaticPage  $staticPage
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $static_page = StaticPage::findOrFail($id);
        $static_page->page_status = 2;
        if ($static_page->save()) {
            return redirect()->route('static_page.index')->with('success', 'Static page was successfully removed!');
        } else {
            return redirect()->route('static_page.index')->with('error', 'Some error occour!');
        }
    }

    public function getActivate($id) {
        if ($id != "") {
            $static_page = StaticPage::findOrFail($id);
            $static_page->page_status = 1;
            $static_page->save();
            return redirect()->route('static_page.index')->with('success', 'Static page was successfully activated!');
        } else {
            return redirect()->route('static_page.index')->with('error', 'Some error occour!');
        }
    }

    public function getDeactivate($id) {
        if ($id != "") {
            $static_page = StaticPage::findOrFail($id);
            $static_page->page_status = 3;
            $static_page->save();
            return redirect()->route('static_page.index')->with('success', 'Static page was successfully deactivated!');
        } else {
            return redirect()->route('static_page.index')->with('error', 'Some error occour!');
        }
    }

}
