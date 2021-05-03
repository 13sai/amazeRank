<?php

namespace App\Http\Controllers\Admin;


use function EasyWeChat\Kernel\Support\str_random;
use App\Models\Admin;
use App\Models\OperationLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function index()
    {
        $adminList = Admin::select('id', 'role', 'name', 'username', 'created_at')->get();
        return $this->success($adminList);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        try {
            $admin = Admin::create([
                'role' => $data['role'],
                'name' => $data['name'],
                'username' => $data['name'],
                'api_token' => str_random(60),
                'password' => bcrypt($data['password']),
            ]);
            if ($admin) {
                return $this->success($admin);
            } else {
                return $this->failure();
            }
        } catch (\Exception $e) {
            return $this->failure('', $e->getMessage());
        }
    }

    public function edit(Request $request)
    {
        $id = $request->get('id');
        $admin = Admin::find($id);
        return $this->success($admin);
    }

    public function update(Request $request)
    {
        $data = $request->all();
        try {
            $adminData = [
                'name' => $data['name'],
                'role' => $data['role'],
            ];
            $data['password'] && $adminData['password'] = bcrypt($data['password']);
            Admin::where('id', $data['id'])->update($adminData);
            return $this->success();
        } catch (\Exception $e) {
            return $this->failure('', $e->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        $id = $request->get('id');
        if (Admin::where('id', $id)->delete()) {
            return $this->success();
        } else {
            return $this->failure();
        }
    }

    public function logList(Request $request)
    {
        $model = new OperationLog();
        $params = $request->all();

        $data = $model->orderBy('id', 'desc')
            ->paginate(20);

        foreach ($data as $item) {
            $item->date = date('Y-m-d', strtotime($item->date));
        }
        return $this->success($data);
    }
}