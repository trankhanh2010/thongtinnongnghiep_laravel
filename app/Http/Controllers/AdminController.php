<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CauhoiImport;
use Exception;
use Illuminate\Support\Facades\Storage;
use File;
use Repsonse;

use App\Models\Gionglua;
use App\Models\Saubenh;
use App\Models\Danhsach_hinhanh;
use App\Models\Chongchiutot;
use App\Models\Debinhiem;
use App\Models\Thongtin_capnhat;
use App\Models\Danhsach_hinhanh_capnhat;
use App\Models\User;
use App\Models\Tintuc;
use App\Models\Luotxem;
use App\Models\Co_lienquan_gionglua;
use App\Models\Loai_tintuc;
use App\Models\Co_loai_tintuc;
use App\Models\Cauhoi;
use App\Models\Phanhoi;
use App\Models\Binhluan;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class AdminController extends Controller
{
    public $data = [];

    private $gionglua;
    private $saubenh;
    private $chongchiutot;
    private $debinhiem;
    private $tintuc;
    private $luotxem;
    private $danhsach_hinhanh;
    private $danhsach_hinhanh_capnhat;
    private $thongtin_capnhat;
    private $co_lienquan_gionglua;
    private $loai_tintuc;
    private $co_loai_tintuc;
    private $cauhoi;
    private $phanhoi;
    private $binhluan;

    public function __construct()
    {
        $this->gionglua = new Gionglua();
        $this->danhsach_hinhanh = new Danhsach_hinhanh();
        $this->saubenh = new Saubenh();
        $this->chongchiutot = new Chongchiutot();
        $this->debinhiem = new Debinhiem();
        $this->tintuc = new Tintuc();
        $this->luotxem = new luotxem();
        $this->thongtin_capnhat = new Thongtin_capnhat();
        $this->danhsach_hinhanh_capnhat = new Danhsach_hinhanh_capnhat();
        $this->co_lienquan_gionglua = new Co_lienquan_gionglua();
        $this->loai_tintuc = new Loai_tintuc();
        $this->co_loai_tintuc = new Co_loai_tintuc();
        $this->cauhoi = new Cauhoi();
        $this->phanhoi = new Phanhoi();
        $this->binhluan = new Binhluan();


        $sql1 = 'SELECT ten, SUM(luotxem) as tong, ngaytao, ngaycapnhat
        FROM (
            SELECT ten,luotxem,ma_tintuc,ngay,ngaytao, ngaycapnhat FROM tintuc
            INNER JOIN luotxem ON tintuc.ma = luotxem.ma_tintuc
        ) t
        GROUP BY ma_tintuc
        HAVING SUM(luotxem)
        ORDER BY tong DESC  LIMIT 5';
        $sql2 = 'SELECT ten, SUM(luotxem) as tong, ngaytao, ngaycapnhat
                FROM (
                    SELECT ten,luotxem,ma_gionglua,ngay,ngaytao, ngaycapnhat FROM gionglua
                    INNER JOIN luotxem ON gionglua.ma = luotxem.ma_gionglua
                ) t
                GROUP BY ma_gionglua
                HAVING SUM(luotxem)
                ORDER BY tong DESC  LIMIT 5';
        $sql3 = 'SELECT ten, SUM(luotxem) as tong, ngaytao, ngaycapnhat
                        FROM (
                            SELECT ten,luotxem,ma_saubenh,ngay,ngaytao, ngaycapnhat FROM saubenh
                            INNER JOIN luotxem ON saubenh.ma = luotxem.ma_saubenh
                        ) t
                        GROUP BY ma_saubenh
                        HAVING SUM(luotxem)
                        ORDER BY tong DESC  LIMIT 5';

        $this->data['ds_tintuc_10'] = $this->luotxem->selectsql($sql1);
        $this->data['ds_gionglua_10'] = $this->luotxem->selectsql($sql2);
        $this->data['ds_saubenh_10'] = $this->luotxem->selectsql($sql3);
        $this->data['tong_nguoidung'] = DB::table('users')->count();
        $this->data['tong_tintuc'] = DB::table('tintuc')->count();
        $this->data['tong_gionglua'] = DB::table('gionglua')->count();
        $this->data['tong_saubenh'] = DB::table('saubenh')->count();
        $this->data['tong_cauhoi'] = DB::table('cauhoi')->count();
        $this->data['tong_loai_tintuc'] = DB::table('loai_tintuc')->count();
    }

    public function home()
    {
        $this->data['title'] = 'Trang chủ';
        $this->data['url'] = 'home';



        return view("admin.home", $this->data);
    }

    public function add_gionglua()
    {
        $this->data['title'] = 'Thêm giống lúa mới';
        $this->data['url'] = 'add_gionglua';
        $this->data['ds_saubenh'] = DB::table('saubenh')->get();
        return view("admin.add_gionglua", $this->data);
    }

    public function postadd_gionglua(Request $request)
    {
        $request->validate(
            [
                'ten' => 'required|unique:gionglua,ten',
                'dacdiem' => 'required',
                'thongtinkhac' => 'required',

            ],
            [
                'ten.required' => 'Tên giống lúa bắt buộc phải nhập',
                'ten.unique' => 'Tên giống lúa đã tồn tại trong hệ thống',
                'dacdiem.required' => 'Đặc điểm của giống lúa bắt buộc phải nhập',
                'thongtinkhac.required' => 'Thông tin khác của giống lúa bắt buộc phải nhập',

            ]
        );
        $time = strtotime(date("Y-m-d H:i:s"));
        $dataInsert = [
            $request->ten,
            $request->dacdiem,
            $request->thongtinkhac,
            $time,
            $time,
        ];
        $this->gionglua->insert($dataInsert);
        $ma = $this->gionglua->get_Mavoiten($request->ten)[0]->ma;

        if ($request->chongchiutot != null) {
            $str = $request->chongchiutot;
            $char = ",";
            $start = 0;
            $num = substr_count($str, $char, $start);

            $str = explode(",", $request->chongchiutot);

            for ($i = 0; $i < $num; $i++) {

                $ma_saubenh = $this->saubenh->get_Mavoiten($str[$i])[0]->ma;
                $ma_gionglua = $this->gionglua->get_Mavoiten($request->ten)[0]->ma;


                $dataInsertchongchiutot = [
                    $ma_gionglua,
                    $ma_saubenh,

                ];
                $this->chongchiutot->insert($dataInsertchongchiutot);
            }
        }

        if ($request->debinhiem != null) {
            $str = $request->debinhiem;
            $char = ",";
            $start = 0;
            $num = substr_count($str, $char, $start);

            $str = explode(",", $request->debinhiem);

            for ($i = 0; $i < $num; $i++) {

                $ma_saubenh = $this->saubenh->get_Mavoiten($str[$i])[0]->ma;
                $ma_gionglua = $this->gionglua->get_Mavoiten($request->ten)[0]->ma;

                $dataInsertdebinhiem = [
                    $ma_gionglua,
                    $ma_saubenh,

                ];
                $this->debinhiem->insert($dataInsertdebinhiem);
            }
        }
        //
        $dataInsert_thongtin_capnhat = [
            $ma,
            null,
            Auth::user()->id,
            $request->ten,
            $request->dacdiem,
            $request->thongtinkhac,
            $request->chongchiutot ?? null,
            $request->debinhiem ?? null,
            $time,
        ];
        $this->thongtin_capnhat->insert_thongtin_capnhat_gionglua($dataInsert_thongtin_capnhat);
        $ma_thongtin_capnhat = $this->thongtin_capnhat->get_mavoi_ma_gionglua_vathoigian($ma, $time)[0]->ma;
        //
        if ($request->hinhanh != null) {
            foreach ($request->hinhanh as $key => $item) {
                $ten_anh = 'gionglua' . strtotime(date("Y-m-d H:i:s")) . $key;
                $image = $request->file('hinhanh')[$key];
                $destinationPath = public_path('/hinhanh/hinhanh_gionglua');
                $image->move($destinationPath, $ten_anh);
                $dataInsert2 = [
                    $ma,
                    $ten_anh,
                ];
                $this->danhsach_hinhanh->insert_hinhanh_gionglua($dataInsert2);
                //
                $dataInsert_danhsach_hinhanh_capnhat = [
                    $ma_thongtin_capnhat,
                    $ten_anh,
                ];
                $this->danhsach_hinhanh_capnhat->insert_hinhanh($dataInsert_danhsach_hinhanh_capnhat);
                //
            }
        }
        return redirect(route('admin.add_gionglua'))->with('msgSuc', 'Thêm mới thành công');
    }

    public function ds_gionglua(Request $request)
    {
        $this->data['url'] = 'ds_gionglua';
        $this->data['title'] = 'Danh sách giống lúa';
        // $this->data['ds']=$this->gionglua->getAll();
        $this->data['ds'] = DB::table('gionglua')->get();
        foreach ($this->data['ds'] as $key => $item) {
            $item->tong_binhluan = DB::table('binhluan')->where('ma_gionglua', $item->ma)->count('ma');
            $item->tong_luotxem = DB::table('luotxem')->where('ma_gionglua', $item->ma)->sum('luotxem');
        }
        return view("admin.ds_gionglua", $this->data);
    }

    public function delete_gionglua($ma_gionglua)
    {
        if (!empty($ma_gionglua)) {
            $detail_gionglua = $this->gionglua->get_Detail($ma_gionglua);
            if (!empty($detail_gionglua)) {
                foreach ($this->thongtin_capnhat->get_all_desctime_gionglua($ma_gionglua) as $key => $item) {
                    $this->danhsach_hinhanh_capnhat->delete_voima_thongtin_capnhat($item->ma);
                    $this->thongtin_capnhat->delete_voima($item->ma);
                }
                $this->danhsach_hinhanh->delete_voima_gionglua($ma_gionglua);
                $this->chongchiutot->delete_voimagionglua($ma_gionglua);
                $this->debinhiem->delete_voimagionglua($ma_gionglua);
                $this->luotxem->delete_Gionglua($ma_gionglua);
                $this->co_lienquan_gionglua->delete_Gionglua($ma_gionglua);
                $this->binhluan->delete_gionglua($ma_gionglua);


                $this->gionglua->delete_Gionglua($ma_gionglua);
            } else {
                return redirect(route('admin.ds_gionglua'))->with('msgErr', 'Thất bại');
            }
        }

        return redirect(route('admin.ds_gionglua'))->with('msgSuc', 'Xóa thành công');
    }
    /////




    public function add_saubenh()
    {
        $this->data['title'] = 'Thêm sâu bệnh mới';
        $this->data['url'] = 'add_saubenh';
        $this->data['ds_gionglua'] = DB::table('gionglua')->get();
        return view("admin.add_saubenh", $this->data);
    }

    public function postadd_saubenh(Request $request)
    {

        $request->validate(
            [
                'ten' => 'required|unique:saubenh,ten',
                'dacdiem' => 'required',
                'thongtinkhac' => 'required',

            ],
            [
                'ten.required' => 'Tên sâu bệnh bắt buộc phải nhập',
                'ten.unique' => 'Tên sâu bệnh đã tồn tại trong hệ thống',
                'dacdiem.required' => 'Đặc điểm của sâu bệnh bắt buộc phải nhập',
                'thongtinkhac.required' => 'Thông tin khác của sâu bệnh bắt buộc phải nhập',

            ]
        );
        $time = strtotime(date("Y-m-d H:i:s"));
        $dataInsert = [
            $request->ten,
            $request->dacdiem,
            $request->thongtinkhac,
            $time,
            $time,
        ];
        $this->saubenh->insert($dataInsert);

        $ma = $this->saubenh->get_Mavoiten($request->ten)[0]->ma;


        // if ($request->hinhanh != null) {
        //     foreach ($request->hinhanh as $key => $item) {
        //         $ten_anh = 'saubenh'. strtotime(date("Y-m-d H:i:s")) . $key;


        //         $image = $request->file('hinhanh')[$key];
        //         $destinationPath = public_path('/hinhanh/hinhanh_saubenh');
        //         $image->move($destinationPath, $ten_anh);
        //         $dataInsert2 = [
        //             $ma,
        //             $ten_anh,
        //         ];
        //         $this->danhsach_hinhanh->insert_hinhanh_saubenh($dataInsert2);
        //     }
        // }
        if ($request->chongchiutot != null) {
            $str = $request->chongchiutot;
            $char = ",";
            $start = 0;
            $num = substr_count($str, $char, $start);

            $str = explode(",", $request->chongchiutot);

            for ($i = 0; $i < $num; $i++) {

                $ma_saubenh = $this->saubenh->get_Mavoiten($request->ten)[0]->ma;
                $ma_gionglua = $this->gionglua->get_Mavoiten($str[$i])[0]->ma;


                $dataInsertchongchiutot = [
                    $ma_gionglua,
                    $ma_saubenh,

                ];
                $this->chongchiutot->insert($dataInsertchongchiutot);
            }
        }

        if ($request->debinhiem != null) {
            $str = $request->debinhiem;
            $char = ",";
            $start = 0;
            $num = substr_count($str, $char, $start);

            $str = explode(",", $request->debinhiem);

            for ($i = 0; $i < $num; $i++) {

                $ma_saubenh = $this->saubenh->get_Mavoiten($request->ten)[0]->ma;
                $ma_gionglua = $this->gionglua->get_Mavoiten($str[$i])[0]->ma;

                $dataInsertdebinhiem = [
                    $ma_gionglua,
                    $ma_saubenh,

                ];
                $this->debinhiem->insert($dataInsertdebinhiem);
            }
        }
        //
        $dataInsert_thongtin_capnhat = [
            $ma,
            null,
            Auth::user()->id,
            $request->ten,
            $request->dacdiem,
            $request->thongtinkhac,
            $request->chongchiutot ?? null,
            $request->debinhiem ?? null,
            $time,
        ];
        $this->thongtin_capnhat->insert_thongtin_capnhat_saubenh($dataInsert_thongtin_capnhat);
        $ma_thongtin_capnhat = $this->thongtin_capnhat->get_mavoi_ma_saubenh_vathoigian($ma, $time)[0]->ma;
        //
        if ($request->hinhanh != null) {
            foreach ($request->hinhanh as $key => $item) {
                $ten_anh = 'saubenh' . strtotime(date("Y-m-d H:i:s")) . $key;
                $image = $request->file('hinhanh')[$key];
                $destinationPath = public_path('/hinhanh/hinhanh_saubenh');
                $image->move($destinationPath, $ten_anh);
                $dataInsert2 = [
                    $ma,
                    $ten_anh,
                ];
                $this->danhsach_hinhanh->insert_hinhanh_saubenh($dataInsert2);
                //
                $dataInsert_danhsach_hinhanh_capnhat = [
                    $ma_thongtin_capnhat,
                    $ten_anh,
                ];
                $this->danhsach_hinhanh_capnhat->insert_hinhanh($dataInsert_danhsach_hinhanh_capnhat);
                //
            }
        }
        return redirect(route('admin.add_saubenh'))->with('msgSuc', 'Thêm mới thành công');
    }

    public function edit_gionglua($ma_gionglua)
    {
        $this->data['url'] = '';

        $this->data['title'] = 'Chỉnh sửa thông tin giống lúa';
        if (!empty($ma_gionglua)) {
            $detail = $this->gionglua->get_Detail($ma_gionglua);
            if (!empty($detail)) {
                $this->data['detail'] = $detail[0];
                $this->data['ds_saubenh'] =  DB::table('saubenh')->get();
                $this->data['ds_saubenh1'] = $this->saubenh->getAll_not_in_chongchiutot($ma_gionglua);
                $this->data['ds_saubenh2'] = $this->saubenh->getAll_not_in_debinhiem($ma_gionglua);
                $this->data['ds_saubenh3'] = $this->saubenh->getAll_not_in_chongchiutot_debinhiem($ma_gionglua);
                $this->data['ds_hinhanh'] = $this->danhsach_hinhanh->ds_theoma_gionglua($ma_gionglua);
                $this->data['ds_chongchiutot'] = $this->chongchiutot->ds_theoma_gionglua($ma_gionglua);

                foreach ($this->data['ds_chongchiutot'] as $key => $item) {
                    $this->data['ds_chongchiutot'][$key]->ten_saubenh = $this->saubenh->get_Detail($item->ma_saubenh)[0]->ten;
                }
                $this->data['ds_debinhiem'] = $this->debinhiem->ds_theoma_gionglua($ma_gionglua);
                foreach ($this->data['ds_debinhiem'] as $key => $item) {
                    $this->data['ds_debinhiem'][$key]->ten_saubenh = $this->saubenh->get_Detail($item->ma_saubenh)[0]->ten;
                }

                foreach ($this->data['ds_saubenh'] as $key => $item) {
                    $this->data['ds_saubenh'][$key]->show = 0;

                    foreach ($this->data['ds_chongchiutot'] as $key1 => $item) {
                        if ($this->data['ds_chongchiutot'][$key1]->ma_saubenh ==   $this->data['ds_saubenh'][$key]->ma) {
                            $this->data['ds_saubenh'][$key]->show = 1;
                        }
                    }
                    foreach ($this->data['ds_debinhiem'] as $key2 => $item) {
                        if ($this->data['ds_debinhiem'][$key2]->ma_saubenh ==   $this->data['ds_saubenh'][$key]->ma) {
                            $this->data['ds_saubenh'][$key]->show = 2;
                        }
                    }
                }
            } else {
                return redirect(route('admin.home'));
            }
        } else {
            return redirect(route('admin.home'));
        }

        return view("admin.edit_gionglua", $this->data);
    }

    public function postedit_gionglua(Request $request, $ma_gionglua)
    {
        if ($request->ten != DB::table('gionglua')->where('ma', $ma_gionglua)) {
            $request->validate(
                [
                    'ten' => 'required|unique:gionglua,ten,' . $ma_gionglua . ',ma',
                ],
                [
                    'ten.required' => 'Tên giống lúa bắt buộc phải nhập',
                    'ten.unique' => 'Tên giống lúa đã tồn tại trong hệ thống',

                ]
            );
        }
        $request->validate(
            [
                'dacdiem' => 'required',
                'thongtinkhac' => 'required',
            ],
            [
                'dacdiem.required' => 'Đặc điểm của sâu bệnh bắt buộc phải nhập',
                'thongtinkhac.required' => 'Thông tin khác của sâu bệnh bắt buộc phải nhập',

            ]
        );
        $time = strtotime(date("Y-m-d H:i:s"));
        $dataInsert = [
            $request->ten,
            $request->dacdiem,
            $request->thongtinkhac,
            $time,
        ];
        $this->gionglua->update_Gionglua($dataInsert, $ma_gionglua);

        $ma = $this->gionglua->get_Mavoiten($request->ten)[0]->ma;

        if ($request->ds_xoachongchiutot != null) {
            $str = $request->ds_xoachongchiutot;
            $char = ",";
            $start = 0;
            $num = substr_count($str, $char, $start);
            $str = explode(",", $str);
            for ($i = 0; $i < $num; $i++) {
                $this->chongchiutot->delete_voimagionglua_va_masaubenh($ma_gionglua, $str[$i]);
            }
        }
        if ($request->chongchiutot != null) {
            $str = $request->chongchiutot;
            $char = ",";
            $start = 0;
            $num = substr_count($str, $char, $start);
            $str = explode(",", $request->chongchiutot);
            for ($i = 0; $i < $num; $i++) {
                $ma_saubenh = $this->saubenh->get_Mavoiten($str[$i])[0]->ma;
                $ma_gionglua = $this->gionglua->get_Mavoiten($request->ten)[0]->ma;
                $dataInsertchongchiutot = [
                    $ma_gionglua,
                    $ma_saubenh,

                ];
                $this->chongchiutot->insert($dataInsertchongchiutot);
            }
        }
        if ($request->ds_xoadebinhiem != null) {
            $str = $request->ds_xoadebinhiem;
            $char = ",";
            $start = 0;
            $num = substr_count($str, $char, $start);
            $str = explode(",", $str);
            for ($i = 0; $i < $num; $i++) {
                $this->debinhiem->delete_voimagionglua_va_masaubenh($ma_gionglua, $str[$i]);
            }
        }
        if ($request->debinhiem != null) {
            $str = $request->debinhiem;
            $char = ",";
            $start = 0;
            $num = substr_count($str, $char, $start);

            $str = explode(",", $request->debinhiem);

            for ($i = 0; $i < $num; $i++) {

                $ma_saubenh = $this->saubenh->get_Mavoiten($str[$i])[0]->ma;
                $ma_gionglua = $this->gionglua->get_Mavoiten($request->ten)[0]->ma;

                $dataInsertdebinhiem = [
                    $ma_gionglua,
                    $ma_saubenh,

                ];
                $this->debinhiem->insert($dataInsertdebinhiem);
            }
        }
        if ($request->ds_xoahinhanh != null) {
            $str = $request->ds_xoahinhanh;
            $char = ",";
            $start = 0;
            $num = substr_count($str, $char, $start);
            $str = explode(",", $str);

            for ($i = 0; $i < $num; $i++) {
                $this->danhsach_hinhanh->delete_voima($str[$i]);
            }
        }

        if ($request->hinhanh != null) {
            foreach ($request->hinhanh as $key => $item) {
                $ten_anh = 'gionglua' . strtotime(date("Y-m-d H:i:s")) . $key;


                $image = $request->file('hinhanh')[$key];
                $destinationPath = public_path('/hinhanh/hinhanh_gionglua');
                $image->move($destinationPath, $ten_anh);
                $dataInsert2 = [
                    $ma,
                    $ten_anh,
                ];
                $this->danhsach_hinhanh->insert_hinhanh_gionglua($dataInsert2);
            }
        }
        //

        $txt_chongchiutot = '';
        foreach ($this->chongchiutot->ds_theoma_gionglua($ma_gionglua) as $key => $item) {
            $txt_chongchiutot = $txt_chongchiutot . $this->saubenh->get_Detail($item->ma_saubenh)[0]->ten . ',';
        }
        $txt_debinhiem = '';
        foreach ($this->debinhiem->ds_theoma_gionglua($ma_gionglua) as $key => $item) {
            $txt_debinhiem = $txt_debinhiem . $this->saubenh->get_Detail($item->ma_saubenh)[0]->ten . ',';
        }
        $ma_thongtin_capnhat = $this->thongtin_capnhat->get_mavoi_ma_gionglua_vathoigianmax($ma_gionglua)[0]->ma;
        $dataInsert_thongtin_capnhat = [
            $ma,
            $ma_thongtin_capnhat,
            Auth::user()->id,
            $request->ten,
            $request->dacdiem,
            $request->thongtinkhac,
            $txt_chongchiutot ?? null,
            $txt_debinhiem ?? null,
            $time,
        ];
        $this->thongtin_capnhat->insert_thongtin_capnhat_gionglua($dataInsert_thongtin_capnhat);
        $ma_thongtin_capnhat = $this->thongtin_capnhat->get_mavoi_ma_gionglua_vathoigian($ma, $time)[0]->ma;
        foreach ($this->danhsach_hinhanh->ds_theoma_gionglua($ma_gionglua) as $key => $item) {
            $dataInsert_danhsach_hinhanh_capnhat = [
                $ma_thongtin_capnhat,
                $item->ten,
            ];
            $this->danhsach_hinhanh_capnhat->insert_hinhanh($dataInsert_danhsach_hinhanh_capnhat);
        }
        //
        return redirect(route('admin.edit_gionglua', $ma_gionglua))->with('msgSuc', 'Chỉnh sửa thông tin thành công');
    }

    public function edit_saubenh($ma_saubenh)
    {
        $this->data['url'] = '';

        $this->data['title'] = 'Chỉnh sửa thông tin sâu bệnh';
        if (!empty($ma_saubenh)) {
            $detail = $this->saubenh->get_Detail($ma_saubenh);
            if (!empty($detail)) {
                $this->data['detail'] = $detail[0];
                $this->data['ds_saubenh'] =  DB::table('gionglua')->get();
                $this->data['ds_saubenh1'] = $this->gionglua->getAll_not_in_chongchiutot($ma_saubenh);
                $this->data['ds_saubenh2'] = $this->gionglua->getAll_not_in_debinhiem($ma_saubenh);
                $this->data['ds_saubenh3'] = $this->gionglua->getAll_not_in_chongchiutot_debinhiem($ma_saubenh);
                $this->data['ds_hinhanh'] = $this->danhsach_hinhanh->ds_theoma_saubenh($ma_saubenh);
                $this->data['ds_chongchiutot'] = $this->chongchiutot->ds_theoma_saubenh($ma_saubenh);

                foreach ($this->data['ds_chongchiutot'] as $key => $item) {
                    $this->data['ds_chongchiutot'][$key]->ten_gionglua = $this->gionglua->get_Detail($item->ma_gionglua)[0]->ten;
                }
                $this->data['ds_debinhiem'] = $this->debinhiem->ds_theoma_saubenh($ma_saubenh);
                foreach ($this->data['ds_debinhiem'] as $key => $item) {
                    $this->data['ds_debinhiem'][$key]->ten_gionglua = $this->gionglua->get_Detail($item->ma_gionglua)[0]->ten;
                }

                foreach ($this->data['ds_saubenh'] as $key => $item) {
                    $this->data['ds_saubenh'][$key]->show = 0;

                    foreach ($this->data['ds_chongchiutot'] as $key1 => $item) {
                        if ($this->data['ds_chongchiutot'][$key1]->ma_gionglua ==   $this->data['ds_saubenh'][$key]->ma) {
                            $this->data['ds_saubenh'][$key]->show = 1;
                        }
                    }
                    foreach ($this->data['ds_debinhiem'] as $key2 => $item) {
                        if ($this->data['ds_debinhiem'][$key2]->ma_gionglua ==   $this->data['ds_saubenh'][$key]->ma) {
                            $this->data['ds_saubenh'][$key]->show = 2;
                        }
                    }
                }
            } else {
                return redirect(route('admin.home'));
            }
        } else {
            return redirect(route('admin.home'));
        }

        return view("admin.edit_saubenh", $this->data);
    }

    public function postedit_saubenh(Request $request, $ma_saubenh)
    {
        if ($request->ten != DB::table('saubenh')->where('ma', $ma_saubenh)) {
            $request->validate(
                [
                    'ten' => 'required|unique:saubenh,ten,' . $ma_saubenh . ',ma',
                ],
                [
                    'ten.required' => 'Tên sâu bệnh bắt buộc phải nhập',
                    'ten.unique' => 'Tên sâu bệnh đã tồn tại trong hệ thống',

                ]
            );
        }
        $request->validate(
            [
                'dacdiem' => 'required',
                'thongtinkhac' => 'required',
            ],
            [
                'dacdiem.required' => 'Đặc điểm của sâu bệnh bắt buộc phải nhập',
                'thongtinkhac.required' => 'Thông tin khác của sâu bệnh bắt buộc phải nhập',

            ]
        );
        $time = strtotime(date("Y-m-d H:i:s"));
        $dataInsert = [
            $request->ten,
            $request->dacdiem,
            $request->thongtinkhac,
            $time,
        ];
        $this->saubenh->update_Saubenh($dataInsert, $ma_saubenh);

        $ma = $this->saubenh->get_Mavoiten($request->ten)[0]->ma;

        if ($request->ds_xoahinhanh != null) {
            $str = $request->ds_xoahinhanh;
            $char = ",";
            $start = 0;
            $num = substr_count($str, $char, $start);
            $str = explode(",", $str);

            for ($i = 0; $i < $num; $i++) {
                $this->danhsach_hinhanh->delete_voima($str[$i]);
            }
        }

        if ($request->hinhanh != null) {
            foreach ($request->hinhanh as $key => $item) {
                $ten_anh = 'saubenh' . strtotime(date("Y-m-d H:i:s")) . $key;


                $image = $request->file('hinhanh')[$key];
                $destinationPath = public_path('/hinhanh/hinhanh_saubenh');
                $image->move($destinationPath, $ten_anh);
                $dataInsert2 = [
                    $ma,
                    $ten_anh,
                ];
                $this->danhsach_hinhanh->insert_hinhanh_saubenh($dataInsert2);
            }
        }
        if ($request->ds_xoachongchiutot != null) {
            $str = $request->ds_xoachongchiutot;
            $char = ",";
            $start = 0;
            $num = substr_count($str, $char, $start);
            $str = explode(",", $str);
            for ($i = 0; $i < $num; $i++) {
                $this->chongchiutot->delete_voimagionglua_va_masaubenh($str[$i], $ma_saubenh);
            }
        }
        if ($request->chongchiutot != null) {
            $str = $request->chongchiutot;
            $char = ",";
            $start = 0;
            $num = substr_count($str, $char, $start);
            $str = explode(",", $request->chongchiutot);
            for ($i = 0; $i < $num; $i++) {
                $ma_saubenh = $this->saubenh->get_Mavoiten($request->ten)[0]->ma;
                $ma_gionglua = $this->gionglua->get_Mavoiten($str[$i])[0]->ma;
                $dataInsertchongchiutot = [
                    $ma_gionglua,
                    $ma_saubenh,
                ];
                $this->chongchiutot->insert($dataInsertchongchiutot);
            }
        }
        if ($request->ds_xoadebinhiem != null) {
            $str = $request->ds_xoadebinhiem;
            $char = ",";
            $start = 0;
            $num = substr_count($str, $char, $start);
            $str = explode(",", $str);
            for ($i = 0; $i < $num; $i++) {
                $this->debinhiem->delete_voimagionglua_va_masaubenh($str[$i], $ma_saubenh);
            }
        }
        if ($request->debinhiem != null) {
            $str = $request->debinhiem;
            $char = ",";
            $start = 0;
            $num = substr_count($str, $char, $start);

            $str = explode(",", $request->debinhiem);

            for ($i = 0; $i < $num; $i++) {

                $ma_saubenh = $this->saubenh->get_Mavoiten($request->ten)[0]->ma;
                $ma_gionglua = $this->gionglua->get_Mavoiten($str[$i])[0]->ma;

                $dataInsertdebinhiem = [
                    $ma_gionglua,
                    $ma_saubenh,

                ];
                $this->debinhiem->insert($dataInsertdebinhiem);
            }
        }
        //

        $txt_chongchiutot = '';
        foreach ($this->chongchiutot->ds_theoma_saubenh($ma_saubenh) as $key => $item) {
            $txt_chongchiutot = $txt_chongchiutot . $this->gionglua->get_Detail($item->ma_gionglua)[0]->ten . ',';
        }
        $txt_debinhiem = '';
        foreach ($this->debinhiem->ds_theoma_saubenh($ma_saubenh) as $key => $item) {
            $txt_debinhiem = $txt_debinhiem . $this->gionglua->get_Detail($item->ma_gionglua)[0]->ten . ',';
        }
        $ma_thongtin_capnhat = $this->thongtin_capnhat->get_mavoi_ma_saubenh_vathoigianmax($ma_saubenh)[0]->ma;
        $dataInsert_thongtin_capnhat = [
            $ma,
            $ma_thongtin_capnhat,
            Auth::user()->id,
            $request->ten,
            $request->dacdiem,
            $request->thongtinkhac,
            $txt_chongchiutot ?? null,
            $txt_debinhiem ?? null,
            $time,
        ];
        $this->thongtin_capnhat->insert_thongtin_capnhat_saubenh($dataInsert_thongtin_capnhat);
        $ma_thongtin_capnhat = $this->thongtin_capnhat->get_mavoi_ma_saubenh_vathoigian($ma, $time)[0]->ma;
        foreach ($this->danhsach_hinhanh->ds_theoma_saubenh($ma_saubenh) as $key => $item) {
            $dataInsert_danhsach_hinhanh_capnhat = [
                $ma_thongtin_capnhat,
                $item->ten,
            ];
            $this->danhsach_hinhanh_capnhat->insert_hinhanh($dataInsert_danhsach_hinhanh_capnhat);
        }
        //
        return redirect(route('admin.edit_saubenh', $ma_saubenh))->with('msgSuc', 'Chỉnh sửa thông tin thành công');
    }
    public function ds_saubenh(Request $request)
    {
        $this->data['url'] = 'ds_saubenh';
        $this->data['title'] = 'Danh sách sâu bệnh';
        $this->data['ds'] = DB::table('saubenh')->get();
        foreach ($this->data['ds'] as $key => $item) {
            $item->tong_binhluan = DB::table('binhluan')->where('ma_saubenh', $item->ma)->count('ma');
            $item->tong_luotxem = DB::table('luotxem')->where('ma_saubenh', $item->ma)->sum('luotxem');
        }

        return view("admin.ds_saubenh", $this->data);
    }

    public function delete_saubenh($ma)
    {
        if (!empty($ma)) {
            $detail_saubenh = $this->saubenh->get_Detail($ma);
            if (!empty($detail_saubenh)) {
                foreach ($this->thongtin_capnhat->get_all_desctime_saubenh($ma) as $key => $item) {
                    $this->danhsach_hinhanh_capnhat->delete_voima_thongtin_capnhat($item->ma);
                    $this->thongtin_capnhat->delete_voima($item->ma);
                }
                $this->danhsach_hinhanh->delete_voima_saubenh($ma);
                $this->chongchiutot->delete_voimasaubenh($ma);
                $this->debinhiem->delete_voimasaubenh($ma);
                $this->luotxem->delete_Saubenh($ma);
                $this->binhluan->delete_saubenh($ma);

                $this->saubenh->delete_saubenh($ma);
            } else {
                return redirect(route('admin.ds_saubenh'))->with('msgErr', 'Thất bại');
            }
        }
        return redirect(route('admin.ds_saubenh'))->with('msgSuc', 'Xóa thành công');
    }

    ////

    public function add_nguoidung()
    {
        $this->data['title'] = 'Thêm người dùng mới';
        $this->data['url'] = 'add_nguoidung';
        $this->data['ds'] = DB::table('users')->get();

        return view("admin.add_nguoidung", $this->data);
    }

    public function postadd_nguoidung(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|unique:users,email',
                'name' => 'required',
                'password' => 'required|confirmed|min:6|max:24',

            ],
            [
                'email.required' => 'Email bắt buộc phải nhập',
                'email.unique' => 'Email này đã được dùng',
                'name.required' => 'Tên người dùng bắt buộc phải nhập',
                'password.required' => 'Mật khẩu bắt buộc phải nhập',
                'password.min' => 'Mật khẩu phải từ 6 đến 24 kí tự',
                'password.max' => 'Mật khẩu phải từ 6 đến 24 kí tự',
                'password.confirmed' => 'Nhập lại mật khẩu không khớp',
            ]
        );
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => 1,
        ]);
        return redirect(route('admin.add_nguoidung'))->with('msgSuc', 'Thêm mới thành công');
    }
    ////
    public function add_loai_tintuc()
    {
        $this->data['title'] = 'Thêm loại tin tức mới';
        $this->data['url'] = 'add_loai_tintuc';
        $this->data['ds'] = DB::table('loai_tintuc')->get();

        return view("admin.add_loai_tintuc", $this->data);
    }

    public function postadd_loai_tintuc(Request $request)
    {

        $request->validate(
            [
                'ten' => 'required|unique:loai_tintuc,ten',
            ],
            [
                'ten.required' => 'Tên loại tin tức bắt buộc phải nhập',
                'ten.unique' => 'Tên loại tin tức đã tồn tại trong hệ thống',
            ]
        );
        $dataInsert = [
            $request->ten,
        ];
        $this->loai_tintuc->insert($dataInsert);


        return redirect(route('admin.add_loai_tintuc'))->with('msgSuc', 'Thêm mới thành công');
    }
    public function delete_loai_tintuc($ma)
    {
        if (!empty($ma)) {
            $detail = $this->loai_tintuc->get_Detail($ma);
            if (!empty($detail)) {

                $this->loai_tintuc->delete_loai_tintuc($ma);
            } else {
                return redirect(route('admin.add_loai_tintuc'))->with('msgErr', 'Thất bại');
            }
        }
        return redirect(route('admin.add_loai_tintuc'))->with('msgSuc', 'Xóa thành công');
    }
    ////

    public function add_tintuc()
    {
        $this->data['title'] = 'Thêm tin tức mới';
        $this->data['url'] = 'add_tintuc';
        $this->data['ds'] = DB::table('gionglua')->get();
        $this->data['ds_loai_tintuc'] = DB::table('loai_tintuc')->get();

        return view("admin.add_tintuc", $this->data);
    }

    public function postadd_tintuc(Request $request)
    {

        $request->validate(
            [
                'ten' => 'required|unique:tintuc,ten',
                'noidung' => 'required',
            ],
            [
                'ten.required' => 'Tên tin tức bắt buộc phải nhập',
                'ten.unique' => 'Tên tin tức đã tồn tại trong hệ thống',
                'noidung.required' => 'Nội dung của tin tức bắt buộc phải nhập',
            ]
        );
        $time = strtotime(date("Y-m-d H:i:s"));
        $dataInsert = [
            $request->ten,
            $request->noidung,
            $time,
            $time,
        ];
        $this->tintuc->insert($dataInsert);

        $ma = $this->tintuc->get_Mavoiten($request->ten)[0]->ma;


        // if ($request->hinhanh != null) {
        //     foreach ($request->hinhanh as $key => $item) {
        //         $ten_anh = 'tintuc'. strtotime(date("Y-m-d H:i:s")).$key;
        //         $image = $request->file('hinhanh')[$key];
        //         $destinationPath = public_path('/hinhanh/hinhanh_tintuc');
        //         $image->move($destinationPath, $ten_anh);
        //         $dataInsert2 = [
        //             $ma,
        //             $ten_anh,
        //         ];
        //         $this->danhsach_hinhanh->insert_hinhanh_tintuc($dataInsert2);
        //     }
        // }
        //
        $dataInsert_thongtin_capnhat = [
            $ma,
            null,
            Auth::user()->id,
            $request->ten,
            $request->noidung,
            $request->ds_loai_tintuc ?? null,
            $request->ds_ma_gionglua ?? null,
            $time,
        ];
        $this->thongtin_capnhat->insert_thongtin_capnhat_tintuc($dataInsert_thongtin_capnhat);
        $ma_thongtin_capnhat = $this->thongtin_capnhat->get_mavoi_ma_tintuc_vathoigian($ma, $time)[0]->ma;
        //
        if ($request->hinhanh != null) {
            foreach ($request->hinhanh as $key => $item) {
                $ten_anh = 'tintuc' . strtotime(date("Y-m-d H:i:s")) . $key;
                $image = $request->file('hinhanh')[$key];
                $destinationPath = public_path('/hinhanh/hinhanh_tintuc');
                $image->move($destinationPath, $ten_anh);
                $dataInsert2 = [
                    $ma,
                    $ten_anh,
                ];
                $this->danhsach_hinhanh->insert_hinhanh_tintuc($dataInsert2);
                //
                $dataInsert_danhsach_hinhanh_capnhat = [
                    $ma_thongtin_capnhat,
                    $ten_anh,
                ];
                $this->danhsach_hinhanh_capnhat->insert_hinhanh($dataInsert_danhsach_hinhanh_capnhat);
                //
            }
        }

        if ($request->ds_ma_gionglua != null) {
            $str = $request->ds_ma_gionglua;
            $char = ",";
            $start = 0;
            $num = substr_count($str, $char, $start);

            $str = explode(",", $request->ds_ma_gionglua);

            for ($i = 0; $i < $num; $i++) {

                $ma_tintuc = $this->tintuc->get_Mavoiten($request->ten)[0]->ma;
                $ma_gionglua = $this->gionglua->get_Mavoiten($str[$i])[0]->ma;


                $dataInsert3 = [
                    $ma_gionglua,
                    $ma_tintuc,

                ];
                $this->co_lienquan_gionglua->insert($dataInsert3);
            }
        }


        if ($request->ds_loai_tintuc != null) {
            $str = $request->ds_loai_tintuc;
            $char = ",";
            $start = 0;
            $num = substr_count($str, $char, $start);

            $str = explode(",", $request->ds_loai_tintuc);

            for ($i = 0; $i < $num; $i++) {

                $ma_tintuc = $this->tintuc->get_Mavoiten($request->ten)[0]->ma;
                $ma_loai_tintuc = $this->loai_tintuc->get_Mavoiten($str[$i])[0]->ma;


                $dataInsert3 = [
                    $ma_tintuc,
                    $ma_loai_tintuc
                ];
                $this->co_loai_tintuc->insert($dataInsert3);
            }
        }
        return redirect(route('admin.add_tintuc'))->with('msgSuc', 'Thêm mới thành công');
    }
    public function ds_tintuc(Request $request)
    {
        $this->data['url'] = 'ds_tintuc';
        $this->data['title'] = 'Danh sách tin tức';
        $this->data['ds'] = DB::table('tintuc')->get();
        foreach ($this->data['ds'] as $key => $item) {
            $item->tong_binhluan = DB::table('binhluan')->where('ma_tintuc', $item->ma)->count('ma');
            $item->tong_luotxem = DB::table('luotxem')->where('ma_tintuc', $item->ma)->sum('luotxem');
        }
        return view("admin.ds_tintuc", $this->data);
    }
    public function edit_tintuc($ma_tintuc)
    {
        $this->data['url'] = '';
        $this->data['title'] = 'Chỉnh sửa thông tin tin tức';
        if (!empty($ma_tintuc)) {
            $detail = $this->tintuc->get_Detail($ma_tintuc);
            if (!empty($detail)) {
                $this->data['detail'] = $detail[0];
                $this->data['ds_hinhanh'] = $this->danhsach_hinhanh->ds_theoma_tintuc($ma_tintuc);

                $this->data['ds_co_lienquan_gionglua'] = $this->co_lienquan_gionglua->ds_theoma_tintuc($ma_tintuc);
                $this->data['ds_gionglua'] =  DB::table('gionglua')->get();
                foreach ($this->data['ds_co_lienquan_gionglua'] as $key => $item) {
                    $this->data['ds_co_lienquan_gionglua'][$key]->ten_gionglua = $this->gionglua->get_Detail($item->ma_gionglua)[0]->ten;
                }

                foreach ($this->data['ds_gionglua'] as $key => $item) {
                    $this->data['ds_gionglua'][$key]->show = 0;

                    foreach ($this->data['ds_co_lienquan_gionglua'] as $key1 => $item) {
                        if ($this->data['ds_co_lienquan_gionglua'][$key1]->ma_gionglua ==   $this->data['ds_gionglua'][$key]->ma) {
                            $this->data['ds_gionglua'][$key]->show = 1;
                        }
                    }
                }

                $this->data['ds_co_loai_tintuc'] = $this->co_loai_tintuc->ds_theoma_tintuc($ma_tintuc);
                $this->data['ds_loai_tintuc'] =  DB::table('loai_tintuc')->get();
                foreach ($this->data['ds_co_loai_tintuc'] as $key => $item) {
                    $this->data['ds_co_loai_tintuc'][$key]->ten_loai_tintuc = $this->loai_tintuc->get_Detail($item->ma_loai_tintuc)[0]->ten;
                }

                foreach ($this->data['ds_loai_tintuc'] as $key => $item) {
                    $this->data['ds_loai_tintuc'][$key]->show = 0;

                    foreach ($this->data['ds_co_loai_tintuc'] as $key1 => $item) {
                        if ($this->data['ds_co_loai_tintuc'][$key1]->ma_loai_tintuc ==   $this->data['ds_loai_tintuc'][$key]->ma) {
                            $this->data['ds_loai_tintuc'][$key]->show = 1;
                        }
                    }
                }
            } else {
                return redirect(route('admin.home'));
            }
        } else {
            return redirect(route('admin.home'));
        }

        return view("admin.edit_tintuc", $this->data);
    }

    public function postedit_tintuc(Request $request, $ma_tintuc)
    {
        if ($request->ten != DB::table('tintuc')->where('ma', $ma_tintuc)) {
            $request->validate(
                [
                    'ten' => 'required|unique:tintuc,ten,' . $ma_tintuc . ',ma',
                ],
                [
                    'ten.required' => 'Tên tin tức bắt buộc phải nhập',
                    'ten.unique' => 'Tên tin tức đã tồn tại trong hệ thống',

                ]
            );
        }
        $request->validate(
            [
                'noidung' => 'required',
            ],
            [
                'noidung.required' => 'Nội dung của tin tức bắt buộc phải nhập',

            ]
        );
        $time = strtotime(date("Y-m-d H:i:s"));
        $dataInsert = [
            $request->ten,
            $request->noidung,
            $time,
        ];
        $this->tintuc->update_Tintuc($dataInsert, $ma_tintuc);

        $ma = $this->tintuc->get_Mavoiten($request->ten)[0]->ma;

        if ($request->ds_xoahinhanh != null) {
            $str = $request->ds_xoahinhanh;
            $char = ",";
            $start = 0;
            $num = substr_count($str, $char, $start);
            $str = explode(",", $str);

            for ($i = 0; $i < $num; $i++) {
                $this->danhsach_hinhanh->delete_voima($str[$i]);
            }
        }

        if ($request->hinhanh != null) {
            foreach ($request->hinhanh as $key => $item) {
                $ten_anh = 'tintuc' . strtotime(date("Y-m-d H:i:s")) . $key;


                $image = $request->file('hinhanh')[$key];
                $destinationPath = public_path('/hinhanh/hinhanh_tintuc');
                $image->move($destinationPath, $ten_anh);
                $dataInsert2 = [
                    $ma,
                    $ten_anh,
                ];
                $this->danhsach_hinhanh->insert_hinhanh_tintuc($dataInsert2);
            }
        }
        //

        $ma = $this->tintuc->get_Mavoiten($request->ten)[0]->ma;

        if ($request->ds_xoa_co_lienquan_gionglua != null) {
            $str = $request->ds_xoa_co_lienquan_gionglua;
            $char = ",";
            $start = 0;
            $num = substr_count($str, $char, $start);
            $str = explode(",", $str);
            for ($i = 0; $i < $num; $i++) {
                $this->co_lienquan_gionglua->delete_voimagionglua_va_matintuc($str[$i], $ma);
            }
        }
        if ($request->chongchiutot != null) {
            $str = $request->chongchiutot;
            $char = ",";
            $start = 0;
            $num = substr_count($str, $char, $start);
            $str = explode(",", $request->chongchiutot);
            for ($i = 0; $i < $num; $i++) {
                $ma_gionglua = $this->gionglua->get_Mavoiten($str[$i])[0]->ma;
                $ma_tintuc = $this->tintuc->get_Mavoiten($request->ten)[0]->ma;
                $dataInsertchongchiutot = [
                    $ma_gionglua,
                    $ma_tintuc,

                ];
                $this->co_lienquan_gionglua->insert($dataInsertchongchiutot);
            }
        }
        if ($request->ds_xoa_co_loai_tintuc != null) {
            $str = $request->ds_xoa_co_loai_tintuc;
            $char = ",";
            $start = 0;
            $num = substr_count($str, $char, $start);
            $str = explode(",", $str);
            for ($i = 0; $i < $num; $i++) {
                $this->co_loai_tintuc->delete_voimatintuc_va_maloaitintuc($ma, $str[$i]);
            }
        }
        if ($request->debinhiem != null) {
            $str = $request->debinhiem;
            $char = ",";
            $start = 0;
            $num = substr_count($str, $char, $start);

            $str = explode(",", $request->debinhiem);

            for ($i = 0; $i < $num; $i++) {

                $ma_loai_tintuc = $this->loai_tintuc->get_Mavoiten($str[$i])[0]->ma;
                $ma_tintuc = $this->tintuc->get_Mavoiten($request->ten)[0]->ma;

                $dataInsertdebinhiem = [
                    $ma_tintuc,
                    $ma_loai_tintuc,

                ];
                $this->co_loai_tintuc->insert($dataInsertdebinhiem);
            }
        }
        //
        $txt_loai_tintuc = '';
        foreach ($this->co_loai_tintuc->ds_theoma_tintuc($ma_tintuc) as $key => $item) {
            $txt_loai_tintuc = $txt_loai_tintuc . $this->loai_tintuc->get_Detail($item->ma_loai_tintuc)[0]->ten . ',';
        }
        $txt_co_lienquan_gionglua = '';
        foreach ($this->co_lienquan_gionglua->ds_theoma_tintuc($ma_tintuc) as $key => $item) {
            $txt_co_lienquan_gionglua = $txt_co_lienquan_gionglua . $this->gionglua->get_Detail($item->ma_gionglua)[0]->ten . ',';
        }
        //
        $ma_thongtin_capnhat = $this->thongtin_capnhat->get_mavoi_ma_tintuc_vathoigianmax($ma_tintuc)[0]->ma;
        $dataInsert_thongtin_capnhat = [
            $ma,
            $ma_thongtin_capnhat,
            Auth::user()->id,
            $request->ten,
            $request->noidung,
            $txt_loai_tintuc,
            $txt_co_lienquan_gionglua,
            $time,
        ];
        $this->thongtin_capnhat->insert_thongtin_capnhat_tintuc($dataInsert_thongtin_capnhat);
        $ma_thongtin_capnhat = $this->thongtin_capnhat->get_mavoi_ma_tintuc_vathoigian($ma, $time)[0]->ma;
        foreach ($this->danhsach_hinhanh->ds_theoma_tintuc($ma_tintuc) as $key => $item) {
            $dataInsert_danhsach_hinhanh_capnhat = [
                $ma_thongtin_capnhat,
                $item->ten,
            ];
            $this->danhsach_hinhanh_capnhat->insert_hinhanh($dataInsert_danhsach_hinhanh_capnhat);
        }
        //

        return redirect(route('admin.edit_tintuc', $ma_tintuc))->with('msgSuc', 'Chỉnh sửa thông tin thành công');
    }
    public function delete_tintuc($ma)
    {
        if (!empty($ma)) {
            $detail = $this->tintuc->get_Detail($ma);
            if (!empty($detail)) {
                foreach ($this->thongtin_capnhat->get_all_desctime_tintuc($ma) as $key => $item) {
                    $this->danhsach_hinhanh_capnhat->delete_voima_thongtin_capnhat($item->ma);
                    $this->thongtin_capnhat->delete_voima($item->ma);
                }
                $this->danhsach_hinhanh->delete_voima_tintuc($ma);
                $this->luotxem->delete_Tintuc($ma);
                $this->co_lienquan_gionglua->delete_tintuc($ma);
                $this->co_loai_tintuc->delete_tintuc($ma);
                $this->binhluan->delete_tintuc($ma);

                $this->tintuc->delete_tintuc($ma);
            } else {
                return redirect(route('admin.ds_tintuc'))->with('msgErr', 'Thất bại');
            }
        }
        return redirect(route('admin.ds_tintuc'))->with('msgSuc', 'Xóa thành công');
    }

    public function ds_thongtin_capnhat_gionglua($ma_gionglua)
    {
        $this->data['url'] = 'ds_thongtin_capnhat_gionglua';
        $this->data['title'] = 'Lịch sử cập nhật';
        $this->data['ds'] = $this->thongtin_capnhat->get_join_user_gionglua($ma_gionglua);
        return view("admin.ds_thongtin_capnhat_gionglua", $this->data);
    }
    public function detail_thongtin_capnhat_gionglua($ma)
    {
        $this->data['url'] = 'detail_thongtin_capnhat_gionglua';
        $this->data['title'] = 'Chi tiết cập nhật';
        $this->data['detail0'] = [];
        $this->data['detail1'] = $this->thongtin_capnhat->get_voima($ma);
        $this->data['ds_hinhanh1'] = $this->danhsach_hinhanh_capnhat->ds_theoma($this->data['detail1'][0]->ma);
        if ($this->data['detail1'][0]->ma_thongtin_capnhat != null) {
            $this->data['detail0'] = $this->thongtin_capnhat->get_voima($this->data['detail1'][0]->ma_thongtin_capnhat);
            $this->data['ds_hinhanh0'] = $this->danhsach_hinhanh_capnhat->ds_theoma($this->data['detail1'][0]->ma_thongtin_capnhat);
        }
        return view("admin.detail_thongtin_capnhat_gionglua", $this->data);
    }

    public function ds_thongtin_capnhat_saubenh($ma_saubenh)
    {
        $this->data['url'] = 'ds_thongtin_capnhat_saubenh';
        $this->data['title'] = 'Lịch sử cập nhật';
        $this->data['ds'] = $this->thongtin_capnhat->get_join_user_saubenh($ma_saubenh);
        return view("admin.ds_thongtin_capnhat_saubenh", $this->data);
    }
    public function detail_thongtin_capnhat_saubenh($ma)
    {
        $this->data['url'] = 'detail_thongtin_capnhat_saubenh';
        $this->data['title'] = 'Chi tiết cập nhật';
        $this->data['detail0'] = [];
        $this->data['detail1'] = $this->thongtin_capnhat->get_voima($ma);
        $this->data['ds_hinhanh1'] = $this->danhsach_hinhanh_capnhat->ds_theoma($this->data['detail1'][0]->ma);
        if ($this->data['detail1'][0]->ma_thongtin_capnhat != null) {
            $this->data['detail0'] = $this->thongtin_capnhat->get_voima($this->data['detail1'][0]->ma_thongtin_capnhat);
            $this->data['ds_hinhanh0'] = $this->danhsach_hinhanh_capnhat->ds_theoma($this->data['detail1'][0]->ma_thongtin_capnhat);
        }
        return view("admin.detail_thongtin_capnhat_saubenh", $this->data);
    }

    public function ds_thongtin_capnhat_tintuc($ma_tintuc)
    {
        $this->data['url'] = 'ds_thongtin_capnhat_tintuc';
        $this->data['title'] = 'Lịch sử cập nhật';
        $this->data['ds'] = $this->thongtin_capnhat->get_join_user_tintuc($ma_tintuc);
        return view("admin.ds_thongtin_capnhat_tintuc", $this->data);
    }
    public function detail_thongtin_capnhat_tintuc($ma)
    {
        $this->data['url'] = 'detail_thongtin_capnhat_tintuc';
        $this->data['title'] = 'Chi tiết cập nhật';
        $this->data['detail0'] = [];
        $this->data['detail1'] = $this->thongtin_capnhat->get_voima($ma);
        $this->data['ds_hinhanh1'] = $this->danhsach_hinhanh_capnhat->ds_theoma($this->data['detail1'][0]->ma);
        if ($this->data['detail1'][0]->ma_thongtin_capnhat != null) {
            $this->data['detail0'] = $this->thongtin_capnhat->get_voima($this->data['detail1'][0]->ma_thongtin_capnhat);
            $this->data['ds_hinhanh0'] = $this->danhsach_hinhanh_capnhat->ds_theoma($this->data['detail1'][0]->ma_thongtin_capnhat);
        }
        return view("admin.detail_thongtin_capnhat_tintuc", $this->data);
    }

    public function thongke_baiviet()
    {
        $this->data['url'] = 'thongke_baiviet';
        $this->data['title'] = 'Báo cáo thống kê bài viết';
        $this->data['ds'] = null;
        return view("admin.thongke_baiviet", $this->data);
    }
    public function postthongke_baiviet(Request $request)
    {
        $this->data['url'] = 'thongke_baiviet';
        $this->data['title'] = 'Báo cáo thống kê bài viết';
        $this->data['ds'] = null;

        $sql = '';
        if ($request->num <= 0) {
            return redirect(route('admin.thongke_baiviet'))->with('msgErrTK', 'Lỗi');
        }
        $num = $request->num;
        $loai = $request->loai;
        if ($request->thoigian == 'tatca') {
            $thoigiantxt = 'từ trước đến nay';
            $thoigian = '';
        }
        if ($loai == "tintuc") {
            $loaitxt = 'tin tức';
        }
        if ($loai == "gionglua") {
            $loaitxt = 'giống lúa';
        }
        if ($loai == "saubenh") {
            $loaitxt = 'sâu bệnh';
        }
        // if($request->thoigian == 'trong' && $request->trong!=null){
        //     $time = strtotime($request->trong);
        //     $thoigian='ngay = '.$time;
        // }
        if ($request->thoigian == 'tu' && $request->tu != null && $request->den != null) {
            $tu = strtotime($request->tu);
            $den = strtotime($request->den);
            if ($tu >= $den) {
                return redirect(route('admin.thongke_baiviet'))->with('msgErrTK', 'Lỗi');
            }
            $thoigian = 'WHERE ngay >=' . $tu . ' and ngay <=' . $den;
            $thoigiantxt = 'từ ' . date("d-m-Y", $tu) . ' đến ' . date("d-m-Y", $den);
        }
        $sql = 'SELECT ten, SUM(luotxem) as tong, ngaytao, ngaycapnhat
        FROM (
            SELECT ten,luotxem,ma_' . $loai . ',ngay,ngaytao, ngaycapnhat FROM ' . $loai . '
            INNER JOIN luotxem ON ' . $loai . '.ma = luotxem.ma_' . $loai . '
        ) t
         ' . $thoigian . '
        GROUP BY ma_' . $loai . '
        HAVING SUM(luotxem)
        ORDER BY tong DESC  LIMIT ' . $num;

        $status = $this->luotxem->statement($sql);

        if ($status) {
            $this->data['text'] = 'Top ' . $num . ' các bài viết ' . $loaitxt . ' ' . $thoigiantxt;
            $this->data['ds'] = $this->luotxem->selectsql($sql);
            return view("admin.thongke_baiviet", $this->data);
        }
        return view("admin.thongke_baiviet", $this->data)->with('msgErrTK', 'Lỗi');
        // $sql='SELECT ten, SUM(luotxem) as tong, ngaytao, ngaycapnhat
        // FROM (
        //     SELECT ten,luotxem,ma_tintuc,ngay,ngaytao, ngaycapnhat FROM tintuc
        //     INNER JOIN luotxem ON tintuc.ma = luotxem.ma_tintuc
        // ) t
        // WHERE ngay >= 1700352000 and ngay <= 17003520000
        // GROUP BY ma_tintuc
        // HAVING SUM(luotxem) 
        // ';

    }

    public function thongke_cauhoi()
    {
        $this->data['url'] = 'thongke_cauhoi';
        $this->data['title'] = 'Báo cáo thống kê câu hỏi';
        $this->data['ds'] = null;
        return view("admin.thongke_cauhoi", $this->data);
    }
    public function postthongke_cauhoi(Request $request)
    {
        $this->data['url'] = 'thongke_baiviet';
        $this->data['title'] = 'Báo cáo thống kê câu hỏi';
        $this->data['ds'] = null;

        $sql = '';
        if ($request->num <= 0) {
            return redirect(route('admin.thongke_cauhoi'))->with('msgErrTK', 'Lỗi');
        }
        $num = $request->num;
        if ($request->thoigian == 'tatca') {
            $thoigiantxt = 'từ trước đến nay';
            $thoigian = '';
        }

        if ($request->thoigian == 'tu' && $request->tu != null && $request->den != null) {
            $tu = strtotime($request->tu);
            $den = strtotime($request->den);
            if ($tu >= $den) {
                return redirect(route('admin.thongke_cauhoi'))->with('msgErrTK', 'Lỗi');
            }
            $thoigian = 'WHERE ngay >=' . $tu . ' and ngay <=' . $den;
            $thoigiantxt = 'từ ' . date("d-m-Y", $tu) . ' đến ' . date("d-m-Y", $den);
        }
        $sql = 'SELECT ten, SUM(luothoi) as tong 
        FROM (
            SELECT ten,luothoi,ma_cauhoi,ngay  FROM cauhoi
            INNER JOIN luothoi ON cauhoi.ma = luothoi.ma_cauhoi
        ) t
         ' . $thoigian . '
        GROUP BY ma_cauhoi
        HAVING SUM(luothoi)
        ORDER BY tong DESC  LIMIT ' . $num;

        $status = $this->luotxem->statement($sql);

        if ($status) {
            $this->data['text'] = 'Top ' . $num . ' câu hỏi có nhiều lượt hỏi nhất ' . $thoigiantxt;
            $this->data['ds'] = $this->luotxem->selectsql($sql);
            return view("admin.thongke_cauhoi", $this->data);
        }
        return view("admin.thongke_cauhoi", $this->data)->with('msgErrTK', 'Lỗi');
    }

    // public function thongke_loai_tintuc()
    // {
    //     $this->data['url'] = 'thongke_loai_tintuc';
    //     $this->data['title'] = 'Báo cáo thống kê loại tin tức';
    //     $this->data['ds'] = null;
    //     return view("admin.thongke_loai_tintuc", $this->data);
    // }
    // public function postthongke_loai_tintuc(Request $request)
    // {
    //     $this->data['url'] = 'thongke_loai_tintuc';
    //     $this->data['title'] = 'Báo cáo thống kê loại tin tức';
    //     $this->data['ds'] = null;

    //     $sql = '';
    //     if ($request->num <= 0) {
    //         return redirect(route('admin.thongke_loai_tintuc'))->with('msgErrTK', 'Lỗi');
    //     }
    //     $num = $request->num;
    //     if ($request->thoigian == 'tatca') {
    //         $thoigiantxt='từ trước đến nay';
    //         $thoigian = '';
    //     }

    //     if ($request->thoigian == 'tu' && $request->tu != null && $request->den != null) {
    //         $tu = strtotime($request->tu);
    //         $den = strtotime($request->den);
    //         if ($tu >= $den) {
    //             return redirect(route('admin.thongke_loai_tintuc'))->with('msgErrTK', 'Lỗi');
    //         }
    //         $thoigian = 'WHERE ngay >=' . $tu . ' and ngay <=' . $den;
    //         $thoigiantxt='từ '.date("d-m-Y", $tu).' đến '.date("d-m-Y", $den);
    //     }
    //     $sql = 'SELECT loai_tintuc.ten as ten_loai_tintuc, SUM(luotxem) as tong, ngaytao, ngaycapnhat
    //     FROM (
    //         SELECT ten,luotxem,ma_' . $loai . ',ngay,ngaytao, ngaycapnhat FROM ' . $loai . '
    //         INNER JOIN luotxem ON ' . $loai . '.ma = luotxem.ma_' . $loai . '
    //     ) t
    //      ' . $thoigian . '
    //     GROUP BY ma_' . $loai . '
    //     HAVING SUM(luotxem)
    //     ORDER BY tong DESC  LIMIT ' . $num;

    //     $status = $this->luotxem->statement($sql);

    //     if ($status) {
    //         $this->data['text'] ='Top '.$num.' câu hỏi có nhiều lượt hỏi nhất '.$thoigiantxt;
    //         $this->data['ds'] = $this->luotxem->selectsql($sql);
    //         return view("admin.thongke_cauhoi", $this->data);
    //     }
    //     return view("admin.thongke_cauhoi", $this->data)->with('msgErrTK', 'Lỗi');

    // }

    public function add_cauhoi()
    {
        $this->data['title'] = 'Thêm câu hỏi mới';
        $this->data['url'] = 'add_loai_tintuc';
        $this->data['ds'] = DB::table('cauhoi')->get();
        foreach ($this->data['ds'] as $key => $item) {
            $item->tong_luothoi = DB::table('luothoi')->where('ma_cauhoi', $item->ma)->sum('luothoi');
        }

        return view("admin.add_cauhoi", $this->data);
    }

    public function postadd_cauhoi(Request $request)
    {

        $request->validate(
            [
                'ten' => 'required|unique:cauhoi,ten',
                'traloi' => 'required',
            ],
            [
                'ten.required' => 'Câu hỏi bắt buộc phải nhập',
                'ten.unique' => 'Câu hỏi đã tồn tại trong hệ thống',
                'traloi.required' => 'Câu trả lời bắt buộc phải nhập',

            ]
        );
        $dataInsert = [
            $request->ten,
            $request->traloi,

        ];
        $this->cauhoi->insert($dataInsert);


        return redirect(route('admin.add_cauhoi'))->with('msgSuc', 'Thêm mới thành công');
    }
    public function postedit_cauhoi(Request $request)
    {
        $request->validate(
            [
                'edit_traloi' => 'required',
            ],
            [
                'edit_traloi.required' => 'Câu trả lời bắt buộc phải nhập',
            ]
        );

        $dataInsert = [
            $request->edit_traloi,

        ];
        DB::table('cauhoi')->where('ma', $request->ma)
            ->update(['traloi' => $request->edit_traloi]);
        return redirect(route('admin.add_cauhoi'))->with('msgSuc', 'Cập nhật thành công');
    }
    public function delete_cauhoi($ma)
    {
        if (!empty($ma)) {
            $detail = $this->cauhoi->get_Detail($ma);
            if (!empty($detail)) {

                $this->cauhoi->delete_cauhoi($ma);
            } else {
                return redirect(route('admin.add_cauhoi'))->with('msgErr', 'Thất bại');
            }
        }
        return redirect(route('admin.add_cauhoi'))->with('msgSuc', 'Xóa thành công');
    }
    ////
    public function ds_phanhoi()
    {
        $this->data['title'] = 'Danh sách phản hồi';
        $this->data['url'] = 'ds_phanhoi';
        $this->data['ds'] = DB::table('phanhoi')->join('users', 'phanhoi.ma_user', '=', 'users.id')->get();
        return view("admin.ds_phanhoi", $this->data);
    }
    public function delete_phanhoi($ma)
    {
        if (!empty($ma)) {
            $detail = $this->phanhoi->get_Detail($ma);
            if (!empty($detail)) {

                $this->phanhoi->delete_phanhoi($ma);
            } else {
                return redirect(route('admin.ds_phanhoi'))->with('msgErr', 'Thất bại');
            }
        }
        return redirect(route('admin.ds_phanhoi'))->with('msgSuc', 'Xóa thành công');
    }
    public function postedit_phanhoi(Request $request)
    {
        $request->validate(
            [
                'traloi' => 'required',
            ],
            [
                'traloi.required' => 'Câu trả lời bắt buộc phải nhập',
            ]
        );

        $dataInsert = [
            $request->traloi,

        ];
        DB::table('phanhoi')->where('ma', $request->ma)
            ->update(['traloi' => $request->traloi]);
        return redirect(route('admin.ds_phanhoi'))->with('msgSuc', 'Cập nhật thành công');
    }
    ///
    public function an_binhluan(Request $request, $ma)
    {
        $save = new Binhluan;
        $save->where('ma', $ma)->update(['trangthai' => 0]);
        return redirect()->back();
    }
    public function hien_binhluan(Request $request, $ma)
    {
        $save = new User;
        $save->where('ma', $ma)->update(['trangthai' => 1]);
        return redirect()->back();
    }
    public function chan_binhluan(Request $request, $ma)
    {
        $save = new User;
        $save->where('id', $ma)->update(['status_comment' => 0]);
        return redirect()->back();
    }
    public function chophep_binhluan(Request $request, $ma)
    {
        $save = new User;
        $save->where('id', $ma)->update(['status_comment' => 1]);
        return redirect()->back();
    }
    public function ds_binhluan_gionglua(Request $request, $ma)
    {
        $this->data['url'] = 'ds_binhluan_gionglua';
        $this->data['title'] = 'Danh sách bình luận của ' . DB::table('gionglua')->where('ma', $ma)->value('ten');
        // $this->data['ds']=$this->gionglua->getAll();
        $this->data['ds'] = DB::table('binhluan')->where('ma_gionglua', $ma)->join('users', 'binhluan.ma_user', '=', 'users.id')->get();

        return view("admin.ds_binhluan_gionglua", $this->data);
    }
    public function ds_binhluan_tintuc(Request $request, $ma)
    {
        $this->data['url'] = 'ds_binhluan_tintuc';
        $this->data['title'] = 'Danh sách bình luận của tin tức ' . DB::table('tintuc')->where('ma', $ma)->value('ten');
        // $this->data['ds']=$this->gionglua->getAll();
        $this->data['ds'] = DB::table('binhluan')->where('ma_tintuc', $ma)->join('users', 'binhluan.ma_user', '=', 'users.id')->get();

        return view("admin.ds_binhluan_tintuc", $this->data);
    }
    public function ds_binhluan_saubenh(Request $request, $ma)
    {
        $this->data['url'] = 'ds_binhluan_saubenh';
        $this->data['title'] = 'Danh sách bình luận của ' . DB::table('saubenh')->where('ma', $ma)->value('ten');
        // $this->data['ds']=$this->gionglua->getAll();
        $this->data['ds'] = DB::table('binhluan')->where('ma_saubenh', $ma)->join('users', 'binhluan.ma_user', '=', 'users.id')->get();

        return view("admin.ds_binhluan_saubenh", $this->data);
    }


    public function add_cauhoi_excel()
    {
        $this->data['title'] = 'Thêm mới câu hỏi';
        $this->data['url'] = 'add_cauhoi_excel';
        return view('admin.add_cauhoi_excel',$this->data);
    }

    public function post_add_cauhoi_excel(Request $request)
    {
        try {

            Excel::import(new CauhoiImport, $request->file('file'));
            return redirect()->back()->with('msgSuc', 'Thêm mới thành công');
        } catch (Exception $ex) {

            return redirect()->back()->with('msgErr', 'Có lỗi! Vui lòng kiểm tra lại!');
        }
    }

    public function downloadfile()
    {
        $filepath = public_path('mau_cauhoi/mau_cauhoi.xlsx');
        return Response()->download($filepath);
    }
}
