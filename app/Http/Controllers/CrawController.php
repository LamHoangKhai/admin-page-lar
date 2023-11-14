<?php

namespace App\Http\Controllers;

use App\Models\CrawData;
use Illuminate\Http\Request;

class CrawController extends Controller
{
    public function index()
    {
        $context = stream_context_create(
            array(
                "http" =>
                    array("header" => "User-Agent:Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.0.0 Mobile Safari/537.36")
            )
        );

        for ($i = 1; $i <= 47; $i++) {
            $html = file_get_html("https://phongvu.vn/c/do-gia-dung-thiet-bi-gia-dinh?page=$i", false, $context);

            foreach ($html->find('.product-card ') as $key => $value) {
                $image = $value->find(".css-1uzm8bv img")[0]->attr["src"];
                $name = $value->find(".att-product-card-title h3")[0]->innertext;
                $product = new CrawData();
                $product->name = $name;
                $product->image = $this->slugify($name) . ".jpg";
                $product->price = $this->formatPrice($value->find('div[type="subtitle"]')[0]->innertext);
                $product->save();
                $this->download_file($image, public_path('/uploads/' . $this->slugify($name) . ".jpg"));
            }

            sleep(5);
        }
        echo "Craw thành công";
    }

    public function formatPrice($data)
    {
        $price = str_replace("<!-- --> - <!-- -->", "-", $data);
        $price = str_replace("\u{A0}₫", "VND", $price);
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
        file_put_contents($file_name, file_get_contents($file_url));
    }

}