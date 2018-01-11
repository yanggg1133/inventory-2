<?php

class AdjustmentMemoController extends \BaseController {

    protected $layout = 'template';

    public function index()
    {
        if (!Sentry::check())
        {
            return Redirect::to('/dashboard');
        }
        else
        {
            $memos = DB::select("SELECT adjustment_memos.id as id ,adjustment_memos.created_at as date , products.title as product, adjustment_memos.quantity as quantity FROM adjustment_memos LEFT JOIN products ON (products.aid = adjustment_memos.aid)");

            $this->layout->content = View::make('adjustment.index', array(
                'memos' => $memos
                ));
        }

    }

    public function create()
    {
        if (!Sentry::check())
        {
            return Redirect::to('/dashboard');
        }
        else
        {
            $products = DB::select("SELECT aid, title FROM products");
            $this->layout->content = View::make('adjustment.create', array(
                'products' => $products,
                ));
        }

    }

    public function store()
    {
        if (!Sentry::check())
        {
            return Redirect::to('/dashboard');
        }
        else
        {
            try
            {
                $memo = new AdjustmentMemo;
                $memo->aid = Input::get('aid');
                $memo->quantity = Input::get('quantity');
                $memo->memo = Input::get('memo');
                $memo->save();

                return Redirect::to('/adjustment-memos');
            }

            catch (\Exception $e)
            {
                echo "Failed : Creating the Memo";
            }
        }

    }
    
    public function show($id)
    {
        if (!Sentry::check())
        {
            return Redirect::to('/dashboard');
        }
        else
        {
            $memos = DB::select("SELECT adjustment_memos.id as id , adjustment_memos.aid as aid , adjustment_memos.created_at as date , products.title as product, adjustment_memos.quantity as quantity, adjustment_memos.memo as memo FROM adjustment_memos LEFT JOIN products ON (products.aid = adjustment_memos.aid) WHERE adjustment_memos.id = $id");

            $this->layout->content = View::make('adjustment.show', array(
                'memos' => $memos
                ));
        }

    }

    public function edit($id)
    {
        if (!Sentry::check())
        {
            return Redirect::to('/dashboard');
        }
        else
        {
            $memos = DB::select("SELECT adjustment_memos.id as id , adjustment_memos.aid as aid , adjustment_memos.created_at as date , products.title as product, adjustment_memos.quantity as quantity, adjustment_memos.memo as memo FROM adjustment_memos LEFT JOIN products ON (products.aid = adjustment_memos.aid) WHERE adjustment_memos.id = $id");
            $products = DB::select("SELECT aid, title FROM products");
            $this->layout->content = View::make('adjustment.edit', array(
                'memos' => $memos,
                'products' => $products,
                'id' => $id,
                ));
        }

    }

    public function update($id)
    {
        if (!Sentry::check())
        {
            return Redirect::to('/dashboard');
        }
        else
        {
            
                $memo = AdjustmentMemo::find($id);
                $memo->aid = Input::get('aid');
                $memo->quantity = Input::get('quantity');
                $memo->memo = Input::get('memo');
                $memo->save();

                return Redirect::to('/adjustment-memos/'.$id);
        }

    }

    public function destroy($id)
    {
        if (!Sentry::check())
        {
            return Redirect::to('/dashboard');
        }
        else
        {
            AdjustmentMemo::destroy($id);
        }
    }
}