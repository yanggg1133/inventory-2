<?php

class SalesorderitemController extends \BaseController {

	protected $layout = 'template';

	/**
     * Display a listing of the resource.
     *
     * @return Response
     */	

    public function index()
    {
        if (!Sentry::check())
        {
            return Redirect::to('/');
        }
        else
        {
            $this->layout->content = View::make('sales.index');
        }

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        if (!Sentry::check())
        {
            return Redirect::to('/');
        }
        else
        {
            $this->layout->content = View::make('');
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        if (!Sentry::check())
        {
            return Redirect::to('/');
        }
        else
        {
            $this->layout->content = View::make('');
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        if (!Sentry::check())
        {
            return Redirect::to('/');
        }
        else
        {
            $this->layout->content = View::make('');
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        if (!Sentry::check())
        {
            return Redirect::to('/');
        }
        else
        {
            $this->layout->content = View::make('sales.index');
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        if (!Sentry::check())
        {
            return Redirect::to('/');
        }
        else
        {
            $this->layout->content = View::make('');
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        if (!Sentry::check())
        {
            return Redirect::to('/');
        }
        else
        {
            $this->layout->content = View::make('');
        }
    }


}
