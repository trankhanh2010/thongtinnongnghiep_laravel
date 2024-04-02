<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Saubenh extends Model
{
    use HasFactory;
    protected $table = 'saubenh';

    public function insert($data){
        
        DB::insert('INSERT INTO saubenh (
            ma, 
            ten,
            dacdiem,
            thongtinkhac,
            ngaytao,
            ngaycapnhat) 
        values (null,?,?,?,?,?)', $data);
    }

    public function get_Mavoiten($ten){
        return DB::select('select ma from saubenh where ten = ?',[$ten]);
    }
    // public function getAll(){
    //     $data = DB::select('select * from '.$this->table);
    //     //paginate không dùng được sau ->get()
    //     // $data =  DB::table($this->table);
    //     return $data;
    // }
    public function getAll(){
        $data =  DB::table($this->table)->simplePaginate(4);
        //paginate không dùng được sau ->get()
        // $data =  DB::table($this->table);
        return $data;
    }
    public function getAll_voiKey($key){
        //$data = DB::select("select * from dulieutrolyao where cau_hoi like '%".$key."%'");
        $data =  DB::table($this->table);
        $data = $data->where('ten', 'like', '%'.$key.'%');
        $data = $data->simplePaginate(4);       
        return $data;
    }
    
    
    public function get_Detail($ma){
        return DB::select('select * from saubenh where ma = ?',[$ma]);
    }
    public function getAll_not_in_chongchiutot($ma){
        $data = DB::select('select * from '.$this->table.' where ma NOT IN (select ma_saubenh from chongchiutot where ma_gionglua ='.$ma. ')');
        return $data;
    }
    public function getAll_not_in_debinhiem($ma){
        $data = DB::select('select * from '.$this->table.' where ma NOT IN (select ma_saubenh from debinhiem where ma_gionglua ='.$ma. ')');
        return $data;
    }

    public function getAll_not_in_chongchiutot_debinhiem($ma){
        $data = DB::select('select * from '.$this->table.' where ma NOT IN (select ma_saubenh from debinhiem where ma_gionglua ='.$ma.') and ma NOT IN (select ma_saubenh from chongchiutot where ma_gionglua ='.$ma.')');
        return $data;
    }
    public function update_Saubenh($data,$ma){
        return DB::update('update saubenh set
        ten = ?,
        dacdiem = ?,
        thongtinkhac = ?,
        ngaycapnhat = ? 
        where ma = ? ', [$data[0],$data[1],$data[2],$data[3],$ma]);
    }
    public function delete_saubenh($id)
    {
        return DB::delete('delete from saubenh where ma = ?', [$id]);
    }
}
