<?php


namespace app\admin\controller;

use app\model\Tags;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\facade\View;
use think\exception\ValidateException;

class Tag extends BaseAdmin
{

    protected function initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub
    }

    public function index()
    {
        return view();
    }

    public function list()
    {
        $page = intval(input('page'));
        $limit = intval(input('limit'));
        $data = Tags::order('id', 'desc');
        $count = $data->count();
        $tags = $data->order('id', 'desc')
            ->limit(($page - 1) * $limit, $limit)->select();
        return json([
            'code' => 0,
            'msg' => '',
            'count' => $count,
            'data' => $tags
        ]);
    }

    public function create()
    {
        if (request()->isPost()) {
            $tag = new Tags();
            $tag->tag_name = input('tag_name');
            $result = $tag->save();
            if ($result) {
                return json(['err' => 0, 'msg' => '添加成功']);
            } else {
                return json(['err' => 1, 'msg' => '添加失败']);
            }
        }
        return view();
    }

    public function edit()
    {
        $id = input('id');
        try {
            $tag = Tags::findOrFail($id);
            if (request()->isPost()) {
                $tag->tag_name = input('tag_name');
                $result = $tag->save();
                if ($result) {
                    return json(['err' => 0, 'msg' => '修改成功']);
                } else {
                    return json(['err' => 1, 'msg' => '修改失败']);
                }
            }
            View::assign([
                'tag' => $tag,
            ]);
            return view();
        } catch (ModelNotFoundException $e) {
            return json(['err' => 1, 'msg' => $e->getMessage()]);
        }
    }

    public function delete()
    {
        $id = input('id');
        $result = Tags::destroy($id);
        if ($result) {
            return json(['err' => '0', 'msg' => '删除成功']);
        } else {
            return json(['err' => '1', 'msg' => '删除失败']);
        }
    }


}