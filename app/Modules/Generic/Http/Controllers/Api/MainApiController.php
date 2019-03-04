<?php

namespace App\Modules\Generic\Http\Controllers\Api;



class MainApiController extends GenericApiController
{
    public function __construct()
    {
        parent::__construct();
    }








    public function main()
    {
        return $this->successResponse();
    }

    /**
     * @SWG\Post(
     *     method="POST",
     *   path="/api/post-example",
     *   summary="Order Details for saidalany",
     *   operationId="Order Details as pharmacy",
     *   @SWG\Parameter(
     *     name="order_id",
     *     in="formData",
     *     required=true,
     *     @SWG\Schema(type="string"),
     *     type="string"
     *   ),
     *    @SWG\Parameter(
     *     name="device_type",
     *     in="formData",
     *     required=true,
     *     @SWG\Schema(type="string"),
     *     type="string"
     *   ),
     *   @SWG\Response(response=200, description="access token"),
     *   @SWG\Response(response=406, description="not acceptable"),
     *   @SWG\Response(response=500, description="internal server error")
     * ),
     */
    public function SwaggerPostExample()
    {
       return $this->successResponse();

    }

    /**
     * @SWG\Get(
     *   path="/api/",
     *   summary="Example For Api Documentation",
     *   operationId="main",
     *   @SWG\Parameter(
     *     name="customerId",
     *     in="path",
     *     description="Target customer.",
     *     required=true,
     *     type="integer"
     *   ),
     *   @SWG\Parameter(
     *     name="filter",
     *     in="query",
     *     description="Filter results based on query string value.",
     *     required=false,
     *     enum={"active", "expired", "scheduled"},
     *     type="string"
     *   ),
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=406, description="not acceptable"),
     *   @SWG\Response(response=500, description="internal server error")
     * )
     *
     */
    public function SwaggerGetExample()
    {
       return $this->successResponse();
    }

}
