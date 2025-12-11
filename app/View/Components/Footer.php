<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Footer extends Component
{
     public function __construct()
    {
        //
    }


    // Load CSS trực tiếp từ resources/views/component
    private function addCss($path)
    {
        $fullPath = resource_path('views/' . $path);
        if(file_exists($fullPath)) {
            $css = file_get_contents($fullPath);
            $cssTag = "<style>{$css}</style>";
            view()->share('footer_styles', (view()-> shared('footer_styles') ?? '') . $cssTag);
        }
    }

    // Load JS trực tiếp từ resources/views/component
    private function addJs($path)
    {
        $fullPath = resource_path('views/' . $path);
        if(file_exists($fullPath)) {
            $js = file_get_contents($fullPath);
            $jsTag = "<script>{$js}</script>";
            view()->share('footer_scripts', (view()->shared('footer_scripts') ?? '') . $jsTag);
        }
    }
   
    public function prepare()
    {
        $this->addCss('components/footer.css');
        $this->addJs('components/footer.js');
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    { 
        return view('components.footer');
    }

    // Header.php
    public function html(): string
    {
        // Chỉ render HTML component, không thêm CSS/JS
        return view('components.footer')->render();
    }

}
