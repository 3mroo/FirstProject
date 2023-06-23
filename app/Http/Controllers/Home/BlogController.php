<?php

namespace App\Http\Controllers\Home;

use Image;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class BlogController extends Controller
{
    public function AllBlog()
    {
        $blogs = Blog::latest()->get();
        return view('admin.blogs.blogs_all', compact('blogs'));
    }//end

    public function AddBlog()
    {
        $categories = BlogCategory::orderBy('blog_category','ASC')->get();
        return view('admin.blogs.blogs_add',compact('categories'));
    }//end

    public function StoreBlog(Request $request)
    {
        $image = $request->file('blog_image');
        $nam_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

        Image::make($image)->resize(430, 327)->save('upload/blogs/' . $nam_gen);
        $save_url = 'upload/blogs/' . $nam_gen;

        Blog::insert([
            'blog_category_id' => $request->blog_category_id,
            'blog_title' => $request->blog_title,
            'blog_tags' => $request->blog_tags,
            'blog_description' => $request->blog_description,
            'blog_image' => $save_url,
            'created_at' => Carbon::now(),
        ]);
        $notification = array(
            'message' => 'Blog Insrered Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.blog')->with($notification);
    } //end

    public function EditBlog($id)
    {
        $blogs = Blog::findOrFail($id);
        $categories = BlogCategory::orderBy('blog_category', 'ASC')->get();
        return view('admin.blogs.blog_edit', compact('blogs', 'categories'));
    }//end

    public function UpdateBlog(Request $request)
    {
        $blog_id = $request->id;
        if ($request->file('blog_image')) {
            $image = $request->file('blog_image');
            $nam_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

            Image::make($image)->resize(430, 327)->save('upload/blogs/' . $nam_gen);
            $save_url = 'upload/blogs/' . $nam_gen;

            Blog::findOrFail($blog_id)->update([
                'blog_category_id' => $request->blog_category_id,
                'blog_title' => $request->blog_title,
                'blog_tags' => $request->blog_tags,
                'blog_description' => $request->blog_description,
                'blog_image' => $save_url,
            ]);
            $notification = array(
                'message' => 'Blog Updated With Image',
                'alert-type' => 'success'
            );
            return redirect()->route('all.blog')->with($notification);
        } else {
            Blog::findOrFail($blog_id)->update([
                'blog_category_id' => $request->blog_category_id,
                'blog_title' => $request->blog_title,
                'blog_tags' => $request->blog_tags,
                'blog_description' => $request->blog_description,
            ]);
            $notification = array(
                'message' => 'Blog Updated Without Image',
                'alert-type' => 'success'
            );
            return redirect()->route('all.blog')->with($notification);
        }

    }//end

    public function DeleteBlog($id)
    {
        $blog = Blog::findOrFail($id);
        $img = $blog->blog_image;
        unlink($img);

        Blog::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Blog Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.blog')->with($notification);
    }//end

    public function BlogDetails($id)
    {
        $allblogs = Blog::latest()->limit(5)->get();
        $blogs = Blog::findOrFail($id);
        $categories = BlogCategory::orderBy('blog_category', 'ASC')->get();
        return view('frontend.blog_details',compact('blogs','allblogs', 'categories'));
    }////

    public function CategoryBlog($id)
    {
        $allblogs = Blog::latest()->limit(5)->get();
        $blogpost = Blog::where('blog_category_id',$id)->orderBy('id','DESC')->get();
        $categories = BlogCategory::orderBy('blog_category','ASC')->get();
        $categoryname = BlogCategory::findORFail($id);
        return view('frontend.cat_blog_details',compact('blogpost','categories', 'allblogs', 'categoryname'));
    }///////

    public function HomeBlog()
    {
        $allblogs = Blog::latest()->paginate(3);
        $categories = BlogCategory::orderBy('blog_category', 'ASC')->get();
        return view('frontend.blog',compact('allblogs', 'categories'));
    }
}
