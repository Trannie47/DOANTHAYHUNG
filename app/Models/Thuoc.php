<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Class Thuoc
 * 
 * @property string $maThuoc
 * @property string $tenThuoc
 * @property string $QuiCach
 * @property float $GiaTien
 * @property string $DanhMuc
 * @property string $DVTinh
 * @property string $NSX
 * @property string $ThanhPhan
 * @property string $CongDung
 * @property string $CachSuDung
 * @property array|null $HinhAnh
 * @property int $maLoai
 * @property bool $chiDinhCuaBacSi
 * @property float $giaKhuyenMai
 * @property Carbon $CreateAt
 * @property bool $isDelete
 * 
 * @property Loaithuoc $loaithuoc
 * @property Collection|Chitietdonhang[] $chitietdonhangs
 *
 * @package App\Models
 */
class Thuoc extends Model
{
	protected $table = 'thuoc';
	protected $primaryKey = 'maThuoc';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'GiaTien' => 'float',
		'HinhAnh' => 'json',
		'maLoai' => 'int',
		'chiDinhCuaBacSi' => 'bool',
		'giaKhuyenMai' => 'float',
		'CreateAt' => 'datetime',
		'isDelete' => 'bool'
	];

	protected $fillable = [
		'maThuoc',
		'tenThuoc',
		'QuiCach',
		'GiaTien',
		'DanhMuc',
		'DVTinh',
		'NSX',
		'ThanhPhan',
		'CongDung',
		'CachSuDung',
		'HinhAnh',
		'maLoai',
		'chiDinhCuaBacSi',
		'giaKhuyenMai',
		'CreateAt',
		'isDelete'
	];

	public function loaithuoc()
	{
		return $this->belongsTo(Loaithuoc::class, 'maLoai');
	}

	public function chitietdonhangs()
	{
		return $this->hasMany(Chitietdonhang::class, 'maThuoc');
	}
	
	/**
	 * Tạo mã thuốc duy nhất (Format: MED + 8 ký tự random alphanumeric)
	 */
	public static function generateMaThuoc(): string
	{
		do {
			$maThuoc = 'MED' . strtoupper(Str::random(8));
		} while (self::where('maThuoc', $maThuoc)->exists());

		return $maThuoc;
	}

	/**
	 * Lấy ảnh đại diện (ảnh đầu tiên trong mảng JSON)
	 */
	public function getThumbnailImage(): ?string
	{
		if (is_array($this->HinhAnh) && !empty($this->HinhAnh)) {
			return $this->HinhAnh[0];
		}

		return null;
	}

	/**
	 * Scope: Lọc thuốc chưa xóa
	 */
	// no isDelete soft-delete scope anymore

	/**
	 * Scope: Tìm kiếm theo tên thuốc
	 */
	public function scopeSearch($query, $keyword)
	{
		if ($keyword) {
			return $query->where('tenThuoc', 'like', '%' . $keyword . '%');
		}

		return $query;
	}

	/**
	 * Scope: Lọc theo loại thuốc
	 */
	public function scopeByCategory($query, $maLoai)
	{
		if ($maLoai) {
			return $query->where('maLoai', $maLoai);
		}

		return $query;
	}
}
