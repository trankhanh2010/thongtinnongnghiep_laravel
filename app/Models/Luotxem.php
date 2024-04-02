<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Luotxem extends Model
{
    use HasFactory;
    protected $table = 'luotxem';
    public function check_tintuc($int,$ma){
        $data=DB::table($this->table)->select('*')->where('ma_tintuc',$ma)->where('ngay',$int)->value('luotxem');
        // dd($data);
        if($data > 0) return 1;
        return 0;
    }
    public function get_ma_tintuc($int,$ma){
        $data=DB::table($this->table)->select('*')->where('ma_tintuc',$ma)->where('ngay',$int)->get();
        return $data[0];
    }
    public function get_detail_tintuc($ma){
        $data=DB::table($this->table)->select('*')->where('ma',$ma)->get();
        return $data[0];
    }
    public function insert_tintuc($data){
        
        DB::insert('INSERT INTO '.$this->table.' (
            ma, 
            ngay,
            ma_gionglua,
            ma_saubenh,
            ma_tintuc,
            luotxem) 
        values (null,?,null,null,?,1)', $data);
    }
    public function tintuc_them1($ma, $int){
        return DB::update('update '.$this->table.' set
        luotxem = ?
        where ma = ? ', [$int,$ma]);
    }

    public function check_gionglua($int,$ma){
        $data=DB::table($this->table)->select('*')->where('ma_gionglua',$ma)->where('ngay',$int)->value('luotxem');
        // dd($data);
        if($data > 0) return 1;
        return 0;
    }
    public function get_ma_gionglua($int,$ma){
        $data=DB::table($this->table)->select('*')->where('ma_gionglua',$ma)->where('ngay',$int)->get();
        return $data[0];
    }
    public function get_detail_gionglua($ma){
        $data=DB::table($this->table)->select('*')->where('ma',$ma)->get();
        return $data[0];
    }
    public function insert_gionglua($data){
        
        DB::insert('INSERT INTO '.$this->table.' (
            ma, 
            ngay,
            ma_gionglua,
            ma_saubenh,
            ma_tintuc,
            luotxem) 
        values (null,?,?,null,null,1)', $data);
    }
    public function gionglua_them1($ma, $int){
        return DB::update('update '.$this->table.' set
        luotxem = ?
        where ma = ? ', [$int,$ma]);
    }
    
    public function check_saubenh($int,$ma){
        $data=DB::table($this->table)->select('*')->where('ma_saubenh',$ma)->where('ngay',$int)->value('luotxem');
        // dd($data);
        if($data > 0) return 1;
        return 0;
    }
    public function get_ma_saubenh($int,$ma){
        $data=DB::table($this->table)->select('*')->where('ma_saubenh',$ma)->where('ngay',$int)->get();
        return $data[0];
    }
    public function get_detail_saubenh($ma){
        $data=DB::table($this->table)->select('*')->where('ma',$ma)->get();
        return $data[0];
    }
    public function insert_saubenh($data){
        
        DB::insert('INSERT INTO '.$this->table.' (
            ma, 
            ngay,
            ma_gionglua,
            ma_saubenh,
            ma_tintuc,
            luotxem) 
        values (null,?,null,?,null,1)', $data);
    }
    public function saubenh_them1($ma, $int){
        return DB::update('update '.$this->table.' set
        luotxem = ?
        where ma = ? ', [$int,$ma]);
    }
    public function delete_Gionglua($id)
    {
        return DB::delete('delete from '.$this->table.' where ma_gionglua = ?', [$id]);
    }
    public function delete_Saubenh($id)
    {
        return DB::delete('delete from '.$this->table.' where ma_saubenh = ?', [$id]);
    }
    public function delete_Tintuc($id)
    {
        return DB::delete('delete from '.$this->table.' where ma_tintuc = ?', [$id]);
    }
    public function statement($sql){
        return DB::statement($sql);
    }
    public function selectsql($sql){
        return DB::select($sql);
    }

}
