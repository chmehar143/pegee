<?php

function set_active($path, $active = 'active')
{
    return Request::is($path) || Request::is($path . '/*') ? $active : '';
}

/**
 *
 * @param type $categories ORM Object of parent categories
 * @param type $include_blank Provide the value of blank
 * @return string Options
 */
function getCategoriesOptions($categories, $selected = "", $include_blank = false, $step = 0)
{

    $options = "";
    if ($include_blank) {
        $options .= '<option value="">' . $include_blank . '</option>';
    }
    foreach ($categories as $category) {
        $options .= '<option value="' . $category->id . '" ' . ($selected == $category->id ? 'selected' : '') . '>';
        if ($step > 0) {
            for ($i = 0; $i < $step; $i++) {
                $options .= '-';
            }
            $options .= ' ';
        }
        $options .= $category->name . '</option>';
        $childrenCategories = $category->childrenCategory()->oldest('weight')->get();
        if ($childrenCategories->count() > 0) {

            $options .= getCategoriesOptions($childrenCategories, $selected, false, $step + 1);
        }
    }

    return $options;
}

function getCategoriesView($categories, $step = 0)
{
    $rows = "";

    foreach ($categories as $category) {
        $dashes = "";
        $class = 'active'; //for parent
        if ($step > 0) {
            if ($step > 1) {
                $dashes .= '<span style="display: inline-block; width: ' . (($step * 15) / 2) . 'px"></span>';
            }
            $dashes .= '<img src="' . asset('images/arrow-right.png') . '" width="15" />';

            $dashes .= '&nbsp;';

            switch ($step % 4) {
                case 1:
                    $class = 'success';
                    break;
                case 2:
                    $class = 'danger';
                    break;
                default:
                    $class = '';
            }
        }
        $rows .= "<tr class='" . $class . "'>";
        $rows .= '<td>' . $dashes . $category->name . '</td>';
        $rows .= '<td>' . $category->weight . '</td>';
        $rows .= '<td width="20"><a class="btn btn-sm btn-success btn-block" href="' . route('category.edit', $category->id) . '" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil fa-fw" aria-hidden="true"></i><span>Edit</span><span class=""> Category</span></a>';
        $rows .= '<a class="btn btn-sm btn-success btn-block" href="' . route('meta_tags.create', ['resource_id' => $category->id, 'resource_type' => 'category']) . '" data-toggle="tooltip" title="MetaTags"><i class="fa fa-info fa-fw" aria-hidden="true"></i> <span>Meta Tags</span></a>';
        if ($category->status != 1) {
            $rows .= '<a onclick="return confirm(\'Are you sure\')" class="btn btn-sm btn-info btn-block" href="' . route('category.activate', $category->id) . '" data-toggle="tooltip" title="Activate"><i class="fa fa-toggle-on fa-fw" aria-hidden="true"></i> <span class="">Activate</span></span></a>';
        } else {
            $rows .= '<a onclick="return confirm(\'Are you sure\')" class="btn btn-sm btn-warning btn-block" href="' . route('category.deactivate', $category->id) . '" data-toggle="tooltip" title="Deactivate">                                            <i class="fa fa-ban fa-fw" aria-hidden="true"></i> <span class="">Deactivate</span></span></a>';
        }
        $rows .= '<a href="' . route('category.destroy', $category->id) . '" onclick="event.preventDefault();document.getElementById(\'destroy-form-' . $category->id . '\').submit();" class="btn btn-sm btn-danger btn-block ' . ($category->status == 2 ? ' disabled' : '') . '" data-toggle="tooltip" title="Remove"><i class="fa fa-trash fa-fw" aria-hidden="true"></i> <span class="">Remove</span><span class=""> Category</span></a><form id="destroy-form-' . $category->id . '" action="' . route('category.destroy', $category->id) . '" method="POST" style="display: none;" onsubmit="return confirm(\'Are You Sure?\')">' . method_field('DELETE') . ' ' . csrf_field() . '</form></td>';
        $rows .= '</tr>';
        $child_categories = $category->childrenCategory()->oldest('weight')->get();
        if (count($child_categories) > 0) {
            $rows .= getCategoriesView($child_categories, ($step + 1));
        }
    }
    return $rows;
}

function getCategoriesFrontView($categories, $page, $step = 0)
{
    $dashes = "";

    $class1 = 'red_bg';
    $rows = "";

    foreach ($categories as $category) {
        $rows .= '<li class="' . $class1 . '" >';
        $rows .= '<a  href="' . route('category', ['slug' => $category->slug]) . '">' . $dashes . $category->name;
        $rows .= '&nbsp;<span>(' . count($category->getProduct()) . ')</span></a>';


        $child_categories = $category->childrenCategory()->oldest('weight')->get();

        /*if ($child_categories->count() > 0) {
                $rows .='<hr/>';
                $rows .= '<ul class="subcategory">';
            $rows .= getCategoriesFrontView($child_categories,"", ($step + 1));
            $rows .= '</ul>';
        }*/
        $rows .= '</li>';
    }

    return $rows;
}

function getShopBreadCrumb($category)
{
    $breadcrumb = [];

    do {
        $breadcrumb[] = '<a href="' . route('category', ['slug' => $category->slug]) . '">' . $category->name . '</a>';
        $category = $category->parentCategory;

    } while ($category);
    $breadcrumb[] = '<a href="' . route('shop') . '">All Products</a>';
    $breadcrumb = array_reverse($breadcrumb);
    $breadcrumb = implode("&nbsp;>&nbsp;", $breadcrumb);


    return $breadcrumb;
}

function getFinalCalculations($cartItems, $loggedInUser = false, $userSelectedAutoship = false, $forceFirstTimeAutoShip = false)
{

    $data = array();
    $firstTimeAutoShipDiscount = 0;
    $countOfAutoshipProducts = false;
    $discount = 0;
    $autoshipDiscount = 0;
    $totalPrice = 0;
    $firstTimeAutoShip = false;
    $internalDiscountMapping = array();
    $discounts = array();
    //if this is the first time we will calculate 15% discount for autoship
    //since max discount is 20% and we have 5% for autoship so we are going to calculate 15% for first time
    if ($forceFirstTimeAutoShip) {
        $firstTimeAutoShip = true;
    } else if ($loggedInUser && $userSelectedAutoship) {
        $orderCountUser = \App\Order::where('user_id', $loggedInUser->id)->get();
        $firstTimeAutoShip = count($orderCountUser) == 0;
    }


// calculate the total price
    foreach ($cartItems as $cartItem) {
        $product = $cartItem['product'];
        $data['products'][$product->id] = $product;

        $productQuantity = $cartItem['quantity'];
        $productActualPrice = $product->price;
        $productPrice = round(($productActualPrice * $productQuantity), 2);
        $totalPrice += $productPrice;
        $internalDiscountMapping[$product->id]['recurringAmount'] = $productPrice;
        $internalDiscountMapping[$product->id]['finalPrice'] = $productPrice;
        $internalDiscountMapping[$product->id]['offerDiscount'] = 0;
        $internalDiscountMapping[$product->id]['firstTimeAutoShipDiscount'] = 0;
        $internalDiscountMapping[$product->id]['autoShipDiscount'] = 0;
        $internalDiscountMapping[$product->id]['PriceAfterAutoshipDiscount'] = 0;
    }


    $grandTotal = $totalPrice;
    // calculate the first time autoship discount
    foreach ($cartItems as $cartItem) {
        if ($firstTimeAutoShip) {
            $product = $cartItem['product'];
            $data['products'][$product->id] = $product;
            $productQuantity = $cartItem['quantity'];
            $productActualPrice = $product->price;
            $discountAmount = round(($productActualPrice * 0.15) * $productQuantity, 2);
            $firstTimeAutoShipDiscount += $discountAmount;
            $grandTotal -= $discountAmount;
            $internalDiscountMapping[$product->id]['firstTimeAutoShipDiscount'] = $discountAmount;
            $internalDiscountMapping[$product->id]['finalPrice'] -= $discountAmount;
        }
    }


    //calculate the offer discount we will not apply any promotion if its first time autoship because we can only give max 20% discount
    if (!$firstTimeAutoShip) {
        foreach ($cartItems as $cartItem) {
            $product = $cartItem['product'];
            $productActualPrice = $product->price;
            $productQuantity = $cartItem['quantity'];
            $offer = $product->getApllyingOffer($productQuantity);
            $discountAmount = 0;
            if ($offer) {
                $discountAmount = getDiscount($productActualPrice, $offer->offer, $productQuantity);
                $internalDiscountMapping[$product->id]['offerDiscount'] = $discountAmount;
                $internalDiscountMapping[$product->id]['finalPrice'] -= $discountAmount;
                $discounts[] = array('text' => $offer->offer . "% off on " . $offer->quantity . " x " . $product->name, 'value' => $discountAmount);
                $grandTotal -= $discountAmount;
                $internalDiscountMapping[$product->id]['recurringAmount'] -= $discountAmount;
            }
        }
    } else {
        foreach ($cartItems as $cartItem) {
            $product = $cartItem['product'];
            $productActualPrice = $product->price;
            $productQuantity = $cartItem['quantity'];
            $offer = $product->getApllyingOffer($productQuantity);
            $discountAmount = 0;
            if ($offer) {
                $discountAmount = getDiscount($productActualPrice, $offer->offer, $productQuantity);
                $internalDiscountMapping[$product->id]['recurringAmount'] -= $discountAmount;
            }
        }
    }


    //calucalte the autoship discount

    //after order We should Check is autoship from order detail entry because product autohip flag can be changed by admin and if admin does it then our calculations would be a mess.
    foreach ($cartItems as $cartItem) {
        $product = $cartItem['product'];
        $productActualPrice = $product->price;

        $productQuantity = intval($cartItem['quantity']);
        $productPrice = $productActualPrice * $productQuantity;
        $productAutoShip = false;
        if (isset($cartItem['autoship_enabled'])) {
            $productAutoShip = true;
            $productAutoShipDiscount = $cartItem['autoship_discount'];
        } else {
            $productAutoShipObject = $product->getActiveAutoShip();
            if ($productAutoShipObject) {
                $productAutoShip = true;
                $productAutoShipDiscount = $productAutoShipObject->autoship_percentage;
            }
        }


        if ($productAutoShip) {
            $countOfAutoshipProducts = true;
            if ($userSelectedAutoship) {
                if ($firstTimeAutoShip && isset($internalDiscountMapping[$product->id]['firstTimeAutoShipDiscount'])) {
                    $productPrice -= $internalDiscountMapping[$product->id]['firstTimeAutoShipDiscount'];
                }
                if (!$firstTimeAutoShip && isset($internalDiscountMapping[$product->id]['offerDiscount'])) {
                    $productPrice -= $internalDiscountMapping[$product->id]['offerDiscount'];
                }
                $countOfAutoshipProducts = true;
                $discountAmount = round(($productPrice * ($productAutoShipDiscount / 100)), 2);

                $autoshipDiscount += $discountAmount;
                $internalDiscountMapping[$product->id]['autoShipDiscount'] = $discountAmount;
                $internalDiscountMapping[$product->id]['PriceAfterAutoshipDiscount'] = ($productActualPrice * $productQuantity) - $discountAmount;
                $internalDiscountMapping[$product->id]['finalPrice'] -= $discountAmount;

                //now calculate the recurring discount
                $recurringDiscountAmount = round(($internalDiscountMapping[$product->id]['recurringAmount'] * ($productAutoShipDiscount / 100)), 2);
                $internalDiscountMapping[$product->id]['recurringAmount'] -= $recurringDiscountAmount;
                $grandTotal -= $discountAmount;
            }
        }
    }

    $data['firstTimeAutoShip'] = $firstTimeAutoShip;
    $data['firstTimeAutoShipDiscount'] = $firstTimeAutoShipDiscount;
    $data['countOfAutoshipProducts'] = $countOfAutoshipProducts;
    $data['discount'] = $discount;
    $data['discounts'] = $discounts;
    $data['totalPrice'] = $totalPrice;
    $data['grandTotal'] = $grandTotal;
    $data['autoshipDiscount'] = $autoshipDiscount;
    $data['internalDiscountMapping'] = $internalDiscountMapping;
    return $data;
}

function getSpecialDiscount($price, $quantity)
{
    $specialDiscount = 0;
    $specialDiscount = round((($price * 15) / 100) * $quantity, 2);
    return $specialDiscount;
}

function getDiscount($price, $dicount, $quantity)
{
    $discount = 0;
    $discount = round((($price * $dicount) / 100) * $quantity, 2);
    return $discount;
}

function getAutoshipDiscount($price, $discount, $quantity, $specialDiscount)
{
    $autoshipDiscount = 0;
    $actualAmount = 0;
    $actualAmount = $price * $quantity;
    $lessSpecialDiscount = $actualAmount - $specialDiscount;
    $autoshipDiscount = round(($lessSpecialDiscount * $discount) / 100, 2);
    return $autoshipDiscount;
}


function navCategoriesDropdown($categories, $page)
{
    $categoryNavDropdown = '';


    foreach ($categories as $category) {
        $categoryNavDropdown .= '<li class="' . (isset($page) && $page == $category->slug ? 'active' : '') . '">';
        $categoryNavDropdown .= '<a href="' . route('category', ['slug' => $category->slug]) . '" title="' . $category->name . '">' . $category->name . '</a>';
        $categoryNavDropdown .= navCategoryDropdown($category);
        $categoryNavDropdown .= '</li>';
    }

    return $categoryNavDropdown;
}

function navCategoryDropdown($category)
{
    $childCategories = $category->childrenCategory()->oldest('weight')->get();
    $dropdown = '';

        if($childCategories->count() > 0){
            $dropdown .= '<ul class="dropdown" role="menu">';
            foreach ($childCategories as $childCategory) {
                $dropdown .= '<li><a href="' . route('category', ['slug' => $childCategory->slug]) . '" title="' . $childCategory->name . '">' . $childCategory->name . '</a></li>';
            }
            $dropdown .= navCategoryDropdown($childCategory);
            $dropdown .= '</ul>';
        }

    return $dropdown;
}