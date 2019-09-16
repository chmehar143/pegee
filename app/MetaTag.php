<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use EloquentFilter\Filterable;

class MetaTag extends Model
{
    use Filterable;

    protected $guarded = ['id'];

    /**
     * The attributes that should be fillable for arrays.
     *
     * @var array
     */
    protected $fillable = [
        'resource_id',
        'resource_type',
        'title',
        'description',
    ];


    public function getName()
    {
        $name = 'Undefiend';
        switch ($this->resource_type) {
            case 'static-page':
                $page = StaticPage::where('id', $this->resource_id)->first();
                if ($page) {
                    $name = $page->page_name;
                }
                break;
            case 'category':
                $category = Category::where('id', $this->resource_id)->first();
                if ($category) {
                    $name = $category->name;
                }

                break;
            case 'product':
                $product = Product::where('id', $this->resource_id)->first();
                if ($product) {
                    $name = $product->name;
                }
                break;
            case 'blog_post':
                $blog_post =  BlogPost::where('id', $this->resource_id)->first();
                if($blog_post){
                    $name = $blog_post->name;
                }
                break;
            case 'home-page':
                $name = 'Home Page';
                break;
            case 'shop-page':
                $name = 'Shop Page';
                break;
            case 'sample-page':
                $name = 'Free Sample Request Page';
                break;
            case 'deals-page':
                $name = 'Today Deals Page';
                break;
            case 'track-page':
                $name = 'Track Page';
                break;
            case 'view-cart-page':
                $name = 'View Cart Page';
                break;
            case 'checkout-page':
                $name = 'Checkout Page';
                break;
            case 'my-orders-page':
                $name = 'My Orders Page';
                break;
            case 'order-detail-page':
                $name = 'Order Details Page';
                break;

            case 'blog_post-page':
                $name = 'Blog Page';
                break;

            default:
                //do nothing
        }
        return $name;
    }

    public static function getMetas($resource_type, $resource_id){
        return MetaTag::where('resource_id', $resource_id)
            ->where('resource_type', $resource_type)
            ->first();
    }
}
