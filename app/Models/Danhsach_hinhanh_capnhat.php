<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Danhsach_hinhanh_capnhat extends Model
{
    use HasFactory;
    protected $table = 'danhsach_hinhanh_capnhat';

    public function insert_hinhanh($data){
        
        DB::insert('INSERT INTO '.$this->table.' (
            ma_thongtin_capnhat,
            ten) 
        values (?,?)', $data);
    }
    public function delete_voima_thongtin_capnhat_vaten($id,$ten)
    {
        return DB::delete('delete from '.$this->table.' where ma_thongtin_capnhat = ? and ten = ?', [$id,$ten]);
    }
    public function delete_voima_thongtin_capnhat($id)
    {
        return DB::delete('delete from '.$this->table.' where ma_thongtin_capnhat = ? ', [$id]);
    }
    public function ds_theoma($ma){
        $data = DB::table($this->table)->where('ma_thongtin_capnhat',$ma)->get();
        return $data;
    }
}
