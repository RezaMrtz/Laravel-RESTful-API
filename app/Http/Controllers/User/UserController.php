<?php

namespace App\Http\Controllers\User;

use App\User;
use App\Mail\UserCreated;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateUser;
use Illuminate\Support\Facades\Mail;
use App\Transformers\UserTransformer;
use App\Http\Controllers\ApiController;
use App\Http\Requests\StoreUser;

class UserController extends ApiController
{

    public function __construct()
    {
        $this->middleware('client.credentials')->only(['store','resend']);
        $this->middleware('auth:api')->except(['store','verify','update']);
        $this->middleware('transform.input:' . UserTransformer::class)->only(['store','update']);
        $this->middleware('scope:manage-account')->only('show');
        $this->middleware('can:view,user')->only('show');
        $this->middleware('can:update,user')->only('update');
        $this->middleware('can:delete,user')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $this->allowedAdminAction();

        $users = User::all();

        return $this->showAll($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUser $request)
    {

        $validate = $request->validate();

        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        $data['verified'] = User::UNVERIFIED_USER;
        $data['verification_token'] = User::generateVerificationCode();
        $data['admin'] = User::REGULAR_USER;

        $user = User::create($data);

        return $this->showOne($user, 201);;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $this->showOne($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUser $request, $id)
    {
        $user = User::findOrFail($id);

        //TODO: Authorizing Form Requests Possibility
        $validate = $request->validate();

        if ($request->has('name')) {
            $user->name = $request->name;
        }

        if ($request->has('email') && $user->email != $request->email) {
            $user->verified = User::UNVERIFIED_USER;
            $user->verification_token = User::generateVerificationCode();
            $user->email = $request->email;
        }

        if ($request->has('password')) {
            $user->password = $request->bcrypt($request->password);
        }

        if ($request->has('admin')) {

            $this->allowedAdminAction();

            if (!$user->isVerified()) {
                return $this->errorResponse('Sorry! Only verified users can modify the admin field', 409);
            }

            $user->admin = $request->admin;
        }

        if ($user->isClean()) {

            return $this->errorResponse('Sorry! You need to specify a different value to update!', 422);
        }

        $user->save();

        return $this->showOne($user);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(['data' => $user], 200);
    }

    /* Verification Message */
    public function verify($token)
    {
        $user = User::where('verification_token', $token)->firstOrFail();

        $user->verified = User::VERIFIED_USER;
        $user->verification_token = null;

        $user->save();

        return $this->showMessage('The account has been verified successfully');
    }

    /* Resend Email Message */
    public function resend(User $user)
    {
        if ($user->isVerified()) {
            return $this->errorResponse('This user is already verified', 409);
        };
        retry(5, function () use ($user) {
            Mail::to($user)->send(new UserCreated($user));
        }, 100);

        return $this->showMessage('The verification email has been resend');
    }
}
