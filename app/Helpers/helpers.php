<?php

if (! function_exists('formatPrice')) {
    /**
     * Format số tiền VNĐ
     *
     * @param  float|int $price
     * @return string
     */
    function formatPrice($price)
    {
        return number_format($price, 0, ',', '.') . ' đ';
    }
}
