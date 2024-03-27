<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Blog;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class BlogController extends Controller
{
    public function index(){
    $blogs = Blog::orderBy('created_at', 'desc')->paginate(5);
    return view('blogs', compact('blogs'));
}

    public function create(){
        return view('blogs');
    }
    public function store(Request $request)
    {
        $request->validate([
            'blog_tag' => 'required',
            'blog_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'blog_title' => 'required',
            'blog_message' => 'required',
        ]);

        $imageName = ''; // Initialize image name variable

        // Handle file upload
        if ($request->hasFile('blog_image')) {
            $image = $request->file('blog_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('blogs_res/img'), $imageName);
        }

        // Create blog with file path
        Blog::create([
            'blog_tag' =>$request->input('blog_tag'),
            'blog_image' => $imageName,
            'blog_title' => $request->input('blog_title'),
            'blog_message' => $request->input('blog_message'),
        ]);
        return redirect()->route('blogs_admindash')->with('success', [
            'message' => 'Blog Created Successfully!',
            'duration' => 3000,
        ]);
    }
    public function show($id)
    {
        return view('blogs');
    }
    public function edit($id)
    {
        $blog = Blog::find($id);

        return view('blogs_editdash', ['blog' => $blog]);
    }
    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $imageName = ''; // Initialize image name variable

        // Handle file upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('blogs_res/img'), $imageName);
        }

        //validate the inputs
        $request->validate([
            'blog_image' => 'required|image',
            'blog_tag' => 'required',
            'blog_title' => 'required',
            'blog_message' => 'required',
        ]);

        $blog->blog_image = $request->file('blog_image')->store('public/blogs');
        $blog->blog_tag = $request->blog_tag;
        $blog->blog_title = $request->blog_title;
        $blog->blog_message = $request->blog_message;

        $blog->save();

        return redirect('/blogs_admindash')->with('success', [
            'message' => 'Blog Updated Successfully!',
            'duration' => 3000,
        ]);
    }
    
    public function destroy($id)
    {
        $blog = Blog::find($id);
        $blog->delete();
        return redirect()->route('blogs_admindash')->with('success', 'Blog deleted successfully.');
    }
    public function showUserHome()
    {
        $blogs = Blog::orderBy('created_at', 'desc')->take(7)->get();
        return view('userhome', ['blogs' => $blogs]);
    }
    public function view($id, $title){
    $blog = Blog::findOrFail($id);
    return view('blog_view', compact('blog'));
}


}
