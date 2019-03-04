<?php

namespace App\Modules\Argaam\Http\Controllers\Admin;

use App\Modules\Argaam\Models\ArticleImage;
use App\Modules\Argaam\Models\Category;
use Illuminate\Container\Container as Application;
use App\Modules\Generic\Http\Controllers\Admin\GenericAdminController;
use App\Modules\Argaam\Http\Requests\ArticleRequest;
use App\Modules\Argaam\Repositories\ArticleRepository;
use App\Modules\Argaam\Models\Article;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class ArticleAdminController extends GenericAdminController
{
     public $ArticleRepository;

         public function __construct()
         {
             parent::__construct();

             $this->ArticleRepository=new ArticleRepository(new Application);
         }


    public function index()
    {

        $title = 'articles List';
        $this->request_array = ['id'];
        $request_array = $this->request_array;
        foreach ($request_array as $item) $$item = request()->has($item) ? request()->$item : false;

         $articles = $this->ArticleRepository->with('category')->where('user_id', Auth::user()->id)->orderBy('id', 'DESC');

             //apply filters
        $articles->when($id, function ($query) use ($id) {
                $query->where('id','=', $id);
        });
         $search_query = request()->query();
         $articles = $articles->get();
         $total = $articles->count();

        return view('argaam::Admin.article_admin_list', compact('articles','title', 'total', 'search_query'));
    }


    private function prepareForExport($data)
    {
        return array_map(function ($row) {
            return [
                'ID' => $row['id']
            ];
        }, $data->toArray());
    }

    public function create()
    {
        $title = 'Create Article';
        $categories = Category::get();
        return view('argaam::Admin.article_admin_form', ['article' => new Article(),'categories' => $categories,'title'=>$title]);
    }

    public function store(ArticleRequest $request)
    {
        $article_inputs = $this->prepare_inputs($request->except(['_token', 'images']));
        $article = $this->ArticleRepository->create($article_inputs);

        if ($request->hasFile('images')) {
            $uploads = $request->file('images');
            foreach ($uploads as $upload) {
                $file      = new ArticleImage();
                $fileName  = time() . "-" . rand(9, 99999999) . $upload->getClientOriginalName();
                $upload->move(base_path() . '/uploads/articles/', $fileName);
                $file->article_id = $article->id;
                $file->name       = $fileName;
                $file->save();
            }
        }

        sweet_alert()->success('Done', 'Article Added successfully');
        return redirect(route('listArticle'));
    }

    public function edit($id)
    {
        $article =$this->ArticleRepository->with('images')->withTrashed()->find($id);
        if($article->user_id != Auth::user()->id)
            redirect()->back();
        $title = 'Edit Article';
        $categories = Category::get();

        return view('argaam::Admin.article_admin_form', ['article' => $article,'categories' => $categories,'title'=>$title]);
    }

    public function update(ArticleRequest $request, $id)
    {
        $article =$this->ArticleRepository->withTrashed()->find($id);
        $article_inputs = $this->prepare_inputs($request->except(['_token', 'images']));
        $article->update($article_inputs);

        if ($request->hasFile('images')) {
            $uploads = $request->file('images');
            foreach ($uploads as $upload) {
                $file      = new ArticleImage();
                $fileName  = time() . "-" . rand(9, 99999999) . $upload->getClientOriginalName();
                $upload->move(base_path() . '/uploads/articles/', $fileName);
                $file->article_id = $article->id;
                $file->name       = $fileName;
                $file->save();
            }
        }
        sweet_alert()->success('Done', 'Article Updated successfully');
        return redirect(route('listArticle'));
    }

    public function destroy($id)
      {
          $article =$this->ArticleRepository->withTrashed()->find($id);

          if($article->user_id != Auth::user()->id)
              redirect()->back();

          if($article->trashed())
          {
              $article->restore();
          }
          else
          {
              $article->delete();
          }
        sweet_alert()->success('Done', 'Article Deleted successfully');
        return redirect(route('listArticle'));
    }

    public function arrange(Request $request)
    {

        $banner_sql = 'SET `sorting` = CASE ';
        foreach ($request->chosen_item as $key => $value) {
            $banner_sql .= " WHEN `id` = " . $value . " THEN " . $key . " ";
        }
        $sql = 'UPDATE `articles` ' . $banner_sql . ' Where user_id = '. Auth::user()->id .  "END";
        DB::statement($sql);
        sweet_alert()->success('Done', 'Articles Sorted Successfully');
        return redirect(route('listArticle'));

    }

    public function deleteArticleImage($id)
    {
        $image = ArticleImage::with('article')->find($id);

        if($image->article->user_id != Auth::user()->id)
            redirect()->back();

        $image->delete();
        unlink(Article::$uploads_path.$image->name);

        sweet_alert()->success('Done', 'Image Deleted successfully');

        return redirect()->back();

    }
    private function prepare_inputs($inputs)
    {
        //$input_file = 'image';
        //$uploaded='';
        //
        //$destinationPath = base_path($this->ArticleRepository->model()::$uploads_path);
        //                $ThumbnailsDestinationPath = base_path($this->ArticleRepository->model()::$thumbnails_uploads_path);
        //
        //                if (!File::exists($destinationPath)) {
        //                    File::makeDirectory($destinationPath, $mode = 0777, true, true);
        //                }
        //                if (!File::exists($ThumbnailsDestinationPath)) {
        //                    File::makeDirectory($ThumbnailsDestinationPath, $mode = 0777, true, true);
        //                }
        //                if (request()->hasFile($input_file)) {
        //                    $file = request()->file($input_file);
        //
        //                    if (is_image($file->getRealPath())) {
        //                        $filename = rand(0, 20000) . time() . '.' . $file->getClientOriginalExtension();
        //
        //
        //                        $uploaded = $filename;
        //
        //                        $img = Image::make($file);
        //                        $original_width = $img->width();
        //                        $original_height = $img->height();
        //
        //                        if ($original_width > 1200 || $original_height > 900) {
        //                            if ($original_width < $original_height) {
        //                                $new_width = 1200;
        //                                $new_height = ceil($original_height * 900 / $original_width);
        //                            } else {
        //                                $new_height = 900;
        //                                $new_width = ceil($original_width * 1200 / $original_height);
        //                            }
        //
        //                            //save used image
        //                            $img->encode('jpg', 90)->save($destinationPath . $filename);
        //                            $img->resize($new_width, $new_height, function ($constraint) {
        //                                $constraint->aspectRatio();
        //                            })->encode('jpg', 90)->save($destinationPath . '' . $filename);
        //
        //                            //create thumbnail
        //                            if ($original_width < $original_height) {
        //                                $thumbnails_width = 400;
        //                                $thumbnails_height = ceil($new_height * 300 / $new_width);
        //                            } else {
        //                                $thumbnails_height = 300;
        //                                $thumbnails_width = ceil($new_width * 400 / $new_height);
        //                            }
        //                            $img->resize($thumbnails_width, $thumbnails_height, function ($constraint) {
        //                                $constraint->aspectRatio();
        //                            })->encode('jpg', 90)->save($ThumbnailsDestinationPath . '' . $filename);
        //                        } else {
        //                            //save used image
        //                            $img->encode('jpg', 90)->save($destinationPath . $filename);
        //                            //create thumbnail
        //                            if ($original_width < $original_height) {
        //                                $thumbnails_width = 400;
        //                                $thumbnails_height = ceil($original_height * 300 / $original_width);
        //                            } else {
        //                                $thumbnails_height = 300;
        //                                $thumbnails_width = ceil($original_width * 400 / $original_height);
        //                            }
        //                            $img->resize($thumbnails_width, $thumbnails_height, function ($constraint) {
        //                                $constraint->aspectRatio();
        //                            })->encode('jpg', 90)->save($ThumbnailsDestinationPath . '' . $filename);
        //                        }
        //                        $inputs[$input_file]=$uploaded;
        //                    }
        //
        //                }


        !$inputs['deleted_at']?$inputs['deleted_at']=null:'';

        return $inputs;
    }

}
