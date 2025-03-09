<?php

namespace Modules\Category\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Category\Models\WpTerm;

class WpTermTaxonomy extends Model
{
    use HasFactory;
    protected $table = 'wp_term_taxonomy';
    protected $primaryKey = 'term_taxonomy_id';
    protected $fillable = ['term_id', 'taxonomy', 'description', 'parent', 'count'];
    public function term()
    {
        return $this->belongsTo(WpTerm::class, 'term_id', 'term_id');
    }
}
