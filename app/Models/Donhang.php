<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Donhang
 * 
 * @property string $maDonHang
 * @property string $ngaydat
 * @property float $tongTien
 * @property string $DiaChi
 * @property string $SdtNguoiDat
 * 
 * @property Khachhang $khachhang
 * @property Collection|Chitietdonhang[] $chitietdonhangs
 *
 * @package App\Models
 */
class Donhang extends Model
{
	protected $table = 'donhang';
	protected $primaryKey = 'maDonHang';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'tongTien' => 'float'
	];

	protected $fillable = [
		'maDonHang',
		'ngaydat',
		'tongTien',
		'DiaChi',
		'SdtNguoiDat'
	];

	public function khachhang()
	{
		return $this->belongsTo(Khachhang::class, 'SdtNguoiDat');
	}

	public function chitietdonhangs()
	{
		return $this->hasMany(Chitietdonhang::class, 'maDonHang');
	}
}
