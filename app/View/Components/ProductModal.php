<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ProductModal extends Component
{
    public function __construct()
    {
        // Tự động load CSS & JS khi khởi tạo
        // $this->loadAssets();
    }

    public function render(): View|Closure|string
    {
        return view('components.product-modal');
    }

    /**
     * Tự động load asset CSS/JS của component
     */
    private function loadAssets()
    {
        $this->addCss("components/product-modal.css");
        $this->addJs("components/product-modal.js");
    }

    /**
     * Hàm load CSS
     */
    private function addCss($path)
    {
        $fullPath = resource_path("views/" . $path);

        if (file_exists($fullPath)) {
            $css = file_get_contents($fullPath);
            $tag = "<style>{$css}</style>";

            // Nối thêm vào product_modal_styles
            view()->share('product_modal_styles', (view()->shared('product_modal_styles') ?? '') . $tag);
        }
    }

    /**
     * Hàm load JS
     */
    private function addJs($path)
    {
        $fullPath = resource_path("views/" . $path);

        if (file_exists($fullPath)) {
            $js = file_get_contents($fullPath);
            $tag = "<script>{$js}</script>";

            // Nối thêm vào product_modal_scripts
            view()->share('product_modal_scripts', (view()->shared('product_modal_scripts') ?? '') . $tag);
        }
    }

    public function prepare()
    {
        $this->addCss('components/product-modal.css');
        $this->addJs('components/product-modal.js');
    }
}
