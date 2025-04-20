<?php

namespace App\Livewire\Products;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

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
        return view('livewire.products.add-product', [
            'allCategories' => $this->getCategories(),
        ]);
    }

    public function submit()
    {
        $this->validate();

        DB::transaction(function () {
            // Save product to wp_posts
            $productId = DB::table('wp_posts')->insertGetId([
                'post_author' => auth()->id() ?? 1,
                'post_title' => $this->name,
                'post_content' => $this->description,
                'post_excerpt' => $this->shortDescription,
                'post_status' => 'publish',
                'post_type' => 'product',
                'comment_status' => 'closed',
                'ping_status' => 'closed',
                'post_name' => Str::slug($this->name),
                'post_date' => now(),
                'post_date_gmt' => now(),
                'post_modified' => now(),
                'post_modified_gmt' => now(),
            ]);

            // Save product image
            if ($this->image) {
                $imagePath = $this->image->store('products', 'public');
                
                // Insert to wp_posts as attachment
                $attachmentId = DB::table('wp_posts')->insertGetId([
                    'post_author' => auth()->id() ?? 1,
                    'post_title' => $this->name . ' Image',
                    'post_status' => 'inherit',
                    'post_type' => 'attachment',
                    'guid' => asset('storage/' . $imagePath),
                    'post_mime_type' => $this->image->getMimeType(),
                    'post_name' => 'product-' . $productId . '-image',
                    'post_date' => now(),
                    'post_date_gmt' => now(),
                ]);

                // Save as thumbnail
                DB::table('wp_postmeta')->insert([
                    'post_id' => $productId,
                    'meta_key' => '_thumbnail_id',
                    'meta_value' => $attachmentId,
                ]);
            }

            // Save product meta data
            $meta_data = [
                '_regular_price' => $this->regularPrice,
                '_price' => $this->salePrice ?: $this->regularPrice,
                '_sale_price' => $this->salePrice,
                '_stock_status' => 'instock',
                '_manage_stock' => 'no',
                '_tax_status' => 'taxable',
                '_tax_class' => '',
                '_visibility' => 'visible',
                '_sku' => 'SKU-' . $productId,
                '_product_image_gallery' => $this->processGalleryImages($productId),
            ];

            foreach ($meta_data as $key => $value) {
                if ($value !== null) {
                    DB::table('wp_postmeta')->insert([
                        'post_id' => $productId,
                        'meta_key' => $key,
                        'meta_value' => $value,
                    ]);
                }
            }

            // Process categories
            $this->saveTerms($productId, $this->categories, 'product_cat');

            // Process tags
            if (!empty($this->tags)) {
                $this->saveTerms($productId, $this->tags, 'product_tag');
            }
        });

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
            
            $attachmentId = DB::table('wp_posts')->insertGetId([
                'post_author' => auth()->id() ?? 1,
                'post_title' => $this->name . ' Gallery Image',
                'post_status' => 'inherit',
                'post_type' => 'attachment',
                'guid' => asset('storage/' . $imagePath),
                'post_mime_type' => $image->getMimeType(),
                'post_name' => 'product-' . $productId . '-gallery-' . count($galleryIds),
                'post_date' => now(),
                'post_date_gmt' => now(),
            ]);

            $galleryIds[] = $attachmentId;
        }

        return implode(',', $galleryIds);
    }

    protected function saveTerms($productId, $terms, $taxonomy)
    {
        $termIds = [];
        $termsArray = array_filter(array_map('trim', explode(',', $terms)));

        foreach ($termsArray as $term) {
            $termSlug = Str::slug($term);

            // Check if term exists
            $existingTerm = DB::table('wp_terms')->where('slug', $termSlug)->first();

            if ($existingTerm) {
                $termId = $existingTerm->term_id;
            } else {
                // Create new term
                $termId = DB::table('wp_terms')->insertGetId([
                    'name' => $term,
                    'slug' => $termSlug,
                    'term_group' => 0,
                ]);

                // Create term taxonomy
                DB::table('wp_term_taxonomy')->insert([
                    'term_id' => $termId,
                    'taxonomy' => $taxonomy,
                    'description' => '',
                    'parent' => 0,
                    'count' => 0,
                ]);
            }

            $termIds[] = $termId;
        }

        // Assign terms to product
        foreach ($termIds as $termId) {
            DB::table('wp_term_relationships')->insert([
                'object_id' => $productId,
                'term_taxonomy_id' => $termId,
                'term_order' => 0,
            ]);
        }
    }

    public function getCategories()
    {
        return DB::table('wp_terms')
            ->join('wp_term_taxonomy', 'wp_terms.term_id', '=', 'wp_term_taxonomy.term_id')
            ->where('wp_term_taxonomy.taxonomy', 'product_cat')
            ->select('wp_terms.term_id', 'wp_terms.name')
            ->orderBy('wp_terms.name')
            ->get();
    }
}