<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * The user service instance.
     *
     * @var UserService
     */
    protected $userService;

    /**
     * Create a new controller instance.
     *
     * @param UserService $userService
     * @return void
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of users.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $users = $this->userService->getAllUsers();

        return response()->json([
            'success' => true,
            'data' => $users
        ]);
    }

    /**
     * Store a newly created user.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'dob' => 'nullable|date',
            'phone_nb' => 'nullable|string|max:20',
            'user_type' => 'required|integer|in:0,1,2',
            'department_id' => 'nullable|integer|exists:departments,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = $this->userService->createUser($request->all());

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User with this email already exists.'
            ], Response::HTTP_CONFLICT);
        }

        return response()->json([
            'success' => true,
            'data' => $user,
            'message' => 'User created successfully.'
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified user.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $user = $this->userService->getUserById((int)$id);

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found.'
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->json([
                'success' => true,
                'data' => $user
            ]);
        } catch (\TypeError $e) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid user ID format.'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Update the specified user.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'sometimes|required|email',
                'password' => 'sometimes|required|min:6',
                'first_name' => 'sometimes|required|string|max:50',
                'last_name' => 'sometimes|required|string|max:50',
                'dob' => 'nullable|date',
                'phone_nb' => 'nullable|string|max:20',
                'user_type' => 'sometimes|required|integer|in:0,1,2',
                'department_id' => 'nullable|integer|exists:departments,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $user = $this->userService->updateUser((int)$id, $request->all());

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found or email already in use.'
                ], Response::HTTP_NOT_FOUND);
            }

            // Load the department relationship for the response
            $user->load('department');

            return response()->json([
                'success' => true,
                'data' => $user,
                'message' => 'User updated successfully.'
            ]);
        } catch (\TypeError $e) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid user ID format.'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified user.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $result = $this->userService->deleteUser((int)$id);

            if (!$result) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found.'
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->json([
                'success' => true,
                'message' => 'User deleted successfully.'
            ]);
        } catch (\TypeError $e) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid user ID format.'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
