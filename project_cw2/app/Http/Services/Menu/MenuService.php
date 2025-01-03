<?php


namespace App\Http\Services\Menu;


use App\Models\Menu;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class MenuService
{
    public function getParent()
    {
        return Menu::where('parent_id', 0)->get();
    }

    public function show()
    {
        return Menu::select('name', 'id', 'thumb')
            ->where('parent_id', 0)
            ->orderbyDesc('id')
            ->get();
    }

    public function getAll()
    {
        return Menu::orderBy('id')->paginate(2);
    }

    public function create($request)
    {
        try {

            $menu = new Menu();
            $menu->name = (string)$request->input('name');
            $menu->parent_id = (int)$request->input('parent_id');
            $menu->description = (string)$request->input('description');
            $menu->content = (string)$request->input('content');
            $menu->active = (string)$request->input('active');
            if ($request->hasFile('thumb')){
                $file = $request->file('thumb');
                $ext = $file->getClientOriginalExtension();
                $filename= time().'.'.$ext;
                $file->move('thumb',$filename);
                $menu->thumb = $filename;

            }



            $menu->save();

            Session::flash('success', 'Tạo Danh Mục Thành Công');
        } catch (\Exception $err) {
            Session::flash('error', $err->getMessage());
            return false;
        }

        return true;
    }
    
    public function update($request, $menu): bool
    {
        if ($request->input('parent_id') != $menu->id) {
            $menu->parent_id = (int)$request->input('parent_id');
        }

        $menu->name = (string)$request->input('name');
        $menu->description = (string)$request->input('description');
        $menu->content = (string)$request->input('content');
        $menu->active = (string)$request->input('active');
        $menu->save();

        Session::flash('success', 'Cập nhật thành công Danh mục');
        return true;
    }
// xoa danh muc theo id
    public function destroy($request)
    {
        $id = (int)$request->input('id');
        $menu = Menu::where('id', $id)->first();
        if ($menu) {
            return Menu::where('id', $id)->orWhere('parent_id', $id)->delete();
        }

        return false;
    }

//tìm id đầu tiên nếu ko tìm thấy thông báo lỗi 404
    public function getId($id)
    {
        return Menu::where('id', $id)->where('active', 1)->firstOrFail();
    }


    public function getProduct($menu, $request)
    {
        $query = $menu->products()
            ->select('id', 'name', 'price', 'price_sale', 'thumb')
            ->where('active', 1);

        if ($request->input('price')) {
            $query->orderBy('price', $request->input('price'));
        }

        return $query
            ->orderByDesc('id')
            ->paginate(12)
            ->withQueryString();
    }
}
