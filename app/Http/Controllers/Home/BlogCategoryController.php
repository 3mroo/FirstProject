<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Image;

class BlogCategoryController extends Controller
{
    public function AllBlogCategory()
    {
        $blogcategory = BlogCategory::latest()->get();
        return view ('admin.blog_category.blog_category_all',compact('blogcategory'));
    }//end

    public function AddBlogCategory()
    {
       return view('admin.blog_category.blog_category_add');
    }//end

    public function StoreBlogCategory(Request $request)
    {

        // $request->validate([
        //     'blog_category' => 'required',
        // ], [
        //     'blog_category.required' => 'Blog Name is Required',
        // ]);

        BlogCategory::insert([
            'blog_category' => $request->blog_category,
        ]);
        $notification = array(
            'message' => 'Blog Category Insrered Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.blog.category')->with($notification);

    }//end

    public function EditBlogCategory($id)
    {
        $blogcategory= BlogCategory::findOrFail($id);
        return view('admin.blog_category.blog_category_edit',compact('blogcategory'));
    }//////////////


    public function UpdateBlogCategory(Request $request)
    {

        $blogcategory_id = $request->id;
        BlogCategory::findOrFail($blogcategory_id)->update([
            'blog_category' => $request->blog_category,
        ]);
        $notification = array(
            'message' => 'Blog Category Updated ',
            'alert-type' => 'success'
        );
        return redirect()->route('all.blog.category')->with($notification);

    } //end

    public function DeleteBlogCategory($id)
    {
        BlogCategory::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Blog Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.blog.category')->with($notification);
    }//end


}
