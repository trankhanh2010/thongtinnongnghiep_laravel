<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tintuc extends Model
{
    use HasFactory;
    protected $table = 'tintuc';

    public function insert($data){
        
        DB::insert('INSERT INTO '.$this->table.' (
            ma, 
            ten,
            noidung,
            ngaytao,
            ngaycapnhat) 
        values (null,?,?,?,?)', $data);
    }

    public function get_Mavoiten($ten){
        return DB::select('select ma from '.$this->table.' where ten = ?',[$ten]);
    }
    public function getAll(){
        $data =  DB::table($this->table)->paginate(4);
        //paginate không dùng được sau ->get()
        // $data =  DB::table($this->table);
        return $data;
    }
    public function getAll_voiKey($key){
        //$data = DB::select("select * from dulieutrolyao where cau_hoi like '%".$key."%'");
        $data =  DB::table($this->table);
        $data = $data->where('ten', 'like', '%'.$key.'%');
        $data = $data->paginate(4);       
        return $data;
    }
    
    public function get_Detail($ma){
        return DB::select('select * from '.$this->table.' where ma = ?',[$ma]);
    }
    public function update_Tintuc($data,$ma){
        return DB::update('update '.$this->table.' set
        ten = ?,
        noidung = ?,
        ngaycapnhat = ? 
        where ma = ? ', [$data[0],$data[1],$data[2],$ma]);
    }
    public function delete_tintuc($id)
    {
        return DB::delete('delete from '.$this->table.' where ma = ?', [$id]);
    }
    public function get_tintucmoi($sl){
        return DB::table('tintuc')->select('*')->limit($sl)->orderByDesc('ngaytao')->get();
        
    }
    public function get_tintucnoibat($sl){
        return DB::table('tintuc')->select('*')->limit($sl)->orderByDesc('ten')->get();
    }
    public function get_tintuckhac($sl){
        return DB::table('tintuc')->select('*')->limit($sl)->orderByRaw('ngaytao')->get();
    }
}
