
@extends('admin.admin_master')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

<div class="page-content">
<div class="container-fluid">

<div class="row">
<div class="col-12">
<div class="card">
    <div class="card-body">

        <form method="post" action="{{ route('Update.blog.category',$blogcategory->id) }} " >
            @csrf


        <h4 class="card-title">Blog Category Page</h4>

                <div class="row mb-3">
            <label for="example-text-input" class="col-sm-2 col-form-label">Edit Blog Category Name</label>
            <div class="col-sm-10">
                <input name="blog_category" class="form-control" type="text" value="{{ $blogcategory->blog_category }}" id="example-text-input">
            </div>
        </div>
        <!-- end row -->




<input type="submit" class="btn btn-info waves-effect waves-light" value="Updated Blog Data">
        </form>

    </div>
</div>
</div> <!-- end col -->
</div>

</div>
</div>




@endsection

