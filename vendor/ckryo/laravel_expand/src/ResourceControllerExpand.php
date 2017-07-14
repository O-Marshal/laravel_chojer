<?php

namespace Ckryo\Laravel\Expand;

use Ckryo\Laravel\Auth\Auth;
use Ckryo\Laravel\Handler\ErrorCodeException;
use Ckryo\Laravel\Logi\Facades\Logi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

trait ResourceControllerExpand
{
    /**
     * 授权用户类型
     * @return string
     */
    function authKey () {
        return "json";
    }


    /**
     * 获取当前资源控制器关联的数据库模型
     * @return \Illuminate\Database\Eloquent\Model
     */
    abstract function resourceModel ();

    /**
     * 获取模型名称的key
     * @return string
     */
    protected function resourceModelNameKey () { return "name"; }

    /**
     * 获取模型主键
     * @return string
     */
    protected function resourceModelPrimaryKey () { return 'id'; }


    /**
     * 获取模型、行为 对应的名称
     * @return string
     */
    abstract function resourceName ();

    /**
     * 获取模型 对应的中文名称
     * @return string
     */
    abstract function resourceDescription ();

    /**
     * 创建数据时,表单验证
     * @param Request $request 请求数据
     * @return mixed
     */
    protected function storeValidate (Request $request, $admin) { return null; }
    protected function storeCustom (Request $request, $admin) { return false; }

    /**
     * 修改数据时,表单验证
     * @param Request $request 请求数据
     * @return mixed
     */
    protected function updateValidate (Request $request, $admin) { return null; }
    protected function updateFillables () { return []; }
    protected function updateCustom (array $updates, $admin, Model $model) { return false; }


    // 资源控制器 - 查询,显示,编辑,删除
    // 删除 , 删除单个, 删除多个


    protected function getDestroyMessageWithDatas (Collection $sql) {
        return '删除了'.$sql->count().'条'.$this->resourceDescription().'数据';
    }

    protected function getDestroyMessageWithSinge ($data) {
        $key = $this->resourceModelNameKey();
        return '删除了'.$this->resourceDescription().':'.$data->$key;
    }

    protected function getCreateMessage ($data) {
        $key = $this->resourceModelNameKey();
        return '创建了'.$this->resourceDescription().':'.$data->$key;
    }

    protected function getUpdateMessage ($data) {
        $key = $this->resourceModelNameKey();
        return '修改了'.$this->resourceDescription().':'.$data->$key;
    }


//    protected function access_logi () {
//        Logi::action($admin->id, 'admin_role', $data->id, 'delete', $this->getDestroyMessageWithSinge($data), json_encode($data->toArray(), JSON_UNESCAPED_UNICODE));
//    }

    /**
     * 行为操作记录
     * @param string $action 行为名称: create,update,delete
     * @param int $admin_id 管理员ID,操作人员信息
     * @param int $union_id 关联数据ID
     * @param string $errMsg 错误信息
     * @param string $data_str 需要保存的数据,json字符串
     */
    protected function logi ($action, $admin_id, $union_id, $errMsg, $data_str) {
        Logi::action($admin_id, $this->resourceName(), $union_id, $action, $errMsg, $data_str);
    }


    function destroy (Auth $auth, $id_str) {
        $items = explode('|', $id_str);
        DB::transaction(function () use ($items, $auth) {
            $admin = $auth->user($this->authKey());
            $model = $this->resourceModel();
            $model_primaryKey = $this->resourceModelPrimaryKey();
            $sql = $model->whereIn($model_primaryKey, $items);
            $data = $sql->get();
            if (count($data) > 1) {
                $this->logi('deletes', $admin->id, 0, $this->getDestroyMessageWithDatas($data), json_encode($data->toArray(), JSON_UNESCAPED_UNICODE));
            } elseif (count($data) === 1) {
                $item = $data->first();
                $this->logi('delete', $admin->id, $item->$model_primaryKey, $this->getDestroyMessageWithSinge($item), json_encode($item->toArray(), JSON_UNESCAPED_UNICODE));
            }
            $sql->delete();
        });
        return response()->ok('操作成功');
    }

    function store (Request $request, Auth $auth) {
        $admin = $auth->user($this->authKey());
        $this->storeValidate($request, $admin);

        DB::transaction(function () use ($request, $admin) {
            $data = $this->storeCustom($request, $admin);
            $model_primaryKey = $this->resourceModelPrimaryKey();
            if (!$data) {

                $fillables = $this->resourceModel()->getFillable();
                $data = $this->resourceModel()->create($request->only($fillables));
            }
            $this->logi('create', $admin->id, $data->$model_primaryKey, $this->getCreateMessage($data), json_encode($request->all(), JSON_UNESCAPED_UNICODE));
        });
        return response()->ok('创建成功');
    }

    function update(Request $request, Auth $auth, $model_id) {
        $model = $this->resourceModel()->where($this->resourceModelPrimaryKey(), $model_id)->first();
        if (!$model) throw new ErrorCodeException(1, '非法操作,对象不存在');
        $admin = $auth->user($this->authKey());
        $this->updateValidate($request, $admin);

        $fillables = $this->updateFillables();
        $updates = [];
        foreach ($request->only($fillables) as $key => $value) {
            if ($request->has($key)) $updates[$key] = $value;
        }
        if (count($updates) === 0) return response()->ok('未修改任何数据');

        DB::transaction(function () use ($updates, $admin, $model) {
            $update = $this->updateCustom($updates, $admin, $model);
            $model_primaryKey = $this->resourceModelPrimaryKey();
            if (!$update) {
                foreach ($updates as $key => $value) {
                    $model->$key = $value;
                }
                $model->save();
            }
            $this->logi('update', $admin->id, $model->$model_primaryKey, $this->getUpdateMessage($model), json_encode($updates, JSON_UNESCAPED_UNICODE));
        });
        return response()->ok('操作成功');
    }
}