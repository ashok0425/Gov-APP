<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * The menu tree, four levels deep: category → subcategory → child category
 * → grandchild category. Every level is a row here; parent_id is what
 * separates them.
 *
 * Every level, main categories included, can carry its own contact details,
 * which the app shows behind a floating button when "show_contact" is on.
 */
class Category extends Model
{
    use HasFactory;

    /** How deep the tree is allowed to get. */
    public const MAX_DEPTH = 4;

    /** What each level is called in the admin. */
    public const LEVEL_NAMES = [
        1 => 'Category',
        2 => 'Subcategory',
        3 => 'Child Category',
        4 => 'Grandchild Category',
    ];

    protected $fillable = [
        'parent_id',
        'name',
        'thumbnail',
        'top_image',
        'status',
        'show_cover',
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
        'show_cover' => 'boolean',
    ];

    /**
     * The published categories this user may work in. An employee pinned to
     * some nodes gets exactly those — a ticked category without its
     * subcategories ticked offers no subcategories; everyone else sees the
     * whole menu.
     */
    public function scopeAccessibleBy($query, $user)
    {
        $query->where('status', 1);

        $scopes = $user->scopedCategories();

        if ($scopes->isNotEmpty()) {
            $query->whereIn('id', $scopes->pluck('id'));
        }

        return $query;
    }

    /**
     * The menu as nested arrays, which is what the cascade selects run on:
     * one payload, every level, no round trip when a level changes.
     *
     * A pinned user's tree holds only their nodes. Since the employee form
     * only lets a node be ticked once its parent is, they always form whole
     * paths down from the top; anything orphaned by a later unpublish is
     * simply unreachable.
     */
    public static function treeFor($user)
    {
        $columns = ['id', 'name', 'parent_id', 'organization_id', 'position'];
        $grouped = static::accessibleBy($user)->ordered()->get($columns)->groupBy('parent_id');

        $build = function ($parentId) use (&$build, $grouped) {
            // groupBy turns a null parent into an empty-string key.
            return $grouped->get($parentId ?? '', collect())
                ->map(fn ($category) => [
                    'id' => $category->id,
                    'name' => $category->name,
                    // Only roots carry one; the list filter's organization
                    // select narrows the top level by it.
                    'organization_id' => $category->organization_id,
                    'children' => $build($category->id),
                ])
                ->values();
        };

        return $build(null);
    }

    /** Top-level categories — the ones the app's home grid shows. */
    public function scopeParents($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Everything sitting at one level of the tree. A row is at level N when it
     * has a chain of N-1 parents and the last of them has none of its own.
     */
    public function scopeAtLevel($query, $level)
    {
        if ($level <= 1) {
            return $query->whereNull('parent_id');
        }

        $chain = implode('.', array_fill(0, $level - 1, 'parent'));

        return $query->whereHas($chain, fn ($q) => $q->whereNull('parent_id'));
    }

    /** Level 2: a subcategory's parent is itself top-level. */
    public function scopeSubcategories($query)
    {
        return $query->atLevel(2);
    }

    /** Level 3: a child category's grandparent is top-level. */
    public function scopeChildCategories($query)
    {
        return $query->atLevel(3);
    }

    /** Level 4: the deepest the menu goes. */
    public function scopeGrandchildCategories($query)
    {
        return $query->atLevel(4);
    }

    /** Menu order: whatever position the admin gave, then alphabetical. */
    public function scopeOrdered($query)
    {
        return $query->orderBy('position')->orderBy('name');
    }

    /** Only main categories carry one; the levels below inherit through their root. */
    public function organization()
    {
        return $this->belongsTo(Organization::class);
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

    /** The cover carousel's slides, in the order the admin arranged them. */
    public function covers()
    {
        return $this->hasMany(CategoryImage::class)->orderBy('position')->orderBy('id');
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
