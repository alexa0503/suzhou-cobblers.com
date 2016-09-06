<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use DB;
use Maatwebsite\Excel\Facades\Excel;
//use App\Http\Controllers\Controller;

class AdminController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$count = \App\WechatUser::count();
        $count = 0;
        return view('cms/dashboard',['count' => $count]);
    }

    /**
     * 账户管理
     */
    public function users()
    {
        $users = DB::table('users')->paginate(20);
        return view('cms/users', ['users' => $users]);
    }
    /**
     *账户管理
     */
    public function account()
    {
        return view('cms/account');
    }
    public function accountPost(Requests\AccountFormRequest $request)
    {
        //var_dump($request->user()->id);
        $user = \App\User::find($request->user()->id);
        $user->password = bcrypt($request->input('password'));
        $user->save();
        return redirect('cms/logout');
        //var_dump($request->input('password'));
    }
    public function userLogs()
    {
        $logs = \App\UserLog::limit(30)->offset(0)->orderBy('create_time', 'DESC')->get();
        return view('cms/userLogs',['logs' => $logs]);
    }
    //导出
    public function export()
    {
        $filename = 'wechat'.date('YmdHis');
        $collection = \App\WechatUser::all();
        $data = $collection->map(function($item){
            return [
                $item->id,
                $item->open_id,
                json_decode($item->nick_name),
                $item->head_img,
                $item->gender,
                $item->country,
                $item->province,
                $item->city,
                $item->create_time,
                $item->create_ip,
            ];
        });
        Excel::create($filename, function($excel) use($data) {
            $excel->setTitle('微信用户');
            // Chain the setters
            $excel->setCreator('Alexa');
            // Call them separately
            $excel->setDescription('A demonstration to change the file properties');
            $excel->sheet('Sheet', function($sheet) use($data) {
                $sheet->row(1, array('ID','openid','昵称','头像','性别','国家','省份','城市','授权时间','授权IP'));
                $sheet->fromArray($data, null, 'A2', false, false);
            });
        })->download('xlsx');
    }
    public function fileUpload(Request $request)
    {
        if ($request->hasFile('thumb')) {
            if ($request->file('thumb')->getError() != 0) {
                return Response(['error' => $request->file('thumb')->getErrorMessage()], 422);
            }
            $file = $request->file('thumb');

            $entension = $file->getClientOriginalExtension();
            $file_name = uniqid().'.'.$entension;
            $path = 'uploads/'.date('Ymd').'/';
            $file->move(public_path($path), $file_name);
            return [];
        }
        return Response(['ret'=>1001,'msg'=>'上传失败'],422);

    }
    public function fileDelete(Request $request)
    {

    }
    public function city()
    {
    }
}
