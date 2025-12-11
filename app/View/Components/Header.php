<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Loaithuoc;

class Header extends Component
{
    public $loaithuocs;

    public function __construct()
    {
        //
    }

    private function addCss($path)
    {
        $fullPath = resource_path('views/' . $path);
        if (file_exists($fullPath)) {
            $css = file_get_contents($fullPath);
            $cssTag = "<style>{$css}</style>";
            view()->share('header_styles', (view()->shared('header_styles') ?? '') . $cssTag);
        }
    }

    private function addJs($path)
    {
        $fullPath = resource_path('views/' . $path);
        if (file_exists($fullPath)) {
            $js = file_get_contents($fullPath);
            $jsTag = "<script>{$js}</script>";
            view()->share('header_scripts', (view()->shared('header_scripts') ?? '') . $jsTag);
        }
    }

    private function addCatalogy()
    {
        // Lấy toàn bộ loại thuốc
        $this->loaithuocs = Loaithuoc::where('isDelete', false)->orderBy('maLoai', 'desc')->get();

        // Share với toàn bộ view (để dùng trong header.blade.php)
        view()->share('loaithuocs', $this->loaithuocs);

    }

    public function prepare()
    {
        $this->addCss('components/header.css');
        $this->addJs('components/header.js');
        $this->addCatalogy();
    }

    public function render(): View|Closure|string
    {
        return view('components.header');
    }

    public function html(): string
    {
        // Chỉ render HTML component, không thêm CSS/JS
        return view('components.header')->render();
    }
}

