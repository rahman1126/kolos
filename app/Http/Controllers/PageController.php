<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\Page;

use Validator;

/**
 * Page Controlller
 */
class PageController extends Controller
{
    // get index page
    public function getIndex()
    {
        $pages = Page::all();
        return view('admin.pages.view')->with('pages', $pages);
    }

    // get create page
    public function getCreate()
    {
        return view('admin.pages.create');
    }

    // store data
    public function postStore(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'name'          => 'required'
        ]);

        if ($valid->fails()) {
            return redirect()->back()
                ->withErrors($valid)
                ->withInput();
        } else {

            $page = new Page;
            $page->name = $request->input('name');
            $page->slug = str_slug($request->input('name'), '-');
            $page->description = $request->input('description');

            if ($page->save()) {
                return redirect('home/page')
                    ->with('msg', 'Page successfully created');
            } else {

                return redirect()->back()
                    ->with('err', 'Page cannot be created. Please try again');

            }

        }
    }

    // get edit page
    public function getEdit($id)
    {
        $page = Page::find($id);
        return view('admin.pages.edit')->with('page', $page);
    }

    // update data
    public function postUpdate(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'name'          => 'required'
        ]);

        if ($valid->fails()) {
            return redirect()->back()
                ->withErrors($valid)
                ->withInput();
        } else {

            $page = Page::find($request->input('id'));
            $page->name = $request->input('name');
            $page->slug = str_slug($request->input('name'), '-');
            $page->description = $request->input('description');

            if ($page->save()) {
                return redirect()->back()
                    ->with('msg', 'Page successfully updated');
            } else {

                return redirect()->back()
                    ->with('err', 'Page cannot be updated. Please try again');

            }

        }
    }

    // delete data
    public function postDelete()
    {

    }
}


?>
