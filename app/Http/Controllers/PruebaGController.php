<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use  Session;
use  Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Codedge\Fpdf\Fpdf\Fpdf;
use Mpdf\Mpdf;
use Carbon\Carbon;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Http;


class PruebaGController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view('Administrador.PruebaG.pruebag');
    }

    public function index_mapa()
    {
       return view('Administrador.PruebaG.pruebamap');
    }

    public function get_biometrico()
    {
        //$data = DB::connection('pgsqlBiometrico')->select("SELECT id, username, password, update_time, first_name, last_name, emp_pin, email, tele_phone, auth_time_dept, login_id, login_type, login_count, is_staff, is_active, is_superuser, is_public, can_manage_all_dept, del_flag, date_joined, last_login, session_key, login_ip, photo FROM public.auth_user; ");
        $insert = DB::connection('pgsqlBiometrico')->select("
        INSERT INTO public.personnel_employee
        (
            create_time,
            create_user,
            change_time,
            status,
            emp_code,
            first_name,
            last_name,
            is_admin,
            enable_payroll,
            deleted,
            is_active,
            app_status,
            gender,
            emp_type,
            app_role
        )
        VALUES 
        (
            now(),
            null,
            now(),
            0,
            3,
            'Fredy',
            'Cedeno',
            false,
            true,
            false,
            true,
            0,
            'M',
            1,
            1
        );
        ");

        $insert_att_atemploye = DB::connection('pgsqlBiometrico')->select("
        INSERT INTO public.att_attemployee
        (
            create_time,
            create_user,
            change_time,
            status,
            enable_attendance,
            enable_schedule,
            enable_overtime,
            enable_holiday,
            emp_id
        )
        VALUES 
        (
            now(),
            null,
            now(),
            0,
            true,
            true,
            true,
            true,
            5
        );
        ");

        
        return $insert;
    }

    public function get_biometricoB()
    {
        //$data = DB::connection('pgsqlBiometrico')->select("SELECT id, username, password, update_time, first_name, last_name, emp_pin, email, tele_phone, auth_time_dept, login_id, login_type, login_count, is_staff, is_active, is_superuser, is_public, can_manage_all_dept, del_flag, date_joined, last_login, session_key, login_ip, photo FROM public.auth_user; ");
        $insert = DB::connection('pgsqlBiometrico')->select("
            SELECT * FROM public.personnel_employee
        ");
        return $insert;
    }

    
    public function get_server()
    {
        //$data = DB::connection('pgsqlBiometrico')->select("SELECT id, username, password, update_time, first_name, last_name, emp_pin, email, tele_phone, auth_time_dept, login_id, login_type, login_count, is_staff, is_active, is_superuser, is_public, can_manage_all_dept, del_flag, date_joined, last_login, session_key, login_ip, photo FROM public.auth_user; ");
        $insert = DB::connection('sqlsrv')->select("
        SELECT 
        t.NAME AS TableName,
        s.Name AS SchemaName,
        p.rows AS RowCounts,
        SUM(a.total_pages) * 8 AS TotalSpaceKB, 
        CAST(ROUND(((SUM(a.total_pages) * 8) / 1024.00), 2) AS NUMERIC(36, 2)) AS TotalSpaceMB,
        SUM(a.used_pages) * 8 AS UsedSpaceKB, 
        CAST(ROUND(((SUM(a.used_pages) * 8) / 1024.00), 2) AS NUMERIC(36, 2)) AS UsedSpaceMB, 
        (SUM(a.total_pages) - SUM(a.used_pages)) * 8 AS UnusedSpaceKB,
        CAST(ROUND(((SUM(a.total_pages) - SUM(a.used_pages)) * 8) / 1024.00, 2) AS NUMERIC(36, 2)) AS UnusedSpaceMB
    FROM 
        sys.tables t
    INNER JOIN      
        sys.indexes i ON t.OBJECT_ID = i.object_id
    INNER JOIN 
        sys.partitions p ON i.object_id = p.OBJECT_ID AND i.index_id = p.index_id
    INNER JOIN 
        sys.allocation_units a ON p.partition_id = a.container_id
    LEFT OUTER JOIN 
        sys.schemas s ON t.schema_id = s.schema_id
    WHERE 
        t.NAME NOT LIKE 'dt%' 
        AND t.is_ms_shipped = 0
        AND i.OBJECT_ID > 255 
    GROUP BY 
        t.Name, s.Name, p.Rows
    ORDER BY 
        TotalSpaceMB desc
        ");

        
        return $insert;
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
