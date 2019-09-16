<?php

namespace App\Http\Controllers\Admin;

use App\Slider;
use App\ModelFilters\AdminFilters\SliderFilter;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\Http\Requests\SliderRequest;
use App\Http\Controllers\Controller;
use File;
use Intervention\Image\Facades\Image;

class SliderController extends Controller {

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
        $sliders = Slider::whereIn('slider_image_status', $status)->filter($request->all(), SliderFilter::class)->paginateFilter(10);
        $statuses = Config::get('constants.STATUS');
        return view('admin.slider.index', [
            'sliders' => $sliders,
            'statuses' => $statuses,
            'page' => 'index-slider-image'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('admin.slider.create', [
            'page' => 'create-slider-image'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SliderRequest $request) {
        $file_name = "";
        $slider = Slider::create([
                    'slider_image' => $file_name,
                    'layer_1' => $request->input('layer_1'),
                    'layer_2' => $request->input('layer_2'),
                    'layer_3' => $request->input('layer_3'),
                    'layer_4' => $request->input('layer_4')
        ]);
        $original_path = public_path('uploads/slider/images/');
        $file_name = 'slider_' . $slider->id . '_' . str_random(32) . '.' . $request['slider_image']->extension();
        File::makeDirectory($original_path, $mode = 0755, true, true);
        Image::make($request['slider_image'])
                ->resize(1920, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save($original_path . $file_name);

        $slider->update(['slider_image' => $file_name]);

        return redirect()->route('slider.index')->with('success', 'Slider image was successfully added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function show(Slider $slider) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $slider = Slider::findorFail($id);
        return view('admin.slider.edit', ['slider' => $slider]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function update(SliderRequest $request, $id) {
        $slider = Slider::findOrFail($id);
        $file_name = "";
        if (!is_null($request->file('slider_image'))) {
            if (file_exists(public_path('uploads/slider/images/' . $slider->slider_image)) && is_file(public_path('uploads/slider/images/' . $slider->slider_image))) {
                unlink(public_path('uploads/slider/images/' . $slider->slider_image));
            }
            $slider->slider_image = $file_name;
        }
        $slider->layer_1 = $request->input('layer_1');
        $slider->layer_2 = $request->input('layer_2');
        $slider->layer_3 = $request->input('layer_3');
        $slider->layer_4 = $request->input('layer_4');
        $slider->save();
        if (!is_null($request->file('slider_image'))) {
            $original_path = public_path('uploads/slider/images/');
            $file_name = 'slider_' . $slider->id . '_' . str_random(32) . '.' . $request['slider_image']->extension();
            File::makeDirectory($original_path, $mode = 0755, true, true);
            Image::make($request['slider_image'])
                    ->resize(1920, function ($constraint) {
                        $constraint->aspectRatio();
                    })
                    ->save($original_path . $file_name);

            if ($slider->update(['slider_image' => $file_name])) {
                return redirect()->route('slider.index')->with('success', 'Slider image was successfully updated!');
            } else {
                return redirect()->route('slider.index')->with('error', 'Some error occour!');
            }
        } else {
            return redirect()->route('slider.index')->with('success', 'Slider image was successfully updated!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $slider = Slider::findOrFail($id);
        $slider->slider_image_status = 2;
        if ($slider->save()) {
            return redirect()->route('slider.index')->with('success', 'Slider image was successfully removed!');
        } else {
            return redirect()->route('slider.index')->with('error', 'Some error occour!');
        }
    }

    public function getActivate($id) {
        if ($id != "") {
            $slider = Slider::findOrFail($id);
            $slider->slider_image_status = 1;
            $slider->save();
            return redirect()->route('slider.index')->with('success', 'Slider image was successfully activated!');
        } else {
            return redirect()->route('slider.index')->with('error', 'Some error occour!');
        }
    }

    public function getDeactivate($id) {
        if ($id != "") {
            $slider = Slider::findOrFail($id);
            $slider->slider_image_status = 3;
            $slider->save();
            return redirect()->route('slider.index')->with('success', 'Slider image was successfully deactivated!');
        } else {
            return redirect()->route('slider.index')->with('error', 'Some error occour!');
        }
    }

}
