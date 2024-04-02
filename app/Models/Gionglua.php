<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Gionglua extends Model
{
    use HasFactory;
    protected $table = 'gionglua';

    public function insert($data){
        
        DB::insert('INSERT INTO gionglua (
            ma, 
            ten,
            dacdiem,
            thongtinkhac,
            ngaytao,
            ngaycapnhat) 
        values (null,?,?,?,?,?)', $data);
    }

    
    public function get_Mavoiten($ten){
        return DB::select('select ma from gionglua where ten = ?',[$ten]);
    }
    // public function getAll(){
    //     $data = DB::select('select * from '.$this->table);
    //     //paginate không dùng được sau ->get()
    //     // $data =  DB::table($this->table);
    //     return $data;
    // }
    // public function getAll_kkey(){
    //     $data =  DB::table($this->table);
    //     $data = $data->paginate(6);
    //     return $data;
    // }
    // public function getAll_voikey_kpa($key){
    //     $data =  DB::table($this->table);
    //     $data = $data->where('ten', 'like', '%'.$key.'%');
    //     return $data;
    // }
    // public function getAll_voiKey($key){
    //     //$data = DB::select("select * from dulieutrolyao where cau_hoi like '%".$key."%'");
    //     $data =  DB::table($this->table);
    //     $data = $data->where('ten', 'like', '%'.$key.'%');
    //     $data = $data->paginate(6);       
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
        return DB::select('select * from gionglua where ma = ?',[$ma]);
    }
    public function getAll_not_in_chongchiutot($ma){
        $data = DB::select('select * from '.$this->table.' where ma NOT IN (select ma_gionglua from chongchiutot where ma_saubenh ='.$ma. ')');
        return $data;
    }
    public function getAll_not_in_debinhiem($ma){
        $data = DB::select('select * from '.$this->table.' where ma NOT IN (select ma_gionglua from debinhiem where ma_saubenh ='.$ma. ')');
        return $data;
    }

    public function getAll_not_in_chongchiutot_debinhiem($ma){
        $data = DB::select('select * from '.$this->table.' where ma NOT IN (select ma_gionglua from debinhiem where ma_saubenh ='.$ma.') and ma NOT IN (select ma_gionglua from chongchiutot where ma_saubenh ='.$ma.')');
        return $data;
    }
    public function update_Gionglua($data,$ma){
        return DB::update('update gionglua set
        ten = ?,
        dacdiem = ?,
        thongtinkhac = ?,
        ngaycapnhat = ? 
        where ma = ? ', [$data[0],$data[1],$data[2],$data[3],$ma]);
    }
    public function delete_Gionglua($id)
    {
        return DB::delete('delete from gionglua where ma = ?', [$id]);
    }

}   
