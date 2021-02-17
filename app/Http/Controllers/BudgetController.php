<?php

namespace App\Http\Controllers;

use App\Budget;
use App\Http\Requests\StoreBudget;
use App\Http\Resources\BudgetResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class BudgetController
 *
 * @package App\Http\Controllers
 */
class BudgetController extends Controller
{
    /**
     * It returns a list of budget requests
     *
     * @OA\Get(
     *     path="/api/budget/list/{email}/",
     *     tags={"Budgets"},
     *     @OA\Response(response="200", description="A Budget list of resources"),
     *     @OA\Response(response="422", description="A list of errors"),
     *     @OA\Parameter(
     *         name="email",
     *         in="path",
     *         description="Email of an User",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *      @OA\Parameter(
     *          name="page",
     *          in="query",
     *          description="Number of page",
     *          required=false,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     * )
     *
     * @param Request     $request The request
     * @param string|null $email   Email to filter requests from
     *
     * @return JsonResponse
     */
    public function show(Request $request, string $email = null)
    {
        $budget = Budget::with(['category', 'user']);

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $budget->whereHas(
                'user',
                function ($q) use ($email) {
                    return $q->whereEmail($email);
                }
            );
        }

        return response()->json(
            BudgetResource::collection(
                $budget->paginate(BudgetResource::ITEMS_PER_PAGE)
            )
        );
    }

    /**
     * Creates a new budget request resource
     *
     * @OA\Post(
     *     path="/api/budget/create",
     *     tags={"Budgets"},
     *     @OA\Response(response="200", description="A Budget resource"),
     *     @OA\Response(response="422", description="A list of errors"),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 required={"description", "email", "phone", "address"},
     *                 @OA\Property(
     *                      property="title",
     *                      type="string",
     *                      description="Title of the budget request"
     *                 ),
     *                 @OA\Property(
     *                      property="category_id",
     *                      type="integer",
     *                      description="Category of the budget request"
     *                 ),
     *                 @OA\Property(
     *                      property="description",
     *                      type="string",
     *                      description="Description of the budget request"
     *                 ),
     *                 @OA\Property(
     *                      property="email",
     *                      type="string",
     *                      description="Email of the user"
     *                 ),
     *                 @OA\Property(
     *                      property="phone",
     *                      type="string",
     *                      description="Phone number of the user"
     *                 ),
     *                 @OA\Property(
     *                      property="address",
     *                      type="string",
     *                      description="Address of user"
     *                 )
     *             )
     *         )
     *     )
     * )
     *
     * @param StoreBudget $request The request
     * @return JsonResponse
     */
    public function create(StoreBudget $request)
    {
        $budget = Budget::create($request->all());

        return response()->json(BudgetResource::make($budget));
    }

    /**
     * Updates the data of the budget request
     *
     * @OA\Put(
     *     path="/api/budget/edit/{id}",
     *     tags={"Budgets"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Budget ID",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(response="200", description="A Budget resource"),
     *     @OA\Response(response="422", description="A list of errors"),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      property="title",
     *                      type="string",
     *                      description="Title of the budget request"
     *                 ),
     *                 @OA\Property(
     *                      property="category",
     *                      type="integer",
     *                      description="Category of the budget request"
     *                 ),
     *                 @OA\Property(
     *                      property="description",
     *                      type="string",
     *                      description="Description of the budget request"
     *                 ),
     *             )
     *         )
     *     )
     * )
     *
     * @param  Request $request
     * @param  int     $id
     * @return JsonResponse
     */
    public function edit(Request $request, int $id)
    {
        $budget = Budget::with(['user', 'category'])->findOrFail($id);

        $budget->edit();

        return response()->json(BudgetResource::make($budget));
    }

    /**
     * Changes the status of the budget request resource
     *
     * @OA\Post(
     *     path="/api/budget/publish/{id}",
     *     tags={"Budgets"},
     *     @OA\Response(response="200", description="A Budget resource"),
     *     @OA\Response(response="422", description="A list of errors"),
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Budget ID",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     * )
     *
     * @param Request $request
     * @param int     $id
     * @return JsonResponse
     */
    public function publish(Request $request, int $id)
    {
        $budget = Budget::with(['category', 'user'])->findOrFail($id);

        $budget->publish();

        return response()->json(BudgetResource::make($budget));
    }

    /**
     * Changes the status of the budget request resource
     *
     * @OA\Post(
     *     path="/api/budget/discard/{id}",
     *     tags={"Budgets"},
     *     @OA\Response(response="200", description="A Budget resource"),
     *     @OA\Response(response="422", description="A list of errors"),
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Budget ID",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     * )
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function discard(Request $request, int $id)
    {
        $budget = Budget::with(['category', 'user'])->findOrFail($id);

        $budget->discard();

        return response()->json(BudgetResource::make($budget));
    }
}
