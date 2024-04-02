<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Co_lienquan_gionglua extends Model
{
    use HasFactory;
    protected $table = 'co_lienquan_gionglua';

    public function insert($data){
        
        DB::insert('INSERT INTO '.$this->table.' (
            ma,
            ma_gionglua, 
            ma_tintuc) 
        values (null,?,?)', $data);
    }
    public function delete_tintuc($id)
    {
        return DB::delete('delete from '.$this->table.' where ma_tintuc = ?', [$id]);
    }
    public function delete_Gionglua($id)
    {
        return DB::delete('delete from '.$this->table.' where ma_gionglua = ?', [$id]);
    }
    public function ds_theoma_tintuc($ma){
        
        return DB::select('select * from '.$this->table.' where ma_tintuc = ?',[$ma]);
    }
    public function delete_voimagionglua_va_matintuc($ma1,$ma2)
    {
        return DB::delete('delete from '.$this->table.' where ma_gionglua = ? and ma_tintuc = ?', [$ma1,$ma2]);
    }
}
