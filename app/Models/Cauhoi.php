<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cauhoi extends Model
{
    use HasFactory;
    protected $table = 'cauhoi';
    

    public function insert($data){
        
        DB::insert('INSERT INTO '.$this->table.' (
            ten,traloi
) 
        values (?,?)', $data);
    }
    public function get_Mavoiten($ten){
        return DB::select('select ma from '.$this->table.' where ten = ?',[$ten]);
    }
    public function get_Detail($ma){
        return DB::select('select * from '.$this->table.' where ma = ?',[$ma]);
    }
    public function delete_cauhoi($id)
    {
        return DB::delete('delete from '.$this->table.' where ma = ?', [$id]);
    }
}
