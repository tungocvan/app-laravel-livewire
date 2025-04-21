<?php

namespace App\Livewire\Products;

use Livewire\Component;
use App\Models\WpPost;
use App\Models\WpPostMeta;
use App\Models\WpTerm;
use App\Models\WpTermTaxonomy;
use App\Models\WpTermRelationship; 
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AddProduct extends Component
{
    use WithFileUploads;

    public $name;
    public $description;
    public $image;
    public $gallery = [];
    public $categories = '';
    public $regularPrice;
    public $salePrice;
    public $shortDescription;
    public $tags = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'image' => 'required|image|max:2048',
        'regularPrice' => 'required|numeric|min:0',
        'salePrice' => 'nullable|numeric|lt:regularPrice',
        'shortDescription' => 'required|string|max:500',
        'categories' => 'required|string',
        'tags' => 'nullable|string',
    ];

    protected $messages = [
        'salePrice.lt' => 'The sale price must be less than regular price.',
    ];

    public function render()
    {
        $allCategories = DB::table('wp_terms')
            ->join('wp_term_taxonomy', 'wp_terms.term_id', '=', 'wp_term_taxonomy.term_id')
            ->where('wp_term_taxonomy.taxonomy', 'product_cat')
            ->select('wp_terms.term_id', 'wp_terms.name')
            ->get();

        return view('livewire.products.add-product', [
            'allCategories' => $allCategories,
        ]);
    }

    public function submit()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'shortDescription' => 'required|string|max:1000',
            'categories' => 'required|numeric',
            'regularPrice' => 'required|numeric',
            'image' => 'required|image|max:2048', // 2MB
            'gallery.*' => 'nullable|image|max:2048',
        ]);

        // Upload main image
        $imagePath = $this->image->store('products', 'public');

        // Insert to wp_posts
        $postId = DB::table('wp_posts')->insertGetId([
            'post_author'      => 1,
            'post_date'        => Carbon::now(),
            'post_date_gmt'    => Carbon::now('UTC'),
            'post_content'     => $this->description ?? '',
            'post_title'       => $this->name,
            'post_excerpt'     => $this->shortDescription,
            'post_status'      => 'publish',
            'comment_status'   => 'open',
            'ping_status'      => 'open',
            'to_ping' => '',  // Thêm giá trị mặc định
            'pinged' => '',   // Thêm giá trị mặc định
            'post_content_filtered' => '', // Thêm giá trị mặc định
            'post_name'        => Str::slug($this->name),
            'post_modified'    => Carbon::now(),
            'post_modified_gmt' => Carbon::now('UTC'),
            'guid'             => url('storage/' . $imagePath),
            'post_type'        => 'product',
        ]);

        // Insert meta data (price, sale price, image)
        DB::table('wp_postmeta')->insert([
            ['post_id' => $postId, 'meta_key' => '_regular_price', 'meta_value' => $this->regularPrice],
            ['post_id' => $postId, 'meta_key' => '_price', 'meta_value' => $this->salePrice ?? $this->regularPrice],
            ['post_id' => $postId, 'meta_key' => '_thumbnail_id', 'meta_value' => $imagePath],
        ]);

        // (Optional) Upload gallery images
        if (!empty($this->gallery)) {
            foreach ($this->gallery as $file) {
                $file->store('products/gallery', 'public');
                // Nếu cần lưu thêm gallery path hoặc gắn vào postmeta, xử lý ở đây
            }
        }

        // Xử lý danh mục
        $this->saveTerms($postId, $this->categories, 'product_cat');
        // Xử lý thẻ
         if (!empty($this->tags)) {
            $this->saveTerms($postId, $this->tags, 'product_tag');
        }
        // Thông báo thành công
        session()->flash('success', 'Product added successfully!');
        $this->reset();
    }

    protected function processGalleryImages($productId)
    {
        if (empty($this->gallery)) {
            return '';
        }

        $galleryIds = [];
        foreach ($this->gallery as $image) {
            $imagePath = $image->store('products/gallery', 'public');
            
            $attachment = WpPost::create([
                'post_author' => auth()->id() ?? 1,
                'post_title' => $this->name . ' Gallery Image',
                'post_status' => 'inherit',
                'post_type' => 'attachment',
                'guid' => asset('storage/' . $imagePath),
                'post_mime_type' => $image->getMimeType(),
                'post_name' => 'product-' . $productId . '-gallery-' . count($galleryIds),
                'post_content' => '',
                'post_date' => now(),
                'post_date_gmt' => now(),
            ]);

            $galleryIds[] = $attachment->id;
        }

        return implode(',', $galleryIds);
    }

    protected function saveTerms($productId, $terms, $taxonomy)
    {
        $termIds = [];
        $termsArray = array_filter(array_map('trim', explode(',', $terms)));

        foreach ($termsArray as $term) {
            $termSlug = Str::slug($term);

            // Kiểm tra xem term đã tồn tại chưa
            $existingTerm = WpTerm::where('slug', $termSlug)->first();

            if ($existingTerm) {
                $termId = $existingTerm->id;
            } else {
                // Tạo term mới
                $term = WpTerm::create([
                    'name' => $term,
                    'slug' => $termSlug,
                    'term_group' => 0,
                ]);

                // Tạo term taxonomy
                WpTermTaxonomy::create([
                    'term_id' => $term->id,
                    'taxonomy' => $taxonomy,
                    'description' => '',
                    'parent' => 0,
                    'count' => 0,
                ]);

                $termId = $term->id;
            }

            $termIds[] = $termId;
        }

        // Gán terms cho sản phẩm
        foreach ($termIds as $termId) {
            WpTermRelationship::create([
                'object_id' => $productId,
                'term_taxonomy_id' => $termId,
                'term_order' => 0,
            ]);
        }
    }

    public function getCategories()
    {
        return WpTerm::join('wp_term_taxonomy', 'wp_terms.term_id', '=', 'wp_term_taxonomy.term_id')
            ->where('wp_term_taxonomy.taxonomy', 'product_cat')
            ->select('wp_terms.term_id', 'wp_terms.name')
            ->orderBy('wp_terms.name')
            ->get();
    }
}