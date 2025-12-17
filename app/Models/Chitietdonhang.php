<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Chitietdonhang
 * 
 * @property string $maDonHang
 * @property string $maThuoc
 * @property int $SoLuong
 * @property float|null $SoTien
 * 
 * @property Donhang $donhang
 * @property Thuoc $thuoc
 *
 * @package App\Models
 */
class Chitietdonhang extends Model
{
	protected $table = 'chitietdonhang';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'SoLuong' => 'int',
		'SoTien' => 'float'
	];

	protected $fillable = [
		'maDonHang',
		'maThuoc',
		'SoLuong',
		'SoTien'
	];

	public function donhang()
	{
		return $this->belongsTo(Donhang::class, 'maDonHang');
	}

	public function thuoc()
	{
		return $this->belongsTo(
			Thuoc::class,
			'maThuoc',  
			'maThuoc'   
		);
	}
}
