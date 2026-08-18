<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * The menu tree, three levels deep: category → subcategory → child category.
 * Every level is a row here; parent_id is what separates them.
 *
 * A category can also carry its own contact details, which the app shows
 * behind a floating button when "show_contact" is on.
 */
class Category extends Model
{
    use HasFactory;

    /** How deep the tree is allowed to get. */
    public const MAX_DEPTH = 3;

    /** What each level is called in the admin. */
    public const LEVEL_NAMES = [
        1 => 'Category',
        2 => 'Subcategory',
        3 => 'Child Category',
    ];

    protected $fillable = [
        'parent_id',
        'name',
        'thumbnail',
        'status',
        'show_contact',
        'owner_name',
        'address',
        'google_map_link',
        'email',
        'phone',
        'whatsapp',
        'messanger',
        'facebook',
        'other',
        'position',
    ];

    protected $casts = [
        'show_contact' => 'boolean',
    ];

    /**
     * Categories are no longer partitioned per palika, so everyone who may see
     * the list sees the published ones.
     */
    public function scopeAccessibleBy($query, $user)
    {
        return $query->where('status', 1);
    }

    /** Top-level categories — the ones the app's home grid shows. */
    public function scopeParents($query)
    {
        return $query->whereNull('parent_id');
    }

    /** Level 2: a subcategory's parent is itself top-level. */
    public function scopeSubcategories($query)
    {
        return $query->whereHas('parent', fn ($q) => $q->whereNull('parent_id'));
    }

    /** Level 3: a child category's grandparent is top-level. */
    public function scopeChildCategories($query)
    {
        return $query->whereHas('parent.parent', fn ($q) => $q->whereNull('parent_id'));
    }

    /** Menu order: whatever position the admin gave, then alphabetical. */
    public function scopeOrdered($query)
    {
        return $query->orderBy('position')->orderBy('name');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')->ordered();
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }

    /** 1 for a category, 2 for a subcategory, 3 for a child category. */
    public function level()
    {
        $level = 1;
        $node = $this;

        while ($node->parent_id && $level < self::MAX_DEPTH) {
            $node = $node->parent;

            if (! $node) {
                break;
            }

            $level++;
        }

        return $level;
    }

    public function levelName()
    {
        return self::LEVEL_NAMES[$this->level()] ?? 'Category';
    }

    /** How many levels this category spans, itself included. */
    public function height()
    {
        $children = $this->children;

        if ($children->isEmpty()) {
            return 1;
        }

        return 1 + $children->max(fn ($child) => $child->height());
    }

    /** This category and everything under it — used to bar circular moves. */
    public function descendantIds()
    {
        return $this->children->flatMap(
            fn ($child) => collect([$child->id])->merge($child->descendantIds())
        );
    }

    /** Category → Subcategory → this, for breadcrumbs and admin labels. */
    public function ancestors()
    {
        $trail = collect();
        $node = $this->parent;

        while ($node && $trail->count() < self::MAX_DEPTH) {
            $trail->prepend($node);
            $node = $node->parent;
        }

        return $trail;
    }

    public function pathName($separator = ' › ')
    {
        return $this->ancestors()->push($this)->pluck('name')->implode($separator);
    }

    /**
     * Whether the app should float a contact button on this category's screen.
     * The switch alone is not enough — an empty card helps nobody.
     */
    public function hasContact()
    {
        if (! $this->show_contact) {
            return false;
        }

        return filled($this->phone)
            || filled($this->email)
            || filled($this->address)
            || filled($this->whatsapp)
            || filled($this->messanger)
            || filled($this->facebook)
            || filled($this->other);
    }

    /**
     * Categories a record may be filed under: anything shallow enough that
     * this record's own subtree still fits inside MAX_DEPTH, minus itself and
     * its descendants — a category cannot become its own grandchild.
     */
    public static function selectableParents(?self $except = null)
    {
        $blocked = collect();
        $room = self::MAX_DEPTH - 1;

        if ($except) {
            $blocked = $except->descendantIds()->push($except->id);
            $room = self::MAX_DEPTH - $except->height();
        }

        return self::with('parent.parent')
            ->whereNotIn('id', $blocked)
            ->ordered()
            ->get()
            ->filter(fn ($category) => $category->level() <= $room)
            ->values();
    }
}
