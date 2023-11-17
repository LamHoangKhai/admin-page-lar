<?php

namespace App\Http\Controllers;

use App\Models\CrawData;
use App\Models\Product;
use App\Models\Category;

use Illuminate\Http\Request;

class CrawController extends Controller
{
    public $count = 0;
    public function index()
    {
        $category = Category::all();
        $context = stream_context_create(
            array(
                "http" => array(
                    "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.0.0 Safari/537.36"
                )
            )
        );
        for ($i = 1; $i <= 1; $i++) {

            try {
                $html = file_get_html("https://phongvu.vn/c/do-gia-dung-thiet-bi-gia-dinh?page=$i", false, $context);

                foreach ($html->find('.product-card ') as $key => $value) {
                    try {
                        // craw data
                        $imageURL = $value->find(".css-1uzm8bv img")[0]->attr["src"];
                        $name = $value->find(".att-product-card-title h3")[0]->innertext;
                        $file_name_image = $this->slugify($name) . ".jpg";
                        $price = $this->formatPrice($value->find('div[type="subtitle"]')[0]->innertext);

                        // insert data
                        $product = new Product();
                        $product->name = $name;
                        $product->image = $file_name_image;
                        $product->price = $price;
                        $product->status = 1;
                        $product->featured = 1;
                        $product->description = $name;
                        $product->content = $name;
                        $product->category_id = $category[rand(0, count($category) - 1)]->id;
                        $product->save();
                        $this->download_file($imageURL, public_path('/uploads/' . $this->slugify($$file_name_image)));
                    } catch (\Exception $e) {
                        echo $e->getMessage();
                        continue;
                    }
                }
            } catch (\Exception $e) {
                echo $e->getMessage();
                continue;
            }

            sleep(5);
        }


        // $products = [];
        // for ($i = 1; $i <= 2; $i++) {
        //     $html = file_get_html("https://phongvu.vn/c/do-gia-dung-thiet-bi-gia-dinh?page=$i", false, $context);

        //     foreach ($html->find('.product-card .css-1uzm8bv img') as $key => $e) {
        //         $products[$key]['image'] = $e->src;
        //     }

        //     foreach ($html->find('.product-card .att-product-card-title h3') as $key => $e) {
        //         $products[$key]['title'] = $e->innertext;
        //         $products[$key]['fileimg'] = $this->slugify($e->innertext) . ".jpg";
        //         // $this->download_file($products[$key]['image'], public_path('/uploads/' . $products[$key]['fileimg']));
        //     }

        //     foreach ($html->find('.product-card div[type="subtitle"]') as $key => $e) {
        //         $products[$key]['price'] = $this->formatPrice($e->innertext);
        //     }
        //     foreach ($products as $item) {
        //         $product = new CrawData();
        //         $product->name = $item["title"];
        //         $product->image = $item['fileimg'];
        //         $product->price = $item['price'];
        //         $product->save();
        //     }
        //     $products = [];
        //     sleep(5);
        // }

        echo "Craw success";
    }

    public function formatPrice($data)
    {
        $price = str_replace("<!-- --> - <!-- -->", " ", $data);
        $price = str_replace("\u{A0}₫", "", $price);
        $price = str_replace(".", "", $price);
        return $price;
    }
    public function slugify($str)
    {
        $str = trim(mb_strtolower($str));
        $str = preg_replace('/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $str);
        $str = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $str);
        $str = preg_replace('/(ì|í|ị|ỉ|ĩ)/', 'i', $str);
        $str = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $str);
        $str = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $str);
        $str = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $str);
        $str = preg_replace('/(đ)/', 'd', $str);
        $str = preg_replace('/[^a-z0-9-\s]/', '', $str);
        $str = preg_replace('/([\s]+)/', '-', $str);
        $str = preg_replace('/-+/', '-', $str);

        return $str;
    }

    public function download_file($file_url, $file_name)
    {
        // $time_start = microtime(true);
        file_put_contents($file_name, file_get_contents($file_url));
        // $this->count++;
        // $time_end = microtime(true);
        // $total_time = $time_end - $time_start;
        // echo $this->count, "------>", $total_time, "<br/>";
    }

}