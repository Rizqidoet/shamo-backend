<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function all(Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('name');
        $show_product = $request->input('show_product');
        $limit = $request->input('limit');

        if ($id) {
            $category = ProductCategory::with(['products'])->find($id);

            if ($category) {
                ResponseFormatter::success($category, 'Data Produk Berhasil Diambil');
            } else {
                ResponseFormatter::error(null, 'Data Produk Tidak Ada', 404);
            }
        }

        $category = ProductCategory::query();

        if ($id) {
            $category->where('id', $id);
        }
        if ($name) {
            $category->where('name', 'like', '%' . $name . '%');
        }

        if ($show_product) {
            $category->with('products');
        }

        return ResponseFormatter::success($category->paginate($limit), 'Data Kategori Berhasil Diambil');
    }
}
