<?php

namespace FBNKCMaster\xDBShow\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

use Auth;

class XDBShowController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $authAdminMiddleware = config('xDBShow.auth_admin_middleware');
        if ($authAdminMiddleware) {
            $this->middleware($authAdminMiddleware);
        } else { // We suppose you have isAdmin() method in the User model
            $this->middleware(function ($request, $next) {
                if (!Auth::check()) {
                    return redirect()->to('/login');
                } else if (!method_exists(Auth::user(),'isAdmin') || !Auth::user()->isAdmin()) {
                    abort(403);
                }
    
                return $next($request);
            });
        }
    }

    public function index()
    {
        $tables = Schema::getAllTables();

        $hiddenTables = config('xDBShow.hidden_tables', []);

        $tables = array_filter($tables, fn ($table) => !in_array($table->name, $hiddenTables));
        
        
        foreach ($tables as &$table) {
            $table->count = DB::table($table->name)->count();
        }

        $databaseName = \DB::connection()->getDatabaseName();
        $databaseName = explode('/', $databaseName);
        $databaseName = end($databaseName);

        return view('xDBShow::index', [ 'databaseName' => $databaseName, 'data' => $tables ]);
    }
    
    public function show(Request $request, $tableName)
    {
        $hiddenColumns = config('xDBShow.hidden_columns' . '.' . $tableName, []);

        $allColumns = Schema::getColumnListing($tableName);
        $onlyColumns = array_diff($allColumns, $hiddenColumns);
        $records = DB::table($tableName)->select($onlyColumns)->paginate(15);

        $data = [
            'title' => $tableName,
            'records' => $records,
        ];
        
        return view('xDBShow::show', $data);
    }

}
