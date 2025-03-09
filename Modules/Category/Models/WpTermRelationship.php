<?php

namespace Modules\Category\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Category\Models\WpTermTaxonomy;

class WpTermRelationship extends Model
{
    use HasFactory;
    protected $table = 'wp_term_relationships';
    protected $primaryKey = "term_taxonomy_id";
    protected $fillable = ['object_id', 'term_taxonomy_id', 'term_order'];
    public function TermTaxonomy()
    {
        return $this->belongsTo(WpTermTaxonomy::class, 'term_taxonomy_id');
    }
}
