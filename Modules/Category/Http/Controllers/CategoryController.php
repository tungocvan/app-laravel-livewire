<?php

namespace Modules\Category\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\Category\Models\WpTerm;
use Modules\Category\Models\WpTermTaxonomy;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
         $this->middleware('permission:category-list|category-create|category-edit|category-delete', ['only' => ['index','show']]);
         $this->middleware('permission:category-create', ['only' => ['create','store']]);
         $this->middleware('permission:category-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:category-delete', ['only' => ['destroy']]);
    }
    public function index($taxonomy='uncategory'){      
        $categories = WpTermTaxonomy::where('taxonomy', $taxonomy)
        ->join('wp_terms', 'wp_terms.term_id', '=', 'wp_term_taxonomy.term_id')
        ->select('wp_terms.name','wp_terms.slug', 'wp_terms.term_id', 'wp_term_taxonomy.parent', 'wp_term_taxonomy.description')
        ->get();

        // Lấy tên danh mục cha
        foreach ($categories as $category) {
            if ($category->parent != 0) {
                $category->parent_name = WpTerm::where('term_id', $category->parent)->value('name');
            } else {
                $category->parent_name = 'Không có';
            }
        }

        $parentCategories = $this->buildCategoryTree($categories);

        return view('Category::category',compact('parentCategories','categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function bulkDelete(Request $request)
    {
        // Kiểm tra xem có danh mục nào được chọn không
        if ($request->has('categories')) {
            // Lấy danh sách ID của các danh mục được chọn
            $categoryIds = $request->input('categories');

            // Xóa các bản ghi liên quan trong bảng wp_term_taxonomy
            WpTermTaxonomy::whereIn('term_id', $categoryIds)->delete();

            // Xóa các bản ghi trong bảng wp_terms
            WpTerm::whereIn('term_id', $categoryIds)->delete();

            return redirect()->route('category.index')->with('success', 'Đã xóa các danh mục được chọn.');
        }

        return redirect()->route('category.index')->with('error', 'Vui lòng chọn ít nhất một danh mục.');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->parent =  is_numeric($request->parent) ? (int) $request->parent : 0;
        //
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255', // slug có thể null
            'parent' => 'nullable|integer',
            'description' => 'nullable|string',
        ]);

        // Kiểm tra nếu slug trống thì tự động tạo slug từ name
        $slug = $request->input('slug');
        if (empty($slug)) {
            $slug = Str::slug($request->input('name')); // Tạo slug từ name
        }

        if($request->term_id){
            $category = WpTerm::find($request->term_id); // Lấy danh mục theo ID
            if ($category) {
                $category->name = $request->name;
                $category->slug = $slug;
                $category->save(); // Lưu lại thay đổi

                // Cập nhật danh mục cha nếu có
                if ($request->has('parent')) {
                    $WpTermTaxonomy = WpTermTaxonomy::where('term_id',$request->term_id)->first();
                    $WpTermTaxonomy->parent = $request->parent ?? 0;
                    $WpTermTaxonomy->description = $request->input('description') ?? '';
                    $WpTermTaxonomy->save();
                }



                return redirect()->route('category.index')->with('success', 'Cập nhật danh mục thành công.');
            }else{
                return redirect()->route('category.index')->with('success', 'Cập nhật danh mục không thành công.');
            }
        }

        //$request->parent= (number)$request->input('parent');





        // Tạo mới WpTerm
        $wpTerm = WpTerm::create([
            'name' => $request->input('name'),
            'slug' => $slug, // Sử dụng slug đã kiểm tra
            'term_group' => 0, // Có thể bỏ qua hoặc thay đổi nếu cần
        ]);

        // Tạo mới WpTermTaxonomy
        WpTermTaxonomy::create([
            'term_id' => $wpTerm->term_id,
            'taxonomy' => 'product_cat', // Định nghĩa taxonomy là 'category'
            'description' => $request->input('description') ?? '',
            'parent' => $request->parent ,
            'count' => 0, // Khởi tạo count là 0
        ]);
        return redirect()->route('category.index')->with('success', 'Chuyên mục đã được thêm thành công.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    private function buildCategoryTree($categories, $parent = 0, $depth = 0)
{
    $result = [];

    foreach ($categories as $category) {
        if ($category->parent == $parent) {
            $result[$category->term_id] = str_repeat('--', $depth) . ' ' . $category->name;
            $result += $this->buildCategoryTree($categories, $category->term_id, $depth + 1);
        }
    }

    return $result;
}
}
