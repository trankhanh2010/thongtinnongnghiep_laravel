<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Binhluan extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'binhluan';
    protected $fillable = ['id','ma_user','noidung','ma_tintuc','ngay_binhluan'];
    public function insert($data){
        
        DB::insert('INSERT INTO '.$this->table.' (
            noidung,ma_tintuc,ma_user,ngay_binhluan
) 
        values (?,?,?,?)', $data);
    }
    public function delete_tintuc($id)
    {
        return DB::delete('delete from '.$this->table.' where ma_tintuc = ?', [$id]);
    }
    public function delete_gionglua($id)
    {
        return DB::delete('delete from '.$this->table.' where ma_gionglua = ?', [$id]);
    }
    public function delete_saubenh($id)
    {
        return DB::delete('delete from '.$this->table.' where ma_saubenh = ?', [$id]);
    }
    public function delete_binhluan($id)
    {
        return DB::delete('delete from '.$this->table.' where ma = ?', [$id]);
    }
}
