<?php

namespace App\Imports;

use App\Models\Cauhoi;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;
class CauhoiImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function rules(): array
    {
        return [
           
            'ten' => [
                'required|unique:cauhoi,ten',
            ],
            'traloi' => [
                'required',
            ],
         
        ];
    }
    
    public function collection(Collection $rows)
    {
       
        foreach ($rows as $row)
        {
            $check = DB::table('cauhoi')->where('ten',$row[0])->value('traloi');
            if($check != null){
                DB::table('cauhoi')->where('ten', $row[0])
                ->update(['traloi' =>  $row[1]]);
            }
            else{
                DB::table('cauhoi')->insert([
                    'ten' => $row[0],
                    'traloi' => $row[1],
                ]);
        }
           
            // Cauhoi::create([
            //     'ma' =>'',
            //     'ten' => $row['ten'],
            //     'traloi' => $row['traloi'],
            // ]);
        }
    }

   
}
