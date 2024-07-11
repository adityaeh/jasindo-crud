<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private $userModel;

    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }

    public function showIndex(Request $request)
    {
        try {
            $perPage = $request->perPage ?? 10;
            $datas = $this->userModel->filter($request)->orderBy('id', 'desc')->paginate($perPage);

            if (!isset($datas)) {
                throw new Exception("Users data not found", 400);
            }
            return response()->json([
                'message' => 'Success',
                'code' => 200,
                'data' => $datas,
            ]);
        } catch (\Exception $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'code' => $th->getCode(),
            ]);
        }
    }

    // public function test(Request $request)
    // {
    //     $queryselect = [1, 2, 3, 4, 5];
    //     return response()->json(['code' => 200, 'message' => 'successss', 'data' => $queryselect]);
    // }

    // public function saveTable(Request $request)
    // {
    //     $user_data = new User();
    //     $user_data->name = $request->user_name;
    //     $user_data->email = $request->user_email;
    //     $user_data->password = 123456;
    //     $user_data->save();

    //     return back();
    // }

    public function getUser(Request $request, $id)
    {
        try {
            if (!isset($id)) {
                throw new Exception("Bad request", 400);
            }
            $result = $this->queryGetUser($id);
            if (!isset($result)) {
                throw new Exception("User not found", 404);
            }

            return response()->json([
                'message' => 'Success',
                'code' => 200,
                'data' => $result
            ]);
        } catch (\Exception $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'code' => $th->getCode(),
            ]);
        }
    }

    public function editTable(UserRequest $request, $id)
    {
        try {
            $request->validated();

            $datas = $this->queryGetUser($id);
            if (!isset($datas)) {
                throw new Exception("User not found", 404);
            }

            if (!$datas->update($request->all())) {
                /// insert log error
                throw new \Exception("Failed on saved", 500);
            }

            return response()->json([
                'message' => 'User updated',
                'code' => 200,
                'data' => $datas
            ]);
        } catch (\Exception $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'code' => $th->getCode(),
            ]);
        }
    }

    public function create(UserRequest $request)
    {
        try {
            $request->validated();
            $payloads = $request->all();

            $datas = User::where(['email' => $payloads['email']])->first();
            if (isset($datas)) {
                throw new Exception("Email already exist", 400);
            }

            if (!User::create($payloads)) {
                /// insert log error
                throw new \Exception("Failed on saved", 500);
            }

            return response()->json([
                'message' => 'User created',
                'code' => 201
            ]);
        } catch (\Exception $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'code' => $th->getCode(),
            ]);
        }
    }

    public function deleteTable(Request $request, $id)
    {
        try {
            if (!isset($id)) {
                throw new Exception("Bad request", 400);
            }
            $result = $this->queryGetUser($id);
            if (!isset($result)) {
                throw new Exception("User not found", 404);
            }
            $deleteUser = User::where(['id' => $id])->delete();
            if ($deleteUser == false) {
                throw new Exception("Failed delete User", 500);
            }

            if (!$deleteUser) {
                throw new Exception("No deleted user", 404);
            }

            return response()->json([
                'message' => 'Success',
                'code' => 200,
                'data' => null
            ]);
        } catch (\Exception $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'code' => $th->getCode(),
            ]);
        }
    }

    private function queryGetUser(int $id)
    {
        try {
            return User::findOrFail($id);
        } catch (\Exception $th) {
            if ($th instanceof ModelNotFoundException) {
                throw new Exception("User not found", 404);
            }
            throw $th;
        }
    }
}
