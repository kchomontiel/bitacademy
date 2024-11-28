<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CourseCategory;

class HomeController extends Controller
{
    public function index()
    {
        $category = CourseCategory::get();
        $data = [];
        if ($category) {
            foreach ($category as $cat) {
                $data[] = [
                    'id' => $cat->id,
                    'category_name' => $cat->category_name,
                    'category_status' => $cat->category_status,
                    'category_image' => asset('public/uploads/courseCategories/'.$cat->category_image),
                ];
            }
        }

        return response($data, 200);
    }
}
