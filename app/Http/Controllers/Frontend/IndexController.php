<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\Item;

class IndexController extends Controller
{
    //
    public function getIndex(){
        $category = Group::where('module','san-pham')->with(['product'])->inRandomOrder()->get();
        $trend = Item::inRandomOrder()->where('module','san-pham')->paginate(5);
        $run = Item::inRandomOrder()->where('module','san-pham')->paginate(5);
        $hight = Item::inRandomOrder()->where('module','san-pham')->paginate(5);
        // dd($category);
        return view('frontend.pages.index',compact('category','trend','run','hight'));
    }

    public function details($slug){
        $data=  Item::where('module','san-pham')->where('slug',$slug)->first();
        // dd($data);
        $image_extension = json_decode($data->image_extension);
        // dd($image_extension);
        $product = Item::where('module','san-pham')->where('slug',$slug)->get();
        foreach($product as $item){
            $id = $item->parrent_id;
        }
        $product_item = Item::where('module','san-pham')->where('parrent_id',$id)->inRandomOrder()->paginate(4);
        // dd($product_item);
        return view('frontend.pages.details',compact('data','product_item','image_extension'));
    }
    
    public function details_id($id){
        $data= Item::where('module','san-pham')->where('id',$id)->first();
        if(isset($data)) {
            $cat = $data->category->title;
            $size = json_decode($data->size);
            $color = json_decode($data->color);
            return response()->json(['data' => $data,'cat' => $cat,'size' => $size,'color' => $color]);
        }   
        return response()->json(['errorCode' => 0, 'mess' => 'Thất bại', 'data' => null]);
    }


    public function product(){
        $highlights = Item::where('module','san-pham')->inRandomOrder()->paginate(9);
        $selling = Item::where('module','san-pham')->inRandomOrder()->paginate(12);
        $category = Group::where('module','san-pham')->inRandomOrder()->get();
        return view('frontend.pages.product',compact('highlights','selling','category'));
    }

    public function category($slug){
        $slug= Group::where('module','san-pham')->where('slug',$slug)->first();
        $name = $slug->title;
        $data = Item::where('module','san-pham')->where('parrent_id',$slug->id)->paginate(12);
        $category = Group::where('module','san-pham')->inRandomOrder()->get();
        return view('frontend.pages.category',compact('data','category','name'));
    }

    public function contact(){
        return view('frontend.pages.contact');
    }

    public function policy(){
        return view('frontend.pages.policy');
    }
}
