<?php

class AuthController extends \BaseController {

    protected $layout = 'template';

    public function index()
    {
        if (Sentry::check())
        {
            return Redirect::to('/dashboard');
        }
        else
        {

            $this->layout->content = View::make('auth.login');
        }

    }

    public function login()
    {
        try
        {
            // Set login credentials
            $credentials = array(
            'email'    => Input::get('email'),
            'password' => Input::get('password'),
            );

            // Try to authenticate the user
            $user = Sentry::authenticate($credentials, false);

            return Redirect::to('dashboard');
        }
        catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
        {
            echo 'Login field is required.';
        }
        catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
        {
            echo 'Password field is required.';
        }
        catch (Cartalyst\Sentry\Users\WrongPasswordException $e)
        {
            echo 'Wrong password, try again.';
        }
        catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
        {
            echo 'User was not found.';
        }
        catch (Cartalyst\Sentry\Users\UserNotActivatedException $e)
        {
            echo 'User is not activated.';
        }

        // The following is only required if throttle is enabled
        catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e)
        {
            echo 'User is suspended.';
        }
        catch (Cartalyst\Sentry\Throttling\UserBannedException $e)
        {
            echo 'User is banned.';
        }
    }

    public function logout()
    {
        // Logs the user out
        Sentry::logout();

        return  Redirect::to('/');
    }

    public function dashboard()
    {
        if (!Sentry::check())
        {
            return  Redirect::to('/');
        }
        else
        {
            $user = Sentry::getUser();

            if ($user->hasAccess('admin') != True)
            {
                $sellers = DB::select("SELECT id, company FROM sellers");
                $sales7 = DB::select("SELECT (SELECT Count(id) FROM sales_orders WHERE purchase_source='cs-cart' AND purchase_date BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW())  as cscart, (SELECT Count(id) FROM sales_orders WHERE purchase_source='amazon' AND purchase_date BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW())  as amazon, (SELECT Count(id) FROM sales_orders WHERE purchase_source='ebay' AND purchase_date BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW())  as ebay  FROM sales_orders LIMIT 1");
                $sales14 = DB::select("SELECT (SELECT Count(id) FROM sales_orders WHERE purchase_source='cs-cart' AND purchase_date BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW())  as cscart, (SELECT Count(id) FROM sales_orders WHERE purchase_source='amazon' AND purchase_date BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW())  as amazon, (SELECT Count(id) FROM sales_orders WHERE purchase_source='ebay' AND purchase_date BETWEEN DATE_SUB(NOW(), INTERVAL 14 DAY) AND NOW())  as ebay  FROM sales_orders LIMIT 1");
                $sales30 = DB::select("SELECT (SELECT Count(id) FROM sales_orders WHERE purchase_source='cs-cart' AND purchase_date BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW())  as cscart, (SELECT Count(id) FROM sales_orders WHERE purchase_source='amazon' AND purchase_date BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW())  as amazon, (SELECT Count(id) FROM sales_orders WHERE purchase_source='ebay' AND purchase_date BETWEEN DATE_SUB(NOW(), INTERVAL 30 DAY) AND NOW())  as ebay  FROM sales_orders LIMIT 1");
                $purchase_orders = DB::select("SELECT COUNT( id ) AS pos FROM purchase_orders WHERE STATUS = 'partial'");
                $shipments = DB::select("SELECT COUNT(tracking_num) as packages FROM shipment_packages WHERE scanned = 0");
                $orders = DB::select("SELECT COUNT(id) as orders FROM sales_orders WHERE status= 'pending'");
                $graph = DB::select("SELECT DATE(sales_orders.purchase_date) as date, IFNULL(SUM(IF(sales_orders.purchase_source = 'cs-cart',sales_order_items.quantity,0 )),0) AS website, IFNULL(SUM(IF(sales_orders.purchase_source = 'ebay',sales_order_items.quantity,0 )),0) AS ebay, IFNULL(SUM(IF(sales_orders.purchase_source = 'amazon',sales_order_items.quantity,0 )),0) AS amazon FROM sales_orders LEFT JOIN sales_order_items ON (sales_order_items.so_id = sales_orders.id) WHERE MONTH(sales_orders.purchase_date) = MONTH(CURRENT_DATE) AND YEAR(sales_orders.purchase_date) = YEAR(CURRENT_DATE) GROUP BY DATE(sales_orders.purchase_date)");
            }

            else
            {
                $sellers = DB::select("SELECT id, company FROM sellers");
                $sales7 = DB::select("SELECT (SELECT Count(id) FROM sales_orders WHERE purchase_source='cs-cart' AND purchase_date BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW())  as cscart, (SELECT Count(id) FROM sales_orders WHERE purchase_source='amazon' AND purchase_date BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW())  as amazon, (SELECT Count(id) FROM sales_orders WHERE purchase_source='ebay' AND purchase_date BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW())  as ebay  FROM sales_orders LIMIT 1");
                $sales14 = DB::select("SELECT (SELECT Count(id) FROM sales_orders WHERE purchase_source='cs-cart' AND purchase_date BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW())  as cscart, (SELECT Count(id) FROM sales_orders WHERE purchase_source='amazon' AND purchase_date BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW())  as amazon, (SELECT Count(id) FROM sales_orders WHERE purchase_source='ebay' AND purchase_date BETWEEN DATE_SUB(NOW(), INTERVAL 14 DAY) AND NOW())  as ebay  FROM sales_orders LIMIT 1");
                $sales30 = DB::select("SELECT (SELECT Count(id) FROM sales_orders WHERE purchase_source='cs-cart' AND purchase_date BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW())  as cscart, (SELECT Count(id) FROM sales_orders WHERE purchase_source='amazon' AND purchase_date BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW())  as amazon, (SELECT Count(id) FROM sales_orders WHERE purchase_source='ebay' AND purchase_date BETWEEN DATE_SUB(NOW(), INTERVAL 30 DAY) AND NOW())  as ebay  FROM sales_orders LIMIT 1");
                $purchase_orders = DB::select("SELECT COUNT( id ) AS pos FROM purchase_orders WHERE STATUS = 'partial'");
                $shipments = DB::select("SELECT COUNT(tracking_num) as packages FROM shipment_packages WHERE scanned = 0");
                $orders = DB::select("SELECT COUNT(id) as orders FROM sales_orders WHERE status= 'pending'");
                $graph = DB::select("SELECT DATE(sales_orders.purchase_date) as date, IFNULL(SUM(IF(sales_orders.purchase_source = 'cs-cart',sales_order_items.quantity,0 )),0) AS website, IFNULL(SUM(IF(sales_orders.purchase_source = 'ebay',sales_order_items.quantity,0 )),0) AS ebay, IFNULL(SUM(IF(sales_orders.purchase_source = 'amazon',sales_order_items.quantity,0 )),0) AS amazon FROM sales_orders LEFT JOIN sales_order_items ON (sales_order_items.so_id = sales_orders.id) WHERE MONTH(sales_orders.purchase_date) = MONTH(CURRENT_DATE) AND YEAR(sales_orders.purchase_date) = YEAR(CURRENT_DATE) GROUP BY DATE(sales_orders.purchase_date)");
            }

            $this->layout->content = View::make('auth.dashboard', array(
                'user' => $user,
                'sales7' => $sales7,
                'sales14' => $sales14,
                'sales30' => $sales30,
                'purchase_orders' => $purchase_orders,
                'shipments' => $shipments,
                'orders' => $orders,
                'graph' => $graph,
                ));
        }
    }


}
