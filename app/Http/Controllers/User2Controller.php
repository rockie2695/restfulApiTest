<?php

namespace App\Http\Controllers;

use App\Models\User2;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

class User2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        try {
            $rules = [
                'email' => ['required', 'email', 'unique:user2s'],
                'password' => ['required', 'confirmed', 'string', 'min:8', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/', 'regex:/[@$!%*#?&]/'],
                'firstName' => ['required', 'string'],
                'lastName' => ['required', 'string'],
                'birthday' => ['required', 'date_format:Y-m-d', 'before:today'],
                'gender' => ['required', 'string', 'size:1'],
                'mobile' => ['required', 'string', 'size:8']
            ];
            $validatedData = $request->validate($rules);
            $validatedData['password'] = Hash::make($validatedData['password']);
            $user = User2::create($validatedData);
            if (isset($user)) {
                return response()->json(['status' => 'ok', 'user' => $user])->setEncodingOptions(JSON_UNESCAPED_UNICODE);
            } else {
                return response()->json(['err' => 'add fail']);
            }
        } catch (ValidationException $exception) {
            // 取得 laravel Validator 實例
            $validatorInstance = $exception->validator;
            // 取得錯誤資料
            $errorMessageData = $validatorInstance->getMessageBag();
            // 取得驗證錯誤訊息
            $errorMessages = $errorMessageData->getMessages();
            return response()->json($errorMessages);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User2  $user2
     * @return \Illuminate\Http\Response
     */
    public function show(User2 $user2)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User2  $user2
     * @return \Illuminate\Http\Response
     */
    public function edit(User2 $user2)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User2  $user2
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User2 $user2)
    {
        //
        /*
         try {
            $post = Post::findOrFail($id);
            $post->title = $request->title;
            $post->content = $request->content;
            $post->save();
        } catch (Throwable $e) {
            //更新失敗
            $data = ['post' => $post];
            return $this->makeJson(0, null, '更新文章失敗');
        }

        $data = ['post' => $post];
        return $this->makeJson(1, $data, '更新文章成功');
         */
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User2  $user2
     * @return \Illuminate\Http\Response
     */
    public function destroy(User2 $user2)
    {
        //
    }
}
