<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseCategory;
use Illuminate\Http\Request;

class SearchCourseController extends Controller
{
    public function index(Request $request)
    {

        $category = CourseCategory::get();
        $selectedCategories = $request->input('categories', []);

        $course = Course::where('status', 2)->when($selectedCategories, function ($query) use ($selectedCategories) {
            $query->whereIn('course_category_id', $selectedCategories);
        })->get();

        $allCourse = Course::where('status', 2)->get();

        return view('frontend.searchCourse', compact('course', 'category', 'selectedCategories', 'allCourse'));
    }
}
