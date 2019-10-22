<?php

/**
 * 前端导航管理
 * 
 * @author: honglinzi
 * @version: 1.0
 */

namespace app\admin\controller;

use app\admin\common\Purview;
use app\admin\model\Nav as MyModel;

class Nav extends Purview
{

    protected $isBlankItems = ['0' => '否', '1' => '是'];

    /**
     * 列表页面
     * 
     * @return string
     */
    public function index()
    {
        $model = new MyModel();
        $list = $model->paginate(10);
        $page = $list->render();
        $this->assign('list', $list);
        $this->assign('page', $page);
        $this->assign('is_blankItems', $this->isBlankItems);

        return $this->fetch();
    }

    /**
     * 执行删除
     * 
     * @return string
     */
    public function del()
    {
        $id = $this->request->param('id/d');

        if ($id > 0)
        {
            $model = MyModel::get($id);
            if ($model && $model->delete())
            {
                return $this->success('操作成功', '/admin/Nav/index');
            }
        }
        return $this->error('出错了，记录不存在');
    }

    /**
     * 编辑页面
     * 
     * @return string
     */
    public function edit()
    {
        $id = $this->request->param('id/d');

        if ($id > 0)
        {
            $model = new MyModel();
            $records = $model->get($id);
            if ($records)
            {
                $this->assign('records', $records);

                $this->assign('is_blankItems', $this->isBlankItems);

                return $this->fetch();
            }
        }
        return $this->error('出错了', '/admin/Nav/index');
    }

    /**
     * 执行编辑
     * 
     * @return string
     */
    public function doEdit()
    {
        $id = $this->request->param('id/d');
        if ($id > 0)
        {
            $data = $this->request->post('Nav');

            $model = new MyModel();
            $myModel = $model->get($id);
            if ($myModel)
            {
                if ($myModel->save($data))
                {
                    return $this->success('操作成功', '/admin/Nav/index');
                }
                else
                {
                    return $this->error($myModel->getError(), '/admin/Nav/edit/id/' . $id);
                }
            }
        }
        return $this->error('操作失败，记录不存在');
    }

    /**
     * 新增页面
     * 
     * @return string
     */
    public function add()
    {
        $this->assign('is_blankItems', $this->isBlankItems);

        return $this->fetch();
    }

    /**
     * 执行新增
     * 
     * @return string
     */
    public function doAdd()
    {
        $data = $this->request->post('Nav');

        $model = new MyModel();
        if ($model->save($data))
        {
            return $this->success('操作成功', '/admin/Nav/index');
        }
        else
        {
            return $this->error($model->getError(), '/admin/Nav/add');
        }
    }

}
