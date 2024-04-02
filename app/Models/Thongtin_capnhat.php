<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Thongtin_capnhat extends Model
{
    use HasFactory;
    protected $table = 'thongtin_capnhat';

    public function insert_thongtin_capnhat_gionglua($data){
        
        DB::insert('INSERT INTO '.$this->table.' (
            ma_gionglua,
            ma_thongtin_capnhat,
            ma_user,
            ten,
            dacdiem,
            thongtinkhac,
            chongchiutot,
            debinhiem,
            ngaycapnhat) 
        values (?,?,?,?,?,?,?,?,?)', $data);
    }
    public function insert_thongtin_capnhat_saubenh($data){
        
        DB::insert('INSERT INTO '.$this->table.' (
            ma_saubenh,
            ma_thongtin_capnhat,
            ma_user,
            ten,
            dacdiem,
            thongtinkhac,
            chongchiutot,
            debinhiem,
            ngaycapnhat) 
        values (?,?,?,?,?,?,?,?,?)', $data);
    }
    public function insert_thongtin_capnhat_tintuc($data){
        
        DB::insert('INSERT INTO '.$this->table.' (
            ma_tintuc,
            ma_thongtin_capnhat,
            ma_user,
            ten,
            noidung,
            loai_tintuc,
            co_lienquan_gionglua,
            ngaycapnhat) 
        values (?,?,?,?,?,?,?,?)', $data);
    }
    public function get_all($ma)
    {
        $data = DB::table($this->table)->where('ma_gionglua',$ma)->get();
        return $data;
    }
    public function get_voima($ma)
    {
        $data = DB::table($this->table)->where('ma',$ma)->get();
        return $data;
    }
    public function get_all_desctime_gionglua($ma)
    {
        $data = DB::table($this->table)->where('ma_gionglua',$ma)->orderByDesc('ngaycapnhat')->get();
        return $data;
    }
    public function get_all_desctime_saubenh($ma)
    {
        $data = DB::table($this->table)->where('ma_saubenh',$ma)->orderByDesc('ngaycapnhat')->get();
        return $data;
    }
    public function get_all_desctime_tintuc($ma)
    {
        $data = DB::table($this->table)->where('ma_tintuc',$ma)->orderByDesc('ngaycapnhat')->get();
        return $data;
    }
    public function get_mavoi_ma_gionglua_vathoigian($ma,$time){
        return DB::select('select ma from '.$this->table.' where ma_gionglua = ? and ngaycapnhat = ?',[$ma,$time]);
    }
    public function get_mavoi_ma_gionglua_vathoigianmax($ma){
        return DB::select('SELECT *  FROM '.$this->table.' where ma_gionglua = ? ORDER BY ngaycapnhat DESC LIMIT 1',[$ma]);
    }
    public function get_mavoi_ma_saubenh_vathoigian($ma,$time){
        return DB::select('select ma from '.$this->table.' where ma_saubenh = ? and ngaycapnhat = ?',[$ma,$time]);
    }
    public function get_mavoi_ma_saubenh_vathoigianmax($ma){
        return DB::select('SELECT *  FROM '.$this->table.' where ma_saubenh = ? ORDER BY ngaycapnhat DESC LIMIT 1',[$ma]);
    }
    public function get_mavoi_ma_tintuc_vathoigian($ma,$time){
        return DB::select('select ma from '.$this->table.' where ma_tintuc = ? and ngaycapnhat = ?',[$ma,$time]);
    }
    public function get_mavoi_ma_tintuc_vathoigianmax($ma){
        return DB::select('SELECT *  FROM '.$this->table.' where ma_tintuc = ? ORDER BY ngaycapnhat DESC LIMIT 1',[$ma]);
    }

    public function get_join_user_gionglua($ma){
        $data = DB::table($this->table)
            ->join('users', $this->table.'.ma_user', '=', 'users.id')
            ->where('ma_gionglua',$ma)->get();
            return $data;
    }
    public function get_join_user_saubenh($ma){
        $data = DB::table($this->table)
            ->join('users', $this->table.'.ma_user', '=', 'users.id')
            ->where('ma_saubenh',$ma)->get();
            return $data;
    }
    public function get_join_user_tintuc($ma){
        $data = DB::table($this->table)
            ->join('users', $this->table.'.ma_user', '=', 'users.id')
            ->where('ma_tintuc',$ma)->get();
            return $data;
    }
    public function delete_voima($id)
    {
        return DB::delete('delete from '.$this->table.' where ma = ?', [$id]);
    }
}
