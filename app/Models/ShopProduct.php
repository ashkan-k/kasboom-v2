<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class ShopProduct extends Model
{
    protected $table = 'shop_products';
    public $timestamps = false;

    public static function store()
    {
        $user_id = auth()->user()->id;
        $product = json_decode($_POST['product'], true);
        if (!isset($product['id']) or strlen($product['product_name']) < 3 or strlen($product['product_english_name']) < 3)
            throw new \Exception('فیلد عنوان فارسی و انگلیسی محصول اجباری می باشد');
        $id = intval($product['id']);

        if (empty($id)) {
            $o = new ShopProduct();
            $o->user_id = $user_id;
            $o->created_at = time();
        } else {
            $o = ShopProduct::where('id', $id)->where('user_id', $user_id)->first();
            if (empty($o)) throw new \Exception('محصول یافت نشد');
        }

        $o->updated_at = time();
        $o->product_name = arToFa($product['product_name']);
        $o->product_english_name = arToFa($product['product_english_name']);
        $o->product_brand_name = arToFa($product['product_brand_name']);
        $o->product_intro = arToFa($product['product_intro']);
        $o->product_memo = arToFa($product['product_memo']);
        $o->product_weight = intval($product['product_weight']);
        $o->product_weight_box = intval($product['product_weight_box']);
        $o->product_price = intval($product['product_price']);
        $o->product_price_old = intval($product['product_price_old']);
        $o->product_count = intval($product['product_count']);
        $o->product_status = $product['product_status'];
        if (!in_array($product['product_status'], ['در دسترس', 'عدم انتشار', 'بزودی', 'توقف تولید']))
            $o->product_status = 'در دسترس';
        $o->product_preparation_time = intval($product['product_preparation_time']);
        $o->product_warranty = arToFa($product['product_warranty']);
        $o->product_alert = arToFa($product['product_alert']);
        $o->product_review = arToFa($product['product_review']);
        $o->apple = intval($product['apple']);
        $o->id_mega_category = intval($product['id_mega_category']);
        $o->id_middle_category = intval($product['id_middle_category']);
        $o->id_sub_category = intval($product['id_sub_category']);

        $o->save();
    }

    public static function storeProp()
    {
        $user_id = auth()->user()->id;
        $prop = json_decode($_POST['prop'], true);
        if (!isset($prop['id']) or strlen($prop['category']) < 2 or strlen($prop['property_key']) < 2 or strlen($prop['property_value']) < 2)
            throw new \Exception('حداقل دو کاراکتر برای فیلدهای اجباری وارد نمایید');
        $id = intval($prop['id']);
        $product_id = intval($prop['id_product']);
        $product = ShopProduct::where('id', $product_id)->where('user_id', $user_id)->first();
        if (empty($product)) throw new \Exception('محصول یافت نشد');

        $data = [];
        if (empty($id)) {
            $data['id_product'] = $product_id;
        }
        else {
            $o = DB::table('shop_product_properties')->where('id', $id)->where('id_product', $product_id)->first();
            if (empty($o)) throw new \Exception('ویژگی یافت نشد');
        }

        $data['category'] = arToFa($prop['category']);
        $data['property_key'] = arToFa($prop['property_key']);
        $data['property_value'] = arToFa($prop['property_value']);
        $data['key_tooltip'] = arToFa($prop['key_tooltip']);
        $data['show_in_product'] = intval($prop['show_in_product']) === 1 ? 1 : 0;

        if (empty($id)) {
            DB::table('shop_product_properties')->insert($data);
        }
        else {
            DB::table('shop_product_properties')->where('id', $id)->update($data);
        }
    }

    public static function storeProfessional()
    {
        $user_id = auth()->user()->id;
        $pro = json_decode($_POST['professional'], true);
        if (!isset($pro['id']) or strlen($pro['product_professional_key']) < 2)
            throw new \Exception('حداقل دو کاراکتر برای فیلدهای اجباری وارد نمایید');
        $id = intval($pro['id']);
        $product_id = intval($pro['id_product']);
        $product = ShopProduct::where('id', $product_id)->where('user_id', $user_id)->first();
        if (empty($product)) throw new \Exception('محصول یافت نشد');

        $data = [];
        if (empty($id)) {
            $data['id_product'] = $product_id;
        }
        else {
            $o = DB::table('shop_product_professional')->where('id', $id)
                ->where('id_product', $product_id)->first();
            if (empty($o)) throw new \Exception('نقد و بررسی یافت نشد');
        }

        $data['product_professional_key'] = arToFa($pro['product_professional_key']);
        $data['product_professional_value'] = arToFa($pro['product_professional_value']);

        if (empty($id)) {
            DB::table('shop_product_professional')->insert($data);
        }
        else {
            DB::table('shop_product_professional')->where('id', $id)->update($data);
        }
    }

    public static function storeProductImage()
    {
        $user_id = intval(auth()->user()->id);
        $product_id = intval($_GET['id']);
        $product = ShopProduct::where('id', $product_id)->where('user_id', $user_id)->first();
        if (empty($product)) throw new \Exception('محصول یافت نشد');

        if (request()->hasFile('file')) {
            if (request()->file('file')->isValid()) {
                if (!checkValidIP(request()->header('x-forwarded-for'))) {
                    throw new \Exception('دسترسی غیر مجاز به شبکه');
                }

                $validated = request()->validate([
                    'file' => 'required|mimes:jpeg,jpg,png|max:500',
                ]);
                $extension = request()->file->extension();
                $time = time();
                $product_image = md5($time.$product_id.mt_rand()) . '.' . $extension;
                DB::table('shop_product_images')->insert([
                    'product_image' => $product_image,
                    'product_size' => 0,
                    'created_at' => $time,
                    'updated_at' => $time,
                    'product_id' => $product_id
                ]);

                request()->file->storeAs('/shop/product/' . $user_id . '/' . $product_id, 'original-' . $product_image, 'public');
                $imagePath = public_path('shop/product/' . $user_id . '/' . $product_id . '/' . 'original-' . $product_image);
                $image = Image::make($imagePath);
                $width = $image->width();
                $height = $image->height();
                $newheight = (400 / $width) * $height;
                $image->resize(400, $newheight);
                $imagePath = public_path('shop/product/' . $user_id . '/' . $product_id . '/' . $product_image);
                $image->save($imagePath);
            }
        }
    }

    public static function deleteProductImage()
    {
        $user_id = intval(auth()->user()->id);
        $picture_id = intval($_POST['id']);
        $picture = DB::table('shop_product_images')->where('id', $picture_id)->first();
        if (empty($picture)) throw new \Exception('تصویر یافت نشد');

        $product = ShopProduct::where('id', $picture->product_id)->where('user_id', $user_id)->first();
        if (empty($product)) throw new \Exception('محصول یافت نشد');

        DB::table('shop_product_images')->where('id', $picture_id)->delete();
        File::delete(public_path('shop/product/' . $user_id . '/' . $product->id . '/' . $picture->product_image));
        File::delete(public_path('shop/product/' . $user_id . '/' . $product->id . '/original-' . $picture->product_image));
    }

































    public function category()
    {
        return $this->belongsTo(category::class, 'id_mega_category');
    }

    public function getDiscountPercent()
    {
        if ($this->product_price_old > 0)
            return 100 - (($this->product_price_old / $this->product_price) * 100);
    }

    public function getProductPoint($price = '')
    {
        if ($price == '')
            $price = $this->product_price;
        $pointArray = new ShopClubPoint();
        foreach ($pointArray->getProductPoint() as $key => $value) {
            if ($price >= $value)
                return $key;
        }
    }

    public function productBueCount($productId)
    {
        $commentCount = ShopInvoice::where('user_id', Auth::id())
            ->whereHas('ShopInvoiceProduct', function ($q) use ($productId) {
                $q->where('product_id', $productId);
            })->count();
        if ($commentCount > 0)
            return true;
        return false;
    }

    public function category_middle()
    {
        return $this->belongsTo(category_middle::class, 'id_middle_category');
    }

    public function category_sub()
    {
        return $this->belongsTo(category_sub::class, 'id_sub_category');
    }

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function Shop()
    {
        return $this->belongsTo(Shop::class, 'id_shop');
    }

    public function ShopProductColor()
    {
        return $this->belongsToMany(Color::class, 'shop_product_color', 'shop_product_id', 'color_id', 'shop_products');
    }

    public function ShopProductImage()
    {
        return $this->hasMany(ShopProductImage::class, 'shop_product_id');
    }

    public function ShopComment()
    {
        return $this->hasMany(ShopComment::class);
    }

    public function getNewComment()
    {
        return $this->ShopComment()->where('status', 1)->orderBy('id', 'desc')->get();
    }

    public function getMostLikeComment()
    {
        return ShopComment::join('shop_comment_likes', 'shop_comments.id', '=', 'shop_comment_likes.shop_comment_id')
            ->selectRaw('shop_comments.*, SUM(shop_comment_likes.value) AS sumValue')
            ->where('shop_comments.status', 1)
            ->groupBy('shop_comment_likes.shop_comment_id')
            ->orderBy('sumValue', 'desc')
            ->get();
    }

    public function ShopProductQuestion()
    {
        return $this->hasMany(ShopProductQuestion::class, 'shop_product_id');
    }

    public function ShopSlideshow()
    {
        return $this->hasMany(ShopSlideshow::class);
    }

    public function ShopProductFavorite()
    {
        return $this->hasMany(ShopProductFavorite::class);
    }

    public function getShopProductFavorite()
    {
        if (!Auth::check())
            $addTofavorite = 0;
        else
            $addTofavorite = ShopProductFavorite::where('user_id', Auth::id())->where('shop_product_id', $this->id)->count();
        return $addTofavorite;
    }

    public function ShopInvoice()
    {
        return $this->hasMany(ShopInvoice::class);
    }

    public function ShopInvoiceProduct()
    {
        return $this->hasMany(ShopInvoiceProduct::class,'product_id');
    }

    public function ShopProductFirstImage($type = 'small_')
    {
        $pic = $this->ShopProductImage->first();
        if (isset($pic->shop_product_image))
            return $this->getImageFolder() . "/$type" . $pic->shop_product_image;
        return 'no_image.png';
    }

    public function getOtherProduct()
    {
        return ShopProduct::where('id_user', Auth::id())
            ->where('id_shop', $this->Shop->id)
            ->where('id', '<>', $this->id)
            ->get();
        // ->take(8);

    }

    public function getImageFolder()
    {
        return "/_upload_/_shops_/" . $this->Shop->code . "/products/" . $this->code;
    }

    public function ShopProductColorId()
    {
        return $this->ShopProductColor->pluck('id')->toArray();
    }

    public function ShopProductProperty()
    {
        return $this->hasMany(ShopProductProperty::class, 'id_product');
    }

    public function getProductUrl()
    {
        return url("shop/shop_products/$this->id/$this->product_name");
    }

    public function ShopProductProfessional()
    {
        return $this->hasMany(ShopProductProfessional::class, 'id_product');
    }

    public function ShopProductCart()
    {
        return $this->hasMany(ShopProductCart::class);
    }

    public function getShippingPrice($type='')
    {

        if ($type == 1)
            $type = 'motori';
        if ($type == 2)
            $type = 'sefareshi';
        if ($type == 3)
            $type = 'pishtaz';
        return $this->getProductShippingPrice($type);
    }

    public function getProductShippingPrice($type)
    {

        $product_weight=$this->product_weight_box;
        if ($this->Shop->send_free_country == 1)
            return -1;
        if ($type == 'motori' && $product_weight<= 1000)
            return $this->Shop->shop_send_motori_to_1kg;

        if ($type == 'motori' && $product_weight > 1000)
            return ( (int)($product_weight / 1000) * $this->Shop->shop_send_motori_more_1kg + $this->Shop->shop_send_motori_to_1kg);

        if ($type == 'pishtaz' && $product_weight <= 1000)
            return $this->Shop->shop_send_pishtaz_to_1kg;

        if ($type == 'pishtaz' && $product_weight > 1000)
            return ( (int)($product_weight / 1000) * $this->Shop->shop_send_pishtaz_more_1kg + $this->Shop->shop_send_pishtaz_to_1kg);

        if ($type == 'sefareshi' && $product_weight <= 1000)
            return $this->Shop->shop_send_sefareshi_to_1kg;

        if ($type == 'sefareshi' && $product_weight > 1000)
            return ((int)($product_weight / 1000) * $this->Shop->shop_send_sefareshi_more_1kg + $this->Shop->shop_send_sefareshi_to_1kg);

    }

    public function getShopCommentAverage()
    {
        return ShopComment::
        select(
            \DB::raw('ROUND(avg(construction_quality)) as construction_quality'),
            \DB::raw('ROUND(avg(good_price)) as good_price'),
            \DB::raw('ROUND(avg(innovation)) as innovation'),
            \DB::raw('ROUND(avg(features)) as features'),
            \DB::raw('ROUND(avg(easy_of_use)) as easy_of_use'),
            \DB::raw('ROUND(avg(design)) as design')
        )
            ->where('status', 1)
            ->where('shop_product_id', $this->id)->first()->toArray();
    }

    public function getCommentCount()
    {
        return ShopComment::where('shop_product_id', $this->id)->where('status', 1)->count();
    }

    public function getShopCommentAverageName()
    {
        $result = [];
        foreach ($this->getShopCommentAverage() as $key => $comment) {

            $result[$key] = $this->getCommentName($comment);
        }
        return $result;
    }

    public function getCommentName($id)
    {
        $str = '';
        if ($id == 1)
            $str = 'خیلی بد';
        if ($id == 2)
            $str = '  بد';
        if ($id == 3)
            $str = 'معمولی';
        if ($id == 4)
            $str = 'خوب';
        if ($id == 5)
            $str = 'عالی';
        return $str;
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

}
