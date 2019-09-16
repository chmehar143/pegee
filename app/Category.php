<?php

namespace App;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Product;

class Category extends Model
{
    private $descendants = [];

    use Filterable,
        Sluggable;

    /**
     * The attributes that should be guarded for arrays.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be fillable for arrays.
     *
     * @var array
     */
    protected $fillable = ['name', 'status', 'parent_id', 'weight'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'parent_id',
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
   
    public function parentCategory()
    {
        return $this->belongsTo('App\Category', 'parent_id');
    }

    public function childrenCategory()
    {
        return $this->hasMany('App\Category', 'parent_id');
    }
    public function getProducts()
    {
        return $this->hasMany('App\Product');
    }

    public function getActiveProducts()
    {
        return $this->getProducts()
            ->where('product_quantity', '>', 0)
            ->where('product_status', 1)
            //->whereIn('category_id', $categories_id)
            ->orderBy('weight')
            ->get();
    }
    public function getProduct()
    {
        // $category_ids = [$this->id];
        $category_ids = $this->getDescendants($this);
        $category_ids[] = $this->id; 
        return Product:: select ('*')
            ->where('product_quantity', '>', 0)
            ->where('product_status', 1)
            ->whereIn('category_id', $category_ids)
            ->orderBy('weight')
            ->get();
    }
    

    public static function getDefaultWeight()
    {
        $latest_category = Category::latest('weight')->first();
        if ($latest_category) {
            return $latest_category->weight + 1;
        }
        return 1;
    }

    public function children()
    {
        return $this->childrenCategory()->with('children');
    }
    
   
    public function getDescendants($category)
    {

        $ids = [];
            foreach($category->childrenCategory as $child)
            {
                $ids[] = $child->id;
                $ids = array_merge($ids, $this->getDescendants($child));
            }

            return $ids; 
    }
    

}
