<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Chongchiutot extends Model
{
    use HasFactory;
    protected $table = 'chongchiutot';

    public function insert($data){
        
        DB::insert('INSERT INTO chongchiutot (
            ma,
            ma_gionglua, 
            ma_saubenh) 
        values (null,?,?)', $data);
    }

    public function ds_theoma_gionglua($ma){
        
        return DB::select('select * from chongchiutot where ma_gionglua = ?',[$ma]);
    }
    public function ds_theoma_saubenh($ma){
        
        return DB::select('select * from chongchiutot where ma_saubenh = ?',[$ma]);
    }
    public function delete_voimagionglua_va_masaubenh($ma1,$ma2)
    {
        return DB::delete('delete from chongchiutot where ma_gionglua = ? and ma_saubenh = ?', [$ma1,$ma2]);
    }
    public function delete_voimagionglua($id)
    {
        return DB::delete('delete from chongchiutot where ma_gionglua = ?', [$id]);
    }
    public function delete_voimasaubenh($id)
    {
        return DB::delete('delete from chongchiutot where ma_saubenh = ?', [$id]);
    }
}
