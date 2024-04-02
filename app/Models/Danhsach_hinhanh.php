<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Danhsach_hinhanh extends Model
{
    use HasFactory;
    protected $table = 'danhsach_hinhanh';

    public function insert_hinhanh_gionglua($data){
        
        DB::insert('INSERT INTO '.$this->table.' (
            ma,
            ma_gionglua,
            ma_saubenh, 
            ma_tintuc,  
            ten) 
        values (null,?,null,null,?)', $data);
    }
    public function insert_hinhanh_saubenh($data){
        
        DB::insert('INSERT INTO '.$this->table.' (
            ma,
            ma_gionglua,
            ma_saubenh, 
            ma_tintuc,  
            ten) 
        values (null,null,?,null,?)', $data);
    }
    public function insert_hinhanh_tintuc($data){
        
        DB::insert('INSERT INTO '.$this->table.' (
            ma,
            ma_gionglua,
            ma_saubenh, 
            ma_tintuc,  
            ten) 
        values (null,null,null,?,?)', $data);
    }
    public function get_ten($ma)
    {
        $data = DB::table($this->table)->where('ma', $ma)->value('ten');
        return $data;
    }
    public function get_ten_tintuc($ma)
    {
        $data = DB::table($this->table)->where('ma_tintuc', $ma)->value('ten');
        return $data;
    }
    public function get_ten_gionglua($ma)
    {
        $data = DB::table($this->table)->where('ma_gionglua', $ma)->value('ten');
        return $data;
    }
    public function get_ten_saubenh($ma)
    {
        $data = DB::table($this->table)->where('ma_saubenh', $ma)->value('ten');
        return $data;
    }
    
    public function get_all()
    {
        $data = DB::table($this->table);
        return $data;
    }

    public function ds_theoma_gionglua($ma){
        return DB::select('select * from '.$this->table.' where ma_gionglua = ?',[$ma]);
    }
    public function ds_theoma_saubenh($ma){
        return DB::select('select * from '.$this->table.' where ma_saubenh = ?',[$ma]);
    }
    public function ds_theoma_tintuc($ma){
        return DB::select('select * from '.$this->table.' where ma_tintuc = ?',[$ma]);
    }
    public function delete_voima($ma)
    {
        return DB::delete('delete from '.$this->table.' where ma = ?', [$ma]);
    }
    public function delete_voima_gionglua($id)
    {
        return DB::delete('delete from '.$this->table.' where ma_gionglua = ?', [$id]);
    }
    public function delete_voima_saubenh($id)
    {
        return DB::delete('delete from '.$this->table.' where ma_saubenh = ?', [$id]);
    }
    public function delete_voima_tintuc($id)
    {
        return DB::delete('delete from '.$this->table.' where ma_tintuc = ?', [$id]);
    }
}
