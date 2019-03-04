@extends('generic::layouts.form')
@section('breadcrumb')
    <ul class="page-breadcrumb breadcrumb">
        <li>
            <a href="{{ url('/operate') }}">Dashboard</a>
             <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="{{ route('listArticle') }}">Articles</a>
             <i class="fa fa-circle"></i>
        </li>
        <li>{{ $title }}</li>
    </ul>
@endsection
@section('form_title') {{ @$title }} @endsection
@section('page_body')
    <form method="post" action="" class="form-horizontal" role="form" enctype="multipart/form-data">
     <div class="form-body">
        {{csrf_field()}}
    <div class="form-group col-md-6">
    <label class="col-md-3 control-label">Title</label>
    <div class="col-md-9">
        <input id="title" value="{{ old('title', $article->title) }}"
               name="title" type="text" class="form-control" >
    </div>
</div>

         <div class="form-group col-md-6">
             <label class="col-md-3 control-label">Category</label>
             <div class="col-md-9">
                 <select id="category_id" name="category_id" class="bs-select form-control" data-live-search="true" >
                     <option>Choose Category</option>
                     @foreach($categories as $item)
                         <option
                                 {{ old('category_id', $article->category_id)==$item->id?'selected':'' }}
                                 value="{{ $item->id }}">{{ $item->name }}</option>
                     @endforeach
                 </select>
             </div>
         </div>
<div style="clear: both;"></div>

         <div class="form-group col-md-12">
             <label class="col-md-3 control-label">Content</label>
             <div class="col-md-9">
                 <textarea id="content"
                           name="content" class="form-control input-data summernote-textarea" >{{ old('content', $article->content) }}</textarea>
             </div>
         </div>


         <div style="clear: both;"></div>

         <div class="form-group col-md-12">
             <label class=" control-label text-right"><strong>Images</strong></label>
         </div>
         <div class="form-group col-md-12">
             <div class="mt-checkbox-list">
                 <input type="file" @if(count($article->images) == 0) required @endif name="images[]" multiple>
             </div>
             <hr />

             @if(isset($article->images))
                 @foreach($article->images as $image)
                     <div class="form-group col-md-4">
                         <div class="mt-checkbox-list"  style="padding: 10px 0 2px 0;">
                             <img style="height: 120px;width:120px;object-fit: contain;" src="{{asset(\App\Modules\Argaam\Models\Article::$uploads_path.$image->name)}}">
                             <br/><br/><a href="{{route('deleteArticleImage', $image->id)}}"><li class="fa fa-remove"></li> delete</a>
                         </div>
                         <div>

                         </div>
                     </div>
                 @endforeach
             @endif
         </div>




    <div class="form-group col-md-6" style="clear:both;">
        <label class="col-md-3 control-label">Disable</label>
        <div class="col-md-9">
            <div class="mt-checkbox-list">
                <label class="mt-checkbox mt-checkbox-outline">
                    <input type="hidden" name="deleted_at" value="">
                    <input type="checkbox" value="{{ date('Y-m-d') }}" name="deleted_at"
                            {{ $article->trashed()?'checked':'' }}>
                    <span></span>
                </label>
            </div>
        </div>

    </div>

    <div class="form-actions" style="clear:both;">
        <div class="row">
            <div class="col-md-offset-3 col-md-9">
                <button type="submit" class="btn green">Submit</button>
                <input type="reset" class="btn default" value="Reset">
            </div>
        </div>
    </div>
    </div>
    </form>
@endsection
