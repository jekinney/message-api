<?php

namespace App\Queries\Contracts;

use Illuminate\Http\Request;

interface Queries
{
    /**
     * Gather data for showing a resource
     *
     * @return void
     */
    public function show();

    /**
     * Gather data for editing a resource
     *
     * @return void
     */
    public function edit();

    /**
     * Store a new resource
     *
     * @return void
     */
    public function store(Request $request);

    /**
     * Update a resource
     *
     * @return void
     */
    public function renew(Request $request);

    /**
     * List of resources for a specific user
     *
     * @return void
     */
    public function userList(Request $request);

    /**
     * List of all resources for admins
     *
     * @return void
     */
    public function adminList(Request $request);

    /**
     * List of publicly available resources
     *
     * @return void
     */
    public function publicList(Request $request);
}
