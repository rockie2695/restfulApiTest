<?php

namespace App\Http\Controllers;

use App\Models\User2;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Throwable;

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
            //if (isset($user)) {
            return response($user, 201); //->json(['status' => 'ok', 'user' => ])->setEncodingOptions(JSON_UNESCAPED_UNICODE);
            //} else {
            //    return response(null, 500); //->json(['err' => 'add fail'])
            //}
        } catch (ValidationException $exception) {
            // 取得 laravel Validator 實例
            $validatorInstance = $exception->validator;
            // 取得錯誤資料
            $errorMessageData = $validatorInstance->getMessageBag();
            // 取得驗證錯誤訊息
            $errorMessages = $errorMessageData->getMessages();
            return response($errorMessages, 400);
        } catch (Throwable $e) {
            return response($e->getMessage(), 500);
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
    { //->ignore($user2->id, 'email')
        try {
            $rules = [
                'email' => ['email', 'unique:user2s,email,' . $request['id']], //unique:table,column,ignore_id
                'password' => ['confirmed', 'string', 'min:8', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/', 'regex:/[@$!%*#?&]/'],
                'firstName' => ['string'],
                'lastName' => ['string'],
                'birthday' => ['date_format:Y-m-d', 'before:today'],
                'gender' => ['string', 'size:1'],
                'mobile' => ['string', 'size:8']
            ];
            $validatedData = $request->validate($rules);
            if (isset($validatedData['password'])) {
                $validatedData['password'] = Hash::make($validatedData['password']);
            }
            $user2 = $user2->findOrFail($request['id'])->whereId($request['id'])->update($validatedData); //return 0 or affect row
            return response(['attect row' => $user2], 200);
        } catch (ValidationException $exception) {
            // 取得 laravel Validator 實例
            $validatorInstance = $exception->validator;
            // 取得錯誤資料
            $errorMessageData = $validatorInstance->getMessageBag();
            // 取得驗證錯誤訊息
            $errorMessages = $errorMessageData->getMessages();
            return response($errorMessages, 400);
        } catch (Throwable $e) {
            return response($e->getMessage(), 500);
        }
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
