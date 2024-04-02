<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Co_loai_tintuc extends Model
{
    use HasFactory;
    protected $table = 'co_loai_tintuc';

    public function insert($data){
        
        DB::insert('INSERT INTO '.$this->table.' (
            ma, 
            ma_tintuc,
            ma_loai_tintuc) 
        values (null,?,?)', $data);
    }
    public function delete_tintuc($id)
    {
        return DB::delete('delete from '.$this->table.' where ma_tintuc = ?', [$id]);
    }
    public function ds_theoma_tintuc($ma){
        
        return DB::select('select * from '.$this->table.' where ma_tintuc = ?',[$ma]);
    }
    public function delete_voimatintuc_va_maloaitintuc($ma1,$ma2)
    {
        return DB::delete('delete from '.$this->table.' where ma_tintuc = ? and ma_loai_tintuc = ?', [$ma1,$ma2]);
    }
}
