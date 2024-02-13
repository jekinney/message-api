<?php

namespace App\Queries\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

abstract class EloquentQueries extends Model implements Queries
{
    /**
     * Create a new resource
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        return $this->create($this->validate($request));
    }

    /**
     * Update a resource
     *
     * @return mixed
     */
    public function renew(Request $request)
    {
        $this->update($this->validate($request));

        return $this->fresh();
    }

    /**
     * Gather data for editing a resource
     *
     * @return mixed
     */
    public function edit()
    {
        return $this;
    }

    /**
     * Gather data to show or display a resource
     *
     * @return mixed
     */
    public function show()
    {
        return $this;
    }

    /**
     * A paginated list of a resource for a specific user
     *
     * @return mixed
     */
    public function userList(Request $request)
    {
        return $this->where('user_id', $request->user()->id)
            ->latest()
            ->paginate($this->amount($request));
    }

    /**
     * A paginated list for admin users.
     * Includes all resources
     *
     * @return mixed
     */
    public function adminList(Request $request)
    {
        return $this->withTrashed()
            ->latest()
            ->paginate($this->amount($request));
    }

    /**
     * A paginated public list of available resources
     *
     * @return mixed
     */
    public function publicList(Request $request)
    {
        return $this->latest()
            ->paginate($this->amount($request));
    }

    // Helper functions

    /**
     * Check request object for a amount
     * variable or return default
     *
     * @return mixed
     */
    public function amount(Request $request)
    {
        return $request->amount ?? 10;
    }

    /**
     * Validate incoming user input
     * and return validated data
     *
     * @return mixed
     */
    public function validate(Request $request)
    {
        // Get rule set array
        $rules = $request->method('post') ? $this->getStoreRules($request) : $this->getRenewRules($request);
        // Validate input
        $validator = Validator::make($request->all(), $rules);

        // Return only data that was valid and dump any extra data
        return $validator->validated();
    }

    /**
     * Getter to set up validation
     * rules to store new resource
     *
     * @return mixed
     */
    abstract protected function getStoreRules();

    /**
     * Getter to set up validation
     * rules to renew a resource
     *
     * @return mixed
     */
    abstract protected function getRenewRules();
}
