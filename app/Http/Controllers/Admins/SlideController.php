<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Slide;
use Illuminate\Http\Request;

class SlideController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataSlides = Slide::paginate(10);
        return view('admins.pages.slide.index', compact('dataSlides'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $get_image = $request->file('Image');

        $idSlide = $request->input('idSlide');
        $SubTitle = $request->input('SubTitle');
        $SubTitleText = $request->input('SubTitleText');
        $MainTitle = $request->input('MainTitle');
        $MainTitleText = $request->input('MainTitleText');
        $TitleButton = $request->input('TitleButton');
        $LinkButtonLinkButton = $request->input('LinkButtonLinkButton');

        if ($idSlide != '') {

            $table = Slide::find($idSlide);
            if ($get_image) {
                $get_name_image = $get_image->getClientOriginalName();
                $storedPath = $get_image->move('images_upload/slide/', $get_name_image);

                $newLink = explode('\\', $storedPath);
                $newLink2 = implode('/', $newLink);
                $table->image = $newLink2;
            }
            $table->sub_title = $SubTitle;
            $table->sub_title_text = $SubTitleText;
            $table->main_title = $MainTitle;
            $table->main_title_text = $MainTitleText;
            $table->text_button = $TitleButton;
            $table->link_button = $LinkButtonLinkButton;
            $table->save();

            session()->put('editSuccess' , 'Sửa slide thành công');
            return redirect()->back();
        } else {
            $addTable = new Slide;
            if ($get_image) {
                $get_name_image = $get_image->getClientOriginalName();
                $storedPath = $get_image->move('images_upload/slide/', $get_name_image);
                $addTable->image = $storedPath;
            }
            $addTable->sub_title = $SubTitle;
            $addTable->sub_title_text = $SubTitleText;
            $addTable->main_title = $MainTitle;
            $addTable->main_title_text = $MainTitleText;
            $addTable->text_button = $TitleButton;
            $addTable->link_button = $LinkButtonLinkButton;
            $addTable->save();

            session()->put('addSuccess' , 'Thêm slide thành công');
            return redirect()->back();
        }

        session()->put('errorSlide' , 'Thực hiện không thành công');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = Slide::find($id);
        return $result;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Slide::find($id)->delete();
        return redirect()->back();
    }
}
