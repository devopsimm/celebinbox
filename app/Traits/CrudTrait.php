<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait CrudTrait
{
    public function index()
    {
        $data = $this->getModel()->paginate();
        return view($this->getViewFolder() . '.index', compact('data'));
    }

    public function create()
    {
        return view($this->getViewFolder() . '.create');
    }

    public function store(Request $request)
    {
        $this->getModel()->create($request->all());
        return redirect()->route($this->getRouteName() . '.index');
    }

    public function show($id)
    {
        $data = $this->getModel()->find($id);
        return view($this->getViewFolder() . '.show', compact('data'));
    }

    public function edit($id)
    {
        $data = $this->getModel()->find($id);
        return view($this->getViewFolder() . '.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $this->getModel()->find($id)->update($request->all());
        return redirect()->route($this->getRouteName() . '.index');
    }

    public function destroy($id)
    {
        $this->getModel()->find($id)->delete();
        return redirect()->route($this->getRouteName() . '.index');
    }

    protected function getModel()
    {
        return $this->modelName;
    }

    protected function getViewFolder()
    {
        return $this->viewFolder;
    }

    protected function getRouteName()
    {
        return $this->routeName;
    }
}

