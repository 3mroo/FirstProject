<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\MultiImage;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Image;

class AboutController extends Controller
{
    public function AboutPage()
    {
        $aboutpage = About::find(1);
        return view ('admin.about_page.about_page_all',compact('aboutpage'));
    } //end

    public function UpdateAbout(Request $request)
    {
        $about_id = $request->id;
        if ($request->file('about_image')) {
            $image = $request->file('about_image');
            $nam_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

            Image::make($image)->resize(523, 605)->save('upload/home_about/' . $nam_gen);
            $save_url = 'upload/home_about/' . $nam_gen;

            About::findOrFail($about_id)->update([
                'title' => $request->title,
                'short_title' => $request->short_title,
                'short_description' => $request->short_description,
                'long_description' => $request->long_description,
                'about_image' => $save_url,
            ]);
            $notification = array(
                'message' => 'About Page Updated With Image',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        } else {
            About::findOrFail($about_id)->update([
                'title' => $request->title,
                'short_title' => $request->short_title,
                'short_description' => $request->short_description,
                'long_description' => $request->long_description,
            ]);
            $notification = array(
                'message' => 'About Page Updated Without Image',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        }
    }//end

    public function HomeAbout()
    {
        $aboutpage = About::find(1);
        return view('frontend.about_page',compact('aboutpage'));
    }//end

    public function AboutMultiImage()
    {
        return view('admin.about_page.multiimage');
    }//end

    public function StoreMultiImage(Request $request)
    {
        // dd($request);
        $image = $request->file('multi_image');
        foreach ($image as $multi_image) {
            $nam_gen = hexdec(uniqid()) . '.' . $multi_image->getClientOriginalExtension();

            Image::make($multi_image)->resize(220,220)->save('upload/multi/'. $nam_gen);
            $save_url = 'upload/multi/' .$nam_gen;

            MultiImage::insert([

                'multi_image' => $save_url,
                'created_at' => Carbon::now()
            ]);

        }
            $notification = array(
                'message' => 'Multi Image Inserted Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('all.multi.image')->with($notification);


    }//end

    public function AllMultiImage()
    {
        $allMultiImage = MultiImage::all();
        return view('admin.about_page.all_multiimage',compact('allMultiImage'));
    }//end

    public function EditMultiImage($id)
    {
        $allMultiImage = MultiImage:: findOrFail($id);
        return view('admin.about_page.edit_page_all',compact('allMultiImage'));
    }//end

    public function UpdateMultiImage(Request $request)
    {
        $multi_image_id = $request->id;
        if ($request->file('multi_image')) {
            $image = $request->file('multi_image');
            $nam_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

            Image::make($image)->resize(220, 220)->save('upload/multi/' . $nam_gen);
            $save_url = 'upload/multi/' . $nam_gen;

            MultiImage::findOrFail( $multi_image_id)->update([
                'multi_image' => $save_url,
            ]);
            $notification = array(
                'message' => 'Multi Image Updated Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('all.multi.image')->with($notification);
        }
    }//end

    public function DeleteMultiImage( $id)
    {
        $multi = MultiImage::findOrFail($id);
        $img = $multi->multi_image;
        unlink($img);

        MultiImage::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Multi Image Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

}
