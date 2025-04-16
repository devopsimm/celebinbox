<?php

namespace App\Http\Controllers\Admin;

use App\Models\Template;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\GeneralService;
/**
 * Class TemplateController
 * @package App\Http\Controllers
 */
class TemplateController extends Controller
{
    public $gService;

    public function __construct()
    {
        $this->gService = new GeneralService();
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index()
    {
        if (!request()->user()->can('templates.view')){
            return abort('403');
        }
        $templates = Template::paginate();

        return view('admin.template.index', compact('templates'))
            ->with('i', (request()->input('page', 1) - 1) * $templates->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function create()
    {
        if (!request()->user()->can('templates.create')){
            return abort('403');
        }
        $template = new Template();
        return view('admin.template.create', compact('template'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if (!request()->user()->can('templates.create')){
            return abort('403');
        }
        request()->validate(Template::$rules);

        $template = Template::create($request->all());

        return redirect()->route('templates.index')
            ->with('success', 'Template created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function show($id)
    {
        if (!request()->user()->can('templates.view')){
            return abort('403');
        }
        $template = Template::find($id);

        return view('admin.template.show', compact('template'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!request()->user()->can('templates.edit')){
            return abort('403');
        }
        $template = Template::find($id);

        return view('admin.template.edit', compact('template'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Template $template
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Template $template)
    {
        if (!request()->user()->can('templates.edit')){
            return abort('403');
        }
        request()->validate(Template::$rules);

        $template->update($request->all());

        return redirect()->route('templates.index')
            ->with('success', 'Template updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        if (!request()->user()->can('templates.delete')){
            return abort('403');
        }
        Template::find($id)->delete();

        return redirect()->route('templates.index')
            ->with('success', 'Template deleted successfully');
    }
}
