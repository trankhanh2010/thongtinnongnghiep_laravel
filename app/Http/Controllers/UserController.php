<?php

namespace App\Http\Controllers;

use App\Models\Gionglua;
use App\Models\Saubenh;
use App\Models\Chongchiutot;
use App\Models\Debinhiem;
use App\Models\User;
use App\Models\Tintuc;
use App\Models\Danhsach_hinhanh;
use App\Models\Thongtin_capnhat;
use App\Models\Luotxem;
use App\Models\Loai_tintuc;
use App\Models\Binhluan;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public $data = [];

    private $gionglua;
    private $saubenh;
    private $chongchiutot;
    private $debinhiem;
    private $tintuc;
    private $danhsach_hinhanh;
    private $thongtin_capnhat;
    private $luotxem;
    private $loai_tintuc;
    private $binhluan;


    private $so_baiviet_tintuc_moi = 5;
    private $so_baiviet_tintuc_noibat = 5;

    public function __construct()
    {
        $this->gionglua = new Gionglua();
        $this->danhsach_hinhanh = new Danhsach_hinhanh();
        $this->saubenh = new Saubenh();
        $this->chongchiutot = new Chongchiutot();
        $this->debinhiem = new Debinhiem();
        $this->tintuc = new Tintuc();
        $this->thongtin_capnhat = new Thongtin_capnhat();
        $this->luotxem = new Luotxem();
        $this->loai_tintuc = new Loai_tintuc();
        $this->binhluan = new Binhluan();



        $this->data['ds_cac_saubenh'] =  DB::table('saubenh')->select('*')->orderByDesc('ten')->get();
        $this->data['ds_tintuc_moi'] = $this->tintuc->get_tintucmoi($this->so_baiviet_tintuc_moi);
        $this->data['ds_tintuc_noibat'] = $this->tintuc->get_tintucnoibat($this->so_baiviet_tintuc_noibat);
        $this->data['ds_tintuc_khac'] = $this->tintuc->get_tintuckhac($this->so_baiviet_tintuc_noibat);
        $this->data['tintuc_noibat_nhat'] = $this->tintuc->get_tintucnoibat(1);
        $this->data['ds_tintuc_moi_nhat'] = $this->tintuc->get_tintucmoi(1);
        $this->data['ds_tintuc_moi_nhat2'] = DB::table('tintuc')->select('*')->limit(4)->orderByDesc('ngaytao')->get();
        $this->data['ds_loai_tintuc'] = DB::table('loai_tintuc')->select('*')->orderByDesc('ten')->get();
        $this->data['ds_cac_gionglua'] = DB::table('gionglua')->select('*')->orderByDesc('ten')->get();


        foreach ($this->data['ds_tintuc_moi'] as $key => $item) {
            $ma = $item->ma;
            $item->ten_hinhanh = $this->danhsach_hinhanh->get_ten_tintuc($ma);
            $item->loai_tintuc = DB::table('co_loai_tintuc')
                ->select('loai_tintuc.ten as ten_tintuc')->where('ma_tintuc', $ma)
                ->join('loai_tintuc', 'co_loai_tintuc.ma_loai_tintuc', '=', 'loai_tintuc.ma')->get();
            $item->gionglua_lienquan = DB::table('co_lienquan_gionglua')
                ->select('gionglua.ten as ten_gionglua_lienquan')->where('ma_tintuc', $ma)
                ->join('gionglua', 'co_lienquan_gionglua.ma_gionglua', '=', 'gionglua.ma')->get();
        }
        foreach ($this->data['ds_tintuc_noibat'] as $key => $item) {
            $ma = $item->ma;
            $item->ten_hinhanh = $this->danhsach_hinhanh->get_ten_tintuc($ma);
            $item->loai_tintuc = DB::table('co_loai_tintuc')
                ->select('loai_tintuc.ten as ten_tintuc')->where('ma_tintuc', $ma)
                ->join('loai_tintuc', 'co_loai_tintuc.ma_loai_tintuc', '=', 'loai_tintuc.ma')->get();
            $item->gionglua_lienquan = DB::table('co_lienquan_gionglua')
                ->select('gionglua.ten as ten_gionglua_lienquan')->where('ma_tintuc', $ma)
                ->join('gionglua', 'co_lienquan_gionglua.ma_gionglua', '=', 'gionglua.ma')->get();
        }
        foreach ($this->data['ds_tintuc_khac'] as $key => $item) {
            $ma = $item->ma;
            $item->ten_hinhanh = $this->danhsach_hinhanh->get_ten_tintuc($ma);
            $item->loai_tintuc = DB::table('co_loai_tintuc')
                ->select('loai_tintuc.ten as ten_tintuc')->where('ma_tintuc', $ma)
                ->join('loai_tintuc', 'co_loai_tintuc.ma_loai_tintuc', '=', 'loai_tintuc.ma')->get();
            $item->gionglua_lienquan = DB::table('co_lienquan_gionglua')
                ->select('gionglua.ten as ten_gionglua_lienquan')->where('ma_tintuc', $ma)
                ->join('gionglua', 'co_lienquan_gionglua.ma_gionglua', '=', 'gionglua.ma')->get();
        }
        foreach ($this->data['tintuc_noibat_nhat'] as $key => $item) {
            $ma = $item->ma;
            $item->ten_hinhanh = $this->danhsach_hinhanh->get_ten_tintuc($ma);
            $item->loai_tintuc = DB::table('co_loai_tintuc')
                ->select('loai_tintuc.ten as ten_tintuc')->where('ma_tintuc', $ma)
                ->join('loai_tintuc', 'co_loai_tintuc.ma_loai_tintuc', '=', 'loai_tintuc.ma')->get();
            $item->gionglua_lienquan = DB::table('co_lienquan_gionglua')
                ->select('gionglua.ten as ten_gionglua_lienquan')->where('ma_tintuc', $ma)
                ->join('gionglua', 'co_lienquan_gionglua.ma_gionglua', '=', 'gionglua.ma')->get();
        }
        foreach ($this->data['ds_tintuc_moi_nhat'] as $key => $item) {
            $ma = $item->ma;
            $item->ten_hinhanh = $this->danhsach_hinhanh->get_ten_tintuc($ma);
            $item->loai_tintuc = DB::table('co_loai_tintuc')
                ->select('loai_tintuc.ten as ten_tintuc')->where('ma_tintuc', $ma)
                ->join('loai_tintuc', 'co_loai_tintuc.ma_loai_tintuc', '=', 'loai_tintuc.ma')->get();
            $item->gionglua_lienquan = DB::table('co_lienquan_gionglua')
                ->select('gionglua.ten as ten_gionglua_lienquan')->where('ma_tintuc', $ma)
                ->join('gionglua', 'co_lienquan_gionglua.ma_gionglua', '=', 'gionglua.ma')->get();
        }
        foreach ($this->data['ds_tintuc_moi_nhat2'] as $key => $item) {
            $ma = $item->ma;
            $item->ten_hinhanh = $this->danhsach_hinhanh->get_ten_tintuc($ma);
            $item->loai_tintuc = DB::table('co_loai_tintuc')
                ->select('loai_tintuc.ten as ten_tintuc')->where('ma_tintuc', $ma)
                ->join('loai_tintuc', 'co_loai_tintuc.ma_loai_tintuc', '=', 'loai_tintuc.ma')->get();
            $item->gionglua_lienquan = DB::table('co_lienquan_gionglua')
                ->select('gionglua.ten as ten_gionglua_lienquan')->where('ma_tintuc', $ma)
                ->join('gionglua', 'co_lienquan_gionglua.ma_gionglua', '=', 'gionglua.ma')->get();
        }
        // dd($this->data['ds_tintuc_moi_nhat2']);
    }

    public function home(Request $request)
    {
        $this->data['title'] = 'Trang chủ';
        $this->data['url'] = 'home';
        $posts = tintuc::paginate(4);

        foreach ($posts as $key => $item) {
            $ma = $item->ma;
            $item->ten_hinhanh = $this->danhsach_hinhanh->get_ten_tintuc($ma);
            $item->loai_tintuc = DB::table('co_loai_tintuc')
                ->select('loai_tintuc.ten as ten_tintuc')->where('ma_tintuc', $ma)
                ->join('loai_tintuc', 'co_loai_tintuc.ma_loai_tintuc', '=', 'loai_tintuc.ma')->get();
            $item->gionglua_lienquan = DB::table('co_lienquan_gionglua')
                ->select('gionglua.ten as ten_gionglua_lienquan')->where('ma_tintuc', $ma)
                ->join('gionglua', 'co_lienquan_gionglua.ma_gionglua', '=', 'gionglua.ma')->get();
        }
        if ($request->ajax()) {
            $view = view('user.load_more_tintuc', compact('posts'))->render();

            return response()->json(['html' => $view]);
        }
        return view("user.home", $this->data, compact('posts'));
    }

    public function detail_tintuc(Request $request, $ma)
    {
        if ($ma == null) return redirect(route('home'));
        $this->data['title'] = 'Xem tin tức';
        $this->data['url'] = 'tintuc';
        $this->data['detail'] = $this->tintuc->get_Detail($ma);
        if ($this->data['detail'] == null) return redirect(route('home'));
        $this->data['ds_hinhanh_detail'] = $this->danhsach_hinhanh->ds_theoma_tintuc($ma);

        // $this->data['detail']['ds_co_loai_tintuc'] =  DB::table('co_loai_tintuc')
        // ->select('loai_tintuc.ten as ten_tintuc')->where('ma_tintuc',$ma)
        // ->join('loai_tintuc', 'co_loai_tintuc.ma_loai_tintuc', '=', 'loai_tintuc.ma')->get();

        // $this->data['ds_co_lienquan_gionglua'] =  DB::table('co_lienquan_gionglua')
        // ->select('gionglua.ten as ten_gionglua_lienquan')->where('ma_tintuc',$ma)
        // ->join('gionglua', 'co_lienquan_gionglua.ma_gionglua', '=', 'gionglua.ma')->get();
        foreach ($this->data['detail'] as $key => $item) {
            $ma = $item->ma;
            $item->ten_hinhanh = $this->danhsach_hinhanh->get_ten_tintuc($ma);
            $item->loai_tintuc = DB::table('co_loai_tintuc')
                ->select('loai_tintuc.ten as ten_tintuc', 'loai_tintuc.ma as ma')->where('ma_tintuc', $ma)
                ->join('loai_tintuc', 'co_loai_tintuc.ma_loai_tintuc', '=', 'loai_tintuc.ma')->get();
            $item->gionglua_lienquan = DB::table('co_lienquan_gionglua')
                ->select('gionglua.ten as ten_gionglua_lienquan', 'gionglua.ma as ma')->where('ma_tintuc', $ma)
                ->join('gionglua', 'co_lienquan_gionglua.ma_gionglua', '=', 'gionglua.ma')->get();
        }

        $this->data['ds_binhluan'] = DB::table('binhluan')->where('ma_tintuc', $ma)->join('users', 'binhluan.ma_user', '=', 'users.id')
            ->paginate(3);

        ///
        $time = strtotime(date("Y-m-d"));
        $check = $this->luotxem->check_tintuc($time, $ma);
        if ($check) {
            $tt = $this->luotxem->get_ma_tintuc($time, $ma);
            $malt = $tt->ma;
            $detail = $this->luotxem->get_detail_tintuc($malt);
            $this->luotxem->tintuc_them1($detail->ma, $detail->luotxem + 1);
        } else {
            $dataInsert = [
                $time,
                $ma
            ];
            $this->luotxem->insert_tintuc($dataInsert);
        }

        $posts = DB::table('binhluan')->where('ma_tintuc', $ma)
            ->join('users', 'binhluan.ma_user', '=', 'users.id')
            ->orderByDesc('ngay_binhluan')
            ->paginate(3);
        if ($request->ajax()) {
            $view = view('user.load_more_binhluan', compact('posts'))->render();

            return response()->json(['html' => $view]);
        }

        return view("user.detail_tintuc", $this->data, compact('posts'));
    }

    public function detail_gionglua(Request $request, $ma)
    {
        if ($ma == null) return redirect(route('home'));
        $this->data['title'] = 'Xem giống lúa';
        $this->data['url'] = 'gionglua';
        $this->data['detail'] = $this->gionglua->get_Detail($ma);
        if ($this->data['detail'] == null) return redirect(route('home'));
        $this->data['ds_hinhanh_detail'] = $this->danhsach_hinhanh->ds_theoma_gionglua($ma);

        $this->data['ds_chongchiutot'] = '';
        $this->data['ds_chongchiutot'] = $this->chongchiutot->ds_theoma_gionglua($ma);
        foreach ($this->data['ds_chongchiutot'] as $key => $item) {
            $ma_saubenh = $item->ma_saubenh;
            $item->ten_hinhanh = $this->danhsach_hinhanh->get_ten_saubenh($ma_saubenh);
            $item->ten = $this->saubenh->get_Detail($ma_saubenh)[0]->ten;
            $item->ngaytao = $this->saubenh->get_Detail($ma_saubenh)[0]->ngaytao;
            $item->thongtinkhac = $this->saubenh->get_Detail($ma_saubenh)[0]->thongtinkhac;
        }
        $this->data['ds_debinhiem'] = '';
        $this->data['ds_debinhiem'] = $this->debinhiem->ds_theoma_gionglua($ma);
        foreach ($this->data['ds_debinhiem'] as $key => $item) {
            $ma_saubenh = $item->ma_saubenh;
            $item->ten_hinhanh = $this->danhsach_hinhanh->get_ten_saubenh($ma_saubenh);
            $item->ten = $this->saubenh->get_Detail($ma_saubenh)[0]->ten;
            $item->ngaytao = $this->saubenh->get_Detail($ma_saubenh)[0]->ngaytao;
            $item->thongtinkhac = $this->saubenh->get_Detail($ma_saubenh)[0]->thongtinkhac;
        }
        
        $posts = DB::table('binhluan')->where('ma_gionglua', $ma)
        ->join('users', 'binhluan.ma_user', '=', 'users.id')
        ->orderByDesc('ngay_binhluan')
        ->paginate(3);
    if ($request->ajax()) {
        $view = view('user.load_more_binhluan', compact('posts'))->render();

        return response()->json(['html' => $view]);
    }
        ///
        $time = strtotime(date("Y-m-d"));
        $check = $this->luotxem->check_gionglua($time, $ma);
        if ($check) {
            $tt = $this->luotxem->get_ma_gionglua($time, $ma);
            $malt = $tt->ma;
            $detail = $this->luotxem->get_detail_gionglua($malt);
            $this->luotxem->gionglua_them1($detail->ma, $detail->luotxem + 1);
        } else {
            $dataInsert = [
                $time,
                $ma
            ];
            $this->luotxem->insert_gionglua($dataInsert);
        }
        return view("user.detail_gionglua", $this->data,compact('posts'));
    }

    public function detail_saubenh(Request $request, $ma)
    {
        if ($ma == null) return redirect(route('home'));
        $this->data['title'] = 'Xem sâu bệnh';
        $this->data['url'] = 'saubenh';
        $this->data['detail'] = $this->saubenh->get_Detail($ma);
        if ($this->data['detail'] == null) return redirect(route('home'));
        $this->data['ds_hinhanh_detail'] = $this->danhsach_hinhanh->ds_theoma_saubenh($ma);

        $this->data['ds_chongchiutot'] = '';
        $this->data['ds_chongchiutot'] = $this->chongchiutot->ds_theoma_saubenh($ma);
        foreach ($this->data['ds_chongchiutot'] as $key => $item) {
            $ma_gionglua = $item->ma_gionglua;
            $item->ten_hinhanh = $this->danhsach_hinhanh->get_ten_gionglua($ma_gionglua);
            $item->ten = $this->gionglua->get_Detail($ma_gionglua)[0]->ten;
            $item->ngaytao = $this->gionglua->get_Detail($ma_gionglua)[0]->ngaytao;
            $item->thongtinkhac = $this->gionglua->get_Detail($ma_gionglua)[0]->thongtinkhac;
        }
        $this->data['ds_debinhiem'] = '';
        $this->data['ds_debinhiem'] = $this->debinhiem->ds_theoma_saubenh($ma);
        foreach ($this->data['ds_debinhiem'] as $key => $item) {
            $ma_gionglua = $item->ma_gionglua;
            $item->ten_hinhanh = $this->danhsach_hinhanh->get_ten_gionglua($ma_gionglua);
            $item->ten = $this->gionglua->get_Detail($ma_gionglua)[0]->ten;
            $item->ngaytao = $this->gionglua->get_Detail($ma_gionglua)[0]->ngaytao;
            $item->thongtinkhac = $this->gionglua->get_Detail($ma_gionglua)[0]->thongtinkhac;
        }

        $posts = DB::table('binhluan')->where('ma_saubenh', $ma)
        ->join('users', 'binhluan.ma_user', '=', 'users.id')
        ->orderByDesc('ngay_binhluan')
        ->paginate(3);
    if ($request->ajax()) {
        $view = view('user.load_more_binhluan', compact('posts'))->render();

        return response()->json(['html' => $view]);
    }
        ///
        $time = strtotime(date("Y-m-d"));
        $check = $this->luotxem->check_saubenh($time, $ma);
        if ($check) {
            $tt = $this->luotxem->get_ma_saubenh($time, $ma);
            $malt = $tt->ma;
            $detail = $this->luotxem->get_detail_saubenh($malt);
            $this->luotxem->saubenh_them1($detail->ma, $detail->luotxem + 1);
        } else {
            $dataInsert = [
                $time,
                $ma
            ];
            $this->luotxem->insert_saubenh($dataInsert);
        }
        return view("user.detail_saubenh", $this->data,compact('posts'));
    }

    public function ds_tintuc(Request $request)
    {
        $this->data['title'] = 'Danh sách tin tức';
        $this->data['url'] = 'ds_tintuc';
        // $key = $request->key;
        // if ($key == '') {
        //     $this->data['ds_tintuc'] = $this->tintuc->getAll();
        // } else {
        //     $this->data['ds_tintuc'] = $this->tintuc->getAll_voiKey($key);
        // }
        // $this->data['ds_tintuc'] = DB::table('tintuc')->select('*')->paginate(4);
        $this->data['ds_tintuc'] =  DB::table('tintuc');
        $theloai = '';
        $gionglua = '';

        if ($request->key_ds_loai_tintuc != null || $request->key_ds_gionglua != null) {
            if ($request->key_ds_loai_tintuc == null) {
                $this->data['ds_tintuc'] = DB::table('tintuc')->distinct()
                    ->select('tintuc.ma as ma', 'gionglua.ten as ten_gionglua', 'tintuc.ten as ten', 'noidung', 'tintuc.ngaytao as ngaytao')
                    ->join('co_lienquan_gionglua', 'tintuc.ma', '=', 'co_lienquan_gionglua.ma_tintuc')
                    ->join('gionglua', 'co_lienquan_gionglua.ma_gionglua', '=', 'gionglua.ma');
            }
            if ($request->key_ds_gionglua == null) {
                $this->data['ds_tintuc'] = DB::table('tintuc')->distinct()
                    ->select('tintuc.ma as ma', 'tintuc.ten as ten', 'noidung', 'tintuc.ngaytao as ngaytao', 'loai_tintuc.ten as ten_loai_tintuc')
                    ->join('co_loai_tintuc', 'tintuc.ma', '=', 'co_loai_tintuc.ma_tintuc')
                    ->join('loai_tintuc', 'co_loai_tintuc.ma_loai_tintuc', '=', 'loai_tintuc.ma');
            } else {
                $this->data['ds_tintuc'] = DB::table('tintuc')->distinct()
                    ->select('tintuc.ma as ma', 'tintuc.ten as ten', 'noidung', 'tintuc.ngaytao as ngaytao')->distinct()
                    ->join('co_loai_tintuc', 'tintuc.ma', '=', 'co_loai_tintuc.ma_tintuc')
                    ->join('loai_tintuc', 'co_loai_tintuc.ma_loai_tintuc', '=', 'loai_tintuc.ma')
                    ->join('co_lienquan_gionglua', 'tintuc.ma', '=', 'co_lienquan_gionglua.ma_tintuc')
                    ->join('gionglua', 'co_lienquan_gionglua.ma_gionglua', '=', 'gionglua.ma');
            }
        }


        // dd($this->data['ds_tintuc']);
        if ($request->key_ds_loai_tintuc != null) {
            $theloai = ' thuộc thể loại ';
            $str = $request->key_ds_loai_tintuc;
            $char = ",";
            $start = 0;
            $num = substr_count($str, $char, $start);
            $str = explode(",", $request->key_ds_loai_tintuc);
            for ($i = 0; $i < $num; $i++) {
                if ($i != 0) {
                    $this->data['ds_tintuc']->orWhere('loai_tintuc.ten', $str[$i]);
                } else {
                    $this->data['ds_tintuc']->Where('loai_tintuc.ten', $str[$i]);
                }
                if ($i == $num - 1) {
                    $theloai = $theloai . '<b>' . $str[$i] . '</b>';
                } else {
                    $theloai = $theloai . '<b>' . $str[$i] . '</b>' . ' hoặc ';
                }
            }
        }

        if ($request->key_ds_gionglua != null) {
            $gionglua = ' có liên quan đến ';
            $str = $request->key_ds_gionglua;
            $char = ",";
            $start = 0;
            $num = substr_count($str, $char, $start);
            $str = explode(",", $request->key_ds_gionglua);
            for ($i = 0; $i < $num; $i++) {
                if ($i != 0) {
                    $this->data['ds_tintuc']->orWhere('gionglua.ten', $str[$i]);
                } else {
                    $this->data['ds_tintuc']->Where('gionglua.ten', $str[$i]);
                }
                if ($i == $num - 1) {
                    $gionglua = $gionglua . '<b>' . $str[$i] . '</b>';
                } else {
                    $gionglua = $gionglua . '<b>' . $str[$i] . '</b>' . ' hoặc ';
                }
            }
        }
        $keyw = '';
        if ($request->key != null) {
            $keyw = ' với từ khóa <b>' . $request->key . '</b>';
            $this->data['ds_tintuc']->where('tintuc.ten', 'like', '%' . $request->key . '%');
        }


        $this->data['ds_tintuc'] = $this->data['ds_tintuc']->select('tintuc.ma as ma', 'tintuc.ten as ten', 'noidung', 'tintuc.ngaytao as ngaytao')
            ->distinct();

        $num = $this->data['ds_tintuc']->distinct()->count('tintuc.ma');
        $this->data['ds_tintuc'] = $this->data['ds_tintuc']->simplePaginate(4);
        foreach ($this->data['ds_tintuc'] as $key => $item) {
            $ma = $item->ma;
            $item->ten_hinhanh = $this->danhsach_hinhanh->get_ten_tintuc($ma);
            $item->loai_tintuc = DB::table('co_loai_tintuc')
                ->select('loai_tintuc.ten as ten_tintuc')->where('ma_tintuc', $ma)
                ->join('loai_tintuc', 'co_loai_tintuc.ma_loai_tintuc', '=', 'loai_tintuc.ma')->get();
            $item->gionglua_lienquan = DB::table('co_lienquan_gionglua')
                ->select('gionglua.ten as ten_gionglua_lienquan')->where('ma_tintuc', $ma)
                ->join('gionglua', 'co_lienquan_gionglua.ma_gionglua', '=', 'gionglua.ma')->get();
        }
        $this->data['text'] = '';
        if ($request->key_ds_loai_tintuc != null || $request->key_ds_gionglua != null || $request->key != null) {
            if ($num > 0) {
                $this->data['text'] = '<p>Tìm thấy <b>' . $num . '</b> bài viết ' . $theloai . $gionglua . $keyw . ' </p>';
            } else {
                $this->data['text'] = 'Không tìm thấy bài viết ';
            }
        }
        return view("user.ds_tintuc", $this->data);
    }
    public function ds_gionglua(Request $request)
    {
        $this->data['title'] = 'Danh sách giống lúa';
        $this->data['url'] = 'ds_gionglua';


        // $key='';
        // if ($request->key != null) {
        //     $key=' với từ khóa '.$request->key;
        //     $this->data['ds_tintuc']->where('tintuc.ten', 'like', '%'.$request->key.'%');

        // }

        // $key = $request->key;
        // if ($key == '') {
        //     $this->data['ds_gionglua'] = $this->gionglua->getAll();
        // } else {
        //     $this->data['ds_gionglua'] = $this->gionglua->getAll_voiKey($key);
        // }
        // foreach ($this->data['ds_gionglua'] as $key => $item) {
        //     $ma = $item->ma;
        //     $item->ten_hinhanh = $this->danhsach_hinhanh->get_ten_gionglua($ma);
        // }
        $this->data['ds_gionglua'] =  DB::table('gionglua');
        $chongchiutot = '';
        $debinhiem = '';

        // if ($request->key_ds_chongchiutot != null || $request->key_ds_debinhiem != null) {
        //     if ($request->key_ds_chongchiutot != null) {
        //         $this->data['ds_gionglua'] = DB::table('gionglua')
        //             ->select('gionglua.ma as ma', 'saubenh.ten as ten_chongchiutot', 'gionglua.ten as ten','gionglua.thongtinkhac as thongtinkhac', 'gionglua.ngaytao as ngaytao')
        //             ->join('chongchiutot', 'gionglua.ma', '=', 'chongchiutot.ma_gionglua')
        //             ->join('saubenh', 'chongchiutot.ma_saubenh', '=', 'saubenh.ma');
        //     }
        //     if ($request->key_ds_debinhiem != null) {
        //         $this->data['ds_gionglua'] = DB::table('gionglua')->distinct()
        //         ->select('gionglua.ma as ma', 'saubenh.ten as ten_debinhiem', 'gionglua.ten as ten','gionglua.thongtinkhac as thongtinkhac', 'gionglua.ngaytao as ngaytao')
        //         ->join('debinhiem', 'gionglua.ma', '=', 'debinhiem.ma_gionglua')
        //         ->join('saubenh', 'debinhiem.ma_saubenh', '=', 'saubenh.ma');
        //     } 
        //     else {
        //         $this->data['ds_tintuc'] = DB::table('tintuc')->distinct()
        //         ->select('gionglua.ma as ma', 'saubenh.ten as ten_chongchiutot', 'gionglua.ten as ten', 'gionglua.thongtinkhac as thongtinkhac', 'gionglua.ngaytao as ngaytao')
        //         ->join('chongchiutot', 'gionglua.ma', '=', 'chongchiutot.ma_gionglua')
        //         ->join('saubenh', 'chongchiutot.ma_saubenh', '=', 'saubenh.ma')
        //         ->select( 'saubenh.ten as ten_debinhiem')
        //         ->join('debinhiem', 'gionglua.ma', '=', 'debinhiem.ma_gionglua')
        //         ->join('saubenh', 'debinhiem.ma_saubenh', '=', 'saubenh.ma');
        //     }
        // }
        if ($request->key_ds_chongchiutot != null || $request->key_ds_debinhiem != null) {
            $this->data['ds_gionglua'] = DB::table('gionglua')
                ->select('debinhiem.ma_saubenh as debinhiem', 'chongchiutot.ma_saubenh as chongchiutot', 'gionglua.ma as ma', 'gionglua.ten as ten', 'gionglua.thongtinkhac as thongtinkhac', 'gionglua.ngaytao as ngaytao')
                ->join('chongchiutot', 'gionglua.ma', '=', 'chongchiutot.ma_gionglua')
                ->join('debinhiem', 'gionglua.ma', '=', 'debinhiem.ma_gionglua');
        }

        if ($request->key_ds_chongchiutot != null) {
            $chongchiutot = ' có khả năng chống chịu tốt với ';
            $str = $request->key_ds_chongchiutot;
            $char = ",";
            $start = 0;
            $num = substr_count($str, $char, $start);
            $str = explode(",", $request->key_ds_chongchiutot);
            for ($i = 0; $i < $num; $i++) {

                // $this->data['ds_gionglua'] = DB::table('gionglua')
                //     ->select('debinhiem.ma_saubenh as debinhiem','chongchiutot.ma_saubenh as chongchiutot','gionglua.ma as ma', 'gionglua.ten as ten','gionglua.thongtinkhac as thongtinkhac', 'gionglua.ngaytao as ngaytao')
                //     ->join('chongchiutot', 'gionglua.ma', '=', 'chongchiutot.ma_gionglua')
                //     ->join('debinhiem', 'gionglua.ma', '=', 'debinhiem.ma_gionglua');

                if ($i != 0) {
                    $this->data['ds_gionglua']->orWhere('chongchiutot.ma_saubenh', DB::table('saubenh')->select()->where('ten', $str[$i])->value('ma'));
                } else {
                    $this->data['ds_gionglua']->Where('chongchiutot.ma_saubenh', DB::table('saubenh')->select()->where('ten', $str[$i])->value('ma'));
                }
                // ->orwhere('chongchiutot.ma_saubenh', DB::table('saubenh')->select()->where('ten',$str[$i])->value('ma') );

                if ($i == $num - 1) {
                    $chongchiutot = $chongchiutot . '<b>' . $str[$i] . '</b>';
                } else {
                    $chongchiutot = $chongchiutot . '<b>' . $str[$i] . '</b>' . ' hoặc ';
                }
            }
        }
        // dd( $this->data['ds_gionglua']->get());


        if ($request->key_ds_debinhiem != null) {
            $debinhiem = ' dễ bị nhiễm bởi ';
            $str = $request->key_ds_debinhiem;
            $char = ",";
            $start = 0;
            $num = substr_count($str, $char, $start);
            $str = explode(",", $request->key_ds_debinhiem);
            for ($i = 0; $i < $num; $i++) {

                if ($i != 0) {
                    $this->data['ds_gionglua']->orWhere('debinhiem.ma_saubenh', DB::table('saubenh')->select()->where('ten', $str[$i])->value('ma'));
                } else {
                    $this->data['ds_gionglua']->Where('debinhiem.ma_saubenh', DB::table('saubenh')->select()->where('ten', $str[$i])->value('ma'));
                }
                // ->orwhere('debinhiem.ma_saubenh', DB::table('saubenh')->select()->where('ten',$str[$i])->value('ma') );


                if ($i == $num - 1) {
                    $debinhiem = $debinhiem . '<b>' . $str[$i] . '</b>';
                } else {
                    $debinhiem = $debinhiem . '<b>' . $str[$i] . '</b>' . ' hoặc ';
                }
            }
            // $this->data['ds_gionglua']->Where('debinhiem.ma_saubenh', DB::table('saubenh')->select()->where('ten', $str[$i])->value('ma'));

        }
        // dd($this->data['ds_gionglua']->get());

        $keyw = '';
        if ($request->key != null) {
            $keyw = ' với từ khóa <b>' . $request->key . '</b>';
            $this->data['ds_gionglua']->where('gionglua.ten', 'like', '%' . $request->key . '%');
        }


        $this->data['ds_gionglua'] = $this->data['ds_gionglua']->select('gionglua.ma as ma', 'gionglua.ten as ten', 'gionglua.dacdiem as dacdiem', 'gionglua.thongtinkhac as thongtinkhac', 'gionglua.ngaytao as ngaytao')
            ->distinct();

        $num = $this->data['ds_gionglua']->distinct()->count('gionglua.ma');
        $this->data['ds_gionglua'] = $this->data['ds_gionglua']->simplePaginate(4);
        foreach ($this->data['ds_gionglua'] as $key => $item) {
            $ma = $item->ma;
            $item->ten_hinhanh = $this->danhsach_hinhanh->get_ten_gionglua($ma);
            $item->chongchiutot = DB::table('chongchiutot')
                ->select('saubenh.ten as ten_chongchiutot')->where('ma_gionglua', $ma)
                ->join('saubenh', 'chongchiutot.ma_saubenh', '=', 'saubenh.ma')->get();
            $item->debinhiem = DB::table('debinhiem')
                ->select('saubenh.ten as ten_debinhiem')->where('ma_gionglua', $ma)
                ->join('saubenh', 'debinhiem.ma_saubenh', '=', 'saubenh.ma')->get();
        }
        $this->data['text'] = '';
        if ($request->key_ds_chongchiutot != null || $request->key_ds_debinhiem != null || $request->key != null) {
            if ($num > 0) {
                $this->data['text'] = '<p>Tìm thấy <b>' . $num . '</b> bài viết về giống lúa ' . $chongchiutot . $debinhiem . $keyw . ' </p>';
            } else {
                $this->data['text'] = 'Không tìm thấy bài viết ';
            }
        }

        return view("user.ds_gionglua", $this->data);
    }
    public function ds_saubenh(Request $request)
    {
        $this->data['title'] = 'Danh sách sâu bệnh';
        $this->data['url'] = 'ds_saubenh';


        $key = $request->key;
        if ($key == '') {
            $this->data['ds_saubenh'] = $this->saubenh->getAll();
        } else {
            $this->data['ds_saubenh'] = $this->saubenh->getAll_voiKey($key);
        }
        foreach ($this->data['ds_saubenh'] as $key => $item) {
            $ma = $item->ma;
            $item->ten_hinhanh = $this->danhsach_hinhanh->get_ten_saubenh($ma);
        }
        return view("user.ds_saubenh", $this->data);
    }


    public function ds_phanhoi(Request $request)
    {
        if (!Auth::user()) {
            return redirect(route('dangnhap'));
        }
        $this->data['title'] = 'Danh sách phản hồi';
        $this->data['url'] = 'ds_phanhoi';

        $this->data['ds_phanhoi'] =  DB::table('phanhoi')->where('ma_user', Auth::user()->id)->get();
        return view("user.ds_phanhoi", $this->data);
    }


    ///
    public function dangky()
    {
        $this->data['title'] = 'Đăng ký';
        $this->data['url'] = 'add_nguoidung';
        return view("user.dangky", $this->data);
    }

    public function post_dangky(Request $request)
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
            'is_admin' => 0,
        ]);
        return redirect(route('dangnhap'))->with('msgDkSuc', 'Đăng ký thành công');
    }

    public function binhluan_tintuc(Request $request)
    {
        if(Auth::user()->status_comment != 1){
            return response()->json(['err' => 'Lỗi']);
        }

        $save = new Binhluan;
        $save->ma_user = $request->ma_user;
        $save->noidung = $request->noidung;
        $save->ma_tintuc = $request->ma_tintuc;
        $save->ngay_binhluan = strtotime(date("Y-m-d H:i:s"));
        $save->save();
    }
    public function binhluan_gionglua(Request $request)
    {
        if(Auth::user()->status_comment != 1){
            return response()->json(['err' => 'Lỗi']);
        }
        $save = new Binhluan;
        $save->ma_user = $request->ma_user;
        $save->noidung = $request->noidung;
        $save->ma_gionglua = $request->ma_gionglua;
        $save->ngay_binhluan = strtotime(date("Y-m-d H:i:s"));
        $save->save();
    }
    public function binhluan_saubenh(Request $request)
    {
        if(Auth::user()->status_comment != 1){
            return response()->json(['err' => 'Lỗi']);
        }
        $save = new Binhluan;
        $save->ma_user = $request->ma_user;
        $save->noidung = $request->noidung;
        $save->ma_saubenh = $request->ma_saubenh;
        $save->ngay_binhluan = strtotime(date("Y-m-d H:i:s"));
        $save->save();
    }
    public function delete_binhluan(Request $request)
    {
        Binhluan::where('ma', $request->ma)->first()->delete_binhluan($request->ma);
        return response()->json(['articleDelete' => 'success']);
    }
}
